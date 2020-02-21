<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Helper;
class BookingController extends Controller
{
    function index($type) {

    	$services = DB::table('services')
        ->join('categories','categories.id','=','services.category_id')
        ->select(DB::raw('services.*'),
          DB::raw('categories.category_name as category_name'),
          DB::raw('categories.fromtime as fromtime'),
          DB::raw('categories.totime as totime'),
          DB::raw('categories.id as category_id'),
          DB::raw('services.id as service_id'))
        ->where('services.alias',$type)
    	  ->get();
      $category_id = 0;
    	foreach ($services as $key => $value) {
    		$category_id = $value->category_id;
    		$service_id = $value->service_id;
    	}
      $featured = DB::table('services')->inRandomOrder()->where('services.id','!=',$service_id)->limit(2)->get();
       $featured2 = DB::table('packs')->inRandomOrder()->where('pack_type','!=','leads')->where('pack_type','!=','leads3')->limit(2)->get();
    	$gallery = DB::table('service_gallery')->where('service_id', $service_id)->get();
    	$service_options = DB::table('service_options')->where('service_id', $service_id)->get();  
      $snow_options = DB::table('snow_options')->get();  	
    	return view('booking.index', compact('services','gallery','service_options','type','service_id','featured','featured2','snow_options'));
    }
    function get_rates($service_id, $date, $arrival_time,$quantity,$optional,$type,$occasion_type,$rate_type) {
      $prices = Helper::get_rates($service_id, $date, $arrival_time,$quantity,$optional,$type,$occasion_type,$rate_type);
      return $prices;
    }

   
}
