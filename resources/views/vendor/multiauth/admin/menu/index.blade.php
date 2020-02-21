@extends('multiauth::layouts.main') 


@section('title')
Order Menu - <?php $units = Helper::get_unit_info($unit_id); echo $units[0]->unit_name; ?>
@endsection

@section('content')
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Add Menu</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
        <?php 

        $units = Helper::get_unit_info($unit_id);
        $unit_name = ""; $foodstore = "";
        foreach ($units as $key => $value) {
          $unit_name = $value->unit_name;
          $foodstore = $value->foodstore;
        }


        ?>
				<h2>Menu - <?php echo $unit_name; ?></h2>

			</div>
		</div>
		<div class="col-md-8 column">
			<div class="top-bar-chart">
				<div class="quick-report">
					<div class="quick-report-infos">

					</div>
					<span class="bar2"><a href="<?= URL::to('admin/create-menu-item/'.$unit_id) ?>"><button class="btn btn-primary">Add Menu Item</button></a></span>
				</div>
 
			</div><!-- Top Bar Chart -->
		</div>
	</div>
</div><!-- Top Bar Chart -->

<div class="panel-content">
	<div class="row">
	@if (session('status'))
				<div class="widget no-color">
						<div class="alert alert-success">
								<div class="notify-content">
									 {{ session('status') }}!

								</div>
						</div>
						</div>
				</div>
			@endif
			</div>
	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">

					<div class="row">

						

   <div class="small-12 medium-2 large-2 columns">
     <div class="circle" >
       <!-- User Profile Image -->
       <img class="profile-pic" src="<?= asset('/uploads/foodstore/'.$foodstore) ?>" style="margin-top: -10px;width: 180px;">

       <!-- Default Image -->
       <!-- <i class="fa fa-user fa-5x"></i> -->
     </div>
    
  </div>

  <?php if(count($data)==0): ?>

  <div class="col-md-12" style="text-align: center;margin-top: 40px;">
    <h4>Please enter first menu item!</h4>

   <a href="<?= URL::to('admin/create-menu-item/'.$unit_id) ?>" style="color: #666;"><i class="fa fa-plus-circle fa-5x"></i><br />Add Item</a>
    
  </div>
  <?php else: ?>
    <table class="table" style="margin-top: 40px;">
      <thead>
        <tr>
          <th>Dish Name</th>
          <th>Category</th>
          <th>Price (Rs.)</th>
          <th>Status</th>
          
          <th>Add On</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($data as $key => $value): ?>
        <tr>
          <td><?= $value->item_name ?><br />
          <?php
           $addons = Helper::get_item_addons($value->id);
           if (count($addons) !=0) {
              echo "<h5 style='margin-left: 10px;font-weight:bold;'>Addons</h5>";
              echo "<ul class='addon-menu'>";
            
             foreach ($addons as $m => $n) {
               echo "<li>".$n->title." <a href='#' data='".$n->id."' data-itemid='".$value->id."' class='edit editaddon'><i class='fa fa-pencil' aria-hidden='true'></i></a> <a href='#' data='".URL::to('admin/delete-menu-addon/'.$n->id)."' class='delete'><i class='fa fa-times' aria-hidden='true'></i></a> </li>";
             }
              echo "</ul>";
           }

            
           ?>
          </td>
          <td><?= Helper::get_food_category_name($value->food_category_id) ?></td>
          <td><?= $value->price ?></td>
          <td><?= ucfirst($value->status) ?></td>
          
           <td><span class="addonplus" data="<?= $value->id ?>"><i class="fa fa-plus-circle fa-lg" style="color: green;"></i></span></td>
          <td><a href="<?= URL::to('admin/edit-menu-item/'.$value->id) ?>" class="edit"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a></td>
          <td><a href="#" data="<?= URL::to('admin/delete-menu-item/'.$value->id) ?>" class="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>


					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- Panel Content -->
</div>
 <!-- Modal -->
 <div class="modal fade" id="myModal12" role="dialog">
  <form action="<?= URL::to('admin/menu/addons_create') ?>" method="post">
    @csrf
   <div class="modal-dialog modal-md">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Add On</h4>
       </div>
       <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>Enter Title</label>
            <input type="text" name="addon_name" placeholder="Title" class="form-control">
          </div>
          <div class="col-md-12" style="margin-top: 10px;">
          <label>Select Type</label>
         <select name="type" class="form-control">
           <option value="radio">Radio</option>
           <option value="checkbox">Checkbox</option>
         </select>
          </div>
           <div class="col-md-6" style="margin-top: 10px;">
            <label>Addon Name</label>
           <input type="text" name="addonname[]" class="form-control" required="required">
         </div>
         <div class="col-md-6" style="margin-top: 10px;">
          <label>Addon Price</label>
           <input type="text" name="addonprice[]" class="form-control" required="required">
         </div>
         <span class="addonarea"></span>

         <div class="col-md-12" style="text-align: left;margin-top: 10px;">
          <button type="button" class="addonpluss"><i class="fa fa-plus fa-lg"></i></button>
         </div>
        </div>       
       </div>
       <input type="hidden" name="item_id" class="item_id" value="">
       <input type="hidden" name="unit_id" value="<?= $unit_id ?>">
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
         <button type="submit" class="btn btn-primary">Add</button>
       </div>
     </div>
   </div>
   </form>
 </div>
 <!-- Modal -->
 <div class="modal fade" id="myModal13" role="dialog">
  <form action="<?= URL::to('admin/menu/addons_edit') ?>" method="post">
    @csrf
   <div class="modal-dialog modal-md">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Add On</h4>
       </div>
       <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>Enter Title</label>
            <input type="text" name="addon_name" placeholder="Title" class="form-control addon_name">
          </div>
          <div class="col-md-12" style="margin-top: 10px;">
          <label>Select Type</label>
         <select name="type" class="form-control types">
         
         </select>
          </div>
          <div class="addonboxarea"></div>
           
         <span class="addonarea"></span>

         <div class="col-md-12" style="text-align: left;margin-top: 10px;">
          <button type="button" class="addonpluss"><i class="fa fa-plus fa-lg"></i></button>
         </div>
        </div>       
       </div>
       <input type="hidden" name="item_id" class="item_id" value="">
       <input type="hidden" name="item_addon_id" class="item_addon_id" value="">
       <input type="hidden" name="unit_id" value="<?= $unit_id ?>">
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
         <button type="submit" class="btn btn-primary">Update</button>
       </div>
     </div>
   </div>
   </form>
 </div>
