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
        return view('admin.home' , [ 'allstudents' => Student::orderby( 'ename' ) -> get() , 'classs' => $res['classs'] , 'one2ones' => $res['one2ones'] , 'classes' => $classes ]);
    }


    /**
     * @return int
     */
    public function getstudentlist()
    {
        $classs = Student::where( 'class_id' , '>' , '0' ) -> orderby( 'ename' ) -> get();
        $one2ones = Student::where( 'class_id' , '0' ) -> orderby( 'ename' ) -> get();

        return [ 'classs' => $classs , 'one2ones' => $one2ones ];
    }
}
