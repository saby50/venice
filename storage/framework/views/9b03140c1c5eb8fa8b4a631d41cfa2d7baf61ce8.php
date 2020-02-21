<!DOCTYPE html>
<html>
<head>
	<title>Approve</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div style="width: 100%;margin: 0 auto;padding-top: 40px;text-align: center;">
	  <?php if($status=="success"): ?>
        <img src="<?php echo e(asset('images/yeah.png')); ?>"><br /><br />
        Order approved successfully.
        <?php elseif($status=="rejected"): ?>
         <img src="<?php echo e(asset('images/oops2.png')); ?>"><br /><br />
         
        Order rejected!
        <?php else: ?>
         <img src="<?php echo e(asset('images/oops2.png')); ?>"><br /><br />
        Opps, something went wrong, please try again later.
       <?php endif; ?>
</div>
<style type="text/css">
	body {
		font-size: 14px;
		font-family: verdana;
	}
</style>
</body>
</html><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/approve.blade.php ENDPATH**/ ?>