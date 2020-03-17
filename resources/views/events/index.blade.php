@extends('layouts.main2')

@section('title')
<?= $data[0]->event_name ?>
@endsection
@section('includes')
<meta property="og:title" content="The Grand Venice Mall | <?= $data[0]->event_name ?>">
<meta property="og:description" content="<?= $data[0]->teaser_line_1 ?> <?= $data[0]->teaser_line_2 ?>">
<meta property="og:image" content="<?= asset('public/uploads/forground/'.$data[0]->forground) ?>">
@endsection
@section('content')
<?php 
if (Auth::check()) {
   $wall_amount = Crypt::decrypt(Auth::user()->wall_am);
} 
    $teaser_line_1 = "";
    $teaser_line_2 = "";
    $description = "";
    $background = "";
    $event_date = "";
    $duration = "";
     $video_icon = "";
    $totime = "";
    $fromtime = "";
    $forground = "";
    $service_name = "";
    $icon = "";
    $event_alias = "";
    $mobile_banner = "";
    $videotype = "";
    $link = "";
    $video = "";
    $tax_percent = "";
    $minimum_quantity = 0;
    $rate_type = "";
    $stag_entry = "";
    $couple_entry = "";
    $family_entry = "";
    $finalamount = 0; $taxamount = 0;   
   foreach ($data as $key => $value) {
    $teaser_line_1 = $value->teaser_line_1;
    $teaser_line_2 = $value->teaser_line_2;
    $description = $value->event_description;
    $background = $value->background;
    $time = $value->start_time;
    $startdate = $value->start_date;
    $enddate = $value->end_date;
    $starttime = $value->start_time;
    $endtime = $value->end_time;
    $tax_percent = $value->tax_percent;
    $forground = $value->forground;
     $video_icon = $value->video_icon;
    $event_name = $value->event_name;
    $price = $value->event_price;
    $event_alias = $value->event_alias;
    $mobile_banner = $value->mobile_banner;
    $rate_type = $value->rate_type;
    $minimum_quantity = $value->minimum_quantity;
    $stag_entry = $value->stag_entry;
    $family_entry = $value->family_entry;
    $couple_entry = $value->couple_entry;
    $videotype = $value->videotype;
    $link = $value->link;
   }

   $edates = ""; $etime="";
   $lastdate = "";
   foreach ($eventdates as $key => $value) {
      $edates .= '"'.date('d-n-Y',strtotime($value->event_date)).'",';
      $etime = $value->event_time;
      $lastdate = $value->event_date;
   }
   

   $edates = rtrim($edates,',');


   
   $finalamount = 0;
   $taxamount = ceil($price * $tax_percent / 100);
   if ($rate_type=="yes") {
    $finalamount = $price;
     $price = $price - $taxamount;
     
   }else {
     $finalamount = $price + $taxamount;
   }
   
   $todaydate = date('d-m-Y');
   $event = 0;
   if (strtotime($todaydate) <= strtotime($lastdate)) {
       $event = 1;
   }

   $finalamount =  $finalamount * $minimum_quantity;
   $price = $price * $minimum_quantity;
   $taxamount = $taxamount * $minimum_quantity;


?>

