<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use PhpParser\ErrorHandler\Collecting;

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

    public function getoldlessons()
    {
        $lessons = $this -> lessons()
            -> where('conduct' , 1 )
            -> get();
        return $lessons;
    }

    public function havenewlessons()
    {
        if ( $this -> lessons() -> where( 'conduct' , '0' ) ->first() )
            return true;
        else
            return false;
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

    public function classes()
    {
        return $this->belongsTo('App\Classes' , 'class_id' , 'id');
    }

    public function getfuxi()
    {
    	$after = 1;
    	
    	$newlessons = $this -> lessons()
			-> where('conduct' , 0 )
    		-> get();
    	foreach ( $newlessons as $newlesson )
    	{
    		if ( $newlesson -> type == 'f' )
    		{
    			$after = 0;
    			break;
    		}
    	}
    	
    	$fuxi = 0;
    	
    	if ( $after )
    	{
	    	$lessons = $this -> lessons()
				-> where('conduct' , 1 )
				-> orderby('date' , 'desc' )
				-> orderby('etime' , 'desc' )
				-> with('cteacher')
	    		-> get();
	    	if ( $this -> recharges() -> sum('lessons1') - $lessons -> sum('cost1') > 0 )
			{
				foreach ( $lessons as $lesson )
				{
					if ( $lesson -> type == 'w' )
					{
						$fuxi++;
					}
					elseif ( ( $lesson -> type == 'f' ) || ( $fuxi > 5 )  )
					{
						break;
					}
				}
			}
		}
		return $fuxi;
    }

    
    public function getjingpin()
    {
    	
    	$after = 1;
    	
    	$newlessons = $this -> lessons()
			-> where('conduct' , 0 )
    		-> get();
    	foreach ( $newlessons as $newlesson )
    	{
    		if ( $newlesson -> type == 'j' )
    		{
    			$after = 0;
    			break;
    		}
    	}
    	
    	$jingpin = 0;
    	
    	if ( $after )
	    {
	    	$lessons = $this -> lessons()
				-> where('conduct' , 1 )
				-> orderby('date' , 'desc' )
				-> orderby('etime' , 'desc' )
				-> with('cteacher')
	    		-> get();
	    	if ( $this -> recharges() -> sum('lessons2') - $lessons -> sum('cost2') > 0 )
			{
				foreach ( $lessons as $lesson )
				{
					if ( $lesson -> type == 'w' )
					{
						$jingpin++;
					}
					elseif ( ( $lesson -> type == 'j' ) || ( $jingpin > 5 )  )
					{
						break;
					}
				}
			}
		}
		return $jingpin;
    }
    
    
    public function getbalance()
    {
    	$lessons = $this -> lessons()
			-> where('conduct' , 1 )
    		-> get();
    	$recharges = $this -> recharges;
    	
    	// 固定课程信息
		$courses = $this -> courses()
			-> where(function($query){
				$query -> where( 'edate' , null )
				-> orwhere( 'edate' , '>=' , Carbon::now() -> timestamp );
			})
    		-> get();
    		if ( $courses -> sum('cost') > 0 )
    		{    			
				return ceil( ( $recharges -> sum('lessons') - $lessons -> sum('cost') )/( $courses -> sum('cost') ) ) ;
    		}
    		else{
    			return 10;
    		}
    }

    //处理添加固定课程请求(不添加关联单节课程)
    public function createcourse($classinfo)
    {
        $classinfo['sid'] = $this -> id;
        $classinfo['sdate'] = Carbon::parse($classinfo['sdate'] . ' 0:00:00');
        if ( $classinfo['edate'] <> null )
        {
            $classinfo['edate'] = Carbon::parse($classinfo['edate'] . ' 23:59:59'); //edate的时间设定为该日期的最大值
        }

        return Course::create($classinfo);
    }
    
    //对时间戳不作处理
//  protected function asDateTime($val)
//  {
//  	return $val;
//  }
//  
}