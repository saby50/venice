<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','WebController@index');

Route::get('booking/{type}','BookingController@index');
Route::get('booking/get_rates/{service_id}/{date}/{arrival_time}/{quantity}/{canal}/{type}/{occassion_type}/{rate_type}','BookingController@get_rates');

Route::get('cart', 'CartController@index');
Route::get('history/fooddetails/{order_id}', 'WebController@foodhistory');
Route::get('cart/remove_item/{key}', 'CartController@remove_item');
Route::get('cart/remove_item_food/{key}', 'CartController@remove_item_food');
Route::get('cart/remove_all', 'CartController@remove_all');
Route::post('cart/add_item', 'CartController@add_item');
Route::post('cart/update_quantity', 'CartController@update_quantity');
Route::post('cart/update_pack_quantity', 'CartController@update_pack_quantity');
Route::post('cart/checkout', 'PaymentController@checkout');
Route::POST('/logout', 'Auth\LoginController@logout');
Route::POST('/clogin', 'Auth\LoginController@clogin');
Route::POST('/cregister', 'Auth\LoginController@cregister');
Route::get('login', 'Auth\LoginController@login');
Route::get('register', 'Auth\LoginController@register');
Route::get('payment/status', 'PaymentController@status');
Route::get('payment/status2', 'PaymentController@status2');
Route::get('parking', 'ParkingController@index');
Route::get('payment/statuscheck', 'PaymentController@statuscheck');
Route::get('packs/{type}', 'PackController@index');
Route::get('notifications', 'WebController@notifications');
Route::get('notifications_units', 'WebController@notifications_units');
Route::get('commercial', 'PackController@commercial');
Route::get('packs/get_packs_price/{quantity}/{pack_id}', 'PackController@get_packs_price');
Route::get('profile', 'WebController@profile');
Route::get('history/{type}', 'WebController@history');
Route::get('invoice/{id}', 'WebController@invoice');
Route::get('food_invoice/{id}', 'WebController@food_invoice');
Route::get('event_invoice/{id}', 'WebController@event_invoice');
Route::post('profile/update', 'WebController@update_profile');
Route::get('profile/pin', 'WebController@pin');
Route::get('forgot', 'Auth\LoginController@forgot');
Route::post('forgot/sendpin', 'Auth\LoginController@sendpin');
Route::post('pin/update', 'WebController@update_pin');
Route::get('contact', 'WebController@contact');
Route::get('show-menu/{view}/{id}', 'WebController@showmenu');
Route::get('menu/addons/{id}', 'WebController@addons');
Route::get('categories', 'WebController@categories');
Route::post('sendcontact', 'WebController@sendcontact');
Route::get('privacy-policies', 'WebController@privacypolicies');
Route::get('terms-conditions', 'WebController@termsconditions');
Route::get('refund-cancellation-policy', 'WebController@refundpolicy');
Route::get('sendmail/{order_id}', 'WebController@sendMail');
Route::get('food-court', 'WebController@terrazzo');
Route::get('fine-dining', 'WebController@urzaa');
Route::get('feedback/{order_id}', 'WebController@feedback');
Route::get('cafe-bakeries', 'WebController@bakery');
Route::get('status_s', 'PaymentController@status_s');
Route::get('food/status_s', 'WebController@status_s');
Route::get('remove_coupon', 'CartController@remove_coupon');
Route::get('status_f', 'PaymentController@status_f');
Route::get('events/{event_alias}', 'EventController@index');
Route::post('events/add_event', 'EventController@add_event');
Route::post('events/send', 'EventController@send');
Route::post('apply_coupon', 'CartController@apply_coupon');
Route::get('echeckout/{payment_method}', 'EventController@checkout');
Route::get('event/status', 'EventController@status');
Route::get('getunitqr/{unit_id}', 'WebController@getunitqr');
Route::get('get_time/{event_date}/{event_id}', 'EventController@get_time');
Route::get('event/gudgudi-terms-conditions', 'EventController@event_terms_condtions');
Route::get('shopping', 'ShopController@index');
Route::get('shop/{alias}', 'ShopController@shop');
Route::get('shops/get_logos/{alphabet}/{floor}', 'ShopController@get_logos');
Route::post('/paytm', 'PaymentController@paytm');
Route::post('callback', 'PaymentController@paytmCallback');
Route::get('careers', 'WebController@careers');
Route::get('offline', 'WebController@offline');
Route::get('sendfeedbacksms', 'WebController@sendfeedbacksms');
Route::get('cinepolis', 'WebController@movies');
Route::get('api/get_app_data', 'ApiController@get_app_data');
Route::post('api/search_restaurants', 'ApiController@search_restaurants');
Route::post('api/search_dish', 'ApiController@search_dish');
Route::post('api/recieve_payment', 'ApiController@recieve_payment');
Route::get('wallet', 'WalletController@wallet');
Route::get('testpush', 'WalletController@testpush');
Route::get('wallet/recharge', 'WalletController@recharge');
Route::get('scanpay', 'WalletController@scanpay');
Route::get('wallet/promo', 'WalletController@promo');
Route::get('/api/app', 'ApiController@app');
Route::get('/api/unit_app', 'ApiController@unit_app');
Route::post('recharge/payment', 'WalletController@recharge_payment');
Route::get('recharge/status', 'WalletController@recharge_status');
Route::get('pay', 'WalletController@pay');
Route::post('pay/process', 'WalletController@process');
Route::get('paynow/{id}', 'WalletController@paynow');
Route::get('view_all', 'WalletController@view_all');
Route::POST('api/get_recive_payment', 'ApiController@get_recive_payment');
Route::POST('api/check_otp', 'ApiController@check_otp');
Route::get('instaprocess', 'WalletController@instaprocess');
Route::get('history/details/{id}', 'WebController@history_details');
Route::get('api/get_denom_percent/{price}', 'ApiController@get_denom_percent');
Route::get('api/get_units', 'ApiController@get_units');
Route::post('applynow', 'WebController@applynow');
Route::post('send/leads', 'WebController@leads');
Route::post('send/feedback', 'WebController@sendfeedback');
Route::post('menu/foodcart', 'WebController@foodcart');
Route::post('menu/foodcartarr', 'WebController@foodcartarr');
Route::post('menu/foodcart_update', 'WebController@foodcart_update');
Route::get('menu/get_cart_data/{unit_id}', 'WebController@get_cart_data');
Route::get('food_cart', 'WebController@food_cart');
Route::get('search', 'WebController@search');
Route::get('getaddonfields/{item_id}', 'WebController@getaddonfields');
Route::get('food_payment/status', 'WebController@foodstatus');
Route::get('food_cart/remove_item/{key}', 'WebController@remove_item');
Route::get('foodorder', 'WebController@foodorder');
Route::post('food_cart/checkout', 'WebController@food_checkout');
Route::post('update_cart', 'WebController@update_cart');
Route::post('menu/add_item_cart', 'WebController@add_item_cart');
Route::any('/{page?}',function(){
    $categories = Helper::get_menu();
      $packs = DB::table('packs')->get();
  return View::make('errors.404',compact('categories','packs'));
})->where('page','.*');

