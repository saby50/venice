<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Auth;
use Hash;
use App\User;
use Crypt;
use Helper;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReciept;
use App\Mail\ContactMail;
use App\Mail\NewCareers;
use App\Mail\LeadsMail;
use Response;
use URL;
use Bitly;
use Session;
class WebController extends Controller
{
    function index() {

      if (Helper::check_mobile()=="1") {
         $featured = DB::table('services')->inRandomOrder()->take(2)->get();
         $featured2 = DB::table('packs')->inRandomOrder()->where('pack_type','!=','leads')->where('pack_type','!=','leads2')->where('pack_type','!=','leads3')->take(2)->get();
         $slider = DB::table('slides')->where('visibility','1')->inRandomOrder()->take(1)->get();
         $movies = DB::table('movies')->inRandomOrder()->take(2)->get();
         $foodorder = DB::table('units')->where('order_food','yes')->where('enable_food_order','yes')->where('suspended','no')->inRandomOrder()->take(6)->get();
          $offlineres = DB::table('units')->where('order_food','yes')->where('enable_food_order','no')->where('suspended','no')->inRandomOrder()->take(6)->get();
          $events = DB::table('events')->where('status','published')->inRandomOrder()->take(6)->get();
          $enable_food_order = DB::table('food_order_status')->where('id','1')->get();
          $bottom_slider = DB::table('bottom_slides')->where('visibility',1)->inRandomOrder()->take(1)->get();

         return view('homepwa', compact('featured','featured2','slider','movies','foodorder','events','enable_food_order','offlineres','bottom_slider'));
      }else {
         $featured = DB::table('services')->inRandomOrder()->take(4)->get();
         $featured2 = DB::table('packs')->inRandomOrder()->where('pack_type','!=','leads')->where('pack_type','!=','leads2')->where('pack_type','!=','leads3')->take(4)->get();
         $slider = DB::table('slides')->where('visibility','1')->orderBy('position','ASC')->inRandomOrder()->take(1)->get();
         $movies = DB::table('movies')->inRandomOrder()->take(4)->get();
          $events = DB::table('events')->where('status','published')->inRandomOrder()->take(6)->get();
           $foodorder = DB::table('units')->where('order_food','yes')->where('suspended','no')->orderBy('enable_food_order','desc')->take(6)->get();
          
          $enable_food_order = DB::table('food_order_status')->where('id','1')->get();
         return view('home', compact('featured','featured2','slider','movies','foodorder','events','enable_food_order','offlineres'));
       }

    }
    function foodorder() {
        if (Helper::check_mobile()=="1") {
       $foodorder = DB::table('units')->where('order_food','yes')->where('enable_food_order','yes')->where('suspended','no')->inRandomOrder()->take(6)->get();
          $offlineres = DB::table('units')->where('order_food','yes')->where('enable_food_order','no')->where('suspended','no')->inRandomOrder()->take(6)->get();
      $categories = DB::table('food_categories')->get();
      return view('foodorder', compact('foodorder','categories','offlineres'));

    }else {
       $foodorder = DB::table('units')->where('order_food','yes')->where('suspended','no')->orderBy('enable_food_order','desc')->get();
      $categories = DB::table('food_categories')->get();
      return view('foodorderdesk', compact('foodorder','categories','offlineres'));
    }
    }
    function getaddonfields($item_id) {
     $db = DB::table('unit_menu_items_add_ons')->where('item_id', $item_id)->get();
     $items = "";
     foreach ($db as $key => $value) {
       $items.= '<input type="checkbox" value="'.$value->id.'"> '.$value->addon_name.'(<i class="fa fa-inr"></i> '.$value->cost.')<br /><br />';
     }
     return $items;
    }
    function addons($item_id) {
      
      return view('menu/addons', compact('item_id'));
    }
    function add_item_cart(Request $request) {
       $item_id = $request['item_id'];
       $quantity = $request['quantity'];
       $addon = $request['addon'];
       $unit_id = $request['unit_id'];
       $price = $request['price'];
       $identifier = $request['identifier'];

       $cart = Session::get('food_cart');
       unset($cart);
       $cart[] = array('unit_id' => $unit_id,'item_id' => $item_id,'quantity' => $quantity, 'price' => $price,'item_name' => Helper::get_menu_item_name($item_id),'custom' => array());
      Session::put('food_cart', $cart);
      if ($addon=="1") {
        return redirect('menu/addons/'.$item_id);
      }else {
        return redirect('food_cart');
      }
    }
    function update_cart(Request $request) {
      $titles = $request['titles'];
      $split = explode(",", $titles);
      $item_id = $request['item_id'];
      $data = array();
      $cart = Session::get('food_cart');
      foreach ($split as $key => $value) {
        $data[] = array($value => $request[$value]);
      }
      foreach ($cart as &$item) {
        if ($item_id==$item['item_id']) {
          $item['custom'] =  $data;
        }
      }

      Session::put('food_cart',$cart);
      $cart = Session::get('food_cart');
      return redirect('food_cart');
     
    }

