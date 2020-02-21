@extends('multiauth::layouts.main') 


@section('title')
Reports
@endsection

@section('content')
<?php 
$_data = array();
$famount = 0;
?>
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Report(s)</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-8">
					<h3>Report(s)  <?php 

				if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
					 list($from,$to) = explode('_', $date_type);
              echo " - ".date('d-m-Y',strtotime($from))." - ".date('d-m-Y',strtotime($to));
				}
             
                               
              ?>, Transactions: <?php

              if ($datatype=="transaction") {
              	echo count($data);
              }else {
              	echo count($daterange);
              }

               
                ?>, Grand Total: <span class="grandtotal"></span></h3>
				</div>
				
             <div class="col-md-4 column">
      <div class="top-bar-chart" style="text-align: right;">
        <a href="#" onclick="exportF(this)" style="color: #000;" class="refresh-content" title="Refresh"><button class="btn btn-primary">Download Reports</button></a>
      </div><!-- Top Bar Chart -->
    </div>     
	</div>
	
 
</div><!-- Top Bar Chart -->

<div class="panel-content">
	<div class="row">
	@if (session('status'))
				<div class="widget no-color">
						<div class="alert alert-success">
								<div class="notify-content">
									 {{ session('status') }}!

								</div>
						</div>
						</div>
				</div>
			@endif
			</div>
	<div class="row">
	
	

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">

					<div class="row">
						<div class="col-md-4">
							<label>Filter by Type: </label>
							<select name="filter" class="form-control type">
							<?php if($datatype=="transaction"): ?>
								<option value="transaction" selected="selected">Transaction Wise</option>
								<option value="activity">Activity Wise</option>
							<?php else: ?>
								<option value="transaction">Transaction Wise</option>
								<option value="activity"  selected="selected">Activity Wise</option>

							<?php endif; ?>								
								
							</select>
							
						</div>
						<div class="col-md-4">
							<label>Filter By Date: </label>
							<select name="filter" class="form-control dtype">
								<?php if($datatype=="transaction"): ?>
									 <?php foreach($filters as $key => $value): ?>
              <?php if($date_type==$value->filter_value || $date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth"): ?>
              <option value="<?= $value->filter_value ?>" selected><?= $value->filter_name ?></option>

              <?php else: ?>
                <option value="<?= $value->filter_value ?>"><?= $value->filter_name ?></option>
            <?php endif; ?>
             <?php endforeach; ?>  

						<?php else: ?>
							<?php if($date_type=="all"): ?>
								<option value="all"  selected="selected">All</option>
								<option value="choose">Choose</option>
							<?php else: ?>
								<option value="all">All</option>
								<option value="choose"  selected="selected">Choose Dates</option>

							<?php endif; ?>	

								<?php endif; ?>
							 
							</select><br />
              <?php if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth"): ?>
              	
              	<div class="col-md-6" style="margin-top: 20px;margin-bottom: 20px;">
                 <input type="text" name="fromdate" placeholder="From Date" id="from" class="form-control" value="<?= $from ?>" autocomplete="off">
             </div>
             <div class="col-md-6" style="margin-top: 20px;margin-bottom: 20px;">
                <input type="text" name="todate" placeholder="To Date" id="to" class="form-control to" value="<?= $to ?>" autocomplete="off">
             </div>

              <?php else: ?>
              	<div class="col-md-6 datearea" style="margin-top: 20px;margin-bottom: 20px;">
                 <input type="text" name="fromdate" placeholder="From Date" id="from" class="form-control" autocomplete="off">
             </div>
             <div class="col-md-6 datearea" style="margin-top: 20px;margin-bottom: 20px;">
                <input type="text" name="todate" placeholder="To Date" id="to" class="form-control to" autocomplete="off">
             </div>
              <?php endif; ?>
							
				
           	 
			</div>						
		  </div>

	<div class="wrapper1">
  <div class="div1"></div>
</div>
					<div class="row" id="double-scroll" style="margin-top: 40px;width: 100%;overflow-x: scroll;">

					<?php if($datatype=="transaction"): ?>
						
						<!-- Transaction Wise -->
						<table class="table display" id="example">
							<thead>

							<tr>
								
								<?php 
									 $color = Helper::rand_color();
									?>
								<td style="background: <?= $color; ?>;color:#FFF;">Customer Details</td>
								
								<?php foreach($services as $key => $value): ?>
									<?php 
                                      $color = Helper::rand_color();
							    	?>
									<td style="background: <?= $color; ?>;color:#FFF;"><?= $value->service_name ?> Qty</td>
								<td  style="background: <?= $color; ?>;color:#FFF;"><?= $value->service_name ?> Rev</td>
							    <?php endforeach; ?>
							    <?php foreach($packs as $key => $value): ?>
							    	<?php 
                                      $color = Helper::rand_color();
							    	?>
							    <td style="background: <?= $color; ?>;color:#FFF;"><?= $value->pack_name ?> Qty</td>
								<td style="background: <?= $color; ?>;color:#FFF;"><?= $value->pack_name ?> Rev</td>
							    <?php endforeach; ?>
							     <?php foreach($events as $key => $value): ?>
							     	<?php 
                                      $color = Helper::rand_color();
							    	?>
							    <td style="background: <?= $color; ?>;color:#FFF;"><?= $value->event_name ?> Qty</td>
								<td style="background: <?= $color; ?>;color:#FFF;"><?= $value->event_name ?> Rev</td>
							    <?php endforeach; ?>
							    <?php 
                                      $color = Helper::rand_color();
							    	?>
							    <td style="background: <?= $color; ?>;color:#FFF;">GV Pay Qty</td>
							    <td style="background: <?= $color; ?>;color:#FFF;">GV Pay Rev</td>
							</tr>
							 </thead>

                               <?php foreach($paymentcat as $t => $g): ?>
                               	<?php if($g->filter_name != "FOC"): ?>
							  <tr style="background: #000;color: #FFF;">
							    	<td>
							    		<strong><?= $g->filter_name ?></strong>
							    	</td>
							    	<?php foreach($services as $k => $v): ?>
							    		<?php
								    	if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
								    		list($from, $to) = explode('_', $date_type);
								    	  $get_price = Helper::get_reports_service_total($v->id,$from, $to,$g->filter_value);
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	  
								    	   
								    	}elseif($date_type=="todays") {
								    		 $get_price = Helper::get_reports_service_total($v->id,'todays', 'todays',$g->filter_value);
								    	  $amount = number_format($get_price['amount']);
								    	  $quantity = $get_price['quantity'];
								    	   
								    		
								    	}elseif($date_type=="yesterday") {
								    		 $get_price = Helper::get_reports_service_total($v->id,'yesterday', 'yesterday',$g->filter_value);
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	   
								    		
								    	}elseif($date_type=="lastmonth") {
								    		 $get_price = Helper::get_reports_service_total($v->id,'lastmonth', 'lastmonth',$g->filter_value);
								    	  $amount = number_format($get_price['amount']);
								    	  $quantity = $get_price['quantity'];
								    	   
								    		
								    	}elseif($date_type=="monthly") {
								    		 $get_price = Helper::get_reports_service_total($v->id,'monthly', 'monthly',$g->filter_value);
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    
								    		
								    	}else {
								    		 $get_price = Helper::get_reports_service_total($v->id,'all', 'all',$g->filter_value);
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    
								    		
								    	}
								    	 
								    	  ?>
							    		<td><?= $quantity ?></td>
								    	<td><i class="fa fa-rupee"></i> <?= $amount ?></td>
                                   
							    	<?php endforeach; ?>
							    	<?php foreach($packs as $k => $v): ?>
							    		<?php
								    	if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
								    		list($from, $to) = explode('_', $date_type);
								    	  $get_price = Helper::get_reports_packs_total($v->id,$from, $to,$g->filter_value);
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	  
								    	   
								    	}elseif($date_type=="todays") {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'todays', 'todays',$g->filter_value);
								    	  $amount = number_format($get_price['amount']);
								    	  $quantity = $get_price['quantity'];
								    	    
								    		
								    	}elseif($date_type=="yesterday") {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'yesterday', 'yesterday',$g->filter_value);
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	   
								    		
								    	}elseif($date_type=="lastmonth") {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'lastmonth', 'lastmonth',$g->filter_value);
								    	  $amount = number_format($get_price['amount']);
								    	  $quantity = $get_price['quantity'];
								    	   
								    		
								    	}elseif($date_type=="monthly") {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'monthly', 'monthly',$g->filter_value);
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    
								    		
								    	}else {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'all', 'all',$g->filter_value);
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    
								    		
								    	}
								    	 
								    	  ?>
							    		<td><?= $quantity ?></td>
								    	<td><i class="fa fa-rupee"></i> <?= $amount ?></td>

							    	<?php endforeach; ?>
							    	<?php foreach($events as $k => $v): ?>
							    		<td>0</td>
								    	<td><i class="fa fa-rupee"></i> 0</td>

							    	<?php endforeach; ?>
							    	<td>0</td>
							    	<td><i class="fa fa-rupee"></i> 0</td>
							    </tr>

							     <?php endif; ?>
							     <?php endforeach; ?>
                            

	                          <tr style="background: #000;color: #FFF;">
							    	<td>
							    		<strong>Total</strong>
							    	</td>
							    	<?php foreach($services as $k => $v): ?>
							    		<?php
								    	if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
								    		list($from, $to) = explode('_', $date_type);
								    	  $get_price = Helper::get_reports_service_total($v->id,$from, $to,'all');
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	  
								    	   
								    	}elseif($date_type=="todays") {
								    		 $get_price = Helper::get_reports_service_total($v->id,'todays', 'todays','all');
								    	  $amount = number_format($get_price['amount']);
								    	  $quantity = $get_price['quantity'];
								    	   
								    		
								    	}elseif($date_type=="yesterday") {
								    		 $get_price = Helper::get_reports_service_total($v->id,'yesterday', 'yesterday','all');
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	   
								    		
								    	}elseif($date_type=="lastmonth") {
								    		 $get_price = Helper::get_reports_service_total($v->id,'lastmonth', 'lastmonth','all');
								    	  $amount = number_format($get_price['amount']);
								    	  $quantity = $get_price['quantity'];
								    	   
								    		
								    	}elseif($date_type=="monthly") {
								    		 $get_price = Helper::get_reports_service_total($v->id,'monthly', 'monthly','all');
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    
								    		
								    	}else {
								    		 $get_price = Helper::get_reports_service_total($v->id,'all', 'all','all');
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    
								    		
								    	}
								    	 
								    	  ?>
							    		<td><?= $quantity ?></td>
								    	<td><i class="fa fa-rupee"></i> <?= $amount ?></td>

							    	<?php endforeach; ?>
							    	<?php foreach($packs as $k => $v): ?>
							    		<?php
								    	if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
								    		list($from, $to) = explode('_', $date_type);
								    	  $get_price = Helper::get_reports_packs_total($v->id,$from, $to,'all');
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	  
								    	   
								    	}elseif($date_type=="todays") {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'todays', 'todays','all');
								    	  $amount = number_format($get_price['amount']);
								    	  $quantity = $get_price['quantity'];
								    	    
								    		
								    	}elseif($date_type=="yesterday") {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'yesterday', 'yesterday','all');
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	   
								    		
								    	}elseif($date_type=="lastmonth") {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'lastmonth', 'lastmonth','all');
								    	  $amount = number_format($get_price['amount']);
								    	  $quantity = $get_price['quantity'];
								    	   
								    		
								    	}elseif($date_type=="monthly") {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'monthly', 'monthly','all');
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    
								    		
								    	}else {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'all', 'all','all');
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    
								    		
								    	}
								    	 
								    	  ?>
							    		<td><?= $quantity ?></td>
								    	<td><i class="fa fa-rupee"></i> <?= $amount ?></td>

							    	<?php endforeach; ?>
							    	<?php foreach($events as $k => $v): ?>
							    		<td>0</td>
								    	<td><i class="fa fa-rupee"></i> 0</td>

							    	<?php endforeach; ?>
							    		<td>0</td>
							    	<td><i class="fa fa-rupee"></i> 0</td>
							    </tr>
