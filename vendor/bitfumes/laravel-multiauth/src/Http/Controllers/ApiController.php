<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use DB;
use Carbon\Carbon;
use Helper;
use Crypt;
use Hash;
use URL;
use App\User;
use App\Mail\UnitDailyReporting;
class ApiController extends Controller
{
  
  function get_app_managers_access($email,$type) {
		$data = Helper::get_todays_bookings($email,$type);

		$services = DB::table('services')->get();
		$packs = DB::table('packs')->get();
		return view('vendor.multiauth.admin.bookings.index', compact('data','services','packs','type','email'));
	}
  function getunitscheckins($parameter) {
       $units = DB::table('units')->where('epass','yes')->where('unit_name','!=','Mall')->get();
       $html = "";
       $html.= '<table class="table" style="margin-top:20px;">
            <thead>
              <tr>
                <th>Unit Name</th>
                <th>No of checkins</th>
              </tr>
            </thead>
            <tbody>';

            foreach($units as $key => $value) { 
               $count = Helper::get_checkin_count($value->id,$parameter);
            if ($count != 0) {
              $count = "<a href='".URL::to('admin/checkin/users/'.$value->id."/".$parameter)."'>".$count."</a>";
            }
              $html.=  '<tr>
                <td>'.$value->unit_name.'</td>

                <td>'.$count.'</td>
              </tr>';
            }
           
        $html.= '</tbody>
          </table>';

          return $html;
  }


  function getmallcheckins($parameter) {
      $db = Helper::getmallcheckins($parameter);
      return $db;
  }
  function unit_daily_reporting() {

    $units = DB::table('units')->get();

    $amount = 0;
    $emailers = array();
    foreach ($units as $key => $value) {
        $data = Helper::get_unit_revenue($value->id);
        if ($data['amount'] != 0) {
          $send = Mail::to($value->unit_email)->send(new UnitDailyReporting($data['amount'],$data['refund'],$data['net_amount'],$data['number_transactions'],$data['refund_count'],$value->unit_name,$value->unit_email));
          $send2 = Mail::to('singhsaby50@gmail.com')->send(new UnitDailyReporting($data['amount'],$data['refund'],$data['net_amount'],$data['number_transactions'],$data['refund_count'],$value->unit_name,$value->unit_email));
          if ($send) {
            echo $data['amount'];
          }
        }
    }


  }

