 


<?php $__env->startSection('title'); ?>
Recieve Payment
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(URL::to('admin/recieve_payment')); ?>" method="post">
	<?php echo csrf_field(); ?>
<div class="main-content style2"> 

<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Shops</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Unit(s)</h2>

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
	<div class="row">
	<?php if(session('status')): ?>
				<div class="widget no-color">
						<div class="alert alert-success">
								<div class="notify-content">
									 <?php echo e(session('status')); ?>!

								</div>
						</div>
						</div>
				</div>
			<?php endif; ?>
				<?php if(session('error')): ?>
				<div class="widget no-color">
						<div class="alert alert-danger">
								<div class="notify-content">
									 <?php echo e(session('error')); ?>!

								</div>
						</div>
						</div>
				</div>
			<?php endif; ?>
			</div>
	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">

					<div class="row">
						<div class="col-md-6">
							<p>Please enter the customer details:</p>
							
						
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" value="" class="form-control" required="required">
							<?php 
                               $unit_id = Helper::get_unit_manager_id(Auth::user()->email);
							?>
							<input type="hidden" name="unit_id" value="<?= $unit_id ?>">
						</div>
						<div class="form-group">
							<label>Amount</label>
							<input type="text" name="amount" value="" class="form-control" required="required">
							
						</div>
						<div class="form-group">
							<input type="submit" name="submit" value="Submit" class="btn btn-primary">
							
						</div>

			</div>
	</div>
	</div>
	</div>
	</div>
	</div>
</div><!-- Panel Content -->
</div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/recieve.blade.php ENDPATH**/ ?>