@extends('multiauth::layouts.main') 
@section('title')
Cash
@endsection
@section('content')
      <?php 
       $fromtime = "";
        $totime = "";
      foreach ($venue as $key => $value) {
        $fromtime = $value->fromtime;
        $totime = $value->totime;
      }
$seconds = time();
  $rounded_seconds = ceil($seconds / (15 * 60)) * (15 * 60);
  $rounded =  date('g:i', $rounded_seconds);
 
   $currenttime = date('h', strtotime('+1 hour')).":00 ".date('A', strtotime('+1 hour')); 

   $currenttime2 = date('h').":00 ".date('A'); 

   if (strtotime($currenttime2) < strtotime($fromtime)) {
         $currenttime = $fromtime; 
         $todaydate = date('d-m-Y'); 
   }else {

    if (strtotime($currenttime) >= strtotime($fromtime) && strtotime($currenttime) <= strtotime($totime)) {
         $currenttime = $rounded." ".date('A', strtotime('+15 minutes'));
         $todaydate = date('d-m-Y');  
   }else {
         $currenttime = $fromtime; 
         $todaydate = date('d-m-Y',strtotime('+1 Day')); 
   }

   }



  
?>

<div class="main-content style2"> 
<div class="heading-sec">
	<div class="row">
		<div class="col-md-8 column">
			<div class="heading-profile" style="margin-left: 5px;">
				<h2>POS Helpdesk | Date: <?= date('l, d F Y') ?> | <?= $currenttime ?> | <?= Auth::user()->name ?> | <span style="color: red">GC: <?= $checkgc ?> | SP: <?= $checksp ?></span></h2>

			</div>
		</div>
    <div class="col-md-4 column">
      <div class="heading-profile" style="margin-left: -10px;text-align: right;">
       
        <i class="fa fa-refresh fa-2x"></i>
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
	<div class="row" style="margin-top: -40px;">
    
		<form action="{{ URL::to('admin/booking/cash') }}" method="post" id="myform">
			@csrf
		

		<div class="col-md-12">
      <div id="loader"></div>
			<div class="widget">
				<div class="product-filter" style="padding: 50px 40px 10px;">

					<div class="row">
						
						<div class="col-md-6" style="height: 500px;overflow-y: scroll;">
							<div class="col-md-12">

								<table width="90%">
                 
									<?php 
                    $i = 1;
									?>
                  <tr style="border-bottom: solid 1px #ccc;">
                  <td style="color: red;">
                    <label>Transaction Type</label></td>
                    
                  <td style="color: red;"><input type="radio" name="transtype" class="transtype" checked="checked" value="offline"> POS(Offline) &nbsp;&nbsp;&nbsp;<input type="radio" name="transtype" class="transtype" value="online"> BMS(Online)</td>
                </tr>

							<?php foreach ($services as $key => $value): ?>
                
								
									<tr style="border-bottom: solid 1px #ccc;">
										<td><input type="checkbox" name="serviceid[]" class="serviceid" value="<?= "s_".$value->id ?>" data="<?= 's_'.$i ?>">&nbsp;&nbsp; <strong><?= $value->service_name ?></strong><br />  <br />  
                    </td>
									     <td style="text-align: center;width: 250px;padding-top: 20px;"><div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number"  disabled="disabled" data-type="minus" data-field="<?= "s_".$i ?>" data="<?= $value->id ?>">
                                        <span class="fa fa-minus"></span>
                                    </button>
                                </span>

                                <input type="text" name="quantity[]" data-quantity="<?= "s_".$i ?>" class="form-control input-number quantity" value="<?= $value->no_seats ?>" min="<?= $value->no_seats ?>" max="10" disabled="disabled"  style="background: #FFF;">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number"  disabled="disabled" data-type="plus" data-field="<?= "s_".$i ?>" data="<?= $value->id ?>">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                </span>
                            </div><br />
                              <?php if($value->alias=="gondola"): ?>
                <div class="form-group" style="text-align: left;">
                   
                    <?php 
                    $service_options = Helper::get_canal_by_serviceid($value->id);
                    ?>
                     <div class="form-check form-check-inline">
                    <?php foreach($service_options as $k => $v): ?>
                   
                  <?php if($k==0): ?>
                         <input class="form-check-input canals" type="radio" name="canals<?= $value->id ?>"  disabled="disabled" value="<?= $v->id ?>" checked>
                      <?php else: ?>
                       <input class="form-check-input canals" type="radio" name="canals<?= $value->id ?>"  disabled="disabled" value="<?= $v->id ?>"> 
                      <?php endif; ?>
                    <label class="form-check-label" for="inlineRadio1"><?= $v->option_name ?></label> &nbsp;&nbsp;
                    
                <?php endforeach; ?>
                  </div> 
                </div>
            <?php endif; ?>
									     	<span class="price_total" id="<?= "s_".$i ?>"></span>
									     	<input type="hidden" name="type[]" value="service" class="service_type" id="<?= "types_".$i ?>">
									     	<input type="hidden" name="serviceid1[]" value="<?= "s_".$value->id ?>">
									     <input type="hidden" name="amount[]" value="" id="<?= "amounts_".$i ?>" class="amounts">
									     	<input type="hidden" name="price[]" value="" id="<?= "prices_".$i ?>">
									     	<input type="hidden" name="tax[]" value="" id="<?= "taxs_".$i ?>"><br /></td>
									</tr>
								
								<?php 
                                       $i++;
									?>	
							<?php endforeach; ?>
							<?php foreach ($packs as $key => $value): ?>
								
									<tr style="border-bottom: solid 1px #ccc;">
										<td><input type="checkbox" name="serviceid[]" class="serviceid" value="<?= "p_".$value->id ?>" data="<?= 'p_'.$i ?>">&nbsp;&nbsp; <strong><?= $value->pack_name ?></strong><br />  <br />  
                     </td>
									     <td style="text-align: center;width: 200px;padding-top: 20px;"><div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="<?= "p_".$i ?>" data="<?= $value->id ?>">
                                        <span class="fa fa-minus"></span>
                                    </button>
                                </span>
                               
                               <input type="text"  name="quantity[]" data-quantity="<?= "p_".$i ?>" class="form-control input-number quantity" value="<?= $value->no_seats ?>" min="<?= $value->no_seats ?>" max="10" disabled="disabled"  style="background: #FFF;" id="<?= "q_".$value->id ?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="plus" data-field="<?= "p_".$i ?>" data="<?= $value->id ?>">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                </span>
                            </div><br />
                            
                <div class="form-group" style="text-align: left;">
                   
                    <?php 
                    $service_options = Helper::get_canal_by_serviceid('1');
                    ?>
                     <div class="form-check form-check-inline">
                    <?php foreach($service_options as $k => $v): ?>
                    
                      <?php if($k==0): ?>
                         <input class="form-check-input canals" type="radio" name="canalp<?= $value->id ?>"  disabled="disabled" value="<?= $v->id ?>" checked>
                      <?php else: ?>
                       <input class="form-check-input canals" type="radio" name="canalp<?= $value->id ?>"  disabled="disabled" value="<?= $v->id ?>"> 
                      <?php endif; ?>
                 
                    <label class="form-check-label" for="inlineRadio1"><?= $v->option_name ?></label> &nbsp;&nbsp;
                   
                <?php endforeach; ?>
                  </div>  
                </div>

                  <?php if($value->pack_type=="occasional"): ?>
                    <div class="form-group" style="text-align: left;">
                
                    <label for="time">Select Time/Cuisine</label><br />
                     <select class="form-control occasion_type" id="occationp_<?= $value->id ?>" disabled="disabled" data="<?= $value->id ?>" name="occasion_type">
                    <?php foreach($occasion_type as $key => $value): ?>                 
                    <option value="<?= $value->id ?>" data="<?= $value->timerange ?>"><?= $value->type ?> - <?= $value->cuisine ?> (Rs <?= Helper::get_occassion_rates($value->id) ?>/P)</option>                   
                    <?php endforeach; ?>
                     </select>
                 </div>
            <?php endif; ?>
            
									     	<span class="price_total datapp_<?= $value->id ?>" id="<?= "p_".$i ?>"></span>
									     	<input type="hidden" name="type[]" value="packs" class="service_type datat_<?= $value->id ?>" id="<?= "typep_".$i ?>">
									     	<input type="hidden" name="serviceid1[]" value="<?= "p_".$value->id ?>">
									     <input type="hidden" name="amount[]" value="" id="<?= "amountp_".$i ?>" class="amounts  dataaa_<?= $value->id ?>">
									     	<input type="hidden" name="price[]" value="" id="<?= "pricep_".$i ?>" class="datappp_<?= $value->id ?>">
									     	<input type="hidden" name="tax[]" value="" id="<?= "taxp_".$i ?>" class="datattp_<?= $value->id ?>"><br /></td>
									</tr>
								<?php 
                                       $i++;
									?>								
							<?php endforeach; ?>
                <?php foreach ($events as $key => $value): ?>
                
                  <tr style="border-bottom: solid 1px #ccc;">
                    <td><input type="checkbox" name="serviceid[]" class="serviceid" value="<?= "e_".$value->id ?>" data="<?= 'e_'.$i ?>" data-date="<?= $value->event_date ?>" data-time="<?= $value->start_time ?>">&nbsp;&nbsp; <strong><?= $value->event_name ?></strong><br />  <br />  
                     </td>
                       <td style="text-align: center;width: 200px;padding-top: 20px;"><div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="<?= "e_".$i ?>" data="<?= $value->id ?>">
                                        <span class="fa fa-minus"></span>
                                    </button>
                                </span>
                               
                               <input type="text"  name="quantity[]" data-quantity="<?= "e_".$i ?>" class="form-control input-number quantity" value="<?= $value->minimum_quantity ?>" min="<?= $value->minimum_quantity ?>" max="10" disabled="disabled"  style="background: #FFF;" id="<?= "c_".$value->id ?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="plus" data-field="<?= "e_".$i ?>" data="<?= $value->id ?>">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                </span>
                            </div><br />
                            
                
                </div>

                
                       
                        <span class="price_total datappe_<?= $value->id ?>" id="<?= "e_".$i ?>"></span>
                        <input type="hidden" name="type[]" value="events" class="service_type datate_<?= $value->id ?>" id="<?= "typee_".$i ?>">
                        <input type="hidden" name="serviceid1[]" value="<?= "e_".$value->id ?>">
                       <input type="hidden" name="amount[]" value="" id="<?= "amounte_".$i ?>" class="amounts  dataaae_<?= $value->id ?>">
                        <input type="hidden" name="price[]" value="" id="<?= "pricepe_".$i ?>" class="datapppe_<?= $value->id ?>">
                        <input type="hidden" name="tax[]" value="" id="<?= "taxpe_".$i ?>" class="datattpe_<?= $value->id ?>"><br /></td>
                  </tr>
                <?php 
                      $i++;
                  ?>                
              <?php endforeach; ?>
							</table>
								</div>
							
						</div>
   <div style="position: relative;float: right;display: none;"><a href="#" class="requestfullscreen" style="color: #000;" title="Fullscreen"><i class="fa fa-arrows-alt fa-2x" aria-hidden="true"></i></a>
                  <a href="#" class="exitfullscreen" style="display: none;color: #000;" title="Exit fullscreen"><i class="fa fa-times-circle fa-2x" aria-hidden="true"></i></a></div>
			<div class="col-md-6 ">
					
            <div class="col-md-6 col-md-offset-3">
              <h3>Total: <span class="grandtotal">0</span></h3>
              <input type="hidden" name="date" value="<?= date('d-m-Y') ?>">
              <input type="hidden" name="time" value="<?= $currenttime ?>">
              <input type="hidden" name="famount" class="famount" value="0">
              <input type="hidden" name="prevamount" class="prevamount" value="0">
              <input type="hidden" name="transvalue" class="transvalue" value="offline">
						<h5>Enter Details</h5>
						<hr />
						<div class="form-group">
							<label>Customer Name</label>
						<input type="text" name="name" class="form-control name" required="required">
						</div>
						<div class="form-group">
							<label>Customer Phone</label>
						<input type="text" name="phone" class="form-control phone" required="required" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            
						</div>
							 <div class="form-group">
        <div class="row payment_method_box">
          <?php foreach($payment_mode as $key => $value): ?>
          <div class="col-md-6">
            <?php if($key==0): ?>
              <input type="radio" class="payment_method" name="payment_method" value="<?= $value->mode_alias ?>" checked> <?= $value->mode_name ?>
              <?php else: ?>
                <input type="radio" class="payment_method" name="payment_method" value="<?= $value->mode_alias ?>"> <?= $value->mode_name ?>
              <?php endif; ?>
            
          </div>
        <?php endforeach; ?>

           
        </div>
        <div class="row bookmyshowid" style="margin-top: 20px;">
          <label>Enter ID: </label>
           <input type="text" name="bookmyshow" class="bookmyshow form-control" required="required" disabled="disabled">
          
        </div>
        <div class="row" style="margin-top: 20px;margin-left: 5px;">
          <div class="col-md-4">
          <input type="checkbox" name="foccheckbox" class="foc"> FOC <br /><br />
          </div> 
          <div class="col-md-4">
            <input type="text" name="percent" class="form-control percent" placeholder="%" disabled="disabled">
          </div>
          <div class="col-md-4">
           <select class="form-control authorised" name="authorised" disabled="disabled">
            <option value="">Authorised By</option>
            <?php foreach($foc as $key => $value): ?>
              <option value="<?= $value->id ?>"><?= $value->name ?></option>
            <?php endforeach; ?>
          </select>
          </div>
          <div class="col-md-12">
            <label>Reasons: </label>
           <select class="form-control authorised" name="foc_reason" disabled="disabled">
            <?php foreach($foc_reasons as $key => $value): ?>
              <option value="<?= $value->reason ?>"><?= $value->reason ?></option>
            <?php endforeach; ?>
          </select>
          </div>
          
        </div>
        </div>
       
       <div class="form-group" style="text-align: center;margin-top: 40px;">
       	<input type="submit" name="submit" value="PUNCH ORDER" class="btn btn-primary submitnow">
       </div>
						</div>
				
					</div>