	 function get_app_managers_all_access($email,$type,$parameter) {
         $type2 = "others";
		$data2 = Helper::get_future_bookings($type2,$type,$parameter,$email,'all');

		$services = DB::table('services')->get();
		$p4acks = DB::table('packs')->get();
		$filters = DB::table('filter_types')->where('page_name','bookings')->get();
		return view('vendor.multiauth.admin.bookings.all', compact('data2','services','packs','type','email','filters','parameter'));
	}
	function food_items_status($unit_id) {
      $data = DB::table('unit_menu_items')->where('unit_id', $unit_id)->get();
       $units = DB::table('units')->where('id', $unit_id)->get();
      return view('vendor.multiauth.admin.food_item_status', compact('data','unit_id','units'));
  }
  function change_status(Request $request) {
      $item_id = $request['item_id'];
      $itemstatus = $request['status'];
     
      $db = DB::table('unit_menu_items')->where('id', $item_id)->update(["status" => $itemstatus]);
      $status = "failed";
      if ($db) {
        $status = "success";
      }
      return $status;
  }
    function change_food_orders(Request $request) {
      $unit_id = $request['unit_id'];
      $itemstatus = $request['status'];
     
      $db = DB::table('units')->where('id', $unit_id)->update(["enable_food_order" => $itemstatus]);
      $status = "failed";
      if ($db) {
        $status = "success";
      }
      return $status;
  }
  function usercheckin(Request $request) {
    $userid = $request['userid'];
    $email = $request['email'];
    $parameter = $request['parameter'];

    $db = DB::table('units')->where('unit_email', $email)->get();
    $unit_id = 0;
    foreach ($db as $key => $value) {
      $unit_id = $value->id;
    }
    $date = date("Y-m-d H:i:s");
    $count = DB::table('user_checkins')
             ->where('user_id' , $userid)
             ->where('unit_id' , $unit_id)
             ->whereDate('user_checkins.created_at', Carbon::today())
             ->count();

    if ($count==0) {
      $insert = DB::table('user_checkins')
      ->insert(['user_id' => $userid, 'unit_id' => $unit_id,
        'created_at' => $date, 'updated_at' => $date]);
    }
    
     $users = DB::table('user_checkins')
    ->join('users', 'users.id','=','user_checkins.user_id')
    ->select(DB::raw('users.*'),
      DB::raw('user_checkins.updated_at as checkindate'))
    ->where('user_checkins.unit_id',$unit_id)
    ->whereDate('user_checkins.created_at', Carbon::today())
    ->groupBy('user_checkins.user_id')
    ->get();
   
    $unit = DB::table('units')->where('id', $unit_id)->get();
    $unit_name = "";
    foreach ($unit as $key => $value) {
      $unit_name = $value->unit_name;
    }
    $data = array('unit_name' => $unit_name, 'results' => $users);
    return $data; 
  }
  function update_restuarant_time(Request $request) {
    $from = $request['from_time'];
    $to = $request['to_time'];
    $unit_id = $request['unit_id'];
    $db = DB::table('units')->where('id',$unit_id)->update(['from_time' => $from, 'to_time' => $to]);
   return redirect('admin/api/food_items_status/'.$unit_id);
  }
	function get_app_managers_date_access($email,$type,$parameter2) {
		$type2 = "choose";
		$data2 = Helper::get_future_bookings($type2,$type,$parameter2,$email,'all');
		$services = DB::table('services')->get();
		$packs = DB::table('packs')->get();
		$filters = DB::table('filter_types')->where('page_name','bookings')->get();
		$parameter = "custom";

		return view('vendor.multiauth.admin.bookings.all', compact('data2','services','packs','filters','parameter','parameter2','type','email'));
	}

