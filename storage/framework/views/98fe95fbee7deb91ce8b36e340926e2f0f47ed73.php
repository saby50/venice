 


<?php $__env->startSection('title'); ?>
Managers
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Create</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>FOC Managers</h2>

			</div>
		</div>
		<div class="col-md-8 column">
			<div class="top-bar-chart">
				<div class="quick-report">
					<div class="quick-report-infos">

					</div>

				</div>

			</div><!-- Top Bar Chart -->
		</div>
	</div>
</div><!-- Top Bar Chart -->

<div class="panel-content">
  <form action="<?php echo e(URL::to('admin/foc/add')); ?>" method="post">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
          <div class="row">
            <div class="col-md-12">
          <?php if(session('status')): ?>
                <div class="widget no-color">
                    <div class="notify orange-skin with-color">
                        <div class="notify-content">
                            <h3>Congratulation! <?php echo e(session('status')); ?></h3>

                        <a title="" class="close">x</a>
                        </div>
                    </div>
                    </div>
                </div>
              <?php endif; ?>
              </div>
					<div class="row formarea">
              <div class="col-md-6">
               <label>Name</label>
               <input type="text" class="form-control" name="name"  required>
              </div>
                 <div class="col-md-6">
                    <label>Email</label>
                      <input type="text" class="form-control" name="email"  required>
                    </div>

              <div class="col-md-6">
               <label>Phone</label>
               <input type="text" class="form-control" name="phone" value="" required>
              </div>
               
            
              <div class="col-md-12">
               <br />
                <input type="submit" class="btn btn-primary" value="Submit">

              </div>
					</div>

				</div>
			</div>
	
	</div>
</form>
</div><!-- Panel Content -->
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/foc/create.blade.php ENDPATH**/ ?>