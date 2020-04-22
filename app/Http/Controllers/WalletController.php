<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Crypt;
use Session;
use URL;
use Helper;
class WalletController extends Controller
{
    function wallet() {
      $user_id = Auth::user()->id;
       $topup = DB::table('wall_history')->where('user_id',$user_id)->limit(3)->orderBy('id', 'desc')->get();
       return view('wallet/wallet',compact('topup'));
    }
    function recharge() {
      $rechage_denomination = DB::table('pricing_denomination')->get();
      return view('wallet/recharge',compact('rechage_denomination'));
    }
    function promo() {
      return view('wallet/promo');
    }
    function recharge_payment(Request $request) {

       $amount = $request['amount'];
       $purpose = $request['purpose'];
       $name = Auth::user()->name;
       $email = Auth::user()->email;
       $phone = Auth::user()->phone;
       $mainam = $request['mainam'];
       $extram = $request['extram'];

       $payment_method = $request['payment_method'];
       $current_amount = Crypt::decrypt(Auth::user()->wall_am);
       $user_id = Auth::user()->id;
       $final_amount = $amount + $extram;
       $wallet[] =  array('final_amount' => $final_amount, 'main_amount' => $mainam, 'extra_amount' => $extram,'current_amount' => $current_amount);

       $check = DB::table('wall_session_temp')->where('user_id',$user_id)->count();
       if ($check==0) {
       $insert = DB::table('wall_session_temp')->insert(['final_amount' => $final_amount,'mainamount' => $mainam,'extra' => $extram,'current_amount' => $current_amount,'user_id' => $user_id]);
       }else {
       	$delete = DB::table('wall_session_temp')->where('user_id',$user_id)->delete();
       	 $insert = DB::table('wall_session_temp')->insert(['final_amount' => $final_amount,'mainamount' => $mainam,'extra' => $extram,'current_amount' => $current_amount,'user_id' => $user_id]);
       }

        
        
       
          if ($payment_method=="instamojo") {
          $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url')
        );
 
    try {
        $response = $api->paymentRequestCreate(array(
            "purpose" => $purpose,
            "amount" => $amount,
            "buyer_name" => $name,
            "payment_method" => $payment_method,
            "send_email" => true,
            "email" => $email,
            "phone" => $phone,
            "redirect_url" => URL::to('recharge/status')
            ));
             
            header('Location: ' . $response['longurl']);
            exit();
    }catch (Exception $e) {
        print('Error: ' . $e->getMessage());
    }
        
      }
       
    }
    function recharge_status() { 
       
    	$date = date("Y-m-d H:i:s");
        $response = array();
        $status = "";
        
     try {
 
        $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url')
        );
 
        $response = $api->paymentRequestStatus(request('payment_request_id'));
        $phone = $response['payments'][0]['buyer_phone'];
        if( !isset($response['payments'][0]['status']) ) {
           $status = "failed";
        } else if($response['payments'][0]['status'] != 'Credit') {
             $status = "failed";
            
        }else {
             $status = "success";
            
        }

      }catch (\Exception $e) {
          $status = "failed";
     }


     
            $payment_id = $response['payments'][0]['payment_id'];
            $currency = $response['payments'][0]['currency'];
            $amount = $response['payments'][0]['amount'];
            $name = $response['payments'][0]['buyer_name'];
            
            $email = $response['payments'][0]['buyer_email'];
            
            $type  = $response['payments'][0]['instrument_type'];
            if ($status=="success") {
            	return Helper::wallet_process($name,$email,$phone,$response['purpose'],$amount,'instamojo',$payment_id,$currency,$type,$status); 
            }

            
            
     
    }
    function pay() {
      $units = DB::table('units')->orderBy('id','desc')->get();
    	return view('wallet/pay', compact('units'));
    }
     function scanpay() {
      return view('wallet/scanpay');
    }
     function paynow($id) { 
      
       $unit = Helper::get_unit_info($id);
         $food_card = "no";
    foreach ($unit as $key => $value) {
      $food_card = $value->food_card;
    }
    $status = Helper::check_user_refund_status();
    if ($food_card=="no" || $status=="1") {
      $payment_method = DB::table('payment_method')->where('gateway_name','!=','food_card')->where('status','active')->get();
    }else {
      $payment_method = DB::table('payment_method')->where('status','active')->get();
    }
     
      return view('wallet/paynow',compact('id','payment_method'));
    }
    function process(Request $request) {
      $amount = $request['amount'];
      $unit_id = $request['unit_id'];
      $user_id = Auth::user()->id;
      $trans_id = uniqid(mt_rand(),true);
      $payment_method = $request['payment_method'];
      if ($payment_method=="gv_pocket") {
        $order_id = "GV/WP/".Helper::generatePIN(6);
      }else {
        $order_id = "GV/FC/".Helper::generatePIN(6);
      }
      
      if ($payment_method=="gv_pocket") {
        $current_bal = Crypt::decrypt(Auth::user()->wall_am);
        return Helper::process_payment(Auth::user()->name,Auth::user()->phone,$unit_id,$amount,$user_id,$trans_id,$payment_method,$order_id,$current_bal);
      }elseif($payment_method=="food_card") {
        
         $current_bal = Crypt::decrypt(Auth::user()->food_card);
        return Helper::process_payment(Auth::user()->name,Auth::user()->phone,$unit_id,$amount,$user_id,$trans_id,$payment_method,$order_id,$current_bal);
      }else {
            $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url')
        );
 
    try {
        $response = $api->paymentRequestCreate(array(
            "purpose" => $request['purpose'].",".$unit_id,
            "amount" => $amount,
            "buyer_name" => Auth::user()->name,
            "payment_method" => $payment_method."_".$unit_id,
            "send_email" => true,
            "email" => Auth::user()->email,
            "phone" => Auth::user()->phone,
            "redirect_url" => URL::to('instaprocess')
            ));
             
            header('Location: ' . $response['longurl']);
            exit();
    }catch (Exception $e) {
        print('Error: ' . $e->getMessage());
    }
      }
    }
    function view_all() {
      $user_id = Auth::user()->id;
      $topup = DB::table('wall_history')->where('user_id',$user_id)->orderBy('id', 'desc')->get();
      return view('wallet/viewall',compact('topup'));
    }
   

    function testpush() {
      $message = "You have recieved amount of Rs. 1200";
      $token = "dUp7dqY-S2o:APA91bGo0aE5NdqPynJkeW80Svrqgx1kKSawlnFLojRB7c65pmkx_PziHbDqm7X2M1opS6hRpoacT_QtvOZltCjWF2slGe0IjJfSmYkbCTUVTeYzKsUPPf_ZXG9TIUWf5EzdkcI_JX5n";
      return Helper::send_push_to_units($message,$token);
    }
    function instaprocess() {
          $date = date("Y-m-d H:i:s");
        $response = array();
        $status = "";
        
     try {
 
        $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url')
        );
 
        $response = $api->paymentRequestStatus(request('payment_request_id'));
        $phone = $response['payments'][0]['buyer_phone'];
        if( !isset($response['payments'][0]['status']) ) {
           $status = "failed";
        } else if($response['payments'][0]['status'] != 'Credit') {
             $status = "failed";
            
        }else {
             $status = "success";
            
        }

      }catch (\Exception $e) {
          $status = "failed";
     }


     
            $payment_id = $response['payments'][0]['payment_id'];
            $currency = $response['payments'][0]['currency'];
            $amount = $response['payments'][0]['amount'];
            $name = $response['payments'][0]['buyer_name'];
            $purpose = $response['purpose'];
            $email = $response['payments'][0]['buyer_email'];
            list($a, $b) = explode(',', $purpose);
            
            $type  = $response['payments'][0]['instrument_type'];
            $user_id = Auth::user()->id;
            $trans_id = uniqid(mt_rand(),true);
            $order_id = "GV/WP/".Helper::generatePIN(6);
            if ($status=="success") {
              $current_bal = Crypt::decrypt(Auth::user()->wall_am);
              return Helper::process_payment(Auth::user()->name,Auth::user()->phone,$b,$amount,$user_id,$trans_id,'instamojo',$order_id,$current_bal); 
            }

    }
    
}
