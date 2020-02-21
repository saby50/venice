@extends('layouts.main2')

@section('title')
Home
@endsection

@section('content')
  <!--==========================
    Hero Section
  ============================-->
    <section id="" class="homehero">
       
    
          <div id="jssor_1" style="position:relative;margin:0 auto;top:-108px;left:0px;width:1300px;height:500px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="../svg/loading/static-svg/spin.svg" />
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1300px;height:500px;overflow:hidden;">
            <div>
                <img data-u="image" src="{{ asset('public/images/home/banner1.jpg') }}" />
                <div class="teaserline1" style=""><strong>The Best Of Venice Awaits</strong>
                <br />
                <h4>Near Pari Chowk, Greater Noida</h4>

                </div>
            </div>
            <div>
                <img data-u="image" src="{{ asset('public/images/home/banner2.jpg') }}" />
                <div class="teaserline2"><strong>Get Set To Witness Splendid Beauty</strong>
                 <br />
                <h4>Along With World-Class Shopping</h4>

                </div>
            </div>
            
             <div>
                <img data-u="image" src="{{ asset('public/images/home/banner3.jpg') }}" />
           <div  class="teaserline1"><strong>A Matchless Architecture </strong>

              <br />
                <h4>Designed To Steal Hearts</h4>

                </div>
            </div>
          
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb032" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i" style="width:16px;height:16px;">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                </svg>
            </div>
        </div>
        <!-- Arrow Navigator -->
        <div data-u="arrowleft" class="jssora051" style="width:65px;height:65px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
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
   

 
    </section> <!-- #hero
    <main id="main">

    ==========================
      Packages Section
    ============================-->
    <div id="packages" class="wow fadeInDown">
        <div class="row" style="width: 100%; text-align: center; margin-left: 0; margin-right: 0; padding-top: 0.5rem; padding-bottom: 0.5rem;">
            <div class="col-4">
                <div class="pack pk1">
                    <a href="<?= URL::to('categories/#gondolaride') ?>"><img src="{{ asset('public/images/home/Icon-Gondola.jpg') }}" onmouseover="this.src='{{ asset("public/images/home/Icon-Gondola-a.jpg") }}'" onmouseout="this.src='{{ asset("public/images/home/Icon-Gondola.jpg") }}'"></a>
                    
                    <div class="title"><p>Gondola Rides</p></div>
                </div>
            </div>
            <div class="col-4">
                <div class="pack pk2">
                    <a href="<?= URL::to('categories/#mastizone') ?>"><img src="{{ asset('public/images/home/Icon-Masti-Zone.jpg') }}" onmouseover="this.src='{{ asset("public/images/home/Icon-Masti-Zone-a.jpg") }}'" onmouseout="this.src='{{ asset("public/images/home/Icon-Masti-Zone.jpg") }}'"></a>
                   
                    <div class="title"><p>Masti Activities</p></div>
                </div>
            </div>
            <div class="col-4">
                <div class="pack pk3">
                    <a href="<?= URL::to('categories/#packs') ?>"><img src="{{ asset('public/images/home/Icon-Packs.jpg') }}" onmouseover="this.src='{{ asset("public/images/home/Icon-Packs-a.jpg") }}'" onmouseout="this.src='{{ asset("public/images/home/Icon-Packs.jpg") }}'"></a>
                
                    <div class="title"><p>GV Packs</p></div>
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
                        <img src="{{ asset('public/images/home/GV-Video.png') }}">
                        <a href="javascript:;" class="modalclick" data-toggle="modal" data-target="#myModal"><img src="{{ asset('public/images/home/Video-Play-Btn.png') }}" class="img-responsive center playBtn" style="height: auto;"></a>
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="section-header">
                            <h2 class="section-title">About us</h2>
                            <h3>Unlimited Fun, Food & Shopping<br /> At NCR's Biggest Tourist Attraction</h3>
                            <p class="section-description p-2">Do you want a perfect day out? Come to the Grand Venice Mall. The perfect destination for everyone who wants to have some fun and shop to their heart's delight. NCR's biggest tourist attraction featuring the best of architectural elements from Venice beckon you to experience unlimited happiness. </p>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- #About -->

        
       
        <!--==========================
      featured Section
    ============================-->
         <section id="featured">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 featured_content">
                        <div class="section-header">
                            <h2 class="section-title">Exciting</h2>
                            <h3 style="text-align: center;">Featured Products</h3>
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
           <!--==========================
      Logo Section
    ============================-->
 <section id="logoarea">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <marquee class="homemarquee"  scrollamount="15">
                            <a href="{{ URL::to('terrazzo') }}"><img src="{{ asset('public/images/gallery/foodcourt/1.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/2.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/3.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/4.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/5.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/6.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/7.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/8.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/9.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/10.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/11.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/12.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/13.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/14.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/15.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/16.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/17.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/18.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/19.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/20.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/21.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/22.jpg') }}">
                             <img src="{{ asset('public/images/gallery/foodcourt/23.jpg') }}"></a>
                        </marquee>
                    </div>
                    
                </div>
            </div>
        </section>

    <!-- #Logo -->
        <!--==========================
      Gallery Section
    ============================-->
        <section id="gallery" style="display: none;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;z-index: 999">
                        <div class="pic1">
                            <a href="<?= URL::to('packs/combo-pack') ?>"><img src="{{ asset('public/images/home/Unlimited-Banner.jpg') }}" class="web_banner"></a>
                           <a href="<?= URL::to('packs/combo-pack') ?>"> <img src="{{ asset('public/images/mobile/Unlimited-Banner.jpg') }}" class="mobile_banner"></a>
                            <a href="<?= URL::to('packs/combo-pack') ?>" style="z-index: 999;" class="btn btn-info">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- #gallery -->
        <!--==========================
      Aminities Section
    ============================-->
@include('include/subfooter')
   <div id="myModal" class="modal fade" role="dialog" aria-hidden="false" style="display: none;">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
      <iframe width="750" height="400" class="youtube-video" src="https://www.youtube.com/embed/yCEKoHTJUmE?start=2&autoplay=" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
      </div>
    </div>

  </div>
</div>
<script src="{{ asset('public/js/jssor.slider.min.js') }}" type="text/javascript"></script>
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

        @keyframes jssorl-009-spin {
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
@endsection