<?php if (Helper::check_mobile()=="1"): ?>
 <section id="hero" class="otherhero" style="margin-top: 130px !important;">
    <?php else: ?>
        <section id="hero" class="otherhero">
    <?php endif; ?>
        <div class="hero-container ">
            <img src="<?= asset('public/uploads/mobile_banner/'.$mobile_banner) ?>" class="mobile" style="margin-top: -40px;">
        </div>
        
    </section><!-- #hero -->
    <!-- booking form step 1/3  start -->
    <a name="bookingform"></a>
    <div class="booking-form" style="display: block;">
        <div class="loader"></div>

        <div class="head" style="padding-bottom: 10px;">
            
            <h4><?= $event_name ?></h4>
        </div>
        <?php if($finalamount==0): ?>
          <form class="row" action="{{ URL::to('events/send') }}" method="post">

        <?php else: ?>
         <form class="row" action="{{ URL::to('events/checkout') }}" method="post">
        <?php endif; ?>
        
            @csrf
            <input type="hidden" name="event_name" value="<?= $event_name ?>">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="date"><?php if(count($eventdates)==1): ?>
                       <span style="font-weight: normal;"><?= date('l, F j Y',strtotime($lastdate)) ?> (<?= $time ?>)</span>
                        <input type="hidden" class="form-control datepicker2" placeholder="----" value="<?= $eventdates[0]->event_date ?>" readonly>
                        <?php else: ?>
                            <?= date('l, F j Y',strtotime($lastdate)) ?> (<?= $time ?>)
                            <input type="hidden" class="form-control datepicker2" id="datepicker" placeholder="----" value="<?= $eventdates[0]->event_date ?>" readonly>
                      <?php endif; ?></label>
                      <div class="" style="font-size: 11px;">
                        <?php if($stag_entry=="yes"): ?> 
                            <i class="fa fa-check" aria-hidden="true" style="color: green;"></i> Stag Entry
                        <?php else: ?>
                            <i class="fa fa-times-circle" aria-hidden="true" style="color: red;"></i>  Stag Entry
                        <?php endif; ?>
                        &nbsp;&nbsp;
                                <?php if($couple_entry=="yes"): ?> 
                            <i class="fa fa-check" aria-hidden="true" style="color: green;"></i> Couple Entry
                        <?php else: ?>
                            <i class="fa fa-times-circle" aria-hidden="true" style="color: red;"></i>  Couple Entry
                        <?php endif; ?>
                         &nbsp;&nbsp;
                             <?php if($family_entry=="yes"): ?> 
                            <i class="fa fa-check" aria-hidden="true" style="color: green;"></i> Family Entry
                        <?php else: ?>
                            <i class="fa fa-times-circle" aria-hidden="true" style="color: red;"></i>  Family Entry
                        <?php endif; ?>
                      </div>
                    <div class="input-group">
                      
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
               
                <div class="form-group">
                   <input type="hidden" name="services" value="1">
                    @if(Auth::check())

                    <input type="text" class="form-control name" name="name" value="{{ Auth::user()->name }}" placeholder="Name" required="required" readonly="readonly">
                    @else
                    <input type="text" class="form-control name" name="name" placeholder="Name" required="required">
                    @endif
                </div>
                 <div class="form-group">
                     @if(Auth::check())
                    <input type="text" class="form-control phone" name="phone" placeholder="Phone" value="{{ Auth::user()->phone }}" required="required" onkeypress="return event.charCode >= 48 && event.charCode <= 57" readonly="readonly">
                    @else
                    <input type="text" class="form-control phone" name="phone" placeholder="Phone" required="required" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                     @endif
                    <input type="hidden" class="event_name" value="<?= $event_name ?>">
                    <input type="hidden" class="event_alias" value="<?= $event_alias ?>">
                   <input type="hidden" class="event_time" value="<?= $starttime ?>">
                </div>
                <div class="form-group">
                @if(Auth::check())
                    <input type="email" class="form-control email" name="email" value="{{ Auth::user()->email }}" aria-describedby="emailHelp" placeholder="Email" required="required" readonly="readonly">
                    @else
                    <input type="email" class="form-control email" name="email" aria-describedby="emailHelp" placeholder="Email" required="required">
                   @endif 
                     
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="time">Quantity</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number minus"  disabled="disabled" data-type="minus" data-field="quant[1]">
                                        <span class="fa fa-minus"></span>
                                    </button>
                                </span>

                                <input type="text" name="quant[1]" class="form-control input-number quantity" value="<?= $minimum_quantity ?>" min="<?= $minimum_quantity ?>" max="10">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number plus" data-type="plus" data-field="quant[1]">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" style="">
                        <div class="input-group margin-bottom-sm price-box" style="width: 100%; margin: 0;background: #FFF;">
                          <span class="input-group-addon rupeeicon"><i class="fa fa-rupee fa-lg"></i> </span> 
                            <input type="text" class="form-control" id="price" value="<?= $finalamount  ?>" name="amount" placeholder="&#x20B9; ----" readonly="readonly" style="background: #FFF;">

                        </div>
                       <div class="pricetaxbox"> Price: <span class="mprice"><?= $price ?></span> |  GST: <span class="tax"><?= $taxamount ?></span>
                      <input type="hidden" class="ffa" value="">  <input type="hidden" class="pprice" value="<?= $price ?>"><input type="hidden" class="taxes" value="<?= $taxamount ?>"></div>
                    </div>
                </div>
                <br />
                <div class="form-group">
                    <input type="checkbox" name="agreement" checked="checked" class="agreement"> I agree to the <a href="{{ URL::to('event/gudgudi-terms-conditions') }}" style="font-size: 15px;color: #ef9e11;" target="_blank">Terms and Conditions</a>
                    
                </div>

                <div class="form-group">
                    <?php if($event==1): ?>
                        <?php if($finalamount==0): ?>
                             <button name="addtocart" type="submit" class="buynow btn" style="width: 100% !important;"><span> Check Out</span></button>

                        <?php else: ?>
                            <?php if(Auth::check()): ?>
                             <button name="addtocart" type="submit" class="buynow btn checkout" style="width: 100% !important;"><span> Check Out</span></button>
                             <?php else:?>
                                  <button name="addtocart" type="submit" id="checkout" class="buynow btn checkout" style="width: 100% !important;"><span> Check Out</span></button>
                             <?php endif; ?>
                        <?php endif; ?>

                  
                   <?php else: ?>
                    <div class="alert alert-danger"> Sorry this event is closed!</div>
               <?php endif; ?>
                    
                </div>
            </div>
        </form>
    </div>
    <!-- booking form step 1/3  end -->
    <!-- booking form step 2/3  start -->
    <div class="booking-form" style="display: none;">
        <div class="head">
            <p class="step">Step 2/3</p>
        </div>
        <form class="row">
            <div class="col-sm-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab1" href="javascript:;">Express Check-out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab2" href="javascript:;">Login</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content mt-4">
                    <div class="tab-pane container active" id="tab11">
                        <div class="form-group">
                            <label for="name">Name<span class="required">*</span></label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone<span class="required">*</span></label>
                            <input type="text" class="form-control" id="phone">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <a href="javascript:;" class="btn">Check-out</a>
                        </div>
                    </div>
                    <div class="tab-pane container" id="tab22">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone">
                        </div>
                        <div class="form-group">
                            <label for="pincode-input1">Pin</label><br>
                            <input type="text" id="pincode-input1">
                        </div>
                        <div class="form-group">
                            <a href="javascript:;" class="btn">Login</a>
                        </div>
                        <div class="form-group text-center">
                            <a href="javascript:;" style="background-color: #fff; color: #000; text-decoration: underline;">Forgot PIN?</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- booking form step 2/3  end -->
    <!-- booking form step 3/3  start -->
    <div class="booking-form" style="display: none;">
        <div class="head">
            <p class="step">Step 3/3</p>
            <h4>Review Your Order</h4>
            <br />
            <p>Dear <span style="color:#EF9E11; ">User Name</span>, your order details are:</p>
        </div>
        <form class="row">
            <div class="col-sm-12">
                <p>Day : ----</p>
                <p>Arrival Time:----</p>
                <p>Number Of Seats:----</p>
                <div class="form-group price-box mt-5">
                    <input type="text" class="form-control" id="price" placeholder="&#x20B9; ----">

                </div>
                <div class="form-group mt-5">
                    <a href="javascript:;" class="btn">Pay Now</a>
                </div>
            </div>
        </form>
    </div>
    <!-- booking form step 3/3  end -->
    <!-- booking form retry start -->
    <div class="booking-form" style="display: none;">
        <div class="head mt-5" style="text-align: center;">
            <img style="height: 30vh;" src="{{ asset('public/images/Oops.png') }}" alt="Oops..">
        </div>
        <form class="row">
            <div class="col-sm-12">
                <p class="text-center">Looks like something went wrong.</p>
                <p class="text-center">Please try again.</p>
                <br />
                <div class="form-group">
                    <a href="javascript:;" class="btn">Retry</a>
                </div>
            </div>
        </form>
    </div>
    <!-- booking form retry end -->
    <!-- booking form success start -->
    <div class="booking-form" style="display: none;">
        <div class="head mt-5" style="text-align: center;">
            <img style="height: 30vh;" src="{{ asset('public/images/Yeahh.png') }}" alt="Yeahhh..">
        </div>
        <form class="row">
            <div class="col-sm-12">
                <p class="text-center">Payment has been successfully done.</p>
                <p class="text-center">Please try again.</p>
                <br />
                <div class="form-group">
                    <a href="javascript:;" class="btn">Retry</a>
                </div>
            </div>
        </form>
    </div>
    <!-- booking form success end -->
    <main id="main">
         <!--==========================
      About Section
    ============================-->
        <section id="about" class="aboutarea">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-12">
                        <?php if(Helper::check_mobile()==1): ?>
                        
                          <?php if($videotype=="video"): ?>
                        <iframe width="100%" height="250" class="youtube-video" src="<?= $video ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                        <?php else: ?>
                        <a href="<?= $link ?>" target="_blank"><img src="<?= asset('public/uploads/vidicon/'.$video_icon) ?>"></a>
                        <?php endif; ?>

                        <?php else: ?>
                        
                        <?php if($videotype=="video"): ?>
                        <img src="<?= asset('public/uploads/vidicon/'.$video_icon) ?>">
                        <a href="javascript:;" class="modalclick" data-toggle="modal" data-target="#myModal"><img src="{{ asset('public/images/home/Video-Play-Btn.png') }}" class="img-responsive center playBtn" style="height: auto;"></a>
                        <?php else: ?>
                        <a href="<?= $link ?>" target="_blank"><img src="<?= asset('public/uploads/vidicon/'.$video_icon) ?>"></a>
                        <?php endif; ?>
                        <?php endif; ?>
                          
                        
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="section-header">
                             <h2 class="section-title"><?= $teaser_line_1 ?></h2>
                            <h3><?= $teaser_line_2 ?></h3>
                          
                      <p><?= $description ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- #About -->
        <!--==========================
      Gallery Section
    ============================-->
        <section id="gallery">
           <div class="container-fluid">
                <div class="row">
                    <?php if(Helper::check_mobile()==1): ?>
                        <div style="width: 100%;overflow-x: scroll;height: 250px;position: relative;">
                         <ul class="mobile-slider2">
                         <?php foreach($gallery as $key => $value): ?>
                   
                        <li>
                            <img src="<?= asset('public/uploads/gallery/'.$value->img_name) ?>">
                        </li>
                    
                <?php endforeach; ?>
                </ul>
                </div>
                        <?php else: ?>
                            <?php foreach($gallery as $key => $value): ?>
                            <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;">
                                <div class="pic1">
                                    <img src="<?= asset('public/uploads/gallery/'.$value->img_name) ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
            <?php endif; ?>
                   
                </div>
            </div>

