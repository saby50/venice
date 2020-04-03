
    <?php
    $unitid = 0;
    $url = URL::to('/');
      if (Session::has('food_cart')) {
        $fcart = Session::get('food_cart');
        if (count($fcart)!=0) {
          foreach ($fcart as $key => $value) {
            $unitid = $value['unit_id'];
          }
          $url = URL::to('show-menu/all/'.Crypt::encrypt($unitid));
        }
      }
    ?>
     <?php if(Helper::check_app()=="1"): ?>   
    <style type="text/css">
        .searc_by_restaurant {
    width: 100%;
    height: 65px;
    position: fixed;
    top: 59px;
    z-index: 9;
    background: #fff;
    padding: 10px;
    display: none;
   }
   .searc_by_dish {
    width: 100%;
    height: 65px;
    position: fixed;
    top: 59px;
    z-index: 9;
    background: #fff;
    padding: 10px;
    display: none;
   }
    </style>
    <?php else: ?>
          <style type="text/css">
        .searc_by_restaurant {
    width: 100%;
    height: 65px;
    position: fixed;
    top: 0px;
    z-index: 9;
    background: #fff;
    padding: 10px;
    display: none;
   }
   .searc_by_dish {
    width: 100%;
    height: 65px;
    position: fixed;
    top: 0px;
    z-index: 9;
    background: #fff;
    padding: 10px;
    display: none;
   }
    </style>
         <?php endif; ?>
     <?php if(Helper::get_device_platform()=="android"): ?>   
  <?php if(Helper::check_app()=="1"): ?>   
 <style type="text/css">
    
    .slider-pwa {
      margin-top: 115px;
    }
      #pre-header {
    height: 60px;
    background: #000;
    width: 100%;
        position: fixed;
    top: 0;
    z-index: 9;
  }
   
   .headpwa {
    top: 59px;
   }
    .firstbox {
      margin-top: 130px !important;
   }
  </style>
  
      <div id="pre-header">
        <div class="row">
            <div class="col-sm-12" style="z-index: 999;margin-left: -30px;">
                <ul>

                    <?php if(Helper::get_device_platform()=="android"): ?>   
                    <li class="list-inline-item" style="width: 100%;text-align: center;"><span style="color: #EF9E11">Download App: </span> <a href="https://play.google.com/store/apps/details?id=com.thebhasin.thegrandvenice" target="_blank"><img src="{{ asset('public/images/google.png') }}" style="height: 40px;width: auto;"></a></li>
                    <?php else: ?>
                    <li class="list-inline-item" style="width: 100%;text-align: center;"><span style="color: #EF9E11">Download App: </span> <a href="https://apps.apple.com/gb/app/the-grand-venice-mall/id1492430011?ign-mpt=uo%3D2" target="_blank"><img src="{{ asset('public/images/apple.png') }}" style="height: 40px;width: auto;"></a></li>
                     <?php endif; ?>
                    
                </ul>
            </div>
            
        </div>
       
    </div>  
     <?php endif; ?>
     <?php else: ?>
      <?php if(Helper::check_app_ios()=="1"): ?>   
      <style type="text/css">
    
    .slider-pwa {
      margin-top: 115px;
    }
      #pre-header {
    height: 60px;
    background: #000;
    width: 100%;
        position: fixed;
    top: 0;
    z-index: 9;
  }
   
   .headpwa {
    top: 59px;
   }
    .firstbox {
      margin-top: 130px !important;
   }
  </style>
      <div id="pre-header">
        <div class="row">
            <div class="col-sm-12" style="z-index: 999;margin-left: -30px;">
                <ul>

                    <?php if(Helper::get_device_platform()=="android"): ?>   
                    <li class="list-inline-item" style="width: 100%;text-align: center;"><span style="color: #EF9E11">Download App: </span> <a href="https://play.google.com/store/apps/details?id=com.thebhasin.thegrandvenice" target="_blank"><img src="{{ asset('public/images/google.png') }}" style="height: 40px;width: auto;"></a></li>
                    <?php else: ?>
                    <li class="list-inline-item" style="width: 100%;text-align: center;"><span style="color: #EF9E11">Download App: </span> <a href="https://apps.apple.com/gb/app/the-grand-venice-mall/id1492430011?ign-mpt=uo%3D2" target="_blank"><img src="{{ asset('public/images/apple.png') }}" style="height: 40px;width: auto;"></a></li>
                     <?php endif; ?>
                    
                </ul>
            </div>
            
        </div>
       
    </div>  
     <?php endif; ?>

      <?php endif; ?>
      <div class="searc_by_restaurant">
    <div class="row">
      <div class="col-1" style="margin-top: 7px;">
      <span class="backbtn ripple" style="font-size: 18px;"> <i class="fa fa-arrow-left fa-lg" style="color: #ccc;" aria-hidden="true"></i></span>

      </div>
       <div class="col-10">
        <input type="text" class="form-control search" name="search" placeholder="Search by restaurant name">
      </div>
        <div class="col-1" style="margin-left: -20px;margin-top: 7px;">
        <i class="fa fa-times fa-lg close_by_restaurant" style="color: #ccc;" aria-hidden="true"></i>

      </div>
    </div>
    </div>
    
    
  </div>
    <div class="searc_by_dish">
    <div class="row">
      <div class="col-1" style="margin-top: 7px;">
      <span class="backbtn ripple" style="font-size: 18px;"> <i class="fa fa-arrow-left fa-lg" style="color: #ccc;" aria-hidden="true"></i></span>

      </div>
       <div class="col-10">
        <input type="text" class="form-control search_dish" name="search" placeholder="Search by dish name">
      </div>
        <div class="col-1" style="margin-left: -20px;margin-top: 7px;">
        <i class="fa fa-times fa-lg close_by_dish" style="color: #ccc;" aria-hidden="true"></i>

      </div>
    </div>
    </div>
    
    
  </div>
 <?php if(Request::is('profile')): ?>   
