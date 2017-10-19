<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wechat extends Model
{
	use SoftDeletes;
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    //指定表名
    protected $table = 'wechat';
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
    
    public function student()
    {
        return $this->belongsTo('App\Student' , 'sid');
    }
    
    //对时间戳不作处理
//  protected function asDateTime($val)
//  {
//  	return $val;
//  }
//  
}