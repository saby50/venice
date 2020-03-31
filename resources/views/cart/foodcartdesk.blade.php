@extends('layouts.main2')

@section('title')
Cart
@endsection

@section('content')
 <?php 
 if (Auth::check()) {
  $wall_amount = Crypt::decrypt(Auth::user()->wall_am);
 }else {
  $wall_amount = 0;
 }
   
    $amount = 0;
    if (count($cart)==0) {
      $getid=0;
    }
?>
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
                               
                                $services = "";
                                $price = 0;
                                $tax_amount = 0;
                             
                          ?>
                         
                        <?php foreach($cart as $key => $value): ?>
                          <?php 
                            $getid = $value['unit_id'];
                            //echo $getid;
                          ?>
                          <?php
                              if (count($cart)==1) {
                                $services = $value['item_name'];
                              }else {
                                $services .= $value['item_name'].",";
                              }
                             
                          ?>
                          <tr>
                          <td><table><tr><td><a href="<?= URL::to('food_cart/remove_item/'.$key) ?>"><img src="{{ asset('public/images/cross.jpg') }}" class="remove" data="<?= $key ?>"></a></td>
                           <td style="font-size: 13px;"><div class="desktoptxt"><strong><?= $value['item_name'] ?><br />

                          

                         </strong>
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
                echo '<div style="font-size:12px;margin-left:5px;"><span style="color:#000;" class="customize" data="'.$value['item_id'].'"> Customize <i class="fa fa-chevron-down" style="color:green;"></i></span> </div>';
              } 
           ?><br />
                            

                            </div></td>
                          </tr></table>
                           </td>
                          <td style="text-align: center;"><span class="orangetext"><i class='fa fa-inr'></i>  <?= $value['price'] ?></span><br />
                              <input type="number" name="quantity" value="<?= $value['quantity'] ?>" class="quantity" min="1">
                          <input type="hidden" class="item_id" value="<?= $value['item_id'] ?>">
       <input type="hidden" class="price" value="<?= Helper::get_menu_item_price($value['item_id']) ?>">  
       <input type="hidden" class="nquantity" value="<?= $value['quantity'] ?>">   
                         
                          
                         
                           </td>
                           </tr>
                           <?php 
                           



                                
                                 $price += $value['price'];
                                 $tax_amount = round($price * 18 /100);
                                  $amount = $price + $tax_amount + $customprice;
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
                        
                       echo number_format($amount) 

                       ?></span><br /><br />
                      
                      
                      <?php endif; ?>
                          </div>
                          <div class="col-md-6 continueshopping" style="text-align: right;">
                            <a href="{{ URL::to('/') }}"><button name="addtocart" type="button" class="addtocart btn" style="width: 200px;"> Continue Shopping</button></a>
                            <div style="margin-top: 20px;width: 220px;float: right;">
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
  
  
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">

    <div id="home" class="container tab-pane active"><br>
      <form action="{{ URL::to('foodcart/checkout') }}" method="post" class="checkoutform" id="checkoutform">
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <div class="form-group">
          <div class="" style="font-size: 13px;">Name<span style="color: red;">*</span></div>
          @if(Auth::check())
          <input type="text" name="name"  class="form-control" value="{{ Auth::user()->name }}" required="required" readonly="readonly">
         @else
         <input type="text" name="name"  class="form-control" required="required">
         @endif
       </div>
        <div class="form-group">
          <div class="" style="font-size: 13px;">Phone<span style="color: red;">*</span></div>
           @if(Auth::check())
           <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required="required" readonly="readonly">
          @else
         <input type="text" name="phone" class="form-control"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required="required">
         @endif
       </div>
       <div class="form-group">
        <?php if(count($cart) > 0): ?>
          <input type="hidden" name="amount" value="<?= Crypt::encrypt($amount) ?>">
        <input type="hidden" name="services" value="Food Order">
        <input type="hidden" name="payment_method" value="instamojo" class="payment_method">
      <?php endif; ?>
          
           @if(Auth::check())
            @if(Auth::user()->type=="manager")
            <div class="" style="font-size: 13px;">Email</div>
         <input type="text" name="email"  class="form-control" value="" >
          @else
          <div class="" style="font-size: 13px;">Email<span style="color: red;">*</span><a href="{{ URL::to('profile') }}" style="float: right;">Change</a></div>
          @if(Auth::user()->email != "")
       <input type="text" name="email"  class="form-control" value="{{ Auth::user()->email }}" required="required" readonly="readonly">
       @else
        <input type="text" name="email"  class="form-control" value="{{ Auth::user()->email }}" required="required">

        @endif
         @endif
          @else
          <div class="" style="font-size: 13px;">Email<span style="color: red;">*</span></div>
         <input type="text" name="email"  class="form-control"  required="required">
         @endif
       </div>
      

         <div class="form-group">
          <?php if(Auth::check()): ?>
       <button type="submit" class="btn checkoutbtn2"> Check-out</button>
       <?php else: ?>
        <button type="submit" class="btn checkoutbtn"> Check-out</button>
       <?php endif; ?>
       </div>
     </form>
      
    </div>
    
    <div id="menu1" class="container tab-pane fade"><br>
     <form action="{{ URL::to('clogin') }}" method="post" class="checkoutform">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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

    <!-- Modal -->
