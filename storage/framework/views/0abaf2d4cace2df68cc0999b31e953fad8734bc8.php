<?php $__env->startSection('title'); ?>
My Profile
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

 <section id="hero_login">
        <div class="hero-container">
            <div class="row" style="width: 100%;">
                <div class="col-md-2 col-12"></div>
                <div class="col-md-8 col-12 my-profile">
                    <div class="head row">
                        <div class="col-md-6" style="padding: 10px;padding-left: 40px;padding-top: 20px;">
                            <h3>My Profile</h3>
                        </div>
                        <div class="col-md-6" style="display: none;">
                            <a href="my-profile.html" class="btn btn_active pull-right">My Profile</a>
                            <a href="order-history.html" class="pull-right" style="padding-right: 10px; padding-top: 12px;">Order History</a>
                        </div>
                    </div>
                    <hr />
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item active" id="tab01">
                            <a class="nav-link active" id="" href="<?= URL::to('profile') ?>">Personal Details</a>
                        </li>
                        <li class="nav-item" id="tab02">
                            <a class="nav-link" id="" href="<?= URL::to('profile/pin') ?>">Change PIN</a>
                        </li>
                         <li class="nav-item" id="tab02">
                            <a class="nav-link" id="" href="<?= URL::to('history/all') ?>">Order History</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane container active" id="tab11">
                            <form class="mt-5 profilemar" method="post" action="<?php echo e(URL::to('profile/update')); ?>">
                                <?php echo csrf_field(); ?>
                            <?php if(session('error')): ?>
                            <div class="alert alert-danger" role="alert">
                            <?php echo e(session('error')); ?>

                           </div>
                          
                           <?php endif; ?>
                            <?php if(session('status')): ?>
                           <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                           </div>
                           <?php endif; ?>
                                <div class="form-group">
                                   
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo e(Auth::user()->name); ?>" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo e(Auth::user()->phone); ?>" placeholder="Phone" readonly="readonly">
                                </div>
                                
                                <div class="form-group">
                                    
                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo e(Auth::user()->email); ?>" placeholder="Email">
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">UPDATE</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane container" id="tab22">
                            <form class="mt-5 profilemar" action="">
                                <div class="form-group">
                                    <label for="pincode-input1">Old PIN</label><br>
                                    <input type="text" id="pincode-input1">
                                </div>
                                <div class="form-group">
                                    <label for="pincode-input2">New PIN</label><br>
                                    <input type="text" id="pincode-input2">
                                </div>
                                <div class="form-group">
                                    <label for="pincode-input3">Confirm PIN</label><br>
                                    <input type="text" id="pincode-input3">
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Update PIN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-12"></div>
            </div>
        </div>
    </section><!-- #hero -->
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

    <script>
     $(document).ready(function() {
        $('#pincode-input1').pincodeInput({
            hidedigits: false,
            complete: function(value, e, errorElement) {
              

               $(".pinno").attr('value',value);


            }
        });
    });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/profile.blade.php ENDPATH**/ ?>