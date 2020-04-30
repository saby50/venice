@extends('layouts.main2')

@section('title')
Pay Now
@endsection

@section('content')
<?php 
    $unit = Helper::get_unit_info($id);
    
?>
<div class="firstbox">
	<div class="row">
		<div class="col-12 unit_info">
			<?php foreach($unit as $key => $value): ?>
                <strong><?= $value->unit_name ?></strong><br />
               <?= $value->unit_category_name ?>: <?= $value->floor_level ?>
			<?php endforeach; ?>
			
			
		</div>
	</div>
	
	
</div>
<div class="recyclerview">
	<form action="{{ URL::to('pay/process') }}" method="post">
		@csrf
	<div class="row">
		<div class="col-12 gv-balance input-icon">
			<input type="number" name="amount" placeholder="Enter An Amount" class="form-control amount_box" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "5" style="border-radius: 0px;">
			<i class="currency_symbol"><i class="fa fa-rupee fa-lg"></i></i>
			<input type="hidden" name="unit_id" value="<?= $id ?>">
			<input type="hidden" name="purpose" value="Payment">
		</div>
	
		<div class="col-12 gv-balance">
			<div class="row">
		<div class="col-12" style="margin-bottom: 30px;margin-top: 20px;"><strong>Pay with</strong></div>
		
		<?php foreach($payment_method as $key => $value): ?>
	
		<div class="col-<?= Helper::fetch_col($payment_method) ?>">
			<?php if($key==0): ?>

             
			
				<input type="radio" name="payment_method" value="<?= $value->gateway_name ?>" checked="checked" class="gateway"> <img src="<?= asset('public/images/'.$value->gateway_name.'.jpg') ?>" class="payment_method2">
				<?php else: ?>

				<input type="radio" name="payment_method" value="<?= $value->gateway_name ?>" class="gateway"> <img src="<?= asset('public/images/'.$value->gateway_name.'.jpg') ?>" class="payment_method2">	
		   
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
		<div class="col-12" style="margin-top: 60px;">
			<span class="balance-notify"></span>
			<button type="submit" class="btn checkoutbtn proceed" style="margin-top: 10px;">PAY NOW</button>
			
		</div>
	</div></div>
	</div>
	</form>
</div>
<!-- The Modal -->
<div id="myModal3" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="">
      <span class="close">&times;</span>
      
    </div>
    <div class="modal-body">
      <p class="balance-error">You have insufficient balance to pay, please recharge it from counter!<br />
     <button type="button" class="btn checkoutbtn " style="margin-top: 10px;display: none;">Recharge Now</button></p>
      
    </div>
    <div style="margin-top: 30px;">
      <h3>Modal Footer</h3>
    </div>
  </div>

</div>
<!-- The Modal -->
<div id="myModal2" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="">
      <span class="close">&times;</span>
      
    </div>
    <div class="modal-body">
      <p class="balance-error">You have insufficient balance to pay!<br />
     <button type="button" class="btn checkoutbtn recharge" style="margin-top: 10px;">Recharge Now</button></p>
      
    </div>
    <div style="margin-top: 30px;">
      <h3>Modal Footer</h3>
    </div>
  </div>

