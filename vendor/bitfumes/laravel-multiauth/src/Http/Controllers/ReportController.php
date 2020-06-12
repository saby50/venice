<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Carbon\Carbon;
use Helper;
use Hash;
class ReportController extends Controller
{

  public function __construct()
  {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
  }

  function unit_revenue($datetype,$unit_id,$custom) {
       $filters = DB::table('filter_types')->where('page_name','unit_revenue')->get();
       $units = DB::table('units')->get();
       $type="web";
      return view('vendor.multiauth.admin.reports.unit_revenue', compact('datetype','filters','type','units','unit_id','custom'));
  }
  function checkinuser($unit_id) {
    $type= "web";
    $data = DB::table('user_checkins')
            ->where('unit_id', $unit_id)
            ->get();
            
    return view('vendor.multiauth.admin.reports.checkinuser', compact('type','data'));
  }

  function checkins($parameter) {
    $type= "web";

    $filters = DB::table('filter_types')
    ->where('page_name','bookings')
    ->where('filter_value','!=','custom')
    ->get();
    
    return view('vendor.multiauth.admin.reports.checkins', compact('type','filters','parameter'));
  }

	function index($datatype,$date_type) {
		$type = "web";
		$data = array();
		$servicelist = "";
		 $services = DB::table('services')->get();  
        $packs = DB::table('packs')->get();  
        $events = DB::table('events')->get();
       $famount = 0;
        if ($datatype=="transaction" && $date_type=="all") {
        	  $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))  

           ->where('bookings.type','service')
           
            ->orderBy('bookings.created_at','desc')
            ->get();


