@extends('layouts.main2')

@section('title')
<?= $packs[0]->pack_name ?>
@endsection
@section('includes')
     <meta property="og:title" content="The Grand Venice Mall | <?= $packs[0]->pack_name ?>">
    <meta property="og:description" content="<?= $packs[0]->teaser_line_1 ?> <?= $packs[0]->teaser_line_2 ?>">
    <meta property="og:image" content="<?= asset('public/uploads/forground/'.$packs[0]->background) ?>">
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
    $price = 0;
    $pack_id = 0;
    $pack_type = "";
    $mobile_banner = "";
       $mobile_banner = "";
     $video_icon = "";
     $pack_type = "";
     $note = "";
     $status = "active";
foreach ($packs as $key => $value) {
    $teaser_line_1 = $value->teaser_line_1;
    $teaser_line_2 = $value->teaser_line_2;
    $description = $value->description;
    $background = $value->background;
    $age = $value->age;
    $duration = $value->duration;
    $price = $value->price;
    $forground = $value->background;
    $service_name = $value->pack_name;
    $icon = $value->icon;
    $pack_id = $value->id;
    $slotsize = $value->slotsize;
    $whours = $value->whours;
    $wdays = $value->wdays;
    $pack_type = $value->pack_type;
    $mobile_banner = $value->mobile_banner;
     $video = $value->video;
    $video_icon = $value->video_icon;
    $note = $value->note;
     $no_seats = $value->no_seats;
     $status = $value->status;

   }

   $seconds = time();
  $rounded_seconds = ceil($seconds / (15 * 60)) * (15 * 60);
  $rounded =  date('h:i', $rounded_seconds);
 
   $currenttime = date('h', strtotime('+1 hour')).":00 ".date('A', strtotime('+1 hour')); 

    foreach ($venue as $key => $value) {
         $totime = $value->totime;
        $fromtime = $value->fromtime;
    }

      $currenttime = date('h', strtotime('+1 hour')).":00 ".date('A', strtotime('+1 hour')); 
      $currenttime2 = date('h').":00 ".date('A'); 

       if (strtotime($currenttime2) < strtotime($fromtime)) {
         $currenttime = $fromtime; 
         $todaydate = date('d-m-Y'); 
   }else {
     if (strtotime($currenttime) >= strtotime($fromtime) && strtotime($currenttime) <= strtotime($totime)) {
         $currenttime =  $rounded." ".date('A', strtotime('+15 minutes'));
        if($pack_type=="occasional") {
         $todaydate = date('d-m-Y', strtotime('+1 Day'));    
        }else {
            $todaydate = date('d-m-Y');    
        }
     }else {
         $currenttime = $fromtime; 
         $todaydate = date('d-m-Y',strtotime('+1 Day'));
     }
 }
