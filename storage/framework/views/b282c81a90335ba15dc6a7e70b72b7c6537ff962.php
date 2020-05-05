 


<?php $__env->startSection('title'); ?>
Unit Revenue
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php 
$amount = 0;
?>
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#" title="">Unit Revenue</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Total Revenue:  <i class="fa fa-rupee"></i>  <strong class="amount2"></strong></h2>

			</div>
		</div>
		<div class="col-md-8 column">
			<div class="top-bar-chart">
				<div class="quick-report">
					<div class="quick-report-infos">
                   <span class="bar2"><a href="<?= URL::to('admin/qrcode/'.$unit_id) ?>" target="_blank"><button class="btn btn-primary">View QR Code</button></a></span>
					</div>
					
				</div>

			</div><!-- Top Bar Chart -->
		</div>
	</div>
</div><!-- Top Bar Chart -->
<div class="panel-content">
	<div class="row">
	<?php if(session('status')): ?>
				<div class="widget no-color">
						<div class="alert alert-success">
								<div class="notify-content">
									 <?php echo e(session('status')); ?>!

								</div>
						</div>
						</div>
				</div>
			<?php endif; ?>
			</div>
	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
					<div class="row filterarea">
						<div class="col-md-3">
							<label>Filter  by days <?= $custom  ?></label><br />
							<select class="form-control filter">
								<?php foreach($filters as $key => $value): ?>
									<?php if($custom != ""): ?>
 <?php if($parameter==$value->filter_value): ?>
              <option value="<?= $value->filter_value ?>" selected><?= $value->filter_name ?></option>

              	<?php else: ?>
                <option value="<?= $value->filter_value ?>"><?= $value->filter_name ?></option>
            <?php endif; ?>

										<?php else: ?>
									 <?php if($parameter==$value->filter_value): ?>
              <option value="<?= $value->filter_value ?>" selected><?= $value->filter_name ?></option>

              	<?php else: ?>
                <option value="<?= $value->filter_value ?>"><?= $value->filter_name ?></option>
            <?php endif; ?>
            <?php endif; ?>
								<?php endforeach; ?>
							</select>

							<?php if($custom=="custom"): ?>
             <div class="col-md-6" style="margin-top: 20px;margin-bottom: 20px;">
               <input type="text" name="fromdate" placeholder="From Date" id="from" class="form-control" autocomplete="off">
             </div>
                <div class="col-md-6" style="margin-top: 20px;margin-bottom: 20px;">
               <input type="text" name="todate" placeholder="To Date" id="to" class="form-control" autocomplete="off">
             </div>
            <?php endif; ?>
             
						</div>
						<?php if(Auth::user()->user_type=="superadmin" || Auth::user()->user_type=="food_analyst"): ?>
								<div class="col-md-3">
							<label>Filter by Units</label><br />
							<select class="form-control filter2">
								<option value="all">All</option>
								<?php foreach($units as $key => $value): ?>
									<?php if($unit_id==$value->id): ?>
                                 <option value="<?= $value->id ?>" selected><?= $value->unit_name ?></option>
                                 <?php else: ?>
                                 	<option value="<?= $value->id ?>"><?= $value->unit_name ?></option>
                                 <?php endif; ?>

								<?php endforeach; ?>
							</select>

				
             
						</div>
					<?php endif; ?>
						
					</div>

					<div class="row">


						<?php if (count($data) != 0): ?>
						
							<div class="table-responsive-lg">
							<table class="table">
								<thead>
									<tr>
										<th>Order Details</th>
										<th>Amount</th>
										<th>Payment Method</th>
										<th>Unit Name</th>
									
									</tr>
								</thead>
								<tbody>
									<?php foreach ($data as $key => $value): ?>
										<tr scope="row">
											<td><strong><?= $value->order_id ?></strong>
												<br />
												<?php 
												$users = Helper::get_users_details($value->user_id);
												foreach ($users as $k => $v) {
													echo $v->name."<br />";
													echo $v->email."<br />";
													echo $v->phone."<br />";

												}
                                             
                                                 
                                                 echo "<strong>Date: </strong> ".date('d M, Y h:i A',strtotime($value->created_at));
                                                 echo "<br /><br />";
                                                     $platform = $value->platform;
                                                 if ($platform=="android") {
                                                 	 echo '<strong>Platform: </strong> <i class="fa fa-android fa-lg" aria-hidden="true" title="Android"></i>';
                                                 }else {
                                                 	echo '<strong>Platform: </strong> <i class="fa fa-globe fa-lg" aria-hidden="true" title="Web"></i>';
                                                 }
												?>
												<br /><br />
												<?php 
                                                if ($value->refund=="yes") {
                                                	echo "<span style='color:red;'>Refunded: Rs.".$value->refund_amount."</span>";
                                                }else {

                                                	echo "
                                                	<span class='refundbtn' data='".$value->id."' style='color:orange;'>Refund Now</span>";
                                                }
											  ?>

											  <form id="refundform_<?= $value->id ?>" method="post" action="<?php echo e(URL::to('admin/api/unit_refund_web')); ?>">
											  	<?php echo csrf_field(); ?>
											  	<input type="hidden" name="amount" value="<?= $value->final_amount ?>">
											  	<input type="hidden" name="unit_id" value="<?= $value->unit_id ?>">
											  	<input type="hidden" name="order_id" value="<?= $value->order_id ?>">
											  </form>

											</td>
											<td><i class="fa fa-rupee"></i> <?= $value->final_amount ?>
                                            <?php 
                                              $amount+= $value->final_amount;
                                            ?>
										</td>
											<td><?php $p_method = $value->payment_method;
											if ($p_method=="gv_pocket") {
											 	echo "GV Pay";
											 }elseif($p_method=="instamojo") {
											 	echo "Instamojo";
											 }elseif($p_method=="food_card") {
											 	echo "Food Card";
											 }  
											 ?></td>
											<td><?php $units = Helper::get_unit_info($value->unit_id); echo $units[0]->unit_name; ?></td>
											</td>
										</tr>
										
									<?php endforeach ?>
								</tbody>
								
							</table>
						</div>
					
							
	<?php else: ?>
	Nothing Found
	<?php endif; ?>
	</div>
	</div>
	</div>
	</div>
	</div>
