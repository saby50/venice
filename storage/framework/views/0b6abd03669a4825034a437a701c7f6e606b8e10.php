<?php $__env->startSection('title'); ?>
Cart
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
if (Auth::check()) {
   $wall_amount = Crypt::decrypt(Auth::user()->wall_am);
} 
   $amount = 0;
   $services = "";
   $price = 0;
   $tax_amount = 0;
   $applied_coupon = 0;
?>

<?php if(count($cart)==0): ?>
  <div class="recyclerview firstbox" style="text-align: center;">
    <i class="fa fa-shopping-cart fa-4x"></i><br />
 Cart is empty
</div>
  <?php else: ?>
 <div class="recyclerview firstbox">
  <div class="loader"></div>

      
      <?php $i=0; foreach($cart as $key => $value): ?>
         <?php
                              if (count($cart)==1) {
                                $services = $value['service_name'];
                              }else {
                                $services .= $value['service_name'].",";
                              }
                             
                          ?>
        <div class="featured-pwa ripple">
          <div class="row">
       
        <div class="col-8">
           <span class="title"><?= $value['service_name'] ?></span><br />
           <span style="font-size: 13px;"><?= $value['date'] ?> | <?= $value['time'] ?></span><br />
           <a href="<?= URL::to('cart/remove_item/'.$key) ?>" class="removeItem">Remove</a>
        </div>
        <?php 
                             $type = $value['type'];
                             $service_id = $value['service_id'];
                             $first_char = mb_substr($type, 0,1);
                             $match = $first_char."_".$service_id;

                             $discountamount = 0;
                             $damount = 0;
                             $bprice = $value['price'];
                            
                             $btax = $value['tax'];
                             $bamount = $bprice + $btax;
                             
                              $coupon = Session::get('coupon');

                           
                             if (!empty($coupon)) {
                             //  $cmatch = explode(",", $coupon['match']);
                               if ($coupon['match']==$match) {
                                if ($value['quantity']==1) {
                                  $discountamount = $bamount * $coupon['coupon_percent'] /100;
                                  $discountprice = $bprice * $coupon['coupon_percent'] /100;
                                  $discounttax = $btax * $coupon['coupon_percent'] /100;
                                  $bamount = $value['amount'] - $discountamount;
                                  $bprice = $value['price'] - $discountprice;
                                  $btax = $value['tax'] - $discounttax;
                                  $applied_coupon = 1;
                                  $damount = $discountamount;
                                }else {
                                   $bamount = $value['amount']/$value['quantity'];
                                   $bprice = $value['price']/$value['quantity'];
                                   $btax = $value['tax']/$value['quantity'];
                                    $discountamount = $bamount * $coupon['coupon_percent'] /100;
                                  $discountprice = $bprice * $coupon['coupon_percent'] /100;
                                  $discounttax = $btax * $coupon['coupon_percent'] /100;
                                  $bamount = $value['amount'] - $discountamount;
                                  $bprice = $value['price'] - $discountprice;
                                  $btax = $value['tax'] - $discounttax;
                                  $applied_coupon = 1; 
                                  

                                }
                               }
                               

                             }

                             $eligibilty = 0;
                             $damount = 0;
                             if (Auth::check()) {
                                $count = Helper::check_eligible_coupon(Auth::user()->id, $match);
                             if ($count==0) {
                               $eligibilty = 1;
                               $damount = $discountamount;
                             }
                             if ($eligibilty==1) {
                              $coupondetails = Helper::get_coupon($match);
                              $coupon = array();
                              foreach ($coupondetails as $l => $m) {
                               $coupon = array('coupon_code' => $m->coupon_name,'coupon_percent' => $m->coupon_percent,'match' => $m->uniq_match);
                              }
                               
                                Session::put('coupon', $coupon);
                             }
                             }
                        

                         ?>
         <div class="col-4">
          <?php if($value['pack_type']=="occasional"): ?>
                            <input type="number" name="quantity" value="<?= $value['quantity'] ?>" class="quantity" min="2">
                            <?php else: ?>
                               <input type="number" name="quantity" value="<?= $value['quantity'] ?>" class="quantity" min="1">
                          <?php endif; ?>
                            <input type="hidden" class="service_id" value="<?= $value['service_id'] ?>">
                          <input type="hidden" class="date" value="<?= $value['date'] ?>">
                          <input type="hidden" class="time" value="<?= $value['time'] ?>">
                          <input type="hidden" class="optional" value="<?= $value['canal'] ?>">
                          <input type="hidden"  value="<?= $value['type'] ?>" class="type">
                          <input type="hidden"  value="<?= $value['occasion_type'] ?>" class="occasion_type">
                          <br />
                         &nbsp;&nbsp;&nbsp; <span class="orangetext"><i class='fa fa-inr'></i>  <?= $value['amount'] ?></span>
        </div>
        </div>
        </div>
       <?php 
                          


 $amount += $bamount;
                                 $price += $bprice;
                                 $tax_amount += $btax;
                           ?>
        <?php if($i == count($cart) - 1): ?>
        <?php else: ?>
          <hr />
        <?php endif; ?>
        

        <?php 
                   $i++;
        ?>

      <?php endforeach; ?>
      <?php if(Auth::check()): ?>
                            <div class="">
               <hr />
                    
                        <form method="post" action="<?php echo e(URL::to('apply_coupon')); ?>">
                          <?php echo csrf_field(); ?>
                          <label><strong>Coupon Code</strong></label>
                       <?php  if ($applied_coupon==1): ?>
                        <input type="text" name="coupon_code" placeholder="Enter Coupon" value="<?= $coupon['coupon_code'] ?>" style="text-transform: uppercase;" class="form-control coupon_code"  onkeyup="this.value = this.value.toUpperCase();"><br />
                        <?php else: ?>
                           <input type="text" name="coupon_code" placeholder="Enter Coupon" value="" style="text-transform: uppercase;" class="form-control coupon_code"  onkeyup="this.value = this.value.toUpperCase();"><br />
                      <?php endif; ?>
                        <button type="submit" class="btn checkoutbtn"> Apply Coupon</button>

                      </form>
                      <div style="margin-top: 20px;">
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
      <?php if(session('error')): ?>
        <div class="widget no-color">
            <div class="alert alert-danger">
                <div class="notify-content">
                   <?php echo e(session('error')); ?>!

                </div>
            </div>
            </div>
        </div>
      <?php endif; ?>
        <?php if(session('warning')): ?>
        <div class="widget no-color">
            <div class="alert alert-warning">
                <div class="notify-content">
                   <?php echo e(session('warning')); ?>!

                </div>
            </div>
            </div>
        </div>
      <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
    </div>
    <div class="recyclerview">
      
