<?php $__env->startSection('title'); ?>
Food Card
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="recyclerview firstbox" style="padding: 40px;">
<div class="row">
		<div class="col-12 recent">
			All Transactions<br />
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
				  if ($value->identifier=="payment") {
				  	$units = Helper::get_unit($value->unit_id);
				  	if (count($units) == 0) {
				  		$unit_name = "";
				  		$unit_floor = "";
				  	}else {
				  		$unit_name = $units['unit_name'];
				  		$unit_floor = $units['floor_level'];
				  	}
                    if (strpos($value->order_id, "ON")!==false) {
				  		echo rtrim($s,",");
				  	}else {
				  		echo $unit_name.", ".$unit_floor;
				  	}
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
<script type="text/javascript">
	$(document).ready(function() {
		$('.gv-box').click(function() {
          var data = $(this).attr('data');
          window.location = data;
		});

	});
</script>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/front/stylewallet.css')); ?>">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/food_card/viewall.blade.php ENDPATH**/ ?>