<tbody>
							
							
							      <?php 
           usort($data, function($a, $b) {
                return $a[0]['created_at'] < $b[0]['created_at'];
           });

 
            ?>
								<?php foreach($data as $key => $value): ?>
								<tr>
								  
							
								    <td><?= $value[0]['order_id'] ?><br /><?= $value[0]['name'] ?><br /><?= $value[0]['email'] ?><br /><?= $value[0]['phone'] ?><br /><?= date('d-m-Y H:i A',strtotime($value[0]['created_at'])) ?></td>
								    
                                  
								    <?php 
                                       $serviceids = "";
                                       $prices= "";
								    ?>
								    <?php foreach($services as $k => $v): ?>

								   <?php  foreach ($value['services'] as $j => $m):?>

								   	<?php 

								   		$serviceids .= $m['service_id']."_".$m['type'].",";
								   		$prices .= $m['price'].",";
								   	


								   	?>

								   <?php endforeach; ?>
								   <?php 

                                     $servicearray = explode(',', $serviceids);
                                     $get_price_quantity =   Helper::get_order_details($value[0]['order_id'],$v->id,'service');

                                    echo "<td>";

                                     if (in_array($v->id."_service", $servicearray)) {
                                     		
                                     			echo $get_price_quantity['quantity'];
                                     }else {
                                     	echo "0";
                                     }
                                     echo "</td>";
                                      echo "<td>";

                                     if (in_array($v->id."_service", $servicearray)) {
                                     	
                                     	   echo '<i class="fa fa-rupee"></i> '.$get_price_quantity['amount'];
                                     	   
                                     }else {
                                     	echo "0";
                                     }
                                     echo "</td>";
								   ?>
								   
							        <?php endforeach; ?>
							         <?php foreach($packs as $k => $v): ?>
								    	 <?php  foreach ($value['services'] as $j => $m):?>

								   		<?php 

								   	    $serviceids .= $m['service_id']."_".$m['type'].",";
								   		$prices .= $m['price'].",";

								   	?>


								   <?php endforeach; ?> 
								   <?php 

                                     $servicearray = explode(',', $serviceids);
                                     $get_price_quantity =   Helper::get_order_details($value[0]['order_id'],$v->id,'packs');
                                     echo "<td>";

                                     if (in_array($v->id."_packs", $servicearray)) {
                                     		
                                     			echo $get_price_quantity['quantity'];
                                     }else {
                                     	echo "0";
                                     }
                                     echo "</td>";
                                      echo "<td>";

                                     if (in_array($v->id."_packs", $servicearray)) {
                                     
                                     		$mainamount2 = $get_price_quantity['amount'];
                                     	   echo '<i class="fa fa-rupee"></i> '.$mainamount2;
                                     		
                                     			
                                     }else {
                                     	echo "0";
                                     }
                                     echo "</td>";
								   ?>
							        <?php endforeach; ?>
							         <?php foreach($events as $k => $v): ?>
								    	<td>0</td>
								    	<td><i class="fa fa-rupee"></i> 0</td>

							        <?php endforeach; ?>
								   	<td>0</td>
							    	<td><i class="fa fa-rupee"></i> 0</td>
								</tr>
							    <?php endforeach; ?>
						<tr style="background: #000;color: #FFF;">
							    	<td>
							    		<strong>Total</strong>
							    	</td>
							    	<?php foreach($services as $k => $v): ?>
							    		<?php
								    	if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
								    		list($from, $to) = explode('_', $date_type);
								    	  $get_price = Helper::get_reports_service_total($v->id,$from, $to,'all');
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	   $famount += $get_price['amount'];
								    	   
								    	}elseif($date_type=="todays") {
								    		 $get_price = Helper::get_reports_service_total($v->id,'todays', 'todays','all');
								    	  $amount = number_format($get_price['amount']);
								    	  $quantity = $get_price['quantity'];
								    	    $famount += $get_price['amount'];
								    		
								    	}elseif($date_type=="yesterday") {
								    		 $get_price = Helper::get_reports_service_total($v->id,'yesterday', 'yesterday','all');
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    $famount += $get_price['amount'];
								    		
								    	}elseif($date_type=="lastmonth") {
								    		 $get_price = Helper::get_reports_service_total($v->id,'lastmonth', 'lastmonth','all');
								    	  $amount = number_format($get_price['amount']);
								    	  $quantity = $get_price['quantity'];
								    	    $famount += $get_price['amount'];
								    		
								    	}elseif($date_type=="monthly") {
								    		 $get_price = Helper::get_reports_service_total($v->id,'monthly', 'monthly','all');
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    $famount += $get_price['amount'];
								    		
								    	}else {
								    		 $get_price = Helper::get_reports_service_total($v->id,'all', 'all','all');
								    	   $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    $famount += $get_price['amount'];
								    		
								    	}
								    	 
								    	  ?>
							    		<td><?= $quantity ?></td>
								    	<td><i class="fa fa-rupee"></i> <?= $amount ?></td>

							    	<?php endforeach; ?>
							    	<?php foreach($packs as $k => $v): ?>
							    		<?php
								    	if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
								    		list($from, $to) = explode('_', $date_type);
								    	  $get_price = Helper::get_reports_packs_total($v->id,$from, $to,'all');
								    	   $amount = number_format($get_price['amount']);
								    	    $quantity = $get_price['quantity'];
								    	   $famount += $get_price['amount'];
								    	   
								    	}elseif($date_type=="todays") {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'todays', 'todays','all');
								    	  $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    $famount += $get_price['amount'];
								    		
								    	}elseif($date_type=="yesterday") {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'yesterday', 'yesterday','all');
								    	   $amount = number_format($get_price['amount']);
								    	    $quantity = $get_price['quantity'];
								    	    $famount += $get_price['amount'];
								    		
								    	}elseif($date_type=="lastmonth") {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'lastmonth', 'lastmonth','all');
								    	  $amount = number_format($get_price['amount']);
								    	   $quantity = $get_price['quantity'];
								    	    $famount += $get_price['amount'];
								    		
								    	}elseif($date_type=="monthly") {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'monthly', 'monthly','all');
								    	   $amount = number_format($get_price['amount']);
								    	    $quantity = $get_price['quantity'];
								    	    $famount += $get_price['amount'];
								    		
								    	}else {
								    		 $get_price = Helper::get_reports_packs_total($v->id,'all', 'all','all');
								    	   $amount = number_format($get_price['amount']);
								    	    $quantity = $get_price['quantity'];
								    	    $famount += $get_price['amount'];
								    		
								    	}
								    	 
								    	  ?>
							    		<td><?= $quantity ?></td>
								    	<td><i class="fa fa-rupee"></i> <?= $amount ?></td>

							    	<?php endforeach; ?>
							    	<?php foreach($events as $k => $v): ?>
							    		<td>0</td>
								    	<td><i class="fa fa-rupee"></i> 0</td>

							    	<?php endforeach; ?>
							    		<td>0</td>
							    	<td><i class="fa fa-rupee"></i> 0</td>
							    </tr>
							    </tbody>
						</table>
					<?php endif; ?>


					<!-- Activity Wise -->
						<?php if($datatype=="activity"): ?>
						
						
						<table class="table display" id="example">

							<tr>
								
								<?php 
									 $color = Helper::rand_color();
									?>
								<td style="background: <?= $color; ?>;color:#FFF;">Date</td>
								
								<?php foreach($services as $key => $value): ?>
									<?php 
									 $color = Helper::rand_color();
									?>
								<td style="background: <?= $color; ?>;color:#FFF;"><?= $value->service_name ?> Trans#</td>
								<td style="background: <?= $color; ?>;color:#FFF;"><?= $value->service_name ?> Qty</td>
								<td style="background: <?= $color; ?>;color:#FFF;"><?= $value->service_name ?> Rev</td>
							    <?php endforeach; ?>
							    <?php foreach($packs as $key => $value): ?>
							    	<?php 
									 $color = Helper::rand_color();
									?>
							    <td style="background: <?= $color; ?>;color:#FFF;"><?= $value->pack_name ?> Trans#</td>
							    <td style="background: <?= $color; ?>;color:#FFF;"><?= $value->pack_name ?> Qty</td>
								<td style="background: <?= $color; ?>;color:#FFF;"><?= $value->pack_name ?> Rev</td>
							    <?php endforeach; ?>
							     <?php foreach($events as $key => $value): ?>
							     	<?php 
									 $color = Helper::rand_color();
									?>
							     <td style="background: <?= $color; ?>;color:#FFF;"><?= $value->event_name ?> Trans#</td>
							     <td style="background: <?= $color; ?>;color:#FFF;"><?= $value->event_name ?> Qty</td>
								 <td style="background: <?= $color; ?>;color:#FFF;"><?= $value->event_name ?> Rev</td>
							    <?php endforeach; ?>
							</tr>
							<?php foreach($paymentcat as $t => $g): ?>
									<?php if($g->filter_name != "FOC"): ?>
							<tr style="background: #000;color: #FFF;">
							    	<td>
							    		<strong><?= $g->filter_name ?></strong>
							    	</td>
							    	<?php foreach($services as $k => $v): ?>
							    		<?php 
							    	$transno = 0;
							    	$quantity = 0;

							    	?>
							    			<td>
                                       <?php foreach($daterange as $key => $value): ?>
							    			<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'service',$g->filter_value);
								     	$transno +=  $get_statistics['transno'];
								     	?>
								     	<?php endforeach; ?>
								     	<?php 
                                            echo $transno;
								     	?>
								     	</td>
							    			<td>
                                       <?php foreach($daterange as $key => $value): ?>
							    			<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'service',$g->filter_value);
								     	$quantity +=  $get_statistics['quantity'];
								     	?>
								     	<?php endforeach; ?>
								     	<?php 
                                            echo $quantity;
								     	?>
								     	</td>
								    	<td><i class="fa fa-rupee"></i> <?php
								    		if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
								    		list($from, $to) = explode('_', $date_type);
								    		$get_price = Helper::get_reports_service_total($v->id,$from, $to,$g->filter_value);
								    	   echo number_format($get_price['amount']);
								    	  
								    	}elseif($date_type=="todays") {
								    		$get_price = Helper::get_reports_service_total($v->id,'todays', 'todays',$g->filter_value);
								    		 echo number_format($get_price['amount']);
								    		
								    	}elseif($date_type=="yesterday") {
								    		$get_price = Helper::get_reports_service_total($v->id,'yesterday', 'yesterday',$g->filter_value);
								    		 echo number_format($get_price['amount']);
								    		
								    	}elseif($date_type=="lastmonth") {
								    		$get_price = Helper::get_reports_service_total($v->id,'lastmonth', 'lastmonth',$g->filter_value);
								    		 echo number_format($get_price['amount']);
								    	
								    	}elseif($date_type=="monthly") {
								    		$get_price = Helper::get_reports_service_total($v->id,'monthly', 'monthly',$g->filter_value);
								    		 echo number_format($get_price['amount']);
								    		
								    	}else {
								    		$get_price = Helper::get_reports_service_total($v->id,'all', 'all',$g->filter_value);
								    		 echo number_format($get_price['amount']);
								    		
								    	}
								    	 
								    	  ?></td>

							    	<?php endforeach; ?>
							    	<?php foreach($packs as $k => $v): ?>
							    			<?php 
							    	$transno = 0;
							    	$quantity = 0;

							    	?>
							    			<td>
                                       <?php foreach($daterange as $key => $value): ?>
							    			<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'packs',$g->filter_value);
								     	$transno +=  $get_statistics['transno'];
								     	?>
								     	<?php endforeach; ?>
								     	<?php 
                                            echo $transno;
								     	?>
								     	</td>
							    		
							    			<td>
                                       <?php foreach($daterange as $key => $value): ?>
							    			<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'packs',$g->filter_value);
								     	$quantity +=  $get_statistics['quantity'];
								     	?>
								     	<?php endforeach; ?>
								     	<?php 
                                            echo $quantity;
								     	?>
								     	</td>
								    	<td><i class="fa fa-rupee"></i> <?php
								    	if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
								    		list($from, $to) = explode('_', $date_type);
								    	   $get_price = Helper::get_reports_packs_total($v->id,$from, $to,$g->filter_value);
								    	   echo number_format($get_price['amount']);
								    	   
								    	}elseif($date_type=="todays") {
								    		$get_price = Helper::get_reports_packs_total($v->id,'todays','todays',$g->filter_value);
								    	   echo number_format($get_price['amount']);
								    		
								    	}elseif($date_type=="yesterday") {
								    		$get_price = Helper::get_reports_packs_total($v->id,'yesterday','yesterday',$g->filter_value);
								    	   echo number_format($get_price['amount']);
								    		
								    	}elseif($date_type=="lastmonth") {
								    			$get_price = Helper::get_reports_packs_total($v->id,'lastmonth','lastmonth',$g->filter_value);
								    	   echo number_format($get_price['amount']);
								    		
								    	}elseif($date_type=="monthly") {
								    			$get_price = Helper::get_reports_packs_total($v->id,'monthly','monthly',$g->filter_value);
								    	   echo number_format($get_price['amount']);
								    		
								    	}else {
								    			$get_price = Helper::get_reports_packs_total($v->id,'all','all',$g->filter_value);
								    	   echo number_format($get_price['amount']);
								    	}						    	 
								    	?></td>
							    	<?php endforeach; ?>
							    	<?php foreach($events as $k => $v): ?>
							    		<td>0</td>
							    		<td>0</td>
							    		<td>0</td>

							    	<?php endforeach; ?>
							    </tr>
							<?php endif; ?>
							    <?php endforeach; ?>
							<tr style="background: #000;color: #FFF;">
							    	<td>
							    		<strong>Total</strong>
							    	</td>
							    	<?php foreach($services as $k => $v): ?>
							    		<?php 
							    	$transno = 0;
							    	$quantity = 0;

							    	?>
							    			<td>
                                       <?php foreach($daterange as $key => $value): ?>
							    			<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'service','all');
								     	$transno +=  $get_statistics['transno'];
								     	?>
								     	<?php endforeach; ?>
								     	<?php 
                                            echo $transno;
								     	?>
								     	</td>
							    			<td>
                                       <?php foreach($daterange as $key => $value): ?>
							    			<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'service','all');
								     	$quantity +=  $get_statistics['quantity'];
								     	?>
								     	<?php endforeach; ?>
								     	<?php 
                                            echo $quantity;
								     	?>
								     	</td>
								    	<td><i class="fa fa-rupee"></i> <?php
								    		if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
								    		list($from, $to) = explode('_', $date_type);
								    		$get_price = Helper::get_reports_service_total($v->id,$from, $to,'all');
								    	   echo number_format($get_price['amount']);
								    	  
								    	}elseif($date_type=="todays") {
								    		$get_price = Helper::get_reports_service_total($v->id,'todays', 'todays','all');
								    		 echo number_format($get_price['amount']);
								    		
								    	}elseif($date_type=="yesterday") {
								    		$get_price = Helper::get_reports_service_total($v->id,'yesterday', 'yesterday','all');
								    		 echo number_format($get_price['amount']);
								    		
								    	}elseif($date_type=="lastmonth") {
								    		$get_price = Helper::get_reports_service_total($v->id,'lastmonth', 'lastmonth','all');
								    		 echo number_format($get_price['amount']);
								    	
								    	}elseif($date_type=="monthly") {
								    		$get_price = Helper::get_reports_service_total($v->id,'monthly', 'monthly','all');
								    		 echo number_format($get_price['amount']);
								    		
								    	}else {
								    		$get_price = Helper::get_reports_service_total($v->id,'all', 'all','all');
								    		 echo number_format($get_price['amount']);
								    		
								    	}
								    	 
								    	  ?></td>

							    	<?php endforeach; ?>
							    	<?php foreach($packs as $k => $v): ?>
							    			<?php 
							    	$transno = 0;
							    	$quantity = 0;

							    	?>
							    			<td>
                                       <?php foreach($daterange as $key => $value): ?>
							    			<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'packs','all');
								     	$transno +=  $get_statistics['transno'];
								     	?>
								     	<?php endforeach; ?>
								     	<?php 
                                            echo $transno;
								     	?>
								     	</td>
							    		
							    			<td>
                                       <?php foreach($daterange as $key => $value): ?>
							    			<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'packs','all');
								     	$quantity +=  $get_statistics['quantity'];
								     	?>
								     	<?php endforeach; ?>
								     	<?php 
                                            echo $quantity;
								     	?>
								     	</td>
								    	<td><i class="fa fa-rupee"></i> <?php
								    	if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
								    		list($from, $to) = explode('_', $date_type);
								    	   $get_price = Helper::get_reports_packs_total($v->id,$from, $to,'all');
								    	   echo number_format($get_price['amount']);
								    	   
								    	}elseif($date_type=="todays") {
								    		$get_price = Helper::get_reports_packs_total($v->id,'todays','todays','all');
								    	   echo number_format($get_price['amount']);
								    		
								    	}elseif($date_type=="yesterday") {
								    		$get_price = Helper::get_reports_packs_total($v->id,'yesterday','yesterday','all');
								    	   echo number_format($get_price['amount']);
								    		
								    	}elseif($date_type=="lastmonth") {
								    			$get_price = Helper::get_reports_packs_total($v->id,'lastmonth','lastmonth','all');
								    	   echo number_format($get_price['amount']);
								    		
								    	}elseif($date_type=="monthly") {
								    			$get_price = Helper::get_reports_packs_total($v->id,'monthly','monthly','all');
								    	   echo number_format($get_price['amount']);
								    		
								    	}else {
								    			$get_price = Helper::get_reports_packs_total($v->id,'all','all','all');
								    	   echo number_format($get_price['amount']);
								    	}						    	 
								    	?></td>
							    	<?php endforeach; ?>
							    	<?php foreach($events as $k => $v): ?>
							    		<td>0</td>
							    		<td>0</td>
							    		<td>0</td>

							    	<?php endforeach; ?>
							    </tr>
							<?php if(count($daterange) != 0): ?>

							<?php 
                               rsort($daterange);
							?>


								<?php foreach($daterange as $key => $value): ?>
								<tr>
								  
							
								    <td><?= $value ?></td>
								     <?php foreach($services as $k => $v): ?>
								     	<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'service','all');
								     	$color = Helper::rand_color();
								     	?>
								     	<td><?= $get_statistics['transno'] ?></td>
								     	<td><?= $get_statistics['quantity'] ?></td>
								     	<td><i class="fa fa-rupee"></i> <?= number_format($get_statistics['amount']) ?></td>
								     <?php endforeach; ?>
								     <?php foreach($packs as $k => $v): ?>
								     <?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'packs','all');
								     	?>
								     	<td><?= $get_statistics['transno'] ?></td>
								     	<td><?= $get_statistics['quantity'] ?></td>
								     	<td><i class="fa fa-rupee"></i> <?= number_format($get_statistics['amount']) ?></td>
								     <?php endforeach; ?>
                                  <?php foreach($events as $k => $v): ?>
								       <?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'events','all');
								     	?>
								     	<td><?= $get_statistics['transno'] ?></td>
								     	<td><?= $get_statistics['quantity'] ?></td>
								     	<td><i class="fa fa-rupee"></i> <?= number_format($get_statistics['amount']) ?></td>
								     <?php endforeach; ?>
								   
								   
								</tr>
							    <?php endforeach; ?>

							   	<tr style="background: #000;color: #FFF;">
							    	<td>
							    		<strong>Total</strong>
							    	</td>
							    	<?php 
							    	$transno = 0;
							    	$quantity = 0;

							    	?>
							    	<?php foreach($services as $k => $v): ?>
							    		<td>
                                       <?php foreach($daterange as $key => $value): ?>
							    			<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'service','all');
								     	$transno +=  $get_statistics['transno'];
								     	?>
								     	<?php endforeach; ?>
								     	<?php 
                                            echo $transno;
								     	?>
								     	</td>
							    			<td>
                                       <?php foreach($daterange as $key => $value): ?>
							    			<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'service','all');
								     	$quantity +=  $get_statistics['quantity'];
								     	?>
								     	<?php endforeach; ?>
								     	<?php 
                                            echo $quantity;
								     	?>
								     	</td>
								    	<td><i class="fa fa-rupee"></i> <?php
								    	if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
								    		list($from, $to) = explode('_', $date_type);
								    	  $get_price = Helper::get_reports_service_total($v->id,$from, $to,'all');
								    	   echo number_format($get_price['amount']);
								    	   $famount += $get_price['amount'];
								    	}elseif($date_type=="todays") {
								    		  $get_price = Helper::get_reports_service_total($v->id,'todays', 'todays','all');
								    	   echo number_format($get_price['amount']);
								    	   $famount += $get_price['amount'];
								    	}elseif($date_type=="yesterday") {
								    	   $get_price = Helper::get_reports_service_total($v->id,'yesterday', 'yesterday','all');
								    	   echo number_format($get_price['amount']);
								    	   $famount += $get_price['amount'];
								    	}elseif($date_type=="lastmonth") {
								    		$get_price = Helper::get_reports_service_total($v->id,'lastmonth', 'lastmonth','all');
								    	   echo number_format($get_price['amount']);
								    	   $famount += $get_price['amount'];
								    	}elseif($date_type=="monthly") {
								    	    $get_price = Helper::get_reports_service_total($v->id,'monthly', 'monthly','all');
								    	   echo number_format($get_price['amount']);
								    	   $famount += $get_price['amount'];
								    	}else {
								    	   $get_price = Helper::get_reports_service_total($v->id,'all', 'all','all');
								    	   echo number_format($get_price['amount']);
								    	   $famount += $get_price['amount'];
								    	}
								    	 
								    	  ?></td>

							    	<?php endforeach; ?>
							    	<?php foreach($packs as $k => $v): ?>
							    		<?php 
							    	$transno = 0;
							    	$quantity = 0;

							    	?>
							    		<td>
                                       <?php foreach($daterange as $key => $value): ?>
							    			<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'packs','all');
								     	$transno +=  $get_statistics['transno'];
								     	?>
								     	<?php endforeach; ?>
								     	<?php 
                                            echo $transno;
								     	?>
							    			<td>
                                       <?php foreach($daterange as $key => $value): ?>
							    			<?php 
								     	$get_statistics = Helper::get_statistics_details($value,$v->id,'packs','all');
								     	$quantity +=  $get_statistics['quantity'];
								     	?>
								     	<?php endforeach; ?>
								     	<?php 
                                            echo $quantity;
								     	?>
								     	</td>
								    	<td><i class="fa fa-rupee"></i> <?php
								    	if ($date_type != "all" && $date_type !="todays" && $date_type != "yesterday" && $date_type != "monthly" && $date_type != "lastmonth") {
								    		list($from, $to) = explode('_', $date_type);
								    	   $get_price = Helper::get_reports_packs_total($v->id,$from, $to,'all');
								    	   echo number_format($get_price['amount']);
								    	   $famount += $get_price['amount'];
								    	}elseif($date_type=="todays") {
								    		  $get_price = Helper::get_reports_packs_total($v->id,'todays','todays','all');
								    	   echo number_format($get_price['amount']);
								    	   $famount += $get_price['amount'];
								    	}elseif($date_type=="yesterday") {
								    	 $get_price = Helper::get_reports_packs_total($v->id,'yesterday','yesterday','all');
								    	   echo number_format($get_price['amount']);
								    	   $famount += $get_price['amount'];
								    	}elseif($date_type=="lastmonth") {
								    	 $get_price = Helper::get_reports_packs_total($v->id,'lastmonth','lastmonth','all');
								    	   echo number_format($get_price['amount']);
								    	   $famount += $get_price['amount'];
								    	}elseif($date_type=="monthly") {
								    		$get_price = Helper::get_reports_packs_total($v->id,'monthly','monthly','all');
								    	   echo number_format($get_price['amount']);
								    	   $famount += $get_price['amount'];
								    	}else {
								    		$get_price = Helper::get_reports_packs_total($v->id,'all','all','all');
								    	   echo number_format($get_price['amount']);
								    	   $famount += $get_price['amount'];
								    	}
								    	 
								    	  ?></td>

							    	<?php endforeach; ?>
							    	<?php foreach($events as $k => $v): ?>
							    		<td>0</td>
								    	<td>0</td>
								    	<td>0</td>

							    	<?php endforeach; ?>
							    </tr>

							<?php endif; ?>
							
						</table>
					<?php endif; ?>
					
				
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

