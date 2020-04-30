<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Carbon\Carbon;
use Helper;
use Session;
use Crypt;
use App\User;
use Auth;
class FoodcardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
	function food_card_topup() {
	$type = 'web';
  	$status = "success";
  	$denominations = DB::table('pricing_denomination')->get();
  	return view('vendor.multiauth.admin.cash.foodcardtopup', compact('type','status','denominations')); 
	}
  function sent_otp($phone, $order_id,$status) {
       $otp = Helper::generatePIN(6);
      $orderid = Crypt::decrypt($order_id);
      $update = DB::table('food_card_refund_requests')->where('order_id',$orderid)->update(['status' => 'reject']);
      $content = "Your refund request with Request ID ".$orderid." is cancelled!. Install the iPhone/Android App: https://l.ead.me/29Ev";
      $send = Helper::send_otp($phone, $content);

  }
  
	function get_user_id($name, $phone, $email) {
  	$finduser = User::where('phone', $phone)->first();

  	 $pin = Helper::generatePIN();
     $user_id =0;
     if (!$finduser) {
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->wall_am = Crypt::encrypt("0");
        $user->password = bcrypt($pin);
        $user->platform = "web";
        $user->otp = $pin;
        $user->type = 'user';
        $user->save();
          $mobile = $phone;
          if (strlen($mobile) == 13 && substr($mobile, 0, 3) == "+91") {
            $mobile = substr($mobile, 3, 10);
          }
         $content = "You are now registered with The Grand Venice Mall. Your login is ".$mobile." and PIN is ".$pin.". Install the iPhone/Android App: https://l.ead.me/29Ev";
        Helper::send_otp($phone,$content);
        $user_id = $user->id;
        $wall_am = "0";
        $food_card = "0";
        }else {
              $user_id = $finduser['id'];
              if ($email == "") {
                $email = $finduser['email'];
              }else {
                $email = $email;
              }
              $updatedate = date("d F Y, h:i A");
              $wall_am = $finduser['wall_am'];
              $food_card = $finduser['food_card'];
              $updateemail = DB::table('users')->where('id',$user_id)->update(['email' => $email,'name' => $name,'updated_at' => $updatedate]); 
        }
        return array('wall_am' => $wall_am,'user_id' => $user_id,'food_card' => $food_card);
  }
	function add(Request $request) {
		$name = $request['name'];
  	$phone = $request['phone'];
  	$amount = $request['amount'];
  	$email = $request['email'];
  	$payment_id = uniqid(mt_rand(),true);
  	$currency = 'INR';
  	$type = "";
  	$status = "success";
  	
    $users = $this->get_user_id($name, "+91".$phone, $email);
    $user_id = $users['user_id'];
    $food_card = $users['food_card'];
  	
  	$date = date("Y-m-d H:i:s");
    $expiry = date('d-m-Y', strtotime('+12 Month',strtotime($date)));
    $order_id = "GV/FC/TP/".Helper::generatePIN();
    $final_amount = $amount;
    $extra = 0;
    $updated_amount = Crypt::decrypt($food_card) + $final_amount;
  	

  	$data = array('final_amount' => $final_amount,'mainamount' => $amount,'extra' => $extra,'user_id' => $user_id,'order_id' => $order_id,'expiry' => $expiry,'identifier' => 'topup','trans_id' => $payment_id,'payment_method' => 'food_card','platform' => 'web','created_at' => $date, 'updated_at' => $date);

  	$updatebalance = DB::table('users')->where('id',$user_id)->update(['food_card'=> Crypt::encrypt($updated_amount)]);

  	$db = DB::table('wall_history')->insert($data);

  	if ($db) {
  		 $content = "Your Food Card is recharged with Rs. ".$amount.", Food Card Balance is Rs. ".$updated_amount.". Install the iPhone/Android App: https://l.ead.me/29Ev";
         Helper::send_otp($phone,$content);
  		return redirect()->back()->withInput()->with('status','Food Card recharge successfully');
  	}
	}

  function food_card_refund($parameter) {
    $type = "web";
    $custom = "";
    $data = DB::table('food_card_refund_requests')->where('identifier','refund');

  
    if ($parameter=="todays") {
      $data = $data->whereDate('created_at',Carbon::today());
      
    }elseif($parameter=="monthly") {
            $data = $data->whereMonth('created_at',Carbon::now()->month);
           
    }elseif($parameter=="lastmonth") {
      $month = new Carbon('last month');
            $data = $data->whereMonth('created_at',$month);
           
    }elseif($parameter=="yesterday") {
      $month = new Carbon('yesterday');
            $data = $data->whereMonth('created_at',$month);
          
    }else {
      //$data = $data->where('payment_method',$parameter2);
    }
       $data = $data->where('food_card_refund_requests.status', 'pending');
        $data = $data->orderBy('food_card_refund_requests.id', 'desc');
    $data = $data->get();
    $filters = DB::table('filter_types')->where('page_name','bookings')->where('filter_value','!=','custom')->get();
    return view('vendor.multiauth.admin.cash.foodcardrefund', compact('type','data','filters','custom','parameter'));
  }
  function food_card_refund_process(Request $request) {
    $order_id = $request['order_id'];
    $otp = $request['otp'];

    $request_id = Crypt::decrypt($order_id);
    $getdetails = DB::table('food_card_refund_requests')->where('order_id',$request_id)->where('otp',$otp)->get();
    $user_id = 0;

    if (count($getdetails)!=0) {
     foreach ($getdetails as $key => $value) {
     $user_id = $value->user_id;
    }
    $finduser = User::where('id', $user_id)->first();
    $refund_amount = Crypt::decrypt($finduser['food_card']);
    $date = date("Y-m-d H:i:s");
    $reqotp = Helper::generatePIN(6);
    $data = array('final_amount' => 0, 'mainamount' => 0, 'extra' => 0, 'user_id' => $user_id, 'order_id' => $request_id, 'expiry' => '', 'identifier' => 'refund', 'unit_id' => 0, 'trans_id' => '','payment_method' => 'food_card', 'platform' => 'android', 'refund' => 'yes', 'refund_amount' => $refund_amount,'created_at' => $date, 'updated_at' => $date);
      $db = DB::table('wall_history')->insert($data);
      if ($db) {
        $update = DB::table('users')->where('id',$user_id)->update(['food_card' => Crypt::encrypt(0)]);
        $content = "Rs ".$refund_amount." refunded in cash from your Food Card. Request ID: ".$request_id. " and OTP: ".$reqotp.". Install the iPhone/Android App: https://l.ead.me/29Ev";
             Helper::send_otp($finduser['phone'],$content);
           $update_request = DB::table('food_card_refund_requests')->where('order_id',$request_id)->update(['status' => 'refunded']);
         return redirect()->back()->withInput()->with('status','Food Card refunded successfully');
      }
    }else {
      return redirect()->back()->withInput()->with('error','OTP mismatch!');
    }

    

  }
  function revenue($parameter) {
     $type = "web";
    $custom = "";
    $data = DB::table('wall_history')->where('identifier','!=','payment');

  
    if ($parameter=="todays") {
      $data = $data->whereDate('created_at',Carbon::today());
      
    }elseif($parameter=="monthly") {
            $data = $data->whereMonth('created_at',Carbon::now()->month);
           
    }elseif($parameter=="lastmonth") {
      $month = new Carbon('last month');
            $data = $data->whereMonth('created_at',$month);
           
    }elseif($parameter=="yesterday") {
      $month = new Carbon('yesterday');
            $data = $data->whereDate('created_at',$month);
          
    }else {
      
    }
       $data = $data->where('wall_history.payment_method', 'food_card');
        $data = $data->orderBy('wall_history.id', 'desc');
    $data = $data->get();
    $filters = DB::table('filter_types')->where('page_name','bookings')->get();
    return view('vendor.multiauth.admin.cash.foodcardrevenue', compact('type','data','filters','parameter','custom'));
  }
  function fc_refund(Request $request) {
     $phone = $request['phone'];
     $email = $request['email'];
     $name = $request['name'];

     $finduser = DB::table('users')->where('phone',"+91".$phone)->get();
     $request_id = "GV/FC/RE/".Helper::generatePIN(6);
     $food_card = 0;
     $user_id = 0;
     foreach ($finduser as $key => $value) {
        $food_card = Crypt::decrypt($value->food_card);
        $user_id = $value->id;
     }

      $date = date("Y-m-d H:i:s");
      $reqotp = Helper::generatePIN(6);
      $data = array('final_amount' => 0, 'mainamount' => 0, 'extra' => 0, 'user_id' => $user_id, 'order_id' => $request_id, 'expiry' => '', 'identifier' => 'refund', 'unit_id' => 0, 'trans_id' => '','payment_method' => 'food_card', 'platform' => 'android', 'refund' => 'yes', 'refund_amount' => $food_card,'otp' => $reqotp,'created_at' => $date, 'updated_at' => $date);
      $db = DB::table('food_card_refund_requests')->insert($data);
     
      if ($db) {
        
        $content = "Your request for Food Card refund (Rs. ".$food_card.") is generated. Request ID:  ".$request_id. " and OTP: ".$reqotp.". Install the iPhone/Android App: https://l.ead.me/29Ev";
             Helper::send_otp($phone,$content);
              $status = Crypt::encrypt($request_id);
            
      }else {
        $status = "failed";
      }
      return $status;

  }
  function custom($parameter) {
    $type = "web";
    $custom = "custom";
    list($from, $to) = explode("_", $parameter);
    $data = DB::table('wall_history')->where('identifier','topup');
    if ($from==$to) {
        $data = $data->whereDate('wall_history.created_at', $from)
                      ->whereDate('wall_history.created_at', $to);
    }else {
        $data = $data->whereBetween('wall_history.created_at', [$from, $to]);
    }
    $data = $data->where('wall_history.payment_method', 'food_card');
    $data = $data->orderBy('wall_history.id', 'desc');
    $data = $data->get();
    $filters = DB::table('filter_types')->where('page_name','bookings')->get();
    return view('vendor.multiauth.admin.cash.foodcardrevenue', compact('type','data','filters','parameter','custom'));

  }


}