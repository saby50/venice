<?php $__env->startSection('title'); ?>
Home
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <div class="sideicons desktop">
     <a href="<?= URL::to('categories/#gondolaride') ?>" data-placement="left"  data-toggle="tooltip" title="Gondola Ride"><img src="<?php echo e(asset('public/images/home/n/icongond.png')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/home/n/icongonda.png")); ?>'"  onmouseout="this.src='<?php echo e(asset("public/images/home/n/icongond.png")); ?>'"></a>

      <br />
      <a href="<?= URL::to('categories/#mastizone') ?>" data-placement="left" data-toggle="tooltip" title="Masti Activities
"><img src="<?php echo e(asset('public/images/home/n/iconmasti.png')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/home/n/iconmastia.png")); ?>'"  onmouseout="this.src='<?php echo e(asset("public/images/home/n/iconmasti.png")); ?>'"></a>
         <br />
      <a href="<?= URL::to('categories/#packs') ?>" data-placement="left" data-toggle="tooltip" title="GV Packs
"><img src="<?php echo e(asset('public/images/home/n/iconpack.png')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/home/n/iconpacka.png")); ?>'"  onmouseout="this.src='<?php echo e(asset("public/images/home/n/iconpack.png")); ?>'"></a>
    <?php if(count(Helper::get_events())!=0):  ?>
      <br />
      <a href="<?= URL::to('categories/#events') ?>" data-placement="left" data-toggle="tooltip" title="Events
"><img src="<?php echo e(asset('public/images/eventicon.png')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/eventicona.png")); ?>'"  onmouseout="this.src='<?php echo e(asset("public/images/eventicon.png")); ?>'"></a>
<?php endif; ?>
    </div>
    <script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
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
          <?php foreach($slider as $key => $value): ?>        
          <div>
                <a href="<?= URL::to($value->slider_link) ?>"><img data-u="image" src="<?= asset('public/uploads/banner/'.$value->banner) ?>" class="desktop" data="<?= URL::to($value->slider_link) ?>" /></a>
               <a href="<?= URL::to($value->slider_link) ?>"><img data-u="image" src="<?= asset('public/uploads/mobile_banner/'.$value->banner_mobile) ?>" data="<?= URL::to($value->slider_link) ?>" class="mobile" /></a>
          </div>
        <?php endforeach; ?>
           
          
          
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator"  class="jssorb032 hidearrows" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
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
        <div data-u="arrowright" class="jssora051 hidearrows" style="width:65px;height:65px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
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

    <div id="packages" class="wow fadeInDown" style="display: none;">
        <div class="row" style="width: 100%; text-align: center; margin-left: 0; margin-right: 0; padding-top: 0.5rem; padding-bottom: 0.5rem;">
            <div class="col-4">
                <div class="pack pk1">
                    <a href="<?= URL::to('categories/#gondolaride') ?>"><img src="<?php echo e(asset('public/images/home/Icon-Gondola.jpg')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/home/Icon-Gondola-a.jpg")); ?>'" onmouseout="this.src='<?php echo e(asset("public/images/home/Icon-Gondola.jpg")); ?>'"></a>
                    
                    <div class="title"><p>Gondola Rides</p></div>
                </div>
            </div>
            <div class="col-4">
                <div class="pack pk2">
                    <a href="<?= URL::to('categories/#mastizone') ?>"><img src="<?php echo e(asset('public/images/home/Icon-Masti-Zone.jpg')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/home/Icon-Masti-Zone-a.jpg")); ?>'" onmouseout="this.src='<?php echo e(asset("public/images/home/Icon-Masti-Zone.jpg")); ?>'"></a>
                   
                    <div class="title"><p>Masti Activities</p></div>
                </div>
            </div>
            <div class="col-4">
                <div class="pack pk3">
                    <a href="<?= URL::to('categories/#packs') ?>"><img src="<?php echo e(asset('public/images/home/Icon-Packs.jpg')); ?>" onmouseover="this.src='<?php echo e(asset("public/images/home/Icon-Packs-a.jpg")); ?>'" onmouseout="this.src='<?php echo e(asset("public/images/home/Icon-Packs.jpg")); ?>'"></a>
                
                    <div class="title"><p>GV Packs</p></div>
                </div>
            </div>
        </div>
    </div>
     <?php if(count($events)!=0): ?>
         <!--==========================
      featured Section
    ============================-->
         
            
                <div class="row">
                  <div class="col-12" style="margin-bottom: 40px;text-align: center;">
                   <a href="<?= URL::to('events/parmish-verma-live') ?>"><img src="<?= URL::to('public/images/event_desktop.jpg') ?>"></a>
                </div>
            </div>
        <!-- #featured -->
       <!--==========================
      featured Section
    ============================-->
  <?php endif; ?>
