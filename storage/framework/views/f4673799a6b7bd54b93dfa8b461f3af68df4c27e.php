 


<?php $__env->startSection('title'); ?>
Cash
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
 <?php 
       $fromtime = "";
        $totime = "";
      foreach ($venue as $key => $value) {
        $fromtime = $value->fromtime;
        $totime = $value->totime;
      }
$seconds = time();
  $rounded_seconds = ceil($seconds / (15 * 60)) * (15 * 60);
  $rounded =  date('g:i', $rounded_seconds);
 
   $currenttime = date('h', strtotime('+1 hour')).":00 ".date('A', strtotime('+1 hour')); 

   $currenttime2 = date('h').":00 ".date('A'); 

   if (strtotime($currenttime2) < strtotime($fromtime)) {
         $currenttime = $fromtime; 
         $todaydate = date('d-m-Y'); 
   }else {

    if (strtotime($currenttime) >= strtotime($fromtime) && strtotime($currenttime) <= strtotime($totime)) {
         $currenttime = $rounded." ".date('A', strtotime('+15 minutes'));
         $todaydate = date('d-m-Y');  
   }else {
         $currenttime = $fromtime; 
         $todaydate = date('d-m-Y',strtotime('+1 Day')); 
   }

   }

  
?>
<meta http-equiv="refresh" content="2; url=<?php echo e(URL::to('admin/cash_bookings')); ?>">
<div class="main-content style2"> 


<div class="heading-sec">
	<div class="row">
		<div class="col-md-12 column">
			<div class="heading-profile" style="margin-left: 5px;">
			  <h2>POS Helpdesk | Date: <?= date('l, d F Y') ?> | <?= $currenttime ?> | <?= Auth::user()->name ?></h2>
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
			</div>
	<div class="row" style="margin-top: -40px;">
		<form action="<?php echo e(URL::to('admin/booking/cash')); ?>" method="post">
			<?php echo csrf_field(); ?>
		

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">

					<div class="row">
						
						<div class="col-md-12">
							  <div class="col-md-12" style="text-align: center;padding: 40px;font-size: 14px;">
                      <?php if($status=="success"): ?>
                   <img src="<?php echo e(asset('images/yeah.png')); ?>"><br /><br />
                   Payment has been successfully done.<br />
                   Enjoy your ride.

                   <?php else: ?>
                      <img src="<?php echo e(asset('images/oops.png')); ?>"><br /><br />
                   Looks like something went wrong.<br />
                   Please try again.

                   <?php endif; ?>

                   <br />
                   <br />
                    <?php if($status=="success"): ?>
                   <a href="<?php echo e(URL::to('admin/cash_bookings')); ?>"><button type="button" class="btn checkoutbtn btn-width btn-primary">Continue</button></a>
                   <?php else: ?>
                    <a href="<?php echo e(URL::to('admin/cash_bookings')); ?>"><button type="button" class="btn checkoutbtn btn-width btn-primary">Retry</button></a>
                   <?php endif; ?>
                      
                    </div>
							
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

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/cash/status_s.blade.php ENDPATH**/ ?>