</section>
<!--==========================
      featured Section
    ============================-->
         <section id="featured" class="innerfeatured" style="margin-top: 60px;">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 featured_content">
                        <div class="section-header">
                            <h2 class="section-title">Customers</h2>
                            <h3 style="text-align: center;">Also Bought</h3>
                        </div>
                    </div>
                </div>
                  <div class="row mt-4">
                    <div class="col-sm-12">
                        <div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="9000" style="">
                            <div class="carousel-inner row w-100 mx-auto" role="listbox">
                                <?php foreach($featured as $key => $value): ?>
                                <div class="carousel-item col-md-3  active">
                                    <div class="panel panel-default">
                                        <div class="panel-thumbnail">
                                                <img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured/'.$value->featured_image) ?>" alt="slide 1">
                                            <div class="title">
                                                <p><?= $value->service_name ?></p>
                                            </div>
                                            <div class="desc" style="text-align: center;">
                                                <?php $short = $value->short_description;
                                                     echo Helper::truncate($short,60);
                                                 ?>
                                            </div>
                                            <div class="price" style="text-align: center;margin-top: 20px;">
                                               
                                                <a href="<?= URL::to('booking/'.$value->alias) ?>" class="btn btn-info">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                             
                           </div>
                            <?php endforeach; ?>
                              <?php foreach($featured2 as $key => $value): ?>
                               <div class="carousel-item col-md-3  active">
                                    <div class="panel panel-default">
                                        <div class="panel-thumbnail">
                                                <img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured/'.$value->featured_image) ?>" alt="slide 1">
                                            <div class="title">
                                                <p><?= $value->pack_name ?></p>
                                            </div>
                                            <div class="desc" style="text-align: center;">
                                                <?php $short = $value->short_description;
                                                     echo Helper::truncate($short,60);
                                                 ?>
                                            </div>
                                            <div class="price" style="text-align: center;margin-top: 20px;">
                                               
                                                <a href="<?= URL::to('packs/'.$value->alias) ?>" class="btn btn-info">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                             
                           </div>
                            <?php endforeach; ?>
                               
                               
                            </div>
                        
                        </div>
                        
                    </div>
                </div>
            </div>
        </section><!-- #featured -->
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
    <div class="modal fade" id="paymentModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <label>Select Payment Method</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>
          <div class="modal-body">
            <div class="content">
                <div class="row">
                <div class="col-5"> <label> <input type="radio" name="payment_mode" class="payment_mode" checked="checked" value="instamojo" style="position: relative;top:2px;">  <img src="<?= asset('public/images/instamojo.JPG') ?>" class="payment_method2" style="width: 80px;"></label><br /></div>
      <?php if(Auth::check()): ?>
      <?php if($wall_amount!=0 && $wall_amount >= $finalamount): ?>
    <div class="col-7" style="font-size: 12px;"><label> <input type="radio" name="payment_mode" class="payment_mode" value="wallet" style="position: relative;top:2px;"> <img src="<?= asset('public/images/gv_pocket.JPG') ?>" class="payment_method2" style="width: 60px;"> (<i class="fa fa-rupee"></i> <?= $wall_amount ?>)</label><br /></div>
    <script type="text/javascript">
     $(document).ready(function() {
       $(".checkout").click(function() {
        $("#paymentModal").modal("show");
         return false;
       });
    });
    
