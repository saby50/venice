<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;
use Helper;
use App\User;
use Auth;
use URL;
class CartController extends Controller
{
    function index() {
     $cart = array();
     if (Session::has('cart')){
       if (Session::get('LAST_ACTIVITY') && (time() - Session::get('LAST_ACTIVITY') > 1800 )) {
          Session:flush();
       }else {
         $cart = Session::get('cart');
       }
     }

       $orderid = "GV/ON/".Helper::generatePIN();
       if (Helper::check_mobile()==1) {
          return view('cart/indexpwa',compact('cart'));
       }else {
         $payment_method = DB::table('payment_method_web')->where('status','active')->get();
        return view('cart/index',compact('cart','payment_method'));
       }
    }
    function add_item(Request $request) {
       $cart = Session::get('cart');
       $type = $request['servicetype'];
       
       if ($type=="service") {
         $db = DB::table('services')->where('id', $request['service_id'])->get();
        
       }else {
        $db = DB::table('packs')->where('id', $request['service_id'])->get();
        
       }
       $service_options = DB::table('service_options')->where('id', $request['canal'])->get();
       $option_name = ""; $service_name = "";
       foreach ($service_options as $key => $value) {
         $option_name = $value->option_name;
       }
        foreach ($db as $key => $value) {
          if ($type=="service") {
             $service_name = $value->service_name;
          }else {
             $service_name = $value->pack_name;
          }
          
        }

        if ($request['pack_type']=="occasional") {
           $get_occasion = DB::table('occasion_type')->where('id',$request['occasion_type'])->get();

        $occasiontext = "";
        foreach ($get_occasion as $key => $value) {
          $occasiontext = $value->type." - ".$value->cuisine;
        }
        }else {
          $occasiontext = "NA";
        }

       
       if(Session::has('cart')) {
           if (count($cart)==0) {
            $cart[] = array('service_name' => $service_name,'service_id' => $request['service_id'],'quantity' => $request['quantity'],
        'time' => $request['timepicker'],'date' => $request['datepicker'],'canal' => $option_name,'canal_id' => $request['canal'],'type' => $type,'amount' =>$request['amount'],'price' => $request['price'],'tax' => $request['taxes'],'icon' => $request['icon'],'pack_type' => $request['pack_type'],'occasion_type' => $request['occasion_type'],'occassion_text' => $occasiontext);
           
        }else {
          $comparetextservice = "";
          $comparetextpacks = "";
          foreach ($cart as &$item) {
            $service_id = $item['service_id'];
            $date = $item['date'];
            $time = $item['time'];
            $comparetextservice .= $service_id."_".$date."_".strtotime($time)."_".$item['canal_id']."_".$item['type'].","; 
            

          }

          $excomparetextservice = explode(',', $comparetextservice);
        

          $reqcomparetextservice = $request['service_id']."_".$request['datepicker']."_".strtotime($request['timepicker'])."_".$request['canal']."_".$type;
        

        
          if (in_array($reqcomparetextservice, $excomparetextservice)) {

            if ($type=="service") {
               foreach ($cart as &$item) {
               if ($item['service_id'] == $request['service_id'] && $item['type']== 'service') {
              $item['quantity'] = $item['quantity'] + $request['quantity'];  
              $rates = Helper::get_rates($request['service_id'],$request['datepicker'],$request['timepicker'],$item['quantity'],$request['canal'],'service','0','online'); 
              }           
             }
            }else {
               foreach ($cart as &$item) {
               if ($item['service_id'] == $request['service_id'] && $item['type']== 'packs') {
              $item['quantity'] = $item['quantity'] + $request['quantity'];  
              $rates = Helper::get_rates($request['service_id'],$request['datepicker'],$request['timepicker'],$item['quantity'],$request['canal'],'packs',$request['occasion_type'],'online'); 
              }           
             }
            }
            
              
             
             if ($type=="service") {
               foreach ($cart as &$item) {
               if ($item['service_id'] == $request['service_id'] && $item['type']== 'service') {
              $item['amount'] = $rates[0]['final_price'];  
              $item['price'] = $rates[0]['price'];  
               $item['tax'] = $rates[0]['tax_amount']; 
               }                 
             }

             }else {
               foreach ($cart as &$item) {
               if ($item['service_id'] == $request['service_id'] && $item['type']== 'packs') {
              $item['amount'] = $rates[0]['final_price'];  
              $item['price'] = $rates[0]['price'];  
               $item['tax'] = $rates[0]['tax_amount']; 
               }                 
             }
             }
            
            
            
          } else {
             $cart[] = array('service_name' => $service_name,'service_id' => $request['service_id'],'quantity' => $request['quantity'],
        'time' => $request['timepicker'],'date' => $request['datepicker'],'canal' => $option_name,'canal_id' => $request['canal'],'type' => $type,'amount' =>$request['amount'],'price' => $request['price'],'tax' => $request['taxes'],'icon' => $request['icon'],'pack_type' => $request['pack_type'],'occasion_type' => $request['occasion_type'],'occassion_text' => $occasiontext);
             
          }
         

        }
      }else {
           $cart[] = array('service_name' => $service_name,'service_id' => $request['service_id'],'quantity' => $request['quantity'],
        'time' => $request['timepicker'],'date' => $request['datepicker'],'canal' => $option_name,'canal_id' => $request['canal'],'type' => $type,'amount' =>$request['amount'],'price' => $request['price'],'tax' => $request['taxes'],'icon' => $request['icon'],'pack_type' => $request['pack_type'],'occasion_type' => $request['occasion_type'],'occassion_text' => $occasiontext);
        
      }




       
        Session::put('cart', $cart);
        Session::flash('success','barang berhasil ditambah ke keranjang!');
       
        return redirect('cart');
     
    }
    function remove_item($key) {
      $cart = Session::get('cart'); // Get the array
      unset($cart[$key]); // Unset the index you want
      Session::put('cart', $cart); // Set the array again
      return redirect()->back();

    }
    function remove_coupon() {
         Session::flash('coupon');

        return redirect('cart')->withInput()->with('warning','Coupon  Code Removed');
    }
    