<div class="modal fadeUp" id="customizeModal" data-easein="bounceIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
  <form method="post" action="<?= URL::to('update_cart') ?>">
  @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Ons</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="addonfields"></div>
      </div>
      <div class="modal-footer">
        
        <button type="submit" class="btn btn-primary">Update Cart</button>
      </div>
    </div>
  </div>
  <input type="hidden" name="item_id" value="" class="item_id">
 <input type="hidden" name="titles"  value="" class="titles">
</form>
</div>
 <!-- The Modal -->
<div id="myModal2"  class="modal fadeUp">
 <div class="modal-dialog modal-dialog-centered" role="document">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="">
      <span class="close"  data-dismiss="modal">&times;</span>
      
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
     
     <div style="padding-left: 10px;padding-right: 10px;width: 100%;"><button type="submit" class="btn checkoutbtnn " style="width: 100%;"> Pay Now</button></div> 
    
      </div>
      
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
.checkoutbtnn {
background-color: #EF9E11;
    border-color: #EF9E11;
    width: 100%;
    font-size: small;
    color: #FFF;
    padding: 10px;
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
</style>

<script type="text/javascript">
  $(function() {
    $(".checkoutbtn2").click(function() {
      $("#myModal2").modal("show");
      return false;
    });
    $(".checkoutbtnn").click(function() {
        var selected = $(".payment_mode:checked").val();  
         $(".payment_method").attr('value',selected); 
         $("#checkoutform").attr('action','{{ URL::to("food_cart/checkout") }}');
          $("#checkoutform").submit();
    });
    $(".checkoutbtn").click(function() {
       var selected = $(".payment_mode:checked").val();
       $(".payment_method").attr('value',selected); 
       if (selected=="paytm") {
           $(".checkoutform").attr('action','{{ URL::to("food_cart/checkout") }}');
           $(".checkoutform").submit();
       }else {
        $(".checkoutform").attr('action','{{ URL::to("food_cart/checkout") }}');
       $(".checkoutform").submit();
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
                '_token':'{{ csrf_token()}}',
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
  <script>
    $(document).ready(function() {
     
        $('#pincode-input1').pincodeInput({
            hidedigits: true,
            complete: function(value, e, errorElement) {
              

               $(".pinno").attr('value',value);


            }
        });
        var cart_count = "<?= count($cart) ?>";

        if (cart_count!=0) {
          var initialdata = <?= Helper::get_unit_menu_data($getid) ?>;
         var addonfields = "";
         var titles = "";
         $(".customize").click(function() {
            var data = $(this).attr('data');
              addonfields = "";
             $.each(initialdata, function(i,v) {
                       if (v['item_id']==data) {
                           addonfields += "<h5>" + v['addon_title'] + "</h5>";
                           
                           
                           titles+=  v['addon_title'];


                           var customize = v['customize'];
                           var type = v['addon_type'];
                           if (customize=="") {

                           }else {
                            $.each(customize, function(m,n) {
                               if (type=="radio") {
                                if (m==0) {
                                  addonfields += '<input type="radio"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'" checked="checked"> '+n['addon_name']+' <span style="font-size:11px;"> (Rs. '+n["cost"]+')</span><br />';
                                }else {
                                   addonfields += '<input type="radio"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'"> '+n['addon_name']+' <span style="font-size:11px;"> (Rs. '+n["cost"]+')</span><br />';
                                }
                                
                               }else {
                                if (m==0) {
                                   addonfields += '<input type="checkbox"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'" checked="checked"> '+n['addon_name']+'<span style="font-size:11px;"> (Rs. '+n["cost"]+')</span><br />';
                                }else {
                                    addonfields += '<input type="checkbox"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'"> '+n['addon_name']+'<span style="font-size:11px;">  (Rs. '+n["cost"]+')</span><br />';

                                }
                               
                               }
                               
                           });
                             $("#customizeModal .addonfields").html(addonfields);
                             $("#customizeModal").modal("show");
                             $(".item_id").val(data);
                             $(".titles").val(titles);
                           }
                           
                           
                       }
                    });
         });
        }
          
    });
    </script>
@endsection