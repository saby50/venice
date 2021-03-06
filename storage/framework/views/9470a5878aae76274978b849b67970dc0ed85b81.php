<?php $__env->startSection('title'); ?>
Food
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="slider-pwa">
        <img data-u="image" src="<?= URL::to("public/images/foodcourtb.jpg") ?>" class="mobile">
      </div>

      <a name="restaurants"></a>

        <!-- Start RecyclerView -->
            <div class="recyclerview">
                <div class="row">

                    <div class="col-12">

                        <div class="recyclerviewhead" style="color: #EE0000;">
                            
                            All Restaurants
                            
                        </div>
                        <div class="recyclerviewhead2">
                            <span class="filterbtn" style="display: none;"><i class="fa fa-sort" aria-hidden="true"></i> Sort/Filter</span>
                           
                        </div>      
                    </div>
                </div>
                <div class="restaurant"></div>
                <?php $i=0; foreach($foodorder as $key => $value): ?>
                <a href="<?= URL::to('show-menu/all/'.Crypt::encrypt($value->id)) ?>" class="restaurantall">
                    <div class="featured-pwa ripple">
                        <div class="row">
                            <div class="col-4">
                                <img class="img-fluid mx-auto d-block feature" src="<?= URL::to('public/uploads/foodstore/'.$value->foodstore) ?>" alt="<?= $value->foodstore ?>"><span style="color: #000;margin-left: 7px;">Prep: <?= $value->prep_time ?></span>
                            </div>  
                            <div class="col-8">
                                <span class="title"><?= $value->unit_name ?></span><br />
                                <span class="desc"><?= $value->tags ?></span><br />
                                <hr />
                                <div class="desc"  style="margin-top: 10px;">
                                    <div class="row">
                                   <div class="col-6" style="font-size: 8px;">
                                        <?php 
                                            $nonveg = Helper::get_veg_non($value->id);
                                        ?>
                                        <?php if(in_array('veg', $nonveg)): ?>
                                         <img src="<?php echo e(asset('public/images/veg.png')); ?>" style="width: 15px;height: 15px;">
                                        <?php endif; ?>
                                        <?php if(in_array('nonveg', $nonveg)): ?>
                                       <img src="<?php echo e(asset('public/images/nonveg.png')); ?>" style="width: 15px;height: 15px;">
                                        <?php endif; ?>
                                        
                                    </div>
                                 
                                     <div class="col-6" style="text-align: right;">
                                        <i class='fa fa-rupee'></i> <?= $value->price_for_two ?> For Two
                                    </div></div>
                                    </div>
                                
                            </div>
                        </div>
                    </div>
                </a>
                <?php if($i == count($foodorder) - 1): ?>
                    <?php else: ?>
                        <hr />
                    <?php endif; ?>
                    

                    <?php 
                    $i++;
                    ?>

                <?php endforeach; ?>
                <hr />
  <?php $i=0; foreach($offlineres as $key => $value): ?>
        
        <a href="<?= URL::to('show-menu/all/'.Crypt::encrypt($value->id)) ?>">
          <div class="featured-pwa ripple">
            <div class="row">
              <div class="col-4">
                <?php if(file_exists('public/uploads/foodstore/'.$value->foodstore)): ?>
                <div class="image-container"><img class="img-fluid mx-auto d-block feature" src="<?= asset('public/uploads/foodstore/'.$value->foodstore) ?>" alt="<?= $value->foodstore ?>"><div class="after"></div></div>
                
                <?php else: ?>
                  <img class="img-fluid mx-auto d-block feature" src="<?= asset('public/images/placeholder.jpg') ?>">
                <?php endif; ?><span style="color: #000;margin-left: 7px;">Prep: <?= $value->prep_time ?></span>
              </div>  
              <div class="col-8">
                <span class="title"><?= $value->unit_name ?></span><br />
                <span class="desc"><?= $value->tags ?></span><br />
                <hr />
                                <div class="desc"  style="margin-top: 10px;">
                                    <div class="row">
                                    <div class="col-6" style="font-size: 8px;">
                                      <?php 
                                $nonveg = Helper::get_veg_non($value->id);
                      ?>
                      <?php if(in_array('veg', $nonveg)): ?>
                                        <img src="<?php echo e(asset('public/images/veg.png')); ?>" style="width: 15px;height: 15px;">
                                      <?php endif; ?>
                                      <?php if(in_array('nonveg', $nonveg)): ?>
                                         <img src="<?php echo e(asset('public/images/nonveg.png')); ?>" style="width: 15px;height: 15px;">
                                      <?php endif; ?>
                                        
                                    </div>

                                     <div class="col-6" style="text-align: right;">
                                        <i class='fa fa-rupee'></i> <?= $value->price_for_two ?> For Two
                                    </div></div>
                                    </div>
                                
                            </div>
            </div>
          </div>
        </a>
        <?php if($i == count($offlineres) - 1): ?>
          <?php else: ?>
            <hr />
          <?php endif; ?>
          

          <?php 
          $i++;
          ?>

        <?php endforeach; ?>
     
            </div>

            <!-- End RecyclerView -->


