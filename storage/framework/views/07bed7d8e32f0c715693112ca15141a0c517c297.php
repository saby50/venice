<?php $__env->startSection('title'); ?>
Food Court
<?php $__env->stopSection(); ?>
<?php $__env->startSection('includes'); ?>
     <meta property="og:title" content="The Grand Venice Mall | Food Court">
    <meta property="og:description" content="Endless Food Options To Serve Your Appetite">
     <meta property="og:image" content="<?php echo e(asset('public/images/GV03.jpg')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div class="sideicons desktop">
     <a href="<?= URL::to('food-court') ?>" data-placement="left"  data-toggle="tooltip" title="Food Court"><img src="<?php echo e(asset('public/images/pages/foodcourticon.png')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/pages/foodcourticona.png")); ?>'"  onmouseout="this.src='<?php echo e(asset("public/images/pages/foodcourticon.png")); ?>'"></a>

      <br />
      <a href="<?= URL::to('fine-dining') ?>" data-placement="left" data-toggle="tooltip" title="Fine Dining
"><img src="<?php echo e(asset('public/images/pages/finediningicon.png')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/pages/finediningicona.png")); ?>'"  onmouseout="this.src='<?php echo e(asset("public/images/pages/finediningicon.png")); ?>'"></a>
         <br />
      <a href="<?= URL::to('cafe-bakeries') ?>" data-placement="left" data-toggle="tooltip" title="Cafe & Bakeries
"><img src="<?php echo e(asset('public/images/pages/bakeryicon.png')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/pages/bakeryicona.png")); ?>'"  onmouseout="this.src='<?php echo e(asset("public/images/pages/bakeryicon.png")); ?>'"></a>
      
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
        <img data-u="image" src="<?php echo e(asset('public/images/pages/foodcourtm.jpg')); ?>"  class="mobile" />
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
                <img data-u="image" src="<?php echo e(asset('public/images/pages/foodcourt.jpg')); ?>" class="desktop" />
                <img data-u="image" src="<?php echo e(asset('public/images/pages/foodcourtm.jpg')); ?>" class="mobile" />
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
        <div data-u="arrowleft" class="jssora051 hidearrows" style="width:65px;height:65px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
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
                    <a href="<?= URL::to('terrazzo#bmenu') ?>"><img src="<?php echo e(asset('public/images/foodcourta.jpg')); ?>"></a>
                    
                    <div class="title"><p>Food Court</p></div>
                </div>
            </div>
            <div class="col-4">
                <div class="pack pk2">
                    <a href="<?= URL::to('urzaa#bmenu') ?>"><img src="<?php echo e(asset('public/images/finedine.jpg')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/finedinea.jpg")); ?>'" onmouseout="this.src='<?php echo e(asset("public/images/finedine.jpg")); ?>'"></a>
                   
                    <div class="title"><p>Fine Dining</p></div>
                </div>
            </div>
            <div class="col-4">
                <div class="pack pk3">
                    <a href="<?= URL::to('bakery#bmenu') ?>"><img src="<?php echo e(asset('public/images/bakery.jpg')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/bakerya.jpg")); ?>'" onmouseout="this.src='<?php echo e(asset("public/images/bakery.jpg")); ?>'"></a>
                
                    <div class="title"><p>Cafe & Bakeries</p></div>
                </div>
            </div>
        </div>
    </div>
     
  <!--==========================
      About Section
    ============================-->
        <section id="about">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-12">
                       <?php if(Helper::check_mobile()==1): ?>
                        <br /><br /><br /><br />
                        <iframe width="100%" height="250" class="youtube-video" src="https://www.youtube.com/embed/OFbtMaD6XAA?start=2" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                         <?php else: ?>
                          <img src="<?php echo e(asset('public/images/pages/foodcourtvid.png')); ?>">
                        
                        <a href="javascript:;" class="modalclick" data-toggle="modal" data-target="#myModal"><img src="<?php echo e(asset('public/images/home/Video-Play-Btn.png')); ?>" class="img-responsive center playBtn" style="height: auto;"></a>

                           <?php endif; ?>
                        
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="section-header">
                       
                    

  <h2 class="section-title">Endless Food Options</h2>
                            <h3>To Serve Your Appetite</h3>
                          
                      <p>The grandest food court awaits you at The Grand Venice. We understand that food is an important part for every family outing. This is why we offer you the best of food options under our roof.  Choose from the best cuisines and delicacies of your liking.  Here you will be spoilt for choices. So get set to treat your taste buds. 
</p>

                        </div>
                    </div>
                </div>
            </div>
        </section><!-- #About -->
    <!--==========================
      Logo Section
    ============================-->

 <section id="logoarea">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <marquee  scrollamount="15">
                            <img src="<?php echo e(asset('public/images/gallery/foodcourt/1.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/2.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/3.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/4.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/5.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/6.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/7.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/8.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/9.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/10.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/11.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/12.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/13.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/14.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/15.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/16.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/17.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/18.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/19.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/20.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/21.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/22.jpg')); ?>">
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/23.jpg')); ?>">
                        </marquee>
                    </div>
                    
                </div>
            </div>
        </section>

    <!-- #Logo -->
     
          <!--==========================
      Gallery Section
    ============================-->
        <section id="gallery">
       <?php if (Helper::check_mobile()==1): ?>
  <div style="width: 100%;overflow-x: scroll;height: 250px;position: relative;">
  <ul class="mobile-slider2">
                <li>
                   <img src="<?php echo e(asset('public/images/gallery/foodcourt/court1.jpg')); ?>">
                 </li>
                    <li>
                   <img src="<?php echo e(asset('public/images/gallery/foodcourt/court2.jpg')); ?>">
                 </li> 
                  <li>
                   <img src="<?php echo e(asset('public/images/gallery/foodcourt/court3.jpg')); ?>">
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
                            <img src="<?= asset('public/images/gallery/foodcourt/court1.jpg') ?>">
                        </div>
                    </div>
                 <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;">
                        <div class="pic1">
                            <img src="<?= asset('public/images/gallery/foodcourt/court3.jpg') ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;">
                        <div class="pic1">
                            <img src="<?= asset('public/images/gallery/foodcourt/court2.jpg') ?>">
                        </div>
                    </div>
                </div>
            </div>
          <?php endif; ?>

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
        <button type="button" class="close" data-dismiss="modal">??</button>
      </div>
      <div class="modal-body">
      <iframe width="750" height="400" class="youtube-video" src="https://www.youtube.com/embed/OFbtMaD6XAA?start=2" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
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
               $('.youtube-video').attr('src','https://www.youtube.com/embed/OFbtMaD6XAA?start=2&autoplay=1');
              
        });
        $("#myModal .close").click(function() {
           $('.youtube-video').attr('src','https://www.youtube.com/embed/OFbtMaD6XAA?start=2');
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
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/pages/terrazzo.blade.php ENDPATH**/ ?>