</div>
<!-- The Modal -->
<div id="myModal4" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="">
      <span class="close">&times;</span>
      
    </div>
    <div class="modal-body">
    	<input type="hidden" name="user_id" value="<?= Auth::user()->id ?>">
      <p class="balance-error">You have an active Refund Request: <?= Helper::get_user_orderid() ?> in the system. Either cancel this request or get it processed from the counter before carrying out the payment.?<br /><br />
     <button type="submit" class="btn cancelbtn" data="<?= Crypt::encrypt(Helper::get_user_orderid()) ?>" data-phone="<?= Auth::user()->phone ?>" data-status="reject">CANCEL REFUND</button></p>
      
    </div>
    <div style="margin-top: 30px;">
      <h3>Modal Footer</h3>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.gv-box').click(function() {
          var data = $(this).attr('data');
          window.location = data;
		});
		 var type = $(".gateway:checked").val();
           if (type=="gv_pocket") {
           	  var balance = "<?= Crypt::decrypt(Auth::user()->wall_am) ?>";
              $(".balance-notify").html('YOUR GV PAY BALANCE: <strong><i class="fa fa-rupee"></i> '+balance+'</strong>');
           }else {
           	var balance = "<?= Crypt::decrypt(Auth::user()->food_card) ?>";
              $(".balance-notify").html('YOUR FOOD CARD BALANCE: <strong><i class="fa fa-rupee"></i> '+balance+'</strong>');

           }
		$('.gateway').on('change', function() {
           var data = $(this).val();
           if (data=="gv_pocket") {
           	  var balance = "<?= Crypt::decrypt(Auth::user()->wall_am) ?>";
              $(".balance-notify").html('YOUR GV PAY BALANCE: <strong><i class="fa fa-rupee"></i> '+balance+'</strong>');
           }else {
           	var balance = "<?= Crypt::decrypt(Auth::user()->food_card) ?>";
              $(".balance-notify").html('YOUR FOOD CARD BALANCE: <strong><i class="fa fa-rupee"></i> '+balance+'</strong>');

           }
		});
		$(".amount_box").keyup(function() {
           var length = $(this).val().length;
           if (length!=0) {
           	 $(".currency_symbol").css('display','block');
           }else {
           	$(".currency_symbol").css('display','none');
           }
		});
		$(".proceed").click(function() {
			
			var amount = $(".amount_box").val();
			var gateway = $(".gateway:checked").val();
			
			if(gateway=="gv_pocket") {
				var current_balance = "<?= Crypt::decrypt(Auth::user()->wall_am) ?>";
			 if (parseInt(current_balance) < parseInt(amount)) {
				$("#myModal2").modal('show');
			 }else if (amount=="" || amount==0) {
				alert("Please enter some amount");
			 }else {
				return true;
			 }		
			}else if(gateway=="food_card") {
				var status = "<?= Helper::check_user_refund_status() ?>";
			 	var current_balance = "<?= Crypt::decrypt(Auth::user()->food_card) ?>";
			if (status=="1") {
               $("#myModal4").modal("show");
			}else {
				if (parseInt(current_balance) < parseInt(amount)) {
				$("#myModal3").modal('show');
			 }else if (amount=="" || amount==0) {
				alert("Please enter some amount");
			 }else {
				return true;
			 }		
			}
			 

			}else {
				//return true;
				alert(gateway);
			}
			
			
           return false;
		});
		$(".recharge").click(function() {
           window.location = "<?= URL::to('wallet/recharge') ?>";
		});
		$(".recharge_food_card").click(function() {
           window.location = "<?= URL::to('food_card/recharge') ?>";
		});

		$(".cancelbtn").click(function() {
			var data = $(this).attr("data");
			var status = $(this).attr("data-status");
			var phone = $(this).attr("data-phone");

			var url = "<?= URL::to('cancelrequest') ?>/"+phone+"/"+data+"/"+status;

			$.get(url, function(data) {
				if (data=="success") {
					window.location = "<?= URL::to('food_card/reject') ?>";
				}
				return false;

			});

           
		});

	});
	 
</script>
<style type="text/css">
	.modal-backdrop.show {
    opacity: 0;
    display: none;
}
.cancelbtn {
	    background-color: #EF9E11;
    width: 100%;
    color: #FFF !important;
    font-size: 16px !important;
    padding: 10px;
    color: #fff !important;
    border-radius: 5px;
}
.input-icon {
  position: relative;
}

.input-icon > i {
  position: absolute;
  display: block;
  transform: translate(0, -50%);
  top: 50%;
  pointer-events: none;
  width: 60%;
  display: none;
  text-align: center;
  font-style: normal;
}

.input-icon > input {
  padding-left: 25px;
  padding-right: 0;
}

.input-icon-right > i {
  right: 0;
}

.input-icon-right > input {
  padding-left: 0;
  padding-right: 25px;
  text-align: right;
}
</style>
@endsection