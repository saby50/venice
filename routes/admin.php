<?php
    Route::GET('/home/{parameter}/{type}', 'AdminController@index')->name('admin.home');
    // Login and Logout
    Route::GET('/', 'LoginController@showLoginForm')->name('admin.login');
    Route::POST('/', 'LoginController@login');
    Route::POST('/logout', 'LoginController@logout')->name('admin.logout');
    Route::get('get_app_managers_access/{email}/{type}', 'ApiController@get_app_managers_access');
    Route::get('get_app_managers_all_access/{email}/{type}/{parameter}', 'ApiController@get_app_managers_all_access');

    Route::get('get_app_managers_date_access/choose/{email}/{type}/{parameter}','ApiController@get_app_managers_date_access');
    
    // Password Resets
    Route::POST('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::GET('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::POST('/password/reset', 'ResetPasswordController@reset');
    Route::GET('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::GET('/password/change', 'AdminController@showChangePasswordForm')->name('admin.password.change');
    Route::POST('/password/change', 'AdminController@changePassword');

    // Register Admins
    Route::get('/register', 'RegisterController@showRegistrationForm')->name('admin.register');
    Route::post('/register', 'RegisterController@register');
    Route::get('/{admin}/edit', 'RegisterController@edit')->name('admin.edit');
    Route::delete('/{admin}', 'RegisterController@destroy')->name('admin.delete');
    Route::patch('/{admin}', 'RegisterController@update')->name('admin.update');

    // Admin Lists
    Route::get('/show', 'AdminController@show')->name('admin.show');
    Route::get('/taxes', 'TaxController@index');
    Route::POST('/addtax', 'TaxController@addtax')->name('admin.addtax');
    Route::GET('/deletetax/{id}', 'TaxController@deletetax')->name('admin.deletetax');
    Route::get('/edittax/{id}', 'TaxController@edittax')->name('admin.edittax');
    Route::POST('/updatetax', 'TaxController@updatetax')->name('admin.updatetax');

    // Admin Roles
    Route::post('/{admin}/role/{role}', 'AdminRoleController@attach')->name('admin.attach.roles');
    Route::delete('/{admin}/role/{role}', 'AdminRoleController@detach');
    //Managers
     Route::get('/manage_users/all', 'ManagerController@index'); 
     Route::get('/manage_users/create', 'ManagerController@create'); 
      Route::post('/manage_users/add', 'ManagerController@add'); 
      Route::get('/manage_users/delete/{id}', 'ManagerController@delete'); 
      Route::get('/manage_users/edit/{id}', 'ManagerController@edit'); 
       Route::post('/manage_users/update', 'ManagerController@update'); 
    //Venue
    Route::get('/venue', 'VenueController@index')->name('admin.venue'); 
    Route::get('/venue/create', 'VenueController@create')->name('venue.create'); 
    Route::POST('/venue/add', 'VenueController@add'); 
    Route::get('/venue/delete/{id}', 'VenueController@delete');
    Route::get('/venue/edit/{id}', 'VenueController@edit');
    Route::POST('/venue/update', 'VenueController@update'); 
     Route::get('/qrcode/{id}', 'WalletController@qrcode');
    //Services
    Route::get('/services', 'ServiceController@index')->name('admin.services'); 
    Route::get('/services/create', 'ServiceController@create')->name('admin.services');
    Route::POST('/services/add', 'ServiceController@add');  
    Route::get('/services/delete/{id}', 'ServiceController@delete');  
    Route::get('/services/edit/{id}', 'ServiceController@edit');  
    Route::POST('/services/update', 'ServiceController@update');  
    Route::post('/services/upload_icon', 'ServiceController@upload_icon');
    Route::post('/services/upload_vidicon', 'ServiceController@upload_vidicon');
    Route::get('/services/load_vidicon/{id}', 'ServiceController@load_vidicon');
    Route::post('/services/delete_vidicon', 'ServiceController@delete_vidicon');
    Route::post('/services/upload_forground', 'ServiceController@upload_forground');
    Route::post('/services/upload_gallery', 'ServiceController@upload_gallery');  

     Route::post('/services/upload_featured_app', 'ServiceController@upload_featured_app');  
      Route::get('/services/load_featured_app/{id}', 'ServiceController@load_featured_app'); 
      Route::post('/services/delete_featured_app', 'ServiceController@delete_featured_app');


     Route::post('/packs/upload_featured_app', 'PacksController@upload_featured_app');  
      Route::get('/packs/load_featured_app/{id}', 'PacksController@load_featured_app'); 
      Route::post('/packs/delete_featured_app', 'PacksController@delete_featured_app');
      
    Route::get('/services/uploads/{id}', 'ServiceController@uploads'); 

    Route::get('/services/load_icon/{id}', 'ServiceController@load_icon'); 
    Route::get('/services/load_forground/{id}', 'ServiceController@load_forground'); 
    Route::post('/services/delete_icon', 'ServiceController@delete_icon');

    Route::get('/services/load_gallery/{id}', 'ServiceController@load_gallery'); 
    Route::post('/services/delete_gallery', 'ServiceController@delete_gallery');
    Route::post('/services/delete_forground', 'ServiceController@delete_forground');
    Route::post('/services/upload', 'ServiceController@upload');

    //Upload Featured services
    Route::post('/services/upload_featured', 'ServiceController@upload_featured');
    Route::get('/services/load_featured/{id}', 'ServiceController@load_featured');
    Route::post('/services/delete_featured', 'ServiceController@delete_featured');
    Route::post('/services/upload_mobile_banner', 'ServiceController@upload_mobile_banner');
    Route::get('/services/load_mobile_banner/{id}', 'ServiceController@load_mobile_banner');
    Route::post('/services/delete_mobile_banner', 'ServiceController@delete_mobile_banner');

    //Upload Featured packs
    Route::post('/packs/upload_featured', 'PacksController@upload_featured');
    Route::get('/packs/load_featured/{id}', 'PacksController@load_featured');
    Route::post('/packs/delete_featured', 'PacksController@delete_featured');
    Route::post('/packs/upload_mobile_banner', 'PacksController@upload_mobile_banner');
    Route::get('/packs/load_mobile_banner/{id}', 'PacksController@load_mobile_banner');
    Route::post('/packs/delete_mobile_banner', 'PacksController@delete_mobile_banner');

    //Rates
    Route::get('/rates/{category_id}', 'RateController@index')->name('admin.rates'); 
    Route::get('/rates/create/{category_id}', 'RateController@create')->name('admin.rates');
    Route::post('/rates/add', 'RateController@add');
    Route::get('/rates/delete/{id}', 'RateController@delete');
    Route::get('/rates/edit/{id}/{category_id}', 'RateController@edit');
    Route::post('/rates/update', 'RateController@update');

    //Categories 
    Route::get('/categories', 'ServiceController@categories')->name('admin.categories'); 
    Route::get('/categories/create', 'ServiceController@create_categories')->name('admin.categories'); 
    Route::POST('/categories/add', 'ServiceController@add_categories');
    Route::get('/categories/delete/{id}', 'ServiceController@delete_category'); 
    Route::get('/categories/edit/{id}', 'ServiceController@edit_category'); 
    Route::POST('/categories/update', 'ServiceController@update_category');  


    //combos
    Route::post('/packs/upload_icon', 'PacksController@upload_icon');
    Route::get('/packs/load_icon/{id}', 'PacksController@load_icon');
    Route::get('/api/checknewbookings/{email}', 'ApiController@checknewbookings');
    Route::get('/api/get_booking_counts', 'ApiController@get_booking_counts');
    Route::get('/packs/get_quantity/{service_id}/{pack_id}', 'PacksController@get_quantity');
    Route::post('/packs/delete_icon', 'PacksController@delete_icon'); 
    Route::post('/packs/upload_forground', 'PacksController@upload_forground');
    Route::post('/packs/delete_forground', 'PacksController@delete_forground');
    Route::get('/packs/load_forground/{id}', 'PacksController@load_forground');
    Route::get('/packs/load_gallery/{id}', 'PacksController@load_gallery'); 
    Route::post('/packs/delete_gallery', 'PacksController@delete_gallery');
    Route::post('/packs/upload_gallery', 'PacksController@upload_gallery');   
    Route::get('/packs', 'PacksController@index')->name('admin.packs'); 
    Route::get('/packs/create/{type}', 'PacksController@create')->name('admin.packs');
    Route::POST('/packs/add', 'PacksController@add'); 
    Route::POST('/packs/update', 'PacksController@update');   
    Route::POST('/packs/upload', 'PacksController@upload');  
    Route::get('/packs/delete/{id}', 'PacksController@delete'); 
    Route::get('/packs/uploads/{id}', 'PacksController@uploads');
     Route::get('/packs/edit/{id}', 'PacksController@edit');
    Route::get('/get_services/{category_id}', 'PacksController@get_services')->name('admin.packs');

      Route::post('/packs/upload_vidicon', 'PacksController@upload_vidicon');
    Route::get('/packs/load_vidicon/{id}', 'PacksController@load_vidicon');

    Route::get('units', 'UnitsController@index');
    Route::get('units/revenue/{filter}/{filter2}', 'UnitsController@revenue');
    Route::get('recharge/{filter}/{filter2}', 'WalletController@recharge_history');
    Route::get('units/recieve', 'UnitsController@recieve');
    Route::get('units/revenue/custom/{filter}', 'UnitsController@custom');
     Route::get('units_cat/delete/{id}', 'UnitsController@units_cat');
     Route::get('units/categories', 'UnitsController@unit_categories');
    Route::get('units/create', 'UnitsController@create');
    Route::get('units/delete/{id}', 'UnitsController@delete');
 Route::get('units/edit/{id}', 'UnitsController@edit');
 Route::post('units/update', 'UnitsController@update');
 Route::post('units/add', 'UnitsController@add');
  Route::post('units/upload_foodstore_app', 'UnitsController@upload_foodstore_app');
   Route::get('units/load_foodstore_app/{id}', 'UnitsController@load_foodstore_app');
   Route::post('units/delete_foodstore_app/', 'UnitsController@delete_foodstore_app');
    Route::post('/packs/delete_vidicon', 'PacksController@delete_vidicon');

    //Shops
    Route::get('shops','ShopController@index');
    Route::get('shops/create','ShopController@create');
    Route::get('shops/edit/{id}','ShopController@edit');
    Route::post('shops/add','ShopController@add');
    Route::get('shops/uploads/{id}','ShopController@uploads');
    Route::post('/shops/upload_banner', 'ShopController@upload_banner');
    Route::get('/shops/load_banner/{id}', 'ShopController@load_banner');
    Route::post('/shops/delete_banner', 'ShopController@delete_banner'); 
    Route::post('/shops/upload_mobile_banner', 'ShopController@upload_mobile_banner');
    Route::get('/shops/load_mobile_banner/{id}', 'ShopController@load_mobile_banner');
    Route::post('/shops/delete_mobile_banner', 'ShopController@delete_mobile_banner');
    Route::post('/shops/upload_gallery', 'ShopController@upload_gallery');
    Route::get('/shops/load_gallery/{id}', 'ShopController@load_gallery');
    Route::post('/shops/delete_gallery', 'ShopController@delete_gallery'); 
    Route::post('/shops/upload_featured', 'ShopController@upload_featured');
    Route::get('/shops/load_featured/{id}', 'ShopController@load_featured');
    Route::get('/shops/delete/{id}', 'ShopController@delete');
    Route::post('/shops/delete_featured', 'ShopController@delete_featured');

    Route::post('/shops/upload_home_banner', 'ShopController@upload_home_banner');
    Route::get('/shops/load_home_banner/{id}', 'ShopController@load_home_banner');
    Route::post('/shops/delete_home_banner', 'ShopController@delete_home_banner');

    Route::post('/shops/upload_logo', 'ShopController@upload_logo');
    Route::get('/shops/load_logo/{id}', 'ShopController@load_logo');
    Route::post('/shops/delete_logo', 'ShopController@delete_logo');

    Route::post('/shops/upload_home_mobile_banner', 'ShopController@upload_home_mobile_banner');
    Route::get('/shops/load_home_mobile_banner/{id}', 'ShopController@load_home_mobile_banner');
    Route::post('/shops/delete_home_mobile_banner', 'ShopController@delete_home_mobile_banner');
    Route::post('/shops/uploadr', 'ShopController@uploadr');
    Route::post('/shops/update', 'ShopController@update');
    Route::get('/shops/delete/{id}', 'ShopController@delete');
    Route::get('/shop_categories', 'ShopController@shop_categories');
    Route::get('shops/categories/create', 'ShopController@shop_categories_create');
    Route::post('/shops/cat_add', 'ShopController@cat_add');
    Route::get('shops/category/delete/{id}', 'ShopController@delete_category');
    Route::get('shops/category/edit/{id}', 'ShopController@edit_category');
     Route::post('/shops/cat_update', 'ShopController@cat_update');

     //Events
     Route::get('events_bookings', 'EventsController@events_bookings');
     Route::get('/events/', 'EventsController@index');
    
     Route::get('/events/create/', 'EventsController@create');
     Route::post('/events/add', 'EventsController@add');
     Route::get('/events/uploads/{id}', 'EventsController@uploads');
     Route::post('/events/upload_banner', 'EventsController@upload_banner');
    Route::get('/events/load_banner/{id}', 'EventsController@load_banner');
    Route::post('/events/delete_banner', 'EventsController@delete_banner'); 

    Route::post('/events/upload_gallery', 'EventsController@upload_gallery');
    Route::get('/events/load_gallery/{id}', 'EventsController@load_gallery');
    Route::post('/events/delete_gallery', 'EventsController@delete_gallery'); 
    Route::post('/events/upload_mobile_banner', 'EventsController@upload_mobile_banner');
    Route::get('/events/load_mobile_banner/{id}', 'EventsController@load_mobile_banner');
    Route::post('/events/delete_mobile_banner', 'EventsController@delete_mobile_banner');
        Route::post('/events/uploadr', 'EventsController@uploadr');
         Route::get('/events/delete/{id}', 'EventsController@delete');


    Route::get('slides','HomeController@index');

    Route::get('movies','HomeController@movies');
    Route::get('movies/delete/{id}','HomeController@movie_delete');
     Route::post('movies/upload_r','HomeController@upload_r');
      Route::post('movies/update','HomeController@movie_update');
    Route::get('movies/create','HomeController@movie_create');
    Route::get('movies/edit/{id}','HomeController@movie_edit');
    Route::get('movies/upload/{id}','HomeController@movie_upload');
    Route::post('movies/add','HomeController@movie_add');
     Route::post('movies/upload_icon', 'HomeController@upload_icon');
     Route::get('movies/load_icon/{id}','HomeController@load_icon');
      Route::post('movies/delete_icon','HomeController@delete_icon');
    Route::get('slide/create','HomeController@create');
    Route::post('slide/add','HomeController@add');
    Route::post('slide/update','HomeController@update');
    Route::get('slide/uploads/{id}','HomeController@uploads');
    Route::get('slide/delete/{id}','HomeController@delete');
    Route::get('slide/edit/{id}','HomeController@edit');
    Route::post('/slide/upload_banner', 'HomeController@upload_banner');
    Route::get('/slide/load_banner/{id}', 'HomeController@load_banner');
    Route::post('/slide/delete_banner', 'HomeController@delete_banner');

    Route::post('/slide/upload_mobile_banner', 'HomeController@upload_mobile_banner');
    Route::get('/slide/load_mobile_banner/{id}', 'HomeController@load_mobile_banner');
    Route::post('/slide/delete_mobile_banner', 'HomeController@delete_mobile_banner');
    Route::post('/slide/uploadr', 'HomeController@uploadr');
    Route::POST('/api/applogin', 'ApiController@applogin');
    Route::POST('/api/forgotpin', 'ApiController@forgotpin');
    Route::GET('/api/food_items_status/{unit_id}', 'ApiController@food_items_status');
    Route::POST('/api/change_status', 'ApiController@change_status');
    Route::POST('/api/checkin', 'ApiController@checkin');
    Route::POST('/api/getdata', 'ApiController@get_data');
    Route::POST('/api/get_food_data', 'ApiController@get_food_data');
    Route::POST('/api/change_food_status', 'ApiController@change_food_status');
    Route::POST('/api/refund_food', 'ApiController@refund_food');
    Route::POST('/api/unit_refund', 'ApiController@unit_refund');
    Route::POST('/api/unit_refund_web', 'ApiController@unit_refund_web');
    Route::get('/api/unit_daily_reporting', 'ApiController@unit_daily_reporting');
    
    //Bookings
    Route::get('bookings/today','BookingsController@index');
    Route::get('bookings/s/{parameter}/{type}','BookingsController@all');
    Route::get('bookings/choose/{parameter}/{type}','BookingsController@choose');
    Route::get('bookings/get_bookings','BookingsController@get_bookings');
    Route::get('cash_bookings','BookingsController@cash_bookings');
    Route::get('wallet/topup','BookingsController@topup');
    Route::get('checkuser/{phone}','WalletController@checkuser');
    Route::get('push','WalletController@push');
    Route::get('unit_push','WalletController@unit_push');
    Route::get('delete_notification/{id}','WalletController@delete_notification');
    Route::get('delete_notification_unit/{id}','WalletController@delete_notification_unit');
    Route::POST('send_push','WalletController@send_push');
    Route::POST('send_push_unit','WalletController@send_push_unit');
     Route::POST('bookings/checkin', 'BookingsController@checkin');  
    Route::POST('topup/add', 'BookingsController@topupadd');  
     Route::POST('booking/cash', 'BookingsController@cash'); 
     Route::get('cash/total', 'BookingsController@total'); 
      Route::get('status_s', 'BookingsController@status_s'); 
      Route::post('booking/set_cart', 'BookingsController@set_cart');  
      Route::get('flush_session_now', 'BookingsController@flush_session_now'); 
      Route::get('sendfeedbacksms', 'BookingsController@sendfeedbacksms');
    //Users
    Route::get('users','AdminController@users');
    Route::get('users/get_users','AdminController@get_users');
    Route::post('users/sendsms','AdminController@sendsms');
    Route::get('compose','AdminController@compose');
    Route::get('users/export','AdminController@export_data');
    Route::post('changeassignment','BookingsController@changeassignment');
    Route::post('users/send','AdminController@send');

    Route::post('changecanal','BookingsController@changecanal');
    //Reports
    Route::get('reports/{type}/{date_type}','ReportController@index');
    Route::get('settings','AdminController@settings');
    Route::get('download-reports/{datetype}','ReportController@downloadreports');
    Route::get('maintenance','AdminController@maintenance');
    Route::post('update_version','AdminController@update_version');
     Route::post('main_update','AdminController@main_update');
     Route::get('delete_mailer/{id}','AdminController@delete_mailer');
      Route::get('edit_mailer/{id}','AdminController@edit_mailer');
    Route::post('addmailers','AdminController@addmailers');
    Route::post('updatemailers','AdminController@updatemailers');
    Route::post('refundinitiate','AdminController@refundinitiate');
    Route::post('recieve_payment','UnitsController@recieve_payment');
    Route::get('checkotp/{phone}','UnitsController@checkotp');
    Route::post('send_otp','UnitsController@send_otp');

     Route::post('changedate','AdminController@changedate');
      Route::get('deletebooking/{id}','BookingsController@deletebooking');
    Route::get('holidays','HolidayController@index');
    Route::get('holidays/create','HolidayController@create');
    Route::get('holidays/edit/{id}','HolidayController@edit');
    Route::get('holidays/delete/{id}','HolidayController@delete');
     Route::post('holidays/add','HolidayController@add');
      Route::post('holidays/update','HolidayController@update');
    Route::get('foc','FocController@index');
    Route::get('foc/create','FocController@create');
    Route::get('reasons','FocController@reasons');
     Route::get('reasons/create','FocController@reason_create');
     Route::post('reasons/add','FocController@reason_add');
     Route::post('reasons/update','FocController@reason_update');
    Route::get('reasons/delete/{id}','FocController@reasons_delete');
    Route::get('reasons/edit/{id}','FocController@reasons_edit');
    Route::get('foc/delete/{id}','FocController@delete');
    Route::get('foc/edit/{id}','FocController@edit');
    Route::post('foc/update','FocController@update');
     Route::get('foc/approve/{order_id}','ApproveController@approve');
     Route::get('foc/reject/{order_id}','ApproveController@reject');
    Route::post('foc/add','FocController@add');
    Route::post('add_lead_comment','LeadsController@add_lead_comment');
     Route::get('gondolier','GondolierController@index');
     Route::get('gondolier/create','GondolierController@create');
     Route::post('gondolier/add','GondolierController@add');
     Route::post('api/gettoken','ApiController@gettoken');
     Route::get('gondolier/delete/{id}','GondolierController@delete');
     Route::get('leads/{type}','LeadsController@index');
      Route::get('gondolier/reports/{type}','GondolierController@reports');
      Route::get('feedbacks/{type}/{type2}','FeedbackController@index');
     Route::get('update_lead_status/{lead_id}/{status}','LeadsController@update_lead_status');
     Route::get('lead_claim/{lead_id}','LeadsController@lead_claim');
     Route::get('get_lead_data/{lead_id}','LeadsController@get_lead_data');
    // Roles
    Route::get('/roles', 'RoleController@index')->name('admin.roles');
    Route::get('/role/create', 'RoleController@create')->name('admin.role.create');
    Route::post('/role/store', 'RoleController@store')->name('admin.role.store');
    Route::delete('/role/{role}', 'RoleController@destroy')->name('admin.role.delete');
    Route::get('/role/{role}/edit', 'RoleController@edit')->name('admin.role.edit');
    Route::patch('/role/{role}', 'RoleController@update')->name('admin.role.update');
    Route::get('addmenu/{unit_id}','MenuController@addmenu');
    Route::get('create-menu-item/{unit_id}','MenuController@createitem');
    Route::get('get_addon/{addonid}','UnitsController@get_addon');
    Route::get('edit-menu-item/{unit_id}','MenuController@edititem');
    Route::get('delete-menu-item/{unit_id}','MenuController@deleteitem');
     Route::get('delete-menu-addon/{addon_id}','MenuController@deleteaddons');
     Route::get('removeaddon/{addon_id}','MenuController@removeaddon');
    Route::post('addmenuitem','MenuController@addmenuitem');
    Route::post('updatemenuitem','MenuController@updatemenuitem');
    Route::post('menu/addons_edit','MenuController@addons_edit');
    Route::post('/menu/upload_featured_item', 'MenuController@upload_featured_item');
    Route::post('/menu/delete_featured_item', 'MenuController@delete_featured_item');
    Route::post('menu/addons_create', 'MenuController@addons_create');
    Route::get('/menu/load_featured_item/{id}', 'MenuController@load_featured_item');
    Route::fallback(function () {
        return abort(404);
    });