<script type="text/javascript">
  $(document).ready(function() {
     $(".addonplus").click(function() {
       var data = $(this).attr('data');
       $("#myModal12").modal("show");
       $(".item_id").val(data);
     });
      $(".removetosyncs").click(function() {
       alert();
     });
    
     $(".editaddon").click(function() {
       var data = $(this).attr('data');
       var data_itemid = $(this).attr('data-itemid');
       $("#myModal13").modal("show");
       $(".item_addon_id").val(data);
       $(".item_id").val(data_itemid);
       var url = "<?= URL::to('admin/get_addon') ?>/"+data;
       var html = "";
       $.get(url, function(data) {
           $(".addon_name").val(data['title']);
           var types = data['type'];
           if (types=="radio") {
              html = '<option value="radio" selected="selected">Radio</option><option value="checkbox">Checkbox</option>';
           }else {
             html = '<option value="radio">Radio</option><option value="checkbox" selected="selected">Checkbox</option>';
           }
           $(".types").html(html);
           var addonlist = "";
        $.each(data['addon_list'], function(k, v) {
          addonlist += '<div class="row1"><div class="col-md-6" style="margin-top: 10px;"><input type="hidden" name="addonid[]" value="'+v['id']+'"><label>Addon Name</label><input type="text" name="addonname[]" class="form-control" required="required" value="'+v['addon_name']+'">\n\
          </div>\n\
         <div class="col-md-6" style="margin-top: 10px;">\n\
          <label>Addon Price</label>\n\
           <input type="text" name="addonprice[]" class="form-control" required="required" value="'+v['cost']+'"><button type="button" class="removetosync" style="float: right;" data="'+v['id']+'"><i class="fa fa-minus fa-lg "></i></button></div></div>';
           $(".addonboxarea").html(addonlist);
          });
        });
     });
     $(".addonpluss").click(function() {
         $(".addonarea").append('<div class="row1"><div class="col-md-6" style="margin-top: 10px;">\n\
            <input type="hidden" name="addonid[]" value=""><label>Addon Name</label>\n\
           <input type="text" name="addonname[]" class="form-control" required="required">\n\
         </div>\n\
         <div class="col-md-6" style="margin-top: 10px;">\n\
          <label>Addon Price</label>\n\
           <input type="text" name="addonprice[]" class="form-control" required="required">\n\
           <button type="button" class="removeto" style="float: right;"><i class="fa fa-minus fa-lg"></i></button>\n\
         </div></div>');
        });
     $(document).on("click", ".removeto", function (e) { //user click on remove text
      e.preventDefault();
      $(this).closest('.row1').remove();
      x--;
    })
     $(document).on("click", ".removetosync", function (e) { //user click on remove text
      e.preventDefault();
      var addonid = $(this).attr('data');
      var url = "<?= URL::to('admin/removeaddon') ?>/"+addonid;
      var response = "";
      $.get(url, function(data) {
        response = data;
       
      });
      $(this).closest('.row1').remove();
        x--;
      
    })
  });
</script>
<style type="text/css">
	.profile-pic {
    max-width: 200px;
    max-height: 200px;
    display: block;
}
.addonplus {
  cursor: pointer;
}
.file-upload {
    display: none;
}
ul.addon-menu {
  list-style: none;
    margin-left: -20px;
    margin-top: -10px;
}
ul.addon-menu > li:before {
    display: inline-block;
    content: "-";
    width: 1em;
    margin-left: -1em;
}
.circle {
    border-radius: 1000px !important;
    overflow: hidden;
    width: 128px;
    height: 128px;
    border: 8px solid rgba(0, 0, 0, 0.1);
    position: relative;
    margin: 0 auto;

}
img {
    max-width: 100%;
    height: auto;
}
.p-image {
  position: absolute;
  top: 167px;
  right: 30px;
  color: #666666;
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
}
.p-image:hover {
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
}
.upload-button {
  font-size: 1.2em;
}

.upload-button:hover {
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
  color: #999;
}
</style>

@endsection