</div>
					<hr />
				</div>

        <div class="col-md-3" style="text-align: center;padding-bottom: 20px;">
         <a href="<?= URL::to('admin/bookings/s/all/cash') ?>" target="_blank"> <h3>Total POS Sale</h3>
          <h3><i class="fa fa-rupee"></i> <span style="text-decoration: underline;"><?= number_format($totalamount) ?></span></h3></a>
        </div>
         <div class="col-md-3" style="text-align: center;padding-bottom: 20px;">
         <a href="<?= URL::to('admin/bookings/s/monthly/cash') ?>" target="_blank">  <h3>POS Sale This Month</h3>
          <h3><i class="fa fa-rupee"></i> <span style="text-decoration: underline;"><?= number_format($monthamount) ?></span></h3></a>
        </div>
         <div class="col-md-3" style="text-align: center;padding-bottom: 20px;">
         <a href="<?= URL::to('admin/bookings/s/todays/cash') ?>" target="_blank">  <h3>POS Sale Today</h3>
           <h3><i class="fa fa-rupee"></i> <span style="text-decoration: underline;"><?= number_format($todayamount) ?></span></h3></a>
        </div>
         <div class="col-md-3" style="text-align: center;padding-bottom: 20px;">
         <a href="<?= URL::to('admin/bookings/s/all/hold') ?>" target="_blank">  <h3>FOC Queue</h3>
           <h3><i class="fa fa-rupee"></i> <span style="text-decoration: underline;"><?= number_format($focamount) ?></span></h3></a>
        </div>
			</div>

		</div>
		</form>

	</div>

