<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Student extends Model
{
	use SoftDeletes;
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    //指定表名
    protected $table = 'students';
    //指定关键字
    protected $primaryKey = 'id';
    //自动维护时间戳
    public $timestamps = true;
    
    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = $value -> getTimestamp() ;
    }
    
    public function getBirthdayAttribute($value)
    {
        return Carbon::createFromTimeStamp($value);
    }
    
    // 调整为日期属性
//  protected $dates = ['birthday'];
    
    protected $dates = ['deleted_at'];
    
    //不允许批量赋值的字段
    protected $guarded = [ 'id' , 'created_at' , 'updated_at' ];
    
    protected function getDateFormat()
    {
    	return time();
    }
    
    public function lessons()
    {
    	return $this->hasMany('App\Lesson', 'sid');
    }    
    
    public function courses()
    {
    	return $this->hasMany('App\Course', 'sid');
    }   
     
    public function recharges()
    {
    	return $this->hasMany('App\Recharge', 'sid');
    }
    
    public function wechats()
    {
    	return $this->hasMany('App\Wechat', 'sid');
    }
    
    
    //对时间戳不作处理
//  protected function asDateTime($val)
//  {
//  	return $val;
//  }
//  
}