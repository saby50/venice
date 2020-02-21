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
class ApproveController extends Controller
{
	function approve($order_id) {
      $getid = Crypt::decrypt($order_id);
      $date = date("d F Y, h:i A");
	  $db = DB::table('bookings')->where('order_id',$getid)->update(['status'=>'success', 'updated_at' => $date]);
	  $db2 = DB::table('bookings_packs')->where('order_id',$getid)->update(['status'=>'success', 'updated_at' => $date]);

	  $dbforfoc = DB::table('foc_requests')->where('order_id',$getid)->update(['status' => 'success','updated_at' => $date]);

	  $services = Helper::get_service_details($getid);
	  $packs = Helper::get_pack_details($getid);

	  $purpose = ""; 
	  $ndate = ""; 
	  $quantity = ""; 
	  $time="";
	  $pack_type = "";
	  $alias = "";
	  $option_id = "";
	  $phone = "";
	  foreach ($services as $key => $value) {
	  	$purpose.= $value->service_name.", ";
	  	$quantity = $value->quantity;
	  	$amount = $value->amount;
	  	$time = $value->time;
	  	$alias = $value->alias;
	  	$option_id = $value->optional;
	  	$phone = $value->phone;
	  }
	   if ($alias=="gondola") {
          $option_id = $option_id;
        }else {
          $option_id = "";
        }

	  foreach ($packs as $key => $value) {
	  	$purpose.= $value->pack_name.", ";
	  	$ndate = $value->date;
	  	$pack_type = $value->pack_type;
	  	$occasion_type = $value->occasion_type;
	  }
	  if ($pack_type=="occasional") {
	  	$getoccassion = DB::table('occasion_type')->where('id',$occasion_type)->get();
	  	foreach ($getoccassion as $key => $value) {
	  		$occassion_text = $value->type." - ".$value->cuisine;
	  	}
          $occassion_text = " - ".$occassion_text;
      }else {
          $occassion_text = "";
      }
       $get_canals = Helper::get_canals($option_id);
      $content = "";
	  if ($db) {
	  	$status = "success";
	  	$content .= "You purchased ".$purpose."".$occassion_text." on ".date('d F',strtotime($ndate)).". Order ID: ".$getid.", Paid: Rs. ".$amount.", Arrival Time: ".$time." on ".date('d F',strtotime($ndate));
              if ($get_canals !="") {
                $content .= ", Canal: ".$get_canals;
              }
             
              $content .= ". The Grand Venice";

        Helper::send_otp($phone,$content);      
	  }else {
         $status = "failed";
	  }

	  return view('vendor.multiauth.admin.approve', compact('status')); 
	}

	function reject($order_id) {
      $getid = Crypt::decrypt($order_id);
      $date = date("d F Y, h:i A");
      $checkstatus = DB::table('bookings')->where('order_id',$getid)->get();
      $status = "";
      foreach ($checkstatus as $key => $value) {
      	$status = $value->status;
      }
      if ($status=="hold") {
      	 $datefoc = date("Y-m-d H:i:s"); 
      	$db = DB::table('bookings')->where('order_id',$getid)->update(['status'=>'reject', 'updated_at' => $date]);
	    $db2 = DB::table('bookings_packs')->where('order_id',$getid)->update(['status'=>'reject', 'updated_at' => $date]);
       $dbforfoc = DB::table('foc_requests')->where('order_id',$getid)->update(['status' => 'reject','updated_at' => $datefoc]);
       	$status = "rejected";
      }else {
      		$status = "failed";
      }
	  
	  

	  return view('vendor.multiauth.admin.approve', compact('status')); 
	}

}