<!DOCTYPE html>
<html>
<head>
	<title>Daily Report</title>
</head>
<body>
	<table style="width: 400px;margin: 0 auto;padding: 10px; height: 100%;">
		<tr>
			<td align="left" style="padding: 0px;"><img src="https://veniceindia.com/public/images/logo.png" style="width: 120px;"></td>
			<td align="right" style="padding: 0px;"></td>
		</tr>
		<tr>
			<td colspan="2"><h3>Settlement Received</h3>
	        <h2>₹ <?= $net_amount ?></h2>
	        <p>Two Hundred Sixteen Rupees And Eleven Paise</p>
	        <br />
	    <span class="subtext">From</span> <br />
	     <strong>GV Pay</strong><br /><br />
	 <span class="subtext">To</span><br />
	 <strong><?= $unit_name ?></strong><br /><br />
	 <span class="subtext"><?= date('d M Y, h:i A') ?></span><br /><br />
	 <div style="width: 100%;border-top: solid 1px #f4f4f4;height: 10px;"></div>
	 <strong>Your Settlement Details</strong><br /><br />
	 <table style="width: 100%;">
	 	<tr>
	 		<td><strong>Payment Received</strong><br /><span class="subtext">Number of payments: 1</span></td>
	 		<td style="text-align: right;">₹ <?= $amount ?></td>
	 	</tr>
	 	<tr style="padding-top: 20px;">
	 		<td><br /><br /><strong>Refunds Proccessed</strong><br /><span class="subtext">Number of payments: 0</span></td>
	 		<td style="text-align: right;">- ₹ <?= $refund ?></td>
	 	</tr>
	 	<tr>
	 		<td colspan="2"><div style="width: 100%;border-top: solid 1px #f4f4f4;height: 10px;margin-top: 10px;"></div></td>
	 	</tr>
	 	<tr style="padding-top: 20px;border-top: solid 1px #999">
	 		<td><strong>Net Amount</strong></td>
	 		<td style="text-align: right;"><br />₹ <?= $net_amount ?></td>
	 	</tr>

	 </table>
</td>
		</tr>
		<tr>
	 		<td colspan="2"><div style="width: 100%;border-top: solid 1px #f4f4f4;height: 10px;margin-top: 10px;"></div></td>
	 	</tr>
		<tr>
			<td colspan="2">
				<strong>Track Payments & Settlements on the go!</strong><br /><br />
				<strong>Download Paytm Business App	</strong><br /><br />
				<a href="<?php echo e(asset('public/images/google.png')); ?>" style="width: 120px;"></a>
			</td>
		</tr>
	</table>
<style type="text/css">
	body {
		margin: 0;
		font-family: arial;
		font-size: 14px;
	}
	.subtext {
		color: #999999;
		font-size: 12px;
	}
</style>	

</body>
</html><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/unitreportdaily.blade.php ENDPATH**/ ?>