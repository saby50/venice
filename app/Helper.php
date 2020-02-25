<?php
class Helper
{
   public static function get_menu() {   
    $db = DB::table('categories')->where('alias','!=','parking')->get();
    $data = array();
    foreach ($db as $key => $value) {
    	$category_id = $value->id;
    	$category_name = $value->category_name;
    	$services = DB::table('services')
         ->select(DB::raw('services.id as service_id'),
         	DB::raw('services.service_name as service_name'),
          DB::raw('services.featured_image as featured_image'),
          DB::raw('services.short_description as short_description'),
         	DB::raw('services.alias as alias'))
      
    	->where('category_id',$category_id)
       
    	->get();
    	$data[$category_name."_".$value->alias] = $services;
    }
    return $data;
  }
  public static function get_packs() {   
    $data = DB::table('packs')->where('pack_type', '!=','leads')->where('pack_type', '!=','leads3')->get();
   
    return $data;
  }
  public static function get_gv_tower() {   
    $data = DB::table('packs')->where('pack_type', '=','leads3')->get();
   
    return $data;
  }
  public static function get_veg_non($unit_id) {   
    $db = DB::table('unit_menu_items')->where('unit_id', $unit_id)->get();

    $store = "";
    foreach ($db as $key => $value) {
      $store.= $value->veg_nonveg.",";
    }
    $storef = rtrim($store,",");
    $data = explode(",", $storef);
   
    return array_unique($data);
  }
   public static function get_item_addons($item_id) {   
    $data = DB::table('unit_menu_items_add_ons')->where('item_id', $item_id)->get();
   
    return $data;
  }
  
