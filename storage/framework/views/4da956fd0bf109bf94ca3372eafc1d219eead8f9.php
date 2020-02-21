<?php $__env->startSection('title'); ?>
Cart
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section id="hero_login" class="cartarea">
        <div class="hero-container">

            <div class="row" style="width: 100%;">

                <div class="col-md-2 col-12"></div>
                <div class="col-md-8 my-profile row">
                	<div class="col-8 cartside1">

                    <div class="loader"></div>
                    <div class="head row">
                        <div class="col-md-8" style="padding-top: 20px;padding-left: 40px;">
                            <h3>Your Cart</h3>

                        </div>
                         <div class="col-md-4" style="padding-top: 20px;padding-left: 40px;">
                            
                        </div>
                    </div>
                    <hr>

                    <div class="col-md-12">
                      <div class="table-responsive-lg">

                       <?php if(count($cart) > 0): ?>
                    	<table class="table borderless">
                    		<thead>
                    			<th>Product</th>
                    			<th>Price</th>
                    		</thead>
                    		<tbody>
                    			<?php 
                                $amount = 0;
                                $services = "";
                                $price = 0;
                                $tax_amount = 0;
                             
                    			?>
                         
                    		<?php foreach($cart as $key => $value): ?>
                          <?php
                              if (count($cart)==1) {
                                $services = $value['service_name'];
                              }else {
                                $services .= $value['service_name'].",";
                              }
                             
                          ?>
                    			<tr>
                    			<td><table><tr><td><a href="<?= URL::to('cart/remove_item/'.$key) ?>" style="top: 10px;position: relative;"><img src="<?php echo e(asset('public/images/cross.jpg')); ?>" class="remove" data="<?= $key ?>"></a></td><td><div class="col-md-4"><img src="<?= $value['icon'] ?>" width="65px" style="border: solid 1px #ccc;"></div><br /><div class="mobiletxt"><strong><?= $value['service_name'] ?><?php if($value['canal']): ?>
                           
                         (<?= $value['canal'] ?>)
                         <?php endif; ?></strong><br />
                            Date/Time: <?= $value['date'] ?> | <?= $value['time'] ?><br />
                            Person: <?= $value['quantity'] ?></div> </td>
                           <td style="font-size: 13px;"><div class="desktoptxt"><strong><?= $value['service_name'] ?><?php if($value['canal']): ?>
                           
                         (<?= $value['canal'] ?>  <?php if($value['pack_type']=="occasional"): ?>
                          - <?= $value['occassion_text'] ?>
                           <?php endif; ?>)
                         <?php endif; ?>
                          

                         </strong><br />
                            Date/Time: <?= $value['date'] ?> | <?= $value['time'] ?><br />
                            Person: <?= $value['quantity'] ?>

                            </div></td>
                          </tr></table>
                           </td>
                    			<td style="text-align: center;"><span class="orangetext"><i class='fa fa-inr'></i>  <?= $value['amount'] ?></span><br />
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
                           </td>
                    		   </tr>
                    		   <?php 
                           $coupon = Session::get('coupon');



                                 $amount += $value['amount'];
                                 $price += $value['price'];
                                 $tax_amount += $value['tax'];
                    		   ?>
                    		<?php endforeach; ?>
                        
                    		</tbody>
                    		
                    	</table>

                      
                      <?php else: ?>
                          <h3 style="text-align: center;">Cart is Empty</h3>
                      <?php endif; ?>
                    </div></div>
                  <hr>
                    
                   <div class="col-md-12 table-responsive-lg" style="padding: 20px;">
                    <table width="100%">
                      <tr>
                        <td>
                         <div class="row">
                          <div class="col-md-6">
                            <?php if(count($cart) > 0): ?>
                      <span style="font-size: 14px;">Subtotal:</span> <span class="orangetext"><i class='fa fa-inr'></i> <?= (double)$price ?></span> &nbsp;&nbsp;| &nbsp;&nbsp;
                         <span style="font-size: 14px;">GST:</span> <span class="orangetext"><i class='fa fa-inr'></i> <?= (double)$tax_amount ?></span><br />
                         <?php 
                          if (!empty($coupon)) {
                             $discountamount = $amount * $coupon['coupon_percent'] /100;
                            echo ' <span style="font-size: 14px;">Coupon Discount('.$coupon['coupon_percent'].'%):</span> <span class="orangetext">&nbsp;&nbsp; <i class="fa fa-inr"></i>';

                            echo $discountamount;

                            echo ' </span><br />';

                          }


                         ?>
                      <span style="font-size: 14px;">Total:</span> <span class="orangetext" style="font-size: 20px;font-weight: bold;"><i class='fa fa-inr'></i>  <?php
                        if (!empty($coupon)) {
                          
                          $amount = $amount - $discountamount;

                        }else {
                          $amount = $amount;
                        }

                       echo number_format($amount) 

                       ?></span><br /><br />
                      <div class="form-group" style="display: none;">
                        <form method="post" action="<?php echo e(URL::to('apply_coupon')); ?>">
                          <?php echo csrf_field(); ?>
                          <?php  if (!empty($coupon)): ?>
                        <input type="text" name="coupon_code" placeholder="Enter Coupon" value="<?= $coupon['coupon_code'] ?>" style="text-transform: uppercase;" class="form-control coupon_code"><br />
                        <?php else: ?>
                           <input type="text" name="coupon_code" placeholder="Enter Coupon" value="" style="text-transform: uppercase;" class="form-control coupon_code"><br />
                      <?php endif; ?>
                        <button type="submit" class="btn checkoutbtn"> Apply Coupon</button>

                      </form>
                        
                      </div>
                      
                      <?php endif; ?>
                          </div>
                          <div class="col-md-6 continueshopping" style="text-align: right;">
                            <a href="<?php echo e(URL::to('/')); ?>"><button name="addtocart" type="button" class="addtocart btn" style="width: 200px;"> Continue Shopping</button></a>
                            <div style="margin-top: 20px;width: 220px;float: right;">
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
                            </div>

                          </div>
                           
                         </div>
                          </td>
                        <td ></td>
                      </tr>
                    </table>
                    
                    </div>
                   
                </div>
                <div class="col-4 cartside2">

