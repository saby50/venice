@extends('layouts.main2')

@section('title')
<?php 
$unit_details = Helper::get_unit_info($getid);
$unit_name = NULL; $foodstore = NULL;
$tags = NULL; $price_for_two = NULL;
foreach ($unit_details as $key => $value) {
	$unit_name = $value->unit_name;
	$foodstore = $value->foodstore;
	$tags = $value->tags;
  $price_for_two = $value->price_for_two;
	
}
echo $unit_name."<p style='font-size:11px;margin-left: 42px;margin-top:-5px;'>".$tags."</p>";

$menu = Helper::get_menu_items($getid,$view);
$categories = array();
foreach ($menu as $key => $value) {
	$categories[] = $value->food_category_id;
}
$categories = array_unique($categories);
if (Session::has('food_cart')) {
  $cart = Session::get('food_cart');

if (count($cart)==0) {
  $q = 0;
  $p = 0;
}else {
  $q = 0;
  $p = 0;
}
foreach ($cart as $key => $value) {
  $q += $value['quantity'];
  $p += $value['price'];
}
}else {
  $q = 0;
  $p = 0;
}


?>
@endsection

@section('content')

   <div class="row">
    
   	
    <div class="recyclerview firstbox recommended">
      <div class="row">
        <div class="col-6" style="font-size: 12px;padding-left: 19px;">
          <label class="switch">
            <?php if($view=="veg"): ?>
             <input type="checkbox" name="veg" value="all" class="vegonly" checked="checked">
             <?php else: ?>
              <input type="checkbox" name="veg" value="veg" class="vegonly">
              <?php endif; ?>
            <span class="slider round"></span>
          </label> Veg
        </div>
          <div class="col-6" style="font-size: 12px;text-align: right;padding-right: 16px;">
           <i class='fa fa-rupee'></i> <?= $price_for_two ?> For Two
        </div>
      </div>
      <hr />
      <?php if(Helper::check_recommended($getid)!=0): ?>
      <div class="col-md-12">
        <div class="row" style="margin-bottom: 20px;">

        <div class="col-12">
          <div class="recyclerviewhead" style="text-transform: uppercase;">
           Recommended
          </div>
            
        </div>
      </div>
        <div class="row">
          <?php foreach($menu as $key => $value): ?>
            <?php if($value->featured=="yes"): ?>
          <div class="col-6 food-section">
            <div class="featured_image"> <div class="ribbon" style="display: none;">
        <div class="txt">
            Bestseller
        </div>
    </div><div class="featured_image_box" style="background: url(<?= URL::to('public/uploads/featured_item/'.$value->featured_image) ?>);"></div></div>
           <div class="Bn7DA"><?php if($value->veg_nonveg=="veg"): ?>
                    <img src="{{ asset('public/images/veg.png') }}" width="15" height="auto" style="margin-top: -5px;">
                    <?php else: ?>
                        <img src="{{ asset('public/images/nonveg.png') }}" width="15" height="auto" style="margin-top: -5px;">
                  <?php endif; ?> <?= $value->item_name ?><br />
                  <div class="NCPX7"><?= Helper::get_food_category_name($value->food_category_id); ?></div></div>
          <div class="f5-yn"><i class="fa fa-rupee"></i> <?= $value->price ?></div>
          <div>
              <?php if($value->status=="active"): ?>
               <?php
               $checkcart = Helper::get_cart_data($value->id);
               $quantity = 0;
               if (Session::has('food_cart')) {
                 foreach ($cart as $c => $t) {
                   if ($t['item_id']==$value->id) {
                     $quantity =  $t['quantity'];
                   }
                }
               }
                
              
             ?>
             <?php if($quantity!=0): ?>
              
               <div class="addButton btnmargintop hided addbutton_<?= $value->id ?>" data-addon="<?= Helper::checkaddonfields($value->id) ?>"  data-price="<?= $value->price ?>" data="<?= $value->id ?>">Add</div>
         
               <div class="foodquantity btnmargintop quantitybox_<?= $value->id ?>" data="<?= $value->id ?>" data-price="<?= $value->price ?>">
           <button class="decrease"  data="<?= $value->id ?>" data-price="<?= $value->price ?>">-</button> <input type="number" value="1" name="quantity" class="quantity_<?= $value->id ?> q" readonly><button class="increase" data="<?= $value->id ?>" data-price="<?= $value->price ?>">+</button>
          </div>
           
          <?php else: ?>
             <?php if(time() >= strtotime($value->from_time) && time() <= strtotime($value->to_time)): ?>
            <div class="addButton btnmargintop addbutton_<?= $value->id ?>" data-addon="<?= Helper::checkaddonfields($value->id) ?>"  data-price="<?= $value->price ?>" data="<?= $value->id ?>">Add</div>
            <?php if(Helper::checkaddonfields($value->id)==1): ?>
           <div class="_1gDO32">Customisable</div>
           <?php endif; ?>
           <div class="foodquantity btnmargintop hided quantitybox_<?= $value->id ?>" data="<?= $value->id ?>" data-price="<?= $value->price ?>">
           <button class="decrease"  data="<?= $value->id ?>" data-price="<?= $value->price ?>">-</button> <input type="number" value="1" name="quantity" class="quantity_<?= $value->id ?> q" readonly><button class="increase" data="<?= $value->id ?>" data-price="<?= $value->price ?>">+</button>
            
          </div>
           <?php else: ?>
             <div class="unavailable">Currently Unavailable</div>
          <?php endif; ?>
              <?php endif; ?>
          
         
          <?php else: ?>
            <div class="unavailable">Currently Unavailable</div>
        <?php endif; ?>
          </div>
          </div>
        <?php endif; ?>
        <?php endforeach; ?>
        </div>
        
      </div>
      
    </div>
    <?php endif; ?>
   	<?php foreach($categories as $k => $v): ?>
   	<div class="recyclerview">
      

   		<div class="col-md-12">

   		<div class="row" style="margin-bottom: 20px;">

				<div class="col-12">
					<div class="recyclerviewhead">
						<?= Helper::get_food_category_name($v) ?>
					</div>
						
				</div>
			</div>
			<?php 
         $menu_items = Helper::get_menu_items_category_id($v,$view);
         foreach($menu_items as $key => $value):

			 ?>
        <?php if($value->featured=="no"): ?>

              <div class="row content" style="margin-top: 20px;">
              	<div class="col-1">
              		<?php if($value->veg_nonveg=="veg"): ?>
              			<img src="{{ asset('public/images/veg.png') }}" width="15" height="auto" style="margin-top: -10px;">
              			<?php else: ?>
                        <img src="{{ asset('public/images/nonveg.png') }}" width="15" height="auto" style="margin-top: -10px;">
              		<?php endif; ?>
              		
              	</div>
				<div class="col-6">

					<div class="Bn7DA title"> <?= $value->item_name ?></div>
					<div class="f5-yn2"><i class="fa fa-rupee"></i> <?= $value->price ?></div>
					
				</div>
				<div class="col-4">
          <?php if($value->status=="active"): ?>
             <?php
               $checkcart = Helper::get_cart_data($value->id);
               $quantity = 0;
               if (Session::has('food_cart')) {
                 foreach ($cart as $c => $t) {
                   if ($t['item_id']==$value->id) {
                     $quantity =  $t['quantity'];
                   }
                }
               }
                
              
             ?>
             <?php if($quantity!=0): ?>
           
              <div class="foodquantity btnmarginright quantitybox_<?= $value->id ?>" data="<?= $value->id ?>" data-price="<?= $value->price ?>">
           <button class="decrease"  data="<?= $value->id ?>" data-price="<?= $value->price ?>">-</button> <input type="number" value="<?= $quantity ?>" name="quantity"  class="quantity_<?= $value->id ?> q" data="<?= $value->id ?>" data-price="<?= $value->price ?>" readonly> <input type="hidden" value="<?= $quantity ?>" name="quantity" class="nquantity_<?= $value->id ?>"><button class="increase" data="<?= $value->id ?>" data-price="<?= $value->price ?>">+</button>
            
          </div>

              <div class="addButton btnmarginright hided addbutton_<?= $value->id ?>"  data-addon="<?= Helper::checkaddonfields($value->id) ?>" data-price="<?= $value->price ?>" data="<?= $value->id ?>">Add</div>
            <?php if(Helper::checkaddonfields($value->id)==1): ?>
           <div class="_1gDO3">Customisable</div>
          
         <?php endif; ?>
          <?php else: ?>
             
            <?php if(time() >= strtotime($value->from_time) && time() <= strtotime($value->to_time)): ?>
              <div class="addButton btnmarginright addbutton_<?= $value->id ?>" data-addon="<?= Helper::checkaddonfields($value->id) ?>" data-price="<?= $value->price ?>" data="<?= $value->id ?>">Add</div>
          <?php if(Helper::checkaddonfields($value->id)==1): ?>
           <div class="_1gDO3">Customisable</div>
         <?php endif; ?>
           <div class="foodquantity btnmarginright hided quantitybox_<?= $value->id ?>" data="<?= $value->id ?>" data-price="<?= $value->price ?>">
           <button class="decrease"  data="<?= $value->id ?>" data-price="<?= $value->price ?>">-</button> <input type="number" value="1" name="quantity" class="quantity_<?= $value->id ?> q"  data="<?= $value->id ?>" data-price="<?= $value->price ?>" readonly><button class="increase" data="<?= $value->id ?>" data-price="<?= $value->price ?>">+</button>
         
            
          </div>
          <?php else: ?>
             <div class="unavailable btnmarginright">Currently Unavailable</div>
          <?php endif; ?>
        <?php endif; ?>
            
					

          
          <?php else: ?>
            <div class="unavailable btnmarginright">Currently Unavailable</div>
        <?php endif; ?>
				</div>
			</div>
    <?php endif; ?>
		<?php endforeach; ?>
   		</div>
   		
   	</div>
   <?php endforeach; ?>
   </div>