?>
    <section id="hero" class="otherhero">
        <div class="hero-container ">
            <img src="<?= asset('public/uploads/mobile_banner/'.$mobile_banner) ?>" class="mobile gvtower" style="margin-top: -40px;">
        </div>        
    </section><!-- #hero -->
    <!-- booking form step 1/3  start -->
     <a name="bookingform" class="anchor"></a>
    <div class="booking-form" style="display: block;">
        <div class="loader"></div>

        <div class="head" style="padding-bottom: 10px;">
            <?php if($pack_type=="leads3"): ?>
                <h4>Site Visit: <?= $service_name ?></h4>
            <?php else: ?>
                <h4>Book: <?= $service_name ?></h4>
            <?php endif; ?>
        </div>
        <?php if($pack_type=="leads" || $pack_type=="leads2" || $pack_type=="leads3"): ?>
        <form action="{{ URL::to('send/leads') }}" method="post">
            @csrf
            <?php else: ?>
        <form class="row" action="" method="post">
        <?php endif; ?>
            <div class="col-sm-12">
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
                <?php if($pack_type=="leads" || $pack_type=="leads2" || $pack_type=="leads3"): ?>
                
                     <div class="form-group">
                    
                    <div class="input-group">
                        <input type="text" class="form-control" name="name" value="" placeholder="Name" required="required">
                        <input type="hidden" name="pack_type" value="<?= $pack_type ?>">
                        <input type="hidden" name="pack_name" value="<?= $service_name ?>">
                    </div>
                </div>
                 <div class="form-group">
                  
                    <div class="input-group">
                        <input type="text" class="form-control" name="phone" placeholder="Phone" value="" required="required" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>
                </div>
                <div class="form-group">
                  
                    <div class="input-group">
                        <input type="text" class="form-control" name="email" placeholder="Email" value="" required="required">
                    </div>
                </div>
                <?php endif; ?>
                <?php if($pack_type=="leads" || $pack_type=="leads2" || $pack_type=="leads3"): ?>
                  <div class="form-group">
                   
                    <div class="input-group">
                       <table style="width: 100%">
                           <tr>
                            <td> <label for="date">Site Visit: </label></td>
                               <td> <input type="radio" name="sitevisit" class="sitevisit" value="yes"> Yes</td>
                               <td> <input type="radio" name="sitevisit" class="sitevisit" value="no" checked="checked"> No</td>
                           </tr>
                       </table>
                    </div>
                </div>
             <?php endif; ?>
                
                <div class="form-group">
                    <label for="date">Select A Day</label>
                    <div class="input-group">
                         <?php if($pack_type=="leads" || $pack_type=="leads2"): ?>
                        <input type="text" class="form-control" id="datepicker" name="date" placeholder="----" value="<?= $todaydate ?>" disabled="disabled" style="background: #ccc;">
                        <?php elseif($pack_type=="leads2"): ?>
                          <input type="text" class="form-control" id="datepicker" name="date" placeholder="----" value="<?= $todaydate ?>">
                            <?php elseif($pack_type=="leads3"): ?>
                          <input type="text" class="form-control" id="datepicker" name="date" placeholder="----" value="<?= $todaydate ?>" readonly>
                        <?php else: ?>
                            <input type="text" class="form-control" id="datepicker" name="date" placeholder="----" value="<?= $todaydate ?>" readonly>
                        <?php endif; ?>
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
                 <?php if($pack_type=="occasional"): ?>
                    <div class="form-group">
                
                    <label for="time">Select Time/Cuisine</label><br />
                     <select class="form-control occasion_type">
                    <?php foreach($occasion_type as $key => $value): ?>                 
                    <option value="<?= $value->id ?>" data="<?= $value->timerange ?>"><?= $value->type ?> - <?= $value->cuisine ?> (Rs <?= Helper::get_occassion_rates($value->id) ?>/P)</option>                   
                    <?php endforeach; ?>
                     </select> <br />
                         <label for="time">Select Canal (Gondola Ride)</label><br />
                    <?php foreach($service_options as $key => $value): ?>
                    <div class="form-check form-check-inline">
                      <?php if($key==0): ?>
                    <input class="form-check-input canals" type="radio" name="canals" value="<?= $value->id ?>" checked>
                    <?php else: ?>
                     <input class="form-check-input canals" type="radio" name="canals" value="<?= $value->id ?>">
                    <?php endif; ?>
                    <label class="form-check-label" for="inlineRadio1"><?= $value->option_name ?></label>
                    </div>
                 <?php endforeach; ?> <br /><br />

                 
                 
                    
                     
                 </div>
               <input type="hidden" class="form-control from" id="timepicker" placeholder="--/--" value="<?= $currenttime ?>" readonly>
               <?php elseif($pack_type=="leads2"): ?>
            <?php else: ?>
                  <div class="form-group">
                    <label for="time">Arrival Time</label>
                     <?php if($pack_type=="leads" || $pack_type=="leads2"): ?>
                    <input type="text" class="form-control from" id="timepicker" name="time" placeholder="--/--" value="<?= $currenttime ?>" disabled="disabled" style="background: #ccc;"> 
                    <?php else: ?>
                        <input type="text" class="form-control from" id="timepicker" name="time" placeholder="--/--" value="<?= $currenttime ?>" readonly>
                    <?php endif; ?>
                </div>         
             <?php endif; ?>
                <?php if($pack_type=="gondolaride"): ?>
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
              <?php if($pack_type=="hybrid"): ?>
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
                <?php if($pack_type!="leads" && $pack_type!="leads2" && $pack_type!="leads3"): ?>
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
                                <?php if($pack_type=="occasional"): ?>
                                <input type="text" name="quant[1]" class="form-control input-number quantity" value="<?= $no_seats ?>"  max="1000"  min="<?= $no_seats ?>"  readonly="readonly"  style="background: #FFF;">
                                <?php else: ?>
                                     <input type="text" name="quant[1]" class="form-control input-number quantity" value="<?= $no_seats ?>" min="<?= $no_seats ?>" max="10" readonly="readonly"  style="background: #FFF;">
                            <?php endif; ?>
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
                       <div class="pricetaxbox"> Price: <span class="mprice"></span> |  Tax: <span class="tax"></span>
                        <input type="hidden" class="pprice" value=""><input type="hidden" class="taxes" value=""></div>
                    </div>
                </div>
                <?php endif; ?>
           
                <div class="form-group">
                    <?php if($pack_type=="leads" || $pack_type=="leads2" || $pack_type=="leads3"): ?>
                         <button type="submit" class="btn checkoutbtn" style="width: 100% !important;"><span> Submit</span></button>
                        <?php else: ?>
                 <?php if($status=="inactive"): ?>           
                 <div class="alert alert-danger"> Sorry this pack is not available!</div>
                 <?php else: ?>
                     <button name="addtocart" type="button" class="buynow btn" style="width: 100% !important;"><span> Add To Cart</span></button>
                 <?php endif; ?>
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
                <?php if(Helper::check_mobile()==1): ?>
        <?php if($pack_type=="leads3"): ?>
            <div class="row" style="margin-left: -50px;">
            <div class="col-12" style="font-size: 15px;">
             <i class="fa fa-phone" style="color: #EF9E11;" aria-hidden="true"></i> 88606 00030
            </div>
            <div class="col-12" style="font-size: 15px;">
               <i class="fa fa-envelope" style="color: #EF9E11;" aria-hidden="true"></i> office@veniceindia.com
            </div>
        </div>
    <?php endif; ?>
     <?php endif; ?>
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
                      <?php if($pack_type=="leads3"): ?>
                      <p>
                          <a href="<?= URL::to('public/pdf/presentation.pdf') ?>" download><button type="button" class="btn checkoutbtn" style="width: 300px;margin-top: -20px;">Download Presentation</button></a>
                      </p>
                      <?php endif; ?>
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
                   
                     <?php if($pack_type != "hybrid" && $pack_type != "occasional" && $pack_type != "leads" && $pack_type != "leads2" && $pack_type != "leads3"): ?>
                    <div class="row">
                        <div class="col-md-3">
                            <h6>WORKING HOURS</h6>
                            <P><?= $whours ?></P>
                        </div>
                        <div class="col-md-3">
                            <h6>WORKING DAYS</h6>
                            <P><?= $wdays ?></P>
                        </div>
                        <div class="col-md-3">
                            <h6>AGE LIMIT</h6>
                            <P><?= $age ?> Years</P>
                        </div>
                        <div class="col-md-3">
                            <h6>DURATION</h6>
                            <P><?= $duration ?> Minutes</P>
                        </div>

                       
                    </div>
                    
                <?php endif; ?>
                <?php if ($pack_type == "leads"): ?>
                         <div class="row packservices">
                         <div class="col-md-4" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/metroconnect.png') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Near Pari Chowk<br /> Metro Station</p></li>
                            </div>
                             <div class="col-md-4" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/corporatehub.png') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Amidst<br /> Corporate Hub</p></li>
                            </div>
                             <div class="col-md-4" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/leaseoptions.png') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Attractive<br /> Leasing Options</p></li>
                            </div>
                        <div class="col-md-4" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/powerbackup.png') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">100%<br /> Power Back-up</p></li>
                           
                          
                        </li></div>
                         <div class="col-md-4" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/airconditioned.png') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Centrally<br /> Airconditioned</p></li>
                           </div>
                        
                        
                         <div class="col-md-4" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/spaciouspark.png') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Spacious<br /> Parking Area</p></li>
                            </div>
                        

                       
                    </div>
                <?php elseif($pack_type=="leads3"): ?>
                <style type="text/css">
                    @media (max-width: 425px) {
                       ul.services-included li {
                            width: 160px;
                            font-size: 13px;
                            padding: 5px;
                        }

                        ul.services-included {
                            list-style: none;
                            width: 340px;
                            margin-left: -50px;
                        }
                        #services .row {
                            padding-right: 10% !important;
                            padding-left: 10% !important;
                       }
                    }
                    
                </style> 
                       <div class="row packservices">
                         <div class="col-md-3" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/towericons/metro.jpg') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Near Pari Chowk<br /> Metro Station</p></li>
                            </div>
                             <div class="col-md-3" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/towericons/airport.jpg') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">30 Minutes From<br /> Upcoming Jewar Airport</p></li>
                            </div>
                             <div class="col-md-3" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/towericons/oc.jpg') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Occupancy Certificate<br /> (OC) Received</p></li>
                            </div>
                        <div class="col-md-3" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/towericons/concierge.jpg') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Efficient Concierge<br /> Service</p></li>
                            </li>
                        </div>
                         <div class="col-md-3" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/towericons/commercial.jpg') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Centrally<br /> Airconditioned</p></li>
                           </div>
                        
                        
                         <div class="col-md-3" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/towericons/aircondition.jpg') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">100% Commercial<br /> Spacious, No restriction Of<br />IT/ITES Bye Laws </p></li>
                            </div>
                        
                            <div class="col-md-3" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/towericons/hub.jpg') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Amidst Dense Corporate,<br /> Retail, Residential,<br /> Institutional & Industrial Hub</p></li>
                            </div>
                             <div class="col-md-3" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/towericons/floorplate.jpg') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">70,000 Sq Ft Floor<br /> Plates With Sprawling<br />Efficiency</p></li>
                            </div>
                             <div class="col-md-3" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/towericons/businesscenter.jpg') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Fully Equipped<br /> Business Centre</p></li>
                            </div>
                        <div class="col-md-3" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/towericons/recreationclub.jpg') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Recreational<br /> Club</p></li>
                           
                          
                        </li></div>
                         <div class="col-md-3" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/towericons/parking.jpg') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Dedicated Spacious<br /> Parking Space</p></li>
                           </div>
                        
                        
                         <div class="col-md-3" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="{{ asset('public/images/towericons/shuttle.jpg') }}" style="width: 120px;"><p style="margin-top: 10px;text-align: center;">Free Metro Shuttle<br /> Service For Occupants</p></li>
                            </div>
                       
                    </div>  
                <?php endif; ?>
                  <?php if($pack_type == "hybrid"): ?>
                    <?php if(Helper::check_mobile()=="1"): ?>
                     <div class=" packservices">
                        <ul class="outerfeatures">
                        <?php foreach($packs_services as $key => $value): ?>
                            <li>
                        <div class="col-md-2" style="margin-top: 20px;">
                            <ul class="services-included">
                            <li><img src="<?= URL::to('public/uploads/icon/'.$value->icon) ?>" style="width: 90px;"></li>
                            <li><strong style="color: #EF9E11"><?= $value->service_name ?></strong><br />
                            <b>For <?= $value->service_quantity ?> Person</b><br />
                             <b> Duration: <?= $value->duration ?></b><br />
                              <b>Age: <?= $value->age ?> Years</b><br />
                        </li></ul></div>
                        <?php endforeach; ?>
                    </li>

                       </ul>
                    </div>
                        <?php else: ?>
                    <div class="row packservices">
                        <?php foreach($packs_services as $key => $value): ?>
                        <div class="col-md-4" style="margin-top: 40px;">
                            <ul class="services-included">
                            <li><img src="<?= URL::to('public/uploads/icon/'.$value->icon) ?>" style="width: 120px;"></li>
                            <li><strong style="color: #EF9E11"><?= $value->service_name ?></strong><br />
                            <b>For <?= $value->service_quantity ?> Person</b><br />
                             <b> Duration: <?= $value->duration ?></b><br />
                              <b>Age: <?= $value->age ?> Years</b><br />
                        </li></div>
                        <?php endforeach; ?>

                       
                    </div>
                <?php endif; ?>
                    <?php if($note != "" || $note!=null): ?>
                    <div class="col-12 notearea">
                    <p><strong>Note: </strong> <?= $note ?></p>
                    
                </div>
            <?php endif; ?>
                <?php endif; ?>
                    <?php if(count($inclusions) != 0): ?>
                        <?php if($pack_type=="occasional"): ?>
                                <div class="row incluions-box">
                     
                            <div class="col-2 incluions-title">
                                <img src="{{ asset('public/images/inclusionicons.jpg') }}">Inclusions
                            </div>
                            <div class="col-10 inclusion-content">
                                <ul class="inclusions">
                                    <?php 
                                    $incl = "";
                                    foreach ($inclusions as $key => $value) {
                                       $incl = $value->inclusions;
                                    }
                                     
                                    ?>
                                   
                                    <li style="text-align: justify !important;font-weight: normal;text-transform: capitalize;"><?= rtrim($incl) ?></li>
                   
                                </ul>
                            </div>
                            
                     
                    </div>
