<?php $__env->startSection('title'); ?>
Wallet
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="recyclerview" style="padding: 40px;margin-top: 40px;">
<div class="row">
		<div class="col-12 recent">
			All Transactions<br />
		</div>
		

		<?php foreach($topup as $key => $value): ?>
			<?php if($value->identifier=="topup"): ?>
			<div class="col-12 gv-history">
				<div class="row">
			<div class="col-8">
				<strong class="gv-title">Topup - <?= $value->order_id ?></strong><br /><span class="gv-subtitle">
                 <?php 
                   $extra_percent = $value->extra / $value->mainamount * 100;
                   echo $extra_percent."% extra GV Pay received";
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
                    echo $units['unit_name'].", ".$units['floor_level'];
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
             	 <?php if($value->refund=="yes"): ?>
             	<strong class="gv-price2">- <i class="fa fa-rupee"></i> <?= $value->refund_amount ?>
             </strong>
             <?php elseif($value->identifier=="refund"): ?>
             	<strong class="gv-price">+ <i class="fa fa-rupee"></i> <?= $value->final_amount ?></strong>
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
<style type="text/css">
@media  only screen and (min-width: 1024px) and (max-width: 2500px) {	
.recyclerview {
        display: block;
    width: 900px;
    margin: 0 auto;
    border: solid 1px #ccc;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}
.gv-balance {
	text-align: center;
}
.ripple {
    position: relative;
    overflow: hidden;
    transform: translate3d(0, 0, 0);
}
.orangeborder {
    border: solid 1px #EF9E11;
    background: #fdf5e8;
}
.gv-box {
    margin-top: 20px;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
    margin-right: 5px;
    margin-left: 5px;
    padding: 5px;
}	
.gv-box .col-5:nth-child(2) {
    text-align: right;
    padding-top: 5px;
    padding-bottom: 5px;
}
.orangeborder h5, .orangeborder a, .orangeborder strong, .orangeborder i {
    color: #EF9E11;
}
.gv-price {
    color: #09d653;
    text-align: right;
}
.gv-price {
    font-weight: 500;
}
.gv-history {
    padding: 10px;
    border: solid 1px #ccc;
    margin-top: 20px;
    line-height: 15px;
    font-family: arial;
}
.gv-title {
    font-weight: 500;
    color: #000;
    font-size: 13px;
}
.gv-subtitle {
    color: #a9a9a9;
    font-size: 11px;
}
.gv-added {
    color: #000;
    font-size: 12px;
}
.gvwebbal {
	margin-left: 0px !important;
}
.orangeborder .gv-box-footer {
    font-size: 11px;
    background: #FFF;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
    padding: 5px;
    border-top: solid 1px #EF9E11;
    padding-left: 10px;
}
.gv-price {
    color: #09d653;
    font-weight: 500;
    text-align: right;
}
.gv-price2 {
    color: red;
    text-align: right;
}
.gv-box span {
    font-size: 11px;
}
.gv-box .col-7:nth-child(1) {
    text-align: left;
    font-size: 13px;
    color: #000;
    padding-top: 5px;
    padding-bottom: 5px;
}
}
</style>
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/wallet/viewall.blade.php ENDPATH**/ ?>