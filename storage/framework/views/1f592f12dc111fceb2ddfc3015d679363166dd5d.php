<?php $__env->startSection('title'); ?>
Categories
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
 <section id="hero2">
       <div class="title">Categories</div>
        
    </section><!-- #hero -->
        <div class="recyclerview firstbox">
            <a name="activities"></a>
<div class="row">

            <div class="col-12">
                <div class="recyclerviewhead">
            Activities 
         </div>
            <div class="recyclerviewhead2">
             
         </div>     
            </div>
            </div>
            <?php $i=0; foreach($services as $key => $value): ?>
                <a href="<?= URL::to('booking/'.$value->alias."#bookingform") ?>">
                <div class="featured-pwa ripple">
                    <div class="row">
                <div class="col-4">

                    <img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured_app/'.$value->featured_app) ?>" alt="slide 1">
                </div>  
                <div class="col-8">
                     <span class="title"><?= $value->service_name ?></span><br />
                     <span class="desc"><?= $value->teaser_line_1 ?> <?= $value->teaser_line_2 ?></span><br />
                      <span class="prices"><?php $rates = Helper::get_all_rates($value->id, 'service');
                          if (count($rates)==1) {
                            echo '<i class="fa fa-rupee"></i> '.$rates[0];
                         } elseif (count($rates)==0) {
                            echo 'Get Quote';
                         }else {
                            echo '<i class="fa fa-rupee"></i> '.min($rates). " - <i class='fa fa-rupee'></i> ".max($rates);
                         }
                       ?></span>
                </div>
                </div>
                </div>
            </a>
                <hr />

            <?php endforeach; ?>
            <div class="row">
<a name="packss"></a>
            <div class="col-12">
                <div class="recyclerviewhead">
            Packs 
         </div>
            <div class="recyclerviewhead2">
             
         </div>     
            </div>
            </div>
            <?php $i=0; foreach($packs as $key => $value): ?>
                <a href="<?= URL::to('packs/'.$value->alias."#bookingform") ?>">
                <div class="featured-pwa ripple">
                    <div class="row">
                <div class="col-4">

                    <img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured_app/'.$value->featured_app) ?>" alt="slide 1">
                </div>  
                <div class="col-8">
                     <span class="title"><?= $value->pack_name ?></span><br />
                     <span class="desc"><?= $value->teaser_line_1 ?> <?= $value->teaser_line_2 ?></span><br />
                      <span class="prices"><?php $rates = Helper::get_all_rates($value->id, 'packs');
                          if (count($rates)==1) {
                            echo '<i class="fa fa-rupee"></i> '.$rates[0];
                         } elseif (count($rates)==0) {
                            echo 'Get Quote';
                         }else {
                            echo '<i class="fa fa-rupee"></i> '.min($rates). " - <i class='fa fa-rupee'></i> ".max($rates);
                         }
                       ?></span>
                </div>
                </div>
                </div>
            </a>
                <?php if($i == count($packs) - 1): ?>
                <?php else: ?>
                    <hr />
                <?php endif; ?>
                

                <?php 
                   $i++;
                ?>

            <?php endforeach; ?>
              <hr />
            <?php if(count($events)!=0): ?>
            <div class="row">
<a name="eventss"></a>
            <div class="col-12">
                <div class="recyclerviewhead">
            Events 
         </div>
            <div class="recyclerviewhead2">
             
         </div>     
            </div>
            </div>
            <?php $i=0; foreach($events as $key => $value): ?>
                <a href="<?= URL::to('events/'.$value->event_alias."#bookingform") ?>">
                <div class="featured-pwa ripple">
                    <div class="row">
                <div class="col-4">

                    <img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured_app/'.$value->featured_app) ?>" alt="slide 1">
                </div>  
                <div class="col-8">
                     <span class="title"><?= $value->event_name ?></span><br />
                     <span class="desc"><?= $value->teaser_line_1 ?> <?= $value->teaser_line_2 ?></span><br />
                      <span class="prices"><?= date('l, F j Y',strtotime($value->start_date)) ?> (<?= $value->start_time ?>)</span>
                </div>
                </div>
                </div>
            </a>
                <?php if($i == count($events) - 1): ?>
                <?php else: ?>
                    <hr />
                <?php endif; ?>
                

                <?php 
                   $i++;
                ?>

            <?php endforeach; ?>
        <?php endif; ?>
        </div>
        
    </div>

<section class="hero careers">
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

                    <?php if(count($events)!=0): ?>
                     <div class="col-12">
                       
                            <h4>Events</h4>
                            <hr />
                    <div class="carousel-inner row w-100 mx-auto" role="listbox">

                    <?php foreach($events as $k => $v): ?>
                        <div class=" col-md-4" style="margin-bottom: 40px;">
                                    <div class="panel panel-default">
                                        <div class="panel-thumbnail">
                                            <a name="events"></a>
                                                <img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured_app/'.$v->featured_app) ?>" alt="slide 1">
                                            <div class="title" style="text-align: center;margin-top: 10px;">
                                                <strong> <?= $v->event_name ?></strong>
                                            </div>
                                            <div class="desc" style="text-align: left !important;">
                                                <?php $short = $v->event_short_description;
                                                     echo Helper::truncate($short,60);
                                                 ?>
                                            </div>
                                            <div class="price" style="text-align: center;margin-top: 20px;">
                                               
                                                <a href="<?= URL::to('packs/'.$v->event_alias) ?>" class="btn btn-info">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                       
                    <?php endforeach; ?>
                <?php endif; ?>

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
  background: url(<?= asset('public/images/banner.jpg') ?>) no-repeat;
  background-position: center;
  position: relative;
  top: -100px;
background-size: contain;

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
    background-size: auto;

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
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/categories.blade.php ENDPATH**/ ?>