        $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))  
               
           ->orderBy('bookings_packs.created_at','desc')
          ->get();

          foreach ($db as $key => $value) {
      $service_id = $value->service_id;
      $optional = $value->optional;
      $order_id = $value->order_id;
      $name = $value->name;
      $phone = $value->phone;
      $email = $value->email;
      $service_name = $value->service_name;
      $created_at = $value->created_at;
      $famount += $value->amount;
     
       $data[$order_id][] = array('name' =>  $name,'email' => $email,'phone' => $phone,'service_name' => $service_name,'created_at' => $created_at,'order_id' => $order_id,'famount' => $famount);

       foreach ($services as $k => $v) {
       	$amount = $value->price + $value->tax;
       

      if ($v->id==$service_id) {
   	 		$data[$order_id]['services'][] = array('price' =>  $amount,'type'=>'service','service_id' => $value->service_id);
   	     }else {
   	     	
   	     }
       } 
    }
  
    foreach ($db2 as $key => $value) {
      $service_id = $value->pack_id;
      $optional = $value->optional;
     $order_id = $value->order_id;
      $name = $value->name;
      $phone = $value->phone;
      $email = $value->email;
      $pack_name = $value->pack_name;
      $created_at = $value->created_at;
      $famount += $value->amount;
       $data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $pack_name,'created_at' => $value->created_at,'order_id' => $value->order_id,'famount' => $famount); 

      

       foreach ($packs as $k => $v) {
         $famount += $value->amount;


       	 if ($v->id==$service_id) {
   	 		$data[$order_id]['services'][] = array('price' =>    $value->price + $value->tax,'type'=>'packs','service_id' => $value->pack_id);
   	     }else {
   	     	
   	     }


       } 
   
    } 
        } elseif ($datatype=="transaction" && $date_type=="todays") {
            $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))  

           ->where('bookings.type','service')
           ->whereDate('bookings.created_at', Carbon::today())
            ->orderBy('bookings.created_at','desc')
            ->get();


        $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))  
           ->whereDate('bookings_packs.created_at',Carbon::today())    
           ->orderBy('bookings_packs.created_at','desc')
          ->get();

          foreach ($db as $key => $value) {
      $service_id = $value->service_id;
      $optional = $value->optional;
      $order_id = $value->order_id;
      $name = $value->name;
      $phone = $value->phone;
      $email = $value->email;
      $service_name = $value->service_name;
      $created_at = $value->created_at;
      $famount += $value->amount;
     
       $data[$order_id][] = array('name' =>  $name,'email' => $email,'phone' => $phone,'service_name' => $service_name,'created_at' => $created_at,'order_id' => $order_id,'famount' => $famount);

       foreach ($services as $k => $v) {
        $amount = $value->price + $value->tax;
       

         if ($v->id==$service_id) {
        $data[$order_id]['services'][] = array('price' =>  $amount,'type'=>'service','service_id' => $value->service_id);
         }else {
          
         }

       


       } 
      
   
    }
  
    foreach ($db2 as $key => $value) {
      $service_id = $value->pack_id;
      $optional = $value->optional;
     $order_id = $value->order_id;
      $name = $value->name;
      $phone = $value->phone;
      $email = $value->email;
      $pack_name = $value->pack_name;
      $created_at = $value->created_at;
      $famount += $value->amount;
       $data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $pack_name,'created_at' => $value->created_at,'order_id' => $value->order_id,'famount' => $famount); 

      

       foreach ($packs as $k => $v) {
         $famount += $value->amount;


         if ($v->id==$service_id) {
        $data[$order_id]['services'][] = array('price' =>    $value->price + $value->tax,'type'=>'packs','service_id' => $value->pack_id);
         }else {
          
         }


       } 
   
    } 
        }elseif ($datatype=="transaction" && $date_type=="monthly") {
           $now = Carbon::now();
                $month = $now->month;
            $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))  

           ->where('bookings.type','service')
            ->whereMonth('bookings.created_at', $month) 
            ->orderBy('bookings.created_at','desc')
            ->get();


        $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))  
           ->whereMonth('bookings_packs.created_at', $month)   
           ->orderBy('bookings_packs.created_at','desc')
          ->get();

          foreach ($db as $key => $value) {
      $service_id = $value->service_id;
      $optional = $value->optional;
      $order_id = $value->order_id;
      $name = $value->name;
      $phone = $value->phone;
      $email = $value->email;
      $service_name = $value->service_name;
      $created_at = $value->created_at;
      $famount += $value->amount;
     
       $data[$order_id][] = array('name' =>  $name,'email' => $email,'phone' => $phone,'service_name' => $service_name,'created_at' => $created_at,'order_id' => $order_id,'famount' => $famount);

       foreach ($services as $k => $v) {
        $amount = $value->price + $value->tax;
       

         if ($v->id==$service_id) {
        $data[$order_id]['services'][] = array('price' =>  $amount,'type'=>'service','service_id' => $value->service_id);
         }else {
          
         }

       


       } 
      
   
    }
  
    foreach ($db2 as $key => $value) {
      $service_id = $value->pack_id;
      $optional = $value->optional;
     $order_id = $value->order_id;
      $name = $value->name;
      $phone = $value->phone;
      $email = $value->email;
      $pack_name = $value->pack_name;
      $created_at = $value->created_at;
      $famount += $value->amount;
       $data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $pack_name,'created_at' => $value->created_at,'order_id' => $value->order_id,'famount' => $famount); 

      

       foreach ($packs as $k => $v) {
         $famount += $value->amount;


         if ($v->id==$service_id) {
        $data[$order_id]['services'][] = array('price' =>    $value->price + $value->tax,'type'=>'packs','service_id' => $value->pack_id);
         }else {
          
         }


       } 
   
    } 
        }elseif ($datatype=="transaction" && $date_type=="yesterday") {
          $month = new Carbon('yesterday');
          
            $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))  

           ->where('bookings.type','service')
            ->whereDate('bookings.created_at', $month)    
            ->orderBy('bookings.created_at','desc')
            ->get();


        $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))  
           ->whereDate('bookings_packs.created_at', $month)       
           ->orderBy('bookings_packs.created_at','desc')
          ->get();

          foreach ($db as $key => $value) {
      $service_id = $value->service_id;
      $optional = $value->optional;
      $order_id = $value->order_id;
      $name = $value->name;
      $phone = $value->phone;
      $email = $value->email;
      $service_name = $value->service_name;
      $created_at = $value->created_at;
      $famount += $value->amount;
     
       $data[$order_id][] = array('name' =>  $name,'email' => $email,'phone' => $phone,'service_name' => $service_name,'created_at' => $created_at,'order_id' => $order_id,'famount' => $famount);

       foreach ($services as $k => $v) {
        $amount = $value->price + $value->tax;
       

         if ($v->id==$service_id) {
        $data[$order_id]['services'][] = array('price' =>  $amount,'type'=>'service','service_id' => $value->service_id);
         }else {
          
         }

       


       } 
      
   
    }
  
    foreach ($db2 as $key => $value) {
      $service_id = $value->pack_id;
      $optional = $value->optional;
     $order_id = $value->order_id;
      $name = $value->name;
      $phone = $value->phone;
      $email = $value->email;
      $pack_name = $value->pack_name;
      $created_at = $value->created_at;
      $famount += $value->amount;
       $data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $pack_name,'created_at' => $value->created_at,'order_id' => $value->order_id,'famount' => $famount); 

      

       foreach ($packs as $k => $v) {
         $famount += $value->amount;


         if ($v->id==$service_id) {
        $data[$order_id]['services'][] = array('price' =>    $value->price + $value->tax,'type'=>'packs','service_id' => $value->pack_id);
         }else {
          
         }


       } 
   
    } 
        }elseif ($datatype=="transaction" && $date_type=="lastmonth") {
           $month = new Carbon('last month');
            $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))  

           ->where('bookings.type','service')
            ->whereMonth('bookings.created_at', $month) 
            ->orderBy('bookings.created_at','desc')
            ->get();


        $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))  
           ->whereMonth('bookings_packs.created_at', $month)   
           ->orderBy('bookings_packs.created_at','desc')
          ->get();

          foreach ($db as $key => $value) {
      $service_id = $value->service_id;
      $optional = $value->optional;
      $order_id = $value->order_id;
      $name = $value->name;
      $phone = $value->phone;
      $email = $value->email;
      $service_name = $value->service_name;
      $created_at = $value->created_at;
      $famount += $value->amount;
     
       $data[$order_id][] = array('name' =>  $name,'email' => $email,'phone' => $phone,'service_name' => $service_name,'created_at' => $created_at,'order_id' => $order_id,'famount' => $famount);

       foreach ($services as $k => $v) {
        $amount = $value->price + $value->tax;
       

         if ($v->id==$service_id) {
        $data[$order_id]['services'][] = array('price' =>  $amount,'type'=>'service','service_id' => $value->service_id);
         }else {
          
         }

       


       } 
      
   
    }
  
    foreach ($db2 as $key => $value) {
      $service_id = $value->pack_id;
      $optional = $value->optional;
     $order_id = $value->order_id;
      $name = $value->name;
      $phone = $value->phone;
      $email = $value->email;
      $pack_name = $value->pack_name;
      $created_at = $value->created_at;
      $famount += $value->amount;
       $data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $pack_name,'created_at' => $value->created_at,'order_id' => $value->order_id,'famount' => $famount); 

      

       foreach ($packs as $k => $v) {
         $famount += $value->amount;


         if ($v->id==$service_id) {
        $data[$order_id]['services'][] = array('price' =>    $value->price + $value->tax,'type'=>'packs','service_id' => $value->pack_id);
         }else {
          
         }


       } 
   
    } 
        }elseif($datatype=="activity" && $date_type == "all") {

        	// Declare two dates 
$Date1 = date('d-m-Y', strtotime('-1 Month'));
$Date2 = date('d-m-Y');
  
// Declare an empty array 
$daterange = array(); 
  
// Use strtotime function 
$Variable1 = strtotime($Date1); 
$Variable2 = strtotime($Date2); 
  
// Use for loop to store dates into array 
// 86400 sec = 24 hrs = 60*60*24 = 1 day 
for ($currentDate = $Variable1; $currentDate <= $Variable2;  
                                $currentDate += (86400)) { 
                                      
$Store = date('Y-m-d', $currentDate); 
$daterange[] = $Store; 
} 

        }elseif($datatype=="activity" && $date_type != "all") {
 list($from, $to) = explode('_', $date_type);
        	// Declare two dates 
$Date1 = $from;

  $Date2 = $to;
// Declare an empty array 
$daterange = array(); 
  
// Use strtotime function 
$Variable1 = strtotime($Date1); 
$Variable2 = strtotime($Date2); 
  
// Use for loop to store dates into array 
// 86400 sec = 24 hrs = 60*60*24 = 1 day 
for ($currentDate = $Variable1; $currentDate <= $Variable2;  
                                $currentDate += (86400)) { 
                                      
$Store = date('Y-m-d', $currentDate); 
$daterange[] = $Store; 
} 

        }elseif($datatype=="transaction" && $date_type != "all")  {

        	  list($from, $to) = explode('_', $date_type);

		   if ($from==$to) {
             $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))  

        ->where('bookings.type','service')
        ->whereDate('bookings.created_at', $from) 
        ->whereDate('bookings.created_at', $to)                      
            ->orderBy('bookings.created_at','desc')
            ->get();


        $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))  
          ->whereDate('bookings_packs.created_at', $from) 
        ->whereDate('bookings_packs.created_at', $to)  
           ->orderBy('bookings_packs.created_at','desc')
          ->get();
        }else {
             $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))  

        ->where('bookings.type','service')
        ->whereBetween('bookings.created_at', [$from, $to])                    
            ->orderBy('bookings.created_at','desc')
            ->get();


        $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))  
         ->whereBetween('bookings_packs.created_at', [$from, $to])  
           ->orderBy('bookings_packs.created_at','desc')
          ->get();
        }
          foreach ($db as $key => $value) {
      $service_id = $value->service_id;
      $optional = $value->optional;
      $order_id = $value->order_id;
      $name = $value->name;
      $phone = $value->phone;
      $email = $value->email;
      $service_name = $value->service_name;
      $created_at = $value->created_at;
      $famount += $value->amount;
     
       $data[$order_id][] = array('name' =>  $name,'email' => $email,'phone' => $phone,'service_name' => $service_name,'created_at' => $created_at,'order_id' => $order_id,'famount' => $famount);

       foreach ($services as $k => $v) {
       	$amount = $value->price + $value->tax;

      	 if ($v->id==$service_id) {
   	 		$data[$order_id]['services'][] = array('price' =>  $amount,'type'=>'service','service_id' => $value->service_id);
   	     }else {
   	     	
   	     }

       


       } 
      
   
    }
  
    foreach ($db2 as $key => $value) {
      $service_id = $value->pack_id;
      $optional = $value->optional;
     $order_id = $value->order_id;
      $name = $value->name;
      $phone = $value->phone;
      $email = $value->email;
      $pack_name = $value->pack_name;
      $created_at = $value->created_at;
       $famount += $value->amount;
       $data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $pack_name,'created_at' => $value->created_at,'order_id' => $value->order_id,'famount' => $famount); 

      

       foreach ($packs as $k => $v) {


       	 if ($v->id==$service_id) {
   	 		$data[$order_id]['services'][] = array('price' =>    $value->price + $value->tax,'type'=>'packs','service_id' => $value->pack_id);
   	     }else {
   	     	
   	     }


       } 
   
    }  
       
		
	}
  $paymentcat = DB::table('filter_types')
        ->where('page_name','booking2')
        ->where('filter_value','!=','all')
         ->where('filter_value','!=','online')
        ->where('filter_value','!=','offline')
        ->get();
  $filters = DB::table('filter_types')->where('page_name','bookings')->get();
	return view('vendor.multiauth.admin.reports.index', compact('type','data','services','packs','events','datatype','date_type','daterange','filters','paymentcat'));
        }



}