	function get_data(Request $request) {
		 $unit_email = $request['email'];
		 $filter_name = $request['parameter'];
		 $data = array();
		 $parameter = Helper::get_filter_types($filter_name);
		if ($parameter=="todays") {
				 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->join('users','users.id','=','wall_history.user_id')
            ->select(DB::raw('wall_history.*'),
            	DB::raw('users.name as name'),
            	DB::raw('users.phone as phone'),
            	DB::raw('users.email as email'),
            	DB::raw('units.unit_name as unit_name'))
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc')
            ->whereDate('wall_history.created_at', Carbon::today())
            ->get();
			}elseif($parameter=="monthly") {
				$now = Carbon::now();
                $month = $now->month;
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->join('users','users.id','=','wall_history.user_id')
            ->select(DB::raw('wall_history.*'),
            	DB::raw('users.name as name'),
            	DB::raw('users.phone as phone'),
            	DB::raw('users.email as email'),
            	DB::raw('units.unit_name as unit_name'))
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc')
            ->whereMonth('wall_history.created_at', $month)
            ->get();
			}elseif($parameter=="all") {
				
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->join('users','users.id','=','wall_history.user_id')
            ->select(DB::raw('wall_history.*'),
            	DB::raw('users.name as name'),
            	DB::raw('users.phone as phone'),
            	DB::raw('users.email as email'),
            	DB::raw('units.unit_name as unit_name'))
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc')
            
            ->get();
			}elseif($parameter=="yesterday") {
				$month = new Carbon('yesterday');
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->join('users','users.id','=','wall_history.user_id')
            ->select(DB::raw('wall_history.*'),
            	DB::raw('users.name as name'),
            	DB::raw('users.phone as phone'),
            	DB::raw('users.email as email'),
            	DB::raw('units.unit_name as unit_name'))
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc')
            ->whereDate('wall_history.created_at', $month)
            ->get();
			}elseif($parameter=="lastmonth") {
				$month = new Carbon('last month');
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->join('users','users.id','=','wall_history.user_id')
            ->select(DB::raw('wall_history.*'),
            	DB::raw('users.name as name'),
            	DB::raw('users.phone as phone'),
            	DB::raw('users.email as email'),
            	DB::raw('units.unit_name as unit_name'))
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc')
            ->whereMonth('wall_history.created_at', $month)
            ->get();
			}elseif($parameter=="custom") {
				$month = new Carbon('last month');
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->join('users','users.id','=','wall_history.user_id')
            ->select(DB::raw('wall_history.*'),
            	DB::raw('users.name as name'),
            	DB::raw('users.phone as phone'),
            	DB::raw('users.email as email'),
            	DB::raw('units.unit_name as unit_name'))
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc')
            
            ->get();
			}else {
				list($from, $to,$custom) = explode("_", $parameter);
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->join('users','users.id','=','wall_history.user_id')
           ->select(DB::raw('wall_history.*'),
            	DB::raw('users.name as name'),
            	DB::raw('users.phone as phone'),
            	DB::raw('users.email as email'),
            	DB::raw('units.unit_name as unit_name'))
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc');
            if ($from==$to) {
            $data = $data->whereDate('wall_history.created_at', $from)
                      ->whereDate('wall_history.created_at', $to);
          }else {
              $data = $data->whereBetween('wall_history.created_at', [$from, $to]);
          }
           
            $data = $data->get();
        }
        $units = Helper::get_unit_by_email($unit_email);
      
        $amount = 0;
        $net_amount = 0;
        $refund_status = "no";
        $refund_amount = 0;
        foreach ($data as $key => $value) {  	
        	$net_amount+= $value->final_amount;
          $refund_status = $value->refund;
          $refund_amount+= $value->refund_amount;
        }

        $amount = $net_amount + $refund_amount;

        $checkunit = DB::table('units')->where('unit_email',$unit_email)->get();
        $suspend = "no";
        $enable_food_order = "no";
        foreach ($checkunit as $key => $value) {
        	$suspend = $value->suspended;
          $enable_food_order = $value->enable_food_order;
          $epass = $value->epass;
        }
        if ($suspend=="yes") {
        	$data = array();
        }

        $finaldata = array('unit_id' => $units[0]['unit_id'],'unit_name' => $units[0]['unit_name'],'amount' => $amount,'net_amount' => $net_amount,'refund_amount' => $refund_amount, 'data' => $data,'refund_status' => $refund_status,'suspended' => $suspend,'enable_food_order' => $enable_food_order,'epass' => $epass);
        return array('result' => $finaldata);
	}
  function get_food_data(Request $request) {
     $unit_email = $request['email'];
     $filter_name = $request['parameter'];
     $data = array();
     $parameter = Helper::get_filter_types($filter_name);
    if ($parameter=="todays") {
         $data = DB::table('food_orders')
            ->join('units','units.id','=','food_orders.unit_id')
            ->join('users','users.email','=','food_orders.email')
            ->select(DB::raw('food_orders.*'),
              DB::raw('users.name as name'),
              DB::raw('users.phone as phone'),
              DB::raw('users.email as email'),
              DB::raw('units.unit_name as unit_name'))
            ->where('units.unit_email',$unit_email)
            ->orderBy('food_orders.id','desc')
            ->groupBY('food_orders.order_id')
            ->whereDate('food_orders.created_at', Carbon::today())
            ->get();
       
      }elseif($parameter=="monthly") {
        $now = Carbon::now();
                $month = $now->month;
        $data = DB::table('food_orders')
            ->join('units','units.id','=','food_orders.unit_id')
            ->join('users','users.email','=','food_orders.email')
            ->select(DB::raw('food_orders.*'),
              DB::raw('users.name as name'),
              DB::raw('users.phone as phone'),
              DB::raw('users.email as email'),
              DB::raw('units.unit_name as unit_name'))
            ->where('units.unit_email',$unit_email)
            ->orderBy('food_orders.id','desc')
            ->groupBY('food_orders.order_id')
            ->whereMonth('food_orders.created_at', $month)
            ->get();
      }elseif($parameter=="all") {
        
          $data = DB::table('food_orders')
            ->join('units','units.id','=','food_orders.unit_id')
            ->join('users','users.email','=','food_orders.email')
            ->select(DB::raw('food_orders.*'),
              DB::raw('users.name as name'),
              DB::raw('users.phone as phone'),
              DB::raw('users.email as email'),
              DB::raw('units.unit_name as unit_name'))
            ->where('units.unit_email',$unit_email)
            ->groupBY('food_orders.order_id')
            ->orderBy('food_orders.id','desc')
            ->get();
      }elseif($parameter=="yesterday") {
        $month = new Carbon('yesterday');
           $data = DB::table('food_orders')
            ->join('units','units.id','=','food_orders.unit_id')
            ->join('users','users.email','=','food_orders.email')
            ->select(DB::raw('food_orders.*'),
              DB::raw('users.name as name'),
              DB::raw('users.phone as phone'),
              DB::raw('users.email as email'),
              DB::raw('units.unit_name as unit_name'))
            ->where('units.unit_email',$unit_email)
            ->orderBy('food_orders.id','desc')
            ->groupBY('food_orders.order_id')
            ->whereDate('food_orders.created_at', $month)
            ->get();
      }elseif($parameter=="lastmonth") {
        $month = new Carbon('last month');
          $data = DB::table('food_orders')
            ->join('units','units.id','=','food_orders.unit_id')
            ->join('users','users.email','=','food_orders.email')
            ->select(DB::raw('food_orders.*'),
              DB::raw('users.name as name'),
              DB::raw('users.phone as phone'),
              DB::raw('users.email as email'),
              DB::raw('units.unit_name as unit_name'))
            ->where('units.unit_email',$unit_email)
            ->orderBy('food_orders.id','desc')
            ->groupBY('food_orders.order_id')
            ->whereMonth('food_orders.created_at', $month)
            ->get();
      }elseif($parameter=="custom") {
        $month = new Carbon('last month');
           $data = DB::table('food_orders')
            ->join('units','units.id','=','food_orders.unit_id')
            ->join('users','users.email','=','food_orders.email')
            ->select(DB::raw('food_orders.*'),
              DB::raw('users.name as name'),
              DB::raw('users.phone as phone'),
              DB::raw('users.email as email'),
              DB::raw('units.unit_name as unit_name'))
            ->where('units.unit_email',$unit_email)
            ->orderBy('food_orders.id','desc')
            
            ->get();
      }else {
        list($from, $to,$custom) = explode("_", $parameter);
          $data = DB::table('food_orders')
            ->join('units','units.id','=','food_orders.unit_id')
            ->join('users','users.email','=','food_orders.email')
            ->select(DB::raw('food_orders.*'),
              DB::raw('users.name as name'),
              DB::raw('users.phone as phone'),
              DB::raw('users.email as email'),
              DB::raw('units.unit_name as unit_name'))
            ->where('units.unit_email',$unit_email)
            ->orderBy('food_orders.id','desc');
            if ($from==$to) {
            $data = $data->whereDate('wall_history.created_at', $from)
                      ->whereDate('wall_history.created_at', $to);
          }else {
              $data = $data->whereBetween('wall_history.created_at', [$from, $to]);
          }
           
            $data = $data->get();
        }
        $units = Helper::get_unit_by_email($unit_email);
      
        $amount = 0;
        $net_amount = 0;
        $refund_status = "no";
        $refund_amount = 0;
        $dataarr = array();
      
     
       
        foreach ($data as $key => $value) {   
            $net_amount+= $value->amount;
          $refund_status = $value->refund;
          $refund_amount+= $value->refund_amount;
           
         
          $dataarr[] = array("id" => $value->id, 'name' => $value->name,'email' => $value->email,'phone' => $value->phone,'unit_id' => $value->unit_id,'item_id' => $value->item_id,'quantity' => $value->quantity, 'price' => $value->price, 'amount' => $value->amount,'tax' => $value->tax,'payment_id' => $value->payment_id,'order_id' => $value->order_id,'payment_method' => $value->payment_method,'refund' => $value->refund,'refund_amount' => $value->refund_amount, 'status' => $value->status,'customize' => $value->customize,'items' => Helper::get_item_array($value->item_ids),'created_at' => $value->created_at,'updated_at' => $value->updated_at,'unit_name' => $value->unit_name);
          
        }

        $amount = $net_amount + $refund_amount;

        $checkunit = DB::table('units')->where('unit_email',$unit_email)->get();
        $suspend = "no";
        $enable_food_order = "no";
        foreach ($checkunit as $key => $value) {
          $suspend = $value->suspended;
           $enable_food_order = $value->enable_food_order;
        }
        if ($suspend=="yes") {
          $dataarr = array();
        }

        $finaldata = array('unit_id' => $units[0]['unit_id'],'unit_name' => $units[0]['unit_name'],'amount' => $amount,'net_amount' => $net_amount,'refund_amount' => $refund_amount, 'data' => $dataarr,'refund_status' => $refund_status,'suspended' => $suspend,'enable_food_order' => $enable_food_order);
        return array('result' => $finaldata);
  }
	 function unit_refund(Request $request) {
         $amount = $request['amount'];
         $order_id = $request['order_id'];
         $unit_id = $request['unit_id'];

         $data = $this->refund_process($amount, $order_id, $unit_id);

         
         return $data;
    }
   
