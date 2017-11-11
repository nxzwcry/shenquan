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

    public function sids()
    {
        $sids = $this -> lessons() -> where( 'conduct' , '0' ) -> groupBy('sid') -> get(['sid']) ->toArray();
//        $studens = Student::find($sids);
        return  array_column($sids, 'sid');
    }

    public function students()
    {
        return  Student::find( $this -> sids() );
    }

    public function getcourse()
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

    
    //对时间戳不作处理
//  protected function asDateTime($val)
//  {
//  	return $val;
//  }
//  
}