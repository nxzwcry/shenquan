<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Log;

class Course extends Model
{
	use SoftDeletes;
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    //指定表名
    protected $table = 'courses';
    //指定关键字
    protected $primaryKey = 'id';
    //自动维护时间戳
    public $timestamps = true;
    
    protected $dates = ['deleted_at'];
    //不允许批量赋值的字段
    protected $guarded = [ 'id' , 'created_at' , 'updated_at' ];
    
    protected function getDateFormat()
    {
    	return time();
    }
    
    public function setSdateAttribute($value)
    {
        $this->attributes['sdate'] = $value -> getTimestamp() ;
    }
    
    public function getSdateAttribute($value)
    {
        return Carbon::createFromTimeStamp($value);
    }

    //edate的时间设定为该日期的最大值
    public function setEdateAttribute($value)
    {
    	if ( $value == null ) {$this->attributes['edate'] = null;}
        else 
        {$this->attributes['edate'] = $value -> getTimestamp() ;}
    }
    
    public function getEdateAttribute($value)
    {
    	if ( $value == null ) { return null; }
        return Carbon::createFromTimeStamp($value);
    }
    
    public function student()
    {
        return $this->belongsTo('App\Student' , 'sid');
    }

    public function classes()
    {
        return $this->belongsTo('App\Classes' , 'class_id');
    }
    
    public function lessons()
    {
    	return $this->hasMany('App\Lesson', 'courseid');
    }

    public function nextlessons()
    {
        return $this-> lessons() -> where('conduct' , 0 );
    }

    public function cteacher()
    {
    	return $this->belongsTo('App\Cteacher' , 'cteacher_id');
    }  
    
    public function place()
    {
    	return $this->belongsTo('App\Place' , 'place_id');
    }

    public function courseware()
    {
        return $this->belongsTo('App\Courseware' , 'cwid');
    }

    public function stop()
    {
        $this -> edate = Carbon::now() -> subSecond();
        $this -> save();
        return $this -> nextlessons() ->delete();
    }

    public function copytostudent($sid) //将该节课程复制给学生
    {
        $cinfo = $this -> toArray();
        $cinfo['sid'] = $sid;
        return Course::create($cinfo);
    }

    public function sameclasscourse()
    {
        return Course::where('class_id' , $this -> class_id)
            -> where('dow' , $this -> dow)
            -> where('sdate' , $this -> sdate)
            -> where('stime' , $this -> stime)
            -> get();
    }

    public function CreateLessons()
    {
        //计算开课日期后的第一节课的日期
        $next = clone $this -> sdate;
//        Log::info( 'next' . $next -> dayOfWeek . 'dow' . $class -> dow );

        $next = $this -> NextDay($next);
        $nextflag = 0;
        if ( $this -> edate == null || $this -> edate -> gt( Carbon::now() ) )
        {
            $edate = Carbon::now();
            $nextflag = 1;
//            $this -> CreateNextLesson();
        }
        else {
            $edate = $this->edate;
        }

        $i = 0;
        while ( $next -> lte( $edate ) )
        {
            $lesson = $this -> CreateLessonFromDate( $next -> toDateString() );
            $next -> addDays(7);
            $i++;
            if ( $lesson -> conduct == 0)
            {
                $nextflag++;
                break;
            }
        }
        if ( $nextflag == 1 )
        {
            $this -> CreateNextLesson();
        }

        return 1;
    }

    protected function NextDay(Carbon $start) //计算从$start开始的下一个上课日，包括$start
    {
        if ( $start -> dayOfWeek <= $this -> dow )
        {
            $start -> addDays( $this -> dow - $start -> dayOfWeek );
        }
        else
        {
            $start -> addDays( $this -> dow - $start -> dayOfWeek + 7 );
        }
        return $start;
    }

    public function CreateNextLesson() //创建本系列课程的下一节单节课程
    {
        $lesson = $this -> lessons() -> where('conduct' , 0) -> first();
//        Log::info($lesson);
        if ( !$lesson )
        {
            Log::info('开始创建下一节课程');
            $next = Carbon::now()->addDays(1);
            $nxet = $this -> NextDay($next);

            if ( $this -> edate == null || $this -> edate -> gt( $nxet ) )
            {
                return $this -> CreateLessonFromDate($next -> toDateString());
            }
        }
        return 0;
    }

    public function CreateLessonFromDate($date)
    {
        $lessoninfo = $this -> toArray();
        $cw = $this -> courseware() ->first();
        if ( $cw )
        {
            $lessoninfo['cwurl'] = $cw -> url;
        }
        $lessoninfo['courseid'] = $lessoninfo['id'];
        $lessoninfo['date'] = $date;
        unset($lessoninfo['id']);
        unset($lessoninfo['dow']);
        unset($lessoninfo['sdate']);
        unset($lessoninfo['edate']);
        unset($lessoninfo['cwid']);
        unset($lessoninfo['updated_at']);
        unset($lessoninfo['created_at']);
//        unset($lessoninfo['courseware']);
        $lesson = Lesson::create($lessoninfo);
        $lesson -> ChackConduct();
        return $lesson;
    }
    //对时间戳不作处理
//  protected function asDateTime($val)
//  {
//  	return $val;
//  }
//  
}