<?php 
$fstatus = "";
foreach ($enable_food_order as $key => $value) {
  $fstatus = $value->status;
}

?>
  <?php if($fstatus=="yes"): ?>
  <section id="foodarea">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 featured_content">
                        <div class="section-header">
                            <h2 class="section-title">Order</h2>
                            <h3 style="text-align: center;">Delicious Food</h3>
                           
                          
                        </div>
                    </div>
                </div>
                <div class="row">
                 <div class="col-12">
                       
                          
                              <?php foreach($foodorder as $key => $value): ?>
                              <a href="<?= URL::to('show-menu/all/'.Crypt::encrypt($value->id)) ?>"> <div class="foodbox row">
                                <div class="col-5">
                                  <?php if($value->enable_food_order=="yes"): ?>
                                 <?php if(file_exists('public/uploads/foodstore/'.$value->foodstore)): ?>
                <img class="img-fluid mx-auto d-block feature  food-img" src="<?= asset('public/uploads/foodstore/'.$value->foodstore) ?>" alt="<?= $value->foodstore ?>">
                
                <?php else: ?>
                  <img class="img-fluid mx-auto d-block feature" src="<?= asset('public/images/placeholder.jpg') ?>">
                <?php endif; ?>
                <?php else: ?>
                  <?php if(file_exists('public/uploads/foodstore/'.$value->foodstore)): ?>
                <div class="image-container"><img class="img-fluid mx-auto d-block feature  food-img" src="<?= asset('public/uploads/foodstore/'.$value->foodstore) ?>" alt="<?= $value->foodstore ?>"><div class="after"></div></div>
                
                <?php else: ?>
                  <div class="image-container"><img class="img-fluid mx-auto d-block feature" src="<?= asset('public/images/placeholder.jpg') ?>"><div class="after"></div></div>
                <?php endif; ?>
                <?php endif; ?>
                <br />
                <div style="font-size: 11px;color:#666;text-align: center;">Prep Time: <?= $value->prep_time ?></div>
                                  
                                </div>
                                <div class="col-7">
                                <span class="title"><?= $value->unit_name ?></span><br />
                <span class="desc"><?= $value->tags ?></span>
                <hr />
                 <div class="col-12" style="font-size: 8px;">
                                      <?php 
                                $nonveg = Helper::get_veg_non($value->id);
                      ?>
                      <?php if(in_array('veg', $nonveg)): ?>
                                        <img src="<?php echo e(asset('public/images/veg.png')); ?>" style="width: 15px;height: 15px;">
                                      <?php endif; ?>
                                      <?php if(in_array('nonveg', $nonveg)): ?>
                                         <img src="<?php echo e(asset('public/images/nonveg.png')); ?>" style="width: 15px;height: 15px;">
                                      <?php endif; ?>
                                       <div style="text-align: right;margin-top: -15px;color: #000;"> <i class='fa fa-rupee'></i> <?= $value->price_for_two ?> For Two</div>
                                    </div>

                                </div>
                                 
                                   
                               </div></a>
                            <?php endforeach; ?>
                           

                               
                    </div>        
                     <div class="col-md-12" style="margin-top: 40px;text-align: center;">
                              <a href="<?= URL::to('foodorder#restaurants') ?>" class="btn btn-info">View All</a>
                              
                            </div>   
                 </div>
            </div>
        </section><!-- #featured -->
      <?php endif; ?>
         <section id="featured" class="">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 featured_content">
                        <div class="section-header">
                            <h2 class="section-title">Exciting</h2>
                            <h3 style="text-align: center;">Featured Activities</h3>
                           
                          
                        </div>
                    </div>
                </div>
                  <div class="row mt-4">
                    <div class="col-sm-12">
                        <div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="9000" style="">
                            <div class="carousel-inner row w-100 mx-auto" role="listbox">
                              
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
      featured Section
    ============================-->
         <section id="featured" class="secondfeatured">
            <div class="container">
               
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
                             
                               
                               
                            </div>
                        
                        </div>
                        
                    </div>
                </div>
            </div>
        </section><!-- #featured -->

            <!--==========================
      About Section
    ============================-->
        <section id="about">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-12">
                        <img src="<?php echo e(asset('public/images/home/GV-Video.png')); ?>">
                        <a href="javascript:;" class="modalclick" data-toggle="modal" data-target="#myModal"><img src="<?php echo e(asset('public/images/home/Video-Play-Btn.png')); ?>" class="img-responsive center playBtn" style="height: auto;"></a>
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
        </section>
