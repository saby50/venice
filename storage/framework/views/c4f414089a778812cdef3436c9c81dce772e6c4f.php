 


<?php $__env->startSection('title'); ?>
Settings
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="main-content style2"> 


<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Setting(s)</h2>

			</div>
		</div>
		<div class="col-md-8 column">
			<div class="top-bar-chart">
				<div class="quick-report">
					<div class="quick-report-infos">

					</div>
					<!-- <span class="bar2"><a href="<?php echo e(URL::to('admin/venue/create')); ?>"><button class="btn btn-primary">Create</button></a></span> -->
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
			</div>
	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">

					<div class="row" style="min-height: 200px;">
						<form action="<?php echo e(URL::to('admin/addmailers')); ?>" method="post">
							<?php echo csrf_field(); ?>
						<div class="col-md-4">
							<label>Select Service</label>
							<select class="form-control" name="service">
							<option value="contact">Contact Form</option>
							
							<?php foreach($services as $key => $value): ?>
								<option value="<?= $value->alias ?>"><?= $value->service_name ?></option>
							<?php endforeach; ?>
							<?php foreach($packs as $key => $value): ?>
								<option value="<?= $value->alias ?>"><?= $value->pack_name ?></option>
							<?php endforeach; ?>
							
						</select>
						</div>
						<div class="col-md-4">
							<label>Enter Email</label>
							<input type="text" name="email" class="form-control">
							
						</div>
						<div class="col-md-4" style="padding-top: 5px;">
							<br />
							<input type="submit" name="" class="btn btn-primary" value="Submit">
							
						</div>
</form>
					



					</div>
					<div class="row">
						<?php if(count($data) != 0): ?>
							<table class="table">
								<thead>
									<tr>
										<th>Service</th>
										<th>Email</th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($data as $key => $value): ?>
										<tr>
											<td><?= $value->service ?></td>
											<td><?= $value->emails ?></td>
											<td><a href="<?= URL::to('admin/edit_mailer/'.$value->id) ?>" class="edit"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a></td>
											<td><a href="#" data="<?= URL::to('admin/delete_mailer/'.$value->id) ?>" class="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
								
							</table>
                        <?php else: ?>
                        	<h3>No Emailers Added</h3>

						<?php endif; ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
$ver = 0;
 foreach ($version as $key => $value) {
 	$ver = $value->version;
 }

?>

<div class="row">
	<form method="post" action="<?php echo e(URL::to('admin/update_version')); ?>">
		<?php echo csrf_field(); ?>
		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
					<h3>Versions</h3>
					<div class="col-md-6">
					<div class="form-group">
						<input type="text" class="form-control" name="version" value="<?= $ver ?>">

						
					</div>
					<div class="form-group">
						<input type="submit" name="submit" value="Update" class="btn btn-primary">
						
					</div>
					</div>
					
				</div>
			</div>
		</div>
		</form>
	</div>
</div><!-- Panel Content -->


	
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/settings/index.blade.php ENDPATH**/ ?>