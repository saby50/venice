 


<?php $__env->startSection('title'); ?>
Services
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Services</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Services(s)</h2>

			</div>
		</div>
		<div class="col-md-8 column">
			<div class="top-bar-chart">
				<div class="quick-report">
					<div class="quick-report-infos">

					</div>
					<span class="bar2"><a href="<?php echo e(URL::to('admin/services/create')); ?>"><button class="btn btn-primary">Create</button></a></span>
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

					<div class="row">

						<?php if (count($data) != 0): ?>
							<?php foreach ($data as $key => $value): ?>

								<div class="col-md-4 box_area">
									<div class="col-md-3" style="text-align:center;">
										<img src="<?php echo e(asset('images/Event_1.png')); ?>" style="margin-left: -30px;"><br /><br />

										<a href="<?= URL::to('admin/services/edit/'.$value->id.'') ?>"  class="edit"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;
<a href="#" data="<?= URL::to('admin/services/delete/'.$value->id.'') ?>" class="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a> &nbsp;
									</div>
									<div class="col-md-9">
										<strong><?= $value->service_name ?></strong><br />
								
										<?= $value->no_seats ?> Seats<br />
										<b>Category:</b> <?= $value->category_name ?><br />
										<b>Duration:</b> <?= $value->duration ?> Mins<br />
									    <b>Age:</b> <?= $value->age ?> Limit<br />
									</div>

								</div>

							<?php endforeach; ?>
							<?php else: ?>
								No Services Found
						<?php endif; ?>



					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- Panel Content -->
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/services/index.blade.php */ ?>