</script>
     <?php endif; ?>
          <?php endif; ?>
            </div>
            </div>
          </div>
          <div class="modal-footer">

           
             <button type="submit" class="buynow btn checkoutbtn" id="checkout">Submit</button>
          </div>
        </div>
      </div>
    </div>
     <div id="myModal" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
      <iframe width="750" height="400" class="youtube-video" src="https://www.youtube.com/embed/PddSUho7PeI?start=2" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
      </div>
    </div>

  </div>
</div>
  <script type="text/javascript">
      $(function() {
        $(".modalclick").click(function() {
           $('#myModal').modal({backdrop: 'static', keyboard: false});
               $('.youtube-video').attr('src','<?= $video ?>?autoplay=1');
              
        });
        $("#myModal .close").click(function() {
           $('.youtube-video').attr('src','<?= $video ?>');
        });
      });
    </script>
@include('include/subfooter')
<style type="text/css">
#hero {
  width: 100%;
  height: 100vh;
  background: url(<?= asset('public/uploads/forground/'.$forground) ?>) no-repeat;
  background-size: contain;
  position: relative;
  margin-top: -80px;
}
@media (max-width: 425px){
#hero {
  background: none;

}
#hero .hero-container {
    display: block;
}
}
.timepicker {
        padding: .375rem .75rem !important;
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
#datepicker {
    background: #FFF;
}
#timepicker {
    background: #FFF;
}
@media (max-width: 425px) {
#main {
    margin-top: 770px !important;
}    
}

