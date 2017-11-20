<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Classes extends Model
{
	use SoftDeletes;
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    //指定表名
    protected $table = 'classes';
    //指定关键字
    protected $primaryKey = 'id';
    //自动维护时间戳
    public $timestamps = true;
    
    //不允许批量赋值的字段
    protected $guarded = [ 'id' , 'created_at' , 'updated_at' ];
    
    protected $dates = ['deleted_at'];
    
    protected function getDateFormat()
    {
    	return time();
    }
    
    public function courses()
    {
        return $this->hasMany('App\Course' ,'class_id');
    }
    
    public function lessons()
    {
        return $this->hasMany('App\Lesson' ,'class_id');
    }

    public function students()
    {
        return $this->hasMany('App\Student' ,'class_id');
    }

    public function getcourse() //获取该班级的一节课程用于显示地点和名称
    {
        $course = $this -> courses() ->
            where(function($query){
            $query -> where( 'edate' , null )
                -> orwhere( 'edate' , '>=' , Carbon::now() -> timestamp );
        }) -> first();
        if ( $course )
        {
            return  $course;
        }
        else
        {
            return null;
        }

    }

    public function getcourses() //获取该班级还在继续上的课程
    {
        $courses = $this -> courses()
            -> where(function($query){
                $query -> where( 'edate' , null )
                    -> orwhere( 'edate' , '>=' , Carbon::now() -> timestamp );
            })
            -> orderby('dow')
            -> get();
        $courses = $courses -> groupBy(function ($item, $key) {
            return $item['dow'].$item['stime'].$item['sdate'];
        } ); //分组要求班课一天不能上一节以上

        $res = collect();
        foreach ( $courses as $course )
        {
            $res -> push( $course->first() );
        }
        return $res;
    }

    public function getscourses($sid) //获取该学生在班级里的还在继续上的课程
    {
        $courses = $this -> courses()
            -> where('sid' , $sid )
            -> where(function($query){
                $query -> where( 'edate' , null )
                    -> orwhere( 'edate' , '>=' , Carbon::now() -> timestamp );
            }) -> get();
        return $courses;
    }

    public function getlessons($sid) //获取该学生在班级里的还在未上单节课
    {
        $lessons = $this -> lessons()
            -> where('sid' , $sid )
            -> where('conduct' , 0 ) -> get();
        return $lessons;
    }

    public function getoldcourses() //获取该班级已经结束的课程
    {
        $courses = $this -> courses()
            -> where( 'edate' , '<' , Carbon::now() -> timestamp )
            -> orderby('dow')
            -> get();
        $courses = $courses -> groupBy(function ($item, $key) {
            return $item['dow'].$item['stime'].$item['sdate'];
        }  ); //分组要求班课一天不能上一节以上

        $res = collect();
        foreach ( $courses as $course )
        {
            $res -> push( $course->first() );
        }
        return $res;
    }

    public function getnextlessons() //获取该班级的下节课程（复数）
    {
        $lessons = $this -> lessons()
            -> where('conduct' , 0 )
            -> orderby('date' )
            -> orderby('stime' )
            -> get();
        $lessons = $lessons -> groupBy(function ($item, $key) {
            return $item['date'].$item['stime'];
        }  ); //分组要求班课一天不能上一节以上

        $res = collect();
        foreach ( $lessons as $lesson )
        {
            $res -> push( $lesson->first() );
        }
//        $lessons = Lesson::where( 'class_id' , $this -> id )
//            -> groupBy('date' , 'name')
//            -> get(['name','date']);
        return $res;
    }

    public function getoldlessons() //获取该班级已经完成的单节课程
    {
        $lessons = $this -> lessons()
            -> where('conduct' , 1 )
            -> orderby('date' , 'desc' )
            -> orderby('etime' , 'desc' )
            -> get();
        $lessons = $lessons -> groupBy(function ($item, $key) {
            return $item['date'].$item['stime'];
        } ); //分组要求班课一天不能上一节以上
//        dd($lessons);
        $res = collect();
        foreach ( $lessons as $lesson )
        {
            $res -> push( $lesson->first() );
        }
        return $res;
    }

    // 添加学生
    public function addstudent( $sid )
    {
        $student = Student::find( $sid );
        if ( $student -> classes ) //如果学生在别的班级里，就删除他在别的班级里的课程
        {
            $student -> classes -> deletestudent($sid);
        }

        $student -> class_id = $this -> id;
        $student -> save(); //将学生加入班级

        //给加入学生添加目前班级的新课（正式）
        $courses = $this -> getcourses();
        foreach( $courses as $course )
        {
            $course -> copytostudent($sid);
        }
        $lessons = $this -> getnextlessons();
        foreach( $lessons as $lesson )
        {
            $lesson -> copytostudent($sid);
        }
        //将学生正在上的课程归入班课（正式删去）
//        $student -> lessons() -> update(['class_id' => $cid]); //正式删去
//        $student -> courses() -> update(['class_id' => $cid]); //正式删去
        return true;
    }

    //删除学生
    public function deletestudent( $sid )
    {
        $student = $this -> students() -> where('id' , $sid) -> first();
        if ( $student )
        {
            $courses = $this -> getscourses($sid);
            foreach ($courses as $course)
            {
                $course -> stop();
            }
            $lessons = $this -> getlessons($sid);
            foreach ($lessons as $lesson)
            {
                $lesson -> delete();
            }
            $student -> class_id = 0;
            $student -> save(); //将学生从班级删去
            return true;
        }
    }

    //对时间戳不作处理
//  protected function asDateTime($val)
//  {
//  	return $val;
//  }
//  
}