<div class="headpwa" style="z-index: 1000;">
  <?php else: ?>
    <div class="headpwa">
     
    <?php endif; ?>
	<div class="row">
		
	
	<div class="col-9 leftside">
    <?php if(Request::is('/')): ?>		
	<i class="fa fa-bars menubtn" aria-hidden="true" style="cursor: pointer;"></i> 
	<img src="{{ asset('public/images/logowhite.png') }}" width="80px;" style="margin-top: -5px;margin-left: 20px;">
   <?php elseif(Request::segment(1)=="booking" || Request::segment(1)=="packs" ): ?>
    <span class="backbtn ripple" style="font-size: 16px;">
      <?php if(Helper::get_device_platform()=="android"): ?>   
      <img src="{{ asset('public/images/pwa/back_arrow.png') }}" width="20">
       <?php else: ?>
        <i class="fa fa-chevron-left fa-lg" aria-hidden="true" style="color: white"></i>
      <?php endif; ?>
        &nbsp;&nbsp;&nbsp;&nbsp;<?= $service_name ?></span>

  <?php elseif(Request::is('cart')): ?>
    <span class="backbtn ripple" style="font-size: 18px;"> <?php if(Helper::get_device_platform()=="android"): ?>   
      <img src="{{ asset('public/images/pwa/back_arrow.png') }}" width="20">
       <?php else: ?>
        <i class="fa fa-chevron-left fa-lg" aria-hidden="true" style="color: white"></i>
      <?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;Your Cart</span>
 <?php elseif(Request::is('commercial')): ?>
 <span class="backbtn ripple" style="font-size: 18px;"> <?php if(Helper::get_device_platform()=="android"): ?>   
      <img src="{{ asset('public/images/pwa/back_arrow.png') }}" width="20">
       <?php else: ?>
        <i class="fa fa-chevron-left fa-lg" aria-hidden="true" style="color: white"></i>
      <?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;GV Tower</span>
  <?php elseif(Request::is('food_cart')): ?>
    <span class="backbtn ripple" style="font-size: 18px;"> <?php if(Helper::get_device_platform()=="android"): ?>   
      <a href="<?= URL::to($url) ?>"><img src="{{ asset('public/images/pwa/back_arrow.png') }}" width="20"></a>
       <?php else: ?>
        <i class="fa fa-chevron-left fa-lg" aria-hidden="true" style="color: white"></i>
      <?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;Your Cart</span>
   
	<?php else: ?>
		<span class="backbtn ripple" style="font-size: 18px;"> <?php if(Helper::get_device_platform()=="android"): ?>   
      <img src="{{ asset('public/images/pwa/back_arrow.png') }}" width="20">
       <?php else: ?>
        <i class="fa fa-chevron-left fa-lg" aria-hidden="true" style="color: white"></i>
      <?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;@yield('title')</span>
	<?php endif; ?>
	</div>
	<div class="col-3 rightside">
    <?php if(Request::is('wallet')): ?>
		<div style="text-align: right;margin-left: -20px;"><a href="{{ URL::to('wallet/recharge') }}" style="color: #FFF;font-size: 14px;"><img src="{{ asset('public/images/topup.PNG') }}" width="40px"></a></div>
     <?php elseif(Request::is('wallet/recharge')): ?>

        <?php elseif(Request::is('show-menu')): ?>
        
      
      <?php elseif(Request::is('profile')): ?>
        <div style="text-align: right;"><a href="{{ URL::to('logout') }}" style="color: #FFF;font-size: 14px;" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" title="Logout"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
                                                   <form id="logout-form" action="{{ URL::to('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                                   </form> </div>
 <?php elseif(Request::is('pay')): ?>

      <!--  <div style="text-align: right;"><a href="{{ URL::to('logout') }}" style="color: #FFF;font-size: 14px;" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" title="Logout"><i class="fa fa-qrcode fa-2x" aria-hidden="true"></i></a>
                                                    </div> -->

    <?php else: ?>
       <?php if(Request::is('history/all')): ?>
        <!--  <div style="text-align: right;"><a href="{{ URL::to('profile') }}" style="color: #FFF;font-size: 14px;">Edit Profile</a></div> -->
        <?php elseif(Request::is('foodorder')): ?>
         <div class="res_search" style="text-align: right;">
          <i class="fa fa-search" aria-hidden="true"></i> </div>

         <?php elseif(Request::segment(1)=="show-menu"): ?>
         <div class="dish_search" style="text-align: right;"><i class="fa fa-search" aria-hidden="true"></i> </div>
        <?php else: ?>
      <ul class="notifications">
        <?php 
           $count = Helper::get_notification_count();
        ?>
      <li class="noti"><a href="{{ URL::to('notifications') }}" class="ripple"><i class="fa fa-bell" aria-hidden="true"></i> 
        <?php if($count != 0): ?>
        <span class="notify-bubble"><?= $count ?></span>
        <?php endif; ?></a></li>
        <?php 
        $profile = "login";
        if (Auth::check()) {
           $profile = "profile";
         }
        ?>
       <li class="profile"><a href="<?= URL::to($profile) ?>" class="ripple"><i class="fa fa-user" aria-hidden="true"></i></a></li>
    </ul>
    <?php endif; ?>