<?php 
             $wallet = "login";
             if (Auth::check()) {
              $wallet = "wallet";
             }
             ?>
    <section class="wallet_area">
          <div class="row">
            <div class="col-md-12 walletbg">
              <div class="row d-flex justify-content-center">
                <div class="col-md-4">
                  <div class="row">
                  
                 <div class="col-md-3"><br /><img src="<?php echo e(asset('public/images/wallicon.png')); ?>" style="height: 120px;"></div> 
                   <div class="col-md-6" style="margin-top: 50px;color: #fff;"><?php if(Auth::check()): ?>
          Your GV-Pay Balance<br />
        <h3><i class="fa fa-rupee"></i> <?= Crypt::decrypt(Auth::user()->wall_am) ?></h3>
        <?php else: ?>
         <h5> Please <a href="<?= URL::to($wallet) ?>" style="color: #FFF;font-size: 20px;">Login</a> For<br /> GV Pay Balance</h5>
        <?php endif; ?></div> 
                </div> </div>
                   <div class="col-md-4">
                     <br />
                  <img src="<?php echo e(asset('public/images/wallbefore.png')); ?>" style="height: 30px;">
                 <div style="margin-top: 3px;text-align: center;color: #FFF;font-size: 16px;">Get UPTO <span style="color: #6be61a;font-size: 20px;">10%</span> EXTRA ON GV PAY</div>
        <a href="<?php echo e(URL::to($wallet)); ?>"><img src="<?php echo e(asset('public/images/pwa/recharge.PNG')); ?>" style="height: 50px;margin-top: 35px;margin-left: 160px;" alt="recharge.PNG"></a>
                </div>
              </div>
              
            </div>
            
          </div>
          
        </section>
        <!-- #About -->
           <!--==========================
      Logo Section
    ============================
 <section id="logoarea">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <marquee class="homemarquee"  scrollamount="15">
                            <a href="<?php echo e(URL::to('terrazzo')); ?>"><img src="<?php echo e(asset('public/images/gallery/foodcourt/1.jpg')); ?>">
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
                             <img src="<?php echo e(asset('public/images/gallery/foodcourt/23.jpg')); ?>"></a>
                        </marquee>
                    </div>
                    
                </div>
            </div>
        </section>

     #Logo -->
        <!--==========================
      Gallery Section
    ============================-->
     <section id="featured" class="thirdfeatured">
            <div class="container">
               <div class="row">
                    <div class="col-sm-12 featured_content cinepolislogo">
                        <div class="section-header">
                            <h2 class="section-title" style="margin-bottom: 20px;"> <img src="<?= asset('public/images/cinepolislogo.jpg') ?>"></h2>
                           
                           
                          
                        </div>
                    </div>
                  <div class="row mt-4">
                    <div class="col-sm-12">
                        <div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="9000" style="">
                            <div class="carousel-inner row w-100 mx-auto" role="listbox">
                                <?php foreach($movies as $key => $value): ?>
                                <div class="carousel-item col-md-3  active">
                                    <div class="panel panel-default">
                                        <div class="panel-thumbnail">
                                               <a href="<?= $value->url ?>" target="_blank"> <img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/moviecover/'.$value->movie_img) ?>" alt="slide 1"></a>
                                            <div class="title" style="text-align: center;margin-top: 5px;">
                                               <strong> <?= $value->movie_name ?></strong><br />
                                                <span style="font-size: 12px;"><?= $value->sub_text ?></span>
                                            </div>
                                            <div class="desc" style="text-align: center;">
                                                
                                            </div>
                                            <div class="price" style="text-align: center;margin-top: 20px;">
                                               
                                               
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

        </section>
       <div class="col-md-12" style="text-align: center;margin-bottom: 40px;">

                               <a href="<?= URL::to('cinepolis') ?>" class="btn btn-info">View More</a>
                            </div>
        <section id="gallery" style="display: none;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;z-index: 999">
                        <div class="pic1">
                            <a href="<?= URL::to('packs/combo-pack') ?>"><img src="<?php echo e(asset('public/images/home/Unlimited-Banner.jpg')); ?>" class="web_banner"></a>
                           <a href="<?= URL::to('packs/combo-pack') ?>"> <img src="<?php echo e(asset('public/images/mobile/Unlimited-Banner.jpg')); ?>" class="mobile_banner"></a>
                            <a href="<?= URL::to('packs/combo-pack') ?>" style="z-index: 999;" class="btn btn-info">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- #gallery -->
        <!--==========================
      Aminities Section
    ============================-->
