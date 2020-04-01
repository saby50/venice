@extends('multiauth::layouts.main') 


@section('title')
Units
@endsection


@section('content')
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Edit</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Units</h2>

			</div>
		</div>
		<div class="col-md-8 column">
			<div class="top-bar-chart">
				<div class="quick-report">
					<div class="quick-report-infos">

					</div>

				</div>

			</div><!-- Top Bar Chart -->
		</div>
	</div>
</div><!-- Top Bar Chart -->

<?php 
$prep_time = "";
$from_time = "";
$to_time = "";
$enable_food_order = "";
foreach ($data as $key => $value) {
  $unit_name = $value->unit_name;
  $unit_email = $value->unit_email;
  $unit_phone = $value->unit_phone;
  $floor_level = $value->floor_level;
  $unit_category_id = $value->unit_category_id;
  $order_food = $value->order_food;
  $tags = $value->tags;
  $price_for_two = $value->price_for_two;
  $suspended = $value->suspended;
  $prep_time = $value->prep_time;
  $from_time = $value->from_time;
  $to_time = $value->to_time;
  $enable_food_order = $value->enable_food_order;
}
$units = Helper::get_category($unit_category_id);

?>
<div class="panel-content">
  <form action="{{ URL::to('admin/units/update') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
          <div class="row">
            <div class="col-md-12">
          @if (session('status'))
                <div class="widget no-color">
                    <div class="notify orange-skin with-color">
                        <div class="notify-content">
                            <h3>Congratulation! {{ session('status') }}</h3>

                        <a title="" class="close">x</a>
                        </div>
                    </div>
                    </div>
                </div>
              @endif
              </div>
					<div class="row formarea">
              <div class="col-md-6">
               <label>Unit Name</label>
               <input type="text" class="form-control" name="unit_name" value="<?= $unit_name ?>" required>
              </div>
                
              <div class="col-md-6">
               <label>Unit Phone</label>
               <input type="number" class="form-control" name="unit_phone" autocomplete="off" value="<?= $unit_phone ?>"  required="">
              </div>
               <div class="col-md-6">
                    <label>From</label>

                      <input type="text" class="form-control from" name="from" value="" autocomplete="off" id="from" required="">
                    </div>
                    <div class="col-md-6">
                      <label>To</label>
                      <input type="text" class="form-control to" name="to" value="" id="to" autocomplete="off" required="">
                    </div>
              <div class="col-md-6">
           
              <label>Unit Email</label>
              <input type="text" class="form-control" name="unit_email" autocomplete="off" value="<?= $unit_email ?>" required="">
              </div>

             <div class="col-md-6">
              <input type="hidden" name="unit_id" value="<?= $id ?>">
              <label>Floor Level</label>
              <input type="text" class="form-control" name="floor_level" autocomplete="off" value="<?= $floor_level ?>" required="required">
              </div>
               <div class="col-md-6">
           
              <label>Categories</label>
              <select class="form-control" name="categories">
              	<?php foreach($categories as $key => $value): ?>
              		<?php if($units['unit_id']==$value->id): ?>
              		<option value="<?= $value->id ?>" selected><?= $value->unit_category_name ?></option>
              		<?php else: ?>
              			<option value="<?= $value->id ?>"><?= $value->unit_category_name ?></option>

              		<?php endif; ?>

              	<?php endforeach; ?>
              </select>
              </div>
              <div class="col-md-6">
               <label>Tax</label>
                 <select class="form-control" name="tax_id">

                      <?php foreach ($taxes as $key => $value): ?>
                        <option value="<?= $value->id ?>"><?= $value->tax_name ?> (<?= $value->tax_percent ?>%)</option>
                      <?php endforeach; ?>
                  </select>
              </div>
            <div class="col-md-6">
           
              <label>Suspended</label><br />
               <?php if($suspended=="yes"): ?>
                   <input type="radio" name="suspended" class="suspended" value="yes" checked> Yes &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="suspended" class="suspended" value="no"> No

                   <?php else: ?>
                     <input type="radio" name="suspended" class="suspended" value="yes"> Yes &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="suspended" class="suspended" value="no" checked> No

                   <?php endif; ?>
              </div>
            <div class="col-md-6">
           
              <label>Food Ordering</label><br />
               <?php if($order_food=="yes"): ?>
                   <input type="radio" name="order_food" class="order_food" value="yes" checked> Enable &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="order_food" class="order_food" value="no"> Disable

                   <?php else: ?>
                     <input type="radio" name="order_food" class="order_food" value="yes"> Enable &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="order_food" class="order_food" value="no" checked> Disable

                   <?php endif; ?>
              </div>
              <div class="col-md-12 food_menu_options" style="margin-top: 40px;">
                    <div class="col-md-6">
                <h5><strong>Upload Food Icon</strong></h5>
                <div id="fileuploader">Upload</div>

                
              </div>
              
               <div class="col-md-12">
                <label>Tags (Seperated by comma)</label>
                <input type="text" name="tags"  value="<?= $tags ?>" class="form-control">
                
              </div>
              <div class="col-md-12" style="margin-top: 10px;">
                <label>Prep Time</label>
                <input type="text" name="prep_time"  value="<?= $prep_time ?>" class="form-control">
                
              </div>
               <div class="col-md-12">
                 <br />
                <label>Price for 2</label>
                <input type="text" name="price_for_two"  value="<?= $price_for_two ?>" class="form-control">
                
              </div>
               <div class="col-md-12">
                 <br />
                <label>Enable Food Order</label><br />
                <?php if($enable_food_order=="yes"): ?>
                <input type="radio" name="enable_food_order" value="yes" checked="checked"> Enable &nbsp;&nbsp; <input type="radio" name="enable_food_order" value="no"> Disable
                <?php else: ?>
                  <input type="radio" name="enable_food_order" value="yes"> Enable &nbsp;&nbsp; <input type="radio" name="enable_food_order" value="no" checked="checked"> Disable 
                <?php endif; ?> 
              </div>
              </div>
              <div class="col-md-12">
               <br /> <br />
                <input type="submit" class="btn btn-primary" value="Submit">

              </div>
              
              
					</div>

				</div>
			</div>
	
	</div>