<?php endif; ?>
	</div>
	</div>
</div>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn">&times;</a>
  <div class="row" style="position: relative;top: -40px;">
  	<div class="col-12">
  		 <h4 class="mainhead">What are you looking for?</h4>
  	</div>
  	<div class="col-6">
     <h5 class="subhead">Activities</h5>
     <ul class="sidemenu-pwa">
     	<?php $services = Helper::get_services();
            foreach($services as $key => $value):
     	 ?>
     	<li><a href="<?= URL::to('booking/'.$value->alias."#bookingform") ?>"><?= $value->service_name ?></a></li>
     	
     <?php endforeach; ?>
     </ul>
 
  	</div>
  	<div class="col-6">
  		<h5 class="subhead">Packs</h5>
  		<ul class="sidemenu-pwa">
     	<?php $packs = Helper::get_packs();
            foreach($packs as $key => $value):
     	 ?>
     	<li><a href="<?= URL::to('packs/'.$value->alias."#bookingform") ?>"><?= $value->pack_name ?></a></li>
     	
     <?php endforeach; ?>
     </ul>
  	</div>
  	<div class="col-6">
     <h5 class="subhead">Facilities</h5>
     <ul class="sidemenu-pwa">
     	<li><a href="<?= URL::to('food-court') ?>">Food Court</a></li>
     	<li><a href="<?= URL::to('fine-dining') ?>">Fine Dining</a></li>
     	<li><a href="<?= URL::to('cafe-bakeries') ?>">Cafe & Bakeries</a></li>
     	<li><a href="<?= URL::to('shopping') ?>">Shopping</a></li>
     	<li><a href="<?= URL::to('cinepolis') ?>">Cinepolis</a></li>
      <li><a href="<?= URL::to('commercial#bookingform') ?>">GV Tower</a></li>
     	

     </ul>
 
  	</div>
  	<div class="col-6">
  		<h5 class="subhead">Social</h5>
  		<ul class="sidemenu-pwa">
     	<li><a href="https://www.facebook.com/GrandVenice/" target="_blank"><i class="fa fa-facebook fa-lg"></i> Facebook</a></li>
     	<li><a href="https://twitter.com/venice_grand/" target="_blank"><i class="fa fa-twitter fa-lg"></i> Twitter</a></li>
     	<li><a href="https://www.instagram.com/grandvenicemall/" target="_blank"><i class="fa fa-instagram fa-lg"></i> Instagram</a></li>
     	<li><a href="https://www.youtube.com/channel/UCnigkZG9wbheaIW36_AuP3Q" target="_blank"><i class="fa fa-youtube fa-lg"></i> Youtube</a></li>
     	  <li><a href="https://www.linkedin.com/company/grandvenice/?viewAsMember=true" target="_blank"><i class="fa fa-linkedin fa-lg"></i> <span style="position: relative;top:2px;">Linkedin</span></a></li>
     </ul>
  	</div>
  	<div class="col-12 dotted-seperator"></div>
  	<div class="col-6 menu-info">
  		<i class="fa fa-envelope-o fa-lg"></i> info@veniceindia.com
  		
  	</div>
  	<div class="col-4 menu-info">
  		<i class="fa fa-phone fa-lg"></i> 8860 666 666
  		
  	</div>
  	<div class="col-12" style="text-align: center;">
  		<a href="{{ URL::to('contact') }}"><button class="btn btn-orange">Contact us</button></a>
  		
  	</div>
  </div>
 
 
