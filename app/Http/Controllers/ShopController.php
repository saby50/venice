<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ShopController extends Controller
{
    function index() {
    	$data = DB::table('shops')->orderBy('shops.priorty')->get();
    	$featured = DB::table('services')->inRandomOrder()->limit(2)->get();
        $featured2 = DB::table('packs')->inRandomOrder()->where('pack_type','!=','leads')->where('pack_type','!=','leads3')->limit(2)->get();
        $categories = DB::table('shop_category')->get();
    	return view('shops/index', compact('data','featured','featured2','categories'));
    }
    function shop($alias) {
      $data = DB::table('shops')
      ->leftjoin('shop_category','shops.shop_category_id','=','shop_category.id')
      ->select(DB::raw('shops.*'),
      	DB::raw('shop_category.category_name as category_name'))
      ->where('shop_alias',$alias)
      ->get();
      $shop_id = 0;
      foreach ($data as $key => $value) {
      	$shop_id  = $value->id;
      }
      $featured = DB::table('services')->inRandomOrder()->limit(2)->get();
        $featured2 = DB::table('packs')->inRandomOrder()->where('pack_type','!=','leads')->where('pack_type','!=','leads3')->limit(2)->get();
      $gallery = DB::table('shop_gallery')->where('shop_id', $shop_id)->get();
      return view('shops/single-shop', compact('data','gallery','featured','featured2'));
    }
    function get_logos($alphabet,$floors) {
      $alphabet = urldecode($alphabet);
      $floors = urldecode($floors);
      if ($alphabet=="all" && $floors=="all") {
        $db = DB::table('shops')
        ->orderBy('shops.priorty','ASC')
        ->where('shops.suspend','no')
        ->get();
      }else if($alphabet!="all" && $floors=="all") {
        $db = DB::table('shops')
        ->where('shop_name', 'LIKE', $alphabet.'%')
        ->where('shops.suspend','no')
        ->orderBy('shops.priorty','ASC')
        ->get();

      }else if($alphabet=="all" && $floors!="all") {
        $db = DB::table('shops')
        ->where('floor_level', $floors)
        ->where('shops.suspend','no')
        ->orderBy('shops.priorty','ASC')
        ->get();

      }else {
        $db = DB::table('shops')
        ->where('shop_name', 'LIKE', $alphabet.'%')
        ->orderBy('shops.priorty','ASC')
        ->where('shops.suspend','no')
        ->where('floor_level', $floors)
        ->get();
      }
       
       $data = array();
       foreach ($db as $key => $value) {
         $shop_name = $value->shop_name;
         $shop_alias = $value->shop_alias;
         $logo = $value->logo;
         $data[] = array('shop_name' => $shop_name,'shop_alias' => $shop_alias ,'logo' => $logo);
       }
       return $data;
    }
}
