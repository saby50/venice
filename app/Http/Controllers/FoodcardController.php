<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Crypt;
use Helper;
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
    function refund(Request $request) {
    	$user_id = $request['user_id'];
    	$food_card = Crypt::decrypt(Auth::user()->food_card);
    	$request_id = "GV/FC/RE/".Helper::generatePIN(6);
    	$date = date("Y-m-d H:i:s");
    	$data = array('final_amount' => 0, 'mainamount' => 0, 'extra' => 0, 'user_id' => $user_id, 'order_id' => $request_id, 'expiry' => '', 'identifier' => 'refund', 'unit_id' => 0, 'trans_id' => '','payment_method' => 'food_card', 'platform' => 'android', 'refund' => 'yes', 'refund_amount' => $food_card,'created_at' => $date, 'updated_at' => $date);
    	$db = DB::table('food_card_refund_requests')->insert($data);
    	if ($db) {
    		
    		$content = "Your request for Food Card refund (Rs. ".$food_card.") is generated. Request ID:  ".$request_id.". Install the iPhone/Android App: https://l.ead.me/29Ev";
             Helper::send_otp(Auth::user()->phone,$content);
             return redirect('food_card/status');
    	}
    }
    function status() {
    	return view('food_card/status');
    }
}