</style>
<?php 
    $tax_percent = "";
    $rate_type = "";
    $finalamount = 0; $taxamount = 0;   
   foreach ($data as $key => $value) {
    $price = $value->event_price;
    $tax_percent = $value->tax_percent;
  
    $rate_type = $value->rate_type;
   }
   ?>
<script type="text/javascript">

   
    if ($(".agreement").is(':checked')) {
      $("#checkout").prop('disabled',false);
    }else {
        $("#checkout").prop('disabled',true);
    }
$(".agreement").change(function() {
    if ($(".agreement").is(':checked')) {
      $("#checkout").prop('disabled',false);
    }else {
        $("#checkout").prop('disabled',true);
    }
});

      var today, datepicker;  
var availableDates = [<?= $edates ?>];

function available(date) {
  dmy = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
  if ($.inArray(dmy, availableDates) != -1) {
    return [true, "","Available"];
  } else {
    return [false,"","unAvailable"];
  }
}
    $('#datepicker').datepicker({
         modal: true,
         header: true,
         footer: true,
         uiLibrary: 'bootstrap4',
         dateFormat: 'dd-mm-yy',
         beforeShowDay: available, 
         onSelect: function(dateText) {
         setTimeout( function() { $('.loader').show(); }, 100 );
         setTimeout( function() { $('.loader').hide(); }, 600 );
            var url = '<?= URL::to("get_time/'+dateText+'/1") ?>';
              $.ajax({
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
        $('.event_time').val(result);
         
        }
     })
         }
     });
    $(document).ready(function() {
       $("#checkout").click(function() {
           var name = $('.name').val();
           var email = $('.email').val();
           var phone = $('.phone').val();
           var payment_mode = $(".payment_mode:checked").val();
            if (name != "" && email != "" && phone != "") {
             if (validateEmail(email)) {
                 var event_name = $('.event_name').val();
              var event_date = $('.datepicker2').val();
              var quantity = $('.quantity').val();
              var event_alias = $('.event_alias').val();
              var amount = $('#price').val();
              var price = $('.pprice').val();
              var taxes = $('.taxes').val();
              var event_time = $('.event_time').val();
              var formData = {
                '_token':'{{ csrf_token()}}',
                'event_name': event_name,
                'event_date': event_date,
                'quantity': quantity,
                'event_alias': event_alias,
                'event_time': event_time,
                'amount': amount,
                'price': price,
                'tax_amount': taxes,
                'name': name,
                'email': email,
                'phone': phone
             };

             var url = '<?= URL::to("events/add_event") ?>';   
            $.post(url,  formData,
            function (resp,textStatus, jqXHR) {
                //Show Message
                window.location = '<?= URL::to('echeckout') ?>/'+payment_mode;
            });
        }else {
               $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Please enter a valid email address!");
        }
            }else {
                 $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Please fill all the required fields!");
           

            }
            
            return false;

       });
    });
    $('.btn-number').click(function(e) {
        e.preventDefault();

        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        setTimeout( function() { $('.loader').show(); }, 100 );
         setTimeout( function() { $('.loader').hide(); }, 600 );
         
         var quantity = 1;
         if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                    
                     quantity = currentVal - 1;
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                     $(".minus").attr('disabled',false);
                    quantity = currentVal + 1;
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }

        } else {
            input.val(0);
        }
        var price = '<?= $price ?>';
        var rate_type = '<?= $rate_type ?>';
        var tax_percent = '<?= $tax_percent ?>';
        price = price * quantity;
        var taxamount = 0, finalamount = 0; 
        taxamount = Math.ceil(price * tax_percent / 100);

        if (rate_type=="yes") {
          finalamount = price;
          price = price - taxamount;
        }else {
          finalamount = price + taxamount;
        }
        



         $('#price').attr('value', " " + finalamount);
         $(".mprice").html("<i class='fa fa-inr'></i>  " + price);       
         $(".pprice").attr('value',price);
         $(".taxes").attr('value',taxamount);
         $(".tax").html("<i class='fa fa-inr'></i>  " + taxamount);
        

     
    });
     function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}
</script>


@endsection