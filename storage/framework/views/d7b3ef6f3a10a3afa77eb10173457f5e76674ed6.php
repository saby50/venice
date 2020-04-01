 


<?php $__env->startSection('title'); ?>
Units
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
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
<div class="panel-content">
  <form action="<?php echo e(URL::to('admin/units/add')); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
          <div class="row">
            <div class="col-md-12">
          <?php if(session('status')): ?>
                <div class="widget no-color">
                    <div class="notify orange-skin with-color">
                        <div class="notify-content">
                            <h3>Congratulation! <?php echo e(session('status')); ?></h3>

                        <a title="" class="close">x</a>
                        </div>
                    </div>
                    </div>
                </div>
              <?php endif; ?>
              </div>
					<div class="row formarea">

              <div class="col-md-6">
               <label>Unit Name</label>
               <input type="text" class="form-control" name="unit_name" value="" required>
              </div>
                
              <div class="col-md-6">
               <label>Unit Phone</label>
               <input type="number" class="form-control" name="unit_phone" autocomplete="off" value=""  required="">
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
              <input type="text" class="form-control" name="unit_email" autocomplete="off" value="" required="">
              </div>
              
                
             <div class="col-md-6">
           
              <label>Floor Level</label>
              <input type="text" class="form-control" name="floor_level" autocomplete="off" value="" required="required">
              </div>
               <div class="col-md-6">
           
              <label>Categories</label>
              <select class="form-control" name="categories">
              	<?php foreach($categories as $key => $value): ?>
              		<option value="<?= $value->id ?>" selected><?= $value->unit_category_name ?></option>

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
             <input type="radio" name="suspended" class="suspended" value="yes" checked> Yes &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="suspended" class="suspended" value="no"> No
              </div>
          <div class="col-md-6">   
          <label>Food Ordering</label><br />
                <input type="radio" name="order_food" class="order_food" value="yes"> Enable &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="order_food" value="no" class="order_food" checked="checked"> Disable
              </div>
               <div class="col-md-12 food_menu_options" style="margin-top: 40px;">
                    <div class="col-md-6">
                <h5><strong>Upload Food Icon</strong></h5>
                 <input type="file" name="foodicon" value="">

                
              </div>
              
               <div class="col-md-12">
                <label>Tags (Seperated by comma)</label>
                <input type="text" name="tags"  value="" class="form-control">
                
              </div>
               <div class="col-md-12">
                 <br />
                <label>Price for 2</label>
                <input type="text" name="price_for_two"  value="" class="form-control">
                
              </div>
             <div class="col-md-12">
                 <br />
                <label>Enable Food Order</label><br />
                <input type="radio" name="enable_food_order" value="yes"> Enable &nbsp;&nbsp; <input type="radio" name="enable_food_order" value="no" checked="checked"> Disable
                
              </div>
              </div>
              <div class="col-md-12">
               <br />
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
  
  });
</script>
    <script>
$(document).ready(function() {
  $('.from').timepicker({
    timeFormat: 'h:mm p',
    interval: 60,
    defaultTime: '11',
    startTime: '11:00',
    dynamic: false,
    dropdown: false,
    scrollbar: true
});
$('.to').timepicker({
  timeFormat: 'h:mm p',
  interval: 60,
  defaultTime: '22:30',
  startTime: '10:30',
  dynamic: false,
  dropdown: false,
  scrollbar: true
});
});

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/units/create.blade.php ENDPATH**/ ?>