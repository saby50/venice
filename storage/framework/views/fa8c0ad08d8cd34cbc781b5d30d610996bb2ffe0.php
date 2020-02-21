<!DOCTYPE html>
<html>
<head>
	<title>Qr Code - <?php $units =  Helper::get_unit($id); echo $units['unit_name'] ?></title>
	<style type="text/css">
		.border1 {
		    border: solid 10px #d1d2d3;
          width: 390px;
          height: 390px;
          margin: 0 auto;
		}
		.border2 {
	border: solid 20px #bbbdc0;
    width: 350px;
    height: 350px;
    margin: 0 auto;
		}
	</style>
</head>
<body>
<div style="width: 100%;text-align: center;margin-top: 30px;" id="editor">
 <img src="<?php echo e(asset('images/qrtop.jpg')); ?>" width="500px"><br /><br /><br /><br />

<div class="border1"><div class="border2"><?= QrCode::size(340)->generate($id); ?></div></div>
<div class="namearea"><?php $units =  Helper::get_unit($id); echo $units['unit_name'] ?></div><br /><br />
<img src="<?php echo e(asset('images/qrbottom.png')); ?>" width="400px">
</div>
<style type="text/css">
	.namearea {
		margin: 0 auto;
		margin-top: 40px;
		font-size: 30px;
		text-transform: uppercase;
		border-bottom: dotted;
		width: 400px;

	}
	body {
		text-align: center;
		border: solid 20px #3a3985;
		height: 92vh;
		padding: 0;
		margin: 0;
	}
</style>
</body>
</html><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/qrcode.blade.php ENDPATH**/ ?>