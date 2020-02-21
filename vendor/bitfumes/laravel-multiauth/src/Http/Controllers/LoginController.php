<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Helper;
use DB;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin:admin', ['only' => 'showLoginForm']);
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $user_type = Helper::get_user_type($request['email']);

        if ($user_type=="lead_manager") {
            return redirect('admin/leads/all');
        }elseif ($user_type=="pos") {
            return redirect('admin/cash_bookings');
        }elseif ($user_type=="food_analyst") {
            return redirect('admin/units/revenue/todays/all');
        }elseif ($user_type=="unit_manager") {
            
            return redirect('admin/units/revenue/todays/'.Helper::get_unit_manager_id($request['email']));
        }elseif ($user_type=="analyst") {
            return redirect('admin/bookings/today');
        }else {
            return redirect('admin/bookings/today');
        }

        
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('multiauth::admin.login');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $request['active'] = 1;
        return $request->only($this->username(), 'password', 'active');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect(route('admin.login'));
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function redirectPath()
    {
        return config('multiauth.redirect_after_login');
    }
}
