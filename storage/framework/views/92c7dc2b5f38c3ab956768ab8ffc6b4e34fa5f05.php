<?php $__env->startSection('title'); ?>
Categories
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!--==========================
    Hero Section
  ============================-->
    <section id="" class="homehero" style="z-index: 1;">
       
    
          <div id="jssor_1" style="position:relative;margin:0 auto;top:-108px;left:0px;width:1300px;height:550px;overflow:hidden;visibility:hidden;z-index: 1;">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="<?php echo e(asset('public/svg/loading/static-svg/spin.svg')); ?>" />
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1300px;height:550px;overflow:hidden;">
        
            <div>
                <img data-u="image" src="<?php echo e(asset('public/images/404.jpg')); ?>" class="desktop" />
                <img data-u="image" src="<?php echo e(asset('public/images/404m.jpg')); ?>" class="mobile" />
            </div>
            
            
        
          
        </div>
       
       
    </div>
   

 
    </section> <!-- #hero -->
<section class="hero2" style="margin-top: 20px;">
<div class="container">
	<div class="row">
                	<?php foreach($categories as $key => $value): ?>
                		<?php 
                         	list($a,$b) = explode('_', $key);  
                         	
                         	?>
                         	
                         <div class="col-12">   
                         <a name="<?= $b ?>"></a>                      	
                         	<h4><?php 
                      
                         	echo $a; 
                         	?></h4>
                         	
                         	<hr />
                         	<div class="carousel-inner row w-100 mx-auto" role="listbox">
                         		 <?php foreach($value as $k => $v): ?>
                                <div class=" col-md-4" style="margin-bottom: 40px;">
                                    <div class="panel panel-default">
                                        <div class="panel-thumbnail">
                                                <img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured/'.$v->featured_image) ?>" alt="slide 1">
                                            <div class="title" style="text-align: center;">
                                                <strong> <?= $v->service_name ?></strong>
                                            </div>
                                            <div class="desc" style="text-align: center;">
                                                <?php $short = $v->short_description;
                                                     echo Helper::truncate($short,60);
                                                 ?>
                                            </div>
                                            <div class="price" style="text-align: center;margin-top: 20px;">
                                               
                                                <a href="<?= URL::to('booking/'.$v->alias) ?>" class="btn btn-info">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                
                           </div>
                            <?php endforeach; ?>


                         	</div>

                         	
                         </div>
                	<?php endforeach; ?>

                	 <div class="col-12">
                	 	<a name="packs"></a>
                         	<h4>GV Packs</h4>
                         	<hr />
                    <div class="carousel-inner row w-100 mx-auto" role="listbox">

                    <?php foreach($packs as $k => $v): ?>
                    	<div class=" col-md-4" style="margin-bottom: 40px;">
                                    <div class="panel panel-default">
                                        <div class="panel-thumbnail">
                                                <img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured/'.$v->featured_image) ?>" alt="slide 1">
                                            <div class="title" style="text-align: center;">
                                                <strong> <?= $v->pack_name ?></strong>
                                            </div>
                                            <div class="desc" style="text-align: center;">
                                                <?php $short = $v->short_description;
                                                     echo Helper::truncate($short,60);
                                                 ?>
                                            </div>
                                            <div class="price" style="text-align: center;margin-top: 20px;">
                                               
                                                <a href="<?= URL::to('packs/'.$v->alias) ?>" class="btn btn-info">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                       
                  	<?php endforeach; ?>

                  </div>

                     </div>


                </div>
                
            </div>
        </section>

<style type="text/css">
	p {
		text-align: justify;
	}
</style>
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
        $(".homehero").click(function() {
          $(".homehero").css('cursor','pointer');
            window.location = "<?= URL::to('events/gudgudi-with-parvinder-singh#bookingform') ?>";
        });

        $(".modalclick").click(function() {
           $('#myModal').modal({backdrop: 'static', keyboard: false});
               $('.youtube-video').attr('src','https://www.youtube.com/embed/yCEKoHTJUmE?start=2&autoplay=1');
              
        });
        $("#myModal .close").click(function() {
           $('.youtube-video').attr('src','https://www.youtube.com/embed/yCEKoHTJUmE?start=2');
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
<?php echo $__env->make('include/subfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/errors/404.blade.php ENDPATH**/ ?>