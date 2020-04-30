@extends('multiauth::layouts.main') 


@section('title')
Refund Queue
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
			@if (session('error'))
				<div class="widget no-color">
						<div class="alert alert-danger">
								<div class="notify-content">
									 {{ session('error') }}!

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

						
						
						
					</div>

					<div class="row">


						<?php if (count($data) != 0): ?>
						
							<div class="table-responsive-lg">
							<table class="table">
								<thead>
									<tr>
										<th>Order Details</th>
										<th>Amount</th>
										<th>Status</th>
										<th></th>
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
											<td>
                                              <?php if($value->status=="pending"): ?>
												Rs. <?php 
                                             $food_card = Crypt::decrypt(Helper::get_food_card($value->user_id));

											 echo $food_card; ?>
											 	

											 <?php endif; ?>
											 </td>
											<td><?= ucfirst($value->status) ?></td>
											<td><?php if($food_card!=0): ?>
												<a href="<?= URL::to('admin/food_card_refund/'.Crypt::encrypt($value->order_id)) ?>" class="refund" data="<?= Crypt::encrypt($value->order_id) ?>" data-phone="<?= $v->phone ?>" data-status="refund">Refund Now</a> &nbsp; &nbsp;<a href="<?= URL::to('admin/food_card_refund/'.Crypt::encrypt($value->order_id)) ?>" class="refund" data="<?= Crypt::encrypt($value->order_id) ?>" data-phone="<?= $v->phone ?>" data-status="reject">Reject</a>
												<?php else: ?>

												<?php endif; ?>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<form action="<?= URL::to('admin/food_card_refund') ?>" method="post">
		@csrf
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verify Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <label>Phone</label>
       <input type="text" name="phone" class="form-control phone" readonly="readonly">
       <br />
        <label>OTP</label>
       <input type="text" name="otp" class="form-control" required="required">
       <input type="hidden" name="order_id" value="" class="order_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Verify</button>
      </div>
    </div>
  </div>
  </form>
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
  	.refund {
  		color: orange;
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
        
         var url = "<?= URL::to('admin/food_card/refund/') ?>/"+data;
          window.location = url;
       });
        
        var amount = "<?= $amount ?>";
      $('.amount2').html(amount);
      $(".refund").click(function() {
      	var data = $(this).attr("data");
      	var phone = $(this).attr("data-phone");
      	var status = $(this).attr("data-status");
      	var url = "<?= URL::to('admin/food_card/sent_otp') ?>/"+phone+"/"+data+"/"+status;
      	if (status=="reject") {
      		$.get(url, function( data ) {
              
               window.location = "<?= URL::to('admin/food_card/refund/all') ?>";
           });
      	}else {
      		 $("#exampleModal").modal("show");
      	}
       
      	$(".phone").val(phone);
      	$(".order_id").val(data);
       
        return false;
      });
  	});
  </script>
@endsection
