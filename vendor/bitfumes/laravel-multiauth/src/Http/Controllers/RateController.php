<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Helper;
class RateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
	function index($category_id) {
    $data = array();
    if ($category_id=="packs") {
        $data = DB::table('rates')
      ->join('packs','packs.id','=','rates.service_id')
      ->select(DB::raw('rates.*'),
        DB::raw('packs.pack_name as service_name'))
      ->where('rates.type','packs')
      ->orderBy('rates.id','desc')
      ->get();

    }else {
        $data = DB::table('rates')
      ->join('services','services.id','=','rates.service_id')
      ->select(DB::raw('rates.*'),
        DB::raw('services.service_name'))
      ->where('services.category_id',$category_id)
      ->where('rates.type','service')
      ->orderBy('rates.id','desc')
      ->get();
    }

	
    $categories = Helper::get_all_categories();
     $type = "web";
	  return view('vendor.multiauth.admin.rates.index', compact('data', 'categories','category_id','type'));
	}

	function create($category_id) {
    if ($category_id=="packs") {
      $services = DB::table('packs')->get();
    }else {
      $services = DB::table('services')->where('category_id',$category_id)->get();
    }
    $menu_type = DB::table('occasion_menu_type')->get();
      $occasion_type = DB::table('occasion_type')->get();
	   
	   $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
      $type = "web";
	   return view('vendor.multiauth.admin.rates.create', compact('services','days','category_id','menu_type','occasion_type','type'));
	}

	function add(Request $request) {
      $from = $request['from'];
      $to = $request['to'];
      $service_id = $request['service_id'];
      $rates = $request['rates'];
      $days = $request['days'];
      $date = date("Y-m-d H:i:s");
      $quantity = $request['quantity'];
      $price = $request['price'];
      $type = $request['type'];
      $category_id = $request['category_id'];
      $occasion_type = $request['occasion_type'];
      $rate_type = $request['rate_type'];
      

      if ($type=="packs") {
        $type = "packs";
      }else{

        $type = "service";

      }


      $wdays = "";
      foreach ($days as $key => $value) {
      	$wdays .= $value.",";
      }

      $db = DB::table('rates')->insert(['fromtime' => $from, 'totime' => $to, 'service_id' => $service_id ,'rates' => $rates, 'days' => $wdays,'type' => $type,'occasion_type' => $occasion_type,'rate_type' => $rate_type,'created_at' => $date, 'updated_at' => $date]);
      $rate_id = DB::getPdo()->lastInsertId();      
      foreach ($quantity as $key => $value) {
        if ($value!="") {
         $db2 = DB::table('rate_conditions')->insert(['quantity' => $value, 'price' => $price[$key], 'rate_id' => $rate_id,'created_at' => $date,'updated_at' => $date]);
        }
      }
      if ($db) {
      	$notification = "status";
        if ($type=="packs") {
          $category_id = "packs";
        }else {
          $category_id = $category_id;
        }
           return redirect('admin/rates/'.$category_id)->withInput()->with($notification,"Rate Created");
       }
	}
	function delete($id) {
     $db = DB::table('rates')->where('id', $id)->get();
	   $delete = DB::table('rates')->where('id', $id)->delete();
      if ($delete) {
      	$notification = "status";
           return redirect()->back()->withInput()->with($notification,"Rate card deleted");
      }

	}
	function edit($id,$category_id) {
	    if ($category_id=="packs") {
      $services = DB::table('packs')->get();
    }else {
      $services = DB::table('services')->where('category_id',$category_id)->get();
    }
	   $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
	   $rates = DB::table('rates')->where('id',$id)->get();
     $conditions = DB::table('rate_conditions')->where('rate_id',$id)->get();
     $menu_type = DB::table('occasion_menu_type')->get();
      $occasion_type = DB::table('occasion_type')->get();
       $type = "web";
	   return view('vendor.multiauth.admin.rates.edit', compact('services','days','rates','conditions','id','category_id','menu_type','occasion_type','type'));
	}

  function update(Request $request) {
    $rate_id = $request['rate_id'];
     $from = $request['from'];
      $to = $request['to'];
      $service_id = $request['service_id'];
      $rates = $request['rates'];
      $days = $request['days'];
      $date = date("Y-m-d H:i:s");
      $quantity = $request['quantity'];
      $price = $request['price'];
      $type = $request['type'];
      $category_id = $request['category_id'];
      $occasion_type = $request['occasion_type'];
      $rate_type = $request['rate_type'];
     
      if ($type=="packs") {
        $pack_type = "";
        $type = "packs";
         $get_packs = Helper::get_packs_details($service_id);

         foreach ($get_packs as $key => $value) {
        $pack_type = $value->pack_type;
        }

        if ($pack_type=="occasional") {
          $occasion_type = $occasion_type;
        }
      }else{
        $type = "service";
        $occasion_type = 0;
      }

     

      $wdays = "";
      foreach ($days as $key => $value) {
        $wdays .= $value.",";
      }

      $delete = DB::table('rate_conditions')->where('rate_id',$rate_id)->delete();

      $db = DB::table('rates')->where('id', $rate_id)->update(['fromtime' => $from, 'totime' => $to, 'service_id' => $service_id ,'rates' => $rates, 'days' => $wdays,'type' => $type,'occasion_type' => $occasion_type,'rate_type' => $rate_type,'created_at' => $date, 'updated_at' => $date]);
      if ($quantity != "") {
        foreach ($quantity as $key => $value) {
       $db2 = DB::table('rate_conditions')->insert(['quantity' => $value, 'price' => $price[$key], 'rate_id' => $rate_id,'created_at' => $date,'updated_at' => $date]);
      }
      }
     

      if ($db) {
        $notification = "status";
           return redirect('admin/rates/'.$category_id)->withInput()->with($notification,"Rate Updated");
       }

  }


}