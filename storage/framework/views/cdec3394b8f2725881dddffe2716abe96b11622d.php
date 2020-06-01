<?php $__env->startSection('title'); ?>
e-Pass
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="recyclerview firstbox">
	<div class="row">
		<h4 style="text-align: center;width: 100%;">Scan e-Pass</h4>
		<div class="qrcode"><?= QrCode::size(300)->generate(Auth::user()->id); ?>
			<center><strong>Name:</strong> <?= Auth::user()->name ?><br /> <strong>Phone:</strong> <?= Auth::user()->phone ?></center>
		</div>
		
	</div>
	
</div>
<style type="text/css">
	.qrcode {
		margin: 0 auto;
		margin-top: -20px;
	}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/epass/index.blade.php ENDPATH**/ ?>