 


<?php $__env->startSection('title'); ?>
Roles
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Create</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Roles</h2>

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
  <form action="<?php echo e(URL::to('admin/manage_users/add')); ?>" method="post">
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
               <label> Name</label>
               <input type="text" class="form-control" name="name"  required>
              </div>
                 <div class="col-md-6">
                    <label>Email</label>
                      <input type="text" class="form-control" name="email"  required>
                    </div>

              <div class="col-md-6">
               <label>Phone</label>
               <input type="text" class="form-control" name="phone" value="" required>
              </div>
               <div class="col-md-6">
               <label>Password</label>
               <input type="text" class="form-control" name="pin" value="" required>
              </div>
               <div class="col-md-12" style="margin-bottom: 20px;">
               <label>Role</label>
               <select class="form-control roles" name="role">
                <?php foreach($roles as $key => $value): ?>
                 <option value="<?= $value->alias ?>"><?= $value->name ?></option>
               <?php endforeach; ?>
               </select>
              </div>
             <div class="col-md-12">
              <br /><strong>(Applicable for Service Manager)</strong><br />
                <hr />

             </div>
             
             <?php foreach ($categories as $key => $value): ?>
                    
                  <div class="col-md-12 catop" id="categories" style="padding-left:0px;padding-right:0px;"> <div class="col-md-4 margin-top" style="padding-left:6px;padding-right:6px;">
                    <label>Category</label><br />
                     <?php 
                      list($category_name, $category_id) = explode('_', $key); 
                      ?>
                        <input type="checkbox" name="category_id[]" value="<?= $category_id ?>"> <?= $category_name ?>
                       
                    </div>
                    <div class="col-md-4 margin-top" style="padding-left: 40px;padding-top: 5px;">
                    <label>Services</label><br />
                    <?php foreach($value as $k => $v): ?>
                      <?php 
                          $option_id = $v->option_id;
                          if ($option_id=="") {
                            $option_id = "0";
                          }
                      ?>
                     <div class="col-md-6"> <input type="checkbox" name="services[]" value="<?= $v->service_id."_".$option_id ?>"> <?= $v->service_name ?>
                      <?php if($v->option_name!=""): ?>
                      (<?= $v->option_name ?>)
                      <?php endif; ?></div>
                     
                      <?php endforeach; ?>
                 
                    </div></div>
                    <?php endforeach; ?>
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
<script type="text/javascript">
  $(document).ready(function() {
    $('input[type=submit]').click(function() {
      var roles = $('.roles').find('option:selected').val();
      var checkboxlength = $('#categories input[type=checkbox]:checked').length;
      if (roles=="manager") {
         if (checkboxlength==0) {
        alert('Please select atleast one category!');
        return false;

      }else {
        return true;
      }
      }
     
    });

  });
</script>
<script>
$(document).ready(function() {
  $('.from').timepicker({
    timeFormat: 'h:mm p',
    interval: 60,
    defaultTime: '8',
    startTime: '8:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});
$('.to').timepicker({
  timeFormat: 'h:mm p',
  interval: 60,
  defaultTime: '16',
  startTime: '4:00',
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

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/managers/create.blade.php ENDPATH**/ ?>