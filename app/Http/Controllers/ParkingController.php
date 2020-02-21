<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ParkingController extends Controller
{
    function index() {
    	$type = "web";
    	$data = DB::table('services')
    	        ->join('categories','services.category_id','=','categories.id')
    	        ->select(DB::raw('services.*'))
    	        ->where('categories.alias','parking')
    	        ->get();
    	return view('parking/index', compact('type','data'));
    }
}