</form>
</div><!-- Panel Content -->
</div>

<link href="https://hayageek.github.io/jQuery-Upload-File/4.0.11/uploadfile.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var order_food = $(".order_food:checked").val();
    if (order_food=="yes") {
        $(".food_menu_options").show();
      }if (order_food=="no") {
        $(".food_menu_options").hide();
      }
    $(".order_food").change(function() {
      var order_food = $(this).val();
      if (order_food=="yes") {
        $(".food_menu_options").show();
      }else {
        $(".food_menu_options").hide();
      }
    });
    $("#fileuploader").uploadFile({
  url:"<?= URL::to('admin/units/upload_foodstore_app') ?>",
  maxFileCount:1,
  fileName:"myfile",
  formData: {"_token":"{{ csrf_token()}}", 'id': "<?= $id ?>"},
  acceptFiles:"image/*",
  showDelete: true,
  returnType: "json",
  showDownload:false,
  showPreview:true,
  previewHeight: "100px",
  previewWidth: "100px",
  onLoad:function(obj)
   {
    $.ajax({
        cache: false,
         url: "<?= URL::to('admin/units/load_foodstore_app/'.Request::segment(4)) ?>",
        dataType: "json",
        success: function(data)
        {
          for(var i=0;i<data.length;i++)
          {
            obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
          }
          }
    });
  },
  deleteCallback: function (data, pd) {
    for (var i = 0; i < data.length; i++) {
        $.post("<?= URL::to('admin/units/delete_foodstore_app/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"{{ csrf_token()}}"},
            function (resp,textStatus, jqXHR) {
                //Show Message
                alert("File Deleted");
            });
    }
    pd.statusbar.hide(); //You choice.

}
  
});
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
@endsection
