<?php $__env->startSection('title'); ?>
Search
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Start RecyclerView -->
<div class="recyclerview firstbox">
    <div class="row">

        <div class="col-12">
        	<input type="text" name="search" class="search form-control" placeholder="Search by restaurant name">
        </div>
        <div class="col-12 restaurant">
        	
        </div>
    </div>

</div>


<?php echo $__env->make('include/subfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script type="text/javascript">
	$(document).ready(function() {
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
              response+= '<hr /><a href="<?= URL::to('show-menu/all/') ?>/'+n['id']+'">\n\
                    <div class="featured-pwa ripple">\n\
                        <div class="row">\n\
                            <div class="col-4">\n\
                                <div class="featureimage" style="background: url(<?= URL::to('public/uploads/foodstore/') ?>/'+n['foodstore']+');"></div>\n\
                            </div>  \n\
                            <div class="col-8">\n\
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

        $(".restaurant").html(response);
        });
        }else {
        	$(".restaurant").html("Nothing Found");
        }
        
        
       });
	});
</script>
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
.featureimage {
   width: 107px;
    height: 90px;
    border-radius: 15px;
    background-position: center !important;
    background-size: contain !important;
    border: solid 1px #ccc;
-webkit-box-shadow: -1px 1px 19px 0px rgba(204,204,204,1);
-moz-box-shadow: -1px 1px 19px 0px rgba(204,204,204,1);
box-shadow: -1px 1px 19px 0px rgba(204,204,204,1);
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/search.blade.php ENDPATH**/ ?>