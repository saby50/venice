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
use Auth;
use App\User;
class WalletController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }

	function push() {
		$type = "web";
		$data = DB::table('user_notifications')->orderBy('id','desc')->get();
        return view('vendor.multiauth.admin.wallet.send_push', compact('type','data'));
	}
	function unit_push() {
		$type = "web";
		
		$data = DB::table('unit_notifications')->orderBy('id','desc')->get();
        return view('vendor.multiauth.admin.wallet.send_push_unit', compact('type','data'));
	}
	function recharge_history($parameter,$parameter2) {
		$type = "web";
		$custom = "";
		$data = DB::table('wall_history')->where('identifier','topup');

	
		if ($parameter=="todays" && $parameter2=="instamojo") {
			$data = $data->whereDate('created_at',Carbon::today());
			$data = $data->where('payment_method','instamojo');
		}elseif($parameter=="monthly" && $parameter2=="instamojo") {
            $data = $data->whereMonth('created_at',Carbon::now()->month);
            $data = $data->where('payment_method','instamojo');
		}elseif($parameter=="lastmonth" && $parameter2=="instamojo") {
			$month = new Carbon('last month');
            $data = $data->whereMonth('created_at',$month);
            $data = $data->where('payment_method','instamojo');
		}elseif($parameter=="yesterday" && $parameter2=="instamojo") {
			$month = new Carbon('yesterday');
            $data = $data->whereMonth('created_at',$month);
            $data = $data->where('payment_method','instamojo');
		}elseif($parameter=="todays" && $parameter2=="cash") {
           $data = $data->whereDate('created_at',Carbon::today());
            $data = $data->where('payment_method','cash');
		}elseif($parameter=="monthly" && $parameter2=="cash") {
            $data = $data->whereMonth('created_at',Carbon::now()->month);
            $data = $data->where('payment_method','cash');
		}elseif($parameter=="lastmonth" && $parameter2=="cash") {
            $month = new Carbon('last month');
            $data = $data->whereMonth('created_at',$month);
            $data = $data->where('payment_method','cash');
		}elseif($parameter=="yesterday" && $parameter2=="cash") {
           	$month = new Carbon('yesterday');
            $data = $data->whereDate('created_at',$month);
            $data = $data->where('payment_method','cash');
		}else {
			$data = $data->where('payment_method',$parameter2);
		}

        $data = $data->orderBy('wall_history.id', 'desc');
		$data = $data->get();
		$filters = DB::table('filter_types')->where('page_name','bookings')->where('filter_value','!=','custom')->get();
		return view('vendor.multiauth.admin.wallet.history', compact('type','data','filters','custom','parameter','parameter2'));
	}
	function send_push(Request $request) {
		$title = $request['title'];
		$message = $request['message'];
		$tokens = DB::table('user_tokens')->get();
		$token = array();
		foreach ($tokens as $key => $value) {
			$token[$key] = $value->token;
			
		}
		Helper::send_push_to_users($title,$message,$token);
		$date = date("Y-m-d H:i:s");
		$db = DB::table('user_notifications')->insert(['title' => $title,'message' => $message,'created_at' => $date, 'updated_at' => $date]);
		return redirect()->back()->withInput()->with('status','Notification published!');
	}
	function send_push_unit(Request $request) {
		$title = $request['title'];
		$message = $request['message'];
		$tokens = DB::table('unit_tokens')->get();
		$token = array();
		foreach ($tokens as $key => $value) {
			$token[$key] = $value->token;
			
		}
		Helper::send_notification_to_units($title,$message,$token);
		$date = date("Y-m-d H:i:s");
		$db = DB::table('unit_notifications')->insert(['title' => $title,'message' => $message,'created_at' => $date, 'updated_at' => $date]);
		return redirect()->back()->withInput()->with('status','Notification published!');
	}
	function delete_notification($id) {
       $delete = DB::table('user_notifications')->where('id',$id)->delete();
       return redirect()->back()->withInput()->with('status','Notification deleted!');
	}
	function delete_notification_unit($id) {
		 $delete = DB::table('unit_notifications')->where('id',$id)->delete();
       return redirect()->back()->withInput()->with('status','Notification deleted!');
	}
	 function qrcode($id) {
      return view('qrcode',compact('id'));
    }
     function checkuser($mobile) {
      $phone = "+91".$mobile;
      $db = User::where('phone',$phone)->get();
      $data = array();
      foreach ($db as $key => $value) {
      	$data[] = array('name' => $value->name,'email' => $value->email,'wall_am' => Crypt::decrypt($value->wall_am),'food_card' => Crypt::decrypt($value->food_card));
      }
      return $data;
    }


}