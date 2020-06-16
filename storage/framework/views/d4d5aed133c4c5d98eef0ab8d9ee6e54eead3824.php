 


<?php $__env->startSection('title'); ?>
User Checkins
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Checkin(s)</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-8">
					<h3>Checkin(s) - <?php 
                     if ($parameter=="todays") {
                     	echo date('d-m-Y');
                     }elseif ($parameter=="monthly") {
                     	echo date('M Y');
                     }elseif ($parameter=="lastmonth") {
                     	echo date('M Y', strtotime('-1 Month'));
                     }elseif ($parameter=="yesterday") {
                     	echo date('d-m-Y', strtotime('-1 Day'));
                     }

					?></h3>
				</div>
				
             <div class="col-md-4 column">
      <div class="top-bar-chart" style="text-align: right;">
      
      </div><!-- Top Bar Chart -->
    </div>     
	</div>
	
 
</div><!-- Top Bar Chart -->

<div class="panel-content">
	<div class="row">
	<?php if(session('status')): ?>
				<div class="widget no-color">
						<div class="alert alert-success">
								<div class="notify-content">
									 <?php echo e(session('status')); ?>!

								</div>
						</div>
						</div>
				</div>
			<?php endif; ?>
			</div>
	<div class="row">
	
	

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
					<div class="row">
                       <div class="col-md-4">
						<label>Filter by date: </label>
						<select name="filter" class="form-control type">
							<?php foreach($filters as $key => $value): ?>
								<?php if($parameter==$value->filter_value): ?>
								<option value="<?= $value->filter_value ?>" selected><?= $value->filter_name ?></option>
								<?php else: ?>
									<option value="<?= $value->filter_value ?>"><?= $value->filter_name ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					   </div>
					</div>
					<div class="row">
						<?php if(count($data)==0): ?>
							<h4>No Bookings Found</h4>
							<?php else: ?>
						<table class="table">
							<thead>
								<tr>
									<th>Personal Details</th>
									<th>Date</th>
									<th>Time</th>
									<th>Booked On</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($data as $key => $value): ?>
									<?php 
                              $userinfo = Helper::get_user_info($value->userid);
						 	?>
						 	<?php foreach($userinfo as $k => $v): ?>
								<tr>
									<td><?= $v->name ?><br /><?= $v->email ?><br /><?= $v->phone ?></td>
									<td><?= $value->date ?></td>
									<td><?= $value->time ?></td>
									<td><?= $value->created_at ?></td>
								</tr>
								<?php endforeach; ?>
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
<style type="text/css">
	.datearea {
		display: none;
	}
	table.table tr td {
		min-width: 170px !important;
	}
	.wrapper1, .wrapper2 {
  width: 100%;
  overflow-x: scroll;
  overflow-y:hidden;
}
.div1 {
  width:8000px;
  height: 20px;
}
</style>


<script type="text/javascript">
	$(document).ready(function() {
       $(".type").change(function() {
          var data = $(this).val();
          var url = "<?= URL::to('admin/slotbookings') ?>/"+data;
          window.location = url;
       });
	});
</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/reports/slotbooking.blade.php ENDPATH**/ ?>