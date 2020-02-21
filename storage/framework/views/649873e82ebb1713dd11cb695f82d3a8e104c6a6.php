<?php $__env->startSection('title'); ?>
Fine Dining
<?php $__env->stopSection(); ?>
<?php $__env->startSection('includes'); ?>
     <meta property="og:title" content="The Grand Venice Mall | Fine Dining">
    <meta property="og:description" content="A Memorable Fine Dining Experience">
     <meta property="og:image" content="<?php echo e(asset('public/images/GV03.jpg')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div class="sideicons desktop">
     <a href="<?= URL::to('food-court') ?>" data-placement="left"  data-toggle="tooltip" title="Food Court"><img src="<?php echo e(asset('public/images/pages/foodcourticon.png')); ?>" onmouseover="this.src='<?php echo e(asset('public/images/pages/foodcourticona.png')); ?>'"  onmouseout="this.src='<?php echo e(asset('public/images/pages/foodcourticon.png')); ?>'"></a>

      <br />
      <a href="<?= URL::to('fine-dining') ?>" data-placement="left" data-toggle="tooltip" title="Fine Dining
"><img src="<?php echo e(asset('public/images/pages/finediningicon.png')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/pages/finediningicona.png")); ?>'"  onmouseout="this.src='<?php echo e(asset('public/images/pages/finediningicon.png')); ?>'"></a>
         <br />
      <a href="<?= URL::to('cafe-bakeries') ?>" data-placement="left" data-toggle="tooltip" title="Cafe & Bakeries
"><img src="<?php echo e(asset('public/images/pages/bakeryicon.png')); ?>" onmouseover="this.src='<?php echo e(asset('public/images/pages/bakeryicona.png')); ?>'"  onmouseout="this.src='<?php echo e(asset('public/images/pages/bakeryicon.png')); ?>'"></a>
      
    </div>
    <script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
  <!--==========================
    Hero Section
  ============================-->
   <?php if(Helper::check_mobile()==1): ?>
      <div class="slider-pwa">
        <img data-u="image" src="<?php echo e(asset('public/images/pages/finedininga.jpg')); ?>"  class="mobile" />
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
                <img data-u="image" src="<?php echo e(asset('public/images/pages/finedining.jpg')); ?>" class="desktop" />
                <img data-u="image" src="<?php echo e(asset('public/images/pages/finedininga.jpg')); ?>" class="mobile" />
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
     <!-- #hero
    <main id="main">

    ==========================
      Packages Section
    ============================-->
    <a name="bmenu"></a>
    <div id="packages" class="wow fadeInDown" style="display: none;">
        <div class="row" style="width: 100%; text-align: center; margin-left: 0; margin-right: 0; padding-top: 0.5rem; padding-bottom: 0.5rem;">
            <div class="col-4">
                <div class="pack pk1">
                    <a href="<?= URL::to('terrazzo#bmenu') ?>"><img src="<?php echo e(asset('public/images/foodcourt.jpg')); ?>" onmouseover="this.src='<?php echo e(asset('public/images/foodcourta.jpg')); ?>'" onmouseout="this.src='<?php echo e(asset('public/images/foodcourt.jpg')); ?>'"></a>
                    
                    <div class="title"><p>Food Court</p></div>
                </div>
            </div>
            <div class="col-4">
                <div class="pack pk2">
                    <a href="<?= URL::to('urzaa#bmenu') ?>"><img src="<?php echo e(asset('public/images/finedinea.jpg')); ?>"></a>
                   
                    <div class="title"><p>Fine Dining</p></div>
                </div>
            </div>
            <div class="col-4">
                <div class="pack pk3">
                    <a href="<?= URL::to('bakery#bmenu') ?>"><img src="<?php echo e(asset('public/images/bakery.jpg')); ?>" onmouseover="this.src='<?php echo e(asset('public/images/bakerya.jpg')); ?>'" onmouseout="this.src='<?php echo e(asset('public/images/bakery.jpg')); ?>'"></a>
                
                    <div class="title"><p>Cafe & Bakeries</p></div>
                </div>
            </div>
        </div>
    </div>
        <!--==========================
      About Section
    ============================-->
        <section id="about" style="background: url(<?php echo e(asset('public/images/pages/bg1.jpg')); ?>);background-repeat: no-repeat;padding: 40px;">
            <div class="container">
                <div class="row">
                  <div class="col-md-5 col-12">
                    <?php if(Helper::check_mobile()==1): ?>
                        <br /><br /><br /><br />
                        <iframe width="100%" height="250" class="youtube-video" src="https://www.youtube.com/embed/O2YpPz9mFxU?start=2" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                         <?php else: ?>
                          <img src="<?php echo e(asset('public/images/pages/bohemiavid.png')); ?>">
                         
                        <a href="javascript:;" class="modalclick" data-toggle="modal" data-target="#myModal"><img src="<?php echo e(asset('public/images/home/Video-Play-Btn.png')); ?>" class="img-responsive center playBtn" style="height: auto;"></a>

                           <?php endif; ?>
                       
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="section-header">
                 

<h2 class="section-title">A Memorable</h2>
                            <h3>Fine Dining Experience</h3>
                          
                      <p>Step in to enjoy a fine dining experience that you would never forget.  The ambience will engulf you and the romance in the air will make you feel amazing. Designed for an overwhelming experience for your senses and your taste buds; enjoying a meal here with family should be on the top of your list of priorities. 
</p>
</div>
                    </div>
                </div>
            </div>
        </section><!-- #About -->
    <!--==========================
      Gallery Section
    ============================-->
        <section id="gallery">
           <?php if (Helper::check_mobile()==1): ?>
  <div style="width: 100%;overflow-x: scroll;height: 250px;position: relative;">
  <ul class="mobile-slider2">
                <li>
                   <img src="<?php echo e(asset('public/images/gallery/finedine/bohemia1.jpg')); ?>">
                 </li>
                    <li>
                   <img src="<?php echo e(asset('public/images/gallery/finedine/bohemia2.jpg')); ?>">
                 </li> 
                  <li>
                   <img src="<?php echo e(asset('public/images/gallery/finedine/bohemia3.jpg')); ?>">
                 </li> 
                   
                </ul>
                </div>
            <?php else: ?>

            <div class="container-fluid">
                <div class="row">
                     <div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="9000" style="">
                            <div class="carousel-inner row w-100 mx-auto" role="listbox">
                    <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;">
                        <div class="pic1">
                            <img src="<?= asset('public/images/gallery/finedine/bohemia1.jpg') ?>">
                        </div>
                    </div>
                 <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;">
                        <div class="pic1">
                            <img src="<?= asset('public/images/gallery/finedine/bohemia2.jpg') ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;">
                        <div class="pic1">
                            <img src="<?= asset('public/images/gallery/finedine/bohemia3.jpg') ?>">
                        </div>
                    </div>
                </div>
            </div>
          <?php endif; ?>
           
</section>


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
      <iframe width="750" height="400" class="youtube-video" src="https://www.youtube.com/embed/O2YpPz9mFxU?start=2" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
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

      $(function() {
    
        $(".modalclick").click(function() {
           $('#myModal').modal({backdrop: 'static', keyboard: false});
               $('.youtube-video').attr('src','https://www.youtube.com/embed/O2YpPz9mFxU?start=2&autoplay=1');
              
        });
        $("#myModal .close").click(function() {
           $('.youtube-video').attr('src','https://www.youtube.com/embed/O2YpPz9mFxU?start=2');
        });
      });
    </script>
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
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/pages/urzaa.blade.php ENDPATH**/ ?>