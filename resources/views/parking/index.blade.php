@extends('layouts.main2') 


@section('title')
Parking
@endsection

@section('content')
<div class="recyclerview" style="padding: 40px;margin-top: 40px;">
<div class="row">
		<div class="col-12 recent">
			<h6 style="text-align: center;">Select Your Vehicle</h6>
		</div>
		
      
		<?php foreach($data as $key => $value): ?>
			<label style="width: 100%;text-align: center;">
			<?php if($key==0): ?>
			<div class="col-md-12" style="text-align: center;margin-bottom: 30px;font-size: 13px;font-family: arial;"><input type="radio" name="parking" value="<?= $value->alias ?>" class="parkingoption" checked="checked"> <img src="<?= asset('public/uploads/icon/'.$value->icon) ?>" width="100px"><br /><br /><span style="font-weight: 500"><?= $value->service_name ?> (<?php $rates =  Helper::get_rates($value->id,date('d-m-Y'),date('g:i A'),"1","","service","0","online"); echo "Rs.".$rates[0]['final_price']."/Day"; ?>)</span></div>
			<?php else: ?>
           <div class="col-md-12" style="text-align: center;margin-bottom: 30px;font-size: 13px;font-family: arial;"><input type="radio" name="parking"  value="<?= $value->alias ?>" class="parkingoption"> <img src="<?= asset('public/uploads/icon/'.$value->icon) ?>" width="100px"><br /><br /><span style="font-weight: 500"><?= $value->service_name ?> (<?php $rates =  Helper::get_rates($value->id,date('d-m-Y'),date('g:i A'),"1","","service","0","online"); echo "Rs.".$rates[0]['final_price']."/Day"; ?>)</span></div>
			<?php endif; ?>
			</label>
		<?php endforeach; ?>
      <div class="col-md-12" style="text-align: center;margin-bottom: 20px;"><input type="text" class="form-control amount_box" name="vehicleno" placeholder="Enter vehicle no"></div>
		<div class="col-md-12" style="text-align: center;"><input type="submit" name="submit" value="Checkin" class="checkin btn"></div>
	
		
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.gv-box').click(function() {
          var data = $(this).attr('data');
          window.location = data;
		});
		$(".checkin").click(function() {
			var parking = $(".parkingoption:checked").val();
          alert(parking);
          return false;
		});

	});
</script>
<style type="text/css">
	/* HIDE RADIO */
[type=radio] { 
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

/* IMAGE STYLES */
[type=radio] + img {
  cursor: pointer;
}

/* CHECKED STYLES */
[type=radio]:checked + img {
  outline: 2px solid #f00;
}
.checkin {
	height: 80px;
	width: 80px;
	border-radius: 40px;
	font-size: 13px;
	background: #37367c;
	color: #FFF;
}.checkin:hover {
	background: #EE0000;
	color: #FFF;
}
</style>
@endsection