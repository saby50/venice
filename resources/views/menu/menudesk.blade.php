@extends('layouts.main2')

@section('title')
<?php 
$unit_details = Helper::get_unit_info($getid);
$unit_name = NULL; $foodstore = NULL;
$tags = NULL; $price_for_two = NULL;
$from_time = "";
$to_time = "";
$enable_food_order = "";
  $selected_unit_name = "";
$selected_unit_id = 0;
foreach ($unit_details as $key => $value) {
  $unit_name = $value->unit_name;
  $foodstore = $value->foodstore;
  $tags = $value->tags;
  $enable_food_order = $value->enable_food_order;
  $price_for_two = $value->price_for_two;
  $from_time = $value->from_time;
  $to_time = $value->to_time;
  $prep_time = $value->prep_time;
  
}
echo $unit_name."<p style='font-size:11px;margin-left: 42px;margin-top:-5px;'>".$tags."</p>";

$menu = Helper::get_menu_items($getid,$view);
$categories = array();
foreach ($menu as $key => $value) {
  $categories[] = $value->food_category_id;
}
$cart_json = array();
$categories = array_unique($categories);
if (Session::has('food_cart')) {
  $cart = Session::get('food_cart');
  $cart_json = $cart;


foreach ($cart as $key => $value) {
  $selected_unit_id = $value['unit_id'];

}
$get_unit_info = Helper::get_unit_info($selected_unit_id);

foreach ($get_unit_info as $key => $value) {
  $selected_unit_name = $value->unit_name;
}

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

$food_order = "";
$current_time = date('g:i A');


?>
@endsection
@section('includes')
     <meta property="og:title" content="The Grand Venice Mall | Fine Dining">
    <meta property="og:description" content="A Memorable Fine Dining Experience">
     <meta property="og:image" content="{{ asset('public/images/GV03.jpg') }}">
@endsection
@section('content')

   <div class="sideicons desktop" style="display: none;">
     <a href="<?= URL::to('food-court') ?>" data-placement="left"  data-toggle="tooltip" title="Food Court"><img src="{{ asset('public/images/pages/foodcourticon.png') }}" onmouseover="this.src='{{ asset('public/images/pages/foodcourticona.png') }}'"  onmouseout="this.src='{{ asset('public/images/pages/foodcourticon.png') }}'"></a>

      <br />
      <a href="<?= URL::to('fine-dining') ?>" data-placement="left" data-toggle="tooltip" title="Fine Dining
"><img src="{{ asset('public/images/pages/finediningicon.png') }}" onmouseover="this.src='{{ asset("public/images/pages/finediningicona.png") }}'"  onmouseout="this.src='{{ asset('public/images/pages/finediningicon.png') }}'"></a>
         <br />
      <a href="<?= URL::to('cafe-bakeries') ?>" data-placement="left" data-toggle="tooltip" title="Cafe & Bakeries
"><img src="{{ asset('public/images/pages/bakeryicon.png') }}" onmouseover="this.src='{{ asset('public/images/pages/bakeryicona.png') }}'"  onmouseout="this.src='{{ asset('public/images/pages/bakeryicon.png') }}'"></a>
      
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
        <img data-u="image" src="{{ asset('public/images/pages/finedininga.jpg') }}"  class="mobile" />
      </div>
  <?php else: ?>
    <section id="" class="homehero" style="z-index: 1;display: none;">
       
    
          <div id="jssor_1" style="position:relative;margin:0 auto;top:-108px;left:0px;width:1300px;height:550px;overflow:hidden;visibility:hidden;z-index: 1;">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="{{ asset('public/svg/loading/static-svg/spin.svg') }}" />
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1300px;height:550px;overflow:hidden;">
            <div>
                <img data-u="image" src="{{ asset('public/images/130919064745020819042206Home-Banne-1.jpg') }}" class="desktop" />
                <img data-u="image" src="{{ asset('public/images/130919064745020819042206Home-Banne-1.jpg') }}" class="mobile" />
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
        <div data-u="arrowleft" class="jssora051 hidearrows"  style="width:65px;height:65px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
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

    <div class="restaurant-banner" id="resbanner">
     
      <div class="container">
         <div class="row">
        <div class="col-3">
          <img src="<?= URL::to('public/uploads/foodstore/'.$foodstore) ?>" class="unit_img">
          
        </div>
          <div class="col-9 smargin">
            <div class="row">
            <div class="col-md-12" style="border-bottom: solid 1px #ccc;padding-bottom: 10px;">
             <strong class="title"><?= $unit_name ?> &nbsp; &nbsp; <?php 
                                $nonveg = Helper::get_veg_non($getid);

                      ?>
                      <?php if(in_array('veg', $nonveg)): ?>
                                        <img src="{{ asset('public/images/veg.png') }}" style="width: 15px;height: 15px;">
                                      <?php endif; ?>
                                      <?php if(in_array('nonveg', $nonveg)): ?>
                                         <img src="{{ asset('public/images/nonveg.png') }}" style="width: 15px;height: 15px;">
                                      <?php endif; ?></strong><br />
             <strong class="desc"><?= $tags ?></strong>
           </div>
           <div class="col-sm-2" style="font-size: 14px;color: #FFF;margin-top: 20px;border-right: solid 1px #fff;">
            <?= $prep_time ?><br /><span style="font-size: 11px;">Prep Time</span>
             
           </div>
      
          <div class="col-2" style="font-size: 14px;color: #FFF;margin-top: 20px;border-right: solid 1px #fff;">
           <?= $price_for_two ?><br /><span style="font-size: 11px;">Cost for Two</span>
             
           </div>
           <div class="col-3" style="font-size: 14px;color: #FFF;margin-top: 30px;">
              <?php 
            
            if($enable_food_order=="no") {
               echo "<span style='color:red;font-size:14px;'>Closed for order</span>";
               //$food_order = "no";
            }else {
              if (strtotime($current_time) > strtotime($from_time) && strtotime($current_time) < strtotime($to_time)) {
              $food_order = "yes";

            }else {
              echo "<span style='color:red;font-size:14px;'>Closed for order</span>";
              $food_order = "no";
            }
            }

            
          ?>
          <?php if($food_order=="yes"): ?>
          <label class="switch">
            <?php if($view=="veg"): ?>
             <input type="checkbox" name="veg" value="all" class="vegonly" checked="checked">
             <?php else: ?>
              <input type="checkbox" name="veg" value="veg" class="vegonly">
              <?php endif; ?>
            <span class="slider round"></span>
          </label> Veg
        <?php endif; ?>
           </div>
          </div>
        </div>
      </div>
     </div>
      
    </div>
    <div class="container mainarea" >
      <div class="row" style="display: flex;">
        <div class="col-2 sidebar-left" id="sidebar">
          <ul class="sidebar-items">
          <?php 
            foreach ($categories as $key => $value) {
           
              echo '<li><a href="#'.$value.'" style="color:#000;font-size:16px;">'.Helper::get_food_category_name($value)."</a></li>";
            }
          ?>
        </ul>
        </div>
         <div class="col-8 itemsarea">
          <?php foreach($categories as $k => $v): ?>
            
            <a name="<?= $v ?>"></a>
           <h4 style="margin-top: 20px;"><?= Helper::get_food_category_name($v) ?></h4>
           <?php 
         $menu_items = Helper::get_menu_items_category_id($v,$view,$getid);
         foreach($menu_items as $key => $value): ?>
          <div class="row content foodrow" style="margin-top: 20px;">
                <div class="col-1">
                  <?php if($value->veg_nonveg=="veg"): ?>
                    <img src="{{ asset('public/images/veg.png') }}" width="15" height="auto" style="margin-top: -10px;">
                    <?php else: ?>
                        <img src="{{ asset('public/images/nonveg.png') }}" width="15" height="auto" style="margin-top: -10px;">
                  <?php endif; ?>
                  
                </div>
        <div class="col-6">

          <div class="Bn7DA"> <?= ucfirst($value->item_name) ?></div>
          <div class="f5-yn2"><i class="fa fa-rupee"></i> <?= $value->price ?></div>
          
        </div>
          <div class="col-5" style="text-align: right;">
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
              <?php if($enable_food_order=="yes"): ?>
             <?php if($food_order=="yes"): ?>
             <?php if($quantity!=0): ?>
             <div class="addButton btnmargintop hided addbutton_<?= $value->id ?>" data-addon="<?= Helper::checkaddonfields($value->id) ?>"  data-price="<?= $value->price ?>" data="<?= $value->id ?>">Add</div>
         
               <div class="foodquantity btnmargintop quantitybox_<?= $value->id ?>" data="<?= $value->id ?>" data-price="<?= $value->price ?>">
           <button class="decrease"  data="<?= $value->id ?>" data-price="<?= $value->price ?>">-</button> <input type="number" value="1" name="quantity" class="quantity_<?= $value->id ?> q" readonly><button class="increase" data="<?= $value->id ?>" data-price="<?= $value->price ?>">+</button>
          </div>
      
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
      <?php else: ?>
         <div class="unavailable btnmarginright">Currently Unavailable</div>
      <?php endif; ?>
            
          

          
          <?php else: ?>
            <div class="unavailable btnmarginright">Currently Unavailable</div>
        <?php endif; ?>
            
          

          
          
        </div>
      </div>
       <?php endforeach; ?>
         <?php endforeach; ?>
        </div>
        <div class="col-3 sidebar-right" id="sidebar2" style="display: none;">
          <h3>Cart</h3>
          <div class="cart_empty">
            <img src="{{ URL::to('public/images/cart_empty.png') }}" style="width: 100%;">
          </div>
            <div class="cart_items">
            <div class="itemsArray"></div>
          </div>
        </div>
      </div>

      
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
      <div class="restaurant-name">From: <span class="unit_name"><?= $selected_unit_name ?></span></div>
      
    </div>
    <div class="col-6">
      <span style="text-transform: uppercase;">View Cart <i class="fa fa-shopping-bag" aria-hidden="true"></i></span> 
      
    </div> 
   </div>
  </div>
</a>
   <div id="myModal" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
      <iframe width="750" height="400" class="youtube-video" src="https://www.youtube.com/embed/O2YpPz9mFxU?start=2" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
      </div>
    </div>

  </div>
</div>
<!-- Modal -->
<div class="modal fadeUp" id="customizeModal" data-easein="bounceIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
  <form method="post" action="<?= URL::to('update_cart') ?>">
  @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Ons</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="addonfields"></div>
      </div>
      <div class="modal-footer">
        
        <button type="submit" class="btn btn-primary">Update Cart</button>
      </div>
    </div>
  </div>
  <input type="hidden" name="item_id" value="" class="item_id">
 <input type="hidden" name="titles"  value="" class="titles">
</form>
</div>
<!-- Modal -->
<div id="myModalSame" class="modal fade" role="dialog">
  <form method="post" id="sameunit" action="<?= URL::to('menu/add_item_cart') ?>">
    @csrf
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body" style="padding: 2px 16px;font-size: 14px;padding-top: 30px;height: 90px;">
        <p>Do you want to discard the current selection and add dishes from <strong><?php $units = Helper::get_unit($getid); echo $units['unit_name']; ?></strong>?</p>
        <input type="hidden" name="item_id" class="sitem_id">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="addon" class="addon">
        <input type="hidden" name="unit_id" value="<?= $getid ?>" class="funit_id">
        <input type="hidden" name="price" class="sprice">
        <input type="hidden" name="identifier" value="plus" class="identifier">
      </div>
      <div class="modal-footer" style="padding: 5px;">
        <button type="button" class="btn btn-default nbtn" id="no" style="color: #f3a423;border: solid 1px #f3a423;background: #FFF;" data-dismiss="modal">NO</button>
        <button type="submit" class="btn nbtn yes" style="background: #f3a423;color: #FFF;">YES, START FRESH</button>
      </div>
    </div>

  </div>
  </form>
</div>
<script src="{{ asset('public/js/jssor.slider.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">

  $(document).ready(function() {

     $(".sidebar-left li:first-child").addClass("current-item");
    $(".sidebar-left a").click(function() {
       $(".sidebar-left li").removeClass("current-item");
      $(this).parent("li").addClass("current-item");
    });
    var unit_id = "<?= $getid ?>";
    var selected_unit_id = "";
       
        var cart_data = <?= json_encode($cart_json) ?>;

        if (cart_data.length==0) {
          $(".bottomcart").hide();

        }else {
          $(".bottomcart").show();
            $.each(cart_data, function(i, data) {
             $(".bottomcart").show();
              $(".itemcount").html(data['quantity']);
              $(".itemprice").html(data['price']);
              
              selected_unit_id = data['unit_id'];

           });
        }

      

         
         var i = <?= $q ?>;
         var mainprice = <?= $p ?>;
         var initialdata = <?= Helper::get_unit_menu_data($getid) ?>;
         var addonfields = "";
     $(".yes").click(function() {
        var url = $("#sameunit").attr('action');
        var sitem_id = $(".sitem_id").val();
        var quantity = "1";
        var titles = "";
        var addon = $(".addon").val();
        var sprice = $(".sprice").val();
        var funit_id = $(".funit_id").val();
        var identifier = $(".identifier").val();
        var formData = {
           '_token':'{{ csrf_token()}}',
             'item_id': sitem_id,
             'quantity': quantity,
             'addon': addon,
             'price': sprice,
             'unit_id': funit_id,
             'identifier': identifier
        };
        $.post(url, formData,
            function (resp,textStatus, jqXHR) {
              if (addon=="1") {
                $("#myModalSame").modal("hide");
                 addonfields = "";
                    $.each(initialdata, function(i,v) {
                       if (v['item_id']==sitem_id) {
                           addonfields += "<h5>" + v['addon_title'] + "</h5>";
                           
                           
                           titles+=  v['addon_title'];


                           var customize = v['customize'];
                           var type = v['addon_type'];
                           if (customize=="") {

                           }else {
                            $.each(customize, function(m,n) {
                               if (type=="radio") {
                                if (m==0) {
                                  addonfields += '<input type="radio"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'" checked="checked"> '+n['addon_name']+' <span style="font-size:11px;"> (Rs. '+n["cost"]+')</span><br />';
                                }else {
                                   addonfields += '<input type="radio"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'"> '+n['addon_name']+' <span style="font-size:11px;"> (Rs. '+n["cost"]+')</span><br />';
                                }
                                
                               }else {
                                if (m==0) {
                                   addonfields += '<input type="checkbox"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'" checked="checked"> '+n['addon_name']+'<span style="font-size:11px;"> (Rs. '+n["cost"]+')</span><br />';
                                }else {
                                    addonfields += '<input type="checkbox"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'"> '+n['addon_name']+'<span style="font-size:11px;">  (Rs. '+n["cost"]+')</span><br />';

                                }
                               
                               }
                               
                           });
                             $("#customizeModal .addonfields").html(addonfields);
                             $("#customizeModal").modal("show");
                             $(".item_id").val(sitem_id);
                             $(".titles").val(titles);
                           }
                           
                           
                       }
                    });

              }else {
                window.location = "<?= URL::to('food_cart') ?>";
              }
               
        });

        return false;
              
     });    
     $(".addButton").click(function() {
         var data = $(this).attr('data');
           var addon = $(this).attr('data-addon');         
           var price = parseInt($(this).attr('data-price'));
           var titles = "";
           var unit_id = "<?= $getid ?>";
            setTimeout( function() { $('.loader').show(); }, 300 );
            setTimeout( function() { $('.loader').hide(); }, 800 );
            if (cart_data.length!=0) {
              if (selected_unit_id==unit_id) {
           
              $(".quantitybox_"+data).show();
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
              
             var unit_name = "<?php $units = Helper::get_unit($getid); echo $units['unit_name']; ?>";
             $(".unit_name").html(unit_name);
             
              $.post(url,  formData,
            function (resp,textStatus, jqXHR) {

                  console.log(resp);
            if (resp.length==0) {
               $(".bottomcart").hide();
            }else {
              $(".bottomcart").show();
              $(".itemcount").html(resp['quantity']);
              $(".itemprice").html(resp['price']);
              $(".unit_name").html(resp['unit_name']);
                if (resp['sameunit']==1) {
                    
                
                }else {
                  
                  if (addon=="1") {
                    addonfields = "";
                    $.each(initialdata, function(i,v) {
                       if (v['item_id']==data) {
                           addonfields += "<h5>" + v['addon_title'] + "</h5>";
                           
                           
                           titles+=  v['addon_title'];


                           var customize = v['customize'];
                           var type = v['addon_type'];
                           if (customize=="") {

                           }else {
                            $.each(customize, function(m,n) {
                               if (type=="radio") {
                                if (m==0) {
                                  addonfields += '<input type="radio"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'" checked="checked"> '+n['addon_name']+' <span style="font-size:11px;"> (Rs. '+n["cost"]+')</span><br />';
                                }else {
                                   addonfields += '<input type="radio"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'"> '+n['addon_name']+' <span style="font-size:11px;"> (Rs. '+n["cost"]+')</span><br />';
                                }
                                
                               }else {
                                if (m==0) {
                                   addonfields += '<input type="checkbox"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'" checked="checked"> '+n['addon_name']+'<span style="font-size:11px;"> (Rs. '+n["cost"]+')</span><br />';
                                }else {
                                    addonfields += '<input type="checkbox"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'"> '+n['addon_name']+'<span style="font-size:11px;">  (Rs. '+n["cost"]+')</span><br />';

                                }
                               
                               }
                               
                           });
                             $("#customizeModal .addonfields").html(addonfields);
                             $("#customizeModal").modal("show");
                             $(".item_id").val(data);
                             $(".titles").val(titles);
                           }
                           
                           
                       }
                    });
                   
                }
            }
              
              }
                
            });
            }else {
                $("#myModalSame").modal({backdrop: 'static', keyboard: false});
                  $(".sitem_id").val(data);
                  $(".sprice").val(price);
                  $(".addon").val(addon);

                  
                  $("#no").attr("data-no",data);
            }
          }else {
              var data = $(this).attr('data');
           var addon = $(this).attr('data-addon');         
           var price = parseInt($(this).attr('data-price'));
           var titles = "";
           var unit_id = "<?= $getid ?>";
              $(".quantitybox_"+data).show();
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
              
             var unit_name = "<?php $units = Helper::get_unit($getid); echo $units['unit_name']; ?>";
             $(".unit_name").html(unit_name);
             
              $.post(url,  formData,
            function (resp,textStatus, jqXHR) {

                  console.log(resp);
            if (resp.length==0) {
               $(".bottomcart").hide();
            }else {
              $(".bottomcart").show();
              $(".itemcount").html(resp['quantity']);
              $(".itemprice").html(resp['price']);
              $(".unit_name").html(resp['unit_name']);
                if (resp['sameunit']==1) {
                    
                
                }else {
                  
                  if (addon=="1") {
                    addonfields = "";
                    $.each(initialdata, function(i,v) {
                       if (v['item_id']==data) {
                           addonfields += "<h5>" + v['addon_title'] + "</h5>";
                           
                           
                           titles+=  v['addon_title'];


                           var customize = v['customize'];
                           var type = v['addon_type'];
                           if (customize=="") {

                           }else {
                            $.each(customize, function(m,n) {
                               if (type=="radio") {
                                if (m==0) {
                                  addonfields += '<input type="radio"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'" checked="checked"> '+n['addon_name']+' <span style="font-size:11px;"> (Rs. '+n["cost"]+')</span><br />';
                                }else {
                                   addonfields += '<input type="radio"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'"> '+n['addon_name']+' <span style="font-size:11px;"> (Rs. '+n["cost"]+')</span><br />';
                                }
                                
                               }else {
                                if (m==0) {
                                   addonfields += '<input type="checkbox"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'" checked="checked"> '+n['addon_name']+'<span style="font-size:11px;"> (Rs. '+n["cost"]+')</span><br />';
                                }else {
                                    addonfields += '<input type="checkbox"  name="'+v['addon_title']+'" value="'+n['addon_name']+"_"+n["cost"]+'"> '+n['addon_name']+'<span style="font-size:11px;">  (Rs. '+n["cost"]+')</span><br />';

                                }
                               
                               }
                               
                           });
                             $("#customizeModal .addonfields").html(addonfields);
                             $("#customizeModal").modal("show");
                             $(".item_id").val(data);
                             $(".titles").val(titles);
                           }
                           
                           
                       }
                    });
                   
                }
            }
              
              }
                
            });
          }
            
           
           
         });
$(".vegonly").change(function() {
          var data = $(this).val();
          var url = "<?= URL::to('show-menu/"+data+"/'.Crypt::encrypt($getid)) ?>";
          window.location = url;
      });
     $(".decrease").click(function() {
                setTimeout( function() { $('.loader').show(); }, 300 );
            setTimeout( function() { $('.loader').hide(); }, 800 );
            var data = $(this).attr('data');
            var unit_id = "<?= $getid ?>";
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
                'identifier': 'minus',
                'unit_id' : unit_id
            };

            var url = '<?= URL::to("menu/foodcart_update") ?>'; 
            

            $.post(url,  formData, function (resp,textStatus, jqXHR) {
               console.log(resp);
            if (resp.length==0) {
               $(".bottomcart").hide();
            }else {
              $(".bottomcart").show();
              $(".itemcount").html(resp['quantity']);
              $(".itemprice").html(resp['price']);
              $(".unit_name").html(resp['unit_name']);
            }
            });

            var unit_id = "<?= $getid ?>";
        

            
            
         });
          $(".increase").click(function() {
            setTimeout( function() { $('.loader').show(); }, 300 );
            setTimeout( function() { $('.loader').hide(); }, 800 );
            var unit_id = "<?= $getid ?>";
            var data = $(this).attr('data');
            var price = parseInt($(this).attr('data-price'));
            var unit_id = "<?= $getid ?>";
           // alert(data);
            var currentquantity = parseInt($(".quantity_"+data).val());
            var updatedquantity = currentquantity + 1;
            $(".quantity_"+data).val(updatedquantity);

            var formData = {
                '_token':'{{ csrf_token()}}',
                'item_id': data,
                'quantity': updatedquantity,
                'price': price,
                'identifier': 'plus',
                'unit_id' : unit_id
            };

            var url = '<?= URL::to("menu/foodcart_update") ?>'; 
            

            $.post(url,  formData, function (resp,textStatus, jqXHR) {
              console.log(resp);
            if (resp.length==0) {
               $(".bottomcart").hide();
            }else {
              $(".bottomcart").show();
              $(".itemcount").html(resp['quantity']);
              $(".itemprice").html(resp['price']);
              $(".unit_name").html(resp['unit_name']);
            }
            });
              var unit_id = "<?= $getid ?>";
       
            
         });
          
 });
         

 
