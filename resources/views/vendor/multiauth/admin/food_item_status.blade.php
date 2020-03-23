<!DOCTYPE html>
<html>
<head>
	<title>Food Item Status</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
</head>
<body>
  <?php
     $enable_food_order = "";
     $from_time = "";
     $to_time = "";
    foreach ($units as $key => $value) {
      $enable_food_order = $value->enable_food_order;
      $from_time = $value->from_time;
      $to_time = $value->to_time;
    }
  ?>
  <div class="row" style="padding: 10px;margin-top: 20px;">
   <div class="col-6 stitles" style="text-align: left;">
    Food Order
      
      
    </div>
     <div class="col-6 sf-align-right" style="text-align: right;">
     <label class="switch">
            <?php if($enable_food_order=="no"): ?>
             <input type="checkbox" name="enable_food_order" value="yes" class="enable_food_order"   data="<?= $unit_id ?>">
             <?php else: ?>
              <input type="checkbox" name="enable_food_order" value="no" class="enable_food_order" checked="checked" data="<?= $unit_id ?>" >
              <?php endif; ?>
            <span class="slider round"></span>
          </label>   
    </div>
  </div>
  <div class="row" style="padding: 10px;">
   <div class="col-6 stitles" style="text-align: left;">
    Timings (<a href="#" class="editbox">Edit</a>)
      
      
    </div>
     <div class="col-6 sf-align-right" style="text-align: right;">
       <?= $from_time ?> - <?= $to_time ?>
    </div>
  </div>
<div class="row" style="padding: 10px;">
	<div class="col-12" style="margin-bottom: 20px;">
		<input type="text" class="form-control" name="search" id="search" placeholder="Search by item name">
		
	</div>
  <?php 
    $menu = Helper::get_menu_items($unit_id,'all');
    $categories = array();
   foreach ($menu as $key => $value) {
    $categories[] = $value->food_category_id;
  }
   $categories = array_unique($categories);

  ?>
	<?php foreach($categories as $key => $value): ?>
		 <div class="fcontent">
      <div class="col-12" style="font-weight: bold;text-align: left;font-size: 16px;margin-bottom: 10px;border-bottom: solid 1px #ccc;padding-bottom:5px;text-transform: uppercase;">
        <?= Helper::get_food_category_name($value) ?>
        
      </div>
      <?php 
         $menu_items = Helper::get_menu_items_category_id($value,'all',$unit_id);
         foreach($menu_items as $k => $v):

       ?>
       <div class="mcontent">
	<div class="col-6 stitles" style="text-align: left;">
        <?= $v->item_name ?>
		
	</div>

	<div class="col-6 sf-align-right" style="text-align: right;">

		<label class="switch">
            <?php if($v->status=="active"): ?>
             <input type="checkbox" name="veg" value="inactive" data="<?= $v->id ?>" class="status" checked="checked">
             <?php else: ?>
              <input type="checkbox" name="veg" value="active" data="<?= $v->id ?>" class="status">
              <?php endif; ?>
            <span class="slider round"></span>
          </label>   
	</div>
  </div>
  <?php endforeach; ?>

	</div>
<?php endforeach; ?>

</div>
<script
  src="https://code.jquery.com/jquery-2.2.4.js"
  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
  crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<div id="dateModal" class="modal" tabindex="-1" role="dialog">
  <form action="{{ URL::to('admin/api/update_restuarant_time') }}" method="post">
    @csrf
  <div class="modal-dialog modal-dialog-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Date</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" name="unit_id" value="<?= $unit_id ?>">
      <div class="modal-body">
        <label>From</label>
        <input type="text" name="from_time" class="form-control from" value="<?= $from_time ?>">
        <br />
        <label>To</label>
        <input type="text" name="to_time" class="form-control to" value="<?= $to_time ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
        
      </div>
    </div>
  </div>
  </form>
</div>
<script type="text/javascript">
	$(document).ready(function() {
    $(".editbox").click(function() {
      $("#dateModal").modal("show");
    });
    $(".enable_food_order").change(function() {
      var data = $(this).attr('data');
      var status = $(this).val();
       if (status=="yes") {
        $(this).val("no");
      }else {
        $(this).val("yes");
      }
       var url = "<?= URL::to('admin/api/change_food_orders') ?>";
            var formData = {
              '_token':'{{ csrf_token()}}',
              'unit_id': data,
              'status': status
            };
             $.post(url,  formData, function (resp,textStatus, jqXHR) {
                console.log(resp);
           });
    });
         $(".status").change(function() {
            var data = $(this).attr('data');
            var status = $(this).val();
            if (status=="active") {
            	$(this).val("inactive");
            }else {
				$(this).val("active");
            }

            var url = "<?= URL::to('admin/api/change_status') ?>";
            var formData = {
            	'_token':'{{ csrf_token()}}',
            	'item_id': data,
            	'status': status
            };
             $.post(url,  formData, function (resp,textStatus, jqXHR) {
                
      		 });
           
            
         });
         $('#search').keyup(function(){
  		    // Search text
 			var text = $(this).val();
 
  			// Hide all content class element
 			$('.mcontent').hide();

           // Search and show
           $('.mcontent .stitles:contains("'+text+'")').closest('.mcontent').show();
 
         });
	});
	$.expr[":"].contains = $.expr.createPseudo(function(arg) {
  return function( elem ) {
   return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
  };
});
</script>
    <script>
$(document).ready(function() {
  $('.from').timepicker({
    timeFormat: 'h:mm p',
    interval: 60,
    defaultTime: '<?= $from_time ?>',
    startTime: '<?= $from_time ?>',
    dynamic: false,
    dropdown: false,
    scrollbar: true
});
$('.to').timepicker({
  timeFormat: 'h:mm p',
  interval: 60,
  defaultTime: '<?= $to_time ?>',
  startTime:  '<?= $to_time ?>',
  dynamic: false,
  dropdown: false,
  scrollbar: true
});
});

</script>
<style type="text/css">
	body {
		margin: 0px;
		overflow-x: hidden;
	}
	.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.fcontent, .mcontent {
	display: contents;
}

/* The slider */
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
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
</body>
</html>