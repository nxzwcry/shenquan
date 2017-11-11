<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use App\Student;
use App\Classes;

class AdminhomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
  	    $res = $this -> getstudentlist();
  	    $classes = Classes::orderby( 'name' )
            -> get();;
        return view('admin.home' , [ 'stops' => $res['stops'] , 'classs' => $res['classs'] , 'one2ones' => $res['one2ones'] , 'classes' => $classes ]);
    }


    /**
     * @return int
     */
    public function getstudentlist()
    {
        $allsids = collect( array_column ( Student::all('id') -> toArray() , 'id' ) );
        $classes = Classes::all();
        $classsids = collect();
        foreach ( $classes as $class )
        {
            $classsids = $classsids -> merge( $class -> sids() );
        }
        $classsids = $classsids -> unique();
        $lessonsids = Lesson::where( 'conduct' , '0' ) -> groupBy('sid') -> get(['sid']) ->toArray();
        $lessonsids = collect( array_column( $lessonsids , 'sid' ) ) -> unique();

        $lessonnoclasssid = $lessonsids -> diff( $classsids );
        $nolessonsid = $allsids -> diff( $lessonsids );

        return [ 'stops' => Student::orderby( 'ename' ) -> find($nolessonsid), 'classs' => Student::orderby( 'ename' ) -> find($classsids) , 'one2ones' => Student::orderby( 'ename' ) -> find($lessonnoclasssid) ];
    }
}
