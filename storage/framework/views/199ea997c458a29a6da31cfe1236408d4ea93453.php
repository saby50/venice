<?php $__env->startSection('title'); ?>
Home
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="tabs">
      <div class="tab ">
       <a href="<?php echo e(URL::to('profile')); ?>">Update Profile</a>
      </div>
      <div class="tab tabopen">
        <a href="<?php echo e(URL::to('profile/pin')); ?>">Update PIN</a>
      </div>
      
    </div>
<div class="recyclerview" style="margin-top: 100px;padding-top: 40px;">
	  <form class="" method="post" action="<?php echo e(URL::to('profile/update')); ?>">
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
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<input type="text" name="name" class="form-control" placeholder="Name" value="<?= Auth::user()->name ?>">
				
			</div>
			<div class="form-group">
				<input type="text" name="phone" class="form-control" placeholder="Phone" value="<?= Auth::user()->phone ?>" readonly>
				
			</div>
			<div class="form-group">
				<input type="text" name="email" class="form-control" placeholder="Email" value="<?= Auth::user()->email ?>">
				
			</div>
			<div class="form-group">
				 <button type="submit" class="btn checkoutbtn"> Update</button>
				
			</div>
		</div>
		<div class="col-md-12">
			
			
		</div>
	</div>
</form>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/pinpwa.blade.php ENDPATH**/ ?>