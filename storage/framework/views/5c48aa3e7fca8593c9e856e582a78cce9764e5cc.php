<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Gondola Rides | The Grand Venice</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <!-- Favicons -->
    <link href="img/favicon.png" rel="icon">
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">
    <!-- Bootstrap CSS File -->
    <link href="<?php echo e(asset('public/lib/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <!-- Libraries CSS Files -->
    <link href="<?php echo e(asset('public/lib/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('public/lib/animate/animate.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('public/css/front/bootstrap-pincode-input.css')); ?>" rel="stylesheet">
    <!-- Main Stylesheet File -->
    <link href="<?php echo e(asset('public/css/front/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('public/css/front/media.css')); ?>" rel="stylesheet">
</head>

<body>
    <!--==========================
  Pre Header
  ============================-->
    <div id="pre-header">
        <div class="row">
            <div class="col-sm-6 left">
                <ul>
                    <li class="list-inline-item" style="color: #EF9E11">Follow Us:</li>
                    <li class="list-inline-item"><a href="javascript:;"><img src="<?php echo e(asset('public/images/Social-Icon-Facebook.png')); ?>"></a></li>
                    <li class="list-inline-item"><a href="javascript:;"><img src="<?php echo e(asset('public/images/Social-Icon-Twitter.png')); ?>"></a></li>
                    <li class="list-inline-item"><a href="javascript:;"><img src="<?php echo e(asset('public/images/Social-Icon-Instagram.png')); ?>"></a></li>
                    <li class="list-inline-item"><a href="javascript:;"><img src="<?php echo e(asset('public/images/Social-Icon-Youtube.png')); ?>"></a></li>
                    <li class="list-inline-item"><a href="javascript:;"><img src="<?php echo e(asset('public/images/Social-Icon-Whatsapp.png')); ?>"></a></li>
                </ul>
            </div>
            <div class="col-sm-6 right">
                <ul>
                    <li class="list-inline-item" style="color: #fff"><img src="<?php echo e(asset('public/images/Mail-Icon.png')); ?>"> info@veniceindia.com</li>
                    <li class="list-inline-item" style="color: #EF9E11">|</li>
                    <li class="list-inline-item" style="color: #fff"><img src="<?php echo e(asset('public/images/Phone-Icon.png')); ?>"> 8860600059</li>
                </ul>
            </div>
        </div>
    </div>
    <!--==========================
  Header
  ============================-->
    <header id="header">
        <div class="container">
            <div id="logo" class="pull-left">
                <a href="index.html"><img src="<?php echo e(asset('public/images/logo.png')); ?>" alt="" title="" /></img></a>
                <!-- Uncomment below if you prefer to use a text logo -->
                <!--<h1><a href="#hero">Regna</a></h1>-->
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class="menu-active"><a href="index.html">Gondola Rides</a></li>
                    <li>|</li>
                    <li class="menu-has-children"><a href="">Masti Activities</a>
                        <ul>
                            <li><a href="#">Drop Down 1</a></li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li>
                            <li><a href="#">Drop Down 5</a></li>
                        </ul>
                    </li>
                    <li>|</li>
                    <li class="menu-has-children"><a href="">Combo Packs</a>
                        <ul>
                            <li><a href="#">Drop Down 1</a></li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li>
                            <li><a href="#">Drop Down 5</a></li>
                        </ul>
                    </li>
                    <li>|</li>
                    <li><a href="#contact">Contact Us</a></li>
                    <li>|</li>
                    <li><a href="login.html"><img src="<?php echo e(asset('public/images/Login-Profile.png')); ?>"> Login</a></li>
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </header><!-- #header -->
    <!--==========================
    Hero Section
  ============================-->
    <section id="hero">
        <div class="hero-container">
            <img src="<?php echo e(asset('public/images/Gondola-Main-Image.png')); ?>">
        </div>
    </section><!-- #hero -->
    <!-- booking form step 1/3  start -->
    <div class="booking-form" style="display: block;">
        <div class="head">
            <p class="step">Step 1/3</p>
            <h4>Book Your Gondola Ride</h4>
        </div>
        <form class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="date">Select A Day</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="datepicker" placeholder="----">
                    </div>
                </div>
                <div class="form-group">
                    <label for="time">Arrival Time</label>
                    <input type="text" class="form-control" id="timepicker" placeholder="--/--">
                </div>
                <div class="form-group">
                    <label for="time">Select Canal</label><br />
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                        <label class="form-check-label" for="inlineRadio1">Grand Canal</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                        <label class="form-check-label" for="inlineRadio2">San Polo</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="time">Number of Seats</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                        <span class="fa fa-minus"></span>
                                    </button>
                                </span>
                                <input type="text" name="quant[1]" class="form-control input-number" value="1" min="1" max="10">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group price-box" style="width: 100%; margin: 0;">
                            <input type="text" class="form-control" id="price" placeholder="&#x20B9; ----">
                        </div>
                    </div>
                </div>
                <br />
                <div class="form-group">
                    <a href="javascript:;" class="btn">Next</a>
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
            <img style="height: 30vh;" src="<?php echo e(asset('public/images/Oops.png')); ?>" alt="Oops..">
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
            <img style="height: 30vh;" src="<?php echo e(asset('public/images/Yeahh.png')); ?>" alt="Yeahhh..">
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
      Services Section
    ============================-->
        <section id="services">
            <div class="container wow fadeIn">
                <div class="section-header text-center">
                    <h4>Take An Enchanting</h4>
                    <h3 class="section-title">Gondola Rides</h3>
                    <p class="section-description">If you are keen on experiencing the second-to-none magic of Venice without taking a trip to Venice Italy, be sure to try out boating at TGV Mall. There are 2 gondola ride canals which allow you to discover waterways for as long as you want. Check out our boating packs and don't forget an engagement because ring this is the best way to propose to your beloved!</p>
                    <div class="row">
                        <div class="col-md-3">
                            <h6>WORKING HOURS</h6>
                            <P>10 AM - 10 PM</P>
                        </div>
                        <div class="col-md-3">
                            <h6>WORKING DAYS</h6>
                            <P>All</P>
                        </div>
                        <div class="col-md-3">
                            <h6>AGE LIMIT</h6>
                            <P>3 Years</P>
                        </div>
                        <div class="col-md-3">
                            <h6>DURATION</h6>
                            <P>15 Minutes</P>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- #services -->
        <!--==========================
      Gallery Section
    ============================-->
        <section id="gallery">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;">
                        <div class="pic1">
                            <img src="<?php echo e(asset('public/images/Gandola-Gallery-1.jpg')); ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.4s" style="padding-right: 7.5px; padding-left: 7.5px;">
                        <div class="pic2">
                            <img src="<?php echo e(asset('public/images/Gandola-Gallery-2.jpg')); ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.6s" style="padding-right: 0;">
                        <div class="pic2">
                            <img src="<?php echo e(asset('public/images/Gandola-Gallery-3.jpg')); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- #gallery -->
        <!--==========================
      Aminities Section
    ============================-->
        <section id="aminities">
            <div class="container-fluid">
                <div class="row text-center">
                    <div class="col-12">
                        <div class="content">
                            <h2>THE GRAND VENICE</h2>
                            <h5>INDIA'S GRANDEST DESTINATION SHOPPING MALL AT GREATER NOIDA</h5>
                            <img src="<?php echo e(asset('public/images/GV-Underline.png')); ?>">
                            <p class="mt-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- #aminities -->
        <!--==========================
      GV Section
    ============================-->
        <section id="gv">
            <div class="container-fluid">
                <div class="row">
                    <ul class="list-inline">
                        <li class="list-inline-item GV011"><img src="<?php echo e(asset('public/images/GV01.jpg')); ?>" class="GV01"></li>
                        <li class="list-inline-item GV022"><img src="<?php echo e(asset('public/images/GV02.jpg')); ?>" class="GV02"></li>
                        <li class="list-inline-item GV033"><img src="<?php echo e(asset('public/images/GV03.jpg')); ?>" class="GV03"></li>
                        <li class="list-inline-item GV044"><img src="<?php echo e(asset('public/images/GV04.jpg')); ?>" class="GV04"></li>
                        <li class="list-inline-item GV055"><img src="<?php echo e(asset('public/images/GV05.jpg')); ?>" class="GV05"></li>
                    </ul>
                </div>
            </div>
        </section><!-- #gv -->
        <!--==========================
      Contact Section
    ============================-->
        <section id="contact">
            <div class="container wow fadeInUp">
                <div class="row justify-content-center">
                    <div class="col-md-3 col-12">
                        <h6>CONTACT DETAILS</h6>
                        <div class="info mt-4">
                            <p>ADDRESS :</p>
                            <p>Bhasin Infotech And Infrastructure Private Limited <br /> Plot No SH3, Site IV, Near Pari Chowk, Block B, <br /> Indutrial Area Surajpur Site 4, Greater Noida, <br /> Uttar Pradesh 201308</p>
                            <p>EMAIL : Info@Veniceindia.com</p>
                            <p>PHONE : 8860600059, 8860600051</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 service">
                        <h6>SERVICES</h6>
                        <ul class="mt-4">
                            <li><a href="javascript:;">Gandola Rides</a></li>
                            <li><a href="javascript:;">Masti Activities</a></li>
                            <li><a href="javascript:;">Combo Packs</a></li>
                            <li><a href="javascript:;">Privacy Ploicies</a></li>
                            <li><a href="javascript:;">Terms & Conditions</a></li>
                            <li><a href="javascript:;">Refund & Cancellation Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-12 social">
                        <h6>SOCIAL</h6>
                        <ul class="mt-4">
                            <li><a href="javascript:;"><img src="<?php echo e(asset('public/images/Social-Icon-Facebook.png')); ?>">&nbsp;&nbsp; Facebook</a></li>
                            <li><a href="javascript:;"><img src="<?php echo e(asset('public/images/Social-Icon-Twitter.png')); ?>">&nbsp;&nbsp; Twitter</a></li>
                            <li><a href="javascript:;"><img src="<?php echo e(asset('public/images/Social-Icon-Instagram.png')); ?>">&nbsp;&nbsp; Instagram</a></li>
                            <li><a href="javascript:;"><img src="<?php echo e(asset('public/images/Social-Icon-Youtube.png')); ?>">&nbsp;&nbsp; Youtube</a></li>
                            <li><a href="javascript:;"><img src="<?php echo e(asset('public/images/Social-Icon-Whatsapp.png')); ?>">&nbsp;&nbsp; Whatsapp</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-12">
                        <h6>RATE US</h6>
                        <div class="TripAdvisor mt-4">
                            <img src="<?php echo e(asset('public/images/TripAdvisor.png')); ?>">
                            <p>Know better, Book better, Go better,</p>
                            <hr />
                            <strong><a target="_blank" href="https://www.tripadvisor.in/Attraction_Review-g2140594-d11914631-Reviews-The_Grand_Venice_Mall-Greater_Noida_Uttar_Pradesh.html">Review The Grand Venice Mall</a></strong>
                            <form action="https://www.tripadvisor.in/UserReview-g2140594-d11914631-The_Grand_Venice_Mall-Greater_Noida_Uttar_Pradesh.html" target="_blank" name="cdsWRLForm2214" id="cdsWRLForm2214" onsubmit="ta.cds.handleTALink(12097,this);return false;"> 
                                <input type="hidden" id="rating02214" value="(Click to rate)">
                                 <input type="hidden" id="rating12214" value="Terrible">
                                  <input type="hidden" id="rating22214" value="Poor"> 
                                  <input type="hidden" id="rating32214" value="Average">
                                   <input type="hidden" id="rating42214" value="Very Good"> 
                                   <input type="hidden" id="rating52214" value="Excellent">
                                    <input type="hidden" id="defaultTitle2214" value="Title your review - Describe your stay in one sentence or less. ">
                                     <input type="hidden" id="reviewTitle2214" name="ReviewTitle">
                                <div class="widWRLRating"> 
                                    <input type="hidden" name="qid10" id="qid102214" value="0"> <span class="widWRLRate ui_bubble_rating bubble_00" id="ratingSpan" onclick="return selectRating(this, event, true, 2214);" onmousemove="return selectRating(this, event, false, 2214);" onmouseout="return lastSetRating(this, 2214);"> </span> <span id="ratingText2214" class="widWRLRatingText">(Click to rate)</span>
                                     </div>
                                <div class="widWRLReview">
                                 <textarea id="taWRLTitle2214" onfocus="initTextArea(this);" rows="3" cols="30" onkeypress="limitLength(this, 120);">Title your review - Describe your stay in one sentence or less. </textarea>
                                  </div>
                                <div class="widWRLButton">
                                 <input type="submit" id="taWRLContinue2214" name="taWRLContinue2214" value="Continue" onclick="checkTextArea(2214);" style="background:url(https://static.tacdn.com/img2/sprites/yellow-button.png) 0 0 repeat-x #EA9523;"> 
                             </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- #contact -->
    </main>
    <!--==========================
    Footer
  ============================-->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                &copy; 2019 The Grand Venice Mall, Venture of Bhasin Infotech & Infrastructure Private Limited
            </div>
        </div>
    </footer><!-- #footer -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <!-- JavaScript Libraries -->
    <script src="<?php echo e(asset('public/lib/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/jquery/jquery-migrate.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/easing/easing.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/wow/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/waypoints/waypoints.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/counterup/counterup.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/superfish/hoverIntent.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/superfish/superfish.min.js')); ?>"></script>
    <!-- Contact Form JavaScript File -->
    <!-- Template Main Javascript File -->
    <script src="<?php echo e(asset('public/js/main.js')); ?>"></script>
    <script type="text/javascript">
    $('.btn-number').click(function(e) {
        e.preventDefault();

        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function() {
        $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {

        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }


    });
    $(".input-number").keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    </script>
    <script type="text/javascript">
    $('#tab1').on('click', function(e) {
        e.preventDefault()
        $('#tab11').addClass('active');
        $('#tab22').removeClass('active');
        $('#tab1').addClass('active');
        $('#tab2').removeClass('active');
    })
    $('#tab2').on('click', function(e) {
        e.preventDefault()
        $('#tab11').removeClass('active');
        $('#tab22').addClass('active');
        $('#tab1').removeClass('active');
        $('#tab2').addClass('active');
    })
    </script>
    <script type="text/javascript" src="js/bootstrap-pincode-input.js"></script>
    <script>
    $(document).ready(function() {
        $('#pincode-input1').pincodeInput({
            hidedigits: false,
            complete: function(value, e, errorElement) {

                $("#pincode-callback").html("This is the 'complete' callback firing. Current value: " + value);


            }
        });
    });
    </script>
    <!-- datepicker -->
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#timepicker').timepicker();
    </script>
</body>

</html>
<?php /* C:\xampp\nxampp\htdocs\venice\resources\views/layouts/main.blade.php */ ?>