<script>
$(document).ready(function(){
  $(".allInput2").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".allTable2 tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  }); 
  $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
}); 
});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		 $(".to").on("change", function(e) {
           var from = $("#from").val();
           var to = $("#to").val();
           var data = from+"_"+to;
           var datatype = "<?= $datatype ?>"
           var url = "<?= URL::to('admin/reports') ?>/"+datatype+"/"+data;
           window.location = url;
         });
	
		$(".type").change(function() {
				var data = $('.type').find(":selected").val();
		var url = "<?= URL::to('admin/reports') ?>/"+data+"/all";
		window.location = url;
		});
			$(".dtype").change(function() {
				var data = $('.dtype').find(":selected").val();
				var datatype = "<?= $datatype ?>"
		var url = "<?= URL::to('admin/reports') ?>/"+datatype+"/"+data;


		if (datatype =="transaction") {
			if (data=="custom") {
			$(".datearea").css('display','block');
		}else {
			window.location = url;
		}
	}else {
			if (data!="all") {
			$(".datearea").css('display','block');
		}else {
			window.location = url;
		}
	}
		
		
		


         
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

	});
	$(function(){
  $(".wrapper1").scroll(function(){
    $(".row").scrollLeft($(".wrapper1").scrollLeft());
  });
  $(".wrapper2").scroll(function(){
    $(".wrapper1").scrollLeft($(".row").scrollLeft());
  });
  var famount = '<?php
   echo number_format($famount); ?>';
  $(".grandtotal").html('<i class="fa fa-rupee"></i> '+famount);
});
</script>

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
function exportF(elem) {
  var table = document.getElementById("example");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.style.padding = "10px";
  var random = "<?= date('his') ?>"
  elem.setAttribute("download", random+"Report.xls"); // Choose the file name
  return false;
}
</script>

@endsection