<a href="{{ URL::to('food_cart') }}" class="bottomcarta">
  <?php if(Session::has('food_cart')): ?>
   <div class="bottomcart">
    <?php else: ?>
      <div class="bottomcart hided">
    <?php endif; ?>
    <div class="row">
    <div class="col-6">
      <div class="mainitem"><span class="itemcount"></span> Items | <i class="fa fa-rupee"></i> <span class="itemprice"></span></div>
      <div class="restaurant-name">From: <span class="unit_name"></span></div>
      
    </div>
    <div class="col-6">
      <span style="text-transform: uppercase;">View Cart <i class="fa fa-shopping-bag" aria-hidden="true"></i></span> 
      
    </div> 
   </div>
  </div>
</a>
<!-- Modal -->
<div id="myModalSame" class="modal fade" role="dialog">
  <form method="post" action="<?= URL::to('menu/add_item_cart') ?>">
    @csrf
  <div class="modal-dialog" style="margin-top: 25rem;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="padding: 10px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body" style="padding: 2px 16px;font-size: 14px;padding-top: 10px;height: 60px;">
        <p>Do you want to discard the current selection and add dishes from <strong><?php $units = Helper::get_unit($getid); echo $units['unit_name']; ?></strong>?</p>
        <input type="hidden" name="item_id" class="sitem_id">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="addon" class="addon">
        <input type="hidden" name="unit_id" value="<?= $getid ?>">
        <input type="hidden" name="price" class="sprice">
        <input type="hidden" name="identifier" value="plus">
      </div>
      <div class="modal-footer" style="padding: 5px;">
        <button type="button" class="btn btn-default nbtn" id="no" data-no="">NO</button>
        <button type="submit" class="btn btn-default nbtn">YES</button>
      </div>
    </div>

  </div>
  </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
      $(".search_dish").keyup(function() {
          var data = $(this).val();
          $('.content').removeClass('visible');
          $('.content').addClass('hide');
           $('.content .title:contains("'+data+'")').closest('.content').addClass('visible');
           $(".recommended").hide();
           $(".recyclerview:nth-child(2)").addClass('firstbox');
           $('.recyclerview .col-md-12').each(function() {
             var count = $(this).children('.visible').length;
              if (count=="0") {
                 $(this).closest('.recyclerview').hide();
              }else {
                $(this).closest('.recyclerview').show();
              }


           });
      });

      $.expr[":"].contains = $.expr.createPseudo(function(arg) {
  return function( elem ) {
   return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
  };
});
      $(".vegonly").change(function() {
          var data = $(this).val();
          var url = "<?= URL::to('show-menu/"+data+"/'.Crypt::encrypt($getid)) ?>";
          window.location = url;
      });
      $(".q").on('change', function() {
       var item_id = $(this).attr('data');
       var quantity = $(this).val();
       var price = $(this).attr('data-price');
       var nquantity = $(".nquantity_"+item_id).val();
       var identifier = "minus";
      if (nquantity < quantity) {
         identifier = "plus";
      }
       var formData = {
                '_token':'{{ csrf_token()}}',
                'item_id': item_id,
                'quantity': quantity,
                'price': price,
                'identifier': identifier
      };

      var url = '<?= URL::to("menu/foodcart_update") ?>'; 
      $.post(url,  formData, function (resp,textStatus, jqXHR) {
           window.location = "<?= URL::to('food_cart') ?>";  
      });
      
    });
        var unit_id = "<?= $getid ?>";
        var url = "<?= URL::to('menu/get_cart_data') ?>/"+unit_id;
        $.get(url, function(data) {
           if (data.length==0) {
               $(".bottomcart").hide();
            }else {
              $(".bottomcart").show();
              $(".itemcount").html(data['quantity']);
              $(".itemprice").html(data['price']);
              $(".unit_name").html(data['unit_name']);
            }
        });

         var i = <?= $q ?>;
         var mainprice = <?= $p ?>;
         $("#no").click(function() {
           var data = $(this).attr('data-no');
             $(".foodquantity").hide();
             $(".addButton").show();
             $("#myModalSame").modal("hide");
         });
        
         $(".addButton").click(function() {
              setTimeout( function() { $('.loader').show(); }, 300 );
            setTimeout( function() { $('.loader').hide(); }, 800 );
           var data = $(this).attr('data');
           var addon = $(this).attr('data-addon');         
           var price = parseInt($(this).attr('data-price'));
           var unit_id = "<?= $getid ?>";
              $(this).next('.foodquantity').show();
                  $(".bottomcart").show();
           
                  $(this).hide();
           

            var formData = {
                '_token':'{{ csrf_token()}}',
                'item_id': data,
                'quantity': "1",
                'unit_id': unit_id,
                'price': price,
                'identifier': 'plus'
            };
            var url = '<?= URL::to("menu/foodcart") ?>'; 
             var url2 = '<?= URL::to("getaddonfields") ?>/'+data; 
             var unit_name = "<?php $units = Helper::get_unit($getid); echo $units['unit_name']; ?>";
             $(".unit_name").html(unit_name);

              $.post(url,  formData,
            function (resp,textStatus, jqXHR) {
                if (resp==1) {
                    
                  $("#myModalSame").modal("show");
                  $(".sitem_id").val(data);
                  $(".sprice").val(price);
                  $(".addon").val(addon);

                  
                  $("#no").attr("data-no",data);
                }else {
               
                  if (addon=="1") {
                 window.location = "<?= URL::to('menu/addons/') ?>/"+data;
                }
                }
                
            });
               i = i + 1; 
            $(".itemcount").html(i);
            mainprice = mainprice + price;
            $(".itemprice").html(mainprice);
           
         });
         $(".decrease").click(function() {
                setTimeout( function() { $('.loader').show(); }, 300 );
            setTimeout( function() { $('.loader').hide(); }, 800 );
            var data = $(this).attr('data');
            var price = parseInt($(this).attr('data-price'));
            var currentquantity = parseInt($(this).next('input.q').val());
            var updatedquantity = 0;
            if (currentquantity==1) {
              updatedquantity = 0;
              price = 0;
              $(".quantitybox_"+data).hide();
             $(".addbutton_"+data).show();
            }else {
              console.log('hit here');
              updatedquantity = currentquantity - 1;
              $(".quantity_"+data).val(updatedquantity);

            }
           var formData = {
                '_token':'{{ csrf_token()}}',
                'item_id': data,
                'quantity': updatedquantity,
                'price': price,
                'identifier': 'minus'
            };

            var url = '<?= URL::to("menu/foodcart_update") ?>'; 
            

            $.post(url,  formData, function (resp,textStatus, jqXHR) {
            
            });

            var unit_id = "<?= $getid ?>";
        var url = "<?= URL::to('menu/get_cart_data') ?>/"+unit_id;
        $.get(url, function(data) {
          console.log(data);
           if (data.length==0) {
               $(".bottomcart").hide();
            }else {
              $(".bottomcart").show();
              $(".itemcount").html(data['quantity']);
              $(".itemprice").html(data['price']);
              $(".unit_name").html(data['unit_name']);
            }
        });

            
            
         });
          $(".increase").click(function() {
            setTimeout( function() { $('.loader').show(); }, 300 );
            setTimeout( function() { $('.loader').hide(); }, 800 );
            var unit_id = "<?= $getid ?>";
            var data = $(this).attr('data');
            var price = parseInt($(this).attr('data-price'));
           // alert(data);
            var currentquantity = parseInt($(".quantity_"+data).val());
            var updatedquantity = currentquantity + 1;
            $(".quantity_"+data).val(updatedquantity);

            var formData = {
                '_token':'{{ csrf_token()}}',
                'item_id': data,
                'quantity': updatedquantity,
                'price': price,
                'identifier': 'plus'
            };

            var url = '<?= URL::to("menu/foodcart_update") ?>'; 
            

            $.post(url,  formData, function (resp,textStatus, jqXHR) {
            
            });
              var unit_id = "<?= $getid ?>";
        var url = "<?= URL::to('menu/get_cart_data') ?>/"+unit_id;
        $.get(url, function(data) {
           if (data.length==0) {
               $(".bottomcart").hide();
            }else {
              $(".bottomcart").show();
              $(".itemcount").html(data['quantity']);
              $(".itemprice").html(data['price']);
              $(".unit_name").html(data['unit_name']);
            }
        });
            
         });

          $(".addonclose").click(function() {
             $(".addbox").hide();
          })
    });
     
   </script>
   <div class="loader"></div>
