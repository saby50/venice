<?php $__env->startSection('title'); ?>
Notifications
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<br /><br />
<div class="col-12" style="padding: 0px;">
		<div class="recyclerview">
			<div class="row">

			<div class="col-12">
				
				
			</div>
          	</div>
			<?php $i=0; foreach($data as $key => $value): ?>
				
				<div class="featured-pwa ripple">
					
				
				
					<div class="row">
					<div class="col-8">
						 <span class="" style="font-size: 12px;color: #000000;font-weight: 500"><?= $value->title ?></span><br />
					</div>
					<div class="col-4" style="text-align: right;">
						 <span class="date"><?= date('d M, Y', strtotime($value->created_at)) ?></span><br />
					</div>
					<div class="col-12">
						 <span class="desc"><?= $value->message ?></span><br />
					</div>
					 
					  
				</div>
				</div>
				
			
				<?php if($i == count($data) - 1): ?>
				<?php else: ?>
					<hr />
				<?php endif; ?>
				

				<?php 
                   $i++;
				?>

			<?php endforeach; ?>
		</div>
</div>
</div>
<style type="text/css">
	.headpwa {
		display: none;
	}
	.footerpwa {
		display: none;
	}
	.recyclerview {
 
    margin-top: -50px;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/notificationsunits.blade.php ENDPATH**/ ?>