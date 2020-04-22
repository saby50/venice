
<?php 
$segment = Request::segment(2);
$categories = Helper::get_all_categories();
$user_type = "";
$manager_id = 0;

if ($type=="app") {
  $manager = DB::table('admins')
    ->where('admins.user_type','manager')
    ->where('admins.email',$email)
    ->get();
  $manager_id = 0;
  foreach ($manager as $key => $value) {
    $user_type = $value->user_type;     
  }     
}else {
  $user_type = Auth::user()->user_type;
}
$food_check = Helper::get_unit_by_email_food(Auth::user()->email);

?>
 <nav id="nav">
        <ul>
        <?php if($user_type=="analyst" || $user_type=="pos" || $user_type=="leadanalyst" || $user_type=="editor"): ?>
        <li class="active"><a href="<?php echo e(URL::to('admin/home/all/all')); ?>" title=""  class="<?php if($segment=='home') { echo 'item-active'; } ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</a></li>
<?php endif; ?> 
      <?php if($user_type=="superadmin"): ?>
                <li class="active"><a href="<?php echo e(URL::to('admin/home/all/all')); ?>" title=""  class="<?php if($segment=='home') { echo 'item-active'; } ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</a></li>
      <li></li>
          <li class="menu-item-has-children"><a href="<?php echo e(URL::to('admin/settings')); ?>" title=""  class="<?php if($segment=='settings' || $segment=='maintenance' || $segment=='taxes' || $segment=='venue') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Settings</a>  <ul>
            <li><a href="<?php echo e(URL::to('admin/settings')); ?>" title=""  class="<?php if($segment=='settings') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Emails & Version</a></li>
            <li><a href="<?php echo e(URL::to('admin/venue')); ?>" title=""  class="<?php if($segment=='venue') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Venue</a></li>
                <li><a href="<?php echo e(URL::to('admin/maintenance')); ?>" title=""><i class="fa fa-bolt"></i> <span>Maintenance</a></li>
              <li><a href="<?php echo e(URL::to('admin/taxes')); ?>" title=""  class="<?php if($segment=='taxes') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Taxes</a></li>
             
              
            </ul></li>  
             
      
        <li class="menu-item-has-children"><a href="<?php echo e(URL::to('admin/categories')); ?>" title=""  class="<?php if($segment=='categories' || $segment=='services' || $segment=='packs') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Activities</a>  <ul>
                <li><a href="<?php echo e(URL::to('admin/categories')); ?>" title=""  class="<?php if($segment=='categories') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Categories</a></li>
              <li><a href="<?php echo e(URL::to('admin/services')); ?>" title=""  class="<?php if($segment=='services') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Services</a></li>
              <li><a href="<?php echo e(URL::to('admin/packs')); ?>" title=""  class="<?php if($segment=='packs') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Packs</a></li>
              
            </ul></li> 
     
    
      <li><a href="<?= URL::to('admin/rates/'.$categories[0]->id) ?>" title=""  class="<?php if($segment=='rates') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Rate</a></li>
 
      <li><a href="<?php echo e(URL::to('admin/manage_users/all')); ?>" title=""  class="<?php if($segment=='manage_users') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Roles</a></li> 

      <?php endif; ?>
       <?php if($user_type=="superadmin" || $user_type=="analyst" || $user_type=="pos" || $user_type=="manager" || $user_type=="leadanalyst" || $user_type=="editor"): ?> 
      <li><a href="<?php echo e(URL::to('admin/bookings/today')); ?>" title=""  class="<?php if($segment=='bookings') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Bookings</a></li>
         <?php endif; ?>

       <?php if($user_type=="superadmin"): ?>   
        <li class="menu-item-has-children"><a href="<?php echo e(URL::to('admin/foc')); ?>" title=""  class="<?php if($segment=='foc' || $segment=='reasons') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>FOC</a>
         <ul>
               <li><a href="<?php echo e(URL::to('admin/foc')); ?>">Managers</a></li>
              <li><a href="<?php echo e(URL::to('admin/reasons')); ?>">Reasons</a></li>
             
              
            </ul></li>
        <li class="menu-item-has-children"><a href="<?php echo e(URL::to('admin/events')); ?>"  title=""  class="<?php if($segment=='events' || $segment=='events_bookings') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Events</a>
            <ul>
               <li><a href="<?php echo e(URL::to('admin/events_bookings/all')); ?>">Bookings</a></li>
              <li><a href="<?php echo e(URL::to('admin/events')); ?>">List</a></li>
              
            </ul></li>
             
          <li class="menu-item-has-children"><a href="<?php echo e(URL::to('admin/shops')); ?>"  title=""  class="<?php if($segment=='shops' || $segment=='shop_categories'| $segment=='slides') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>CMS</a>
            <ul>
               <li><a href="<?php echo e(URL::to('admin/shop_categories')); ?>">Shop Categories</a></li>
              <li><a href="<?php echo e(URL::to('admin/shops')); ?>">Shop Listing</a></li>
               <li><a href="<?php echo e(URL::to('admin/slides')); ?>">Home Slides</a></li>
              <li><a href="<?php echo e(URL::to('admin/movies')); ?>">Movies</a></li>
              <li><a href="<?php echo e(URL::to('admin/holidays')); ?>">Holidays</a></li>
              <li><a href="<?php echo e(URL::to('admin/gondolier')); ?>">Gondolier</a></li>

            </ul></li>
        <li><a href="<?php echo e(URL::to('admin/users')); ?>" title=""  class="<?php if($segment=='users') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Users</a></li> 
 <li class="menu-item-has-children"><a href="<?php echo e(URL::to('admin/cash_bookings')); ?>" title=""  class="<?php if($segment=='cash_bookings') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>POS</a><ul>
               <li><a href="<?php echo e(URL::to('admin/cash_bookings')); ?>">Helpdesk</a></li>   
               <li><a href="<?php echo e(URL::to('admin/wallet/topup')); ?>">Wallet Topup</a></li>
               <li><a href="<?php echo e(URL::to('admin/food_card/topup')); ?>">Food Card Topup</a></li>
                <li><a href="<?php echo e(URL::to('admin/food_card/refund/todays')); ?>">Refund Queue</a>
                </li>             
            </ul></li> 


   
         <?php endif; ?>
          <?php if($user_type=="editor"): ?>
              <li class="menu-item-has-children"><a href="<?php echo e(URL::to('admin/shops')); ?>"  title=""  class="<?php if($segment=='shops' || $segment=='shop_categories'| $segment=='slides') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>CMS</a>
            <ul>
               <li><a href="<?php echo e(URL::to('admin/shop_categories')); ?>">Shop Categories</a></li>
              <li><a href="<?php echo e(URL::to('admin/shops')); ?>">Shop Listing</a></li>
               <li><a href="<?php echo e(URL::to('admin/slides')); ?>">Home Slides</a></li>
              <li><a href="<?php echo e(URL::to('admin/movies')); ?>">Movies</a></li>
              <li><a href="<?php echo e(URL::to('admin/holidays')); ?>">Holidays</a></li>
              <li><a href="<?php echo e(URL::to('admin/gondolier')); ?>">Gondolier</a></li>

            </ul></li>
            <?php endif; ?>
         <?php if($user_type=="pos"): ?>
              <li class="menu-item-has-children"><a href="<?php echo e(URL::to('admin/cash_bookings')); ?>" title=""  class="<?php if($segment=='cash_bookings') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>POS</a><ul>
               <li><a href="<?php echo e(URL::to('admin/cash_bookings')); ?>">Help Desk</a></li>   
                <li><a href="<?php echo e(URL::to('admin/wallet/topup')); ?>">Wallet Topup</a></li>      
            </ul></li> 
              <?php endif; ?> 
           <?php if($user_type=="superadmin" || $user_type=="lead_manager" || $user_type=="leadanalyst" || $user_type=="editor"): ?>
         <li><a href="<?php echo e(URL::to('admin/leads/all')); ?>" title=""  class="<?php if($segment=='leads') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> Leads</a></li> 
       <?php endif; ?>
         <?php if($user_type=="superadmin" || $user_type=="analyst" || $user_type=="pos" || $user_type=="leadanalyst" || $user_type=="editor"): ?>  
          
    
     

          <li class="menu-item-has-children"><a href="<?php echo e(URL::to('admin/reports/transaction/todays')); ?>" title=""  class="<?php if($segment=='reports' || $segment=='feedbacks' || $segment=='gondolier') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Reports</a><ul>
               <li><a href="<?php echo e(URL::to('admin/reports/transaction/todays')); ?>">Revenue</a></li>
               <li><a href="<?php echo e(URL::to('admin/feedbacks/all/all')); ?>">Feedback</a></li>
               <li><a href="<?php echo e(URL::to('admin/gondolier/reports/todays')); ?>">Gondolier</a></li>                
            </ul></li>
             
          <?php endif; ?> 

           <?php if($user_type=="food_analyst"): ?>
             <li><a href="<?php echo e(URL::to('admin/wallet/topup')); ?>"><i class="fa fa-eye"></i> Wallet Topup</a></li>   
             <li><a href="<?php echo e(URL::to('admin/units/revenue/todays/all')); ?>"><i class="fa fa-eye"></i> Units Revenue</a></li>
               <li><a href="<?php echo e(URL::to('admin/recharge/todays/cash')); ?>"><i class="fa fa-eye"></i> Recharge History</a></li>   

           <?php endif; ?>

          <?php if($user_type=="superadmin"): ?>
            <li class="menu-item-has-children"><a href="<?php echo e(URL::to('admin/units')); ?>" title=""  class="<?php if($segment=='units') { echo 'item-active'; } ?>"><i class="fa fa-bolt"></i> <span>Wallet</a><ul>
               <li><a href="<?php echo e(URL::to('admin/units')); ?>">Units</a></li>
               <li><a href="<?php echo e(URL::to('admin/units/revenue/todays/all')); ?>">Units Revenue</a></li>
               <li><a href="<?php echo e(URL::to('admin/recharge/todays/instamojo')); ?>">Recharge History</a></li>
               <li><a href="<?php echo e(URL::to('admin/unit_push')); ?>">Unit Notifications</a></li>
               <li><a href="<?php echo e(URL::to('admin/push')); ?>">User Notifications</a></li>   
                           
            </ul></li>
            <?php endif; ?> 
            <?php if($user_type=="unit_manager"): ?>

            <li><a href="<?= URL::to('admin/units/revenue/todays/'.Helper::get_unit_manager_id(Auth::user()->email)) ?>"><i class="fa fa-eye"></i> <span>Units Revenue</a></li>
             <li><a href="<?= URL::to('admin/units/recieve') ?>"><i class="fa fa-eye"></i> <span>Receive</a></li>  
              <li><a href="#" id="notificationbtn"><i class="fa fa-eye"></i> <span>Notifications</a></li> 
                <?php if(count($food_check) != 0): ?>
                  <?php 
                    $unitid = 0;
                    foreach ($food_check as $key => $value) {
                       $unitid = $value->id;
                    }
                  ?> 
                  <li><a href="<?= URL::to('admin/addmenu/'.$unitid) ?>"><i class="fa fa-eye"></i> <span>Manage Menu</a></li> 
                  <?php endif; ?> 
            <?php endif; ?> 
          <li><a href="https://veniceindia.com" title="" target="_blank"><i class="fa fa-eye"></i> <span>Visit Website</a></li> 

      <li><a href="/admin/logout" title="" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span><?php echo e(__('Logout')); ?></a>
                                                          <form id="logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST" style="display: none;">
                                    <?php echo csrf_field(); ?>
                                </form></li>
          
          
        </ul>
    </nav><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/layouts/menu.blade.php ENDPATH**/ ?>