<?php if(count($cart) > 0): ?>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#home">Express Checkout</a>
    </li>
    <?php if(!Auth::check()): ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu1">Login</a>
    </li>
    <?php endif; ?>
  
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">

    <div id="home" class="container tab-pane active"><br>
     <form action="<?php echo e(URL::to('cart/checkout')); ?>" method="post" class="checkoutform">
       <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
       <div class="form-group">
          <div class="" style="font-size: 13px;">Name<span style="color: red;">*</span></div>
          <?php if(Auth::check()): ?>
          <?php if(Auth::user()->type=="manager"): ?>
         <input type="text" name="name"  class="form-control" value="" required="required">
         <?php else: ?>
        <input type="text" name="name"  class="form-control" value="<?php echo e(Auth::user()->name); ?>" required="required" readonly="readonly">
         <?php endif; ?>
         <?php else: ?>
         <input type="text" name="name"  class="form-control" required="required">
         <?php endif; ?>
       </div>
        <div class="form-group">
          <div class="" style="font-size: 13px;">Phone<span style="color: red;">*</span></div>
           <?php if(Auth::check()): ?>
           <?php if(Auth::user()->type=="manager"): ?>
         <input type="text" name="phone" class="form-control"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required="required">
          <?php else: ?>
       <input type="text" name="phone" class="form-control" value="<?php echo e(Auth::user()->phone); ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required="required" readonly="readonly">
         <?php endif; ?>
          <?php else: ?>
         <input type="text" name="phone" class="form-control"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required="required">
         <?php endif; ?>
       </div>
       <div class="form-group">
        <?php if(count($cart) > 0): ?>
        <input type="hidden" name="amount" value="<?= Crypt::encrypt($amount) ?>">
        <input type="hidden" name="services" value="<?= rtrim($services,",") ?>">
      <?php endif; ?>
          
           <?php if(Auth::check()): ?>
            <?php if(Auth::user()->type=="manager"): ?>
            <div class="" style="font-size: 13px;">Email</div>
         <input type="text" name="email"  class="form-control" value="" >
          <?php else: ?>
          <div class="" style="font-size: 13px;">Email<span style="color: red;">*</span><a href="<?php echo e(URL::to('profile')); ?>" style="float: right;">Change</a></div>
          <?php if(Auth::user()->email != ""): ?>
       <input type="text" name="email"  class="form-control" value="<?php echo e(Auth::user()->email); ?>" required="required" readonly="readonly">
       <?php else: ?>
        <input type="text" name="email"  class="form-control" value="<?php echo e(Auth::user()->email); ?>" required="required">

        <?php endif; ?>
         <?php endif; ?>
          <?php else: ?>
          <div class="" style="font-size: 13px;">Email<span style="color: red;">*</span></div>
         <input type="text" name="email"  class="form-control"  required="required">
         <?php endif; ?>
       </div>
             <?php if(Auth::check()): ?>
           
       <div class="form-group">
        <div class="row payment_method_box">
             <?php 
               $wall_am = Crypt::decrypt(Auth::user()->wall_am);
             ?>
           <?php foreach($payment_method as $key => $value): ?>
            <?php if($key==0): ?>
