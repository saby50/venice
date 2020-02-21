 


<?php $__env->startSection('title'); ?>
Holidays
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<?php 
 $holiday = "";
  $date = "";
foreach ($data as $key => $value) {
  $holiday = $value->holiday;
  $date = $value->date;
}
?>
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
				<h2>Holiday(s)</h2>

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
  <form action="<?php echo e(URL::to('admin/holidays/update')); ?>" method="post">
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
               <label>Holiday Name</label>
               <input type="text" class="form-control" name="holiday_name" value="<?= $holiday ?>"  required>
              </div>
              <div class="col-md-6">
                <label>Date</label>
                <input type="text" class="form-control" id="datepicker" name="date" autocomplete="off" value="<?= $date ?>"  required>
              </div>
              <input type="hidden" name="holiday_id" value="<?= $id ?>">

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

 var today, datepicker;
    today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
  

    $('#datepicker').datepicker({
         modal: true,
         header: true,
         footer: true,
       
         uiLibrary: 'bootstrap4',
         dateFormat: 'dd-mm-yy'
});
});

</script>
<script src="https://veniceindia.com/public/js/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/holidays/edit.blade.php ENDPATH**/ ?>