<?php echo $__env->make('include/subfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div id="myModal" class="modal fade" role="dialog" aria-hidden="false" style="display: none;">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
      <iframe width="750" height="400" class="youtube-video" src="https://www.youtube.com/embed/qxDPNvj3jbQ?start=2&autoplay=" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
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
.image-container {
    position: relative;
    width: 100%;
    height: auto;
}
.image-container .after {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
     display: block;
    background: rgba(0,0,0,.6);
    color: #FFF;
}
.food-img {
  border: solid 1px #ccc;
}
.foodbox {
     width: 330px;
    padding: 10px;
    border: solid 1px #ccc;
    box-shadow: 0px 2px 2px #ccc;
    float: left;
    margin: 5px;
    height: 150px;
}
#foodarea {
  margin-bottom:60px !important;
  width: 1050px;
  margin: 0 auto;
}
.title {
  font-size: 14px;
  font-weight: bold;
color: #000;
}
.desc {
    font-size: 11px;
    color: #666;
}
#myModal iframe  {
  width: 100%;
}



    </style>
    <style type="text/css">

ul.movie_menu {
  list-style: none;
  margin-left: -40px;
  margin-bottom: 20px;
}
ul.movie_menu li {
      width: 160px;
    border: solid 1px #ccc;
    border-radius: 10px;
    padding: 5px;
    text-align: center;
    font-size: 16px;

}
ul.movie_menu li a {
  color: #000;
}


</style>
    <script type="text/javascript">

      $(function() {
    
        $(".modalclick").click(function() {
           $('#myModal').modal({backdrop: 'static', keyboard: false});
               $('.youtube-video').attr('src','https://www.youtube.com/embed/qxDPNvj3jbQ?autoplay=1');
              
        });
        $("#myModal .close").click(function() {
           $('.youtube-video').attr('src','https://www.youtube.com/embed/qxDPNvj3jbQ');
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
         .wallet_area {
          height: 170px;
          margin-bottom: 40px;
           background: url(<?php echo e(asset('public/images/walletbg.jpg')); ?>);
          
        }
        .walletbg {
         
        }
    </style>
    <script type="text/javascript">jssor_1_slider_init();</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/home.blade.php ENDPATH**/ ?>