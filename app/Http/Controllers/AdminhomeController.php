<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class AdminhomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$students = Student::where('valid' , 1)
    		-> orderby('created_at' , 'DESC')
    		-> get();
//  	dd($students);
        return view('admin.home' , ['students' => $students]);
    }
}
