<?php 
$categories = Helper::get_menu();
$packs = Helper::get_packs();
$events = Helper::get_events();
$segment = Request::segment(1);
$segment2 = Request::segment(2);
$gvtower = Helper::get_gv_tower();
$array = array();
$tempval = "";
?>
<header id="header">
        <div class="container">
            <div id="logo" class="pull-left">
                <a href="<?php echo e(URL::to('/')); ?>"><img src="<?php echo e(asset('public/images/logo.png')); ?>" alt="" title="" /></img></a>
                <!-- Uncomment below if you prefer to use a text logo -->
                <!--<h1><a href="#hero">Regna</a></h1>-->
            </div>
            <div class="cart-mobile">
              <?php
                     if(Session::has('cart')) {
                        if (count(Session::get('cart'))==0) {
                         echo '<a href="#"><i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:24px;color: #EF9E11;"></i> <span class="badge badge-warning" id="lblCartCount">0</span></a>';
                     }else {
                        echo '<a href="'.URL::to("cart").'"><i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:24px;color: #EF9E11;"></i> <span class="badge badge-warning" id="lblCartCount">'.count(Session::get('cart')).'</span></a>';
                     } 
                 }else {
                    echo '<a href="#"><i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:24px;color: #EF9E11;"></i> <span class="badge badge-warning" id="lblCartCount">0</span></a>';
                 } 
                      


                      ?>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class="<?php if($segment=='') { echo 'menu-active'; } ?>"><a href="<?= URL::to('/') ?>">Home</a></li>
                    <li>|</li>
                     <?php foreach($categories as $key => $value): ?>
                    <?php 
                          list($a,$b) = explode('_', $key);  
                         
                          ?>
                          <?php if($b=="gondolaride"): ?>
                      <li class="menu-has-children  <?php if($segment2=='gondola') { echo 'menu-active'; } ?>"><a href="<?= URL::to('categories#'.$b) ?>">

                        <?php else: ?>
                          <li class="menu-has-children  <?php if($segment2=='zipline' || $segment2=="trampoline-park" || $segment2=="bumpin-car" || $segment2=="the-house-of-dead" || $segment2=="7d-theatre") { echo 'menu-active'; } ?>"><a href="<?= URL::to('categories#'.$b) ?>">
                          <?php endif; ?>
                        <?php 
                          
                          echo $a; 
                          ?></a>
                        <ul>
                            <?php foreach($value as $k => $v): ?>
                            <li><a href="<?= URL::to('booking/'.$v->alias) ?>"><?= $v->service_name ?></a></li>

                            <?php endforeach; ?>
                           
                        </ul>
                    </li>
                    <li>|</li>
                <?php endforeach; ?>
                    
                  
          
                    <li class="menu-has-children <?php if($segment2=='couple-pack' || $segment2=='family-pack' || $segment2=='combo-pack') { echo 'menu-active'; } ?>"><a href="<?= URL('categories#packs') ?>">GV Packs</a>
                        <ul>
                        <?php foreach($packs as $key => $value): ?>
                            <li><a href="<?= URL::to('packs/'.$value->alias) ?>"><?= $value->pack_name ?></a></li>
                        <?php endforeach; ?>
                           
                        </ul>
                    </li>
                    <?php if(count($events)!=0): ?>
                     <li>|</li>

                    <li class="menu-has-children"><a href="<?= URL('#') ?>">Events</a>
                        <ul>
                        <?php foreach($events as $key => $value): ?>
                            <li><a href="<?= URL::to('events/'.$value->event_alias) ?>"><?= $value->event_name ?></a></li>
                        <?php endforeach; ?>
                           
                        </ul>
                    </li>
                  <?php endif; ?>
                     <li>|</li>
                     <?php if(count($gvtower) !=0): ?>
                      <li class="<?php if($segment2=='commercial') { echo 'menu-active'; } ?>"><a href="<?= URL('commercial') ?>">GV Tower</a></li> 
                        <li>|</li>
                  <?php endif; ?>
                  
                    <li class="menu-has-children <?php if($segment=='food-court' || $segment=='fine-dining' || $segment=='cafe-bakeries') { echo 'menu-active'; } ?>"><a href="<?php echo e(URL::to('food-court')); ?>">Food</a>
                     <ul>
                       
                      <li><a href="<?= URL::to('food-court') ?>">Food Court
</a></li>
                       <li><a href="<?= URL::to('fine-dining') ?>">Fine Dining

</a></li>  
                        <li><a href="<?= URL::to('cafe-bakeries') ?>">Cafe & Bakeries

