<!DOCTYPE html>
<html>
<head>
	<title>Contact Request</title>
</head>
<body>
	<table style="width: 900px;">
		<tr>
			<td> <img src="<?php echo e(asset('public/images/logo.png')); ?>" style="width: 200px;"><br/>
				<br/>
				<p>You have received a new Career Request, Following are the details: </p>
				<br />
				<strong>Name: </strong> <?= $name ?><br />
			    <strong>Email: </strong> <?= $email ?><br />
			    <strong>Phone: </strong> <?= $phone ?><br />
			    <strong>Job Title: </strong> <?= $job_title ?><br />
			    <strong>CV: </strong> <?= URL::to('public/uploads/cv/'.$cv) ?><br /></td>
		</tr>
	</table>

</body>
</html><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/careersmail.blade.php ENDPATH**/ ?>