<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

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
    //对时间戳不作处理
//  protected function asDateTime($val)
//  {
//  	return $val;
//  }
//  
}