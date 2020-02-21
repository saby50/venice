<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Helper;
class PackController extends Controller
{
    function index($type) {
    	 $packs = DB::table('packs')->where('alias',$type)->get();

           foreach ($packs as $key => $value) {
               $pack_type = $value->pack_type;
           }

           if ($pack_type=="hybrid" || $pack_type=="occasional") {
                $service_options = DB::table('service_options')
        ->leftjoin('services','services.id','=','service_options.service_id')
        ->leftjoin('categories','categories.id','=','services.category_id')
        ->select(DB::raw('service_options.*'),
            DB::raw('categories.alias as alias'))
         
        ->get();   
          $menu_type = DB::table('occasion_menu_type')->get();
         $occasion_type = DB::table('occasion_type')->orderBy('position','ASC')->get();  
           }else {
             $service_options = DB::table('service_options')
        ->leftjoin('services','services.id','=','service_options.service_id')
        ->leftjoin('categories','categories.id','=','services.category_id')
        ->select(DB::raw('service_options.*'),
            DB::raw('categories.alias as alias'))
        ->where('categories.alias', $pack_type)
        ->get();     
           }
        $venue = DB::table('venue')->get();
        $gallery = DB::table('packs_gallery')->where('pack_id', $packs[0]->id)->get();
        $inclusions = DB::table('packs_inclusions')->where('pack_id', $packs[0]->id)->get();
        $packs_services = DB::table('packs_services')
        ->join('services','packs_services.service_id','=','services.id')
        ->select(DB::raw('services.*'),
         DB::raw('packs_services.quantity as service_quantity'))
        ->where('pack_id', $packs[0]->id)->get();
        $featured2 = DB::table('packs')->inRandomOrder()->where('pack_type','!=','leads')->where('pack_type','!=','leads3')->where('packs.id','!=',$packs[0]->id)->limit(2)->get();

       $featured = DB::table('services')->inRandomOrder()->limit(2)->get();
    	return view('packs.index',compact('packs','venue','gallery','service_options','inclusions','packs_services','featured','featured2','menu_type','occasion_type'));
    }
    function commercial() {
       $packs = DB::table('packs')->where('alias','commercial')->get();

           foreach ($packs as $key => $value) {
               $pack_type = $value->pack_type;
           }

           if ($pack_type=="hybrid" || $pack_type=="occasional") {
                $service_options = DB::table('service_options')
        ->leftjoin('services','services.id','=','service_options.service_id')
        ->leftjoin('categories','categories.id','=','services.category_id')
        ->select(DB::raw('service_options.*'),
            DB::raw('categories.alias as alias'))
         
        ->get();   
          $menu_type = DB::table('occasion_menu_type')->get();
         $occasion_type = DB::table('occasion_type')->orderBy('position','ASC')->get();  
           }else {
             $service_options = DB::table('service_options')
        ->leftjoin('services','services.id','=','service_options.service_id')
        ->leftjoin('categories','categories.id','=','services.category_id')
        ->select(DB::raw('service_options.*'),
            DB::raw('categories.alias as alias'))
        ->where('categories.alias', $pack_type)
        ->get();     
           }
        $venue = DB::table('venue')->get();
        $gallery = DB::table('packs_gallery')->where('pack_id', $packs[0]->id)->get();
        $inclusions = DB::table('packs_inclusions')->where('pack_id', $packs[0]->id)->get();
        $packs_services = DB::table('packs_services')
        ->join('services','packs_services.service_id','=','services.id')
        ->select(DB::raw('services.*'),
         DB::raw('packs_services.quantity as service_quantity'))
        ->where('pack_id', $packs[0]->id)->get();
        $featured2 = DB::table('packs')->inRandomOrder()->where('pack_type','!=','leads')->where('pack_type','!=','leads3')->where('packs.id','!=',$packs[0]->id)->limit(2)->get();

       $featured = DB::table('services')->inRandomOrder()->limit(2)->get();
      return view('packs.index',compact('packs','venue','gallery','service_options','inclusions','packs_services','featured','featured2','menu_type','occasion_type'));
    }


   function get_packs_price($quantity, $pack_id) {
     $data = Helper::get_packs_price($quantity,$pack_id);
     return $data;
   }
}
