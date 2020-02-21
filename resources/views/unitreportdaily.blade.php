<!DOCTYPE html>
<html>
<head>
	<title>Daily Report</title>
</head>
<body>
	<table style="width: 400px;margin: 0 auto;padding: 10px; height: 100%;border: solid 10px #fafbfb;">
		<tr>
			<td align="left" style="padding: 0px;"><img src="https://veniceindia.com/public/images/logo.png" style="width: 120px;"></td>
			<td align="right" style="padding: 0px;"></td>
		</tr>
		<tr>
			<td colspan="2"><h3 style="font-size: 1.5em;">Settlement Received</h3>
	        <h2>₹ <?= (float) $net_amount ?></h2>
	        <p><?= ucfirst(Helper::getIndianCurrency((float) $net_amount)) ?></p>
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
	 		<td><strong>Payment Received</strong><br /><span class="subtext">Number of payments: <?= $number_transactions ?></span></td>
	 		<td style="text-align: right;">₹ <?= (float) $amount ?></td>
	 	</tr>
	 	<tr style="padding-top: 20px;">
	 		<td><br /><br /><strong>Refunds Proccessed</strong><br /><span class="subtext">Number of payments: <?= $refund_count ?></span></td>
	 		<td style="text-align: right;">- ₹ <?= (float) $refund ?></td>
	 	</tr>
	 	<tr>
	 		<td colspan="2"><div style="width: 100%;border-top: solid 1px #f4f4f4;height: 10px;margin-top: 10px;"></div></td>
	 	</tr>
	 	<tr style="padding-top: 20px;border-top: solid 1px #999">
	 		<td><strong>Net Amount</strong></td>
	 		<td style="text-align: right;"><br /><strong>₹ <?= (float) $net_amount ?></strong></td>
	 	</tr>

	 </table>
</td>
		</tr>
		<tr>
	 		<td colspan="2"><div style="width: 100%;border-top: solid 1px #f4f4f4;height: 10px;margin-top: 10px;"></div></td>
	 	</tr>
		<tr>
			<td colspan="2">
				<strong style="color: #002977;">Track Payments & Settlements on the go!</strong><br /><br />
				<strong>Download GV Units App</strong><br /><br />
				<a href="https://play.google.com/store/apps/details?id=com.venice.gvunitmanager" target="_blank"><img src="{{ asset('images/google.png') }}" style="width: 120px;"></a>
			</td>
		</tr>
	</table>
<style type="text/css">
	body {
		margin: 0;
		font-family: arial;
		font-size: 16px;
	}
	.subtext {
		color: #999999;
		font-size: 12px;
	}
</style>	

</body>
</html>