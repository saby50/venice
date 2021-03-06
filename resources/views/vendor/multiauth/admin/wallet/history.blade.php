@extends('multiauth::layouts.main') 


@section('title')
Unit Revenue
@endsection

@section('content')
<?php 
$amount = 0;
?>
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#" title="">Topup</a></li>
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
                  
					</div>
					
				</div>

			</div><!-- Top Bar Chart -->
		</div>
	</div>
</div><!-- Top Bar Chart -->
<div class="panel-content">
	<div class="row">
	@if (session('status'))
				<div class="widget no-color">
						<div class="alert alert-success">
								<div class="notify-content">
									 {{ session('status') }}!

								</div>
						</div>
						</div>
				</div>
			@endif
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

						<div class="col-md-3">
							<label>Filter  by type</label><br />
							<select class="form-control filter2">
								<?php if($parameter2=="cash"): ?>
									<option value="instamojo">Instamojo</option>
								<option value="cash" selected="selected">Cash</option>
									<?php else: ?>
										<option value="instamojo" selected="selected">Instamojo</option>
								<option value="cash">Cash</option>
								<?php endif; ?>
								
							</select>
						</div>
						
						
					</div>

					<div class="row">


						<?php if (count($data) != 0): ?>
						
							<div class="table-responsive-lg">
							<table class="table">
								<thead>
									<tr>
										<th>Order Details</th>
										<th>Amount</th>
										<th>Cashback</th>
										<th>Total Amount</th>
										<th>Payment Method</th>
										
									
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
												
												

											  <form id="refundform_<?= $value->id ?>" method="post" action="{{ URL::to('admin/api/unit_refund_web') }}">
											  	@csrf
											  	<input type="hidden" name="amount" value="<?= $value->final_amount ?>">
											  	<input type="hidden" name="unit_id" value="<?= $value->unit_id ?>">
											  	<input type="hidden" name="order_id" value="<?= $value->order_id ?>">
											  </form>

											</td>
											<td><i class="fa fa-rupee"></i> <?= $value->mainamount ?>

                                            <?php 
                                              $amount+= $value->mainamount;
                                            ?>
										</td>
										<td><i class="fa fa-rupee"></i> <?= $value->extra ?></td>
										<td><i class="fa fa-rupee"></i> <?= $value->final_amount ?></td>
											<td><?php $p_method = $value->payment_method;
											if ($p_method=="gv_pocket") {
											 	echo "GV Pay";
											 }elseif($p_method=="instamojo") {
											 	echo "Instamojo";
											 } elseif($p_method=="cash") {
											 	echo "Cash";
											 } 
											 ?></td>
											
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
  	@media only screen and (max-width: 600px) {
 .filterarea {
  		position: relative;
  		top: -20px;
  	}
}
  </style>

  <script type="text/javascript">
  	$(document).ready(function() {
       $(".filter").change(function() {
         var data = $(this).val();
         var parameter2 = "<?= $parameter2 ?>";
         var url = "<?= URL::to('admin/recharge/') ?>/"+data+"/"+parameter2;
          window.location = url;
       });
        $(".filter2").change(function() {
         var data = $(this).val();
         var parameter2 = "<?= $parameter ?>";
         var url = "<?= URL::to('admin/recharge/') ?>/"+parameter2+"/"+data;
          window.location = url;
       });
        var amount = "<?= $amount ?>";
      $('.amount2').html(amount);
  	});
  </script>
@endsection
