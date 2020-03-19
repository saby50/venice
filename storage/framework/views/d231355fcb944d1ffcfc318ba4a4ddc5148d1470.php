 


<?php $__env->startSection('title'); ?>
Bookings
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php 
$user_type = Auth::user()->user_type;
$serviceids = "";

?>
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Event Booking(s)</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-6 column">
			<div class="heading-profile">
				<h2>Event Booking(s)</h2>

			</div>
		</div>
		<div class="col-md-6 column">
			<div class="top-bar-chart" style="text-align: right;">
			  <a href="#" style="color: #000;" class="refresh-content" title="Refresh"><i class="fa fa-refresh fa-2x" aria-hidden="true"></i></a>
			</div><!-- Top Bar Chart -->
		</div>
	</div>
</div><!-- Top Bar Chart -->

<div class="panel-content" ng-app="myApp" ng-controller="myCtrl">
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
      <?php if(session('error')): ?>
        <div class="widget no-color">
            <div class="alert alert-danger">
                <div class="notify-content">
                   <?php echo e(session('error')); ?>!

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
                <ul class="nav nav-tabs">
    <li class=""><a  href="<?php echo e(URL::to('admin/bookings/today')); ?>">Today's Arrival</a></li>
    <li><a  href="<?php echo e(URL::to('admin/bookings/s/todays/all')); ?>">All Bookings</a></li>
     <?php if(Auth::user()->user_type=="superadmin" || Auth::user()->user_type=="analyst"): ?>
    <li  class="active"><a  href="<?php echo e(URL::to('admin/events_bookings')); ?>">Events</a></li>

  <?php endif; ?>

  </ul>
            
          </div>
	
					<div class="row">
						
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
     <?php if (count($data) != 0): ?>
       <div class="row" style="margin-top: 20px;margin-bottom: 20px;margin-left:auto;margin-right: auto;">
          <div class="col-md-3">
            <label>Filter by event</label>
            <select class="filter form-control" name="filter">
               <option value="all">All</option>
              <?php foreach($events as $key => $value): ?>
                <?php if($value->id==$filter): ?>
                <option value="<?= $value->id ?>" selected><?= $value->event_name ?></option>
                <?php else: ?>
                 <option value="<?= $value->id ?>"><?= $value->event_name ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-1" style="margin-top: 20px;">
            <button class="btn btn-success">Export</button>
          </div>
          <div class="col-md-6">
            
          </div>
        <div class="col-md-2">
          <input type="text" placeholder="Search.." class="form-control allInput">
        </div>
        
        
      </div>
             <table class="table allTable" id="example">
          <thead>
            <tr>
              
              <th>Details</th>
              <th>Booking Details</th>
              <th>Price</th>
              
             
              
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $key => $value): ?>
              <tr>
                <td><strong>Name:</strong> <?= $value->name ?><br /><strong>Email:</strong> <?= $value->email ?><br /><strong>Phone:</strong> <?= $value->phone ?>
                  
                  <br /><strong>Booked on:</strong> <?php 
            
               echo date('d M, Y h:i A',strtotime($value->created_at));
               echo '<br />';
                $payment_method = $value->payment_method;
            if ( $payment_method=="instamojo") {
             echo "EC(Instamojo)";
            }else if( $payment_method=="cash") {
              echo "POS(Cash)";

            }else if( $payment_method=="card") {
              echo "POS(CARD)";

            } else if( $payment_method=="paytm_qr") {
              echo "POS(Paytm QR)";

            }   

             
                 
             ?> </td>
                <td><strong><?= $value->event_name ?></strong><br /><strong>Quantity: </strong><?= $value->quantity ?> <br /><strong>Event Date: </strong><?= $value->event_date ?><br /><strong>Event Time: </strong><?= $value->event_time ?></td>
                <td><i class="fa fa-inr"></i> <?= $value->amount ?></td>
               
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        
      <?php else: ?>
              <h4 style="margin-top: 40px;">  No Bookings</h4>
            <?php endif; ?>
    </div>
    
   
    <div id="menu3" class="tab-pane fade">
      <h3>Menu 3</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>

					



					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- Panel Content -->
</div>

<script type="text/javascript" src="<?php echo e(asset('js/jquery.table2excel.js')); ?>"></script>
<script type="text/javascript" src="https://staging.striker.academy/crm/public/js/dirPagination.js"></script>
    <script>
$(document).ready(function(){
  $(".todayInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".todayTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $(".todaySelect").on("change", function() {
    var value = $(this).val().toLowerCase();
   $(".todayTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $(".allInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".allTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $(".allSelect").on("change", function() {
    var value = $(this).val().toLowerCase();
   $(".allTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $(".historyInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".historyTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $(".historySelect").on("change", function() {
    var value = $(this).val().toLowerCase();
   $(".historyTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  //
   $(".todayInput2").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".todayTable2 tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $(".todaySelect2").on("change", function() {
    var value = $(this).val().toLowerCase();
   $(".todayTable2 tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $(".allInput2").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".allTable2 tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $(".allSelect2").on("change", function() {
    var value = $(this).val().toLowerCase();
   $(".allTable2 tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $(".historyInput2").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".historyTable2 tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $(".historySelect2").on("change", function() {
    var value = $(this).val().toLowerCase();
   $(".historyTable2 tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
    $(".refresh-content").click(function() {
           location.reload(true);
     });

    $(".filter").change(function() {
        var data = $('.filter').find(":selected").val();
       
       
       var url = "<?= URL::to('admin/events_bookings') ?>/"+data;
    
    window.location = url;
    });
});
</script>
<style type="text/css">
  table tr th, table tr td {
    border-bottom: solid 1px #ff7d01 !important
  }
  .bluecode {
    color: #1c94dc;
  }
</style>
<script type="text/javascript">
$("button.btn-success").click(function(){
  $("#example").table2excel({
    // exclude CSS class
    exclude: ".noExl",
    name: "Worksheet Name",
    filename: "event", //do not include extension
    fileext: ".xls" // file extension
  }); 
});
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/events/bookings.blade.php ENDPATH**/ ?>