</div>
<script>
$(document).ready(function() {
   $(".menubtn").click(function() {
   	  $(".sidenav").show('fast');
   });
   $(".closebtn").click(function() {
   	  $(".sidenav").hide('fast');
   });
   $(".backbtn").click(function() {
      window.history.back();
   });
});

</script>
<style type="text/css">
	.backbtn {
		color: #FFF;
        font-size: 14px;
	}
  .firstbox {
      margin-top: 70px;
   }

   .searchbox {
    position: absolute;
    left: -213px;
    top: 12px;
    display: none;
   }
 
    
   .search {
     border: none;
     border-bottom: solid 1px #ccc;
     border-radius: 0px;
   }
    .search_dish {
     border: none;
     border-bottom: solid 1px #ccc;
     border-radius: 0px;
   }
</style>
<script type="text/javascript">
  $(document).ready(function() {
    $(".dish_search").click(function() {
       $(".headpwa").hide("fast");
     $(".searc_by_dish").show('fast');
     $(".search_dish").focus();
    });
      $(".close_by_dish").click(function() {
       $(".headpwa").show("fast");
     $(".searc_by_dish").hide('fast');
      $(".recommended").show();
      $(".recyclerview:nth-child(2)").removeClass('firstbox');
    
    });
  $(".res_search").click(function() {
    $(".headpwa").hide("fast");
     $(".searc_by_restaurant").show('fast');
     $(".search").focus();
     
  });

  $(".close_by_restaurant").click(function() {
    $(".searc_by_restaurant").hide("fast");
     $(".headpwa").show("fast");
      $(".restaurant").html("");
          $(".restaurantall").css('display','block');
          $(".slider-pwa").show("fast");
          $(".recyclerview").removeClass("firstbox");
     
  });
  });

</script>

