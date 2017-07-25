<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Class extends Model
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    //指定表名
    protected $table = 'class';
    //指定关键字
    protected $primaryKey = 'id';
    //自动维护时间戳
    public $timestamps = true;
    
    //允许批量赋值的字段
    protected $fillable = ['sid','tname', 'dow' , 'stime' , 'etime' , 'cid' , 'mid'];
    
    protected function getDateFormat()
    {
    	return time();
    }
    
    //对时间戳不作处理
//  protected function asDateTime($val)
//  {
//  	return $val;
//  }
//  
}