<div class="row">

      <div class="col-12">
        <div class="recyclerviewhead">
      Billing Details
       </div>
      <div class="recyclerviewhead2">
         
       </div>   
      </div>
            </div>

            <div class="row billingdetails">
              <div class="col-8">
                Subtotal
              </div>
               <div class="col-4" style="text-align: right;">
                 <span class="billdet"><i class='fa fa-inr'></i> <?= (double)$price ?></span>
              </div>
              <div class="col-8">
                GST
              </div>
               <div class="col-4" style="text-align: right;">
                <span class="billdet"><i class='fa fa-inr'></i> <?= (double)$tax_amount ?></span>
              </div>
              <?php  if ($applied_coupon==1): ?>
              <div class="col-6">
                Coupon
              </div>
               <div class="col-6" style="text-align: right;">
                 <span class="billdet"> <?php echo $coupon['coupon_code'].' <a href="'.URL::to('remove_coupon').'" style="text-decoration: underline;">(remove)</a>'; ?></span>
              </div>
            <?php endif; ?>
              <div class="col-8">
                Total
              </div>
               <div class="col-4" style="text-align: right;">
                <span class="orangetext" style="font-size: 20px;"><i class='fa fa-inr'></i> <?= number_format($amount) ?></span>
              </div>
            </div>
      
      
    </div>
       <div class="recyclerview">
