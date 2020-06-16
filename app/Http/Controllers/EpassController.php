<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class EpassController extends Controller
{
    function index() {
    	return view('epass/index');
    }
    function book_slot(Request $request) {
    	$date = $request['date'];
    	$time = $request['time'];
    	$date = date("Y-m-d H:i:s");
        $db = DB::table('book_slot')
        ->insert(['date' => $date, 'time' => $time, 'userid' => Auth::user()->id,'created_at' => $date, 'updated_at' => $date]);
    	return redirect()->back()->withInput()->with('status','Slot booked successfully!');

    }
}
