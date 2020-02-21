<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Crypt;
use DB;
use Auth;
use Hash;
use Helper;
use URL;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/cart';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    function clogin(Request $request) {
      $phone = $request['phone'];
      if (Helper::check_mobile()==1) {
        $pinno = $request['pin1'].''.$request['pin2'].''.$request['pin3'].''.$request['pin4'];
      }else {
        $pinno = $request['pinno'];
      }
      
      $rd = $request['rd'];
      $amount = $request['amount'];
      $services = $request['services'];
      $finduser = User::where('phone', "+91".$phone)->first();
      if ($finduser) {
       $passcheck = Hash::check($pinno, $finduser->password);
         if ($passcheck==true) {          
          
         if ($rd=="index") {
          Auth::login($finduser, true);
           return redirect('/');
         }else {

          Auth::login($finduser, true);

           return redirect('/cart');

       
             
         }          
        }else {
           return redirect('login')->withInput()->with('error','Invalid phone/pin no!');
        }
      }else {
        return redirect('login')->withInput()->with('error','User not found!');
      }
    }
    function login() {
       if (Helper::check_mobile()==1) {
        return view('loginpwa'); 
      }else {

       return view('login'); 
      }

    }
    function forgot() {
        if (Helper::check_mobile()==1) {
        return view('forgotpwa'); 
      }else {

       return view('forgot'); 
      }

    }

    function redirect_to_payment_gateway($services, $amount, $name, $email, $phone) {
         $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url')
        );
 
    try {
        $response = $api->paymentRequestCreate(array(
            "purpose" => $services,
            "amount" => $amount,
            "buyer_name" => $name,
            "send_email" => true,
            "email" => $email,
            "phone" => $phone,
            "redirect_url" => URL::to('payment/status')
            ));
             
            header('Location: ' . $response['longurl']);
            exit();
    }catch (Exception $e) {
        print('Error: ' . $e->getMessage());
    }
    }
    function sendpin(Request $request) {
      $phone = "+91".$request['phone'];
      $finduser = User::where('phone', $phone)->first();
      $pin = Helper::generatePIN();
      if ($finduser) {
        $pin = Helper::generatePIN();
        $update = DB::table('users')->where('phone',$phone)->update(['password' => bcrypt($pin)]);
         $content = "You have successfully reset your PIN. The new PIN is ".$pin.". Please login with your number ".$phone." and PIN and book services online at www.veniceindia.com";
         Helper::send_otp($phone,$content);
         return redirect('forgot')->withInput()->with('status','Pin sent to your registered number, please check!');
      }else {
          return redirect('forgot')->withInput()->with('error','Sorry, no user found with this number!');
      }
    }
    function register() {
        if (Helper::check_mobile()==1) {
        return view('registerpwa'); 
      }else {

       return view('register'); 
      }

     
    }
    function cregister(Request $request) {
       $name = $request['name'];
       $phone = "+91".$request['phone'];
       $email = $request['email'];
      if (Helper::check_mobile()==1) {
        $pinno = $request['pin1'].''.$request['pin2'].''.$request['pin3'].''.$request['pin4'];
      }else {
        $pinno = $request['pinno'];
      }
       $finduser = User::where('phone',$phone)->first();

       if ($finduser) {
        return redirect('login')->withInput()->with('error','Already registered!');

       }else {
         $user = new User;
         $user->name = $name;
         $user->email = $email;
         $user->phone = $phone;
         $user->password = bcrypt($pinno);
         $user->platform = 'web';
         $user->type = 'user';
         $user->save();
        
       return redirect('/login')->withInput()->with('status','Successfully registered, please login!');
       }



    }
}