     function unit_refund_web(Request $request) {
         $amount = $request['amount'];
         $order_id = $request['order_id'];
         $unit_id = $request['unit_id'];

         $data = $this->refund_process($amount, $order_id, $unit_id);

         
         return redirect()->back()->withInput()->with('status','Refund succcess!');
    }
    function refund_food(Request $request) {
      $order_id = $request['order_id'];
      return Helper::refund_food_order($order_id);

    }

    function refund_process($amount, $order_id, $unit_id) {
      $orderdetails = DB::table('wall_history')->where('order_id', $order_id)->get();
         $user_id = 0;
         foreach ($orderdetails as $key => $value) {
           $user_id = $value->user_id;
           $payment_method = $value->payment_method;
         }

         $unit_info = Helper::get_unit_info($unit_id);

         $unit_name = "";

         foreach ($unit_info as $key => $value) {
           $unit_name = $value->unit_name;
         }

        $checkuser = User::where('id',$user_id)->get();

         $wall_amount = 0;
         $phone = "";
         $food_card = 0;
         foreach ($checkuser as $key => $value) {
            $wall_amount = $value->wall_am;
            $food_card = $value->food_card;
            $phone = $value->phone;
         }

         if ($payment_method=="gv_pocket") {
            $updated_balance = Crypt::decrypt($wall_amount) + $amount;

         $update = DB::table('users')->where('id',$user_id)->update(['wall_am' => Crypt::encrypt($updated_balance)]);
         }else {
           $updated_balance = Crypt::decrypt($food_card) + $amount;

         $update = DB::table('users')->where('id',$user_id)->update(['food_card' => Crypt::encrypt($updated_balance)]);
         }
        

         $refund = DB::table('wall_history')->where('order_id', $order_id)->where('unit_id', $unit_id)->update(['refund' => 'yes','refund_amount' => $amount,'final_amount' => '0', 'mainamount' => '0','extra' => '0']);

         $payment_id = uniqid(mt_rand(),true);
         $date = date("Y-m-d H:i:s");
         $platform = Helper::get_device_platform();
         $insert = DB::table('wall_history')->insert(['final_amount' => $amount,'user_id' => $user_id,'order_id' => $order_id, 'identifier' => 'refund','unit_id' => $unit_id,'trans_id' => $payment_id,'payment_method' => $payment_method,'platform' => $platform,'created_at' => $date, 'updated_at' => $date]);

         $data = array('status' => 'failed');
         if ($insert) {
          if ($payment_method=="gv_pocket") {
           $content = "Your Order ID:".$order_id." for Rs. ".$amount." is refunded by ".$unit_name." to GV Pay. Your GV Pay balance is Rs. ".$updated_balance.". Install the iPhone/Android App: https://l.ead.me/29Ev";
            Helper::send_otp($phone,$content);
         }else {
          $content = "Your Order ID:".$order_id." for Rs. ".$amount." is refunded by ".$unit_name." to Food Card. Your Food Card balance is".$updated_balance.". Install the iPhone/Android App: https://l.ead.me/29Ev";
           Helper::send_otp($phone,$content);
         }
           
           $data = array('status' => 'success');
         }
         return $data;
    }
    function change_food_status(Request $request) {
      $orderstatus = $request['status'];
      $order_id = $request['order_id'];
      $db = DB::table('food_orders')->where('order_id', $order_id)->update(['status' => $orderstatus]);
      $getdetails = DB::table('food_orders')->where('order_id',$order_id)->get();
       $phone = ""; $payment_id = 0; $payment_method = ""; $refund_amount = 0;
       $status = ""; $unit_id = 0; $unit_name = "";
      foreach ($getdetails as $key => $value) {
        $phone = $value->phone;
        $payment_id = $value->payment_id;
        $payment_method = $value->payment_method;
        $refund_amount = $value->amount;
        $unit_id = $value->unit_id;
      }
       $get_unit_info = Helper::get_unit_info($unit_id);
       foreach ($get_unit_info as $key => $value) {
          $unit_name = $value->unit_name;
       }
       $res = "";
      if ($orderstatus=="rejected") {
        $content = "Your Order ID: ".$order_id." is refused by ".$unit_name.". The payment will be refunded within 7 working days. Sorry for the inconvenience!";
        $status = Helper::refund_food_order($order_id);

      }elseif ($orderstatus=="confirmed") {
         $content = "Your Order ID: ".$order_id." is confirmed by ".$unit_name.". Install the iPhone/Android App: https://l.ead.me/29Ev";
         $status =  "success";
      }elseif ($orderstatus=="completed") {
        $content = "Your Order ID: ".$order_id." with ".$unit_name." is READY, Please collect the same! Install the iPhone/Android App: https://l.ead.me/29Ev";
        $status =  "success";
      }
     
      Helper::send_otp($phone,$content);
      return $status;

    }
	 function checkin(Request $request) {
    $phone = $request['phone'];
		$order_id = $request['order_id'];
		$s_ids = explode(',', $request['service_id']);
		$gondolier = $request['gondolier'];
		
		$services = array();
		$date2 = date("d F Y, h:i A");
		$checkin_time = date("H:i A");
		$type2 = $request['type'];
		$email = $request['email'];
		$managers = Helper::get_manager($type2,$email);

		$db = DB::table('bookings')->where('phone',"+91".$phone)->where('order_id',$order_id)->count();

		if ($db==0) {
			if ($type2=="app") {
			return redirect('admin/get_app_managers_access/'.$email.'/app')->withInput()->with('error','Phone no is wrong');
		}else {
			
            return redirect('admin/bookings/today')->withInput()->with('error','Phone no is wrong');


		}
			
		}else {

			   $date5 = date("Y-m-d H:i:s");
            if ($gondolier != "" || isset($gondolier)) {
            	foreach ($gondolier as $key => $value) {
				$gond = DB::table('gondolier_checkins_log')->insert(['gondolier_id' => $value,'order_id' => $order_id,'created_at' => $date5,'updated_at' => $date5]);
			}
            }

		foreach ($s_ids as $key => $value) {
			list($serviceid,$type) = explode('_', $value);
			if ($type=="packs") {
				$services = explode(",",Helper::get_pack_services($serviceid));
			   foreach ($services as $k => $v) {
			   if (in_array($v, $managers)) {
			   	   $checkin = DB::table('bookings')->where('book_pack_id',$serviceid)->where('service_id',$v)->where('type','packs')->where('order_id',$order_id)->update(['checkin' => 'yes','checkin_time' => $date2]);

			   	    $checkservice = DB::table('bookings')->where('checkin','no')->where('book_pack_id',$serviceid)->count();
			   	    if ($checkservice==0) {
			   	    	$checkin2 = DB::table('bookings_packs')->where('id',$serviceid)->update(['checkin' => 'yes','checkin_time' => $date2]);
			   	    }else {
			   	    	$checkin2 = DB::table('bookings_packs')->where('id',$serviceid)->update(['checkin' => 'no','checkin_time' => $date2]);
			   	    }
			    }
		       }
			}else {

				$checkin = DB::table('bookings')->where('id',$value)->update(['checkin' => 'yes','checkin_time' => $date2]);

			}

			
		}

          // $content .= "You checked-in at The Grand Venice Mall for ".rtrim($snames,",")." Order ID: ".$order_id.", Qty: ".$quantity.", Check-in Time: ".$checkin_time." on ".$date2;

			
			//Helper::send_otp($phone,$content);
	        return redirect('admin/get_app_managers_access/'.$email.'/app')->withInput()->with('status','Successfully Checkedin');
		}
	}
  function forgotpin(Request $request) {
    $mobile = $request['mobile'];
      $finduser = DB::table('admins')->where('phone', $mobile)->first();
      $pin = Helper::generatePIN(6);
      $data = array();
      if ($finduser) {
        $pin = Helper::generatePIN(6);
        $update = DB::table('admins')->where('phone',$mobile)->update(['password' => bcrypt($pin)]);
        $content = "You have successfully reset your PIN. The new PIN is ".$pin.". Please login with your email id ".$finduser->email." and PIN.";
        Helper::send_otp($mobile,$content);
        $data = array('status' => 'succcess','message' => 'Pin sent successfully'); 
      }else {
          $data = array('status' => 'no_found','message' => 'User not found');
      }
      return $data;
  }

