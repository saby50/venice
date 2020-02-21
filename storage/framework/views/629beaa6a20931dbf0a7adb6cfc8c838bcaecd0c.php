<?php $__env->startSection('title'); ?>
Please wait...
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="col-md-12" style="text-align: center;padding-top: 200px;padding-bottom: 200px;">
    <h1>Please do not refresh this page...</h1>
</div>
<form method="post" action="<?php echo e($paytm_txn_url); ?>" name="f1">
    <?php echo e(csrf_field()); ?>

    <table border="1">
        <tbody>
		<?php
		foreach($paramList as $name => $value) {
			echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
		}
		?>
        <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
        </tbody>
    </table>
    <script type="text/javascript">
		document.f1.submit();
    </script>
</form>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
Book A Pitch
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/paytm/paytm-merchant-form.blade.php ENDPATH**/ ?>