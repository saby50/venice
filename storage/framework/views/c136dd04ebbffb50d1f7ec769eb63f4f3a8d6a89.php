<?php $__env->startSection('title'); ?>
Food Card
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="recyclerview firstbox">
	<div class="row">
		<div class="col-12 gv-balance">
			Food Card Balance<br />
			<h3 style="color: #EF9E11;"><i class="fa fa-rupee"></i> <?= Crypt::decrypt(Auth::user()->food_card) ?></h3>
		</div>
	</div>
	<div class="row gv-box orangeborder ripple" data="<?php echo e(URL::to('food_card/refund')); ?>">
		
		<div class="col-7">
			Food Card<br />
			<span>100% Usage</span> </a>


		</div>
		<div class="col-5">
			<h5><i class="fa fa-rupee"></i> <?= Crypt::decrypt(Auth::user()->food_card) ?></h5>
		</div>
		
		<div class="col-12 gv-box-footer">
            <?php if (Crypt::decrypt(Auth::user()->food_card)==0): ?>
			<strong>Low Balance, Recharge from counter</strong>
			
			<?php else: ?>
			<strong>+ Get Instant Refund</strong>
			<i class="fa fa-arrow-right" aria-hidden="true" style="float: right;"></i>
			<?php endif; ?>

			
		</div>
		
	</div>
	<div class="row gv-box skyblueborder ripple" data="<?php echo e(URL::to('wallet/promo')); ?>" style="display: none;">
		
		<div class="col-7">
			PROMOTIONAL CREDIT<br />
			<span>Restricted Usage</span> <a href="#" class="info-icon"><i class="fa fa-info" aria-hidden="true"></i></a>


		</div>
		<div class="col-5">
			<h5><i class="fa fa-rupee"></i> 0</h5>
		</div>
		
		<div class="col-12 gv-box-footer">

			<a href="#">View Expiry Summary</a>
			<i class="fa fa-arrow-right" aria-hidden="true" style="float: right;"></i>

			
		</div>
		
	</div>
</div>
<?php if(count($topup) != 0): ?>
<div class="recyclerview" style="padding: 40px;">
<div class="row">
		<div class="col-7 recent">
			Recent Transactions<br />
		</div>
		<div class="col-5 gv-balance gvwebbal" style="text-align: right;;margin-left: 10px;">
			<a href="<?php echo e(URL::to('food_card/view_all')); ?>" style="color: #078bde;">View All</a><br />
			
		</div>

		<?php foreach($topup as $key => $value): ?>
			<?php if($value->identifier=="topup"): ?>
			<div class="col-12 gv-history">
				<div class="row">
			<div class="col-8">
				<strong class="gv-title"><?= $value->order_id ?></strong><br /><span class="gv-subtitle">
                 <?php 
                   $extra_percent = $value->extra / $value->mainamount * 100;
                  echo "Topup";
                 ?>
				</span><br /><br />
				<span class="gv-added">Added on <?= date('d M, Y H:i A', strtotime($value->created_at)) ?></span><br />
				<span class="gv-expiry">Expires on <?= date('d M, Y', strtotime($value->expiry)) ?></span>
			</div>
             <div class="col-4" style="text-align: right;">
             	<strong class="gv-price">+ <i class="fa fa-rupee"></i> <?= $value->final_amount ?></strong>
			</div>
			</div>
			</div>
		
			<?php else: ?>
           <div class="col-12 gv-history">
				<div class="row">
			     <div class="col-8">
				<strong class="gv-title"> <?php 
				  if ($value->identifier=="payment") {
				  	$units = Helper::get_unit($value->unit_id);
                    echo $value->order_id;
				  }else {
				  	$services = Helper::get_service_details($value->order_id);
				  	$packs = Helper::get_pack_details($value->order_id);
                	$s = "";
                	foreach ($services as $k => $v) {
                		$s.= $v->service_name.",";
                	}
                	foreach ($packs as $k => $v) {
                		$s.= $v->pack_name.",";
                	}
                	echo $value->order_id;
                	if ($value->identifier=="refund") {
                		echo ' <span style="font-size: 12px;" class="gv-price2">(Refund)</span>';
                	}
				  }
                 
                ?></strong><br /><span class="gv-subtitle">
                	 <?php 
				  if ($value->identifier=="payment" || $value->identifier=="refund") {
				  	$units = Helper::get_unit($value->unit_id);
				  	if (count($units) == 0) {
				  		$unit_name = "";
				  		$unit_floor = "";
				  	}else {
				  		$unit_name = $units['unit_name'];
				  		$unit_floor = $units['floor_level'];
				  	}
                    echo $unit_name.", ".$unit_floor;
				  }elseif($value->identifier=="foodorder") {
				  	echo "Food Order";
				  }elseif($value->identifier=="event") {
				  	echo Helper::get_event_name($value->order_id);
				  }else {
				  	echo rtrim($s,",");
				  }
                 
                ?>
				 </span><br />
				<span class="gv-added"> <?php 
                if ($value->identifier=="payment") {
	             // echo "Paid at ".$units['unit_name'];
                }else {
                	
                }
				 ?><br /> on <?= date('d M, Y H:i A', strtotime($value->created_at)) ?></span><br />
                
				
			</div>
             <div class="col-4" style="text-align: right;">
             	 <?php if($value->identifier=="refund"): ?>
             	<strong class="gv-price2">- <i class="fa fa-rupee"></i> <?= $value->refund_amount ?></span>
             		
             </strong>
             <?php elseif($value->identifier=="payment" && $value->refund=="yes"): ?>
             <strong class="gv-price2">- <i class="fa fa-rupee"></i> <?= $value->refund_amount ?>
             </strong>
             <?php else: ?>
             	<strong class="gv-price2">- <i class="fa fa-rupee"></i> <?= $value->final_amount ?>
             </strong>
             <?php endif; ?>
			</div>
			</div>
			</div>
			<?php endif; ?>
		<?php endforeach; ?>
		
		
	</div>
