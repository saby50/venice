@extends('layouts.main2')

@section('title')
Cart
@endsection

@section('content')
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
                          



                                 $amount += $value['amount'];
                                 $price += $value['price'];
                                 $tax_amount += $value['tax'];
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
                <span class="billdet"><i class='fa fa-inr'></i> <?= (double)$tax_amount ?></span>
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
 <form action="{{ URL::to('cart/checkout') }}" method="post" class="checkoutform">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
    background: rgba(255,255,255,0.8) url({{ asset('public/images/loader2.gif')  }}) center center no-repeat;
    z-index: 1000;
}
    .loader {
    display: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8) url({{ asset('public/images/loader2.gif')  }}) center center no-repeat;
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
          $(".checkoutform").attr('action','{{ URL::to("paytm") }}');
          
          return true;
       }else if (selected=="wallet") {
         $(".checkoutform").attr('action','{{ URL::to("cart/checkout") }}');
         $(".checkoutform").submit();
       }else {
        $(".checkoutform").attr('action','{{ URL::to("cart/checkout") }}');
        $(".checkoutform").submit();
       }
     }else {
       if (selected=="paytm") {
          $(".checkoutform").attr('action','{{ URL::to("paytm") }}');  
          return true;
       }else {
        $(".checkoutform").attr('action','{{ URL::to("cart/checkout") }}');
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
                 '_token':'{{ csrf_token()}}',
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
  
@endsection