 


<?php $__env->startSection('title'); ?>
Food Card Revenue
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php 
 $gv_total = 0;
 $food_card_total = 0;
 $food_order_total = 0;
?>
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#" title="">Topup</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-8 column">
			<div class="heading-profile">
		

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
					<div class="row filterarea">
              <div class="col-md-4">
              <label>Filter  by Units</label><br />
              <select class="form-control filter_unit">
                <?php foreach($units as $key => $value): ?>
                  
           <?php if($unit_id==$value->id): ?>
              <option value="<?= $value->id ?>" selected><?= $value->unit_name ?></option>

                <?php else: ?>
                <option value="<?= $value->id ?>"><?= $value->unit_name ?></option>
            <?php endif; ?>

                    
            
                <?php endforeach; ?>
              </select>
          
            
             
            </div>
						<div class="col-md-4">
							<label>Filter  by days</label><br />
							<select class="form-control filter">
								<?php foreach($filters as $key => $value): ?>
									
           <?php if($datetype==$value->filter_value): ?>
              <option value="<?= $value->filter_value ?>" selected><?= $value->filter_name ?></option>

              	<?php else: ?>
                <option value="<?= $value->filter_value ?>"><?= $value->filter_name ?></option>
            <?php endif; ?>

										
            
								<?php endforeach; ?>
							</select>
          
            
             
						</div>
            <div class="col-md-4">
              <?php if($datetype=="daily"): ?>
              <label>Month and Year</label>
               <input type="text" name="custom" class="custom form-control" value="<?= $custom ?>">
            <?php endif; ?>
             <?php if($datetype=="monthly"): ?>
              <label>Year</label>
               <input type="text" name="custom" class="custom form-control" value="<?= $custom ?>">
            <?php endif; ?>
             <?php if($datetype=="day"): ?>
              <label>Date</label>
              <input type="text" name="custom" class="custom form-control" value="<?= date('d-m-Y') ?>">
            <?php endif; ?>
              
              
            </div>

						
						
						
					</div>

					<div class="row">
           
            <table class="table">
              <thead>
                <tr style="background: yellow;">
                  <th>Date</th>
                   <th>GV Pay (<i class="fa fa-rupee"></i>)</th>
                    <th>Food Card (<i class="fa fa-rupee"></i>)</th>
                     <th>Food Orders (<i class="fa fa-rupee"></i>)</th>
                </tr>
              </thead>
              <tbody>
                 <?php if($datetype=="daily"): ?>
                <?php
                list($m, $y) = explode("-", $custom);
                $c_month = date('m', mktime(0, 0, 0, $m, 10)); 
                $c_year = $y; 
                $no_day = cal_days_in_month(CAL_GREGORIAN, $c_month, $c_year);           
                for($i=1; $i<=$no_day; $i++): ?>
                <tr>
                  <td><?php $date = $c_year.'-'.$c_month.'-'.$i; $date2 = $i.'-'.$c_month.'-'.$c_year; echo $date2; ?></td>
                  <td><?php 
                  $gv_pay = Helper::get_unit_revenue_by_date($date, $unit_id,'gv_pocket',$datetype); 
                  echo $gv_pay;
                  $gv_total+= $gv_pay;
                  ?></td>
                  <td><?php $food_card =  Helper::get_unit_revenue_by_date($date, $unit_id,'food_card',$datetype);
                     echo $food_card;
                      $food_card_total+= $food_card;
                   ?></td>
                  <td><?php $foodorder = Helper::get_unit_revenue_by_date($date, $unit_id,'foodorder',$datetype);
                  echo $foodorder; 

                  $food_order_total+= $foodorder;?></td>
                </tr>
              <?php endfor; ?>
               <?php endif; ?>

                <?php if($datetype=="monthly"): ?>
                <?php
                        
                for ($i=1; $i<=12; $i++): ?>
                <tr>
                  <td><?php  $date = date('m', mktime(0,0,0,$i)).' '.$custom; $date2 = date('F', mktime(0,0,0,$i)).' '.$custom; echo $date2; ?></td>
                  <td><?php $gv_pay =  Helper::get_unit_revenue_by_date($date, $unit_id,'gv_pocket',$datetype);
                    echo $gv_pay;
                     $gv_total+= $gv_pay;
                   ?></td>
                  <td><?php $food_card =   Helper::get_unit_revenue_by_date($date, $unit_id,'food_card',$datetype);
                    echo $food_card;
                    $food_card_total+= $food_card;
                   ?></td>
                  <td><?php $foodorder = Helper::get_unit_revenue_by_date($date, $unit_id,'foodorder',$datetype);
                      echo $foodorder;
                      $food_order_total+= $foodorder;
                   ?></td>
                </tr>
              <?php endfor; ?>
               <?php endif; ?>
               <?php if($datetype=="day"): ?>
               
                
                <tr>
                  <td><?php $date = date('Y-m-d');  $date2 = date('d-m-Y'); echo $date2; ?></td>
                  <td><?php $gv_pay = Helper::get_unit_revenue_by_date($date, $unit_id,'gv_pocket',$datetype);
                  echo $gv_pay;

                  $gv_total+= $gv_pay; ?></td>
                  <td><?php $food_card = Helper::get_unit_revenue_by_date($date, $unit_id,'food_card',$datetype); echo $food_card;
                  $food_card_total+= $food_card; ?></td>
                  <td><?php $foodorder = Helper::get_unit_revenue_by_date($date, $unit_id,'foodorder',$datetype); echo $foodorder;
                  $food_order_total+= $foodorder; ?></td>
                </tr>
             
               <?php endif; ?>
               <tr style="background: yellow;">
                <td><strong>Total</strong></td>
                <td><i class="fa fa-rupee"></i> <?= $gv_total ?></td>
                <td><i class="fa fa-rupee"></i> <?= $food_card_total ?></td>
                <td><i class="fa fa-rupee"></i> <?= $food_order_total ?></td>
               </tr>
              </tbody>
              
            </table>
         

						
	</div>
	</div>
	</div>
	</div>
	</div>