</div>

<?php endif; ?>
<!-- The Modal -->
<div id="myModal3" class="modal">
<form action="<?= URL::to('food_card/refund') ?>" method="post">
	<?php echo csrf_field(); ?>
  <!-- Modal content -->
  <div class="modal-content">
    <div class="">
      <span class="close">&times;</span>
      
    </div>
    <div class="modal-body">
    	<input type="hidden" name="user_id" value="<?= Auth::user()->id ?>">
      <p class="balance-error">Are you sure you want to refund Rs. <?= Crypt::decrypt(Auth::user()->food_card) ?>?<br /><br />
     <button type="submit" class="btn checkoutbtn">Yes Refund</button><br /><br /><button type="button" class="btn checkoutbtn cancel" data-dismiss="modal">No Cancel</button></p>
      
    </div>
    <div style="margin-top: 30px;">
      <h3>Modal Footer</h3>
    </div>
  </div>
</form>
</div>
<!-- The Modal -->
<div id="myModal4" class="modal">

	<?php echo csrf_field(); ?>
  <!-- Modal content -->
  <div class="modal-content">
    <div class="">
      <span class="close">&times;</span>
      
    </div>
    <div class="modal-body">
    	<input type="hidden" name="user_id" value="<?= Auth::user()->id ?>">
      <p class="balance-error">Your request for refund is already recieved, please collect the cash from counter!<br /><br />
   </p>
      
    </div>
    <div style="margin-top: 30px;">
      <h3>Modal Footer</h3>
    </div>
  </div>

</div>
<style type="text/css">
	.cancel {
		background: #37367c !important;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$('.gv-box').click(function() {
          var data = $(this).attr('data');
          var status = "<?= Helper::check_user_refund_status() ?>";
          var food_card = "<?= Crypt::decrypt(Auth::user()->food_card) ?>";
          if (food_card != 0) {
          	if (status=="1") {
               $("#myModal4").modal("show");
          	}else {
          		$("#myModal3").modal("show");
          	}
          	
          }
          
		});
		

	});
</script>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/front/stylewallet.css')); ?>">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/food_card/index.blade.php ENDPATH**/ ?>