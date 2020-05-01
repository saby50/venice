@extends('multiauth::layouts.main') 


@section('title')
Food Card Revenue
@endsection

@section('content')
<?php 
$amount = 0;
$refund_amount = 0;
$recharg_amount = 0;
$unit_revenue = 0;

foreach ($data as $key => $value) {
  if ($value->identifier=="refund") {
    $refund_amount+= $value->refund_amount;
  }else {
    $recharg_amount+= $value->final_amount;
  }
  $amount = $recharg_amount - $refund_amount;

  $unit_revenue = Helper::get_unit_revenue_food_card($parameter);
  $amount = $amount - $unit_revenue;
}
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
		<div class="col-md-8 column">
			<div class="heading-profile">
				<h2>Revenue:  <i class="fa fa-rupee"></i>  <?= $amount ?> | Recharge:  <i class="fa fa-rupee"></i>  <?= $recharg_amount ?> | Refund:  <i class="fa fa-rupee"></i>  <?= $refund_amount ?> | Spend:  <i class="fa fa-rupee"></i>  <?= $unit_revenue ?></h2>

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
						<div class="col-md-4">
							<label>Filter  by days <?= $custom  ?></label><br />
							<select class="form-control filter">
								<?php foreach($filters as $key => $value): ?>
									
           <?php if($parameter==$value->filter_value || $custom=="custom"): ?>
              <option value="<?= $value->filter_value ?>" selected><?= $value->filter_name ?></option>

              	<?php else: ?>
                <option value="<?= $value->filter_value ?>"><?= $value->filter_name ?></option>
            <?php endif; ?>

										
            
								<?php endforeach; ?>
							</select>
           <?php if($parameter=="custom" || $custom=="custom"): ?>
           	<?php 
           	$from = "";
           	$to = "";
              if ($custom=="custom") {
              	list($from, $to) =  explode("_", $parameter);
              }
           	?>
			<div class="choosedate">		
             <div class="col-md-6" style="margin-top: 20px;margin-bottom: 20px;">
               <input type="text" name="fromdate" placeholder="From Date" id="from" class="form-control" autocomplete="off" value="<?= $from ?>">
             </div>
                <div class="col-md-6" style="margin-top: 20px;margin-bottom: 20px;">
               <input type="text" name="todate" placeholder="To Date" id="to" class="form-control" autocomplete="off" value="<?= $to ?>">
             </div>
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
                    <th>Payment Method</th>
                    <th>Type</th>
										<th>Date</th>
										
										
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
                                             
                                                 
                                                 echo "<br />";
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

                                            <?php if($value->identifier=="refund"): ?>
                                             <span style="color: red;"> -<i class="fa fa-rupee"></i> <?= $value->refund_amount ?></span>
                                            <?php 

                                                     $refund_amount+= $value->refund_amount;
                                            ?>
                                              <?php else: ?>
                                                <span style="color: green;">+<i class="fa fa-rupee"></i> <?= $value->final_amount ?></span>
                                                <?php 

                                                     $recharg_amount+= $value->final_amount;
                                            ?>
                                              <?php endif; ?>
                                              <?php 

                                                 $amount = $recharg_amount - $refund_amount;
                                              ?>
											 </td>

											
											 <td>Cash</td>
											 
											<td><?= ucfirst($value->identifier) ?></td>
											<td><?= date('d M, Y h:i A',strtotime($value->created_at)) ?></td>
											
										
											
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
  	.refund {
  		color: orange;
  	}
  	.choosedate {
  		
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
        
         var url = "<?= URL::to('admin/food_card/revenue/') ?>/"+data;
         if (data=="custom") {
           $(".choosedate").show("fast");
         }else {
         	$(".choosedate").hide("fast");
         }
        window.location = url;
         
       });
        
        var amount = "<?= $amount ?>";
      $('.amount2').html(amount);
      $(".refund").click(function() {
      	if (confirm("Are you sure want to refund the amount?")) {
      		return true;
      	}else {
      		return false;
      	}
        return false;
      });
       $("#to").on('change', function() {
      var from = $("#from").val();
      var to = $("#to").val();

      var data = from+"_"+to;

      var url = "<?= URL::to('admin/food_card/revenue/custom') ?>/"+data;

       
       window.location = url;
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
  } );
  	});
  </script>
@endsection
