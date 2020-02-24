<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use URL;
use Helper;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReciept;
use Crypt;
use Auth;
class PaymentController extends Controller
{

  function checkout(Request $request) {
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
            "redirect_url" => URL::to('payment/status')
            ));
             
            header('Location: ' . $response['longurl']);
            exit();
    }catch (Exception $e) {
        print('Error: ' . $e->getMessage());
    }
        
      }elseif($payment_method=="wallet") {
        $payment_id = rand(10,100);
         Helper::booking_process($request->name,$request->email,$request->phone,$request->services,$amount,$payment_method,$payment_id,'INR',$payment_method,'success','off',null,null,null); 

         return redirect('status_s');
      }else {
        $payment_id = rand(10,100);
         $this->booking_process($request->name,$request->email,"+91".$request->phone,$request->services,$amount,$payment_method,$payment_id,'INR',$payment_method,'success','off',null,null,null); 
          return redirect('status_s');  
      }
    
    }
    function status2() {
      $status = "success";
      return view('payment/status', compact('status'));  
    }
    function status() {

   	   $cart = Session::get('cart');
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
             Helper::booking_process($name,$email,$phone,$response['purpose'],$amount,'instamojo',$payment_id,$currency,$type,$status,'off',null,null,null); 

             return redirect('status_s');

            }else {
              return redirect('status_f');

            }      
     
    }
    function status_s() {
      $status = 'success';
      return view('payment/status', compact('status'));  
    }
    function status_f() {
      $status = 'failed';
      return view('payment/failed', compact('status'));  
    }
    function booking_process($name, $email,$phone,$purpose, $amount,$payment_method,$payment_id,$currency,$type,$status,$foccheckbox,$authorised,$foc_reasons,$percent) {
        
         if (Session::get('cart')) {
            $cart = Session::get('cart');
           $checkbookings = DB::table('bookings')->get();
           $lastorder = 0;
           foreach ($checkbookings as $key => $value) {
             $lastorder = $value->id;
           }
           $lastorder = $lastorder + 1;
           $date = date("Y-m-d H:i:s");
           $orderid = "GV/ON/".Helper::generatePIN(6);
            $finduser = User::where('phone', $phone)->first();
            $pin = Helper::generatePIN();
            $user_id =0;
            if (!$finduser) {
              $user = new User;
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
       

        if ($type=="service") {
            $data = array('user_id' => $user_id,'name' => $name,'email' => $email,'phone' => $phone,'service_id' => $service_id,'service_name' => $service_name,'optional' => $option_id,'date'=> $date2,'time' => $time,'quantity' => $quantity, 'amount' => $amount,'status' => $status,'platform' => Helper::get_device_platform(),'price' => $price,'tax' => $tax,'txnid' => $payment_id,'payment_mode' => $type,'order_id' => $orderid,'type' => $type,'payment_method' => $payment_method,'created_at' => $date, 'updated_at' => $date);
          $db = DB::table('bookings')->insert($data);
        }else {
            $data2 = array('user_id' => $user_id,'name' => $name,'email' => $email,'phone' => $phone,'pack_id' => $service_id,'pack_name' => $service_name,'optional' => $option_id,'date'=> $date2,'time' => $time,'quantity' => $quantity, 'amount' => $amount,'status' => $status,'platform' => Helper::get_device_platform(),'price' => $price,'tax' => $tax,'txnid' => $payment_id,'payment_mode' => $type,'order_id' => $orderid,'type' => $type,'payment_method' => $payment_method,'occasion_type' => $occasion_type,'created_at' => $date, 'updated_at' => $date);
         $db = DB::table('bookings_packs')->insert($data2);

         $book_pack_id = DB::getPdo()->lastInsertId();

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

        
        if ($email != "") {
             Mail::to($email)->send(new OrderReciept($orderid));
        }

        if ($pack_type=="occasional") {
          $occassion_text = " - ".$occassion_text;
        }else {
          $occassion_text = "";
        }


           $get_canals = $this->get_canals($option_id);
           if(count($cart)=="1") {
              list($a, $b, $c) = explode('-', $date2);
              $ndate = $b.'-'.$a.'-'.$c;
              $content .= "You purchased ".$purpose."".$occassion_text." on ".date('d F',strtotime($date)).". Order ID: ".$orderid.", Qty: ".$quantity.", Paid: Rs. ".$amount.", Arrival Time: ".$time." on ".date('d F',strtotime($date2));
              if ($get_canals !="") {
                $content .= ", Canal: ".$get_canals;
              }
             
              $content .= ". The Grand Venice";
              

           }else {
              $content .= "You purchased ".$purpose."".$occassion_text." on ".date('d F',strtotime($date)).". Order ID: ".$orderid.", Qty: ".$quantity.", Paid: Rs. ".$amount;
               if ($get_canals !="") {
                $content .= ", Canal: ".$get_canals;
              }

              $content .= ". The Grand Venice";

           }
          Helper::send_otp($phone,$content);
          Session::flush('cart');
        }
        }
    }


    function get_canals($canal_id) {
       $db = DB::table('service_options')->where('id',$canal_id)->get();
       $option_name = "";
       foreach ($db as $key => $value) {
         $option_name = $value->option_name;
       }
       return $option_name;
    }


    //paytm integration
    public function paytm(Request $request)
    {  
      $price =  Crypt::decrypt($request->price);   
      $order_id = Helper::generatePIN(6);
      $mobile = $request->phone;
      $email = $request->email; 
      $name = $request->name;
      $data[] = array('name' => $name, 'email' => $email, 'phone' => $mobile);
      Session::put('details', $data);          
      $data_for_request = $this->handlePaytmRequest( $order_id, $price,$mobile, $email);
      $paytm_txn_url = 'https://securegw-stage.paytm.in/theia/processTransaction';
      $paramList = $data_for_request['paramList'];
      $checkSum = $data_for_request['checkSum'];
      return view( 'paytm/paytm-merchant-form', compact( 'paytm_txn_url', 'paramList', 'checkSum' ) );
    }

    public function handlePaytmRequest( $order_id, $amount,$mobile, $email ) {
    // Load all functions of encdec_paytm.php and config-paytm.php
    $this->getAllEncdecFunc();
    $this->getConfigPaytmSettings();
    $checkSum = "";
    $paramList = array();
    // Create an array having all required parameters for creating checksum.
    $paramList["MID"] = 'TheGra40714651594487';
    $paramList["ORDER_ID"] = $order_id;
    $paramList["CUST_ID"] = $order_id;
    $paramList["INDUSTRY_TYPE_ID"] = 'Retail';
    $paramList["MOBILE_NO"] = $mobile;
    $paramList["EMAIL"] = $email;
    $paramList["CHANNEL_ID"] = 'WEB';
    $paramList["TXN_AMOUNT"] = $amount;
    $paramList["WEBSITE"] = 'WEBSTAGING';
    $paramList["CALLBACK_URL"] = url( 'callback' );
    $paytm_merchant_key = 'Zhrvm68nKLmdd_oG';
    //Here checksum string will return by getChecksumFromArray() function.
    $checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );
    return array(
      'checkSum' => $checkSum,
      'paramList' => $paramList
    );
  }

   public function statuscheck() {
    // Load all functions of encdec_paytm.php and config-paytm.php
    $this->getAllEncdecFunc();
    $this->getConfigPaytmSettings();

    $paytm_merchant_key = 'Zhrvm68nKLmdd_oG';
 

    /* initialize an array */
$paytmParams = array();

/* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
$paytmParams["MID"] = "TheGra40714651594487";

/* Enter your order id which needs to be check status for */
$paytmParams["ORDERID"] = "280497";

/**
* Generate checksum by parameters we have in body
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
*/
   $checksum = getChecksumFromArray( $paytmParams, $paytm_merchant_key );
/* put generated checksum value here */
$paytmParams["CHECKSUMHASH"] = $checksum;

/* prepare JSON string for request */
$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

/* for Staging */
$url = "https://securegw-stage.paytm.in/order/status";

/* for Production */
// $url = "https://securegw.paytm.in/order/status";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));  
$response = curl_exec($ch);
return json_decode($response,true);
   }
   

  /**
   * Get all the functions from encdec_paytm.php
   */
  function getAllEncdecFunc() {
    function encrypt_e($input, $ky) {
      $key   = html_entity_decode($ky);
      $iv = "@@@@&&&&####$$$$";
      $data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $iv );
      return $data;
    }
    function decrypt_e($crypt, $ky) {
      $key   = html_entity_decode($ky);
      $iv = "@@@@&&&&####$$$$";
      $data = openssl_decrypt ( $crypt , "AES-128-CBC" , $key, 0, $iv );
      return $data;
    }
    function pkcs5_pad_e($text, $blocksize) {
      $pad = $blocksize - (strlen($text) % $blocksize);
      return $text . str_repeat(chr($pad), $pad);
    }
    function pkcs5_unpad_e($text) {
      $pad = ord($text{strlen($text) - 1});
      if ($pad > strlen($text))
        return false;
      return substr($text, 0, -1 * $pad);
    }
    function generateSalt_e($length) {
      $random = "";
      srand((double) microtime() * 1000000);
      $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
      $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
      $data .= "0FGH45OP89";
      for ($i = 0; $i < $length; $i++) {
        $random .= substr($data, (rand() % (strlen($data))), 1);
      }
      return $random;
    }
    function checkString_e($value) {
      if ($value == 'null')
        $value = '';
      return $value;
    }

    function getChecksumFromArray($arrayList, $key, $sort=1) {
      if ($sort != 0) {
        ksort($arrayList);
      }
      $str = getArray2Str($arrayList);
      $salt = generateSalt_e(4);
      $finalString = $str . "|" . $salt;
      $hash = hash("sha256", $finalString);
      $hashString = $hash . $salt;
      $checksum = encrypt_e($hashString, $key);
      return $checksum;
    }



    function getChecksumFromString($str, $key) {
      $salt = generateSalt_e(4);
      $finalString = $str . "|" . $salt;
      $hash = hash("sha256", $finalString);
      $hashString = $hash . $salt;
      $checksum = encrypt_e($hashString, $key);
      return $checksum;
    }
    function verifychecksum_e($arrayList, $key, $checksumvalue) {
      $arrayList = removeCheckSumParam($arrayList);
      ksort($arrayList);
      $str = getArray2StrForVerify($arrayList);
      $paytm_hash = decrypt_e($checksumvalue, $key);
      $salt = substr($paytm_hash, -4);
      $finalString = $str . "|" . $salt;
      $website_hash = hash("sha256", $finalString);
      $website_hash .= $salt;
      $validFlag = "FALSE";
      if ($website_hash == $paytm_hash) {
        $validFlag = "TRUE";
      } else {
        $validFlag = "FALSE";
      }
      return $validFlag;
    }
    function verifychecksum_eFromStr($str, $key, $checksumvalue) {
      $paytm_hash = decrypt_e($checksumvalue, $key);
      $salt = substr($paytm_hash, -4);
      $finalString = $str . "|" . $salt;
      $website_hash = hash("sha256", $finalString);
      $website_hash .= $salt;
      $validFlag = "FALSE";
      if ($website_hash == $paytm_hash) {
        $validFlag = "TRUE";
      } else {
        $validFlag = "FALSE";
      }
      return $validFlag;
    }
    function getArray2Str($arrayList) {
      $findme   = 'REFUND';
      $findmepipe = '|';
      $paramStr = "";
      $flag = 1;
      foreach ($arrayList as $key => $value) {
        $pos = strpos($value, $findme);
        $pospipe = strpos($value, $findmepipe);
        if ($pos !== false || $pospipe !== false)
        {
          continue;
        }
        if ($flag) {
          $paramStr .= checkString_e($value);
          $flag = 0;
        } else {
          $paramStr .= "|" . checkString_e($value);
        }
      }
      return $paramStr;
    }
    function getArray2StrForVerify($arrayList) {
      $paramStr = "";
      $flag = 1;
      foreach ($arrayList as $key => $value) {
        if ($flag) {
          $paramStr .= checkString_e($value);
          $flag = 0;
        } else {
          $paramStr .= "|" . checkString_e($value);
        }
      }
      return $paramStr;
    }
    function redirect2PG($paramList, $key) {
      $hashString = getchecksumFromArray($paramList, $key);
      $checksum = encrypt_e($hashString, $key);
    }
    function removeCheckSumParam($arrayList) {
      if (isset($arrayList["CHECKSUMHASH"])) {
        unset($arrayList["CHECKSUMHASH"]);
      }
      return $arrayList;
    }
    function getTxnStatus($requestParamList) {
      return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
    }
    function getTxnStatusNew($requestParamList) {
      return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
    }
    function initiateTxnRefund($requestParamList) {
      $CHECKSUM = getRefundChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY,0);
      $requestParamList["CHECKSUM"] = $CHECKSUM;
      return callAPI(PAYTM_REFUND_URL, $requestParamList);
    }
    function callAPI($apiURL, $requestParamList) {
      $jsonResponse = "";
      $responseParamList = array();
      $JsonData =json_encode($requestParamList);
      $postData = 'JsonData='.urlencode($JsonData);
      $ch = curl_init($apiURL);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Content-Length: ' . strlen($postData))
      );
      $jsonResponse = curl_exec($ch);
      $responseParamList = json_decode($jsonResponse,true);
      return $responseParamList;
    }
    function callNewAPI($apiURL, $requestParamList) {
      $jsonResponse = "";
      $responseParamList = array();
      $JsonData =json_encode($requestParamList);
      $postData = 'JsonData='.urlencode($JsonData);
      $ch = curl_init($apiURL);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Content-Length: ' . strlen($postData))
      );
      $jsonResponse = curl_exec($ch);
      $responseParamList = json_decode($jsonResponse,true);
      return $responseParamList;
    }
    function getRefundChecksumFromArray($arrayList, $key, $sort=1) {
      if ($sort != 0) {
        ksort($arrayList);
      }
      $str = getRefundArray2Str($arrayList);
      $salt = generateSalt_e(4);
      $finalString = $str . "|" . $salt;
      $hash = hash("sha256", $finalString);
      $hashString = $hash . $salt;
      $checksum = encrypt_e($hashString, $key);
      return $checksum;
    }
    function getRefundArray2Str($arrayList) {
      $findmepipe = '|';
      $paramStr = "";
      $flag = 1;
      foreach ($arrayList as $key => $value) {
        $pospipe = strpos($value, $findmepipe);
        if ($pospipe !== false)
        {
          continue;
        }
        if ($flag) {
          $paramStr .= checkString_e($value);
          $flag = 0;
        } else {
          $paramStr .= "|" . checkString_e($value);
        }
      }
      return $paramStr;
    }


    function callRefundAPI($refundApiURL, $requestParamList) {
      $jsonResponse = "";
      $responseParamList = array();
      $JsonData =json_encode($requestParamList);
      $postData = 'JsonData='.urlencode($JsonData);
      $ch = curl_init($apiURL);
      curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_URL, $refundApiURL);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $headers = array();
      $headers[] = 'Content-Type: application/json';
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      $jsonResponse = curl_exec($ch);
      $responseParamList = json_decode($jsonResponse,true);
      return $responseParamList;
    }
  }

  /**
   * Config Paytm Settings from config_paytm.php file of paytm kit
   */
  function getConfigPaytmSettings() {
    define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
    define('PAYTM_MERCHANT_KEY', 'Zhrvm68nKLmdd_oG'); //Change this constant's value with Merchant key downloaded from portal
    define('PAYTM_MERCHANT_MID', 'TheGra40714651594487'); //Change this constant's value with MID (Merchant ID) received from Paytm
    define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm
    $PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
    $PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
    if (PAYTM_ENVIRONMENT == 'PROD') {
      $PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
      $PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
    }
    define('PAYTM_REFUND_URL', '');
    define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
    define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
    define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
  }
  public function paytmCallback( Request $request ) {
   
    $udf1 = $request['ORDERID'];
    if ( 'TXN_SUCCESS' === $request['STATUS'] ) {
      $txnid = $request['TXNID'];
      $amount = $request['TXNAMOUNT'];
      $status = 'success';
      $addedon =  date("Y-m-d H:i:s");
      $error_Message = "no_error";
      $issuing_bank = $request['BANKNAME'];
      $custid = $request['CUST_ID'];  
      $payment_method = "paytm";
      $details = Session::get('details');
      $name =  $details[0]['name'];
      $email = $details[0]['email'];
      $phone = $details[0]['phone'];
      $cart = Session::get('cart');
      $currency = "INR";
      $purpose = "";
      foreach ($cart as &$item) {
        $purpose .= $item['service_name'].",";
      }
      $purpose = rtrim($purpose,",");
      $this->booking_process($name,$email,$phone,$purpose,$amount,'paytm',$txnid,$currency,$issuing_bank,$status,'off'); 
      Session::flush('details');
      return redirect('status_s');

    } else if( 'TXN_FAILURE' === $request['STATUS'] ){
      return view( 'paytm/payment-failed' );
    }
  }
   
}
