 
<?php $__env->startSection('title'); ?>
Slider
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php 
    $slider_name = "";
  	$position = 0;
  	$slider_link = "";
  foreach ($data as $key => $value) {
  	$slider_name = $value->slide_name;
  	$position = $value->position;
  	$slider_link = $value->slider_link;
  }
?>
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
				<h2>Slider</h2>

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
  <form action="<?php echo e(URL::to('admin/slide/update')); ?>" method="post">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
          <div class="row">
            <div class="col-md-12">
         
              </div>
					<div class="row formarea">
            <div class="col-md-6">
                <label>Slider Name</label>
                <input type="text" class="form-control" name="slider_name" value="<?= $slider_name ?>" required>
              </div>
              <div class="col-md-6">
                <label>Slider Position</label>
                <input type="hidden" name="slider_id" value="<?= $id ?>">
                <input type="text" class="form-control" name="position" value="<?= $position ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  required>
              </div>  
              <div class="col-md-6">
                <label>Slider Link</label>
                <input type="text" class="form-control" name="slider_link" value="<?= $slider_link ?>"  required>
              </div>        
              <div class="col-md-12">              
                <input type="submit" class="btn btn-primary" value="Next">
              </div>
					</div>

				</div>
			</div>
	
	</div>
</form>
</div><!-- Panel Content -->
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/home/edit.blade.php ENDPATH**/ ?>