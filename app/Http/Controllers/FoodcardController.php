<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
class FoodcardController extends Controller
{
    function index() {
    	 $user_id = Auth::user()->id;
       $topup = DB::table('wall_history')->where('user_id',$user_id)->where('payment_method','food_card')->limit(3)->orderBy('id', 'desc')->get();
       return view('food_card/index',compact('topup'));
    }
    function view_all() {
    	$user_id = Auth::user()->id;
      $topup = DB::table('wall_history')->where('user_id',$user_id)->where('payment_method','food_card')->orderBy('id', 'desc')->get();
      return view('food_card/viewall',compact('topup'));
    }
}
