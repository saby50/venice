@extends('layouts.main2')

@section('title')
<?= $services[0]->service_name ?>
@endsection
@section('includes')
     <meta property="og:title" content="The Grand Venice Mall | <?= $services[0]->service_name ?>">
    <meta property="og:description" content="<?= $services[0]->teaser_line_1 ?> <?= $services[0]->teaser_line_2 ?>">
    <meta property="og:image" content="<?= asset('public/uploads/forground/'.$services[0]->forground) ?>">
@endsection
@section('content')
<?php 

    $teaser_line_1 = "";
    $teaser_line_2 = "";
    $description = "";
    $background = "";
    $age = "";
    $duration = "";
    $totime = "";
    $fromtime = "";
    $forground = "";
    $service_name = "";
    $icon = "";
     $alias = 0;
     $video = "";
     $mobile_banner = "";
     $video_icon = "";
     $status = "active";
   foreach ($services as $key => $value) {
    $teaser_line_1 = $value->teaser_line_1;
    $teaser_line_2 = $value->teaser_line_2;
    $description = $value->description;
    $background = $value->background;
    $age = $value->age;
    $duration = $value->duration;
    $totime = $value->totime;
    $fromtime = $value->fromtime;
    $forground = $value->forground;
    $service_name = $value->service_name;
    $icon = $value->icon;
    $slotsize = $value->slotsize;
    $mobile_banner = $value->mobile_banner;
    $video = $value->video;
    $video_icon = $value->video_icon;
    $notes = $value->notes;
    $status = $value->status;
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
 <section id="hero" class="otherhero">
        <div class="hero-container ">
            <img src="<?= asset('public/uploads/mobile_banner/'.$mobile_banner) ?>" class="mobile" style="margin-top: -40px;">
        </div>
        
    </section><!-- #hero -->
    <!-- booking form step 1/3  start -->
    <a name="bookingform"  class="anchor"></a>
    <div class="booking-form" style="display: block;">
        <div class="loader"></div>

        <div class="head" style="padding-bottom: 10px;">
            
            <h4>Book: <?= $service_name ?></h4>
        </div>
        <form class="row" action="" method="post">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="date">Select A Day</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="datepicker" placeholder="----" value="<?= $todaydate ?>" readonly>
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="time">Arrival Time</label>
                    <input type="text" class="form-control from" id="timepicker" placeholder="--/--" value="<?= $currenttime ?>" readonly>
                </div>
                <?php if($type=="gondola"): ?>
                <div class="form-group">
                    <label for="time">Select Canal</label><br />
                    <?php foreach($service_options as $key => $value): ?>
                    <div class="form-check form-check-inline">
                    <?php if($key==0): ?>
                    <input class="form-check-input canals" type="radio" name="canals" value="<?= $value->id ?>" checked>
                    <?php else: ?>
                     <input class="form-check-input canals" type="radio" name="canals" value="<?= $value->id ?>">
                    <?php endif; ?>
                    <label class="form-check-label" for="inlineRadio1"><?= $value->option_name ?></label>
                    </div>
                <?php endforeach; ?>
                   
                </div>
            <?php endif; ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="time">Quantity</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number minus" disabled="disabled" data-type="minus" data-field="quant[1]">
                                        <span class="fa fa-minus"></span>
                                    </button>
                                </span>
                                <input type="text" name="quant[1]" class="form-control input-number quantity" value="1" min="1" max="10" readonly="readonly"  style="background: #FFF;">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number plus" data-type="plus" data-field="quant[1]">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" style="background: #FFF;">
                        <div class="input-group margin-bottom-sm price-box" style="width: 100%; margin: 0;">
                          <span class="input-group-addon rupeeicon"><i class="fa fa-rupee fa-lg"></i> </span> 
                            <input type="text" class="form-control" id="price" placeholder="&#x20B9; ----" readonly="readonly" style="background: #FFF;">

                        </div>
                       <div class="pricetaxbox"> Price: <span class="mprice"></span> |  GST: <span class="tax"></span>
                      <input type="hidden" class="ffa" value="">  <input type="hidden" class="pprice" value=""><input type="hidden" class="taxes" value=""></div>
                    </div>
                </div>
                <br />
                <div class="form-group">
                   
                   <?php if($status=="inactive"): ?>           
                 <div class="alert alert-danger"> Sorry this service is not available!</div>
                 <?php else: ?>
                     <button name="addtocart" type="button" class="buynow btn" style="width: 100% !important;"><span> Add To Cart</span></button>
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
                         <iframe width="100%" height="250" class="youtube-video" src="<?= $video ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>

                        <?php else: ?>
                        <img src="<?= asset('public/uploads/vidicon/'.$video_icon) ?>">
                        <a href="javascript:;" class="modalclick" data-toggle="modal" data-target="#myModal"><img src="{{ asset('public/images/home/Video-Play-Btn.png') }}" class="img-responsive center playBtn" style="height: auto;"></a>
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
      Services Section
    ============================-->
        <section id="services">
            <div class="container wow fadeIn">
                <div class="section-header text-center">
          
                    <div class="row">
                        <div class="col-md-3">
                            <h6>WORKING HOURS</h6>
                            <P><?= date('g A', strtotime($fromtime)) ?> - <?= date('g A', strtotime($totime)) ?></P>
                        </div>
                        <div class="col-md-3">
                            <h6>WORKING DAYS</h6>
                            <P>All</P>
                        </div>
                        <div class="col-md-3">
                            <h6>AGE LIMIT</h6>
                            <P><?= $age ?> Years</P>
                        </div>
                        <div class="col-md-3">
                            <h6>DURATION</h6>
                            <P><?= $duration ?></P>
                        </div>
                    </div>
                    <?php if($notes != ""): ?>
                    <div class="col-12 notearea">
                    <p><strong>Note: </strong> <?= $notes ?></p>
                    
                </div>
            <?php endif; ?>
                </div>
            </div>
        </section><!-- #services -->
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
<div class="recyclerview"> 
        <div class="row">

            <div class="col-12">
                <div class="recyclerviewhead">
           Customers Also Bought
         </div>
            <div class="recyclerviewhead2">
            <a href="<?= URL::to('categories') ?>">View All</a>
         </div>     
            </div>
            </div>
     <?php $i = 0; foreach($featured2 as $key => $value): ?>
                <a href="<?= URL::to('packs/'.$value->alias) ?>">
                <div class="featured-pwa ripple">
                    <div class="row">
                        
                <div class="col-4">

                    <img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured/'.$value->featured_image) ?>" alt="slide 1">
                </div>  
                <div class="col-8">
                     <span class="title"><?= $value->pack_name ?></span><br />
                     <span class="desc"><?= $value->teaser_line_1 ?> <?= $value->teaser_line_2 ?></span><br />
                       <span class="prices"><?php $rates = Helper::get_all_rates($value->id, 'packs');
                         if (count($rates)==1) {
                            echo '<i class="fa fa-rupee"></i> '.$rates[0];
                         }elseif (count($rates)==0) {
                            echo 'Get Quote';
                         }else {
                            echo '<i class="fa fa-rupee"></i> '.min($rates). " - ".max($rates);
                         }
                       ?></span>
                </div>
                </div>
                </div>
            </a>
             <hr />
           
        <?php endforeach; ?>
          <?php foreach($featured as $key => $value): ?>
                <a href="<?= URL::to('booking/'.$value->alias) ?>">
                <div class="featured-pwa ripple">
                    <div class="row">
                        
                <div class="col-4">

                    <img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured/'.$value->featured_image) ?>" alt="slide 1">
                </div>  
                <div class="col-8">
                     <span class="title"><?= $value->service_name ?></span><br />
                     <span class="desc"><?= $value->teaser_line_1 ?> <?= $value->teaser_line_2 ?></span><br />
                       <span class="prices"><?php $rates = Helper::get_all_rates($value->id, 'service');
                         if (count($rates)==1) {
                            echo '<i class="fa fa-rupee"></i> '.$rates[0];
                         }elseif (count($rates)==0) {
                            echo 'Get Quote';
                         }else {
                            echo '<i class="fa fa-rupee"></i> '.min($rates). " - ".max($rates);
                         }
                       ?></span>
                </div>
                </div>
                </div>
            </a>
             <?php if($i == count($featured) - 1): ?>
                <?php else: ?>
                    <hr />
                <?php endif; ?>
                

                <?php 
                   $i++;
                ?>
        <?php endforeach; ?>
        </div>
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
                                                      echo $short;
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
                                                     echo $short;
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
 margin-top: -100px;
}
a.anchor{
 display: block;
    position: relative;
    top:-80px;
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
#myModal iframe  {
  width: 100%;
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
</style>
<script>
      var service_id = "<?= $service_id ?>";
      var datepicker = $("#datepicker").val();
      var timepicker3 =  $("#timepicker ").val();
      var quantity = $(".quantity").val();
      var canal = $(".canals:checked").val();         
      var url = "<?= URL::to('booking/get_rates/"+service_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/service/0/online') ?>";

    

      $.ajax({
       url: url,
       type: 'GET',

       context: this,
       success: function(result) {

        if (result[0]['final_price']=="0") {
           $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Sorry, no session available for the selected date/time!");
           $('#price').attr('value', "0");
           $(".nextbtn").prop("disabled", true);
        }else {

            if (result[0]['final_price']==0) {
                $(".addtocart").prop('disabled', true);
               
            }

            $('#price').attr('value', " " + result[0]['final_price']);
            $(".mprice").html("<i class='fa fa-inr'></i>  " + result[0]['price']);
            var ffa = result[0]['price'];
            var ffa2  = "<?= Crypt::encrypt("+ffa+") ?>";
            $(".ffa").attr('value',ffa2);
             $(".pprice").attr('value',result[0]['price']);
              $(".taxes").attr('value',result[0]['tax_amount']);
            $(".tax").html("<i class='fa fa-inr'></i>  " + result[0]['tax_amount']);
            $(".nextbtn").prop("disabled", false);
        }
         
        }
     })
  

    $('.btn-number').click(function(e) {
        e.preventDefault();
      
        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        setTimeout( function() { $('.loader').show(); }, 100 );
         setTimeout( function() { $('.loader').hide(); }, 600 );
          var service_id = "<?= $service_id ?>";
         var datepicker = $("#datepicker").val();
         var timepicker3 =  $("#timepicker ").val();
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

        var canal = $(".canals:checked").val();         
      var url = "<?= URL::to('booking/get_rates/"+service_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/service/0/online') ?>";
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

            $('#price').attr('value', " " + result[0]['final_price']);
            $(".mprice").html("<i class='fa fa-inr'></i>  " + result[0]['price']);
             var ffa = result[0]['price'];
            var ffa2  = "<?= Crypt::encrypt("+ffa+") ?>";
            $(".ffa").attr('value',ffa2);
               $(".pprice").attr('value',result[0]['price']);
              $(".taxes").attr('value',result[0]['tax_amount']);
            $(".tax").html("<i class='fa fa-inr'></i>  " + result[0]['tax_amount']);
            $(".nextbtn").prop("disabled", false);
        }
         
        }
     })
    });
    
