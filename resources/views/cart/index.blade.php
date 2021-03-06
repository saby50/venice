@extends('layouts.main2')

@section('title')
Cart
@endsection

@section('content')

<?php 
$applied_coupon = "no";
if (Auth::check()) {
  $wall_amount = Crypt::decrypt(Auth::user()->wall_am);
 }else {
  $wall_amount = 0;
 }
  $amount = 0;
  $disamount = "";
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
                            <h3>Your Cart</h3><br />

                       

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
                    			<td><table><tr><td><a href="<?= URL::to('cart/remove_item/'.$key) ?>" style="top: 10px;position: relative;"><img src="{{ asset('public/images/cross.jpg') }}" class="remove" data="<?= $key ?>"></a> 
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

                           
                             if ($value['is_coupon_applied']=="yes") {
                             //  $cmatch = explode(",", $coupon['match']);
                               if ($coupon['match']==$match) {
                                if ($value['quantity']==1) {
                                  $discountamount = $bamount * $coupon['coupon_percent'] /100;
                                  $discountprice = $bprice * $coupon['coupon_percent'] /100;
                                  $discounttax = $btax * $coupon['coupon_percent'] /100;
                                  $bamount = $value['amount'] - $discountamount;
                                  $bprice = $value['price'] - $discountprice;
                                  $btax = $value['tax'] - $discounttax;
                                  $applied_coupon = $value['is_coupon_applied'];
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
                                   $applied_coupon = $value['is_coupon_applied'];
                                  

                                }
                               }
                               

                             }
                            
                             $disamount.= $discountamount.",";
                              

                            

                            
                          
                         ?></td><td><div class="col-md-4"><img src="<?= $value['icon'] ?>" width="65px" style="border: solid 1px #ccc;"></div><br /><div class="mobiletxt"><strong>
                         <?= $value['service_name']  ?><?php if($value['canal']): ?>
                           
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
                    			<td style="text-align: center;"><span class="orangetext">  <?php 
                                if ($value['is_coupon_applied']=="yes") {
                                  echo "<strike><i class='fa fa-inr'></i>".$value['amount']."</strike>&nbsp; &nbsp;<i class='fa fa-inr'></i> ".$bamount;
                                }else {
                                  echo "<i class='fa fa-inr'></i>".$bamount;
                                }
                          ?></span><br />
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
                          



                                 $amount += $bamount;
                                 $price += $bprice;
                                 $tax_amount += $btax;
                                 
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
                          if ($applied_coupon=="yes") {
                             
                            echo ' <span style="font-size: 14px;">Coupon:</span> <span class="orangetext"> ';

                            echo $coupon['coupon_code'];

                            echo ' </span> <a href="'.URL::to('remove_coupon').'">remove</a><br />';

                          }


                         ?>
                      <span style="font-size: 14px;">Total:</span> <span class="orangetext" style="font-size: 20px;font-weight: bold;"><i class='fa fa-inr'></i>  <?php
                        

                       echo number_format($amount) 

                       ?></span><br /><br />
                     
                      
                      <?php endif; ?>
                          </div>
                          <div class="col-md-6 continueshopping" style="text-align: right;">
                            <a href="{{ URL::to('/') }}"><button name="addtocart" type="button" class="addtocart btn" style="width: 200px;"> Continue Shopping</button></a>
                           


                          </div>
                          <?php if(!empty($cart)): ?>
                          @if(Auth::check())
                          <?php
                            $coupons = Helper::get_available_coupons(Auth::user()->phone);
                          ?>
                            <div class="col-md-12">
              
                    
                        <form method="post" action="{{ URL::to('apply_coupon') }}" style="margin-left: 0px;margin-right: 0px;margin-top: 40px;">
                          @csrf
                          <label><strong>Select Coupon</strong></label>
                          <select name="coupon_code" class="form-control" style="margin-bottom: 20px;">
                              <option value=""></option>
                            <?php foreach ($coupons as $key => $value): ?>
                              <?php if($applied_coupon=="yes"): ?>
                              <?php if ($coupon['coupon_code']==$value['coupon_code']): ?>
                                <option value="<?= $value['coupon_code'] ?>" selected="selected"><?= $value['coupon_code'] ?></option>
                              <?php else: ?>
                                  
                              <option value="<?= $value['coupon_code'] ?>"><?= $value['coupon_code'] ?></option>
                              <?php endif; ?>

                              <?php else: ?>
                                <option value="<?= $value['coupon_code'] ?>"><?= $value['coupon_code'] ?></option>


                              <?php endif; ?>
                          
                            <?php endforeach; ?>
                            
                          </select>
                       
                       <?php  if ($applied_coupon=="yes"): ?>
                        <button type="submit" class="btn checkoutbtn"> Coupon Already Applied!</button>
                        <?php else: ?>
                           <button type="submit" class="btn checkoutbtn"> Apply Coupon</button>

                        <?php endif; ?>

                      </form>
                      <div style="margin-top: 20px;">
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
        @if (session('warning'))
        <div class="widget no-color">
            <div class="alert alert-warning">
                <div class="notify-content">
                   {{ session('warning') }}!

                </div>
            </div>
            </div>
        </div>
      @endif
      </div>
      @endif
    <?php endif; ?>
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
    @if(!Auth::check())
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu1">Login</a>
    </li>
    @endif
  
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">

    <div id="home" class="container tab-pane active"><br>
     <form action="{{ URL::to('cart/checkout') }}" method="post" class="checkoutform" id="checkoutform">
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <?php
         $coupon = Session::get('coupon');
       ?>
      <?php if ($applied_coupon=="yes"): ?>
         <input type="hidden" name="coupon_id" value="<?= Helper::get_coupon_id($coupon['coupon_code']) ?>">
         <input type="hidden" name="discountamount" value="<?= rtrim($disamount,",") ?>">
      <?php endif; ?>
       <div class="form-group">
          <div class="" style="font-size: 13px;">Name<span style="color: red;">*</span></div>
          @if(Auth::check())
          @if(Auth::user()->type=="manager")
         <input type="text" name="name"  class="form-control" value="" required="required">
         @else
        <input type="text" name="name"  class="form-control" value="{{ Auth::user()->name }}" required="required" readonly="readonly">
         @endif
         @else
         <input type="text" name="name"  class="form-control" required="required">
         @endif
       </div>
        <div class="form-group">
          <div class="" style="font-size: 13px;">Phone<span style="color: red;">*</span></div>
           @if(Auth::check())
           @if(Auth::user()->type=="manager")
         <input type="text" name="phone" class="form-control"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required="required">
          @else
       <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required="required" readonly="readonly">
         @endif
          @else
         <input type="text" name="phone" class="form-control"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required="required">
         @endif
       </div>
       <div class="form-group">
        <?php if(count($cart) > 0): ?>
        <input type="hidden" name="amount" value="<?= Crypt::encrypt($amount) ?>">
        <input type="hidden" name="services" value="<?= rtrim($services,",") ?>">
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
             <input type="hidden" name="payment_method" class="payment_method" value="instamojo">

         <div class="form-group">
          <?php if($amount==0): ?>

             <button type="submit" class="btn checkoutbtn"> Check-out</button>
            <?php else: ?>
         <?php if(Auth::check()): ?>
         <button type="submit" class="btn checkoutbtn2"> Check-out</button>
         <?php else: ?>
          <button type="submit" class="btn checkoutbtn"> Check-out</button>
         <?php endif; ?>
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
         
         <button type="submit" class="btn checkoutbtn3"> Login</button>
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
.checkoutbtn3 {
  width: 100%;
  color: #FFF;
  padding: 10px;
}
.checkoutbtnn {
background-color: #EF9E11;
    border-color: #EF9E11;
    width: 100%;
    font-size: small;
    color: #FFF;
    padding: 10px;
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
<script type="text/javascript">
  $(function() {
    $(".checkoutbtn2").click(function() {
      $("#myModal2").modal("show");
      return false;
    });
     $(".checkoutbtnn").click(function() {
        var selected = $(".payment_mode:checked").val();  
         $(".payment_method").attr('value',selected); 
         $("#checkoutform").attr('action','{{ URL::to("cart/checkout") }}');
          $("#checkoutform").submit();
    });
    $(".checkoutbtn").click(function() {
       var selected = $(".payment_method:checked").val();
       if (selected=="paytm") {
          $(".checkoutform").attr('action','{{ URL::to("paytm") }}'); 
          return true;
       }else {
        $(".checkoutform").attr('action','{{ URL::to("cart/checkout") }}');
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
                 '_token':'{{ csrf_token()}}',
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
@endsection