</div><!-- Panel Content -->
</div>

 <div class="modal fade-scale" id="bookingModal" role="dialog">
      <div class="modal-dialog bounce modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <label>Oops</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>
          <div class="modal-body">
            <div class="content"></div>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade-scale" id="bookingModal2" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <label>Oops</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>
          <div class="modal-body">
            <div class="content"></div>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-primary" id="yes">Yes</button>
          </div>
        </div>
      </div>
    </div>
<script>
  $(".transtype").on('change', function() {
    var value = $(this).val();
     $(".transvalue").attr('value',value);
  });
$(document).ready(function(){
  $(".allInput2").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".allTable2 tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  }); 
  $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
var i = 1;
$(".serviceid").click(function() {
  //alert();
     setTimeout( function() { $('#loader').show(); }, 100 );
        setTimeout( function() { $('#loader').hide(); }, 600 );
   var s_id = $(this).attr('data');
   if ($(this).is(':checked')) {
     $(this).closest('td').next('td').find('.btn-number').attr('disabled',false);
  $(this).closest('td').next('td').find('.canals').attr('disabled',false);
   $(this).closest('td').next('td').find('input[name="quantity[]"], select').attr('disabled',false);
   $(this).closest('td').next('td').find('input[name="quantity[]"]').attr('readonly',true);
   var quantity = $(this).closest('td').next('td').find('input').val();

 }else {
   $(this).closest('td').next('td').find('.btn-number').attr('disabled',true);
  $(this).closest('td').next('td').find('.canals').attr('disabled',true);
   $(this).closest('td').next('td').find('input[name="quantity[]"], select').attr('disabled',true);
   $(this).closest('td').next('td').find('input[name="quantity[]"]').attr('readonly',false);
   var quantity = "0";

 }
 
  var service_id = $(this).val().split('_');
  var type = $(this).closest('td').next('td').find('input.service_type').val();
  var datepicker = "";
  var timepicker3 = "";
  if (type=="events") {
       datepicker = "04-04-2020";
       timepicker3 = "6:00 PM";
       $(".serviceid").prop('disabled',true);
       $(this).prop('disabled',false);
    }else {
         datepicker = "<?= date('d-m-Y') ?>";
         timepicker3 = "<?= $currenttime ?>";
    }

  
  var occasion_type = $(this).closest('td').next('td').find(".occasion_type option:checked").val();
  if (occasion_type=="undefined" || occasion_type==null) {
    occasion_type = "0";
  }

  
  var canal = $(this).closest('td').next('td').find('.canals:checked').val();
  var famount = parseInt($(".famount").val());
  var famount2 = 0;
  var transvalue = $(".transvalue").val();
   var url = "<?= URL::to('booking/get_rates/"+service_id[1]+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/"+type+"/"+occasion_type+"/"+transvalue+"') ?>";
   

   $.ajax({
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
        if (result.length=="0") {
           $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Sorry, no session available for the selected date/time!");
           $('#price').attr('value', "0");
           $(".nextbtn").prop("disabled", true);
        }else {

             $(this).closest('td').next('td').find('span.price_total').html('<h5 style="color:red;text-align:left;"><i class="fa fa-rupee"></i> '+result[0]['final_price']+' (Price: <i class="fa fa-rupee"></i> '+result[0]['price']+' + GST: <i class="fa fa-rupee"></i> '+result[0]['tax_amount']+')</h5>');
              $("#amount"+s_id).attr('value',result[0]['final_price']);
              $("#price"+s_id).attr('value',result[0]['price']);
              $("#tax"+s_id).attr('value',result[0]['tax_amount']);
               famount2  = parseInt(result[0]['final_price'] + famount);
             $(".famount").attr('value',famount2);
             $(".grandtotal").html("<i class='fa fa-rupee'></i> "+famount2);
var sum = 0;
                 $(".amounts").each(function() {
                  if ($(this).val() != "") {
                    sum += parseFloat($(this).val());
                  }
                   
                  
                  });
                  $(".prevamount").attr('value',Math.round(sum));
                 if ($('.foc').is(':checked')) {
                   var percent = $('.percent').val();
                   var difference = parseInt(sum) * parseInt(percent) / 100;
                   sum  = sum - difference;
                 }

                   if ($(this).is(':checked')) {
 
                   }else {
                    $(this).closest('td').next('td').find('span.price_total').html('');
                      $(".famount").attr('value',Math.round(sum));
                      $(".grandtotal").html("<i class='fa fa-rupee'></i> "+Math.round(sum));

                   }
             
            

        }
         
        }
     });


});
$(".payment_method").on('change', function() {
   var value = $(this).val();
   if (value=="bookmyshow") {
    $(".bookmyshowid").css('display','block');
    $(".bookmyshow").attr('disabled', false);
   }else if (value=="gv_pay") {
    $(".bookmyshowid").css('display','block');
    $(".bookmyshow").attr('disabled', false);
   }else {
    $(".bookmyshowid").css('display','none');
    $(".bookmyshow").attr('disabled', true);
   }
});
 $('.btn-number').click(function(e) {
        e.preventDefault();

        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[data-quantity='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        setTimeout( function() { $('#loader').show(); }, 100 );
        setTimeout( function() { $('#loader').hide(); }, 600 );
        var service_id = $(this).attr('data');

      
        var quantity = 1;
       if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                    
                     quantity = currentVal - 1;
                }
                if (parseInt(input.val()) == input.attr('min')) {
                   // $(this).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                    
                    quantity = currentVal + 1;
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }

        } else {
            input.val(0);
        }
        var type = $("#type"+fieldName).val();

        var datepicker = "";
        var timepicker3 = "";
        if (type=="events") {
          datepicker = "04-04-2020";
          timepicker3 = "6:00 PM";
        }else {
         datepicker = "<?= date('d-m-Y') ?>";
         timepicker3 = "<?= $currenttime ?>";
         }
        var canal = 0;
        if (type=="service") {
          var canal_name = "canals"+service_id;
          canal = $("input[name="+canal_name+"]:checked").val();
        }else {
           var canal_name = "canalp"+service_id;
          canal = $("input[name="+canal_name+"]:checked").val();
        }

         var occasion_type = $("#occationp_"+service_id).val();
        if (occasion_type=="undefined" || occasion_type==null) {
          occasion_type = "0";
        }

        if (canal == null) {
          canal = 0;
        }
        var transvalue = $(".transvalue").val();
        var url = "<?= URL::to('booking/get_rates/"+service_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/"+type+"/"+occasion_type+"/"+transvalue+"') ?>";

     
    var famount2 = parseInt($(".famount").val());
    var famount3 = 0;
   $.ajax({
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
        if (result.length=="0") {
           $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Sorry, no session available for the selected date/time!");
           $('#price').attr('value', "0");
           $(".nextbtn").prop("disabled", true);
        }else {
          console.log(result);

              $("#"+fieldName).html('<h5 style="color:red;text-align:left;"><i class="fa fa-rupee"></i> '+result[0]['final_price']+' (Price: <i class="fa fa-rupee"></i> '+result[0]['price']+' + GST: <i class="fa fa-rupee"></i> '+result[0]['tax_amount']+')</h5>');
              $("#amount"+fieldName).attr('value',result[0]['final_price']);
              $("#price"+fieldName).attr('value',result[0]['price']);
              $("#tax"+fieldName).attr('value',result[0]['tax_amount']);
                var sum = 0;
                 $(".amounts").each(function() {
                  if ($(this).val() != "") {
                    sum += parseFloat($(this).val());
                  }
                   
                  
                  });
                 $(".prevamount").attr('value',Math.round(sum));
                   if ($('.foc').is(':checked')) {
                   var percent = $('.percent').val();
                   var difference = parseInt(sum) * parseInt(percent) / 100;
                   sum  = sum - difference;
                 }
               $(".famount").attr('value',Math.round(sum));
             $(".grandtotal").html("<i class='fa fa-rupee'></i> "+Math.round(sum));
              
             
        }
         
        }
     });
   
    });

 $(".submitnow").click(function() {
    var famount = $(".famount").val();
    var name = $(".name").val();
     var phone = $(".phone").val();
     if ($('input.foc').is(':checked')) {

       if (name=="" || phone=="") {
         $('#bookingModal').modal('show');
      $('#bookingModal .content').html("Please fill all the required feilds!");

      }else {
        var foc = $('.foc').val();
        var authorised = $('.authorised').val();
        var percent = $('.percent').val();
        
        if ($('.foc').is(':checked')) {
          if (authorised=="" || percent=="") {
               $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Please fill FOC details!");
          }else {
             return true;
          }

        }else {
          return true;
        }
        
      }

     }else {
      if (famount=="0") {
       $('#bookingModal').modal('show');
      $('#bookingModal .content').html("Please select atleast 1 service!");
      
    }else {
      if (name=="" || phone=="") {
         $('#bookingModal').modal('show');
      $('#bookingModal .content').html("Please fill all the required feilds!");

      }else {
        var foc = $('.foc').val();
        var authorised = $('.authorised').val();
        var percent = $('.percent').val();
        
        if ($('.foc').is(':checked')) {
          if (authorised=="" || percent=="") {
               $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Please fill FOC details!");
          }else {
             return true;
          }

        }else {
          return true;
        }
        
      }
      
      
    }
     }
    
    return false;
 });

 $(".occasion_type").change(function() {
     setTimeout( function() { $('#loader').show(); }, 100 );
        setTimeout( function() { $('#loader').hide(); }, 600 );
    var service_id = $(this).attr('data');
    var occasion_type = $(".occasion_type option:checked").val();
    var quantity = $("#q_"+service_id).val();
    var datepicker = "<?= date('d-m-Y') ?>";
    var timepicker3 = "<?= $currenttime ?>";
    var type = $(".datat_"+service_id).val();
     var canal = 0;
        if (type=="service") {
          var canal_name = "canals"+service_id;
          canal = $("input[name="+canal_name+"]:checked").val();
        }else {
           var canal_name = "canalp"+service_id;
          canal = $("input[name="+canal_name+"]:checked").val();
        }
        var transvalue = $(".transvalue").val();
     var url = "<?= URL::to('booking/get_rates/"+service_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/"+type+"/"+occasion_type+"/"+transvalue+"') ?>";
      

     $.ajax({
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
        if (result.length=="0") {
           $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Sorry, no session available for the selected date/time!");
        
        }else {

             $(".datapp_"+service_id).html('<h5 style="color:red;text-align:left;"><i class="fa fa-rupee"></i> '+result[0]['final_price']+' (Price: <i class="fa fa-rupee"></i> '+result[0]['price']+' + GST: <i class="fa fa-rupee"></i> '+result[0]['tax_amount']+')</h5>');
               $(".dataaa_"+service_id).attr('value',result[0]['final_price']);
              $(".datappp_"+service_id).attr('value',result[0]['price']);
              $(".datattp_"+service_id).attr('value',result[0]['tax_amount']);

              var sum = 0;
                 $(".amounts").each(function() {
                  if ($(this).val() != "") {
                    sum += parseFloat($(this).val());
                  }
                   
                  
                  });
                 $(".prevamount").attr('value',Math.round(sum));
                   if ($('.foc').is(':checked')) {
                   var percent = $('.percent').val();
                   var difference = parseInt(sum) * parseInt(percent) / 100;
                   sum  = sum - difference;
                 }
               $(".famount").attr('value',Math.round(sum));
             $(".grandtotal").html("<i class='fa fa-rupee'></i> "+Math.round(sum));
              
             
        }
         
        }
     });
    
 });
 $('.foc').on('change', function() {
   if($(this).is(':checked')) {
     $('.percent').prop('disabled',false);
   $('.authorised').prop('disabled',false);
 }else {
   $('.percent').prop('disabled',true);
   $('.authorised').prop('disabled',true);
 }
  
 });
 $(".percent").on('change', function() {
    var value = $(this).val();
    var sum = 0;
     $(".amounts").each(function() {
      if ($(this).val() != "") {
          sum += parseFloat($(this).val());
      }
        });
    var discount = parseInt(sum) * parseInt(value) / 100;
    famount = sum - discount;
     $(".famount").attr('value',Math.round(famount));
     $(".grandtotal").html("<i class='fa fa-rupee'></i> "+Math.round(famount));
 });
});
$(function() {
   $(".fa-refresh").click(function() {
           location.reload(true);
     });
  // open in fullscreen
  $('.main-content .requestfullscreen').click(function() {
    $('.main-content').fullscreen();
    return false;
  });
  // exit fullscreen
  $('.main-content .exitfullscreen').click(function() {
    $.fullscreen.exit();
    return false;
  });
  // document's event
  $(document).bind('fscreenchange', function(e, state, elem) {
    // if we currently in fullscreen mode
    if ($.fullscreen.isFullScreen()) {
      $('.main-content .requestfullscreen').hide();
      $('.main-content .exitfullscreen').show();
    } else {
      $('.main-content .requestfullscreen').show();
      $('.main-content .exitfullscreen').hide();
    }
    $('#state').text($.fullscreen.isFullScreen() ? '' : 'not');
  });
  
});
</script>
<script type="text/javascript" src="{{ asset('js/jquery.fullscreen-0.4.1.min.js') }}"></script>
<style type="text/css">
    #loader {
    display: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8) url({{ asset('images/loader2.gif')  }}) center center no-repeat;
    z-index: 1000;
}
.fade-scale {
  transform: scale(0);
  opacity: 0;
  -webkit-transition: all .25s linear;
  -o-transition: all .25s linear;
  transition: all .25s linear;
}

.fade-scale.in {
  opacity: 1;
  transform: scale(1);
}
.fa-refresh {
  cursor: pointer;
}
.bookmyshowid {
  display: none;
}
</style>
@endsection