</script>
<script>
var sidebar = document.getElementById("resbanner");
var stickyCart = sidebar.offsetTop;
function myCart() {
  if (window.pageYOffset >= stickyCart) {
    sidebar.classList.add("staticbox")
  } else {
    sidebar.classList.remove("staticbox");
  }
}

$(window).scroll(function() {
   myCart();
});

window.onscroll = function() {myFunction()};

var navbar = document.getElementById("sidebar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>
    <style type="text/css">
        #hero {
  margin-top: -6.8%;
  width: 100%;
  height: 100vh;

  background-size: contain;
  position: relative;
}
.current-item a {
  color: #ee9e11 !important;
  
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
     margin-left: 247px;
}
.cart_items {
  display: none;
}
.smargin {
  margin-top: 30px;
}
.staticbox .smargin {
  margin-top: 10px;
}
.staticbox .unit_img {
  width: 150px;
  margin-top: 10px;
}
.staticbox {

        height: 141px !important;

    margin-top: 18px !important;

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
.current-item {
  color: #ee9e11;
  border-right: solid 4px #ee9e11;
}
.mainarea {
  padding: 20px;
}
.sidebar-right  {
  position: fixed;
  z-index: 1;
  top: 400px;
  right: 70px;
   width: auto;

}
.hided {
  display: none;
}
.switch {
        position: relative;
    display: inline-block;
    width: 50px;
    height: 21px;
}
.unit_img {
  width: 200px;
  margin-top: 30px;
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
  background-color: #62cc72;
}

input:focus + .slider {
  box-shadow: 0 0 1px #62cc72;
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
.bottomcart {
  width: 600px;
  height: 45px;
  font-size: 14px;
  line-height: 16px;
  padding: 10px;
  background: #60b246;
  position: fixed;
  bottom: 0;
  z-index: 999;
  color: #fff;
  padding-left: 10px;
  padding-right: 10px;
  left: 50%;
  margin-left: -300px;
}
.bottomcarta {
font-size: 16px;
}
.bottomcart .col-6:nth-child(2) {
  text-align: right;
}
.sidebar-left  {
 position: fixed;
  z-index: 1;
  top: 400px;
  left: 70px;
   width: 130px;


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
    cursor: pointer;
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
.hided {
  display: none;
}
.foodquantity input {
      width: 25px;
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
.sticky {
   top: 20px;
}
.sticky2 {
   top: 20px;
}

ul.sidebar-items {
width: 200px;
}
ul.sidebar-items li {
  list-style: none;
  width: 100%;
}
.restaurant-banner {
  width: 100%;
  height: 200px;
  background: #39397f;
  margin-top: 25px;
 
  z-index: 9999;

}

#myModal iframe  {
  width: 100%;
}
.Bn7DA {
  color: #000;
  font-size: 14px;
}
.itemsarea {
 margin-left: 220px;
  border-left:solid 1px #ccc;
  border-right:solid 1px #ccc;

}
.foodrow {
  border-bottom: solid 1px #ccc;
  padding-bottom: 10px;
}
.food-img {
  border: solid 1px #ccc;
}
#foodarea {
  margin-bottom:60px !important;
  width: 1050px;
  margin: 0 auto;
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
.unavailable {
  font-size: 10px;
  line-height: 12px;
  float: right;
  width: 60px;
 
}
.title {
  font-size: 18px;
  font-weight: bold;
color: #FFF;
} 
hr {
  background: #FFF;
}
.desc {
    font-size: 13px;
    color: #FFF;
}

    </style>
      <script type="text/javascript">

      $(function() {
    
        $(".modalclick").click(function() {
           $('#myModal').modal({backdrop: 'static', keyboard: false});
               $('.youtube-video').attr('src','https://www.youtube.com/embed/O2YpPz9mFxU?start=2&autoplay=1');
              
        });
        $("#myModal .close").click(function() {
           $('.youtube-video').attr('src','https://www.youtube.com/embed/O2YpPz9mFxU?start=2');
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