</div><!-- Panel Content -->
</div>

 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style type="text/css">
  	.filterarea {
  		position: relative;
  		top: -40px;
  	}
  	.refundbtn {
  		cursor: pointer;
  	}
  	.refund {
  		color: orange;
  	}
  	.choosedate {
  		
  	}
  	@media  only screen and (max-width: 600px) {
 .filterarea {
  		position: relative;
  		top: -20px;
  	}
}
  </style>
 <?php if($datetype=="daily"): ?>
       <script>
  $( function() {
    var dateFormat = "mm-yy",
      from = $( ".custom" )
        .datepicker({
       changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: dateFormat,
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            var newdate = $(".custom").val();
            var datetype = "<?= $datetype ?>";
            var unit_id = "<?= $unit_id ?>";
            window.location = "<?= URL::to('admin/units/reports/') ?>/"+datetype + "/"+unit_id+"/"+newdate;
        }
        });
        });
  </script>
  <style type="text/css">
    .ui-datepicker-calendar {
    display: none;
    }
  </style>
<?php endif; ?>
 <?php if($datetype=="monthly"): ?>
       <script>
  $( function() {
    var dateFormat = "yy",
      from = $( ".custom" )
        .datepicker({
       changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: dateFormat,
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            var newdate = $(".custom").val();
            var datetype = "<?= $datetype ?>";
            var unit_id = "<?= $unit_id ?>";
            window.location = "<?= URL::to('admin/units/reports/') ?>/"+datetype + "/"+unit_id+"/"+newdate;
        }
        });
});
  </script>
  <style type="text/css">
    .ui-datepicker-calendar {
    display: none;
    }
  </style>
<?php endif; ?>
 <?php if($datetype=="day"): ?>
       <script>
  $( function() {
    var dateFormat = "dd-mm-yy",
      from = $( ".custom" )
        .datepicker({
       changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: dateFormat,
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            var newdate = $(".custom").val();
            var datetype = "<?= $datetype ?>";
            var unit_id = "<?= $unit_id ?>";
            window.location = "<?= URL::to('admin/units/reports/') ?>/"+datetype + "/"+unit_id+"/"+newdate;
        }
        });

 
 });
  </script>
<?php endif; ?>
  <script type="text/javascript">
     $( function() {
function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }

    $(".filter").change(function() {
         var data = $(this).val();
        var unit_id = "<?= $unit_id ?>";
        var custom = "";
        if (data=="daily") {
          custom = "<?= date('m-Y') ?>";
        }else if(data=="monthly") {
          custom = "<?= date('Y') ?>";
        }else {
          custom = "<?= date('d-m-Y') ?>";
        }
        window.location = "<?= URL::to('admin/units/reports/') ?>/"+data + "/"+unit_id+"/"+custom;
    });
        
     $(".filter_unit").change(function() {
        var data = $(this).val();
        var datetype = "<?= $datetype ?>";
        var custom = "<?= $custom ?>";
        window.location = "<?= URL::to('admin/units/reports/') ?>/"+datetype + "/"+data+"/"+custom;
    });
  
 
    
  });


</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/reports/unit_revenue.blade.php ENDPATH**/ ?>