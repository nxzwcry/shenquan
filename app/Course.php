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
    
    //对时间戳不作处理
//  protected function asDateTime($val)
//  {
//  	return $val;
//  }
//  
}