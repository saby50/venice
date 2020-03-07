@extends('layouts.main2')

@section('title')
Food
@endsection

@section('content')
<div class="slider-pwa">
        <img data-u="image" src="http://localhost/venice/public/images/pages/foodcourtm.jpg" class="mobile">
      </div>

        <!-- Start RecyclerView -->
            <div class="recyclerview">
                <div class="row">

                    <div class="col-12">
                        <div class="recyclerviewhead">
                            
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
                                <img class="img-fluid mx-auto d-block feature" src="<?= URL::to('public/uploads/foodstore/'.$value->foodstore) ?>" alt="<?= $value->foodstore ?>">
                            </div>  
                            <div class="col-8" style="padding-left: 24px;">
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
                                        <i class="fa fa-circle" aria-hidden="true" style="color: #16e358;"></i> 
                                        <?php endif; ?>
                                        <?php if(in_array('nonveg', $nonveg)): ?>
                                        <i class="fa fa-circle" aria-hidden="true" style="color: #ee1c25;"></i> 
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
            </div>

            <!-- End RecyclerView -->


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
@include('include/subfooter')
<script type="text/javascript">
  $(document).ready(function() {
         $(".filterbtn").click(function() {
              $(".filters").slideToggle("slow");
         });
       $(".search").keyup(function() {
        var data = $(this).val();
        var url = "<?= URL::to('api/search_restaurants') ?>";
        var formdata = {
            '_token':'{{ csrf_token()}}',
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
                                <div class="featureimage" style="background: url(<?= URL::to('public/uploads/foodstore/') ?>/'+n['foodstore']+');"></div>\n\
                            </div>  \n\
                            <div class="col-8" style="padding-left: 24px;">\n\
                                <span class="title">'+n['unit_name']+'</span><br />\n\
                                <span class="desc">'+n['tags']+'</span><br />\n\
                                <hr />\n\
                                <div class="desc"  style="margin-top: 10px;">\n\
                                    <div class="row">\n\
                                    <div class="col-6" style="font-size: 8px;">\n\
                                        <i class="fa fa-circle" aria-hidden="true" style="color: #16e358;"></i> Veg <br />\n\
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


@endsection