   public static function get_item_addons_list($item_addon_id) {   
    $data = DB::table('unit_menu_items_add_ons_list')->where('item_addon_id', $item_addon_id)->get();
    return $data;
  }
  public static function booking_food_process($name, $email,$phone,$purpose, $amount,$payment_method,$payment_id,$currency,$type,$status,$foccheckbox,$authorised,$foc_reason,$percent) {

    if (Session::get('food_cart')) {

      $cart = Session::get('food_cart');
      $date = date("Y-m-d H:i:s");
      $orderid = "GV/FD/".Helper::generatePIN(6);
           
      $finduser = App\User::where('phone', $phone)->first();
      $pin = Helper::generatePIN();
      $user_id =0;
      if (!$finduser) {
          $user = new App\User;
          $user->name = $name;
          $user->email = $email;
          $user->phone = $phone;
          $user->password = bcrypt($pin);
          $user->platform = Helper::get_device_platform();
          $user->otp = $pin;
          $user->type = 'user';
          $user->save();  
          $mobile = $phone;
          if (strlen($mobile) == 13 && substr($mobile, 0, 3) == "+91") {
            $mobile = substr($mobile, 3, 10);
          }
    

          $content = "You are now registered with The Grand Venice Mall. Your login is ".$mobile." and PIN is ".$pin.". Install the iPhone/Android App: https://l.ead.me/29Ev";
              Helper::send_otp($phone,$content);
              $user_id = $user->id;
      }else {
          $user_id = $finduser['id'];
          if ($email == "") {
            $email = $finduser['email'];
          }else {
              $email = $email;
          }
          $updatedate = date("d F Y, h:i A");
          $updateemail = DB::table('users')->where('id',$user_id)->update(['email' => $email,'name' => $name,'updated_at' => $updatedate]); 
      }

      $itemdetails = "";

      foreach ($cart as $key => $value) {
        $unit_id = $value['unit_id'];
        $item_id = $value['item_id'];
        $quantity = $value['quantity'];
        $price = $value['price'];
        $itemdetails.= Helper::get_menu_item_name($item_id)."(Qty: ".$quantity."), ";
        
        $data = array('name' => $name, 'email' => $email, 'phone' => $phone, 'unit_id' => $unit_id, 'item_id' => $item_id,'quantity' => $quantity, 'price' => $price, 'amount' => $amount, 'tax' => '0','payment_id' => $payment_id,'order_id' => $orderid,'payment_method' => $payment_method,'created_at' => $date, 'updated_at' => $date);
         $db = DB::table('food_orders')->insert($data);

      }
      $units = Helper::get_unit($unit_id);
      
      $content = "Your order for ".$itemdetails."from ".$units['unit_name']." is confirmed, Your Order ID is: ".$orderid;

      Helper::send_otp($phone,$content);

      $unit_phone = $units['unit_phone'];

      $content2 = "You have recieved new order from ".$name.", Here are the details: ".$itemdetails." Order ID is: ".$orderid;

      Helper::send_otp($unit_phone,$content2);

      $gettoken = DB::table('unit_tokens')->where('unit_id',$unit_id)->get();
      $token = "";
      foreach ($gettoken as $key => $value) {
        $token = $value->token;
      }

       $message = "You have recieved 1 new order";
       Helper::send_push_to_units($message,$token,"food_order","food_order");


       if ($payment_method=="wallet") {
          $current_bal = Crypt::decrypt(Auth::user()->wall_am);

           $updated_bal = $current_bal - $amount;
         
           $query2 = DB::table('users')->where('id',Auth::user()->id)->update(['wall_am' => Crypt::encrypt($updated_bal)]);
            $trans_id = uniqid(mt_rand(),true);
            $platform = Helper::get_device_platform();
           $query3 = DB::table('wall_history')->insert(['final_amount' => $amount,'user_id' => $user_id,'order_id' => $orderid,'identifier' => 'foodorder','trans_id' => $trans_id,'payment_method' => 'wallet','platform' => $platform,'created_at' => $date, 'updated_at' => $date]);
          $contentwallet = "You have paid Rs. ".$amount." to ".$purpose.", Order ID: ".$orderid.", Now current balance is Rs. ".$updated_bal.".";
           Helper::send_otp(Auth::user()->phone,$contentwallet);
       }

      Session::forget('food_cart');
      return $orderid;
    }

  }
  public static function get_cart_data($item_id) {   
   $cart = Session::get('food_cart');
   $data = array();
   if(Session::has('food_cart')) {
   foreach ($cart as &$item) {
     if ($item['item_id']==$item_id) {
       $data = array('available' => '1','quantity' => $item['quantity']);
     }else {
       $data = array('available' => '0','quantity' => '0');
     }
   }
  }else {
    $data = array('available' => '0','quantity' => '0');
  }
   
    return $data;
  }
  public static function get_menu_items($unit_id,$view) {
    if ($view=="veg") {
        $data = DB::table('unit_menu_items')->where('unit_id', $unit_id)->where('veg_nonveg', $view)->get();
    }else {
      $data = DB::table('unit_menu_items')->where('unit_id', $unit_id)->get();
    }  
    
    return $data;
  }
  public static function get_menu_item_name($item_id) {   
    $data = DB::table('unit_menu_items')->where('id', $item_id)->get();
    $item_name = "";
    foreach ($data as $key => $value) {
      $item_name = $value->item_name;
    }
    return $item_name;
  }
  public static function get_menu_item_price($item_id) {   
    $data = DB::table('unit_menu_items')->where('id', $item_id)->get();
    $item_price = 0;
    foreach ($data as $key => $value) {
      $item_price = $value->price;
    }
    return $item_price;
  }
  public static function get_menu_item_details($item_id) {   
    $data = DB::table('unit_menu_items')->where('id', $item_id)->get();
   
    return $data;
  }
  public static function get_menu_items_category_id($food_category_id,$view) { 
    if ($view=="veg") {
      $data = DB::table('unit_menu_items')->where('food_category_id', $food_category_id)->where('veg_nonveg', $view)->get();
    }else {
      $data = DB::table('unit_menu_items')->where('food_category_id', $food_category_id)->get();
    }
    
    return $data;
  }
  public static function get_food_category_name($category_id) {   
    $data = DB::table('food_categories')->where('id',$category_id)->get();
    $category_name = "";
    foreach ($data as $key => $value) {
      $category_name = $value->category_name;
    }
    return $category_name;
  }
  public static function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}
  public static function get_unit_revenue($unit_id) {
      $db = DB::table('wall_history')
      ->where('unit_id',$unit_id)
      ->where('identifier','payment')
      ->whereDate('wall_history.created_at',Carbon\Carbon::today())
      ->get();
      $amount = 0;
        $net_amount = 0;
        $refund_status = "no";
        $refund_amount = 0;
        $refund_count = 0;
        foreach ($db as $key => $value) {   
          $net_amount+= $value->final_amount;
          $refund_status = $value->refund;
          $refund_amount+= $value->refund_amount;
          if ($refund_status=="yes") {
            $refund_count++;
          }
        }

        $amount = $net_amount + $refund_amount;

        return array('amount' => $amount, 'refund' => $refund_amount,'net_amount' => $net_amount, 'number_transactions' => count($db),'refund_count' => $refund_count);
  }
  public static function get_unit_notifications() {   
    $data = DB::table('unit_notifications')->get();
   
    return $data;
  }
  public static function checknewbookings($email) {
    $unit_id = Helper::get_unit_manager_id($email);
    $count = DB::table('wall_history')
         ->where('unit_id', $unit_id)
         ->where('identifier','payment')
         ->whereDate('created_at', Carbon\Carbon::today())
         ->count();

    return $count;

  }
  public static function check_if_unit_suspended($email) {
      $data = DB::table('units')->where('unit_email',$email)->get();
      $suspend = "no";
      foreach ($data as $key => $value) {
        $suspend = $value->suspended;
      }

    return $suspend;
  }
  
  public static function get_unit_manager_id($email) {
     $db = DB::table('units')->where('unit_email', $email)->get();
     return $db[0]->id;
  }
  public static function checkaddonfields($item_id) {
     $db = DB::table('unit_menu_items_add_ons')->where('item_id', $item_id)->count();
     $status = "0";
     if ($db != 0) {
       $status = "1";
     }
     return $status;
  }
  public static function recivepayment_process($phone, $amount, $unit_id) {
       $checkuser = App\User::where('phone',$phone)->get();
         $data = array();
         $date = date("Y-m-d H:i:s");
         $otp = Helper::generatePIN();
         $wall_am = 0;
         if (count($checkuser) != 0) {
          foreach ($checkuser as $key => $value) {
            $wall_am = $value->wall_am;
          }
          $wallet = Crypt::decrypt($wall_am);
          if ($wallet >= $amount) {
            $insert = DB::table('recieve_pay')->insert(['unit_id' => $unit_id,'phone' => $phone,'amount' => $amount,'otp' => $otp,'created_at' => $date, 'updated_at' => $date]);
            $units = Helper::get_unit_info($unit_id);
            $unit_name = "";
            foreach ($units as $key => $value) {
              $unit_name = $value->unit_name;
            }
            $content = "OTP for payment to ".$unit_name.", The Grand Venice is ".$otp.", of Rs.".$amount."/-";
            Helper::send_otp($phone,$content);
            $data = array('status' => 'success','message' => 'OTP Sent');
          }else {
            $data = array('status' => 'insufficient','message' => 'insufficient balance');
          }
           
         }else {
           $data = array('status' => 'user_not_found','message' => 'User not found');
         }
         return $data;
    }

    public static function checkotp_process($phone, $otp) {
         $checkotp = DB::table('recieve_pay')->where('phone', $phone)->where('otp', $otp)->get();
         $users = App\User::where('phone',$phone)->get();
         $user_id = 0;
         $current_balance = 0;
         foreach ($users as $key => $value) {
           $user_id = $value->id;
           $current_balance = Crypt::decrypt($value->wall_am);
           $name = $value->name;
         }
         $trans_id = uniqid(mt_rand(),true);
         $order_id = "GV/WP/".Helper::generatePIN(6);
         $payment_method = "gv_pocket";
         $data = array();
         if (count($checkotp)==0) {
           $data = array('status' => 'failed', 'message' => 'Otp mismatch!');
         }else {
          $amount = 0;
          $unit_id = 0;
          foreach ($checkotp as $key => $value) {
            $amount = $value->amount;
            $unit_id = $value->unit_id;
          }
           Helper::process_payment($name, $phone, $unit_id,$amount,$user_id,$trans_id,$payment_method,$order_id,$current_balance);
           $data = array('status' => 'success', 'message' => 'Success, You have recieved Rs.'.$amount);
         }
         return $data;
    }
  
  public static function get_unit_info($id) {   
    $data = DB::table('units')
            ->join('unit_categories','unit_categories.id','=','units.unit_category_id')
            ->select(DB::raw('units.*'), DB::raw('unit_categories.unit_category_name'))
            ->where('units.id',$id)
            ->get();
    return $data;
  }
  public static function get_wallet_revenue_by_day($parameter) {
   $topfinal = 0;
  

    $topupdata = DB::table('wall_history')
             ->where('wall_history.identifier','topup');

            if ($parameter=="todays") {
              $topupdata = $topupdata->whereDate('wall_history.created_at',Carbon\Carbon::today());
            }elseif($parameter=="monthly") {
               $now = Carbon\Carbon::now();
               $month = $now->month;
              $topupdata = $topupdata->whereMonth('wall_history.created_at',$month);
            }elseif($parameter=="total") {
             
            }elseif($parameter=="lastmonth") {
              $month = new Carbon\Carbon('last month');
              $topupdata = $topupdata->whereMonth('wall_history.created_at',$month);
            }
             
            $topupdata = $topupdata->get();
            
    $topupamount = 0;
    foreach ($topupdata as $key => $value) {
         $topupamount += $value->final_amount;
    }  

    


    $serdata = DB::table('wall_history')
             ->where('wall_history.identifier','service');
            if ($parameter=="todays") {
              $serdata = $serdata->whereDate('wall_history.created_at',Carbon\Carbon::today());
            }elseif($parameter=="monthly") {
               $now = Carbon\Carbon::now();
               $month = $now->month;
              $serdata = $serdata->whereMonth('wall_history.created_at',$month);
            }elseif($parameter=="total") {
             
            }elseif($parameter=="lastmonth") {
              $month = new Carbon\Carbon('last month');
              $serdata = $serdata->whereMonth('wall_history.created_at',$month);
            }
            
            $serdata = $serdata->get();
    $servamount = 0;
    foreach ($serdata as $key => $value) {
         $servamount += $value->final_amount;
    } 

  

     $paydata = DB::table('wall_history')
             ->where('wall_history.identifier','payment');
            if ($parameter=="todays") {
              $paydata = $paydata->whereDate('wall_history.created_at',Carbon\Carbon::today());
            }elseif($parameter=="monthly") {
               $now = Carbon\Carbon::now();
               $month = $now->month;
              $paydata = $paydata->whereMonth('wall_history.created_at',$month);
            }elseif($parameter=="total") {
             
            }elseif($parameter=="lastmonth") {
              $month = new Carbon\Carbon('last month');
              $paydata = $paydata->whereMonth('wall_history.created_at',$month);
            }
      
            $paydata = $paydata->get();
    $payamount = 0;
    foreach ($paydata as $key => $value) {
         $payamount += $value->final_amount;
    } 
   

    $finalamount = $topupamount - $servamount - $payamount;   
    return $finalamount;
    
  }
  public static function get_wallet_revenue($date) { 
    $topfinal = 0;
   //previous
    $topupdata2 = DB::table('wall_history')
             ->whereDate('wall_history.created_at', '<',Carbon\Carbon::parse($date))
            ->where('wall_history.identifier','topup')
            ->get();
    $topupamount2 = 0;
    foreach ($topupdata2 as $key => $value) {
         $topupamount2 += $value->final_amount;
    }  

    $topupdata = DB::table('wall_history')
             ->whereDate('wall_history.created_at',Carbon\Carbon::parse($date))
            ->where('wall_history.identifier','topup')
            ->get();
    $topupamount = 0;
    foreach ($topupdata as $key => $value) {
         $topupamount += $value->final_amount;
    }  

    $topfinal = $topupamount + $topupamount2;

    //previous
    $serdata2 = DB::table('wall_history')
            ->whereDate('wall_history.created_at','<',Carbon\Carbon::parse($date))
            ->where('wall_history.identifier','service')
            ->get();
    $servamount2 = 0;
    foreach ($serdata2 as $key => $value) {
         $servamount2 += $value->final_amount;
    }   


    $serdata = DB::table('wall_history')
            ->whereDate('wall_history.created_at',Carbon\Carbon::parse($date))
            ->where('wall_history.identifier','service')
            ->get();
    $servamount = 0;
    foreach ($serdata as $key => $value) {
         $servamount += $value->final_amount;
    } 

    $serfinal = $servamount2 + $servamount;  

   $paydata2 = DB::table('wall_history')
            ->whereDate('wall_history.created_at','<',Carbon\Carbon::parse($date))
            ->where('wall_history.identifier','payment')
            ->get();
    $payamount2 = 0;
    foreach ($paydata2 as $key => $value) {
         $payamount2 += $value->final_amount;
    } 

     $paydata = DB::table('wall_history')
            ->whereDate('wall_history.created_at',Carbon\Carbon::parse($date))
            ->where('wall_history.identifier','payment')
            ->get();
    $payamount = 0;
    foreach ($paydata as $key => $value) {
         $payamount += $value->final_amount;
    } 
    $payfinal = $payamount2 + $payamount;  
    

    $finalamount = $topfinal - $serfinal - $payfinal;   
    return $finalamount;

  }
  public static function get_wallet_data($parameter) {
    $amount = 0;
    if ($parameter=="todays") {
      $data = DB::table('wall_history')
            ->whereDate('wall_history.created_at',Carbon\Carbon::today())
            ->where('wall_history.identifier','topup')
            ->get();
                 
      foreach ($data as $key => $value) {
        $amount = $value->final_amount; 
      }
    }
    return $amount;
    
  }
  public static function get_services() {
     $data = DB::table('services')->get();
    return $data;
  }
  public static function get_services_details($serviceid) {
    $db = DB::table('services')->where('id',$serviceid)->get();
    return $db;
  }
  
  public static function get_user_type($email) {
      $data = DB::table('admins')
            ->where('admins.email',$email)
            ->get();
           $user_type = "";
      foreach ($data as $key => $value) {
          $user_type = $value->user_type;     
     } 
     return $user_type;
  }
  public static function get_packs_details($packid) {
    $db = DB::table('packs')->where('id',$packid)->get();
    return $db;
  }

  public static function get_guest_services() {   
    $data = DB::table('guest_services')->get();
   
    return $data;
  }
  public static function get_comments($id) {   
    $data = DB::table('lead_comments')
            ->where('lead_id',$id)
            ->orderBy('id','desc')
            ->get();
    return $data;
  }
   public static function claimed_checked($lead_id) {   
    $data = DB::table('lead_claim')->where('lead_id',$lead_id)->get();
    return $data;
  }
   public static function claimed_checked_all() {   
    $data = DB::table('lead_claim')->get();
    return $data;
  }
  public static function get_analyst_name($uid) {
    $db = DB::table('admins')->where('id',$uid)->get();
    $name = "";
    foreach ($db as $key => $value) {
      $name = $value->name;
    }
    return $name;
  }
 public static function get_number_of_ratings($service_id,$type) {   
    $data = DB::table('feedbacks')->where('service_id',$service_id)->where('type',$type)->count();
   
    return $data;
  }
  public static function get_recharg_history($parameter) {   
    $data = DB::table('wall_history')->where('identifier','topup');

    if ($parameter=="todays") {
      $data = $data->whereDate('created_at',Carbon\Carbon::today());

    }elseif ($parameter=="monthly") {
       $data = $data->whereMonth('created_at',Carbon\Carbon::now()->month);
    }else {

    }
    $data = $data->where('payment_method','cash');
    $data = $data->get();
    $amount = 0;
    foreach ($data as $key => $value) {
      $amount += $value->final_amount;
    }
   
    return $amount;
  }
  public static function get_reviews($orderid,$service_id) {   
    $data = DB::table('feedbacks')
            ->where('order_id',$orderid)
            ->where('service_id',$service_id)
            ->get();
   
    return $data;
  }
  public static function get_average_ratings($service_id,$type) {   
    $rating1 = DB::table('feedbacks')
    ->where('service_id',$service_id)
    ->where('type',$type)
    ->where('rating',1)
    ->get();

     $rating2 = DB::table('feedbacks')
    ->where('service_id',$service_id)
    ->where('type',$type)
    ->where('rating',2)
    ->get();
     $rating3 = DB::table('feedbacks')
    ->where('service_id',$service_id)
    ->where('type',$type)
    ->where('rating',3)
    ->get();
     $rating4 = DB::table('feedbacks')
    ->where('service_id',$service_id)
    ->where('type',$type)
    ->where('rating',4)
    ->get();
     $rating5 = DB::table('feedbacks')
    ->where('service_id',$service_id)
    ->where('type',$type)
    ->where('rating',5)
    ->get();
    $rtotal1 = 0;
    foreach ($rating1 as $key => $value) {
      $rtotal1 += $value->rating;
    }
    $rtotal2 = 0;
    foreach ($rating2 as $key => $value) {
      $rtotal2 += $value->rating;
    }
    $rtotal3 = 0;
    foreach ($rating3 as $key => $value) {
      $rtotal3 += $value->rating;
    }
     $rtotal4 = 0;
    foreach ($rating4 as $key => $value) {
      $rtotal4 += $value->rating;
    }
      $rtotal5 = 0;
    foreach ($rating5 as $key => $value) {
      $rtotal5 += $value->rating;
    }


     $totaluser = count($rating1) + count($rating2) + count($rating3) + count($rating4) + count($rating5);
   
    if ($totaluser==0) {
      $average_rating = 0;
    }else {
     
      $sumofmaxrating = $totaluser * 5;
      $sumrating = $rtotal1 + $rtotal2 + $rtotal3 + $rtotal4 + $rtotal5;
      $average_rating = $sumrating * 5 / $sumofmaxrating; 
    }
    
   
    return number_format($average_rating,'1');
  }
   public static function get_reports_service_total($service_id,$from, $to,$type3) {  
   if ($from=="all" && $to=="all") {
      $data = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))  
        ->where('bookings.type','service');
        if ($service_id != 0) {
         $data = $data->where('bookings.service_id',$service_id);    
        }
        if ($type3=='all') {
          # code...
        }else {
          if ($type3=='online') {
            $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
          }elseif($type3=='offline') {
            $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
          }else {
             $data = $data->where('payment_method',$type3);
          }
        }
       
                             
        $data = $data->orderBy('bookings.created_at','desc')
        ->get();
    }elseif ($from=="yesterday" && $to=="yesterday") {
    
      $month = new Carbon\Carbon('yesterday');
     $data = DB::table('bookings')
    ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))  
        ->where('bookings.type','service')
        ->whereDate('bookings.created_at', $month); 
        if ($service_id != 0) {
         $data = $data->where('bookings.service_id',$service_id);    
        }
        if ($type3=='all') {
          # code...
        }else {
          if ($type3=='online') {
            $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
          }elseif($type3=='offline') {
           $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
          }else {
             $data = $data->where('payment_method',$type3);
          }
        }
       
              
       $data = $data->orderBy('bookings.created_at','desc')
        ->get();

    }elseif ($from=="monthly" && $to=="monthly") {
    
     $now = Carbon\Carbon::now();
     $month = $now->month;
     $data = DB::table('bookings')
       ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))  
        ->where('bookings.type','service');
        
       if ($service_id != 0) {
         $data = $data->where('bookings.service_id',$service_id);    
      }
        if ($type3=='all') {
          # code...
        }elseif ($type3=='online') {
             $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
        }elseif($type3=='offline') {
           $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
        }else {
             $data = $data->where('payment_method',$type3);
        }
        
      $data = $data->whereMonth('bookings.created_at', $month)
      ->orderBy('bookings.created_at','desc')
        ->get();

    }elseif ($from=="lastmonth" && $to=="lastmonth") {
    
      $month = new Carbon\Carbon('last month');

     $data = DB::table('bookings')
          ->leftjoin('service_options','bookings.optional','=','service_options.id')  
          ->select(DB::raw('bookings.*'),
           DB::raw('service_options.option_name as option_name'))  
          ->where('bookings.type','service');
          if ($service_id != 0) {
             $data = $data->where('bookings.service_id',$service_id);    
          }
         if ($type3=='all') {
          # code...
        }elseif ($type3=='online') {
            $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
          }elseif($type3=='offline') {
           $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
          }else {
             $data = $data->where('payment_method',$type3);
          }
        
          $data = $data->whereMonth('bookings.created_at', $month)                                       
          ->orderBy('bookings.created_at','desc')
          ->get();

    } elseif ($from=="todays" && $to=="todays") {
     $data = DB::table('bookings')
     ->where('type','service')
     ->where('status','success');
       if ($service_id != 0) {
         $data = $data->where('bookings.service_id',$service_id);    
      }
       if ($type3=='all') {
          # code...
        }else {
          if ($type3=='online') {
           $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
          }elseif($type3=='offline') {
           $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
          }else {
             $data = $data->where('payment_method',$type3);
          }
        }
       $data = $data->whereDate('bookings.created_at',Carbon\Carbon::today())
     ->get();
    } else {
          $date = strtotime("+1 day", strtotime($to));
          $to = date("Y-m-d", $date);

         if ($from==$to) {
          $data = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))  
        ->where('bookings.type','service');
         if ($service_id != 0) {
         $data = $data->where('bookings.service_id',$service_id);    
      }
        if ($type3=='all') {
          # code...
        }elseif ($type3=='online') {
           $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
       }elseif($type3=='offline') {
          $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
        }else {
             $data = $data->where('payment_method',$type3);
        }
        
         $data = $data->whereDate('bookings_packs.created_at', $from) 
        ->whereDate('bookings_packs.created_at', $to)                           
        ->orderBy('bookings.created_at','desc')
        ->get();
         }else {
      
          $data = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))  
        ->where('bookings.type','service');
        if ($service_id != 0) {
         $data = $data->where('bookings.service_id',$service_id);    
      }
         if ($type3=='all') {
          # code...
        }else {
          if ($type3=='online') {
           $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
          }elseif($type3=='offline') {
          $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
          }else {
             $data = $data->where('payment_method',$type3);
          }
        }
         $data = $data->whereBetween('bookings.created_at', [$from, $to])            
                           
        ->get();
         }
    }
    
    $amount = 0;
    $quantity = 0;
    foreach ($data as $key => $value) {
      $amount += $value->price + $value->tax;
      $quantity += $value->quantity;
    }
   
    return array('amount' => $amount, 'quantity' => $quantity);
  }
   public static function get_reports_packs_total($service_id,$from, $to,$type3) { 
   if ($from=="all" && $to=="all") {
     $data = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
            DB::raw('service_options.option_name as option_name'));
          if ($service_id != 0) {
            $data = $data->where('pack_id',$service_id);
          }
           if ($type3=='all') {
          # code...
        }else {
          if ($type3=='online') {
            $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
          }elseif($type3=='offline') {
          $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
          }else {
             $data = $data->where('payment_method',$type3);
          }
        }
         
          $data = $data->orderBy('bookings_packs.created_at','desc')
          ->get();
   } elseif ($from=="todays" && $to=="todays") {

      $data = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
            DB::raw('service_options.option_name as option_name')); 
           if ($service_id != 0) {
            $data = $data->where('pack_id',$service_id);
          }
           if ($type3=='all') {
          # code...
        }else {
          if ($type3=='online') {
             $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
          }elseif($type3=='offline') {
          $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
          }else {
             $data = $data->where('payment_method',$type3);
          }
        }
           $data = $data->whereDate('bookings_packs.created_at',Carbon\Carbon::today())
          ->orderBy('bookings_packs.created_at','desc')
          ->get();

    }elseif ($from=="monthly" && $to=="monthly") {
    
     $now = Carbon\Carbon::now();
     $month = $now->month;
     $data = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
            ->select(DB::raw('bookings_packs.*'),
            DB::raw('service_options.option_name as option_name')); 
           if ($service_id != 0) {
            $data = $data->where('pack_id',$service_id);
           }
        if ($type3=='all') {
          # code...
        }elseif ($type3=='online') {
             $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
        }elseif($type3=='offline') {
          $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
        }else {
          $data = $data->where('payment_method',$type3);
        }
        
           $data = $data->whereMonth('bookings_packs.created_at',$month)
          ->orderBy('bookings_packs.created_at','desc')
          ->get();
        
    }elseif ($from=="lastmonth" && $to=="lastmonth") {
    
    $month = new Carbon\Carbon('last month');

      $data = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
            DB::raw('service_options.option_name as option_name')); 
           if ($service_id != 0) {
            $data = $data->where('pack_id',$service_id);
          }  
            if ($type3=='all') {
          # code...
        }else {
          if ($type3=='online') {
             $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
          }elseif($type3=='offline') {
          $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
          }else {
             $data = $data->where('payment_method',$type3);
          }
        }
           $data = $data->whereMonth('bookings_packs.created_at', $month)     
          ->orderBy('bookings_packs.created_at','desc')
          ->get();         

    } elseif ($from=="yesterday" && $to=="yesterday") {
    
    $month = new Carbon\Carbon('yesterday');

    $data = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
            DB::raw('service_options.option_name as option_name')); 
           if ($service_id != 0) {
            $data = $data->where('pack_id',$service_id);
          } 
          if ($type3=='all') {
          # code...
        }else {
          if ($type3=='online') {
             $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
          }elseif($type3=='offline') {
          $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
          }else {
             $data = $data->where('payment_method',$type3);
          }
        }
           $data = $data->whereDate('bookings_packs.created_at', $month) 
            ->where('bookings_packs.status','success')
          ->orderBy('bookings_packs.created_at','desc')
          ->get();         

    }else {
    $data = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
            DB::raw('service_options.option_name as option_name')); 
           if ($service_id != 0) {
            $data = $data->where('pack_id',$service_id);
          } 
           if ($type3=='all') {
          # code...
        }else {
          if ($type3=='online') {
            $whereData = ['instamojo','bookmyshow'];
            $data = $data->whereIn('payment_method',$whereData);
          }elseif($type3=='offline') {
         $whereData = array(array('payment_method','!=','instamojo'), array('payment_method','!=','bookmyshow'));
          $data = $data->where($whereData);
          }else {
             $data = $data->where('payment_method',$type3);
          }
        }
        if ($from==$to) {
           $data = $data->whereDate('bookings_packs.created_at', $from)
                      ->whereDate('bookings_packs.created_at', $to);
        }else {
           $data = $data->whereBetween('bookings_packs.created_at', [$from, $to]);
        }
          
          $data = $data->orderBy('bookings_packs.created_at','desc')
          ->get();
   }  
    
   $amount = 0;
    $quantity = 0;
    foreach ($data as $key => $value) {
      $amount += $value->price + $value->tax;
      $quantity += $value->quantity;
    }
   
    return array('amount' => $amount, 'quantity' => $quantity);
  }

  public static function rand_color() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
  }
  public static function get_order_details($order_id,$service_id,$type) {
    if ($type=="service") {
      $db = DB::table('bookings')->where('order_id',$order_id)->where('service_id',$service_id)->get();
    }else {
      $db = DB::table('bookings_packs')->where('order_id',$order_id)->where('pack_id',$service_id)->get();
    }
    $amount=0;
    $quantity = 0;
    foreach ($db as $key => $value) {
      $amount = $value->price + $value->tax;
      $quantity = $value->quantity;
    }
    return array('quantity' => $quantity, 'amount' => $amount);
  }
  public static function get_statistics_details($order_date,$service_id,$type,$type3) {
    if ($type=="service") {
      $db = DB::table('bookings')
      ->whereDate('created_at',$order_date)
      ->where('service_id',$service_id)
      ->where('type','service');
       if ($type3=='all') {
          # code...
        }else {
          if ($type3=='online') {
            $db = $db->where('payment_method','instamojo');
          }elseif($type3=='offline') {
          $db = $db->where('payment_method','!=','instamojo');
          }else {
             $db = $db->where('payment_method',$type3);
          }
        }
      $db = $db->get();
    }elseif($type=="events") {
      $db = DB::table('booking_events')
      ->whereDate('created_at',$order_date)
      ->where('event_id',$service_id);
       if ($type3=='all') {
          # code...
        }else {
          if ($type3=='online') {
            $db = $db->where('payment_method','instamojo');
          }elseif($type3=='offline') {
          $db = $db->where('payment_method','!=','instamojo');
          }else {
             $db = $db->where('payment_method',$type3);
          }
        }
       $db = $db->get();
    }else {
      $db = DB::table('bookings_packs')
      ->whereDate('created_at',$order_date)
      ->where('pack_id',$service_id);
       if ($type3=='all') {
          # code...
        }else {
          if ($type3=='online') {
            $db = $db->where('payment_method','instamojo');
          }elseif($type3=='offline') {
          $db = $db->where('payment_method','!=','instamojo');
          }else {
             $db = $db->where('payment_method',$type3);
          }
        }
       $db = $db->get();
    }
    $amount=0;
    $quantity = 0;
    $totaltrans = 0;
    foreach ($db as $key => $value) {
      $amount += $value->price + $value->tax;
      $quantity += $value->quantity;
    }
    return array('quantity' => $quantity, 'amount' => $amount,'transno' => count($db));
  }
   public static function get_pack_services($pack_id) {
     $data = DB::table('bookings')->where('book_pack_id',$pack_id)->get();

     $serviceid = "";
     foreach ($data as $key => $value) {
     
       $serviceid .= $value->service_id.",";
     }

     return rtrim($serviceid,",");
  }

  public static function get_manager($type, $email) {

     if ($type=="app") {
      $manager = DB::table('admins')
    ->where('admins.user_type','manager')
    ->where('admins.email',$email)
    ->get();
     $manager_id = 0;
      foreach ($manager as $key => $value) { 
        $manager_id = $value->id;      
      }
      
    }else {
       $manager_id = Auth::user()->id;
    }
    
      $manager = DB::table('admins')
    ->join('member_services','admins.id','=','member_services.member_id')
    ->where('admins.user_type','manager')
    ->where('admins.id',$manager_id)
    ->get();
     $serviceid = array();
    foreach ($manager as $key => $value) {
      list($a, $b) = explode('_', $value->service_id);
      $serviceid[] = $a;
    }

    return $serviceid;
  }
  
  public static function get_events() {   
    $data = DB::table('events')->get();
   
    return $data;
  }
  public static function truncate($text, $length) {
   $length = abs((int)$length);
   if(strlen($text) > $length) {
      $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
   }
   return($text);
  }
  public static function get_category_details($service_id) {   
    $data = DB::table('services')
    ->leftjoin('categories','services.category_id','=','categories.id')
    ->select(DB::raw('categories.*'))
    ->where('services.id',$service_id)
    ->get();
   
    return $data;
  }
  public static function get_all_categories() {   
    $data = DB::table('categories')->get();
    return $data;
  }
   public static function get_rates($service_id, $date, $arrival_time,$quantity,$optional,$type,$occasion_type,$rate_type) {
      $time_from = $arrival_time;
      $time_to = date('h:i A',strtotime('+15 minutes',strtotime($time_from)));
      $holidays = DB::table('holidays')->where('date',$date)->get();
   
      $day = date('l', strtotime($date));

      if ($occasion_type==0) {
        if ($rate_type=="online") {
           $rates = DB::table('rates')
      ->where('service_id',$service_id)
      ->where('type',$type);
      if (count($holidays)==0) {
       $rates = $rates->whereRaw('find_in_set(?, rates.days)', [$day]);
      }
      $rates = $rates->where('rate_type','online')
      ->get();
        }else {
           $rates = DB::table('rates')
      ->where('service_id',$service_id)
      ->where('type',$type);
      
       if (count($holidays)==0) {
       $rates = $rates->whereRaw('find_in_set(?, rates.days)', [$day]);
      }
       $rates = $rates->where('rate_type','offline')
      ->get();
        }
       
      }else {
          if ($rate_type=="online") {
             $rates = DB::table('rates')
      ->where('service_id',$service_id)
      ->where('type',$type)
      ->where('occasion_type',$occasion_type);
       if (count($holidays)==0) {
       $rates = $rates->whereRaw('find_in_set(?, rates.days)', [$day]);
     }
      $rates = $rates->where('rate_type','online')
      ->get();


          }else {
             $rates = DB::table('rates')
      ->where('service_id',$service_id)
      ->where('type',$type)
      ->where('occasion_type',$occasion_type);
       if (count($holidays)==0) {
      $rates = $rates->whereRaw('find_in_set(?, rates.days)', [$day]);

    }
       $rates = $rates->where('rate_type','offline')
      ->get();

          }
       
      }
      
     $fromtime = strtotime(urldecode($time_from));
     $totime = strtotime(urldecode($time_to));
     $price = 0;
     $rate_id = 0;
     $pricearray = array();
     foreach ($rates as $key => $value) {
       $from = $value->fromtime;
       $to = $value->totime;
      
       if (strtotime($from) <= $fromtime && strtotime($to) >= $totime) {
        $pricearray[] = $value->rates;
         $price = $value->rates;
          $rate_id = $value->id;
       }
     }

     $price = max($pricearray);

     if ($type=="service") {
        $services = Helper::get_service($service_id);
       $tax_id = 0;
       foreach ($services as $key => $value) {
       $tax_id = $value->tax_id;
       $tax_type = $value->tax_type;
       }

     }else {
       $packs = DB::table('packs')->where('id',$service_id)->get();
       $tax_id = 0;
       foreach ($packs as $key => $value) {
       $tax_id = $value->tax_id;
       $tax_type = $value->tax_type;
       }
     }

    
     


     $taxes = Helper::get_taxes($tax_id);
     $tax_percent = 0;
     foreach ($taxes as $key => $value) {
       $tax_percent = $value->tax_percent;
     }

     $mainprice = 0;
     $squantity = 0;
     $rate_conditions = DB::table('rate_conditions')->where('rate_id', $rate_id)->get();
     if (count($rate_conditions) > 0) {
      foreach ($rate_conditions as $key => $value) {
        $squantity = $value->quantity;
        if ($squantity==$quantity) {
         $mainprice = $value->price;
        }else {
         $mainprice = $price * $quantity;
        }
       }
     }else {
      $mainprice = $price * $quantity;
     }

     $taxprice = 0;
     $taxprice = $mainprice * $tax_percent/100;
     $fprice = 0;

     if ($tax_type=="no") {    
      $mainprice = $mainprice; 
       $fprice = $mainprice + $taxprice;
     }else {
        $mainprice = $mainprice - $taxprice;
        $fprice = $mainprice + $taxprice;
     }

      $checkbookings = DB::table('bookings')
     ->where('date',$date)
     ->where('time',$arrival_time)
     ->where('optional',$optional)
     ->get();

     $options = DB::table('service_options')->where('id',$optional)->get();
     $capacity = 0;
     foreach ($options as $key => $value) {
       $capacity = $value->capacity;
     }

     $data = array();

      $data[] = array('price' => round($mainprice), 'final_price' => round($fprice),'tax_amount' => round($taxprice));
      
      return $data;
    }
   public static function get_order_items($orderid) {
      $db = DB::table('bookings')
      ->leftjoin('service_options','bookings.optional','=','service_options.id')
      ->select(DB::raw('bookings.*'),
        DB::raw('service_options.option_name'))
      ->where('order_id',$orderid)
      ->where('type','service')
      ->get();
      return $db;
    }
    public static function get_service($service_id) {
      $db = DB::table('services')->where('id', $service_id)->get();
      return $db;
    }
    public static function get_taxes($tax_id) {
      $db = DB::table('taxes')->where('id', $tax_id)->get();
      return $db;
    }

     public static function send_otp($mobile,$content) {
     $content = urlencode($content);
     $Url = "http://182.18.182.46/vendorsms/pushsms.aspx?user=Striker&password=striker&msisdn=".$mobile."&sid=VENICE&msg=".$content."&fl=0&gwid=2";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $Url);
     curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
     curl_setopt($ch, CURLOPT_HEADER, 0);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_TIMEOUT, 10);
     $output = curl_exec($ch);
     $errmsg = curl_error($ch);
     $cInfo = curl_getinfo($ch);
     curl_close($ch);
     return $output;
  }
   public static function send_multiple_otp($mobile,$content) {
     $content = urlencode($content);
     $Url = "http://182.18.182.46/vendorsms/pushsms.aspx?user=Striker&password=striker&msisdn=".$mobile."&sid=VENICE&msg=".$content."&fl=0&gwid=2";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $Url);
     curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
     curl_setopt($ch, CURLOPT_HEADER, 0);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_TIMEOUT, 10);
     $output = curl_exec($ch);
     $errmsg = curl_error($ch);
     $cInfo = curl_getinfo($ch);
     curl_close($ch);
     return $output;
  }
  public static function generatePIN($digits = 4){
    $i = 0; //counter
    $pin = ""; //our default pin is blank.
    while($i < $digits){
        //generate a random number between 0 and 9.
        $pin .= mt_rand(0, 9);
        $i++;
    }
    return $pin;
   }
   
  public static function get_packs_price($quantity, $pack_id) {
      $db = DB::table('packs')
      ->join('taxes','packs.tax_id','=','taxes.id')
      ->select(DB::raw('packs.*'),
        DB::raw('taxes.tax_percent as tax_percent'))
      ->where('packs.id', $pack_id)
      ->get();
        $tax_percent = "";
        $price = 0;
        $tax_type = 0;
      foreach ($db as $key => $value) {
        $tax_percent = $value->tax_percent;
        $price = $value->price;
        $tax_type = $value->tax_type;
      }
      $calprice = $price * $quantity;

      $caltax = $calprice * $tax_percent/100;
      
      if ($tax_type=="no") {    
       $mainprice = $calprice; 
       $fprice = $calprice + $caltax;
     }else {
        $mainprice = $calprice - $caltax;
        $fprice = $mainprice + $caltax;
     }

     $data[] = array('price' => $mainprice, 'final_price' => $fprice,'tax_amount' => $caltax);
  
      return $data;
   }
   public static function get_pack_details($order_id) {
      $db = DB::table('bookings_packs')
            ->leftjoin('packs','bookings_packs.pack_id','=','packs.id')
            ->leftJoin('service_options','bookings_packs.optional','=','service_options.id')
            ->leftJoin('occasion_type','occasion_type.id','=','bookings_packs.occasion_type')
            ->select(DB::raw('bookings_packs.*'),
              DB::raw('packs.pack_type as pack_type'),
              DB::raw('service_options.option_name as option_name'),
              DB::raw('occasion_type.type as type'),
              DB::raw('occasion_type.cuisine as cuisine'))
            ->where('order_id',$order_id)
            ->get();
      return $db;
   }
    public static function get_service_details($order_id) {
     $db = DB::table('bookings')
      ->join('services','bookings.service_id','=','services.id')
       ->leftJoin('service_options','bookings.optional','=','service_options.id')
      ->select(DB::raw('bookings.*'),
       DB::raw('services.alias as alias'),
       DB::raw('service_options.option_name as option_name'))
      ->where('bookings.order_id',$order_id)
      ->where('bookings.type','service')
      ->get();
      return $db;
   }
   public static function get_occassion_type($id) {
    $db = DB::table('occasion_type')->where('id',$id)->get();
    $occasion_type = "";
    foreach ($db as $key => $value) {
      $occasion_type = $value->type."-".$value->cuisine;
    }
    return $occasion_type;

   }
   public static function get_booking_amount($userid) {

      $db = DB::table('bookings')
          ->where('bookings.user_id',$userid)
          ->groupBy('bookings.order_id')
          ->get();

      $db2 = DB::table('booking_events')
          ->where('booking_events.user_id',$userid)
          ->groupBy('booking_events.order_id')
          ->get();    

     $amount = 0;
     $data = array(); 
     $date = "";   

     foreach ($db as $key => $value) {
        $amount += $value->amount;
        $date = $value->created_at;
        
     } 
     $no_of_bookings = count($db) + count($db2);
     $data = array('amount' => $amount, 'no_of_bookings' => $no_of_bookings,'date' => $date);
     foreach ($db2 as $key => $value) {
        $amount += $value->amount;
       $date = $value->created_at;
     } 
     $data = array('amount' => $amount, 'no_of_bookings' => $no_of_bookings,'date' => $date);
     return $data;    

   }
   public static function get_todays_bookings($email,$type) {
    $date = date('d-m-Y');
    $user_type = "";
    $manager_id = 0;

    if ($type=="app") {
      $manager = DB::table('admins')
    ->where('admins.user_type','manager')
    ->where('admins.email',$email)
    ->get();
     $manager_id = 0;
      foreach ($manager as $key => $value) {
      $manager_id = $value->id;
      $user_type = $value->user_type;
      
      }
      
    }else {
      $manager_id = Auth::user()->id;
        $user_type = Auth::user()->user_type;
    }
    
        $data = array();
    if ($user_type=="superadmin" || $user_type=="analyst" || $user_type=="lead_manager" || $user_type=="pos" || $user_type=="leadanalyst" || $user_type=="editor") {

         $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))          
            ->where('bookings.date',$date)  
             ->where('bookings.status','success')
              ->where('bookings.refund','no')
             ->where('type','service')
            ->orderBy('bookings.id','desc')
            ->get();


            $db2 = DB::table('bookings_packs') 
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
             ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))  
             ->where('bookings_packs.date',$date) 
             ->where('bookings_packs.status','success')
             ->where('bookings_packs.refund','no')
            ->orderBy('bookings_packs.id','desc')
            ->get();

     foreach ($db2 as $key => $value) {
      $service_id = $value->pack_id;
      $optional = $value->optional;
      $data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->pack_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'service_id' => $value->pack_id,'type' => $value->type,'payment_method' => $value->payment_method,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin,'option_name' => $value->option_name,'occasion_type' => $value->occasion_type);
    }      

    foreach ($db as $key => $value) {
      $service_id = $value->service_id;
      $optional = $value->optional;

      $data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->service_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'option_name' => $value->option_name,'service_id' => $value->service_id,'type' => $value->type,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin,'payment_method' => $value->payment_method,'occasion_type' => '0');

      
    }
    }else {
        $manager = DB::table('admins')
    ->join('member_services','admins.id','=','member_services.member_id')
    ->where('admins.user_type','manager')
    ->where('admins.id',$manager_id)
    ->get();

           $a = 0; $b = 0;
           $serviceids = "";
      foreach ($manager as $key => $value) {
      $service_id = $value->service_id;
      $user_type = $value->user_type;
      $serviceids .= $service_id.",";
          }
          $serviceids = rtrim($serviceids,",");
          list($a,$b) = explode('_', $serviceids);
          $servicearray = explode(',', $serviceids);
     $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))          
            ->where('bookings.date',$date)  
             ->where('bookings.checkin','no')
             ->where('bookings.status','success')
             ->where('bookings.refund','no')
             ->where('type','service')
            ->orderBy('bookings.id','desc')
            ->get();

          $db2 = DB::table('bookings_packs') 
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')
            ->leftjoin('bookings','bookings.book_pack_id','=','bookings_packs.id')  
             ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'),
          DB::raw('bookings.service_id as pack_service_id'),
          DB::raw('bookings.checkin as book_checkin'))  
             ->where('bookings_packs.date',$date) 
             ->where('bookings_packs.checkin','no')
             ->where('bookings_packs.refund','no')
             ->where('bookings_packs.status','success')     
            ->orderBy('bookings_packs.id','desc')
            ->get();
           

     foreach ($db2 as $key => $value) {
      $service_id = $value->pack_id;
      $optional = $value->optional;
      if($b==0) {
        if ($a==$value->pack_service_id && $value->book_checkin=="no") {
        $data[$value->order_id][] = array('service_id' => $value->id."_packs",'name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->pack_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'type' => $value->type,'payment_method' => $value->payment_method,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin,'option_name' => $value->option_name,'optional' => $optional,'occasion_type' => $value->occasion_type);
        }
      }else {
         if ($a==$value->pack_service_id && $optional==$b && $value->book_checkin=="no") {
        $data[$value->order_id][] = array('service_id' => $value->id."_packs",'name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->pack_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'type' => $value->type,'payment_method' => $value->payment_method,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin,'option_name' => $value->option_name,'optional' => $optional,'occasion_type' => $value->occasion_type);
         }
      }     
    }      
    foreach ($db as $key => $value) {
      $service_id = $value->service_id;
      $optional = $value->optional;
       if ($optional=="") {
        $optional = "0";
      }
        
         if (in_array($service_id."_".$optional, $servicearray) && $value->checkin=="no") {
        $data[$value->order_id][] = array('pack_id' => $value->service_id,'name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->service_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'option_name' => $value->option_name,'service_id' => $value->id."_service",'type' => $value->type,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin,'payment_method' => $value->payment_method,'optional' => $optional,'occasion_type' => '0');
        }
        }
    }
    return $data;
  }

  public static function get_future_bookings($type,$type2,$parameter,$email,$type3) {
    $date = date('d-m-Y');
  $user_type = "";
    $manager_id = 0;

    if ($type2=="app") {
      $manager = DB::table('admins')
    ->where('admins.user_type','manager')
    ->where('admins.email',$email)
    ->get();
     $manager_id = 0;
      foreach ($manager as $key => $value) {
      $manager_id = $value->id;
      $user_type = $value->user_type;
      
      }
      
    }else {
      $manager_id = Auth::user()->id;
        $user_type = Auth::user()->user_type;
    }
        $data = array();
    if ($user_type=="superadmin" || $user_type=="analyst" || $user_type=="lead_manager" || $user_type=="pos" || $user_type=="leadanalyst" || $user_type=="editor") {

      if ($parameter=="todays" && $type=="others") {
         $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name')); 

          if ($type3=="online") {
             $whereData = ['instamojo','bookmyshow']; 
             $db = $db->whereIn('payment_method',$whereData); 
             $db = $db->where('bookings.status','success'); 
             
          } elseif ($type3=="offline") {
             $whereData = array(array('payment_method','!=','instamojo') , array('payment_method','!=','bookmyshow')); 
             $db = $db->where($whereData);
             $db = $db->where('bookings.status','success'); 
          }elseif($type3=="all") {
             $db = $db->where('bookings.status','success'); 
          }elseif ($type3=="foc") {
            
             $db = $db->where('status','=','success');
          }elseif ($type3=="hold") {
             $db = $db->where('payment_method','!=','instamojo');
             $db = $db->where('status','!=','success');
          } else {
            $db = $db->where('payment_method',$type3);
            $db = $db->where('bookings.status','success'); 
           }

        $db = $db->whereDate('bookings.created_at', Carbon\Carbon::today())->where('bookings.type','service')
                                 
            ->orderBy('bookings.created_at','desc')
            ->get();


        $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'));  
        if ($type3=="online") {
               $whereData = ['instamojo','bookmyshow']; 
             $db2 = $db2->whereIn('payment_method',$whereData); 
             $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif ($type3=="offline") {
               $whereData = array(array('payment_method','!=','instamojo') , array('payment_method','!=','bookmyshow')); 
             $db2 = $db2->where($whereData);
              $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif($type3=="all") {
            $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif ($type3=="foc") {
            
             $db2 = $db2->where('status','=','success');
          } elseif ($type3=="hold") {
             $db2 = $db2->where('payment_method','!=','instamojo');
             $db2 = $db2->where('status','!=','success');
          } else {
            $db2 = $db2->where('payment_method',$type3);
            
           } 
          $db2 = $db2->whereDate('bookings_packs.created_at', Carbon\Carbon::today())
          ->orderBy('bookings_packs.created_at','desc')
          ->get();

      }else if($parameter=="monthly" && $type=="others") {
        $now = Carbon\Carbon::now();
                $month = $now->month;

           $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'));
            if ($type3=="online") {
              $whereData = ['instamojo','bookmyshow']; 
             $db = $db->whereIn('payment_method',$whereData);
             $db = $db->where('bookings.status','success'); 
          } elseif ($type3=="offline") {
             $whereData = array(array('payment_method','!=','instamojo') , array('payment_method','!=','bookmyshow')); 
             $db = $db->where($whereData);
             $db = $db->where('bookings.status','success'); 
          }elseif($type3=="all") {
             $db = $db->where('bookings.status','success'); 
          }elseif ($type3=="foc") {
            
             $db = $db->where('status','=','success');
          }elseif ($type3=="hold") {
             $db = $db->where('payment_method','!=','instamojo');
             $db = $db->where('status','!=','success');
          } else {
            $db = $db->where('payment_method',$type3);
            $db = $db->where('bookings.status','success'); 
           }


        $db = $db->where('bookings.type','service')
              ->whereMonth('bookings.created_at', $month)                      
              ->orderBy('bookings.created_at','desc')
              ->get();


        $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))  
          ->whereMonth('bookings_packs.created_at', $month); 
         if ($type3=="online") {
           $whereData = ['instamojo','bookmyshow']; 
             $db2 = $db2->whereIn('payment_method',$whereData);
              $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif ($type3=="offline") {
            $whereData = array(array('payment_method','!=','instamojo') , array('payment_method','!=','bookmyshow'));
             $db2 = $db2->where($whereData);
              $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif($type3=="all") {
            $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif ($type3=="foc") {
            
             $db2 = $db2->where('status','=','success');
          } elseif ($type3=="hold") {
             $db2 = $db2->where('payment_method','!=','instamojo');
             $db2 = $db2->where('status','!=','success');
          } else {
            $db2 = $db2->where('payment_method',$type3);
            
           }           
           $db2 = $db2->orderBy('bookings_packs.created_at','desc')
                  ->get();


      }else if($parameter=="lastmonth" && $type=="others") {
        
                $month = new Carbon\Carbon('last month');

         $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name')); 

          if ($type3=="online") {
            $whereData = ['instamojo','bookmyshow']; 
             $db = $db->whereIn('payment_method',$whereData);
             $db = $db->where('bookings.status','success'); 
          } elseif ($type3=="offline") {
            $whereData = array(array('payment_method','!=','instamojo') , array('payment_method','!=','bookmyshow'));
             $db = $db->where($whereData);
             $db = $db->where('bookings.status','success'); 
          }elseif($type3=="all") {
             $db = $db->where('bookings.status','success'); 
          }elseif ($type3=="foc") {
            
             $db = $db->where('status','=','success');
          }elseif ($type3=="hold") {
             $db = $db->where('payment_method','!=','instamojo');
             $db = $db->where('status','!=','success');
          } else {
            $db = $db->where('payment_method',$type3);
            $db = $db->where('bookings.status','success'); 
           }

        $db = $db->where('bookings.type','service')
        ->whereMonth('bookings.created_at',$month)                      
            ->orderBy('bookings.created_at','desc')
            ->get();


        $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))
          ->whereMonth('bookings_packs.created_at',$month);  
        if ($type3=="online") {
          $whereData = ['instamojo','bookmyshow']; 
             $db2 = $db2->whereIn('payment_method',$whereData);
              $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif ($type3=="offline") {
            $whereData = array(array('payment_method','!=','instamojo') , array('payment_method','!=','bookmyshow'));
             $db2 = $db2->where($whereData);
              $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif($type3=="all") {
            $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif ($type3=="foc") {
            
             $db2 = $db2->where('status','=','success');
          }elseif ($type3=="hold") {
             $db2 = $db2->where('payment_method','!=','instamojo');
             $db2 = $db2->where('status','!=','success');
          } else {
            $db2 = $db2->where('payment_method',$type3);
            
           } 
          $db2 = $db2->orderBy('bookings_packs.created_at','desc')
          ->get();



      }else if($parameter=="yesterday" && $type=="others") {
        
                $month = new Carbon\Carbon('yesterday');

           $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name')); 

          if ($type3=="online") {
            $whereData = ['instamojo','bookmyshow']; 
             $db = $db->whereIn('payment_method',$whereData);
             $db = $db->where('bookings.status','success'); 
          } elseif ($type3=="offline") {
             $whereData = array(array('payment_method','!=','instamojo') , array('payment_method','!=','bookmyshow'));
             $db = $db->where($whereData);
             $db = $db->where('bookings.status','success'); 
          }elseif($type3=="all") {
             $db = $db->where('bookings.status','success'); 
          }elseif ($type3=="foc") {
            
             $db = $db->where('status','=','success');
          }elseif ($type3=="hold") {
             $db = $db->where('payment_method','!=','instamojo');
             $db = $db->where('status','!=','success');
          } else {
            $db = $db->where('payment_method',$type3);
            $db = $db->where('bookings.status','success'); 
           }

        $db = $db->where('bookings.type','service')
        ->whereDate('bookings.created_at',$month)                      
            ->orderBy('bookings.created_at','desc')
            ->get();


        $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'))
          ->whereDate('bookings_packs.created_at',$month);  
        if ($type3=="online") {
          $whereData = ['instamojo','bookmyshow']; 
             $db2 = $db2->whereIn('payment_method',$whereData);
              $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif ($type3=="offline") {
            $whereData = array(array('payment_method','!=','instamojo') , array('payment_method','!=','bookmyshow'));
             $db2 = $db2->where($whereData);
              $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif($type3=="all") {
            $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif ($type3=="foc") {
            
             $db2 = $db2->where('status','=','success');
          } elseif ($type3=="hold") {
             $db2 = $db2->where('payment_method','!=','instamojo');
             $db2 = $db2->where('status','!=','success');
          } else {
            $db2 = $db2->where('payment_method',$type3);
            
           } 
          $db2 = $db2->orderBy('bookings_packs.created_at','desc')
          ->get();


      }else if($type=="choose") {

        list($from, $to) = explode('_', $parameter);

            $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name')); 
             if ($type3=="online") {
              $whereData = ['instamojo','bookmyshow']; 
             $db = $db->whereIn('payment_method',$whereData);
             $db = $db->where('bookings.status','success'); 
          } elseif ($type3=="offline") {
            $whereData = array(array('payment_method','!=','instamojo') , array('payment_method','!=','bookmyshow'));
             $db = $db->where($whereData);
             $db = $db->where('bookings.status','success'); 
          }elseif($type3=="all") {
             $db = $db->where('bookings.status','success'); 
          }elseif ($type3=="foc") {
            
             $db = $db->where('status','=','success');
          }elseif ($type3=="hold") {
             $db = $db->where('payment_method','!=','instamojo');
             $db = $db->where('status','!=','success');
          } else {
            $db = $db->where('payment_method',$type3);
            $db = $db->where('bookings.status','success'); 
           } 
           if ($from==$to) {
            $db = $db->whereDate('bookings.created_at', $from)
                      ->whereDate('bookings.created_at', $to);
           }else {
              $db = $db->whereBetween('bookings.created_at', [$from, $to]);
           }

        $db = $db->where('bookings.type','service')           
            ->orderBy('bookings.created_at','desc')
            ->get();


        $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
          ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'));  
          
          if ($type3=="online") {
            $whereData = ['instamojo','bookmyshow']; 
             $db2 = $db2->whereIn('payment_method',$whereData);
              $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif ($type3=="offline") {
            $whereData = array(array('payment_method','!=','instamojo') , array('payment_method','!=','bookmyshow'));
             $db2 = $db2->where($whereData);
              $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif ($type3=="foc") {
            
             $db2 = $db2->where('status','=','success');
          }elseif($type3=="all") {
            $db2 = $db2->where('bookings_packs.status','success'); 
          } elseif ($type3=="hold") {
             $db2 = $db2->where('payment_method','!=','instamojo');
             $db2 = $db2->where('status','!=','success');
          } else {
            $db2 = $db2->where('payment_method',$type3);
          } 

          if ($from==$to) {
            $db2 = $db2->whereDate('bookings_packs.created_at', $from)
                      ->whereDate('bookings_packs.created_at', $to);
          }else {
              $db2 = $db2->whereBetween('bookings_packs.created_at', [$from, $to]);
          }
          $db2 = $db2->orderBy('bookings_packs.created_at','desc')
               ->get();
        


      }else {
              $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name')); 

          if ($type3=="online") {
            $whereData = ['instamojo','bookmyshow']; 
             $db = $db->whereIn('payment_method',$whereData);
             
             $db = $db->where('bookings.status','success'); 
          } elseif ($type3=="offline") {
            $whereData = array(array('payment_method','!=','instamojo') , array('payment_method','!=','bookmyshow'));
             $db = $db->where($whereData);
             $db = $db->where('bookings.status','success'); 
          }elseif($type3=="all") {
             $db = $db->where('bookings.status','success'); 
          }elseif ($type3=="hold") {
             $db = $db->where('payment_method','!=','instamojo');
             $db = $db->where('status','!=','success');
          }elseif ($type3=="foc") {
            
             $db = $db->where('status','=','success');
          } else {
            $db = $db->where('payment_method',$type3);
            $db = $db->where('bookings.status','success'); 
           }


         $db = $db->where('type','service')      
            ->orderBy('bookings.created_at','desc')
            ->get();


           $db2 = DB::table('bookings_packs')
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')  
             ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'));

          if ($type3=="online") {
            $whereData = ['instamojo','bookmyshow']; 
             $db2 = $db2->whereIn('payment_method',$whereData);

              $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif ($type3=="offline") {
            $whereData = array(array('payment_method','!=','instamojo') , array('payment_method','!=','bookmyshow'));
             $db2 = $db2->where($whereData);
              $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif($type3=="all") {
            $db2 = $db2->where('bookings_packs.status','success'); 
          }elseif ($type3=="foc") {
            
             $db2 = $db2->where('status','=','success');
          } elseif ($type3=="hold") {
             $db2 = $db2->where('payment_method','!=','instamojo');
             $db2 = $db2->where('status','!=','success');
          } else {
            $db2 = $db2->where('payment_method',$type3);
            
           }  
            $db2 = $db2
              
              ->orderBy('bookings_packs.created_at','desc')
              ->get();

      }
        
     foreach ($db2 as $key => $value) {
      $service_id = $value->pack_id;
      $optional = $value->optional;
      if ($type3=="foc") {
        $checkfoc = Helper::check_foc_status($value->order_id);
        if (count($checkfoc) != 0) {
          $data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->pack_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'service_id' => $value->pack_id,'type' => $value->type,'payment_method' => $value->payment_method,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin,'option_name' => $value->option_name,'refund' => $value->refund,'occasion_type' => $value->occasion_type);
        }
      }else {
         $data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->pack_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'service_id' => $value->pack_id,'type' => $value->type,'payment_method' => $value->payment_method,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin,'option_name' => $value->option_name,'refund' => $value->refund,'occasion_type' => $value->occasion_type);
      }
     
      
    }      

    foreach ($db as $key => $value) {
      $service_id = $value->service_id;
      $optional = $value->optional;
      if ($type3=="foc") {
          $checkfoc = Helper::check_foc_status($value->order_id);
            if (count($checkfoc) != 0) {
         $data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->service_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'option_name' => $value->option_name,'service_id' => $value->service_id,'type' => $value->type,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin,'payment_method' => $value->payment_method,'refund' => $value->refund,'occasion_type' => '0');
       }
      }else {
           $data[$value->order_id][] = array('name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->service_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'option_name' => $value->option_name,'service_id' => $value->service_id,'type' => $value->type,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin,'payment_method' => $value->payment_method,'refund' => $value->refund,'occasion_type' => '0');
      }

    

      
    }


    
    }else {
      $manager = DB::table('admins')
    ->join('member_services','admins.id','=','member_services.member_id')
    ->where('admins.user_type','manager')
    ->where('admins.id',$manager_id)
    ->get();

           $a = 0; $b = 0;
           $serviceids = "";
      foreach ($manager as $key => $value) {
      $service_id = $value->service_id;
      $user_type = $value->user_type;
      $serviceids .= $service_id.",";
          }
          $serviceids = rtrim($serviceids,",");
          list($a,$b) = explode('_', $serviceids);
          $servicearray = explode(',', $serviceids);
     $db = DB::table('bookings')
        ->leftjoin('service_options','bookings.optional','=','service_options.id')  
        ->select(DB::raw('bookings.*'),
          DB::raw('service_options.option_name as option_name'))               
             ->where('bookings.status','success')
             ->where('type','service')
            ->orderBy('bookings.id','desc')
            ->get();

          $db2 = DB::table('bookings_packs') 
            ->leftjoin('service_options','bookings_packs.optional','=','service_options.id')
            ->leftjoin('bookings','bookings.book_pack_id','=','bookings_packs.id')  
             ->select(DB::raw('bookings_packs.*'),
          DB::raw('service_options.option_name as option_name'),
          DB::raw('bookings.service_id as pack_service_id'),
          DB::raw('bookings.checkin as book_checkin'))  
             ->where('bookings_packs.status','success')     
            ->orderBy('bookings_packs.id','desc')
            ->get();
           

     foreach ($db2 as $key => $value) {
      $service_id = $value->pack_id;
      $optional = $value->optional;
      if($b==0) {
        if ($a==$value->pack_service_id) {
        $data[$value->order_id][] = array('service_id' => $value->id."_packs",'name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->pack_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'type' => $value->type,'payment_method' => $value->payment_method,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin,'option_name' => $value->option_name,'optional' => $optional,'refund' => $value->refund,'occasion_type' => $value->occasion_type);
        }
      }else {
         if ($a==$value->pack_service_id && $optional==$b) {
        $data[$value->order_id][] = array('service_id' => $value->id."_packs",'name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->pack_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'type' => $value->type,'payment_method' => $value->payment_method,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin,'option_name' => $value->option_name,'optional' => $optional,'refund' => $value->refund,'occasion_type' => $value->occasion_type);
         }
      }     
    }      
    foreach ($db as $key => $value) {
      $service_id = $value->service_id;
      $optional = $value->optional;
       if ($optional=="") {
        $optional = "0";
      }
        
         if (in_array($service_id."_".$optional, $servicearray)) {
        $data[$value->order_id][] = array('pack_id' => $value->service_id,'name' => $value->name,'email' => $value->email,'phone' => $value->phone,'service_name' => $value->service_name,'date' => $value->date,'time' => $value->time,'quantity' => $value->quantity,'platform' => $value->platform,'price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount,'created_at' => $value->created_at,'order_id' => $value->order_id,'option_name' => $value->option_name,'service_id' => $value->id."_service",'type' => $value->type,'checkin_time' => $value->checkin_time,'checkin' => $value->checkin,'payment_method' => $value->payment_method,'optional' => $optional,'refund' => $value->refund,'occasion_type' => '0');
        }
        }
    }
    return $data;
  }

  public static function booking_process($name, $email,$phone,$purpose, $amount,$payment_method,$payment_id,$currency,$type,$status,$foccheckbox,$authorised,$foc_reason,$percent) {
        
         if (Session::get('cart')) {
          if ($foccheckbox=="on") {
            $status = "hold";
          }
            $emailers = array();
            $emailerstring = "";
            $cart = Session::get('cart');
           $checkbookings = DB::table('bookings')->get();
           $lastorder = 0;
           foreach ($checkbookings as $key => $value) {
             $lastorder = $value->id;
           }
           $lastorder = $lastorder + 1;
           $date = date("Y-m-d H:i:s");
           $orderid = "GV/ON/".Helper::generatePIN(6);
           
            $finduser = App\User::where('phone', $phone)->first();
            $pin = Helper::generatePIN();
            $user_id =0;
            if (!$finduser) {
              $user = new App\User;
              $user->name = $name;
              $user->email = $email;
              $user->phone = $phone;
              $user->password = bcrypt($pin);
              $user->platform = Helper::get_device_platform();
              $user->otp = $pin;
              $user->type = 'user';
              $user->save();
              $mobile = $phone;
              if (strlen($mobile) == 13 && substr($mobile, 0, 3) == "+91") {
               $mobile = substr($mobile, 3, 10);
              }
              $content = "You are now registered with The Grand Venice Mall. Your login is ".$mobile." and PIN: ".$pin.".  Install the iPhone/Android App: https://l.ead.me/29Ev";
              Helper::send_otp($phone,$content);
              $user_id = $user->id;
            }else {
              $user_id = $finduser['id'];
              if ($email == "") {
                $email = $finduser['email'];
              }else {
                $email = $email;
              }
              $updatedate = date("d F Y, h:i A");
              $updateemail = DB::table('users')->where('id',$user_id)->update(['email' => $email,'name' => $name,'updated_at' => $updatedate]); 
            }

           
              foreach ($cart as $key => $value) {
        $service_name =  $value['service_name'];
        $service_id = $value['service_id'];
        $quantity =  $value['quantity'];
        $time =  $value['time'];
        $date2 =  $value['date'];
        $quantity =  $value['quantity'];
        $price = $value['price'];
        $tax = $value['tax'];
        $option_id = $value['canal_id'];
        $type = $value['type'];
        $pack_type = $value['pack_type'];
        $occasion_type = $value['occasion_type'];
        $occassion_text = $value['occassion_text'];
        $dplatform = Helper::get_device_platform();
       

        if ($type=="service") {
            $data = array('user_id' => $user_id,'name' => $name,'email' => $email,'phone' => $phone,'service_id' => $service_id,'service_name' => $service_name,'optional' => $option_id,'date'=> $date2,'time' => $time,'quantity' => $quantity, 'amount' => $amount,'status' => $status,'platform' => $dplatform,'price' => $price,'tax' => $tax,'txnid' => $payment_id,'payment_mode' => $type,'order_id' => $orderid,'type' => $type,'payment_method' => $payment_method,'created_at' => $date, 'updated_at' => $date);
          $db = DB::table('bookings')->insert($data);
           $get_alias = Helper::get_alias($value['service_id']);
            $emailers[] = Helper::get_mailer($get_alias);    
        }else {
            $data2 = array('user_id' => $user_id,'name' => $name,'email' => $email,'phone' => $phone,'pack_id' => $service_id,'pack_name' => $service_name,'optional' => $option_id,'date'=> $date2,'time' => $time,'quantity' => $quantity, 'amount' => $amount,'status' => $status,'platform' => $dplatform,'price' => $price,'tax' => $tax,'txnid' => $payment_id,'payment_mode' => $type,'order_id' => $orderid,'type' => $type,'payment_method' => $payment_method,'occasion_type' => $occasion_type,'created_at' => $date, 'updated_at' => $date);
         $db = DB::table('bookings_packs')->insert($data2);

         $book_pack_id = DB::getPdo()->lastInsertId();

         $get_pack_details = Helper::get_packs_details($service_id);
         $packalias = "";
         foreach ($get_pack_details as $key => $value) {
           $packalias = $value->alias;
         }

          $emailers[] = Helper::get_mailer($packalias);

           $checkservice = DB::table('packs')
      ->join('packs_services','packs.id','=','packs_services.pack_id')
      ->join('services','packs_services.service_id','=','services.id')
      ->select(DB::raw('packs.*'),
        DB::raw('packs_services.category_id as category_id'),
        DB::raw('packs_services.service_id as service_id'),
        DB::raw('packs_services.quantity as quantity'),
        DB::raw('services.service_name as service_name'),
        DB::raw('services.alias as alias'))
      ->where('packs.id',$service_id)
      ->get();
      foreach ($checkservice as $k => $v) {
        $s_id = $v->service_id;
        $s_name = $v->service_name;
        $qt = $v->quantity;
        $alias = $v->alias;
        
        $emailers[] = Helper::get_mailer($alias);
        if ($alias=="gondola") {
          $option_id = $option_id;
        }else {
          $option_id = "";
        }
           $data = array('user_id' => $user_id,'name' => $name,'email' => $email,'phone' => $phone,'service_id' => $s_id,'service_name' => $s_name,'optional' => $option_id,'date'=> $date2,'time' => $time,'quantity' => $quantity, 'amount' => $amount,'status' => $status,'platform' => Helper::get_device_platform(),'price' => $price,'tax' => $tax,'txnid' => $payment_id,'payment_mode' => $type,'order_id' => $orderid,'type' => $type,'payment_method' => $payment_method,'book_pack_id' => $book_pack_id,'created_at' => $date, 'updated_at' => $date);
         $db = DB::table('bookings')->insert($data);
          
           
      }


      
         
       
      }
      
            }
        $npurpose = "";
        foreach ($cart as $key => $value) {
                $time =  $value['time'];
                $date2 =  $value['date'];
              list($a, $b, $c) = explode('-', $date2);
              $ndate = $b.'-'.$a.'-'.$c;
                $npurpose .= $value['service_name']." - Arrival Time: ".$time.", ".date('d F',strtotime($date2)).", ";

          }
          $contentwallet = "";
         $content = "";
        if ($status=="success") {

         $data = DB::table('bookings')
        ->join('services','bookings.service_id','=','services.id')
        ->leftJoin('service_options','bookings.optional','=','service_options.id')
        ->select(DB::raw('bookings.*'),
         DB::raw('services.alias as alias'),
         DB::raw('service_options.option_name as option_name'))
        ->where('bookings.order_id',$orderid)
        ->get();

        if ($payment_method=="wallet") {
           $current_bal = Crypt::decrypt(Auth::user()->wall_am);

           $updated_bal = $current_bal - $amount;
         
           $query2 = DB::table('users')->where('id',Auth::user()->id)->update(['wall_am' => Crypt::encrypt($updated_bal)]);
           $trans_id = uniqid(mt_rand(),true);
            $platform = Helper::get_device_platform();
           $query3 = DB::table('wall_history')->insert(['final_amount' => $amount,'user_id' => $user_id,'order_id' => $orderid,'identifier' => 'service','trans_id' => $trans_id,'payment_method' => 'wallet','platform' => $platform,'created_at' => $date, 'updated_at' => $date]);

           $contentwallet = "You have paid Rs. ".$amount." to ".$purpose.", Order ID: ".$orderid.", Now current balance is Rs. ".$updated_bal.".";
           Helper::send_otp(Auth::user()->phone,$contentwallet);
        }

        if ($email != "") {
           $emailers = array_values(array_unique($emailers));
         // Mail::to($email)->cc($emailers)->send(new App\Mail\OrderReciept($orderid));
        }else {
           $emailers = array_values(array_unique($emailers));
         //  Mail::to($emailers)->send(new App\Mail\OrderReciept($orderid));
        }
    if ($pack_type=="occasional") {
          $occassion_text = " - ".$occassion_text;
        }else {
          $occassion_text = "";
        }


           $get_canals = Helper::get_canals($option_id);
           if(count($cart)=="1") {
              list($a, $b, $c) = explode('-', $date2);
              $ndate = $b.'-'.$a.'-'.$c;
              $content .= "You purchased ".$purpose."".$occassion_text." on ".date('d F',strtotime($date)).". Order ID: ".$orderid.", Qty: ".$quantity.", Paid: Rs. ".$amount.", Arrival Time: ".$time." on ".date('d F',strtotime($date2));
              if ($get_canals !="") {
                $content .= ", Canal: ".$get_canals;
              }
             
              $content .= ". The Grand Venice";
              

           }else {
              $content .= "You purchased ".$purpose."".$occassion_text." on ".date('d F',strtotime($date)).". Order ID: ".$orderid.", Paid: Rs. ".$amount;
               if ($get_canals !="") {
                $content .= ", Canal: ".$get_canals;
              }

              $content .= ". The Grand Venice";

           }
          Helper::send_otp($phone,$content);
         Session::forget('cart');
        }
        }
        return $orderid;
    }

    public static function get_canals($canal_id) {
       $db = DB::table('service_options')->where('id',$canal_id)->get();
       $option_name = "";
       foreach ($db as $key => $value) {
         $option_name = $value->option_name;
       }
       return $option_name;
    }

    public static function get_canal_by_serviceid($service_id) {
      $db = DB::table('service_options')->where('service_id', $service_id)->get();  
     
      return $db;
    }
    public static function get_roles_by_alias($alias) {
      $db = DB::table('roles')->where('alias', $alias)->get();  
      $name = "";
      foreach ($db as $key => $value) {
        $name = $value->name;
      }
     
      return $name;
    }
    public static function get_mailer($service) {
      $db = DB::table('mailers')
            ->where('service', $service)
            ->groupBy('mailers.emails')
            ->get(); 
      $emails = "";
      foreach ($db as $key => $value) {
        $emails .= $value->emails;
      }
      return $emails;
    }
     public static function get_alias($service_id) {
      $db = DB::table('services')
            ->where('id', $service_id)
            ->get(); 
      $alias = array();
      foreach ($db as $key => $value) {
         $alias = $value->alias;
      }
      return $alias;
    }
    public static function get_occassion_rates($occasion_id) {
      $db = DB::table('rates')
      ->where('type','packs')
      ->where('rate_type','online')
      ->where('occasion_type',$occasion_id)
      ->get();
      $rates = 0;
      foreach ($db as $key => $value) {
        $rates = $value->rates;
      }
      return $rates;
    }
    public static function check_foc_status($order_id) {
      $db = DB::table('foc_requests')->where('order_id', $order_id)->get();
      return $db;
    }
    public static function get_canal($service_id) {
      $db = DB::table('service_options')->where('service_id', $service_id)->get();
      return $db;
    }
    public static function get_foc_stats($reason_id,$type1) {
      if ($type1=="todays") {
         $db = DB::table('foc_requests')->where('reason', $reason_id)->whereDate('created_at',Carbon\Carbon::today())->get();
      }elseif($type1=="monthly") {
        $now = Carbon\Carbon::now();
     $month = $now->month;
          $db = DB::table('foc_requests')->where('reason', $reason_id)->whereMonth('created_at',$month)->get();
      }elseif($type1=="lastmonth") {
       $month = new Carbon\Carbon('last month');
          $db = DB::table('foc_requests')->where('reason', $reason_id)->whereMonth('created_at',$month)->get();
      }else {
   
          $db = DB::table('foc_requests')->where('reason', $reason_id)->get();
      }
     
      return count($db);

    }
  public static function get_gondoliers() {
    $data = DB::table('gondoliers')->get();
    return $data;
  }
   public static function get_foc_amount($type) {
    $data = array();
    if ($type=="todays") {
      $data = DB::table('foc_requests')
              ->whereDate('foc_requests.created_at', Carbon\Carbon::today())
              ->get();
    }elseif($type=="monthly") {
      $now = Carbon\Carbon::now();
                $month = $now->month;
       $data = DB::table('foc_requests')
              ->whereMonth('foc_requests.created_at', $month)
              ->get();
    }elseif($type=="lastmonth") {
      $month = new Carbon\Carbon('last month');
       $data = DB::table('foc_requests')
               ->whereMonth('foc_requests.created_at', $month)
              ->get();
    }else {
       $data = DB::table('foc_requests')
              ->get();
    }
    $amount = 0;
    $rdata = array();
    foreach ($data as $key => $value) {
      $amount += $value->ramount; 
    }
    $rdata  = array('amount' => $amount,'count' => count($data));
    return $rdata;
  }
  public static function get_gondoliers_order_id($order_id) {
    $data = DB::table('gondolier_checkins_log')
    ->join('gondoliers','gondoliers.id','=','gondolier_checkins_log.gondolier_id')
    ->where('order_id',$order_id)
    ->get();
    $gondolier_name = "";
    foreach ($data as $key => $value) {
      $gondolier_name .= $value->gondolier_name.",";
    }
    return rtrim($gondolier_name,",");


  }
   public static function check_gondolier_ride_count($gondolier_id) {
    $data = DB::table('gondolier_checkins_log')
    ->where('gondolier_id',$gondolier_id)
    ->get();
    
    return count($data);


  }
   public static function check_gondolier_ride_count_date($gondolier_id,$date) {
    $data = DB::table('gondolier_checkins_log')
    ->where('gondolier_id',$gondolier_id)
    ->whereDate('created_at',$date)
    ->get();
    
    return count($data);


  }
     public static function check_feedback_service($order_id, $type) {
      $data = array();
      if ($type=="service") {
           $data = DB::table('bookings')
    ->where('order_id',$order_id)  
    ->get();
      }else {
            $data = DB::table('bookings_packs')
    ->where('order_id',$order_id)  
    ->get();
      }
    
    return $data;


  }
  public static function check_gondolier_total($gondolier_id,$type) {
    if ($type=="todays") {
      $data = DB::table('gondolier_checkins_log')
      ->where('gondolier_id',$gondolier_id)
      ->whereDate('gondolier_checkins_log.created_at',Carbon\Carbon::today())
      ->count();
    }elseif($type=="monthly") {
       $now = Carbon\Carbon::now();
     $month = $now->month;
       $data = DB::table('gondolier_checkins_log')
      ->where('gondolier_id',$gondolier_id)
      ->whereMonth('gondolier_checkins_log.created_at',$month)
      ->count();
    }elseif($type=="lastmonth") {
       $month = new Carbon\Carbon('last month');
       $data = DB::table('gondolier_checkins_log')
      ->where('gondolier_id',$gondolier_id)
      ->whereMonth('gondolier_checkins_log.created_at',$month)
      ->count();
    }elseif($type=="yesterday") {
       $month = new Carbon\Carbon('yesterday');
       $data = DB::table('gondolier_checkins_log')
      ->where('gondolier_id',$gondolier_id)
      ->whereDate('gondolier_checkins_log.created_at',$month)
      ->count();
    }else {
      list($from, $to) = explode('_', $type);
       $month = new Carbon\Carbon('yesterday');
       $data = DB::table('gondolier_checkins_log')
      ->where('gondolier_id',$gondolier_id);
      if ($from==$to) {
          $data = $data->whereDate('gondolier_checkins_log.created_at',$from)
                     ->whereDate('gondolier_checkins_log.created_at',$to);
        
      }else {
         $to = date('Y-m-d', strtotime($to.'+1 day'));
      $data = $data->whereBetween('gondolier_checkins_log.created_at',[$from, $to]);
      }
      $data = $data->count();
    }
    
    return $data;
  }
  public static function get_bms_id($order_id) {
    $data = DB::table('bookings_bms')->where('order_id',$order_id)->get();
    $bookmyshow_id = "";
    foreach ($data as $key => $value) {
      $bookmyshow_id = $value->bookmyshow_id;
    }
    return $bookmyshow_id;
  }
  public static function check_mobile() {
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    $status = 0;
    $tablet_browser = 0;

 
if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
}
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))   {

   $status = 1;

  }elseif($tablet_browser > 0) {
       $status = 1;
  }else {
      $status = 0;
  }

  return $status;
}
public static function get_all_rates($service_id,$service_type) {
   $db = DB::table('rates')
         ->where('service_id',$service_id)
         ->where('type',$service_type)
         ->where('rate_type','online')
         ->get();

  $data = array();
  foreach ($db as $key => $value) {
    $data[] = $value->rates;
  }
  return $data;


}
public static function wallet_process($name,$email,$phone,$purpose,$amount,$payment_method,$payment_id,$currency,$type,$status) {
          
           
            $wallet = DB::table('wall_session_temp')->where('user_id',Auth::user()->id)->get();
            $final_amount = 0;
            $main_amount = 0;
            $extra_amount = 0;
            $user_id = Auth::user()->id;
            $date = date("Y-m-d H:i:s");
       $expiry = date('d-m-Y', strtotime('+12 Month',strtotime($date)));
       $order_id = "GV/TP/".Helper::generatePIN(6);
            $current_amount = 0;
            foreach ($wallet as $key => $value) {
              $final_amount = $value->final_amount;
              $main_amount = $value->mainamount;
              $extra_amount = $value->extra;
              $current_amount = $value->current_amount;
            }

            $trans_id = uniqid(mt_rand(),true);

            $updated_amount = $current_amount + $final_amount;


             $insert = DB::table('wall_history')->insert(['final_amount' => $final_amount,'mainamount' =>$main_amount,'extra' => $extra_amount,'user_id' => $user_id,'order_id' => $order_id,'expiry' => $expiry,'identifier' => 'topup','trans_id' => $payment_id,'payment_method' => $payment_method,'created_at' => $date, 'updated_at' => $date]);
            $updatebalance = DB::table('users')->where('id',$user_id)->update(['wall_am'=> Crypt::encrypt($updated_amount)]);

             $content = "Your GV Pay is recharged with Rs. ".$final_amount.", GV Pay Balance is Rs. ".$updated_amount.". Install the iPhone/Android App: https://l.ead.me/29Ev";
         Helper::send_otp($phone,$content);


         
         return redirect('wallet');
  
    }
    public static function fetch_col($count) {
          $col = "0";
          if (count($count)=="1") {
            $col = "12";
          }elseif(count($count)=="2") {
            $col = "6";
          }elseif(count($count)=="3") {
            $col = "4";
          }elseif(count($count)=="4") {
            $col = "3";
          }
          return $col;
    }
    public static function get_unit($unit_id) {
     $db = DB::table('units')->where('id',$unit_id)->get();
     $data = array();
     foreach ($db as $key => $value) {
       $data = array('unit_name' => $value->unit_name,'floor_level' => $value->floor_level,'unit_phone' => $value->unit_phone,'unit_email' => $value->unit_email);
     }
     return $data;
    }
    public static function process_payment($name, $phone, $unit_id,$amount,$user_id,$trans_id,$payment_method,$order_id,$current_bal) {
      
       $date = date("Y-m-d H:i:s");
        $platform = Helper::get_device_platform();
        $data = array('unit_id' => $unit_id, 'final_amount' => $amount,'user_id' => $user_id,'trans_id' => $trans_id,'payment_method' => $payment_method,'order_id' => $order_id,'identifier' => 'payment','platform' => $platform, 'created_at' => $date, 'updated_at' => $date);
        $query = DB::table('wall_history')->insert($data);

        if ($data) {
          if ($payment_method=="gv_pocket") {
             $updated_bal = $current_bal - $amount;
           $query2 = DB::table('users')->where('id',$user_id)->update(['wall_am' => Crypt::encrypt($updated_bal)]);
           $units = Helper::get_unit($unit_id);
           $content = "You paid Rs. ".$amount." to ".$units['unit_name'].", ".$units['floor_level'].", Order ID: ".$order_id.", GV Pay balance is Rs. ".$updated_bal.". Install the iPhone/Android App: https://l.ead.me/29Ev";
           Helper::send_otp($phone,$content);
           $content2 = "You have recieved Rs. ".$amount." from ".$name.", Order ID: ".$order_id.".";
           Helper::send_otp($units['unit_phone'],$content2);
           $gettoken = DB::table('unit_tokens')->where('unit_id',$unit_id)->get();
           $token = "";
           foreach ($gettoken as $key => $value) {
             $token = $value->token;
           }
            $message = "You have recieved payment of Rs. ".$amount;
           Helper::send_push_to_units($message,$token,"GV Pay: Payment Alert","gv_pay");

          }
          $units = Helper::get_unit($unit_id);
          $data = array('type' => 'wallet','order_id' => $order_id,'amount' => $amount,'unit_name' => $units['unit_name'], 'date' => $date);
          
           return redirect('status_s')->withInput()->with('status', $data);
        }
    }
    public static function get_unit_by_email($email) {
     $db = DB::table('units')->where('unit_email',$email)->get();
     $unit_name = ""; $unit_id = 0;
     foreach ($db as $key => $value) {
      $unit_name = $value->unit_name;
      $unit_id = $value->id;
     }
     $data[] = array('unit_name' => $unit_name, 'unit_id' => $unit_id);
     return $data;
    }
    public static function get_unit_by_email_food($email) {
     $db = DB::table('units')->where('unit_email',$email)->get();
     
     return $db;
    }
    public static function send_push_to_units($message,$tokenid,$title,$subject) {

      $url = 'https://fcm.googleapis.com/fcm/send';
      $fields = array (
        'to' => $tokenid,
        'priority' => 'high',
        'notification' => array (
                "body" => $message,
                "title" => $title,
                "icon" => "myicon",
                "subject" => $subject,
                "sound"  => "ordernoti",
                "channel_id" => 'fcm_default_channel'
        )
      );
       $fields = json_encode ( $fields );
       $headers = array (
        'Authorization: key=' . "AIzaSyDGTUh0xntxRsrLM6gsK3-fq0TzkrJkKGo",
        'Content-Type: application/json'
       );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;

    }
     public static function send_push_to_users($title,$message,$device_tokens) {
        // Set POST variables
        $newarray = array();
        foreach ($device_tokens as $token) {
            $newarray[] = $token;
        }


      $url = 'https://fcm.googleapis.com/fcm/send';
      $fields = array (
        'registration_ids' => $newarray,
        'priority' => 'high',
        'notification' => array (
                "body" => $message,
                "title" => $title,
                "icon" => "myicon"
        )
      );
       $fields = json_encode ( $fields );
       $headers = array (
        'Authorization: key=' . "AAAAj0QDz4k:APA91bH7full3Tpza-Hh_AtwbtzdJO6Tk_jT5XwlNjcKbulfZKum8G9_EacZMoYRcFPMYfsHcC8s9XiEMt9dylWVjrXlKoElVZGoY82x7TZsid-DIDWyocIBnsTL-LTLzsARcp4o7rw1",
        'Content-Type: application/json'
       );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;

    }

     public static function send_notification_to_units($title,$message,$device_tokens) {
        // Set POST variables
        $newarray = array();
        foreach ($device_tokens as $token) {
            $newarray[] = $token;
        }


      $url = 'https://fcm.googleapis.com/fcm/send';
      $fields = array (
        'registration_ids' => $newarray,
        'priority' => 'high',
        'notification' => array (
                "body" => $message,
                "title" => $title,
                "icon" => "myicon"
        )
      );
       $fields = json_encode ( $fields );
       $headers = array (
         'Authorization: key=' . "AAAAJB7Ui2A:APA91bGITUgdUR0xNDs1q07_1UPJQn58mnsm3r-tISGyAV0NVHS5C3IZPvjnBiN5ep1_BZvtRfn1CXuOfaNr94B8YbLv05xTLrqSYwqgCso-RdWTS4T9dxmh2u235OWQBycbSN_I74jk",
        'Content-Type: application/json'
       );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;

    }
    
    public static function get_filter_types($filter_name) {
     $db = DB::table('filter_types')->where('filter_name',$filter_name)->get();
     $filter_value = "";
     foreach ($db as $key => $value) {
      $filter_value = $value->filter_value;
     }
     return $filter_value;
    }
     public static function get_category($unit_category) {
     $db = DB::table('unit_categories')->where('id',$unit_category)->get();
     $data = array();
     foreach ($db as $key => $value) {
      $data =  array('unit_category' => $value->unit_category_name,'unit_id' => $value->id);
     }
     return $data;
    }
    public static function get_device_platform() {
       $platform = "";
       //Detect special conditions devices
$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

//do something with this information
if( $iPod || $iPhone ){
    $platform = "ios";
}else if($iPad){
    $platform = "ios";
}else if($Android){
   $platform = "android";
}else if($webOS){
   $platform = "web";
}
return $platform;
    }

    public static function check_app() {
      $check = false;
      $isWebView = false;
      if((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile/') !== false)) :
         $isWebView = true;
      elseif(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) :
         $isWebView = true;
      endif;

        if(!$isWebView) : 
           $check = true;
       endif;
      return $check;
    }

    public static function check_app_ios() {
     if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"iphone")) {
       if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"safari")) {
          return "1";
       } else{
          return "0";
       }
      }
    }
    
public static function get_users_details($userid) {
   $user = App\User::where('id', $userid)->get();
   return $user;
}
public static function get_notification_count() {
   $count = DB::table('user_notifications')->count();
   return $count;
}
public static function get_booking_counts() {
  $services = DB::table('bookings')
     ->where('type','service')
     ->where('status','success')
     ->whereDate('bookings.created_at',Carbon\Carbon::today())
     ->count();

    $packs = DB::table('bookings_packs')
     ->where('type','service')
     ->where('status','success')
     ->whereDate('bookings_packs.created_at',Carbon\Carbon::today())
     ->count();

     $count = $services + $packs;


   return $count;
}

}