<div class="row">
        
      <div class="col-12">
        <div class="recyclerviewhead" style="margin-bottom: 10px;color: #ff7d01;text-align: center;width: 100%;">
      Express Checkout
       </div>
      <div class="recyclerviewhead2">
         
       </div>   
      </div>
            </div>
 <form action="<?php echo e(URL::to('cart/checkout')); ?>" method="post" class="checkoutform">
  <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            <div class="row billingdetails">
              
              <div class="col-12">
                <?php if(Auth::check()): ?>
                <input type="text" name="name" class="form-control" placeholder="Name" required="required" autocomplete="off" value="<?= Auth::user()->name ?>" readonly>
                <?php else: ?>
                    <input type="text" name="name" class="form-control" placeholder="Name" required="required" autocomplete="off">

                  <?php endif; ?><br />
              </div>
               <input type="hidden" name="amount" value="<?= Crypt::encrypt($amount) ?>">
        <input type="hidden" name="services" value="<?= rtrim($services,",") ?>">
        <input type="hidden" name="payment_method" value="instamojo" class="payment_method">
              <div class="col-12">
                <?php if(Auth::check()): ?>
                 <input type="text" name="phone" class="form-control" placeholder="Phone"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required="required" autocomplete="off" value="<?= Auth::user()->phone ?>" readonly>
                 <?php else: ?>
                   <input type="text" name="phone" class="form-control" placeholder="Phone"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required="required" autocomplete="off">

                  <?php endif; ?><br />
              </div>
             
              <div class="col-12">
                <?php if(Auth::check()): ?>
                  <div style="width: 100%;text-align:right;"><a href="<?= URL::to('profile') ?>" style="color: #ff7d01; ">Edit</a></div>

                <input type="text" name="email" class="form-control" placeholder="Email" required="required" autocomplete="off" value="<?= Auth::user()->email ?>" readonly>
                 <?php else: ?>

                  <input type="text" name="email" class="form-control" placeholder="Email" required="required" autocomplete="off">
                  <?php endif; ?><br />
              </div>
                 <div class="col-12 form-group">
                  <?php if(Auth::check()): ?>
               <button type="submit" class="btn checkoutbtn"> Check-out</button>
               <?php else: ?>
                <button type="submit" class="btn checkoutbtn3"> Check-out</button>
             <?php endif; ?>
              </div>

            </div>
       </form>
        
    </div>
<?php endif; ?>
  <div class="modal fade center" id="bookingModal" role="dialog">
  <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
  
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <label>Something went wrong!</label>
            <button type="button" class="close" data-dismiss="modal" style="color: #FFF;">&times;</button>

          </div>
          <div class="modal-body">
            <div class="content">
              
            
            </div>

          </div>
          <div class="modal-footer">

            
             <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
      </form>
    </div>
</div></div>
 <!-- The Modal -->
<div id="myModal2" class="modal fade">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="">
      <span class="close">&times;</span>
      
    </div>
    <div class="modal-body">
      <h5>Payment Mode</h5>
     <div class="row">
    <div class="col-5"> <label> <input type="radio" name="payment_mode" class="payment_mode" checked="checked" value="instamojo" style="position: relative;top:2px;">  <img src="<?= asset('public/images/instamojo.JPG') ?>" class="payment_method2" ></label><br /></div>
      <?php if(Auth::check()): ?>
      <?php if($wall_amount!=0 && $wall_amount >= $amount): ?>
    <div class="col-7" style="font-size: 12px;"><label> <input type="radio" name="payment_mode" class="payment_mode" value="wallet" style="position: relative;top:2px;"> <img src="<?= asset('public/images/gv_pocket.JPG') ?>" class="payment_method2" style="width: 60px;"> (<i class="fa fa-rupee"></i> <?= $wall_amount ?>)</label><br /></div>
     <?php endif; ?>
          <?php endif; ?><br /><br />
     
     <div style="padding-left: 10px;padding-right: 10px;width: 100%;"><button type="submit" class="btn checkoutbtn2" style="width: 100%;"> Pay Now</button></div> 
    
      </div>
       <div style="margin-top: 30px;">
      <h3>Modal Footer</h3>
    </div>
    </div>
  
  </div>

