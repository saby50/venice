 


<?php $__env->startSection('title'); ?>
Send Notification
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Send Notification</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Send Notification</h2>

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
	<form method="post" action="<?php echo e(URL::to('admin/send_push_unit')); ?>">
		<?php echo csrf_field(); ?>
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
			</div>
	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">

					<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								<label>Title</label>
							<input type="text" name="title" class="form-control">
							</div>
							<div class="form-group">
								<label>Message</label>
							<input type="text" name="message" class="form-control">
							</div>
							<div class="form-group">
							<input type="submit" name="submit" value="Send Push" class="btn btn-primary">
							</div>
							
						</div>
                       



					</div>
					<div class="row">
<div class="col-md-12">
	<table class="table">
		<thead>
			<tr>
				<th>Title</th>
				<th>Message</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data as $key => $value): ?>
			<tr>
				<td><?= $value->title ?></td>
				<td><?= $value->message ?></td>
				<td><a href="#" data="<?= URL::to('admin/delete_notification_unit/'.$value->id) ?>" class="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	
</div>	
</div>
				</div>

			</div>

		</div>

	</div>
	</form>

</div><!-- Panel Content -->

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/wallet/send_push_unit.blade.php ENDPATH**/ ?>