 


<?php $__env->startSection('title'); ?>
Categories
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
				<h2>Categories</h2>

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
foreach ($data as $key => $value) {
  $category_name = $value->category_name;
  $fromtime = $value->fromtime;
  $totime = $value->totime;
  $category_id = $value->id;
  $venue_id = $value->venue_id;

}
?>

<div class="panel-content">
  <form action="<?php echo e(URL::to('admin/categories/update')); ?>" method="post">
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
               <label>Category Name</label>
               <input type="text" class="form-control" name="category_name" value="<?= $category_name ?>" required>
              </div>
                <div class="col-md-6">
                    <label>Venue</label>
                       <select class="form-control" name="venue_id">

                      <?php foreach ($venue as $key => $value): ?>
                        <?php if($venue_id==$value->id): ?>
                        <option value="<?= $value->id ?>" checked><?= $value->location_name ?></option>
                        <?php else: ?>
                          <option value="<?= $value->id ?>"><?= $value->location_name ?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                  </select>
                    </div>
              <div class="col-md-6">
               <label>From</label>
               <input type="text" class="form-control from" name="fromtime" value="" autocomplete="off" id="from" value="<?= $fromtime ?>"  required="">
              </div>
              <div class="col-md-6">
                <input type="hidden" name="category_id" value="<?= $category_id ?>">
              <label>To</label>
              <input type="text" class="form-control to" name="totime" value="" id="to" autocomplete="off" value="<?= $totime ?>" required="">
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

          <script>
$(document).ready(function() {
  $('.from').timepicker({
    timeFormat: 'h:mm p',
    interval: 60,
    defaultTime: '<?= $fromtime ?>',
    startTime: '<?= $fromtime ?>',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});
$('.to').timepicker({
  timeFormat: 'h:mm p',
  interval: 60,
  defaultTime: '<?= $totime ?>',
  startTime: '<?= $totime ?>',
  dynamic: false,
  dropdown: true,
  scrollbar: true
});
});

</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
   <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/categories/edit.blade.php ENDPATH**/ ?>