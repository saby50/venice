<!DOCTYPE html>
<html>
<head>
	<title>Grand Venice: Ratings</title>
	<?php echo $__env->yieldContent('includes'); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicons -->
    <link href="<?php echo e(asset('public/images/favicon.png')); ?>" rel="icon">
    <link href="<?php echo e(asset('public/images/apple-touch-icon.png')); ?>" rel="apple-touch-icon">
	 <!-- Bootstrap CSS File -->
    <link href="<?php echo e(asset('public/lib/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
     <link href="<?php echo e(asset('public/lib/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet">
     <script src="<?php echo e(asset('public/js/jquery-2.1.3.js')); ?>"></script>
</head>
<body>
	<div class="container">
		<div class="col-md-12" style="text-align: center;margin-top: 20px;">
			<a href="https://veniceindia.com"><img src="<?php echo e(URL::to('public/images/logo.png')); ?>" width="200px"></a>
			
		</div>
		
			
			<?php echo $__env->yieldContent('content'); ?>
			
	
		
	</div>

</body>
</html><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/layouts/feedback.blade.php ENDPATH**/ ?>