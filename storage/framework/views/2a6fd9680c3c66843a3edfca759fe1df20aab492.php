<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div style="width: 800px;">
  <p>You have received a new FOC Request bearing Order ID: <strong><?= $order_id ?></strong>, Following are the details:</p>
	<?php 
      $data = Helper::get_order_items($order_id);
      $name = "";
      	$email = "";
      	$phone = "";
      	$amount = 0;

      foreach ($data as $key => $value) {
      	$name = $value->name;
      	$email = $value->email;
      	$phone = $value->phone;
      	$amount = $value->amount;
      }
	?>

	<p>Name: <?= $name ?>
	<br />Email: <?= $email ?>
	<br />Phone: <?= $phone ?>
    <br /> Reason: <?= $foc_reason ?>
     <br /> Amount:  Rs. <?= $prevamount ?>
     <br /> Discount: <?= $percent ?>%
    <br /> <strong style="font-size: 16px;">Net Amount: Rs. <?= $amount ?></strong></p>
    <p><a href="<?= URL::to('admin/foc/approve/'.Crypt::encrypt($order_id)) ?>" target="_blank"><button style="background: #FFD700;color: #FFF;padding: 10px;border: none;border-radius: 5px;width: 120px;font-weight: bold;">Approve</button></a> &nbsp; &nbsp;&nbsp; &nbsp;<a href="<?= URL::to('admin/foc/reject/'.Crypt::encrypt($order_id)) ?>" target="_blank"><button style="background: #000;color: #FFF;padding: 10px;border: none;border-radius: 5px;width: 120px;font-weight: bold;">Reject</button></a></p>

</div>
</body>
</html><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/foc/mail.blade.php ENDPATH**/ ?>