</a></li>      
                     </ul>
                      </li>

                       <li>|</li>
                    <li><a href="<?php echo e(URL::to('shopping')); ?>" class="active">Shopping</a></li>
                     
                    <li>|</li>
                    <li><a href="<?php echo e(URL::to('contact')); ?>" class="active">Contact Us</a></li>
                    <li>|</li>
                    <?php if(Auth::check()): ?>
                        <li class="menu-has-children"><a href="<?php echo e(URL::to('profile')); ?>"><img src="<?php echo e(asset('public/images/Login-Profile.png')); ?>"> <?= Auth::user()->name ?> </a>

                        <ul>
                            
                            
                            <li><a href="<?php echo e(URL::to('profile')); ?>">My Profile</a></li>
                         <li><a href="<?php echo e(URL::to('wallet')); ?>">GV Pay (<i class="fa fa-rupee"></i><?= Crypt::decrypt(Auth::user()->wall_am) ?>)</a></li>
                         <li><a href="<?php echo e(URL::to('wallet/recharge')); ?>">Recharge GV Pay</a></li>
                        <?php if(Auth::user()->type=="user"): ?>
                           <li><a href="<?php echo e(URL::to('history/all')); ?>">Order History</a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo e(URL::to('logout')); ?>" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a></li>

                            
                        </ul></li>
                   <form id="logout-form" action="<?php echo e(URL::to('logout')); ?>" method="POST" style="display: none;">
                                    <?php echo csrf_field(); ?>
                                </form> 
                   <?php else: ?>
                     <li><a href="<?php echo e(URL::to('login')); ?>"><img src="<?php echo e(asset('public/images/Login-Profile.png')); ?>"> Login</a></li>
                    <?php endif; ?>
                    
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </header>
      <div class="topnav" id="myTopnav" style="z-index: 999;">
  <a href="<?= URL::to('/') ?>" class="active">Home</a>
  <?php foreach($categories as $key => $value): ?>
 <div class="dropdown">
  <?php 
                          list($a,$b) = explode('_', $key);  
                         
                          ?>
    <button class="dropbtn"><?= $a ?> 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
         <?php foreach($value as $k => $v): ?>
      <a href="<?= URL::to('booking/'.$v->alias."#bookingform") ?>"><?= $v->service_name ?></a>
 
      <?php endforeach; ?>
    </div>
  </div> 
  <?php endforeach; ?>
  <div class="dropdown">
    <button class="dropbtn">GV Packs
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
         <?php foreach($packs as $k => $v): ?>
      <a href="<?= URL::to('packs/'.$v->alias."#bookingform") ?>"><?= $v->pack_name ?></a>
 
      <?php endforeach; ?>
    </div>
  </div>
     <a href="<?= URL::to('/commercial') ?>">Commercial Tower</a>
        <a href="<?= URL::to('/cinepolis') ?>">Cinepolis</a>
  <div class="dropdown"> 
      <button class="dropbtn">Events
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">        
     <?php foreach($events as $k => $v): ?>
      <a href="<?= URL::to('events/'.$v->event_alias."#bookingform") ?>"><?= $v->event_name ?></a>
 
      <?php endforeach; ?>
    </div>
  </div> 

  <div class="dropdown"> 
      <button class="dropbtn">Food
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">        
      <a href="<?= URL::to('food-court') ?>">Food Court</a>
      <a href="<?= URL::to('fine-dining') ?>">Fine Dining</a>
      <a href="<?= URL::to('cafe-bakeries') ?>">Cafe & Bakeries</a>
    </div>
  </div> 
   <a href="<?= URL::to('/shopping') ?>">Shopping</a>
  
   <a href="<?= URL::to('/careers') ?>">Careers</a>
  <a href="<?= URL::to('/contact') ?>">Contact</a>
<?php if(Auth::check()): ?>
     <div class="dropdown">
    <button class="dropbtn"><?= Auth::user()->name ?> 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
       <a href="<?php echo e(URL::to('profile')); ?>">My Account</a>
       <a href="<?php echo e(URL::to('history/all')); ?>">Order History</a>
       <a href="<?php echo e(URL::to('logout')); ?>" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                                                       <form id="logout-form" action="<?php echo e(URL::to('logout')); ?>" method="POST" style="display: none;">
                                    <?php echo csrf_field(); ?>
                                </form> 

    </div>
  </div>
  <?php else: ?>
   <a href="<?php echo e(URL::to('login')); ?>"><img src="<?php echo e(asset('public/images/Login-Profile.png')); ?>"> Login</a>
   <?php endif; ?>
 
 <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">Menu <i class="fa fa-bars" aria-hidden="true"></i>
</a>
</div>



<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/front/menu.css')); ?>">
<?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/include/menu.blade.php ENDPATH**/ ?>