</div>
<style type="text/css">
#hero {
  width: 100%;
  height: 100vh;
  background: url(<?= asset('public/images/dashboard.jpg') ?>) no-repeat top center;
  background-size: contain;
  position: relative;
}
.timepicker {
        padding: .375rem .75rem !important;
}
.payment_method_box {
  font-size: 14px;
}

.checkoutbtn, .checkoutbtn2,.checkoutbtn3 {
  width: 100% !important;
}
.billdet {
  font-size: 13px;
}
#price {
    font-size:24px;
    font-weight: bold;
    line-height: 3 !important;
    color: #000;
    text-align: center;
}
    .loader {
    display: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8) url(<?php echo e(asset('public/images/loader2.gif')); ?>) center center no-repeat;
    z-index: 1000;
}
    .loader {
    display: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8) url(<?php echo e(asset('public/images/loader2.gif')); ?>) center center no-repeat;
    z-index: 1000;
}
.remove {
  cursor: pointer;
}
.vertical-alignment-helper {
    display:table;
    height: 100%;
    width: 100%;
}
.vertical-align-center {
    /* To center vertically */
    display: table-cell;
    vertical-align: middle;
}

</style>

<script type="text/javascript">
  $(function() {
     $(".removeItem").click(function() {
         $(".")
      });
    $(".checkoutbtn").click(function() {
       var selected = $(".payment_method:checked").val();

        $("#myModal2").modal('show');
        return false;
    });
 $(".checkoutbtn2").click(function() {
       var selected = $(".payment_mode:checked").val();
       $(".payment_method").attr('value',selected); 
      var login = "<?= Auth::check() ?>";

       if (login=="1") {
         
         if (selected=="paytm") {
          $(".checkoutform").attr('action','<?php echo e(URL::to("paytm")); ?>');
          
          return true;
       }else if (selected=="wallet") {
         $(".checkoutform").attr('action','<?php echo e(URL::to("cart/checkout")); ?>');
         $(".checkoutform").submit();
       }else {
        $(".checkoutform").attr('action','<?php echo e(URL::to("cart/checkout")); ?>');
        $(".checkoutform").submit();
       }
     }else {
       if (selected=="paytm") {
          $(".checkoutform").attr('action','<?php echo e(URL::to("paytm")); ?>');  
          return true;
       }else {
        $(".checkoutform").attr('action','<?php echo e(URL::to("cart/checkout")); ?>');
        $(".checkoutform").submit();
       }
     }
       return false;
    });
      $(".quantity").on('change', function() {
         setTimeout( function() { $('.loader').show(); }, 100 );
         setTimeout( function() { $('.loader').hide(); }, 600 );   
         var service_id =  $(this).nextAll('input.service_id').first().attr('value');
         var date = $(this).nextAll('input.date').first().attr('value');
         var time = $(this).nextAll('input.time').first().attr('value');
         var optional = $(this).nextAll('input.optional').first().attr('value');
         var type = $(this).nextAll('input.type').first().attr('value');
         var ocassion_type = $(this).nextAll('input.occasion_type').first().attr('value');
         if (ocassion_type != "") {
          ocassion_type = ocassion_type;
         }else {
          ocassion_type  = "0";
         }

         
         var quantity = $(this).val();
         var url;
         if (type=="service") {
            url = "<?= URL::to('cart/update_quantity') ?>";
         }else {
           url = "<?= URL::to('cart/update_pack_quantity') ?>";
         }

         
           var formData = {
                 '_token':'<?php echo e(csrf_token()); ?>',
                'service_id': service_id,
                'date': date,
                'time': time,
                'quantity': quantity,
                'optional': optional,
                'ocassion_type': ocassion_type
            };
            if (quantity==0) {
              $("#bookingModal").modal('show');
              $(".modal-body .content").html("Quantity 0 is invalid!");
              $(".checkoutbtn").attr('disabled', true);
            }else {
                $.post(url,  formData,
            function (resp,textStatus, jqXHR) {
               window.location = "<?= URL::to('cart') ?>";
            });
                  $(".checkoutbtn").attr('disabled', false);
            }
           



       
      });

  });

</script>
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/cart/indexpwa.blade.php ENDPATH**/ ?>