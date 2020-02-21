<?php $__env->startSection('title'); ?>
<?= $data[0]->shop_name ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('includes'); ?>
     <meta property="og:title" content="The Grand Venice Mall | <?= $data[0]->shop_name ?>">
    <meta property="og:description" content="<?= $data[0]->teaser_line_1 ?> <?= $data[0]->teaser_line_2 ?>">
    <meta property="og:image" content="<?= asset('public/uploads/forground/'.$data[0]->banner) ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta'); ?>
<meta name="robots" content="noindex, follow">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 <?php 
   $banner = ""; $banner_mobile = "";
   $description = ""; $category_name = "";
   $floor_level = ""; $number_unit = "";
   $teaser_line_1 = ""; $teaser_line_2 = "";
   foreach ($data as $key => $value) {
       $banner = $value->banner;
       $banner_mobile = $value->banner_mobile;
       $description = $value->description;
       $category_name = $value->category_name;
       $floor_level = $value->floor_level;
       $number_unit = $value->number_unit;
       $teaser_line_1 = $value->teaser_line_1;
       $teaser_line_2 = $value->teaser_line_2;
   }

 ?>
  <!--==========================
    Hero Section
  ============================-->
  <?php if(Helper::check_mobile()==1): ?>
      <div class="slider-pwa">
        <img data-u="image" src="<?= asset('public/uploads/mobile_banner/'.$banner_mobile) ?>" class="mobile" />
      </div>
  <?php else: ?>
    <section id="" class="homehero" style="z-index: 1;">
       
    
          <div id="jssor_1" style="position:relative;margin:0 auto;top:-108px;left:0px;width:1300px;height:550px;overflow:hidden;visibility:hidden;z-index: 1;">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="<?php echo e(asset('public/svg/loading/static-svg/spin.svg')); ?>" />
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1300px;height:550px;overflow:hidden;">
            <div>
                <img data-u="image" src="<?= asset('public/uploads/forground/'.$banner) ?>" class="desktop" />
                <img data-u="image" src="<?= asset('public/uploads/mobile_banner/'.$banner_mobile) ?>" class="mobile" />
            </div>
         
            
            
          
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb032 hidearrows" style="position:absolute;bottom:12px;right:12px;display: none;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i" style="width:16px;height:16px;">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                </svg>
            </div>
        </div>
        <!-- Arrow Navigator -->
        <div data-u="arrowleft" class="jssora051 hidearrows"  style="width:65px;height:65px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
            </svg>
        </div>
        <div data-u="arrowright" class="jssora051" style="width:65px;height:65px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
            </svg>
        </div>
    </div>
   

 
    </section> 
   <?php endif; ?>
    <!-- #hero -->
   
         <!--==========================
      Services Section
    ============================-->
        <section id="services" style="margin-top: -80px;">
            <div class="container wow fadeIn">
                <div class="section-header text-center">
                    <h4><?= $teaser_line_1 ?></h4>
                    <h3 class="section-title"><?= $teaser_line_2 ?></h3>
                    <p class="section-description"><?= $description ?></p>
                
                </div>
            </div>
            <div class="row incluions-box eventbox">
                     
                            <div class="col-2 incluions-title">
                                <img src="<?php echo e(asset('public/images/inclusionicons.jpg')); ?>">Details
                            </div>
                            <div class="col-9 inclusion-content">
                                <ul class="inclusions">
                                    
                                   
                                    <li><?= $category_name ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $floor_level ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $number_unit ?></li>
                   
                                </ul>
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
         <!--==========================
      About Section
    ============================-->
        <section id="about" style="display: none;">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-12">
                        <img src="<?php echo e(asset('public/images/pages/urzaavid.png')); ?>">
                        
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="section-header">
                         <h2><span class="section-title" style="color: #ef8e11;">Specially Curated</span> <span style="color: #000 !important;">World-Class Dine-In</span> </h2>                           
                            <p class="section-description p-2">What do you like about dining out?  Enjoying your favorite food,  with your loved ones in a truly beautiful environment.  The ambience here will win you over,  the food here will make you fall in love and the service will make you come back again and again. Step in for this and much more.  You will want to come back as soon as you step out.  
 </p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </section><!-- #About -->
          <!--==========================
      Gallery Section
    ============================-->
        <section id="gallery" style="display: none;">
            <div class="container-fluid">
                <div class="row">
                     <div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="9000" style="">
                            <div class="carousel-inner row w-100 mx-auto" role="listbox">
                    <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;">
                        <div class="pic1">
                            <img src="<?= asset('public/images/gallery/finedine/urzaa1.jpg') ?>">
                        </div>
                    </div>
                 <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;">
                        <div class="pic1">
                            <img src="<?= asset('public/images/gallery/finedine/urzaa2.jpg') ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;">
                        <div class="pic1">
                            <img src="<?= asset('public/images/gallery/finedine/urzaa3.jpg') ?>">
                        </div>
                    </div>
                </div>
            </div>
</section>
        <!--==========================
      Aminities Section
    ============================-->
<?php echo $__env->make('include/subfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div id="myModal" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
      <iframe width="750" height="400" class="youtube-video" src="https://www.youtube.com/embed/yCEKoHTJUmE?start=2" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
      </div>
    </div>

  </div>
</div>
<script src="<?php echo e(asset('public/js/jssor.slider.min.js')); ?>" type="text/javascript"></script>
    <style type="text/css">
        #hero {
  margin-top: -6.8%;
  width: 100%;
  height: 100vh;

  background-size: contain;
  position: relative;
}
#myModal iframe  {
  width: 100%;
}



    </style>
<script type="text/javascript">
        jssor_1_slider_init = function() {

            var jssor_1_options = {
              $AutoPlay: 1,
              $SlideDuration: 800,
              $SlideEasing: $Jease$.$OutQuint,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
              }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*#region responsive code begin*/

            var MAX_WIDTH = 3000;

            function ScaleSlider() {
                var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {

                    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                    jssor_1_slider.$ScaleWidth(expectedWidth);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

            ScaleSlider();

            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*#endregion responsive code end*/
        };
    </script>
    <style>
   
        /*jssor slider loading skin spin css*/
        .jssorl-009-spin img {
            animation-name: jssorl-009-spin;
            animation-duration: 1.6s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes  jssorl-009-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /*jssor slider bullet skin 032 css*/
        .jssorb032 {position:absolute;}
        .jssorb032 .i {position:absolute;cursor:pointer;}
        .jssorb032 .i .b {fill:#fff;fill-opacity:0.7;stroke:#000;stroke-width:1200;stroke-miterlimit:10;stroke-opacity:0.25;}
        .jssorb032 .i:hover .b {fill:#000;fill-opacity:.6;stroke:#fff;stroke-opacity:.35;}
        .jssorb032 .iav .b {fill:#000;fill-opacity:1;stroke:#fff;stroke-opacity:.35;}
        .jssorb032 .i.idn {opacity:.3;}
        
        /*jssor slider arrow skin 051 css*/
        .jssora051 {display:block;position:absolute;cursor:pointer;}
        .jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
        .jssora051:hover {opacity:.8;}
        .jssora051.jssora051dn {opacity:.5;}
        .jssora051.jssora051ds {opacity:.3;pointer-events:none;}
    </style>
    <script type="text/javascript">jssor_1_slider_init();</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/shops/single-shop.blade.php ENDPATH**/ ?>