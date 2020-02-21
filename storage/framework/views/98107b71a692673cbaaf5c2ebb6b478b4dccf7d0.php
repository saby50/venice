<?php $__env->startSection('title'); ?>
Recharge
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="recyclerview" style="margin-top: 70px;">
	<form action="<?php echo e(URL::to('recharge/payment')); ?>" method="post">
		<?php echo csrf_field(); ?>
	<div class="row">
		<div class="col-12" style="font-size: 13px;text-align: center;">
			GV Pay Balance<br />
			<h3 style="color: #EF9E11;"><i class="fa fa-rupee"></i> <?= Crypt::decrypt(Auth::user()->wall_am) ?></h3>
		</div>
	</div>
	<div class="row d-flex justify-content-center">
		<?php if(Helper::check_mobile()=="1"): ?>
		<div class="col-12" style="font-size: 13px;text-align: center;">
		<?php else: ?>
		<div class="col-8" style="font-size: 13px;text-align: center;">
		<?php endif; ?>
			<strong>ADD MONEY</strong><br />
			<ul class="recharge-denomination">
			<?php foreach ($rechage_denomination as $key => $value): ?>
				<?php if($key==0): ?>
				<li class="selected" data="<?= $value->pricing ?>">+ <i class="fa fa-rupee"></i> <?= $value->pricing ?></li>
				<?php else: ?>
				<li data="<?= $value->pricing ?>">+ <i class="fa fa-rupee"></i> <?= $value->pricing ?></li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-12" style="text-align: center;margin-top: 20px;">
			---- Or ----
		</div>
		<div class="col-12" style="font-size: 13px;margin-top: 20px;">
			<input type="number" name="amount" placeholder="Enter An Amount" class="form-control ramount" 
    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
    type = "number"
    maxlength = "5">
		</div>
	</div>

	<div class="row">
		<div class="col-12" style="text-align: center;margin-top: 20px;">
			<span style="font-size: 11px;">You will get <span class="percent"></span>% extra on GV Pay Topup</span><br />
			<input type="hidden" name="mainam" class="mainam">
			<input type="hidden" name="extram" class="extram">
			<input type="hidden" name="payment_method" value="instamojo">
			<input type="hidden" name="purpose" value="wallet">
			<div class="pricing-display">
				<h3 style="color: #000;"><i class="fa fa-rupee"></i> <span class="finalamount"></span></h3>
			</div>
			<div class="pricing-split row">
				<div class="col-6">
					Recharge<br />
					<i class="fa fa-rupee"></i> <span class="mainamount"></span>
				</div>
				<div class="col-6">
					Cashback<br />
					<i class="fa fa-rupee"></i> <span class="extraamount"></span>
				</div>
			</div>
		</div>
		<div class="col-12" style="text-align: center;margin-top: 20px;">
           <div class="form-group">
				 <button type="submit" class="btn checkoutbtn"> Topup</button>
				
			</div>
		</div>
		
	</div>
	</form>
	
</div>
 <!-- The Modal -->
<div id="myModalError" class="modal fade">
 <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Oops</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="font-size: 14px;">A minimum recharge of INR 500 need to be done</p>
      </div>
      <div class="modal-footer">
      
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div id="snackbar" style='display:none'>A minimum recharge of INR 500 need to be done</div>
<script type="text/javascript">
	$(document).ready(function() {
		var data = $('ul.recharge-denomination li.selected').attr('data');
		var url = "<?= URL::to('api/get_denom_percent/"+data+"') ?>";
		var percent = 0;
		$.get(url, function( result ) {
            percent = result;
        $('.percent').html(percent);
		$('.ramount').attr('value', data);
		var extra = data * percent/100;
		var finalamount = parseFloat(data) + parseFloat(extra);
		 $('.finalamount').html(Math.round(finalamount));
		 $('.mainamount').html(Math.round(data));
		 $('.extraamount').html(Math.round(extra));
		 $('.mainam').attr('value',Math.round(data));
		 $('.extram').attr('value',Math.round(extra));
        });
        
      $('ul.recharge-denomination li').click(function() {
      	var data = $(this).attr('data');
        $('ul.recharge-denomination li').removeClass('selected');
        $(this).addClass('selected');
        var url = "<?= URL::to('api/get_denom_percent/"+data+"') ?>";
		var percent = 0;
		$.get(url, function( result ) {
            percent = result;
        $('.percent').html(percent);
        $('.ramount').attr('value', data);
        var extra = data * percent/100;
		var finalamount = parseFloat(data) + parseFloat(extra);
		 $('.finalamount').html(Math.round(finalamount));
		 $('.mainamount').html(Math.round(data));
		 $('.extraamount').html(Math.round(extra));
		 $('.mainam').attr('value',Math.round(data));
		 $('.extram').attr('value',Math.round(extra));
		 });
      });
       $('.ramount').keyup(function() {
       	var data = $(this).val();
        if ($(this).val()=="") {
        	var data = 0;
        }
         var url = "<?= URL::to('api/get_denom_percent/"+data+"') ?>";
         var percent = 0;
		$.get(url, function( result ) {
			percent = result;
        var extra = data * percent/100;
		var finalamount = parseFloat(data) + parseFloat(extra);
		 $('.percent').html(percent);
		 $('.finalamount').html(Math.round(finalamount));
		 $('.mainamount').html(Math.round(data));
		 $('.extraamount').html(Math.round(extra));
		 $('.mainam').attr('value',Math.round(data));
		 $('.extram').attr('value',Math.round(extra));
		  });
      });
       $(".checkoutbtn").click(function() {
           if ($('.ramount').val() < 100) {
           	 //$('#snackbar').stop().fadeIn(400).delay(3000).fadeOut(400);
         //  	 $("#snackbar").html("A minimum recharge of INR 500 need to be done");
           	 $("#myModalError").modal("show");
           	 $("#myModalError .modal-body p").html("A minimum recharge of INR 100 need to be done");
           	 return false;
           }else if ($('.ramount').val() > 10000) {
           	 $("#myModalError").modal("show");
           	 $("#myModalError .modal-body p").html("A maximum recharge limit is INR 10000");
           	 return false;
           }else {
           	return true;
           }
           return false;
       });
	});
</script>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/front/stylewallet.css')); ?>">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/wallet/recharge.blade.php ENDPATH**/ ?>