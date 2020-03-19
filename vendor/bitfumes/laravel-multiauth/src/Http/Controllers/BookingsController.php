<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use DB;
use URL;
use Auth;
use Carbon\Carbon;
use Helper;
use Crypt;
use Session;
use Bitly;
use App\Mail\FocMail;
use App\User;
class BookingsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
	function index() {
		$email = "super@admin.com";
		$type = "web";
		$data = Helper::get_todays_bookings($email,$type);

		$services = DB::table('services')->get();
		$packs = DB::table('packs')->get();
		return view('vendor.multiauth.admin.bookings.index', compact('data','services','packs','email','type'));
	}
	
	function all($parameter,$type3) {
		$type2 = "others";
		$email = Auth::user()->email;
		$type = "web";
		$data2 = Helper::get_future_bookings($type2,$type,$parameter,$email,$type3);
		$services = DB::table('services')->get();
		$packs = DB::table('packs')->get();
		$filters = DB::table('filter_types')->where('page_name','bookings')->get();
		$filter2 = DB::table('filter_types')->where('page_name','booking2')->get();
		return view('vendor.multiauth.admin.bookings.all', compact('data2','services','packs','filters','parameter','type','email','type3','filter2'));
	}
	function choose($parameter2,$type3) {
		$type2 = "choose";
		$email = Auth::user()->email;
		$type = "web";
		$data2 = Helper::get_future_bookings($type2,$type,$parameter2,$email,$type3);
		$services = DB::table('services')->get();
		$packs = DB::table('packs')->get();
		$filters = DB::table('filter_types')->where('page_name','bookings')->get();
		$parameter = "custom";
       
		$filter2 = DB::table('filter_types')->where('page_name','booking2')->get();
		return view('vendor.multiauth.admin.bookings.all', compact('data2','services','packs','filters','parameter','parameter2','type','email','filter2','type3'));
	}
	
	
	function get_history_bookings() {
		$date = date('d-m-Y');
		$manager_id = Auth::user()->id;
        $user_type = Auth::user()->user_type;
        $data = array();

		if ($user_type=="superadmin") {
				 $db = DB::table('bookings')
				->leftjoin('service_options','bookings.optional','=','service_options.id')	
				->select(DB::raw('bookings.*'),
					DB::raw('service_options.option_name as option_name'))	        
		        ->where('bookings.date','<=',$date)	
		     
		        ->orderBy('bookings.id','desc')
		        ->get();

		foreach ($db as $key => $value) {
			$service_id = $value->service_id;
			$optional = $value->optional;

			$data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->service_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'option_name' => $value->option_name,'service_id' => $value->service_id,'type' => $value->type,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin);

			
		}
		}else {
		$manager = DB::table('admins')
		->join('member_services','admins.id','=','member_services.member_id')
		->where('admins.user_type','manager')
		->where('admins.id',$manager_id)
		->get();
		$db = array(); $data = array();
        foreach ($manager as $key => $value) {
			$service_id = $value->service_id;
			list($a, $b) = explode('_', $service_id);
			if ($b==0) {
				$db = DB::table('bookings')
				->leftjoin('service_options','bookings.optional','=','service_options.id')	
				->select(DB::raw('bookings.*'),
					DB::raw('service_options.option_name as option_name'))	        
		        ->where('bookings.date','<=',$date)	
		        ->where('bookings.service_id',$a) 
		           
		        ->orderBy('bookings.id','desc')
		        ->get();
			}else {
	         $db = DB::table('bookings')
				->leftjoin('service_options','bookings.optional','=','service_options.id')	
				->select(DB::raw('bookings.*'),
					DB::raw('service_options.option_name as option_name'))	        
		        ->where('bookings.date','<=',$date)	
		        ->where('bookings.service_id',$a)	
		        ->where('bookings.optional',$b)	
		        		        
		        ->orderBy('bookings.id','desc')
		        ->get();
			}
			 
		
		foreach ($db as $key => $value) {
			$service_id = $value->service_id;
			$optional = $value->optional;

			$data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->service_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'option_name' => $value->option_name,'service_id' => $value->service_id,'type' => $value->type,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin);

			
		}

		}
	}
	
		return $data;
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
		if ($type2=="app") {
			return redirect('admin/get_app_managers_access/'.$email.'/app')->withInput()->with('status','Successfully Checkedin');
		}else {
			
            return redirect('admin/bookings/today')->withInput()->with('status','Successfully Checkedin');


		}
		}
	}

	function cash_bookings() {		
		$type = "web";
		$data = array();$data1 = array(); $data2 = array();
		$services = DB::table('services')
		            ->where('offline','yes')
		            ->get();
		$packs = DB::table('packs')
		         ->where('offline','yes')->get();
		$totalbookings = DB::table('bookings')
          ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))
          ->where('type','service') 
           ->where('status','success')        
          ->where('payment_method','!=','instamojo')       
          ->orderBy('bookings.created_at','desc')	
		->get();
		
		

		$totalpacks = DB::table('bookings_packs')
         ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
             ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))
             ->orderBy('bookings_packs.created_at','desc')
		->where('payment_method','!=','instamojo')
		 ->where('status','success')
		->get();
		
		 foreach ($totalpacks as $key => $value) {
         $data[$value->order_id][] = array('amount' => $value->amount);
         
        }      

    foreach ($totalbookings as $key => $value) {
        $data[$value->order_id][] = array('amount' => $value->amount);
     }
        $totalamount = 0;
		foreach ($data as $key => $value) {
			foreach ($value as $key => $value) {		
			}
			$totalamount += $value['amount'];
		}

		$now = Carbon::now();
        $month = $now->month;

		$monthbookings = DB::table('bookings')
        ->where('status','success')
		->where('type','service')		
		->whereMonth('bookings.created_at', $month)
		->where('payment_method','!=','instamojo')	
		->get();

	

		$monthpacks = DB::table('bookings_packs')
        ->where('status','success')
		->whereMonth('bookings_packs.created_at', $month)
		->where('payment_method','!=','instamojo')	
		->get();

		 foreach ($monthbookings as $key => $value) {
         $data1[$value->order_id][] = array('amount' => $value->amount);
         
        }

         foreach ($monthpacks as $key => $value) {
         $data1[$value->order_id][] = array('amount' => $value->amount);
         
        }

		  $monthamount = 0;
		foreach ($data1 as $key => $value) {
			foreach ($value as $key => $value) {		
			}
			$monthamount += $value['amount'];
		}

		$todaydate = date('d');

		$todaybookings = DB::table('bookings')
        ->where('status','success')
		->where('type','service')		
		->whereDate('bookings.created_at', Carbon::today())
		->where('payment_method','!=','instamojo')
		->get();

		$todayamount = 0; $todaysamount = 0;
		foreach ($todaybookings as $key => $value) {
		    $todaysamount += $value->price + $value->tax;
		}   

		$todaypacks = DB::table('bookings_packs')
        ->where('status','success')		
		->whereDate('bookings_packs.created_at', Carbon::today())
		->where('payment_method','!=','instamojo')
		->get();

	

		 foreach ($todaybookings as $key => $value) {
         $data2[$value->order_id][] = array('amount' => $value->amount);
         
        }

         foreach ($todaypacks as $key => $value) {
         $data2[$value->order_id][] = array('amount' => $value->amount);
         
        }

		  $todayamount = 0;
		foreach ($data2 as $key => $value) {
			foreach ($value as $key => $value) {		
			}
			$todayamount += $value['amount'];
		}

		   $menu_type = DB::table('occasion_menu_type')->get();
         $occasion_type = DB::table('occasion_type')->orderBy('position','ASC')->get(); 

         $payment_mode = DB::table('payment_modes')->get();     

         $venue = DB::table('venue')->get(); 

         $foc = DB::table('foc')->get(); 
         $foc_reasons = DB::table('foc_reasons')->get(); 


         $focbookings = DB::table('bookings')
          ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))
          ->where('type','service')  
           ->where('status','hold')    
          ->where('payment_method','!=','instamojo')       
          ->orderBy('bookings.created_at','desc')	
		->get();
		
		$data3 = array();

		$focpacks = DB::table('bookings_packs')
         ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
             ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))
             ->orderBy('bookings_packs.created_at','desc')
              ->where('status','hold')    
		->where('payment_method','!=','instamojo')
		->get();
		
		 foreach ($focpacks as $key => $value) {
         $data3[$value->order_id][] = array('amount' => $value->amount);
         
        }      

    foreach ($focbookings as $key => $value) {
        $data3[$value->order_id][] = array('amount' => $value->amount);
     }
        $focamount = 0;
		foreach ($data3 as $key => $value) {
			foreach ($value as $key => $value) {		
			}
			$focamount += $value['amount'];
		}

		$checksp = DB::table('bookings')
		           ->where('optional','22')
		           ->where('checkin','no')
		           ->whereDate('bookings.created_at',Carbon::today())
		           ->count();

		$checkgc = DB::table('bookings')
		           ->where('optional','21')
		           ->where('checkin','no')
		           ->whereDate('bookings.created_at',Carbon::today())
		           ->count();

		$events = DB::table('events')->where('status','published')->get();

	    return view('vendor.multiauth.admin.cash.index',compact('type','services','packs','totalamount','monthamount','todayamount','occasion_type','menu_type','payment_mode','venue','foc','foc_reasons','focamount','checksp','checkgc','events'));
	}
	function changeassignment(Request $request) {
		$order_id = $request['order_id'];
		$gondolier = $request['gondolier'];
		 $date5 = date("Y-m-d H:i:s");
		 $delete = DB::table('gondolier_checkins_log')->where('order_id',$order_id)->delete();
            if ($gondolier != "" || isset($gondolier)) {
            	foreach ($gondolier as $key => $value) {
				$gond = DB::table('gondolier_checkins_log')->insert(['gondolier_id' => $value,'order_id' => $order_id,'created_at' => $date5,'updated_at' => $date5]);
			}
         }
         return redirect()->back()->withInput()->with('status','Gondolier changed!');

	}
	 function cash(Request $request) {
     $serviceid = $request['serviceid'];
       $type = $request['type'];
       $amount = $request['amount'];
       $price = $request['price'];
       $tax = $request['tax'];
       $quantity = $request['quantity'];
       $name = $request['name'];
       $phone = $request['phone'];
       $payment_method = $request['payment_method'];
       $email = "";
       $date = $request['date'];
       $time = $request['time'];
       $famount = $request['famount'];
       $foccheckbox = $request['foccheckbox'];
       $authorised = $request['authorised'];
       $foc_reason = $request['foc_reason'];
       $percent = $request['percent'];
       $service = array();
       $payment_method = $request['payment_method'];
       $prevamount = $request['prevamount'];
       $bookmyshow = $request['bookmyshow'];
       $transtype = $request['transtype'];
       $services = "";
       $ptype = "";

       foreach ($serviceid as $key => $value) {
        list($a, $b) = explode("_", $value);
        if ($a=="s") {
        	$canal_id = $request['canals'.$b];
          $service =  Helper::get_services_details($b);
          $get_canals = Helper::get_canals($canal_id);
          foreach ($service as $k => $v) {
          	$services .= $v->service_name.",";
          $pack_type = ""; $occasion_type = ""; $occasiontext = "";
          $get_rates = Helper::get_rates($b, $date, $time,$quantity[$key],$canal_id,'service',$occasion_type,$transtype);
          
             $nprice = $get_rates[0]['price'];
             $ntax = $get_rates[0]['tax_amount'];
        
           $discount = 0;  $discountprice = 0;  $discounttax = 0;
          if ($foccheckbox=="on") { 	
         	$discountprice = $nprice * $percent /100;
         	$discounttax = $ntax * $percent /100;
         	$ntax = $ntax - $discounttax;
         	$nprice = $nprice - $discountprice;
          }

          $cart[] = array('service_name' => $v->service_name,'service_id' => $b,'quantity' => $quantity[$key],
        'time' => $time,'date' => $date,'canal' => $get_canals,'canal_id' => $canal_id,'type' => 'service','amount' => $famount,'price' => $nprice,'tax' => $ntax,'icon' => $v->icon,'pack_type' => $pack_type,'occasion_type' => $occasion_type,'occassion_text' => $occasiontext);
        }
        $ptype = "service";
        }elseif($a=="e") {
        	 $events = Helper::get_event_by_id($b);
        	 $event_name = "";
        	 foreach ($events as $k => $v) {
        	 	$event_name = $v->event_name;
        	 	$get_rates = Helper::get_rates($b, $date, $time,$quantity[$key],'0','events','0',$transtype);
          
             $nprice = $get_rates[0]['price'];
             $ntax = $get_rates[0]['tax_amount'];
             
         
        	 	  $cart[] = array('event_name' => $event_name,'event_alias' => $v->event_alias,'service_id' => $b,'quantity' => $quantity[$key],
        'event_time' => $v->start_time,'date' => $v->start_date,'canal' => '','canal_id' => '','type' => 'events','amount' => $famount,'price' => $nprice,'tax_amount' => $ntax,'icon' => '','pack_type' => '','occasion_type' => '','occassion_text' => '', 'name' => $name,'email' => $email,'phone' => $phone);
        	 	 
        	 }
        	
         $ptype = "events";

       


        }else {
        	$ptype = "packs";
          $service = Helper::get_packs_details($b);
          $canal_id = $request['canalp'.$b];
           $get_canals = Helper::get_canals($canal_id);
          foreach ($service as $k => $v) {
          	$services .= $v->pack_name.",";
            $pack_type = $v->pack_type;
            $occasion_type = "";
            	$occasiontext = "";  

            if ($pack_type == "occasional") {
              $occasion_type = $request['occasion_type'];
              $get_occasion = DB::table('occasion_type')->where('id',$request['occasion_type'])->get();
              foreach ($get_occasion as $key => $value) {
                    $occasiontext = $value->type." - ".$value->cuisine;
                    $time = $value->timerange;
              }

            }

            $get_rates = Helper::get_rates($b, $date, $time,$quantity[$key],$canal_id,'packs',$occasion_type,$transtype);
             $namount = $get_rates[0]['final_price'];
             $nprice = $get_rates[0]['price'];
             $ntax = $get_rates[0]['tax_amount'];
           $discount = 0;  $discountprice = 0;  $discounttax = 0;
          if ($foccheckbox=="on") {
         	$discountprice = $nprice * $percent /100;
         	$discounttax = $ntax * $percent /100;
         	$ntax = $ntax - $discounttax;
         	$nprice = $nprice - $discountprice;

          }
          $cart[] = array('service_name' => $v->pack_name,'service_id' => $b,'quantity' => $quantity[$key],
        'time' => $time,'date' => $date,'canal' => $get_canals,'canal_id' => $canal_id,'type' => 'packs','amount' => $famount,'price' => $nprice,'tax' => $ntax,'icon' => $v->icon,'pack_type' => $pack_type,'occasion_type' => $occasion_type,'occassion_text' => $occasiontext);
        }
      }
        
      }


      if ($ptype=="events") {

      	   Session::put('event', $cart);  
          $status = "success";
      	  $payment_id = md5(microtime(true).mt_Rand());
      	  $event_name = "";
      	  foreach ($cart as $key => $value) {
      	  	 $event_name = $value['event_name'];
      	  }

          $status = "success";
      	 $payment_id = md5(microtime(true).mt_Rand());
         Helper::booking_event_process($name,$email,,"+91".$phone,$event_name,$amount,'cash',$payment_id,'INR','events',$status); 


      }else {
      	 $purpose = rtrim($services,',');
       Session::put('cart', $cart);  
       $payment_id = md5(microtime(true).mt_Rand());
        
      
      $order_id =  Helper::booking_process($name,$email,"+91".$phone,$purpose,$famount,$payment_method,$payment_id,'INR',$payment_method,'success',$foccheckbox,$authorised,$foc_reason,$percent);

      if (isset($bookmyshow) || $bookmyshow != "") {
      	$bmsinsert = DB::table('bookings_bms')->insert(['order_id' => $order_id,'reference_id' => $bookmyshow,'identifier' => $payment_method,'created_at' => $date, 'updated_at' => $date]);
      }
      
      $focmanger = DB::table('foc')->where('id',$authorised)->get();
      $focemail = ""; $fophone = "";
      foreach ($focmanger as $key => $value) {
      	$focemail = $value->email;
      	$fophone = $value->phone;
      
      }
    //  $url =  "http://".$_SERVER['SERVER_NAME'];
     // $url2 = Bitly::getUrl($url.'/public/admin/foc/approve/'.Crypt::encrypt($order_id));
      $focontent = "You have got a new FOC request, please check your email for approving or rejecting the same.";
      if ($foccheckbox=="on") {
       $date = date("Y-m-d H:i:s"); 
        $dbforfoc = DB::table('foc_requests')->insert(['order_id' => $order_id,'authorized_by' => $authorised,'percent' => $percent,'reason' => $foc_reason,'status' => 'hold','ramount' => $prevamount,'created_at' => $date, 'updated_at' => $date]);         
        Mail::to($focemail)->send(new FocMail($order_id, $authorised,$percent,$foc_reason,$prevamount));          
        Helper::send_otp($fophone,$focontent);
      }
      }


      return redirect('admin/status_s');
     
  }
  public function get_url() {
  	$url = env('APP_URL').'/public/admin/foc/approve/'.Crypt::encrypt($order_id);
  }
  function status_s() {

  	 $status = 'success';
  	 $type = 'web';
  	  $venue = DB::table('venue')->get();     
      return view('vendor.multiauth.admin.cash.status_s', compact('status','type','venue')); 
  }
  function total() {
  	$totalbookings = DB::table('bookings')
        ->where('status','success')
		->where('type','service')		
		->where('payment_method','!=','instamojo')
		->get();

		$type = 'web';

		return view('vendor.multiauth.admin.cash.total', compact('totalbookings','type')); 
  }
  function deletebooking($order_id) {
  	$getid = Crypt::decrypt($order_id);
  	$db = DB::table('bookings')->where('order_id',$getid)->delete();
  	$db2 = DB::table('bookings_packs')->where('order_id',$getid)->delete();
  	$db3 = DB::table('gondolier_checkins_log')->where('order_id',$getid)->delete();
  	return redirect()->back()->withInput()->with('status','Booking deleted successfully!');
  }
  function changecanal(Request $request) {
  	$order_id = $request['order_id'];
  	$canal = $request['canal'];
  	$db = DB::table('bookings')->where('order_id',$order_id)->update(['optional' => $canal]);
  	$db2 = DB::table('bookings_packs')->where('order_id',$order_id)->update(['optional' => $canal]);
  	return redirect()->back()->withInput()->with('status','Canal changed!');
  }
  function topup() {
  	$type = 'web';
  	$status = "success";
  	$denominations = DB::table('pricing_denomination')->get();
  	return view('vendor.multiauth.admin.cash.topup', compact('type','status','denominations')); 
  }
  function topupadd(Request $request) {
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
    $wall_am = $users['wall_am'];
  	
  	$date = date("Y-m-d H:i:s");
    $expiry = date('d-m-Y', strtotime('+12 Month',strtotime($date)));
    $order_id = "GV/TP/".Helper::generatePIN();
    $final_amount = $request['finalamount'];
    $extra = $request['extraamount'];

    $updated_amount = Crypt::decrypt($wall_am) + $final_amount;
  	

  	$data = array('final_amount' => $final_amount,'mainamount' => $amount,'extra' => $extra,'user_id' => $user_id,'order_id' => $order_id,'expiry' => $expiry,'identifier' => 'topup','trans_id' => $payment_id,'payment_method' => 'cash','platform' => 'web','created_at' => $date, 'updated_at' => $date);

  	$updatebalance = DB::table('users')->where('id',$user_id)->update(['wall_am'=> Crypt::encrypt($updated_amount)]);

  	$db = DB::table('wall_history')->insert($data);

  	if ($db) {
  		 $content = "Your GV Pay is recharged with Rs. ".$final_amount.", GV Pay Balance is Rs. ".$updated_amount.". Install the iPhone/Android App: https://l.ead.me/29Ev";
         Helper::send_otp($phone,$content);
  		return redirect()->back()->withInput()->with('status','Wallet recharge successfully');
  	}
  	
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
        }else {
              $user_id = $finduser['id'];
              if ($email == "") {
                $email = $finduser['email'];
              }else {
                $email = $email;
              }
              $updatedate = date("d F Y, h:i A");
              $wall_am = $finduser['wall_am'];
              $updateemail = DB::table('users')->where('id',$user_id)->update(['email' => $email,'name' => $name,'updated_at' => $updatedate]); 
        }
        return array('wall_am' => $wall_am,'user_id' => $user_id);
  }
 
}