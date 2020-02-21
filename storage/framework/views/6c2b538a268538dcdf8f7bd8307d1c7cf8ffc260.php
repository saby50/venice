<?php $__env->startSection('title'); ?>
Payment Status
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section id="hero_login">
        <div class="hero-container">
            <div class="row" style="width: 100%;">
                <div class="col-md-2 col-12"></div>
                <div class="col-md-8 my-profile row">
                	<div class="col-12" style="padding-left: 0px;padding-right: 0px;">
                    <div class="loader"></div>
                    <div class="head row">
                        <div class="col-md-12" style="padding-top: 20px;padding-left: 40px;">
                            <h3>Your Payment</h3>
                        </div>
                        
                    </div>

                    <?php 

                       $type = "";
                    ?>

                    <?php if(session('status')): ?>
                     <?php 
                     $session = session('status');
                      $type = $session['type'];
                     

                   ?>
                  <?php endif; ?>
                   

                  <?php if(Helper::check_mobile()==1): ?>
                    <style type="text/css">
                      #hero_login .my-profile {
                           border: none;
                      }
                      #hero_login {
                        width: 100%;
                        height: auto;
                        background: none;
                     }
                     #main {
                      margin-top: 0px;
                     }
                    </style>
                    <?php else: ?>
                  <hr>
                    <?php endif; ?>
                    <div class="col-md-12" style="text-align: center;padding: 40px;font-size: 14px;">

                      <?php if($type=="wallet"): ?>

                        <img src="<?php echo e(asset('public/images/yeah.png')); ?>" width="200px"><br /><br />
                   <p>You have successfully paid through GV Pay. Following are the details:<br />
                    <strong>Amount: </strong> <?= $session['amount'] ?><br />
                   <strong>Paid To: </strong> <?= $session['unit_name'] ?><br />
                  <strong>Date: </strong> <?= date('M, d Y', strtotime($session['date'])) ?><br />
                  <strong>Order ID: </strong> <?= $session['order_id'] ?></p>


                        <?php else: ?>
                      <?php if($status=="success"): ?>
                   <img src="<?php echo e(asset('public/images/yeah.png')); ?>"><br /><br />
                   Payment has been successfully done.<br />
                   Your tasty food is being prepared!
                   <br />
                   <br />
                   <?php else: ?>
                      <img src="<?php echo e(asset('public/images/oops.png')); ?>"><br /><br />
                   Looks like something went wrong.<br />
                   Please try again.
                    <br />
                   <br />

                   <?php endif; ?>
                    <?php endif; ?>
                  
                    <?php if($status=="success"): ?>
                   <a href="<?php echo e(URL::to('/')); ?>"><button type="button" class="btn checkoutbtn btn-width">Continue</button></a>
                   <?php else: ?>
                    <a href="<?php echo e(URL::to('/cart')); ?>"><button type="button" class="btn checkoutbtn btn-width">Retry</button></a>
                   <?php endif; ?>
                      
                    </div>
                   
                </div>
           
                </div>
                </div>
                <div class="col-md-2 col-12"></div>
            </div>
        </div>
    </section>
    <!-- booking form success end -->
    <main id="main">

<div class="modal fade" id="bookingModal" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <label>Oops</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>
          <div class="modal-body">
            <div class="content"></div>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>

<style type="text/css">
#hero {
  width: 100%;
  height: 100vh;
  background: url(<?= asset('public/images/dashboard.jpg') ?>) no-repeat top center;
  background-size: contain;
  position: relative;
}
.timepicker {
        padding: .375rem .75rem !important;
}
#price {
    font-size:24px;
    font-weight: bold;
    line-height: 3 !important;
    color: #000;
    text-align: center;
}
    .loader {
    display: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8) url(<?php echo e(asset('public/images/loader2.gif')); ?>) center center no-repeat;
    z-index: 1000;
}
    .loader {
    display: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8) url(<?php echo e(asset('public/images/loader2.gif')); ?>) center center no-repeat;
    z-index: 1000;
}
.remove {
  cursor: pointer;
}
</style>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/menu/status.blade.php ENDPATH**/ ?>