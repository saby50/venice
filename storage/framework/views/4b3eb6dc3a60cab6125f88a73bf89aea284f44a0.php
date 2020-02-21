<?php $__env->startSection('title'); ?>
Cinepolis
<?php $__env->stopSection(); ?>
<?php $__env->startSection('includes'); ?>
     <meta property="og:title" content="The Grand Venice Mall | Cinepolis">
    <meta property="og:description" content="Enjoy The Latest Movies At Cinepolis">
    <meta property="og:image" content="<?= asset('public/images/cinepolis.jpg') ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 <section id="hero2">
       <div class="title"></div>
        
    </section><!-- #hero -->
  <?php if(Helper::check_mobile()==1): ?>
<section class="hero careers2">
  <?php else: ?>
<section class="hero careers">
  <?php endif; ?>
<div class="container">
	<div class="row">
       <div class="col-sm-12 featured_content cinepolislogo">
                        <div class="section-header">
                            <h2 class="section-title" style="margin-bottom: 40px;"> <img src="<?= asset('public/images/cinepolislogo.jpg') ?>"></h2>
                           
                           
                          
                        </div>
                    </div>
       	<?php foreach($movies as $key => $value): ?>
                  <div class="col-3" style="margin-bottom: 40px;">   
                         	<div class="carousel-inner row w-100 mx-auto" role="listbox">
                                    <div class="panel panel-default">
                                        <div class="panel-thumbnail">
                                               <a href="<?= $value->url ?>" target="_blank"> <img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/moviecover/'.$value->movie_img) ?>" alt="slide 1"></a>
                                             
                                            <div class="title" style="text-align: center;margin-top: 5px;">
                                                <strong> <?= $value->movie_name ?></strong><br />
                                                <span style="font-size: 12px;"><?= $value->sub_text ?></span>
                                            </div>
                                            <div class="desc" style="text-align: center;">
                                                <?php $short = $value->synopsis;
                                                    // echo Helper::truncate($short,60);
                                                 ?>
                                                 <br />

                                                 <?php
                                                 $slots =  $value->slots;
                                                 $slotarray = explode(',', $slots);
                                                // echo '<div id="centerDiv"><ul class="slotsarea">';

                                                 foreach ($slotarray as $k => $v) {
                                                //     echo '<li><a href="'.$value->url.'" target="_blank">'.$v.'</a></li>';
                                                 }
                                                // echo '</ul></div>';

                                                 ?>
                                            </div>
                                            
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
       #hero2 {
  width: 100%;
  height: 346px;
  background: url(<?= asset('public/images/cinepolis.jpg') ?>) no-repeat;
  background-position: center;
  position: relative;
  top: -100px;


}

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
ul.slotsarea {
    list-style: none;
    margin: 0 auto;
    
}
ul.slotsarea li a {
  color:#000;
  font-size: 15px;
}
ul.slotsarea li {
    padding: 10px;
    border:solid 1px #ccc;
    text-align:center;
    margin-right: 10px;
    width: 120px;
     display: inline;
    margin-top: 20px;
}
div#centerDiv {
        width: 100%;
        text-align: center;
        margin-top: 20px;
        height: 40px;
        
    }
  #hero2 div.title {
    text-align: center;
    top: 120px;
    position: relative;
    font-size: 70px;
    color: #000;
    width: 400px;
    margin: 0 auto;

    text-transform: uppercase;

}
@media (max-width: 425px) {
 #hero2 {
    width: 100%;
    height: 300px;
    background-position: center;
    position: relative;
    top: -0px;

 background: url(<?= asset('public/images/cinepolismobile.jpg') ?>) no-repeat;
     background-size: cover;
}
.col-3 {
    flex: 0 0 100% !important;
    max-width: 100% !important;
}
ul.movie_menu {
    margin-top: 40px !important;
}
#hero2 div.title {
    text-align: center;
    top: 80px;
    position: relative;
    font-size: 50px;
    color: #000;
    width: 100%;
    margin: 0 auto;
}

}
</style>
<?php echo $__env->make('include/subfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/movies/index.blade.php ENDPATH**/ ?>