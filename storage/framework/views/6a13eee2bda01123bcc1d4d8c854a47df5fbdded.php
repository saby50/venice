<?php $__env->startSection('title'); ?>
Login
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
 <script type="text/javascript" src="<?php echo e(asset('public/js/bootstrap-pincode-input.js')); ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/bootstrap-pincode-input.css')); ?>">
<section>
	
	<div class="recyclerview login-form firstbox">
		<div>
	    	<center><img src="<?php echo e(asset('public/images/loginartwork.jpg')); ?>" class="loginimg"></center>
          </div>	
		 <form action="<?php echo e(URL::to('clogin')); ?>" method="post">
         <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
       <h5 style="text-align: center;">Login</h5>
       <p style="text-align: center;">Please login to access your account!</p>
       <div class="form-group">
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
       </div>
       <div class="form-group">
       	<label>Phone</label>
       	<input type="number" class="form-control" name="phone" required="required" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
       	
       </div>
       <div class="form-group">
      <div class="pinarea">
                            <label for="pincode-input1">PIN</label><br>
                            <div class="pincode-input-container"><div style="display: none;"><input type="number" inputmode="numeric" id="preventautofill" autocomplete="off" class="pincode-input-text-masked"></div><input type="number" name="pin1" maxlength="1" autocomplete="off" class="form-control pincode-input-text pincode-input-text-masked first" required="required"><input type="number" maxlength="1" autocomplete="off" name="pin2" class="form-control pincode-input-text pincode-input-text-masked first" required="required"><input type="number" maxlength="1" autocomplete="off" class="form-control pincode-input-text pincode-input-text-masked first" name="pin3" required="required"><input type="number" maxlength="1" autocomplete="off" class="form-control pincode-input-text pincode-input-text-masked first" name="pin4" required="required">
                        </div>
                        <input type="hidden" name="rd" value="index">
       </div>
         <div class="form-group " style="margin-top: 20px;">
       <button type="submit" class="btn checkoutbtn"> Continue</button>
       </div>
   

	</div>
	<div class="row">
<div class="col-6">
		<a href="<?php echo e(URL::to('forgot')); ?>" class="removeItem" style="font-size: 14px;">Forgot PIN?</a>
	</div>
	<div class="col-6" style="text-align: right;">
		<a href="<?php echo e(URL::to('register')); ?>" class="removeItem" style="font-size: 14px;">Register</a>
	</div>
	</div>
	</form>
	</div>
</section>

 <script>
     $(document).ready(function() {
      $(".pincode-input-text").keyup(function () {
    if (this.value.length == this.maxLength) {
      var $next = $(this).next('.pincode-input-text');
      if ($next.length)
          $(this).next('.pincode-input-text').focus();
      else
          $(this).blur();
    }
});
    });
    </script>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/loginpwa.blade.php ENDPATH**/ ?>