<?php if($note != "" || $note!=null): ?>
                    <div class="col-12 notearea">
                    <p><strong>Note: </strong> <?= $note ?></p>
                    
                </div>
            <?php endif; ?>
                        <?php elseif($pack_type=="leads2"): ?>   
                                <div class="row incluions-box">
                     
                            <div class="col-2 incluions-title">
                               
                            </div>
                            <div class="col-8 inclusion-content">
                                <ul class="inclusions">
                                    <?php 
                                    $incl = "";
                                    foreach ($inclusions as $key => $value) {
                                       $incl .= $value->inclusions."<br />";
                                    }
                                     
                                    ?>
                                   
                                    <li><?= $incl ?></li>
                   
                                </ul>
                            </div>
                            
                     
                    </div>
                     <?php if($note != "" || $note!=null): ?>
<div class="col-12 notearea">
                    <p><strong>Note: </strong> <?= $note ?></p>
                    
                </div>
                <?php endif; ?>
                        <?php else: ?>

                                 <div class="row incluions-box">
                     
                            <div class="col-2 incluions-title">
                                <img src="{{ asset('public/images/inclusionicons.jpg') }}">Inclusions
                            </div>
                            <div class="col-9 inclusion-content">
                                <ul class="inclusions">
                                    <?php 
                                    $incl = "";
                                    foreach ($inclusions as $key => $value) {
                                       $incl .= $value->inclusions."&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;";
                                    }
                                     
                                    ?>
                                   
                                    <li><?= rtrim($incl,'&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;') ?></li>
                   
                                </ul>
                            </div>
                            
                     
                    </div>
                     <?php if($note != "" || $note!=null): ?>
