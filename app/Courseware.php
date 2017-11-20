<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Courseware extends Model
{
	use SoftDeletes;
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    //指定表名
    protected $table = 'coursewares';
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

    public function course()
    {
        return $this->hasMany('App\Course' , 'cwid');
    }
        
    //对时间戳不作处理
//  protected function asDateTime($val)
//  {
//  	return $val;
//  }
//  
}