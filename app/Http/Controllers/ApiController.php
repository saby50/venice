<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use Crypt;
use Helper;
class ApiController extends Controller
{
    function get_app_data() {
    	$db = DB::table('versions')->where('platform','android')->get();
    	$db2 = DB::table('maintenance')->where('platform','android')->get();
    	$version = 0.0;
    	foreach ($db as $key => $value) {
    		$version = $value->version;
    	}
    	$maintenance = false;
    	foreach ($db2 as $key => $value) {
    		$maintenance = $value->maintenance;
    		$mainmessage = $value->message;
    	}
    	$data = array('version' => $version,'maintenance' => $maintenance,'mainmessage' => $mainmessage);
    	return $data;
    }
    function get_denom_percent($price) {
        $db = DB::table('pricing_extra_percentage')->where('range_from','<=',$price)->where('range_to','>=',$price)->get();
        $percent = 0;
        foreach ($db as $key => $value) {
            $percent = $value->percent;
        }
        return $percent;
    }
    function search_restaurants(Request $request) {
      $keyword = $request['keyword'];
      $db = DB::table('units')->where('order_food','yes')->where('suspended','no')->where('unit_name', 'like', '%' . $keyword. '%')->get();
      $data = array();
      foreach ($db as $key => $value) {
        $data[] = array('unit_name' => $value->unit_name, 'foodstore' => $value->foodstore, 'price_for_two' => $value->price_for_two,'tags' => $value->tags,'id' => Crypt::encrypt($value->id));
      }
      return $data;
    }
    function search_dish(Request $request) {
      $keyword = $request['keyword'];
      $unit_id = $request['unit_id'];
      $db = DB::table('unit_menu_items')
            ->where('unit_id',$unit_id)
            ->where('status','active')
            ->where('item_name', 'like', '%' . $keyword. '%')
            ->get();
      return $db;
    }
    function get_units() {
         $units = DB::table('units')->where('suspended','no')->orderBy('id','desc')->get();
         return $units;
    }

   
     function get_recive_payment(Request $request) {
         $phone = "+91".$request['phone'];
         $amount = $request['amount'];
         $unit_id = $request['unit_id'];
         $data = Helper::recivepayment_process($phone, $amount, $unit_id);
         return $data;
    }
    
    function check_otp(Request $request) {
         $phone = "+91".$request['phone'];
         $otp = $request['otp'];
         $data  = Helper::checkotp_process($phone, $otp);
         return $data;
    }
    function app() {
        $version_check = DB::table('versions')->get();
    $adversion = 0.0;
    $iosversion = 0.0;
    foreach ($version_check as $key => $value) {
      $platform = $value->platform;
      if ($platform=="android") {
        $adversion =$value->version;
      }
      if ($platform=="ios") {
        $iosversion = $value->version;
      }
     }
       $maintenance = DB::table('maintenance')->get();
    foreach ($maintenance as $key => $value) {
      $platform = $value->platform;
      if ($platform=="android") {
        $admaintenance = $value->maintenance;
        $message = $value->message;
      }
      if ($platform=="ios") {
        $iosmaintenance = $value->maintenance;
      }
    }
     $app_url = "";

     $appstore = DB::table('appstore')->get();
    foreach ($appstore as $key => $value) {
      $platform = $value->platform;
    
      if ($platform=="ios") {
        $app_url = $value->app_url;
      }
    }

    $data = array('adversion' => $adversion,'iosversion' => $iosversion,'admaintenance' => $admaintenance,'iosmaintenance' => $iosmaintenance,'maintenance_message' =>  $message,'app_store_url' => $app_url);
    return $data;
   
    }
     function unit_app() {
        $version_check = DB::table('version_units')->get();
    $adversion = 0.0;
    $iosversion = 0.0;
    foreach ($version_check as $key => $value) {
      $platform = $value->platform;
      if ($platform=="android") {
        $adversion =$value->version;
      }
      if ($platform=="ios") {
        $iosversion = $value->version;
      }
     }
       $maintenance = DB::table('maintenance_units')->get();
    foreach ($maintenance as $key => $value) {
      $platform = $value->platform;
      if ($platform=="android") {
        $admaintenance = $value->maintenance;
        $message = $value->message;
      }
      if ($platform=="ios") {
        $iosmaintenance = $value->maintenance;
      }
    }


    $data = array('adversion' => $adversion,'iosversion' => $iosversion,'admaintenance' => $admaintenance,'iosmaintenance' => $iosmaintenance,'maintenance_message' =>  $message);
    return $data;
   
    }
}
