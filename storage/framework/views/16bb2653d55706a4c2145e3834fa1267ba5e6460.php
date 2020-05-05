<?php $__env->startSection('title'); ?>
Food Cart
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

?>
<?php if(count($cart)==0): ?>
  <div class="recyclerview firstbox" style="text-align: center;">
    <i class="fa fa-shopping-cart fa-4x"></i><br />
 Cart is empty
</div>
  <?php else: ?>
 <div class="recyclerview firstbox">
  <div class="loader"></div>
  <div class="row">
           <?php 
           $unit_id = 0;
           foreach ($cart as $key => $value) {
             $unit_id = $value['unit_id'];
           }
           $unit_name = ""; $foodstore = "";
          $unit_details = Helper::get_unit_info($unit_id);
          foreach ($unit_details as $k => $v) {
            $unit_name =  $v->unit_name;
            $foodstore = $v->foodstore;
          }
      ?>
    <div class="col-2" style="background: url(<?= URL::to('public/uploads/foodstore/'.$foodstore) ?>);width: 100%;height: 40px;background-position: center;background-size: contain;margin-left: 10px;border: solid 1px #ccc;">
     
    </div>
    <div class="col-8" style="margin-top: 10px;">
      <span style="font-size: 11px;"><?= $unit_name ?></span>
    </div>
  </div>
      
      <?php $i=0; foreach($cart as $key => $value): ?>
       <?php  $tax_percent = Helper::get_unit_tax($unit_id); ?>

        <div class="featured-pwa ripple">
          <div class="row">
      
        <div class="col-8">
          <?php 
           $get_item_details = Helper::get_menu_item_details($value['item_id']);
           $veg_nonveg = "";

           foreach ($get_item_details as $k => $v) {
             $veg_nonveg = $v->veg_nonveg;
           }

        ?>
                  <?php if($veg_nonveg=="veg"): ?>
                    <img src="<?php echo e(asset('public/images/veg.png')); ?>" style="margin-top: 0px;width: 16px;">
                    <?php else: ?>
                        <img src="<?php echo e(asset('public/images/nonveg.png')); ?>" style="margin-top: 0px;width: 16px;">
                  <?php endif; ?>
           <span class="title2"><?= Helper::get_menu_item_name($value['item_id']) ?></span><br />
           <?php 
              $custom = $value['custom'];
              $customprice = 0;
            
              foreach ($custom as $k => $v) {
                foreach ($v as $m => $n) {
                  if (is_array($n)) {
                    if (!empty($n)) {
                  foreach ($n as $j => $i) {
                    list($a,$b) = explode("_", $i);
                    $customprice+=$b;
                  }
                   }
                  }else {
                    list($a,$b) = explode("_", $n);
                    $customprice+=$b;

                  }
                 
              }
              echo "&nbsp;&nbsp;".$a;
              }
              if (!empty($custom)) {
                echo '<div style="font-size:12px;margin-left:5px;"><a href="'.URL::to("menu/addons/".$value["item_id"]).'" style="color:#000;"> Customize <i class="fa fa-chevron-down" style="color:green;"></i></a> </div>';
              } 
           ?>
         
           <a href="<?= URL::to('food_cart/remove_item/'.$key) ?>" class="removeItem">Remove</a>
        </div>
       <div class="col-4">
      
      <input type="number" name="quantity" value="<?= $value['quantity'] ?>" class="quantity" min="1">
      <input type="hidden" class="item_id" value="<?= $value['item_id'] ?>">
       <input type="hidden" class="price" value="<?= Helper::get_menu_item_price($value['item_id']) ?>">  
       <input type="hidden" class="nquantity" value="<?= $value['quantity'] ?>">            
       <br />
       <?php 
           $qprice = Helper::get_menu_item_price($value['item_id']);
           $sprice = $value['quantity'] * $qprice;


       ?>
                         &nbsp;&nbsp;&nbsp; <span class="orangetext"><i class='fa fa-inr'></i>  <?= $sprice  + $customprice  ?></span>
        </div>
        </div>
        </div>
       <?php 
         
          $price += $sprice + $customprice;
          $tax_amount = $price * $tax_percent/100;

          $amount = round($price + $tax_amount);
        ?>
        <?php if($i == count($cart) - 1): ?>
        <?php else: ?>
          <hr />
        <?php endif; ?>
        

        <?php 
                   $i++;
        ?>

      <?php endforeach; ?>
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
                <span class="billdet"><i class='fa fa-inr'></i> <?= round($tax_amount) ?></span>
              </div>
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
 <form action="<?php echo e(URL::to('foodcart/checkout')); ?>" method="post" class="checkoutform">
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
        <input type="hidden" name="services" value="Food Order">
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
.title2 {
    color: #000;
    font-size: 12px;
    font-weight: 500;
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
         $(".checkoutform").attr('action','<?php echo e(URL::to("food_cart/checkout")); ?>');
         $(".checkoutform").submit();
       }else {
        $(".checkoutform").attr('action','<?php echo e(URL::to("food_cart/checkout")); ?>');
        $(".checkoutform").submit();
       }
     }else {
       if (selected=="paytm") {
          $(".checkoutform").attr('action','<?php echo e(URL::to("paytm")); ?>');  
          return true;
       }else {
        $(".checkoutform").attr('action','<?php echo e(URL::to("food_cart/checkout")); ?>');
        $(".checkoutform").submit();
       }
     }
       return false;
    });

    $(".quantity").on('change', function() {
      var quantity = $(this).val();
      var item_id = $(this).nextAll('.item_id').first().attr('value');
      var price = $(this).nextAll('.price').first().attr('value');
      var nquantity = $(this).nextAll('.nquantity').first().attr('value');
      var identifier = "minus";
      if (nquantity < quantity) {
         identifier = "plus";
      }
      var formData = {
                '_token':'<?php echo e(csrf_token()); ?>',
                'item_id': item_id,
                'quantity': quantity,
                'price': price,
                'identifier': identifier
      };

      var url = '<?= URL::to("menu/foodcart_update") ?>'; 
      $.post(url,  formData, function (resp,textStatus, jqXHR) {
           window.location = "<?= URL::to('food_cart') ?>";  
      });
      
    });
    

  });

</script>
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/cart/foodcart.blade.php ENDPATH**/ ?>