     function foodcart(Request $request) {

      $item_id = $request['item_id'];
      $quantity = $request['quantity'];
      $price = $request['price'];
      $unit_id = $request['unit_id'];
      $item_name = Helper::get_menu_item_name($item_id);

      $cart = Session::get('food_cart');
      $sameunit = 0;
      if (Session::has('food_cart')) {
        if (count($cart)==0) {
          $cart[] = array('unit_id' => $unit_id,'item_id' => $item_id,'quantity' => $quantity, 'price' => $price,'item_name' => $item_name,'custom' => array());
        }else {
          $sunit = "";
          foreach ($cart as &$item) {
            $sunit = $item['unit_id'];
          }
          if ($sunit==$unit_id) {
           $cart[] = array('unit_id' => $unit_id,'item_id' => $item_id,'quantity' => $quantity, 'price' => $price,'item_name' => $item_name,'custom' => array());
          }else {
            $sameunit = 1;
          }
          
        }
        
      }else {
        $cart[] = array('unit_id' => $unit_id,'item_id' => $item_id,'quantity' => $quantity, 'price' => $price,'item_name' => $item_name,'custom' => array());
      }
      Session::put('food_cart', $cart);
      $carts = Session::get('food_cart');
     $data = array();
      $get_unit_name = Helper::get_unit_info($unit_id);
      $unit_name = "";
      foreach ($get_unit_name as $key => $value) {
        $unit_name = $value->unit_name;
      }
      $q = 0; $p = 0;
      foreach ($carts as $key => $value) {
        $q+= $value['quantity'];
        $p+= $value['price'];
        $data = array('price' => $p,'quantity' => $q, 'unit_name' => $unit_name,'item_name' => $item_name,'sameunit' => $sameunit);
         
      }
       return $data;

    }
    
    function foodcart_update(Request $request) {

      $item_id = $request['item_id'];
      $quantity = $request['quantity'];
      $identifier = $request['identifier'];
      $price = $request['price'];
      $unit_id = $request['unit_id'];
      $cart = Session::get('food_cart');
      $sprice = Helper::get_menu_item_price($item_id);
      $qprice = $quantity * $sprice;
      if ($quantity==0) {
        foreach ($cart as $key => $value) {
           if ($value['item_id'] == $item_id) {
              unset($cart[$key]); // Unset the index you want
              Session::put('food_cart', $cart);
            }
        }
      }else {
        foreach ($cart as &$item) {
           if ($item['item_id'] == $item_id) {
               $item['quantity'] = $quantity;
               $item['price'] = $qprice;
            }
        }
      }
  
      Session::put('food_cart', $cart);
      $carts = Session::get('food_cart');
      $data = array();
      $get_unit_name = Helper::get_unit_info($unit_id);
      $unit_name = "";
      foreach ($get_unit_name as $key => $value) {
        $unit_name = $value->unit_name;
      }
      $q = 0; $p = 0;
      foreach ($carts as $key => $value) {
        $q+= $value['quantity'];
        $p+= $value['price'];
        $data = array('price' => $p,'quantity' => $q, 'unit_name' => $unit_name);
         
      }
       return $data;
    }

