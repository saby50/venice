 


<?php $__env->startSection('title'); ?>
Services
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
					<span class="bar2"><a href="<?php echo e(URL::to('admin/units/create')); ?>"><button class="btn btn-primary">Create</button></a></span>
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

								<div class="col-md-3 box_area">
									<div class="col-md-3" style="text-align:center;">
										<div style="margin-top: -10px;"><?= QrCode::size(100)->generate($value->id); ?></div><br /><br />

										<div style="margin-top: -30px;"><a href="<?= URL::to('admin/units/edit/'.$value->id.'') ?>"  class="edit" title="Edit Unit"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;
											<a href="<?= URL::to('admin/qrcode/'.$value->id) ?>" target="_blank" style="color:#EF9E11;" title="Download QR Code"><i class="fa fa-download fa-lg" aria-hidden="true"></i></a><br />
<!--<a href="#" data="<?= URL::to('admin/units/delete/'.$value->id.'') ?>" class="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a> --></div> &nbsp;
	</div>
	<div class="col-md-9">
	<strong><?= $value->unit_name ?></strong><br />
	<b>Category:</b> <?php $unit_cat = Helper::get_category($value->unit_category_id); echo $unit_cat['unit_category']; ?><br />
	<b>Floor Level:</b> <?= $value->floor_level ?><br />
    
    <?php if($value->order_food=="yes"): ?>
    <a href="<?= URL::to('admin/addmenu/'.$value->id) ?>" target="_blank" style="color: red;">Manager Menu</a><br />
	<?php endif; ?>
   
   </div>
	</div>
	<?php endforeach; ?>
	<?php else: ?>
	No Shops Found
	<?php endif; ?>
	
	</div>
	</div>
	</div>
	</div>
	</div>
</div><!-- Panel Content -->
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/units/index.blade.php ENDPATH**/ ?>