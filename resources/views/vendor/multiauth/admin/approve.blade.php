<!DOCTYPE html>
<html>
<head>
	<title>Approve</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div style="width: 100%;margin: 0 auto;padding-top: 40px;text-align: center;">
	  <?php if($status=="success"): ?>
        <img src="{{ asset('images/yeah.png') }}"><br /><br />
        Order approved successfully.
        <?php elseif($status=="rejected"): ?>
         <img src="{{ asset('images/oops2.png') }}"><br /><br />
         
        Order rejected!
        <?php else: ?>
         <img src="{{ asset('images/oops2.png') }}"><br /><br />
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
</html>