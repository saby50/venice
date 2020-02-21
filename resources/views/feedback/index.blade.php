@extends('layouts.feedback')
@section('includes')
<meta name="robots" content="noindex, nofollow" />
@endsection
@section('content') 
<div class="col-md-12" style="text-align: center;margin-top: 40px;">

	
</div>
<div class="col-md-12" style="text-align: center;">
	<?php if($checkfeedbacks == 0): ?>
<form action="{{ URL::to('send/feedback') }}" method="post">
@csrf
<?php 
    $userid = "0";
    $i = 0;

    echo "<h4>Hi ".$name.", Please Rate our services:</h4><br />";

 ?>

<?php foreach($services as $key => $value): ?>
	<h5><?= $value->service_name ?></h5>
	<?php 
         $rand = rand(111,000);
		?>
	<div align="center">
		<li class="fa fa-star fa-2x s_<?= $rand ?>" data-index="0" rating="1" data2="<?= $rand ?>" style="color: #ccc;"></li>
		<li class="fa fa-star fa-2x s_<?= $rand ?>" data-index="1" rating="2" data2="<?= $rand ?>" style="color: #ccc;"></li>
		<li class="fa fa-star fa-2x s_<?= $rand ?>" data-index="2" rating="3" data2="<?= $rand ?>" style="color: #ccc;"></li>
		<li class="fa fa-star fa-2x s_<?= $rand ?>" data-index="3" rating="4" data2="<?= $rand ?>" style="color: #ccc;"></li>
		<li class="fa fa-star fa-2x s_<?= $rand ?>" data-index="4" rating="5" data2="<?= $rand ?>" style="color: #ccc;"></li>
		
		
	</div><br /><br />
	<input type="hidden" name="service_id[]" value="<?= $value->service_id ?>" class="service_id">
		<input type="hidden" name="type[]" value="service" class="type">
		<input type="hidden" class="rateIndex_<?= $rand ?>" name="rateindex" value="-1">
		<input type="hidden" class="rating_<?= $rand ?> ratingtext" name="rating[]" value="0">

		<?php 
          $userid = $value->user_id;
          $i++;
		?>
<?php endforeach; ?>
<input type="hidden" name="user_id" value="<?= $userid ?>" class="user_id">
<input type="hidden" name="order_id" value="<?= $generateid ?>">
<?php foreach($packs as $key => $value): ?>
	<h5><?= $value->pack_name ?></h5>
	<div align="center">
		<?php 
         $rand = rand(111,000);
		?>
		<li class="fa fa-star fa-2x s_<?= $rand ?>" data-index="0" rating="1" data2="<?= $rand ?>" style="color: #ccc;"></li>
		<li class="fa fa-star fa-2x s_<?= $rand ?>" data-index="1" rating="2" data2="<?= $rand ?>" style="color: #ccc;"></li>
		<li class="fa fa-star fa-2x s_<?= $rand ?>" data-index="2" rating="3" data2="<?= $rand ?>" style="color: #ccc;"></li>
		<li class="fa fa-star fa-2x s_<?= $rand ?>" data-index="3" rating="4" data2="<?= $rand ?>" style="color: #ccc;"></li>
		<li class="fa fa-star fa-2x s_<?= $rand ?>" data-index="4" rating="5" data2="<?= $rand ?>" style="color: #ccc;"></li>
		
	</div><br /><br />
	<input type="hidden" name="service_id[]" value="<?= $value->pack_id ?>" class="service_id">
		<input type="hidden" name="type[]" value="packs" class="type">
		<input type="hidden" class="rateIndex_<?= $rand ?>" name="rateindex" value="-1">
		<input type="hidden" class="rating_<?= $rand ?>" name="rating[]" value="0">
		
		<?php 
          $userid = $value->user_id;
		?>
<?php endforeach; ?>
<input type="hidden" name="user_id" value="<?= $userid ?>" class="user_id">
<textarea class="form-control" placeholder="Your Comments" name="comments"></textarea><br /><br />
<input type="submit" class="btn btn-warning submit" value="Submit Rating" style="color: #FFF;"><br /><br />
</form>
<?php else: ?>
  <img src="{{ asset('public/images/yeah.png') }}"><br /><br />Thanks for your rating
<?php endif; ?>
</div>
<script type="text/javascript">
	
	$(document).ready(function() {
		
		  $(".fa-star").on('click', function() {
		 	var random = $(this).attr('data2');
		 	$(".rateIndex_"+random).attr('value',$(this).data('index'));
		 	$(".rating_"+random).attr('value',$(this).attr('rating'));
          
		 });
        $(".fa-star").mouseover(function() {
        	var random = $(this).attr('data2');
           resetColors(random);
           var currentIndex = parseInt($(this).data('index'));  
           setStar(currentIndex,random);
        });
          $(".fa-star").mouseleave(function() {
          
          var random = $(this).attr('data2');
          resetColors(random);
           var rateIndex = $(".rateIndex_"+random).val();
          if (rateIndex != -1) {
             setStar(rateIndex,random);
          }
        });

          function resetColors(random) {
          	$('.s_'+random).css('color','#ccc');
          }
          function setStar(max,random) {
          	for(var i=0; i <= max; i++) {
           	$('.s_'+random+':eq('+i+')').css('color','#FFD700');
           	
           }
          }

          $(".submit").click(function() {
             var ratingtext = $(".ratingtext").val();
             if (ratingtext=="0") {
             	alert("Please rate our service!");
             	return false;
             }else {
             	return true;
             }
             return false;

          });

         
	});
</script>
@endsection