<style type="text/css">
	p {
		text-align: justify;
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
       #hero2 {
  width: 100%;
  height: 346px;
  background: url(<?= asset('public/images/banner.jpg') ?>) no-repeat;
  background-position: center;
  position: relative;
  top: -100px;
background-size: contain;

}
.feature {
    border: solid 1px #ccc;
}
.filterbtn {
    font-size: 12px;
    color: #EE0000;
}
.filters {
    height: 250px;
    width: 100%;
    background-color: #fff;
    position: fixed;
    bottom: 0px;
    padding: 10px;
    border-top: solid 1px #ccc;
    display: none;
    z-index: 999;
    overflow-y: auto;
}
.featureimage {
   width: 107px;
    height: 90px;
    border-radius: 15px;
    background-position: center !important;
    background-size: contain !important;
    border: solid 1px #ccc;
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
<div class="filters">
  <div class="row">
    <div class="col-12">
        <h5>Filter</h5>
    </div>
    <?php foreach($categories as $key => $value): ?>
        <div class="col-4">
            <label><input type="checkbox" name="filter[]"> <?= $value->category_name ?></label>
        
    </div>
<?php endforeach; ?>
    
      
  </div>  
</div>
<?php echo $__env->make('include/subfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script type="text/javascript">
  $(document).ready(function() {
         $(".filterbtn").click(function() {
              $(".filters").slideToggle("slow");
         });
       $(".search").keyup(function() {
        var data = $(this).val();
        var url = "<?= URL::to('api/search_restaurants') ?>";
        var formdata = {
            '_token':'<?php echo e(csrf_token()); ?>',
           'keyword': data
        };
        var response = "";
        if (data != "") {
          $.post(url, formdata, function(resp,textStatus, jqXHR) {
            console.log(resp);
            $.each(resp, function(i,n) {

              response+= '<hr /><a href="<?= URL::to('show-menu/all/') ?>/'+n['id']+'" class="restaurantall">\n\
                    <div class="featured-pwa ripple">\n\
                        <div class="row">\n\
                            <div class="col-4">\n\
                            <img class="img-fluid mx-auto d-block feature" src="<?= URL::to('public/uploads/foodstore/') ?>/'+n['foodstore']+'" alt="'+n['foodstore']+'">\n\
                            </div>  \n\
                            <div class="col-8">\n\
                                <span class="title">'+n['unit_name']+'</span><br />\n\
                                <span class="desc">'+n['tags']+'</span><br />\n\
                                <hr />\n\
                                <div class="desc"  style="margin-top: 10px;">\n\
                                    <div class="row">\n\
                                    <div class="col-6" style="font-size: 8px;">\n\
                                        <br />\n\
                                    </div>\n\
                                     <div class="col-6" style="text-align: right;">\n\
                                        <i class="fa fa-rupee"></i> '+n['price_for_two']+' For Two\n\
                                    </div></div>\n\
                                    </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </a>';
            });
             $(".restaurantall").css('display','none');
             $(".slider-pwa").hide("fast");
             $(".recyclerview").addClass("firstbox");

        $(".restaurant").html(response);
        });
        }else {
            $(".restaurant").html("");
          $(".restaurantall").css('display','block');
          $(".slider-pwa").show("fast");
          $(".recyclerview").removeClass("firstbox");
        }
        
        
       });
  });
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/foodorder.blade.php ENDPATH**/ ?>