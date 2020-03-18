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
       $featured2 = DB::table('packs')->inRandomOrder()->where('pack_type','!=','leads')->limit(2)->get();
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
       $eventcart = Session::get('event');

       $eventcart = array('event_name' => $event_name,'event_alias' => $event_alias,'amount' => $amount,'price' => $price,'quantity' => $quantity, 'tax_amount' => $taxamount,'date' => $date,'name' => $name, 'phone' => $phone, 'email' => $email,'event_time' => $event_time);

        Session::put('event', $eventcart);
        Session::flash('success','barang berhasil ditambah ke keranjang!');
       
        return redirect('cart');
       
    }
    function checkout($payment_method) {
       $event_cart = Session::get('event');
       
     
      if ($payment_method=="instamojo") {
          $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url')
        );
 
    try {
        $response = $api->paymentRequestCreate(array(
            "purpose" => "Event: ".$event_cart['event_name'],
            "amount" => $event_cart['amount'],
            "buyer_name" => $event_cart['name'],
            "payment_method" => $payment_method,
            "send_email" => true,
            "email" => $event_cart['email'],
            "phone" => $event_cart['phone'],
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
         $this->booking_process($event_cart['name'],$event_cart['email'],$event_cart['phone'],$event_cart['event_name'],$event_cart['amount'],$payment_method,$trans_id,$currency,$type,$status); 

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
             $this->booking_process($name,$email,$phone,$response['purpose'],$amount,'instamojo',$payment_id,$currency,$type,$status); 

             return redirect('status_s');

            }else {
              return redirect('status_f');

            }    
    }


    function booking_process($name,$email,$phone,$purpose,$amount,$payment_method,$payment_id,$currency,$type,$status) {
       if (Session::get('event')) {
       	   $cart = Session::get('event');

       	    $date2 = date("Y-m-d H:i:s");
           $orderid = "GV/ON/E/".Helper::generatePIN(6);
            $finduser = User::where('phone', $phone)->first();
            $pin = Helper::generatePIN();
            $user_id =0;
            if (!$finduser) {
              $user = new User;
              $user->name = $name;
              $user->email = $email;
              $user->phone = $phone;
              $user->password = bcrypt($pin);
              $user->platform = "web";
              $user->otp = $pin;
              $user->type = 'user';
              $user->save();
              $content = "Your account with The Grand Venice Mall is successfully registered. Please login with your phone number ".$phone." and PIN: ".$pin." and book services online at www.veniceindia.com";
              Helper::send_otp($phone,$content);
              $user_id = $user->id;
            }else {
              $user_id = $finduser['id'];
            }

           
             	 $event_name =  $cart['event_name'];
             	 $event_alias =  $cart['event_alias'];
             	 $amount =  $cart['amount'];
             	 $price = $cart['price'];
             	 $quantity = $cart['quantity'];
               $tax_amount = $cart['tax_amount'];
               $date = $cart['date'];
               $name = $cart['name'];
               $phone = $cart['phone'];
               $email = $cart['email'];
               $event_time = $cart['event_time'];
               $event_id = $this->get_event_id($event_alias);
               $data = array('user_id' => $user_id,'name' => $name,'email' => $email,'phone' => $phone, 'event_id' => $event_id,'event_name' => $event_name,'amount' => $amount,'date' => $date,'time' => $event_time,'status' => $status,'quantity' => $quantity,'price'=> $price,'tax' => $tax_amount,'txnid' => $payment_id,'payment_mode' => $type,'platform' =>'web','payment_method' => $payment_method,'order_id' => $orderid,'created_at' => $date2, 'updated_at' => $date2);
               $db = DB::table('booking_events')->insert($data);
               $content2 = "Event Confirmation: ".$event_name.", ".date('d F',strtotime($date))."(".$event_time."). Order ID: ".$orderid.", Qty: ".$quantity.", Paid: Rs. ".$amount.". Install the Apps: https://l.ead.me/29Ev";
            Helper::send_otp($phone,$content2);

            $ndata[] = $data;

            if ($payment_method=="wallet") {
               $current_bal = Crypt::decrypt(Auth::user()->wall_am);

           $updated_bal = $current_bal - $amount;
         
           $query2 = DB::table('users')->where('id',Auth::user()->id)->update(['wall_am' => Crypt::encrypt($updated_bal)]);
           $trans_id = uniqid(mt_rand(),true);
            $platform = Helper::get_device_platform();
           $query3 = DB::table('wall_history')->insert(['final_amount' => $amount,'user_id' => $user_id,'order_id' => $orderid,'identifier' => 'event','trans_id' => $trans_id,'payment_method' => 'wallet','platform' => $platform,'created_at' => $date2, 'updated_at' => $date2]);

              $contentwallet = "You paid Rs. ".$amount." Event: ".$purpose.", Order ID: ".$orderid.", GV Pay balance is Rs. ".$updated_bal.". Install the iPhone/Android App: https://l.ead.me/29Ev";
              Helper::send_otp(Auth::user()->phone,$contentwallet);
            }

             if ($email != "") {
             Mail::to($email)->cc(['ravinder.bedi@thebasin.in'])->send(new EventReciept($ndata));
             }
            Session::flush('event');

            
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
      $this->booking_process($name,$email,$phone,$purpose,$amount,'NULL',$payment_id,$currency,$type,$status); 
      return redirect()->back()->withInput()->with('status','You have success booked!');

    }
}