<style type="text/css">
  .switch {
        position: relative;
    display: inline-block;
    width: 50px;
    height: 21px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}
.hide {
  display: none;
}
.visible {
  display: flex;
}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
 position: absolute;
    content: "";
    height: 15px;
    width: 18px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked + .slider {
  background-color: #f3a423;
}

input:focus + .slider {
  box-shadow: 0 0 1px #f3a423;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
   border-radius: 34px;
    width: 50px;
}

.slider.round:before {
  border-radius: 50%;
}
   .loader {
    position: fixed;
    display: none;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8) url({{ asset('public/images/loader2.gif')  }}) center center no-repeat;
    z-index: 1000;
}
.food-section {
    padding-right: 6px !important;
    padding-left: 6px !important;
}
.featured_image_box {
 width: 160px;
    height: 100px;
    margin-bottom: 10px;
    background-size: cover !important;
    background-position: center !important;
}
._1gDO3 {
        position: absolute;
    right: 0;
    left: 0;
    bottom: -1px;
    font-size: 9px;
    font-weight: 500;
    color: #7e808c;
    text-align: center;
    margin-left: 64px;
}
._1gDO32 {
   position: absolute;
    right: 0;
    left: 0;
    bottom: -15px;
    font-size: 9px;
    font-weight: 500;
    color: #7e808c;
    text-align: center;
    margin-left: 95px;
}
.nbtn {
  background: transparent;
  color: white;

}
	.profile-pic {
    max-width: 100px;
    max-height: 100px;
    display: block;
}
}
.addonclose {
  float: right;
}
.restaurant-name {
  font-size: 11px;
  margin-top: -5px;
}
.addbox {
  height: 100vh;
  width: 100%;
  background: #fff;
  position: fixed;
  top: 0;
  padding: 10px;
  padding-top: 150px;
  display: none;
}
.hided {
  display: none;
}
.bottomcart {
  width: 100%;
  height: 50px;
  padding: 10px;
  background: #60b246;
  position: fixed;
  bottom: 0;
  z-index: 999;
  color: #fff;
  padding-left: 10px;
  padding-right: 10px;
}
.bottomcarta {
font-size: 16px;
}
.bottomcart .col-6:nth-child(2) {
  text-align: right;
}
.NCPX7 {
   -o-text-overflow: ellipsis;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    margin-top: 7px;
    color: #7e808c;
    font-size: 11px;
    text-transform: capitalize;
}
.foodquantity {
  width: 70px;
    border: 1px solid #d4d5d9;
    text-align: center;
    float: right;
    text-transform: uppercase;
    color: #f3a423;
    font-weight: 500;
    font-size: .93rem;
    border-radius: 5px;
    height: 30px;
    padding-top: 3px;
        z-index: 9999;
    
}
.foodquantity input {
      width: 20px;
    text-align: center;
    border: none;
    top: -2px;
    position: relative;
    color: #f3a423;
}
.foodquantity button {
      width: 15px;
    text-align: center;
    padding: 1px;
    background: transparent;
    border: none;
    color: #f3a423;
}
.featured_image img {
  width: 100%;
  height: auto;
  margin-bottom: 10px;
}
.red {
	color: red;
	font-size: 10px;
}
.unavailable {
  font-size: 10px;
  line-height: 12px;
  float: right;
  width: 60px;
 
}
.addButton {
	width: 70px;
    border: 1px solid #d4d5d9;
    text-align: center;
    float: right;
    text-transform: uppercase;
    color: #f3a423;
    font-weight: 500;
    font-size: .93rem;
    height: 30px;
    padding-top: 3px;
}
.btnmarginright {
  margin-right: -30px;
}
.btnmargintop {
  margin-top: -20px;
}
.circle {
    border-radius: 1000px !important;
    overflow: hidden;
    width: 100px;
    height: 100px;
    border: 8px solid rgba(0, 0, 0, 0.1);
    position: relative;
    margin: 0 auto;

}
._3Bh5d {
	-webkit-box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
    text-transform: uppercase;
    font-size: 1.3rem;
    font-weight: 600;
    color: #3d4152;
    opacity: .9;
    text-align: center;
}
.Bn7DA {
    font-size: 13px;
    font-weight: 500;
    color: #3d4152;
    line-height: 1.3;
    margin-bottom: 10px;
}
.f5-yn {
        color: #686b78;
    font-size: 12px;
    -webkit-box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
    position: relative;
    top: 5px;
    left: 4px;
    width: 34px;
}
.f5-yn2 {
       color: #686b78;
    font-size: 12px;
    -webkit-box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
    position: relative;
    top: 5px;
    left: 4px;
    width: 34px;
}
.store-desc {
	font-size: 11px;
	color: #7e808c;
}

/* ribbon area  */
.featured_image {
  background-color: #fff;
    position: relative;
}
.ribbon {
  -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    -o-transform: rotate(-45deg);
    transform: rotate(-45deg);
    border: 25px solid transparent;
    border-top: 25px solid rgb(213, 61, 76);
    position: absolute;
    bottom: -3px;
    right: -38px;
    padding: 0 10px;
    width: 98px;
    color: white;
    font-family: sans-serif;
    size: 11px;
}
.ribbon .txt {
    position: absolute;
    top: -22px;
    left: 5px;
    font-size: 10px;
}​

</style>
@endsection