<div class="col-12 notearea">
                    <p><strong>Note: </strong> <?= $note ?></p>
                    
                </div>
                <?php endif; ?>

                        <?php endif; ?>
                   
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
           Customer Also Bought
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
.timepicker {
        padding: .375rem .75rem !important;
}
a.anchor{
    display: block;
    position: relative;
    top:-80px;
} 
@media (max-width: 425px) {
    .booking-form {
    margin-top: 40px !important;
    } 
    .gvtower {
        position: relative;
        top: 42px;
    }

}

#datepicker {
    background: #FFF;
}
#timepicker {
    background: #FFF;
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
@media (max-width: 425px) {
.packservices {
      margin-left: -40px;
}
}
</style>
<script type="text/javascript">
    $(".sitevisit").change(function() {
      var sitevisit = $(this).val();
     if (sitevisit=="yes") {
        $("#datepicker").prop('disabled',false);
         $("#datepicker").css('background','#FFF');
        $("#timepicker").prop('disabled',false);
        $("#timepicker").css('background','#FFF');
     }else {
         $("#datepicker").prop('disabled',true);
         $("#datepicker").css('background','#ccc');
        $("#timepicker").prop('disabled',true);
        $("#timepicker").css('background','#ccc');
     }
    });
    var quantity = $('.quantity').val();
    var datepicker = $("#datepicker").val();
    var timepicker3 =  $("#timepicker ").val();
    var pack_id = '<?= $pack_id ?>';
    var canal = $(".canals:checked").val();
    var occasion_type = $(".occasion_type option:selected").val();
     var occasion_time = $(".occasion_type option:selected").attr('data');
    
    var pack_type = "<?= $pack_type ?>";
    var url = "";


    if (pack_type=="occasional") {
     url = "<?= URL::to('booking/get_rates/"+pack_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/packs/"+occasion_type+"/online') ?>";
     $("#timepicker").attr('value',occasion_time); 
    }else {
     url = "<?= URL::to('booking/get_rates/"+pack_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/packs/0/online') ?>";
    } 
    console.log(url);

    
         $.ajax({
    
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
        if (result.length=="0") {
           $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Sorry, no session available for the selected date/time!");
           $('#price').attr('value', "");
           $(".nextbtn").prop("disabled", true);
        }else {

            $('#price').attr('value', " " + result[0]['final_price']);
            $(".mprice").html("<i class='fa fa-inr'></i>  " + result[0]['price']);
               $(".pprice").attr('value',result[0]['price']);
              $(".taxes").attr('value',result[0]['tax_amount']);
            $(".tax").html("<i class='fa fa-inr'></i>  " + result[0]['tax_amount']);
            $(".nextbtn").prop("disabled", false);
        }
         
        }
     });    
    var today, datepicker;
    var pack_type = "<?= $pack_type ?>";
    if (pack_type=="occasional") {
        today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate() + 1);

    }else {
        today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate() );
    }
    
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
           
 
        }else {
            startTime = "<?= $fromtime ?>";
            $('.from').timepicker('option', 'minTime', startTime);

          
            
        }
    var quantity = $('.quantity').val();
    var datepicker = $("#datepicker").val();
    var timepicker3 =  $("#timepicker ").val();
    var pack_id = '<?= $pack_id ?>';
    var canal = $(".canals:checked").val();       
    var occasion_type = $(".occasion_type option:selected").val();
     var occasion_time = $(".occasion_type option:selected").attr('data');
    var pack_type = "<?= $pack_type ?>";
    var url = "";

    if (pack_type=="occasional") {
    url = "<?= URL::to('booking/get_rates/"+pack_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/packs/"+occasion_type+"/online') ?>";

    }else {
     url = "<?= URL::to('booking/get_rates/"+pack_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/packs/0/online') ?>";
    }


        
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
    $('.occasion_type').change(function() {
         setTimeout( function() { $('.loader').show(); }, 100 );
         setTimeout( function() { $('.loader').hide(); }, 600 );

          var quantity = $('.quantity').val();
      var datepicker = $("#datepicker").val();
      var timepicker3 =  $("#timepicker ").val();
    var pack_id = '<?= $pack_id ?>';
    var canal = $(".canals:checked").val();

     var occasion_type = $(this).val();
     var occasion_time = $(".occasion_type option:selected").attr('data');

      var pack_type = "<?= $pack_type ?>";
    var url = "";

    if (pack_type=="occasional") {
    url = "<?= URL::to('booking/get_rates/"+pack_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/packs/"+occasion_type+"/online') ?>";

     $("#timepicker").attr('value',occasion_time); 
    }else {
     url = "<?= URL::to('booking/get_rates/"+pack_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/packs/0/online') ?>";
    }

       $.ajax({
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
        if (result.length=="0") {
           $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Sorry, no session available for the selected date/time!");
           $('#price').attr('value', "");
           $(".nextbtn").prop("disabled", true);
        }else {

            $('#price').attr('value', " " + result[0]['final_price']);
            $(".mprice").html("<i class='fa fa-inr'></i>  " + result[0]['price']);
               $(".pprice").attr('value',result[0]['price']);
              $(".taxes").attr('value',result[0]['tax_amount']);
            $(".tax").html("<i class='fa fa-inr'></i>  " + result[0]['tax_amount']);
            $(".nextbtn").prop("disabled", false);
        }
         
        }
     }); 

        
    });
   
  $('.from').timepicker({
      timeFormat: 'h:mm p',
       interval: '<?= $slotsize ?>', 
        minTime: '<?= $currenttime ?>', 
       maxTime: '<?= $totime ?>', 
        defaultTime: '',
       dynamic: false,
       minDate: 0,
       dropdown: true,
       scrollbar: true,
       use24hours: true,
          change: function(time) {
           setTimeout( function() { $('.loader').show(); }, 100 );
         setTimeout( function() { $('.loader').hide(); }, 600 );
         var service_id = "<?= $pack_id ?>";
         var datepicker = $("#datepicker").val();
         var timepicker3 =  $("#timepicker ").val();
         var quantity = $(".quantity").val();
        var canal = $(".canals:checked").val();         
        var pack_type = "<?= $pack_type ?>";
         var occasion_type = $(".occasion_type option:selected").val();
     var occasion_time = $(".occasion_type option:selected").attr('data');
        var url = "";

    if (pack_type=="occasional") {
      url = "<?= URL::to('booking/get_rates/"+pack_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/packs/"+occasion_type+"/online') ?>";
    }else {
     url = "<?= URL::to('booking/get_rates/"+pack_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/packs/0/online') ?>";
    }



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
 $('.btn-number').click(function(e) {
        e.preventDefault();

        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
         var pack_type = "<?= $pack_type ?>";
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        setTimeout( function() { $('.loader').show(); }, 100 );
         setTimeout( function() { $('.loader').hide(); }, 600 );
          var pack_id = "<?= $pack_id ?>";
         var datepicker = $("#datepicker").val();
         var timepicker3 =  $("#timepicker ").val();
         quantity = 0;
         if(pack_type=="occasional") {
             quantity = 2;
         }else {
             quantity = 1;
         }
         
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

     
  
      var datepicker = $("#datepicker").val();
      var timepicker3 =  $("#timepicker ").val();
    var pack_id = '<?= $pack_id ?>';
    var canal = $(".canals:checked").val();

        var occasion_type = $(".occasion_type option:selected").val();
     var occasion_time = $(".occasion_type option:selected").attr('data');
     
    var url = "";

    if (pack_type=="occasional") {
     url = "<?= URL::to('booking/get_rates/"+pack_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/packs/"+occasion_type+"/online') ?>";
    }else {
     url = "<?= URL::to('booking/get_rates/"+pack_id+"/"+datepicker+"/"+timepicker3+"/"+quantity+"/"+canal+"/packs/0/online') ?>";
    }


         $.ajax({
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
        if (result.length=="0") {
           $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Sorry, no session available for the selected date/time!");
           $('#price').attr('value', "");
           $(".nextbtn").prop("disabled", true);
        }else {

            $('#price').attr('value', " " + result[0]['final_price']);
            $(".mprice").html("<i class='fa fa-inr'></i>  " + result[0]['price']);
               $(".pprice").attr('value',result[0]['price']);
              $(".taxes").attr('value',result[0]['tax_amount']);
            $(".tax").html("<i class='fa fa-inr'></i>  " + result[0]['tax_amount']);
            $(".nextbtn").prop("disabled", false);
        }
         
        }
     })    
     
    });
    $(function() {
       $(".addtocart, .buynow").on('click', function() {
         $(".addtocart span").html('<i class="fa fa-check checked"></i> Added');
         setTimeout( function() { $('.loader').show(); }, 100 );
         setTimeout( function() { $('.loader').hide(); }, 600 );   

          var service_id = "<?= $pack_id ?>";
         var servicetype = "packs";
         var datepicker = $("#datepicker").val();
         var timepicker =  $("#timepicker ").val();
         var quantity = $(".quantity").val();
         var canal = $(".canals:checked").val();
         var amount = $("#price").val();
         var price = $(".pprice").val();
         var tax = $(".taxes").val();
         var occasion_type = "";
          var pack_type = "<?= $pack_type ?>";
          if (pack_type=="occasional") {
              occasion_type = $(".occasion_type option:selected").val();
          }else {
            occasion_type = "NA";
          }
        
         var icon = "<?= URL::to('public/uploads/icon/'.$icon) ?>";
         var formData = {
                '_token':'{{ csrf_token()}}',
                'service_id': service_id,
                'datepicker': datepicker,
                'timepicker': timepicker,
                'quantity': quantity,
                'canal': canal,
                'amount': amount,
                'pack_type': pack_type,
                'occasion_type': occasion_type,
                'price': price,
                'taxes': tax,
                'icon': icon,
                'servicetype': servicetype
            };

             if (amount==0) {

                   $('#bookingModal').modal('show');
            $('#bookingModal .content').html("Sorry, no session available for the selected date/time!");


             }else {


         var url = '<?= URL::to("cart/add_item") ?>';   
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