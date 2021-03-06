<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Lesson extends Model
{
	use SoftDeletes;
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    //指定表名
    protected $table = 'lessons';
    //指定关键字
    protected $primaryKey = 'id';
    //自动维护时间戳
    public $timestamps = true;
    
    protected $dates = ['deleted_at'];
    
    //不允许批量赋值的字段
    protected $guarded = [ 'id' , 'created_at' , 'updated_at' ];

    protected $events = [
        'created' => UserSaved::class
    ];
    
    protected function getDateFormat()
    {
    	return time();
    }
    
    public function student()
    {
        return $this->belongsTo('App\Student' , 'sid');
    }
    
    public function course()
    {
        return $this->belongsTo('App\Course' , 'courseid');
    }
    
    public function cteacher()
    {
    	return $this->belongsTo('App\Cteacher' , 'cteacher_id');
    }  
    
    public function place()
    {
    	return $this->belongsTo('App\Place' , 'place_id');
    }

    public function classes()
    {
        return $this->belongsTo('App\Classes' , 'class_id');
    }


    public function copytostudent($sid) //将该节课程复制给学生
    {
        $linfo = $this -> toArray();
        $linfo['sid'] = $sid;
        return Lesson::create($linfo);
    }

    public function sameclasslesson()
    {
        return Lesson::where('class_id' , $this -> class_id)
                    -> where('date' , $this -> date)
                    -> where('stime' , $this -> stime)
                    -> get();
    }

    //课程结束时间
    public function GetEtime()
    {
        return Carbon::parse( $this -> date . ' ' . $this -> etime );
    }

    //如果之后加入事件的话利用事件实现
    public function ChackConduct()
    {
        if ( Carbon::now() -> gte( $this -> GetEtime() ) )
        {
            $this -> conduct = 1;
            $this -> save();
            $course = $this -> course;
            if( $course )
            {
                $course -> CreateNextLesson();
            }
        }
        return $this -> conduct;
    }

    //对时间戳不作处理
//  protected function asDateTime($val)
//  {
//  	return $val;
//  }
//  
}