<?php  if($value->gateway_name=="gv_pocket"): ?>
              <?php if($wall_am!=0 && $wall_am >= $amount): ?>
               <div class="col-md-6">
       <input type="radio" name="payment_method" value="<?= $value->alias ?>" class="payment_method" checked="checked"> <img src="<?= asset('public/images/'.$value->gateway_name.'.JPG') ?>" class="payment_method2"> (Rs. <?= $wall_am ?>)</div>
       <?php endif; ?>
    <?php else: ?>

     <div class="col-md-6">
       <input type="radio" name="payment_method" value="<?= $value->alias ?>" class="payment_method" checked="checked"> <img src="<?= asset('public/images/'.$value->gateway_name.'.JPG') ?>" class="payment_method2"></div>
    <?php endif; ?>
            <?php else: ?>
<?php  if($value->gateway_name=="gv_pocket"): ?>
              <?php if($wall_am!=0 && $wall_am >= $amount): ?>
               <div class="col-md-6">
       <input type="radio" name="payment_method" value="<?= $value->alias ?>" class="payment_method"> <img src="<?= asset('public/images/'.$value->gateway_name.'.JPG') ?>" class="payment_method2"> (Rs. <?= $wall_am ?>)</div>
       <?php endif; ?>
    <?php else: ?>

     <div class="col-md-6">
       <input type="radio" name="payment_method" value="<?= $value->alias ?>" class="payment_method"> <img src="<?= asset('public/images/'.$value->gateway_name.'.JPG') ?>" class="payment_method2"></div>
    <?php endif; ?>

            <?php endif; ?>

  
    <?php endforeach; ?>
        </div>
       </div>
      
       
          <?php else: ?>
         <input type="hidden" name="payment_method" value="instamojo">
         <?php endif; ?>

         <div class="form-group">
         
         <button type="submit" class="btn checkoutbtn"> Check-out</button>
       </div>
     </form>
      
    </div>
    
    <div id="menu1" class="container tab-pane fade"><br>
     <form action="<?php echo e(URL::to('clogin')); ?>" method="post" class="checkoutform">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        <div class="form-group" style="width: 270px;margin-left: 30px;">
          <div class="" style="font-size: 13px;">Phone<span style="color: red;">*</span></div>
         <input type="text" name="phone" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required="required">
       </div>
       <div class="form-group">
         
        <div class="row">
         <div style="margin-left: 50px;margin-bottom: 40px;">
                            <label for="pincode-input1">PIN<span style="color: red;">*</span></label><br>
                            <input type="text" name="pin" id="pincode-input1">
                            </div>
                            <input type="hidden" name="pinno" value="" class="pinno">
                            <input type="hidden" name="rd" value="cart">

                             <?php if(count($cart) > 0): ?>
        <input type="hidden" name="amount" value="<?= $amount ?>">
        <input type="hidden" name="services" value="<?= rtrim($services,",") ?>">
        <input type="hidden" name="payment_method" value="instamojo">
      <?php endif; ?>
       </div>
         <div class="form-group">
         
         <button type="submit" class="btn checkoutbtn2"> Login</button>
       </div>
     </form>
    </div>

  </div>
          <?php endif; ?>       </div>
                </div>
                <div class="col-md-2 col-12"></div>
            </div>
        </div>
    </section>
    <!-- booking form success end -->
    <main id="main">

<div class="modal fade" id="bookingModal" role="dialog">
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

            <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
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
.payment_method2 {
  width: 60px;
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
</style>

<script type="text/javascript">
  $(function() {
    $(".checkoutbtn").click(function() {
       var selected = $(".payment_method:checked").val();
       if (selected=="paytm") {
          $(".checkoutform").attr('action','<?php echo e(URL::to("paytm")); ?>'); 
          return true;
       }else {
        $(".checkoutform").attr('action','<?php echo e(URL::to("cart/checkout")); ?>');
        return true;
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
             $.post(url,  formData,
            function (resp,textStatus, jqXHR) {
               window.location = "<?= URL::to('cart') ?>";
            });



       
      });

  });

</script>
  <script>
    $(document).ready(function() {
        $('#pincode-input1').pincodeInput({
            hidedigits: true,
            complete: function(value, e, errorElement) {
              

               $(".pinno").attr('value',value);


            }
        });
    });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/cart/index.blade.php ENDPATH**/ ?>