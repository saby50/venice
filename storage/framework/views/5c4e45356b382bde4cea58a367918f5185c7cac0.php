 


<?php $__env->startSection('title'); ?>
Gondoliers
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="main-content style2"> 
<div class="breadcrumbs">
    <ul>
        <li><a href="#/" title="">Home</a></li>
        <li><a href="#/pages/portfolio" title="">Gondoliers</a></li>
    </ul>
</div>

<div class="heading-sec">
    <div class="row">
        <div class="col-md-2 column">
            <div class="heading-profile">
                <h2>Gondolier Report</h2>

            </div>
        </div>
       
        <div class="col-md-9 column">

            <div class="top-bar-chart">
                <div class="quick-report">
                    <div class="quick-report-infos">

                    </div>
                    <span class="bar2" style="display: none;"><a href="<?php echo e(URL::to('admin/gondolier/create')); ?>"><button class="btn btn-primary">Create</button></a></span>
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
                    <div class="row" style="margin-bottom: 40px;">
                        <div class="col-md-4">
                            <label>Filter</label>
                        <select class="form-control servicefilter">
                            <?php foreach($filters as $key => $value): ?>
                                <?php if($value->filter_value != "all"): ?>
                                 <?php if($type2==$value->filter_value || $type2 != "all" && $type2 !="todays" && $type2 != "yesterday" && $type2 != "monthly" && $type2 != "lastmonth"): ?>
                                <option value="<?= $value->filter_value ?>" selected><?= $value->filter_name ?></option>

                                <?php else: ?>
                                <option value="<?= $value->filter_value ?>"><?= $value->filter_name ?></option>    
                            <?php endif; ?>
                           <?php endif; ?>
                            <?php endforeach; ?>
                            
                        </select>
                        </div>
                          <?php if ($type2 != "all" && $type2 !="todays" && $type2 != "yesterday" && $type2 != "monthly" && $type2 != "lastmonth"): ?>
                            <?php 
                               list($from, $to) = explode('_', $type2);
                            ?>
                        <div class="col-md-4 date_area">
                                <div class="col-md-6 datearea" style="margin-top: 20px;margin-bottom: 20px;">
                 <input type="text" name="fromdate" placeholder="From Date" id="from" value="<?= $from ?>" class="form-control" autocomplete="off">
             </div>
             <div class="col-md-6 datearea" style="margin-top: 20px;margin-bottom: 20px;">
                <input type="text" name="todate" placeholder="To Date" id="to" value="<?= $to ?>" class="form-control to" autocomplete="off">
             </div>
                            
                        </div>
                        <?php else: ?>
                             <div class="col-md-4 date_area" style="display: none;">
                                <div class="col-md-6 datearea" style="margin-top: 20px;margin-bottom: 20px;">
                 <input type="text" name="fromdate" placeholder="From Date" id="from" class="form-control" autocomplete="off">
             </div>
             <div class="col-md-6 datearea" style="margin-top: 20px;margin-bottom: 20px;">
                <input type="text" name="todate" placeholder="To Date" id="to" class="form-control to" autocomplete="off">
             </div>
                            
                        </div>
                    <?php endif; ?>
                       
                        
                    </div>

                    <div class="row">
                    	<table class="table">
                    		<head>
                    			
                    			<tr>
                    				<th style="background: #000;color:#FFF;">Dates</th>
                    				<?php foreach($data as $key => $value): ?>
                    				<th style="background: #000;color:#FFF;"><?= $value->gondolier_name ?></th>
                    				<?php endforeach; ?>
                    			</tr>
                    			
                    		</head>
                    		<tbody>
                    			<?php foreach($daterange as $k => $v): ?>
                    			<tr>
                    				<td><?= $v ?></td>
                    				<?php foreach($data as $key => $value): ?>
                    				<td><?= Helper::check_gondolier_ride_count_date($value->id,$v) ?></td>
                    				<?php endforeach; ?>
                    			</tr>
                    		<?php endforeach; ?>
                            <tr>
                                    <th style="background: #000;color:#FFF;">Total</th>
                                    <?php foreach($data as $key => $value): ?>
                                    <th style="background: #000;color:#FFF;"><?= Helper::check_gondolier_total($value->id,$type2); ?></th>
                                    <?php endforeach; ?>
                                </tr>

                    		</tbody>
                    	</table>

                       



                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- Panel Content -->
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".servicefilter").change(function() {
        var data = $('.servicefilter').find(":selected").val(); 
        if (data != "custom") {
            var url = "<?= URL::to('admin/gondolier/reports') ?>/"+data;
        window.location = url; 
    }else {
        $(".date_area").css('display','block');
    }
       
        });
         $(".to").on("change", function(e) {
           var from = $("#from").val();
           var to = $("#to").val();
           var data = from+"_"+to;
           var datatype = "<?= $type2 ?>"
           var url = "<?= URL::to('admin/gondolier/reports') ?>/"+data;
           window.location = url;
         });

    });
    $( function() {
    var dateFormat = "yy-mm-dd",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 2,
          dateFormat: 'yy-mm-dd'
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        dateFormat: 'yy-mm-dd'
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
  
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  });

    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/gondolier/reports.blade.php ENDPATH**/ ?>