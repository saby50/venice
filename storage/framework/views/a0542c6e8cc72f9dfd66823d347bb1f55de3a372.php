 


<?php $__env->startSection('title'); ?>
Settings
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
		$android_maintenance = "false";
		$ios_maintenance = "false";
		$message = "";
            foreach ($data as $key => $value) {
            	$platform = $value->platform;
            	if ($platform=="android") {
            		$android_maintenance = $value->maintenance;
            	}elseif ($platform=="ios") {
            		$ios_maintenance = $value->maintenance;
            	}
            	$message = $value->message;
            }
           
		 ?>
		 <form action="<?php echo e(URL::to('admin/main_update')); ?>" method="post">
	    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
<div class="main-content style2"> 


<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Maintenance</h2>

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
					<div class="col-md-6" >
								<h4>Android</h4>

								</div>
						<div class="col-md-6 sf-align-right" >
							<!-- Rounded switch -->
                        <label class="switch">
                        	<?php if($android_maintenance=="true"): ?>
                             <input type="checkbox" name="android_maintenance" class="maintenance" value="true" checked="checked">
                        	<?php else: ?>
                         <input type="checkbox" name="android_maintenance" class="maintenance" value="true">
                        	<?php endif; ?>                           
                           <span class="slider round"></span>
                         </label>                            
						</div>
							<div class="col-md-6" style="margin-top: 40px;;display: none;">
								<h4>IOS</h4>

								</div>
						<div class="col-md-6 sf-align-right" style="margin-top: 40px;display: none;">
							<!-- Rounded switch -->
                        <label class="switch">
                        	 	<?php if($ios_maintenance=="true"): ?>
                             <input type="checkbox" name="ios_maintenance" class="maintenance" value="true" checked="checked">
                        	<?php else: ?>
                         <input type="checkbox" name="ios_maintenance" class="maintenance" value="true">
                        	<?php endif; ?> 
                            
                           <span class="slider round"></span>
                         </label>                            
						</div>


							<div class="col-md-8" style="margin-top: 40px;">
								<h4>Enter Message</h4>

								</div>
						<div class="col-md-4 "  style="margin-top: 40px;">
						 <textarea name="message" class="form-control message" placeholder="Message" style="height: 80px;" required="required"><?= $message ?></textarea>                          
						</div>

						
							<div class="col-md-12" style="margin-top:20px;">
								<input type="submit" class="btn btn-primary" value="Update">
							</div>
							</div>
							<div class="col-md-6" style="margin-top:50px;">
								
							</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>

</div><!-- Panel Content -->


	
</div>
</form>
	<style type="text/css">

		/* The switch - the box around the slider */
			.display-none  {
				display: none;
			}
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

	</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/maintenance.blade.php ENDPATH**/ ?>