    function get_cart_data($unit_id) {
     $cart = Session::get('food_cart');
     $data = array();

      $quantity = 0; $price = 0; $unit_id=0;
     if(Session::has('food_cart')) {
       foreach ($cart as $key => $value) {
        $unit_id = $value['unit_id'];
       }
     $get_unit_name = Helper::get_unit_info($unit_id);
     $unit_name = "";
     foreach ($get_unit_name as $key => $value) {
       $unit_name = $value->unit_name;
     }
       foreach ($cart as &$item) {
        if ($unit_id==$item['unit_id']) {
          $quantity+= $item['quantity'];
         $price+= $item['price'];
         $data = array('price' => $price,'quantity' => $quantity, 'unit_name' => $unit_name,'unit_id' => $item['unit_id']);
        }
        
       }
     }
   
      return $data;

    }
    function food_cart() {
       $cart = Session::get('food_cart');
       if (Helper::check_mobile()=="1") {
         return view('cart/foodcart', compact('cart'));
       }else {
        return view('cart/foodcartdesk', compact('cart'));
       }
       
    }

    function remove_item($key) {
      $cart = Session::get('food_cart'); // Get the array
      unset($cart[$key]); // Unset the index you want
      Session::put('food_cart', $cart); // Set the array again
      return redirect()->back();

    }
    function food_checkout(Request $request) {
        $payment_method = $request['payment_method'];
      $amount = Crypt::decrypt($request->amount);
      if ($payment_method=="instamojo") {
          $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url')
        );
 
    try {
        $response = $api->paymentRequestCreate(array(
            "purpose" => "$request->services",
            "amount" => $amount,
            "buyer_name" => "$request->name",
            "payment_method" => $payment_method,
            "send_email" => true,
            "email" => "$request->email",
            "phone" => "$request->phone",
            "redirect_url" => URL::to('food_payment/status')
            ));
             
            header('Location: ' . $response['longurl']);
            exit();
    }catch (Exception $e) {
        print('Error: ' . $e->getMessage());
    }
        
      }elseif($payment_method=="wallet") {
        $payment_id = rand(10,100);
       $result = Helper::booking_food_process($request->name,$request->email,$request->phone,$request->services,$amount,'wallet',$payment_id,'INR',"",'success','off',null,null,null); 

         return redirect('food/status_s'); 

      }else {
        $payment_id = rand(10,100);
        // $this->booking_process($request->name,$request->email,"+91".$request->phone,$request->services,$amount,$payment_method,$payment_id,'INR',$payment_method,'success','off',null,null,null); 
        //  return redirect('status_s');  
      }
    }

    function foodstatus() {
       $cart = Session::get('food_cart');
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
             $result = Helper::booking_food_process($name,$email,$phone,$response['purpose'],$amount,'instamojo',$payment_id,$currency,$type,$status,'off',null,null,null); 

             return redirect('food/status_s'); 

            }else {
              return redirect('status_f');

            }      
    }
    function status_s() {
      $status = 'success';
      return view('menu/status', compact('status'));  
    }
    function search() {
      return view('search');  
    }

    function showmenu($view,$id) {
      if (Helper::check_mobile()=="1") {
       $getid = Crypt::decrypt($id);
       return view('menu/menu', compact('getid','view'));
     }else {
       $getid = Crypt::decrypt($id);
       return view('menu/menudesk', compact('getid','view'));
      }
    }

    function offline() {
      return view('offline');
    }

    function getunitqr($id) {
      return view('getunitqr', compact('id'));
    }
   
    function notifications() {
      $data = DB::table('user_notifications')->orderBy('id','desc') ->get();
      return view('notifications', compact('data'));
    }

    function notifications_units() {
      $data = DB::table('unit_notifications')->orderBy('id','desc') ->get();
      return view('notificationsunits', compact('data'));
    }

    function profile() {
        $userid = Auth::user()->id;
       if (Helper::check_mobile()=="1") {
         $bookings = DB::table('bookings')
          ->where('bookings.user_id',$userid)
          ->orderBy('bookings.id','desc') 
          ->groupBy('bookings.order_id')
          ->limit(3)
          ->get();
           $categories = DB::table('categories')->get();
           return view('profilepwa', compact('bookings','categories'));
       }else {
        return view('profile');
       }
      
    }
    function sendcontact(Request $request) {
      $name = $request['name'];
      $email = $request['email'];
      $phone = $request['phone'];
      $message = $request['message'];
      $date = date("Y-m-d H:i:s");
      $captcha = $request['g-recaptcha-response'];

      $response =  $this->getCaptcha('6LcynKQUAAAAAOiFew_xPzxygQIjCfnDZVGz64J-',$captcha);
     

    if($response->success == false)
    {
        return redirect()->back()->withInput()->with('error','Captcha Invalid!');
    }
    else
    {
          $db = DB::table('contactus')->insert(['name' => $name, 'email' => $email, 'phone' => $phone,'message' => $message,'updated_at' => $date, 'created_at' => $date]);
      if ($db) {
          $emailers = Helper::get_mailer('contact');
         Mail::to($emailers)->send(new ContactMail($name,$email,$phone, $message));
       return redirect()->back()->withInput()->with('status','Your query has been successfully recorded!');
      
      }else {
        return redirect()->back()->withInput()->with('error','Server error, please try again later!');
      }
    }
    
    }

    function getCaptcha($secretKey,$captcha){
      $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha);
      $return = json_decode($response);
      return $return;
    }
    function history($type) {
       $userid = Auth::user()->id;
       $bookings = $this->get_history($type);
       $food_history = $this->get_food_history();
       $categories = DB::table('categories')->get();
       if (Helper::check_mobile()==1) {
         return view('historypwa', compact('bookings','categories','type','topup','food_history'));
       }else {
        return view('history', compact('bookings','categories','type'));
       }
       
    }
    function foodhistory($order_id) {
      $getid = Crypt::decrypt($order_id);
      $data = DB::table('food_orders')->where('order_id',$getid)->get();
      return view('foodhistory', compact('data','getid'));
    }
    function get_food_history() {
      $email = Auth::user()->email;
      $db = DB::table('food_orders')->where('email',$email)->groupBy('food_orders.order_id')->orderBy('id','desc')->get();
      return $db;
    }
    function get_history($type) {
      $userid = Auth::user()->id;
       if ($type=="all") {
        if (Helper::check_mobile()==1) {
          $bookings = DB::table('bookings')
          ->where('bookings.user_id',$userid)
          ->orderBy('bookings.id','desc') 
          ->groupBy('bookings.order_id')
          ->get();
        }else {
          $bookings = DB::table('bookings')
          ->where('bookings.user_id',$userid)
          ->orderBy('bookings.id','desc') 
          ->groupBy('bookings.order_id')
          ->simplePaginate(2);
        }
        }else if($type=="packs") {
          $bookings = DB::table('bookings')
          ->where('type','packs')
          ->where('bookings.user_id',$userid)
          ->groupBy('bookings.order_id')
          ->orderBy('bookings.id','desc')
          ->simplePaginate(2);
        }else if($type=="food_orders") {
          $bookings = DB::table('food_orders')
          ->where('food_orders.phone',Auth::user()->phone)
          ->groupBy('food_orders.order_id')
          ->orderBy('food_orders.id','desc')
          ->simplePaginate(2);
        }else if($type=="events") {
          $bookings = DB::table('booking_events')
          ->where('booking_events.user_id',$userid)
          ->groupBy('booking_events.order_id')
          ->orderBy('booking_events.id','desc')
          ->simplePaginate(2);
        }else {
          $bookings = DB::table('bookings')
          ->join('services','bookings.service_id','=','services.id')
          ->join('categories','services.category_id','=','categories.id')
          ->select(DB::raw('bookings.*'))
          ->where('categories.alias',$type)
          ->where('type','service')
          ->where('bookings.user_id',$userid)
          ->orderBy('bookings.id','desc')
          ->groupBy('bookings.order_id')
          ->simplePaginate(2);
        } 
        return $bookings;
    }
    function history_details($id) {
      $getid = Crypt::decrypt($id);
      return view('historydetailspwa', compact('getid'));
    }

    function invoice($order_id) {
      $getorderid = Crypt::decrypt($order_id);
      $name = Auth::user()->name;
      $email = Auth::user()->email;
      $phone = Auth::user()->phone;
      $pdfname = date('dmyhis')."_bookings";
      $pdf = PDF::loadView('invoice',['orderid' => $getorderid]);
      return $pdf->download($pdfname.'.pdf');
    }
    function food_invoice($order_id) {
      $getorderid = Crypt::decrypt($order_id);
      $name = Auth::user()->name;
      $email = Auth::user()->email;
      $phone = Auth::user()->phone;
      $pdfname = date('dmyhis')."_bookings";
      $pdf = PDF::loadView('food_invoice',['orderid' => $getorderid]);
      return $pdf->download($pdfname.'.pdf');
    }
    function careers() {
      $db = DB::table('careers')->orderBy('careers.id','desc')->get();
      return view('careers/index', compact('db'));
    }
    function applynow(Request $request) {
      $name = $request['name'];
      $email = $request['email'];
      $phone = $request['phone'];
      $job = $request['job'];
      $cv = $request['cv'];
       $date = date("Y-m-d H:i:s");

        $captcha = $request['g-recaptcha-response'];

      $response =  $this->getCaptcha('6LcynKQUAAAAAOiFew_xPzxygQIjCfnDZVGz64J-',$captcha);


      if($response->success == false)
    {
        return redirect('careers#applicationform')->withInput()->with('error','Captcha Invalid!');
    }
    else
    {

      $destinationPath = "public/uploads/cv";
      $file = $request->file('myfile');
      $fdate = date('dmyhis');
      $filename = str_replace(" ", "", $fdate."".$file->getClientOriginalName());
      $file->move($destinationPath,$filename);

      $db1 = DB::table('careers')->where('id',$job)->get();
      $job_title = "";
      foreach ($db1 as $key => $value) {
        $job_title = $value->job_title;
      }



       Mail::to('hr@bhasingroup-gv.com')->send(new NewCareers($name,$email,$phone, $job_title,$filename));

       $db = DB::table('job_applications')->insert(['name' => $name, 'email' => $email,'phone' => $phone,'job_id'=> $job,'cv' => $filename,'created_at' => $date, 'updated_at' => $date]);

      return redirect('careers#applicationform')->withInput()->with('status','Applied successfully!');
    }
    }
    function event_invoice($order_id) {
      $getorderid = Crypt::decrypt($order_id);
      $data = DB::table('booking_events')     
      ->where('booking_events.order_id',$getorderid)
      ->get();
      $pdfname = date('dmyhis')."_event_booking";
      $pdf = PDF::loadView('eventinvoice',['data' => $data]);
      return $pdf->download($pdfname.'.pdf');
    }
    function update_profile(Request $request) {
       $name = $request['name'];
       $phone = $request['phone'];
       $email = $request['email'];
       $userid = Auth::user()->id;
       $db = DB::table('users')->where('id', $userid)->update(['name' => $name,'phone' => $phone, 'email' => $email]);
       if ($db) {
         $notification = "status";
         return redirect('profile')->withInput()->with($notification,'Profile Updated!');
       }else {
         $notification = "error";
         return redirect('profile')->withInput()->with($notification,'Some error occured, please try again later!');
       }
    }
    function pin() {
      $userid = Auth::user()->id;
       if (Helper::check_mobile()=="1") {
        return view('pinpwa');
       }else {
        return view('pin');
       }
      
    }
    function update_pin(Request $request) {
      $oldpin = $request['oldpin'];
      $newpin = $request['newpin'];
      $cnewpin = $request['cnewpin'];
      $userid = Auth::user()->id;
      $finduser = User::where('id',$userid)->first();
      if ($finduser) {
       $passcheck = Hash::check($oldpin, $finduser->password);
         if ($passcheck==true) { 
          if ($cnewpin==$newpin) {
            DB::table('users')->where('id',$userid)->update(['password' => bcrypt($cnewpin)]);
           $notification="status";
          return redirect('profile/pin')->withInput()->with($notification,'Pin Updated!');
          }else {
            $notification="error";
          return redirect('profile/pin')->withInput()->with($notification,'New Pin and Confirm Pin should be match!');
          }
          
         }else {
          $notification="error";
          return redirect('profile/pin')->withInput()->with($notification,'Old Pin not match with records!');
         }
       }
      

    }
    function contact() {
      return view('contact');
    }
    function privacypolicies() {
      return view('privacypolicies');
    }
    function termsconditions() {
      return view('termsconditions');
    }
    function refundpolicy() {
       return view('refundpolicy');
    }
    function categories() {
      $categories = Helper::get_menu();
     $services = DB::table('services')->get();
      $packs = DB::table('packs')->where('pack_type','!=','leads')->where('pack_type','!=','leads3')->get();
       $events = DB::table('events')->where('status','published')->get();
      return view('categories', compact('categories','packs','services','events'));  
    }
    function terrazzo() {  
      return view('pages/terrazzo');
    }
     function urzaa() {  
      return view('pages/urzaa');
    }
    function bakery() {
      return view('pages/bakery');
    }
    function leads(Request $request) {
     $name = $request['name'];
     $phone = $request['phone'];
     $email = $request['email'];
     $date2 = $request['date'];
     $time = $request['time'];
     $pack_type = $request['pack_type'];
     $pack_name = $request['pack_name'];
     $date = date("Y-m-d H:i:s");
     if ($date2=="") {
       $date2 = "N/A";
     }
     if ($time=="") {
       $time = "N/A";
     }


      if ($pack_type=="leads") {
        Mail::to('ravinder.bedi@seekerstech.com')->cc(['gaurav.budhiraja@mistavenue.co.in','vimal@mistavenue.co.in'])->send(new LeadsMail($name,$email,$phone, $date2,$time, $pack_name));
      }else {
         Mail::to('info@veniceindia.com')->send(new LeadsMail($name,$email,$phone, $date2,$time,$pack_name));
      }
     

     $db = DB::table('leads')->insert(['name' => $name,'phone' => $phone,'email' => $email ,'date' => $date2, 'time' => $time,'status' => 'fresh','lead_type' => $pack_name,'updated_at' => $date, 'created_at' => $date]);

     return redirect()->back()->withInput()->with('status','Thanks for your request!');
    }
    function feedback($order_id) {
      $generateid = Crypt::decrypt($order_id);
      $services = Helper::get_service_details($generateid);
      $packs = Helper::get_pack_details($generateid);
      $data = DB::table('bookings')->where('order_id',$generateid)->get();
      $checkfeedbacks = DB::table('feedbacks')->where('order_id',$generateid)->count();
      $name = "";
      foreach ($data as $key => $value) {
        $name = $value->name;
      }
      return view('feedback/index', compact('services','packs','name','generateid','checkfeedbacks'));  
    }
    function sendfeedback(Request $request) {
       $service_id = $request['service_id'];
       $type = $request['type'];
       $rating = $request['rating'];
       $user_id = $request['user_id'];
       $comments = $request['comments'];
       $order_id = $request['order_id'];
       $date = date("Y-m-d H:i:s");
       foreach ($service_id as $key => $value) {
         $db = DB::table('feedbacks')->insert(['service_id' => $value,'type' => $type[$key],'rating' => $rating[$key],'user_id' => $user_id,'comments' => $comments,'order_id' => $order_id,'updated_at' => $date, 'created_at' => $date]);
       }

       return redirect()->back()->withInput()->with('status','Thanks for your ratings');
    }
    function sendfeedbacksms() {
      $date2 = date('d-m-Y');
      $todaysorder = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))          
            ->where('bookings.date',$date2)  
             ->where('bookings.status','success')
            ->orderBy('bookings.id','desc')
            ->groupBy('bookings.order_id')
            ->get();
      
      $todaydate = date('d-m-Y');
      $currenttime = date('g:i A');
  
      foreach ($todaysorder as $key => $value) {
        echo $phone = $value->phone;
        $orderid = $value->order_id;
        $time = date('g:i A', strtotime('+2 hour', strtotime($value->time)));
        $date = $value->date;
        
       
   

     if (strtotime($date)==strtotime($todaydate)) {
      if (strtotime($time)==strtotime($currenttime)) {
         $url =  "https://".$_SERVER['SERVER_NAME'].'/feedback/'.Crypt::encrypt($orderid);
         $url2 = Bitly::getUrl($url);
         $content = "Hi ".$value->name.", please spare just 10 seconds to give your valuable feedback. Click ".$url2;
         Helper::send_otp($phone,$content);
        
      }else  {
       echo "Current Date";
         }
     }else {
      echo "Not Current Date";
     }

    
      
      }
      
     

      

     // return $todaysorder;


    }
    function movies() {
      $movies = DB::table('movies')->orderBy('movies.id','desc')->get();
      return view('movies/index', compact('movies'));  
    }
   
}
