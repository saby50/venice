   <!--==========================
  Pre Header
  ============================-->
    <div id="pre-header">
        <div class="row">
            <div class="col-sm-6 left" style="z-index: 999">
                <ul>
                    <li class="list-inline-item" style="color: #EF9E11">Follow Us:</li>
                    <li class="list-inline-item"><a href="https://www.facebook.com/GrandVenice/" target="_blank"><img src="<?php echo e(asset('public/images/Social-Icon-Facebook.png')); ?>"></a></li>
                    <li class="list-inline-item"><a href="https://twitter.com/venice_grand/" target="_blank"><img src="<?php echo e(asset('public/images/Social-Icon-Twitter.png')); ?>"></a></li>
                    <li class="list-inline-item"><a href="https://www.instagram.com/grandvenicemall/" target="_blank"><img src="<?php echo e(asset('public/images/Social-Icon-Instagram.png')); ?>"></a></li>
                    <li class="list-inline-item"><a href="https://www.youtube.com/channel/UCnigkZG9wbheaIW36_AuP3Q" target="_blank"><img src="<?php echo e(asset('public/images/Social-Icon-Youtube.png')); ?>"></a></li>
                 
                </ul>
            </div>
            <div class="col-sm-6 right">
                <ul>
                    <li class="list-inline-item" style="color: #fff;font-size: 13px;"><img src="<?php echo e(asset('public/images/Mail-Icon.png')); ?>"> info@veniceindia.com</li>
                    <li class="list-inline-item" style="color: #EF9E11">|</li>
                    <li class="list-inline-item" style="color: #fff;font-size: 13px;"><img src="<?php echo e(asset('public/images/Phone-Icon.png')); ?>"> <a href="tel:8860666666" class="calltag">8860 666 666</a></li>

                    <li class="list-inline-item" style="color: #EF9E11">|</li>
                    <li class="list-inline-item" style="color: #fff;font-size: 13px;">
                    <?php
                     if(Session::has('cart')) {
                        if (count(Session::get('cart'))==0) {
                         echo '<a href="#"><i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:20px;color: #EF9E11;"></i> <span class="badge badge-warning" id="lblCartCount">0</span> </a>';
                     }else {
                        echo '<a href="'.URL::to("cart").'"><i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:20px;color: #EF9E11;"></i> <span class="badge badge-warning" id="lblCartCount">'.count(Session::get('cart')).'</span> </a>';
                     } 
                 }else {
                    echo '<a href="#"><i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:20px;color: #EF9E11;"></i> <span class="badge badge-warning" id="lblCartCount">0</span> </a>';
                 } 
                      


                      ?>
                  </li>
                </ul>
            </div>
        </div>
    </div>

    
    <!--==========================
  Header
  ============================-->
    <?php echo $__env->make('include.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- #header -->
    <!--==========================
    Hero Section
  ============================--><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/layouts/header.blade.php ENDPATH**/ ?>