</div><!-- Panel Content -->
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(".refundbtn").click(function() {
            var id = $(this).attr('data');

			if(confirm("Are you sure want to refund this transaction?")) {
				$('#refundform_'+id).submit();
			}else {

			}
          
		});
      var amount = "<?= $amount ?>";
      $('.amount2').html(amount);
         $(".filter").change(function() {
        var data = $(this).find(":selected").val();
        var data2 = $('.filter2').find(":selected").val();
        if (data2=="undefined" || data2=="") {
        	data2 = "<?= $unit_id ?>";
        }
       var url = "<?= URL::to('admin/units/revenue/') ?>/"+data+"/"+data2;
    
    window.location = url;
    });
            $(".filter2").change(function() {
        var data = $('.filter').find(":selected").val();
        var data2 = $(this).find(":selected").val();
       var url = "<?= URL::to('admin/units/revenue/') ?>/"+data+"/"+data2;
    
    window.location = url;
    });
           $("#to").on('change', function() {
      var from = $("#from").val();
      var to = $("#to").val();
   var data3 = $('.filter2').find(":selected").val();
      var data2 = from+"_"+to+"_custom";

   
     var url = "<?= URL::to('admin/units/revenue/') ?>/"+data2+"/"+data;

       
       window.location = url;
    });
	});
	$( function() {
    var dateFormat = "yy-mm-dd",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 2,
          dateFormat: 'yy-mm-dd'
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),

      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        dateFormat: 'yy-mm-dd'
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  });

</script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style type="text/css">
  	.filterarea {
  		position: relative;
  		top: -40px;
  	}
  	.refundbtn {
  		cursor: pointer;
  	}
  	@media  only screen and (max-width: 600px) {
 .filterarea {
  		position: relative;
  		top: -20px;
  	}
}
  </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/units/revenue.blade.php ENDPATH**/ ?>