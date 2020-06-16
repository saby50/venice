<?php $__env->startSection('title'); ?>
e-Pass
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="recyclerview firstbox">

	<div class="row">
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
		<h4 style="text-align: center;width: 100%;">Scan e-Pass</h4>
		<div class="qrcode"><?= QrCode::size(300)->generate(Auth::user()->id); ?>
			<center><strong>Name:</strong> <?= Auth::user()->name ?><br /> <strong>Phone:</strong> <?= Auth::user()->phone ?></center>
		</div>
		<h4 style="margin-top: 40px;text-align: center;width: 100%;">Book Your Slot</h4>
		
		<div class="slot-box">
	       
			<form method="post" action="<?= URL::to('book_slot') ?>">
				<?php echo csrf_field(); ?>

			<label>Date</label>
			<input type="date" name="date" class="form-control">
			<label>Time</label>
			<input type="time" name="time" class="form-control"><br />
			<button type="Submit" class="btn btn-primary form-control">Submit</button>
			</form>
		</div>
		
	</div>
	
</div>
<style type="text/css">
	.qrcode {
		margin: 0 auto;
		margin-top: -20px;
	}
	.slot-box {
		width: 100%;
    padding: 20px;
	}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/epass/index.blade.php ENDPATH**/ ?>