	function applogin(Request $request) {
	  $email = $request['email'];
	  $password = $request['password'];
	  $token = "";
	  $date = date("Y-m-d H:i:s");
	  if (isset($request['token'])) {
	  	$token = $request['token'];
	  	$units = Helper::get_unit_by_email($email);
	  	$unit_id = $units[0]['unit_id'];
	  	$checkunit = DB::table('unit_tokens')->where('unit_id', $unit_id)->count();
	  	if ($checkunit==0) {
	  		$db = DB::table('unit_tokens')->insert(['unit_id' => $unit_id, 'token' => $token, 'created_at' => $date, 'updated_at' => $date]);
	  	}else {
	  		$db = DB::table('unit_tokens')->where('unit_id',$unit_id)->update(['token' => $token,'updated_at' => $date]);
	  	}
	  	
	  }
	   $date = date("Y-m-d H:i:s");

	  $finduser = DB::table('admins')->where('email', $email)->get();
	  $userpassword = ""; $user_id="";
	  foreach ($finduser as $key => $value) {
	  	$userpassword = $value->password;
	  	$user_id = $value->id;
	  }
	  $data = array();
      if ($finduser) {
          $passcheck = Hash::check($password, $userpassword);
          if ($passcheck==true) {  
              $data = array('status' => 'succcess','message' => 'login succcess');
              $db = DB::table('login_logs')->insert(['user_id' => $user_id,'created_at' => $date, 'updated_at' => $date]);        
              
          }else {
          	$data = array('status' => 'failed','message' => 'login failed');
          }

      }else {

      	$data = array('status' => 'notfound','message' => 'User not found!');

      }

      return $data; 

	}
	function gettoken(Request $request) {
       $token = $request['token'];
       $imei = $request['imei'];
       $date = date("Y-m-d H:i:s");
       $checktoken = DB::table('user_tokens')->where('token' , $token)->count();
       $db = "";
       if ($checktoken==0) {
       	 $db = DB::table('user_tokens')->insert(['token' => $token,'imei' => $imei,'created_at' => $date, 'updated_at' => $date]);
       }else {

       }
       $data = array('status' =>'succcess');
       if ($db) {
       	$data = array('status' =>'succcess');
       }
       return $data;
	}
	function checknewbookings($email) {
		$unit_id = Helper::get_unit_manager_id($email);
		$count = DB::table('wall_history')
		     ->where('unit_id', $unit_id)
		     ->where('identifier','payment')
         ->whereDate('created_at', Carbon::today())
		     ->count();

		return $count;

	}
	function get_booking_counts() {
  $services = DB::table('bookings')
     ->where('type','service')
     ->where('status','success')
     ->whereDate('bookings.created_at',Carbon::today())
     ->count();

    $packs = DB::table('bookings_packs')
     ->where('type','service')
     ->where('status','success')
     ->whereDate('bookings_packs.created_at',Carbon::today())
     ->count();

     $count = $services + $packs;


   return $count;
}


}