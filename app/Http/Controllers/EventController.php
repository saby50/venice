<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use URL;
use Helper;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventReciept;
use Crypt;
use Auth;
class EventController extends Controller
{
    function index($alias) {
       $data = DB::table('events')
       ->join('taxes','taxes.id','=','events.tax_id')
       ->select(DB::raw('events.*'),
         DB::raw('taxes.tax_percent as tax_percent'))
       ->where('event_alias',$alias)
       ->get();
       $event_id = 0;
       foreach ($data as $key => $value) {
       	$event_id = $value->id;
       }
       $eventdates = DB::table('event_dates')->where('event_id',$event_id)->get();
       $gallery = DB::table('event_gallery')->where('event_id',$event_id)->get();
       $featured = DB::table('services')->inRandomOrder()->limit(2)->get();
       $featured2 = DB::table('packs')->inRandomOrder()->where('pack_type','!=','leads')->where('pack_type','!=','leads3')->limit(2)->get();
       return view('events/index', compact('data','gallery','eventdates','featured','featured2'));	
    }

     function add_event(Request $request) {
       
       $date = $request['event_date'];
       $quantity = $request['quantity'];
       $amount =  $request['amount'];
       $price = $request['price'];
       $taxamount = $request['tax_amount'];
       $event_name = $request['event_name'];
       $event_alias = $request['event_alias'];
       $event_time = $request['event_time'];
       $name = $request['name'];
       $email = $request['email'];
       $phone = $request['phone'];
       //$cart = Session::get('event');

       $cart[] = array('event_name' => $event_name,'event_alias' => $event_alias,'amount' => $amount,'price' => $price,'quantity' => $quantity, 'tax_amount' => $taxamount,'date' => $date,'name' => $name, 'phone' => $phone, 'email' => $email,'event_time' => $event_time);

        Session::put('event', $cart);
        Session::flash('success','barang berhasil ditambah ke keranjang!');
       
        return redirect('cart');
       
    }
    function checkout($payment_method) {
       $event_cart = Session::get('event');
        $name = "";
         $email = "";
         $phone = "";
         $event_name = "";
         $amount = 0;
         foreach ($event_cart as $key => $value) {
          $name = $value['name'];
          $email = $value['email'];
          $phone = $value['phone'];
          $event_name = $value['event_name'];
          $amount = $value['amount'];
         }
     
      if ($payment_method=="instamojo") {
          $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url')
        );
 
    try {
        $response = $api->paymentRequestCreate(array(
            "purpose" => "Event: ".$event_name,
            "amount" => $amount,
            "buyer_name" => $name,
            "payment_method" => $payment_method,
            "send_email" => true,
            "email" => $email,
            "phone" => $phone,
            "redirect_url" => URL::to('event/status')
            ));
             
            header('Location: ' . $response['longurl']);
            exit();
    }catch (Exception $e) {
        print('Error: ' . $e->getMessage());
    }
        
      }else {
         $trans_id = uniqid(mt_rand(),true);
         $currency = "INR";
         $status = "success";
         $type = "wallet";
         $name = "";
         $email = "";
         $phone = "";
         $event_name = "";
         $amount = 0;
         foreach ($event_cart as $key => $value) {
          $name = $value['name'];
          $email = $value['email'];
          $phone = $value['phone'];
          $event_name = $value['event_name'];
          $amount = $value['amount'];
         }
         Helper::booking_event_process($name,$email,"+91".$phone,$event_name,$amount,$payment_method,$trans_id,$currency,$type,$status); 
        

          return redirect('status_s');

      }
       
    }
    function status() {
        $cart = Session::get('event');
    	$date = date("Y-m-d H:i:s");
        $response = array();
        $status = "";
     try {
 
        $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url')
        );
 
        $response = $api->paymentRequestStatus(request('payment_request_id'));
        $phone = $response['payments'][0]['buyer_phone'];
        if( !isset($response['payments'][0]['status']) ) {
           $status = "failed";
        } else if($response['payments'][0]['status'] != 'Credit') {
             $status = "failed";
            
        }else {
             $status = "success";
            
        }

      }catch (\Exception $e) {
          $status = "failed";
     }


     
            $payment_id = $response['payments'][0]['payment_id'];
            $currency = $response['payments'][0]['currency'];
            $amount = $response['payments'][0]['amount'];
            $name = $response['payments'][0]['buyer_name'];
            
            $email = $response['payments'][0]['buyer_email'];
            
            $type  = $response['payments'][0]['instrument_type'];
            
           if ($status=="success") {
             Helper::booking_event_process($name,$email,"+91".$phone,$response['purpose'],$amount,'instamojo',$payment_id,$currency,$type,$status); 

             return redirect('status_s');

            }else {
              return redirect('status_f');

            }    
    }


  
    function get_event_id($event_alias) {
       $db = DB::table('events')->where('event_alias',$event_alias)->get();
       $event_id = 0;
       foreach ($db as $key => $value) {
         $event_id = $value->id;
       }
       return $event_id;
    }
    function get_time($date, $event_id) {
    	$data = DB::table('event_dates')->where('event_date',$date)->get();
    	return $data[0]->event_time;
    }
    function event_terms_condtions() {
      return view('eventsterms');
    }
    function send(Request $request) {
      $name = $request['name'];
      $phone = $request['phone'];
      $email = $request['email'];
      $quant = $request['quant'];
      $amount = $request['amount'];
      $event_name = $request['event_name'];
      $payment_id = rand(15,35); 
      $currency = "INR";
      $type = "NULL";
      $purpose = "NULL";
      $status = "success";
      Helper::booking_event_process($name,$email,"+91".$phone,$purpose,$amount,'NULL',$payment_id,$currency,$type,$status); 
      return redirect()->back()->withInput()->with('status','You have success booked!');

    }
}