</script>
<script type="text/javascript">
    var today, datepicker;
    today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
  

    $('#datepicker').datepicker({
         modal: true,
         header: true,
         footer: true,
         minDate: today,
         uiLibrary: 'bootstrap4',
         dateFormat: 'dd-mm-yy',
         beforeShow : function(){
          var dateTime = new Date();
           var hour = dateTime.getHours();
             var lasthour = '<?= date('G',strtotime($totime)) ?>';
    
        //If Hour is equal to 11AM disable past date including tomorrow and today
          if(hour  == lasthour){
            $(this).datepicker( "option", "minDate", "+1" );
          }
        },
         onSelect: function (dateText) {
           setTimeout( function() { $('.loader').show(); }, 100 );
           setTimeout( function() { $('.loader').hide(); }, 600 );

          //change time 
          var data = $(this).val();
          var todaydate = "<?php echo date('d-m-Y'); ?>";
        
        var startTime;   
        if(data==todaydate) {  
        var finaltime = "<?= $currenttime ?>";  

           $('.from').timepicker('option', 'minTime', finaltime);
            $('.from').val(finaltime);
 
        }else {
            startTime = "<?= $fromtime ?>";

            $('.from').timepicker('option', 'minTime', startTime);
           $('.from').val(startTime);
          
            
        }
         var service_id = "<?= $service_id ?>";
         var datepicker = $("#datepicker").val();
         var timepicker3 =  $("#timepicker ").val();
         var quantity = $(".quantity").val();
         var canal = $(".canals:checked").val();         
      var url = "<?= URL::to('booking/get_rates/"+service_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/service/0/online') ?>";
        
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

           $('#price').attr('value', " " + result[0]['final_price']);
            var ffa = result[0]['price'];
            var ffa2  = "<?= Crypt::encrypt("+ffa+") ?>";
            $(".ffa").attr('value',ffa2);
               $(".pprice").attr('value',result[0]['price']);
              $(".taxes").attr('value',result[0]['tax_amount']);
            $(".mprice").html("<i class='fa fa-inr'></i>  " + result[0]['price']);
            $(".tax").html("<i class='fa fa-inr'></i>  " + result[0]['tax_amount']);
            $(".nextbtn").prop("disabled", false);
        }
         
        }
     })
         }
     });
    $(function(){

    $(".canals").on('change', function() {
          setTimeout( function() { $('.loader').show(); }, 100 );
         setTimeout( function() { $('.loader').hide(); }, 600 );
          var service_id = "<?= $service_id ?>";
         var datepicker = $("#datepicker").val();
         var timepicker3 =  $("#timepicker ").val();
         var quantity = $(".quantity").val();
         var canal = $(".canals:checked").val();         
      var url = "<?= URL::to('booking/get_rates/"+service_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/service/0/online') ?>";
        
      $.ajax({
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
        if (result.length=="0") {
           $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Sorry, no session available for the selected date/time!");
           $('#price').attr('value',"0");
           $(".nextbtn").prop("disabled", true);
        }else {

           $('#price').attr('value', " " + result[0]['final_price']);
            var ffa = result[0]['price'];
            var ffa2  = "<?= Crypt::encrypt("+ffa+") ?>";
            $(".ffa").attr('value',ffa2);
               $(".pprice").attr('value',result[0]['price']);
              $(".taxes").attr('value',result[0]['tax_amount']);
            $(".mprice").html("<i class='fa fa-inr'></i>  " + result[0]['price']);
            $(".tax").html("<i class='fa fa-inr'></i>  " + result[0]['tax_amount']);
            $(".nextbtn").prop("disabled", false);
        }
         
        }
     })

    });
    
   $('.from').timepicker({
      timeFormat: 'h:mm p',
       interval: '<?= $slotsize ?>', 
       minTime: '<?= $currenttime ?>', 
       maxTime: '<?= $totime ?>', 
       defaultTime: '<?= $currenttime ?>',
       dynamic: false,
       dropdown: true,
       scrollbar: true,
       use24hours: true,
       change: function(time) {
           setTimeout( function() { $('.loader').show(); }, 100 );
         setTimeout( function() { $('.loader').hide(); }, 600 );
         var service_id = "<?= $service_id ?>";
         var datepicker = $("#datepicker").val();
         var timepicker3 =  $("#timepicker ").val();
         var quantity = $(".quantity").val();
        var canal = $(".canals:checked").val();         
      var url = "<?= URL::to('booking/get_rates/"+service_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/service/0/online') ?>";

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

           $('#price').attr('value', " " + result[0]['final_price']);
            var ffa = result[0]['price'];
            var ffa2  = "<?= Crypt::encrypt("+ffa+") ?>";
            $(".ffa").attr('value',ffa2);
    $(".pprice").attr('value',result[0]['price']);
              $(".taxes").attr('value',result[0]['tax_amount']);
            $(".mprice").html("<i class='fa fa-inr'></i>  " + result[0]['price']);
            $(".tax").html("<i class='fa fa-inr'></i>  " + result[0]['tax_amount']);
            $(".nextbtn").prop("disabled", false);
        }
         
        }
     })
        }



     });
       });

    $(function() {
       $(".addtocart, .buynow").on('click', function() {
         $(".addtocart span").html('<i class="fa fa-check checked"></i> Added');
         setTimeout( function() { $('.loader').show(); }, 100 );
         setTimeout( function() { $('.loader').hide(); }, 600 );   

         var service_id = "<?= $service_id ?>";
         var servicetype = "service";
         var datepicker = $("#datepicker").val();
         var timepicker =  $("#timepicker ").val();
         var quantity = $(".quantity").val();
         var canal = $(".canals:checked").val();
         var amount = $("#price").val();
         var price = $(".pprice").val();  
         var tax = $(".taxes").val();
         var icon = "<?= URL::to('public/uploads/icon/'.$icon) ?>";
         var formData = {
                '_token':'{{ csrf_token()}}',
                'service_id': service_id,
                'datepicker': datepicker,
                'timepicker': timepicker,
                'quantity': quantity,
                'canal': canal,
                'amount': amount,
                'price': price,
                'taxes': tax,
                'icon': icon,
                'servicetype': servicetype
            };

         var url = '<?= URL::to("cart/add_item") ?>'; 
          if (amount==0) {
               $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Sorry, no session available for the selected date/time!");
         }else{
               $.post(url,  formData,
            function (resp,textStatus, jqXHR) {
               //Show Message
                window.location = '<?= URL::to('cart') ?>';
            });
         }


       });
    });

</script>

@endsection