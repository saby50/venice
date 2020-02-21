<?php $__env->startSection('title'); ?>
Forgot PIN
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

 <section id="hero_login">
        <div class="hero-container">
            <div class="row" style="width: 100%;">
                <div class="col-md-4"></div>
                <div class="col-md-4 login-form">
                    <h3 class="text-center loginhead"><span class="underline">Forgot PIN</span></h3>
                    <p class="text-center mt-4">Please enter your register mobile number and we shall send you the updated PIN</p>
                    <form action="<?php echo e(URL::to('forgot/sendpin')); ?>" method="post">
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
                        <div class="form-group loginphone">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                        <div class="form-group text-center">
                           <button type="submit" class="btn checkoutbtn " style="width: 100%;">Send PIN</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </section><!-- #hero -->
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
#hero_login .login-form {
    padding: 3rem 9rem 3rem 9rem !important;
}
@media  only screen and  (min-width: 1300px) and (max-width: 1366px){
  #hero_login .login-form {
    padding: 10px !important;
}
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
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/forgot.blade.php ENDPATH**/ ?>