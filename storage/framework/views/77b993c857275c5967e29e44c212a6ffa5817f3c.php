<?php $__env->startSection('title'); ?>
Wallet
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="recyclerview" style="margin-top: 70px;">
	<div class="row">
		<div class="col-12 gv-balance">
			GV Pocket Balance<br />
			<h3 style="color: #EF9E11;"><i class="fa fa-rupee"></i> <?= Crypt::decrypt(Auth::user()->wall_am) ?></h3>
		</div>
	</div>
	<div class="row gv-box orangeborder ripple" data="<?php echo e(URL::to('wallet/recharge')); ?>">
		
		<div class="col-7">
			GV COIN<br />
			<span>100% Usage</span> <a href="#" class="info-icon"><i class="fa fa-info" aria-hidden="true"></i></a>


		</div>
		<div class="col-5">
			<h5><i class="fa fa-rupee"></i> <?= Crypt::decrypt(Auth::user()->wall_am) ?></h5>
		</div>
		
		<div class="col-12 gv-box-footer">

			<strong>+ TopUp GV Pocket </strong> (Get extra 5% GV Cash)
			<i class="fa fa-arrow-right" aria-hidden="true" style="float: right;"></i>

			
		</div>
		
	</div>
	<div class="row gv-box skyblueborder ripple" data="<?php echo e(URL::to('wallet/promo')); ?>">
		
		<div class="col-7">
			PROMOTIONAL CREDIT<br />
			<span>Restricted Usage</span> <a href="#" class="info-icon"><i class="fa fa-info" aria-hidden="true"></i></a>


		</div>
		<div class="col-5">
			<h5><i class="fa fa-rupee"></i> <?= Crypt::decrypt(Auth::user()->wall_am) ?></h5>
		</div>
		
		<div class="col-12 gv-box-footer">

			<a href="#">View Expiry Summary</a>
			<i class="fa fa-arrow-right" aria-hidden="true" style="float: right;"></i>

			
		</div>
		
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.gv-box').click(function() {
          var data = $(this).attr('data');
          window.location = data;
		});

	});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/wallet/promo.blade.php ENDPATH**/ ?>