    function apply_coupon(Request $request){
       $coupon_code = $request['coupon_code'];
       $cart = Session::get('cart');
       $type = "";
       $matcharray = array();
       $service_id = 0;
        $match = "";
      foreach ($cart as $key => $value) {
        $type = $value['type'];
        $service_id = $value['service_id'];
        $first_char = mb_substr($type, 0,1);
        $match.= $first_char."_".$service_id.",";
      }

      $matcharray = explode(",", rtrim($match,","));

           $db = DB::table('coupons')->where('coupon_name',$coupon_code)->get();
           $coupon_id = 0;
           foreach ($db as $key => $value) {
            $coupon_id = $value->id;
           }
       
       if (Helper::check_if_coupon_applied(Auth::user()->id,$coupon_id)) {
         Session::flash('coupon');

        return redirect('cart')->withInput()->with('error','Coupon already applied');
      }else {
        $db = DB::table('coupons')->where('coupon_name',$coupon_code)->get();
       $coupon = array();
       if (count($db)==0) {
        // Session::put('coupon', $coupon);
         return redirect('cart')->withInput()->with('error','Coupon not exist!');
       }else {
        foreach ($db as $key => $value) {
          if (in_array($value->uniq_match, $matcharray)) {
             $coupon_percent = $value->coupon_percent;
             $coupon = array('coupon_code' => $coupon_code,'coupon_percent' => $coupon_percent,'match' => $value->uniq_match);
            Session::put('coupon', $coupon);
            return redirect('cart')->withInput()->with('status','Coupon Applied!');
          }else {
             return redirect('cart')->withInput()->with('error','Coupon not exist!');
          }
          
        }
       

        
       }
      }
       

       
    }
    function remove_all() {
      Session::forget('cart');
      return redirect()->back();
    }
    function update_quantity(Request $request) {
      $service_id = $request['service_id'];
      $date = $request['date'];
      $time = $request['time'];
      $quantity = $request['quantity'];
      $optional = $request['optional'];
      $cart = Session::get('cart', []);

      $get_prices = Helper::get_rates($service_id, $date, $time,$quantity,$optional,'service','0','online');
         $final_price = "";
         $price = "";
         $tax_amount = "";
      foreach ($get_prices as $key => $value) {
         $final_price = $value['final_price'];
         $price = $value['price'];
         $tax_amount = $value['tax_amount'];
      }
      
      foreach ($cart as &$item) {
        if ($item['service_id'] == $service_id && $item['type']== 'service' && $item['canal']==$optional) {
           $item['quantity'] = $quantity;
           $item['amount'] = $final_price;
           $item['price'] = $price;
          $item['tax'] = $tax_amount;
       }
     } 

     $ct = Session::put('cart', $cart);
     return $get_prices[$key]['final_price'];

    }
    function update_pack_quantity(Request $request) {
      $pack_id = $request['service_id'];
      $date = $request['date'];
      $time = $request['time'];
      $quantity = $request['quantity'];
      $optional = $request['optional'];
      $ocassion_type = $request['ocassion_type'];
      $cart = Session::get('cart', []);

      $get_prices = Helper::get_rates($pack_id, $date, $time,$quantity,$optional,'packs',$ocassion_type,'online');
      $final_price = "";
      $price = "";
      $tax_amount = "";
      foreach ($get_prices as $key => $value) {
         $final_price = $value['final_price'];
         $price = $value['price'];
         $tax_amount = $value['tax_amount'];  
      }

      foreach ($cart as &$item) {
        if ($item['service_id'] == $pack_id && $item['type']== 'packs' && $item['canal']==$optional) {
           $item['quantity'] = $quantity;
           $item['amount'] = $final_price;
           $item['price'] = $price;
          $item['tax'] = $tax_amount;
       }
     } 
     $ct = Session::put('cart', $cart);
     return $final_price;
    }
}
