@extends('multiauth::layouts.main') 
@section('title')
Dashboard
@endsection
@section('content')
<div class="main-content style2"> 

<div class="breadcrumbs">
    <ul>
        <li><a href="#/" title="">Home</a></li>
        <li><a href="#/" title="">Dashboard</a></li>
    </ul>
</div>
<h4>Welcome, {{ Auth::user()->name }}</h4>
<div class="panel-content">
    <div class="row">
        <div class="col-md-12">
            <div class="mini-stats-sec">
                <div class="row">
                   <!--  <div class="col-md-4">
                        <label>Filter</label>
                         <select class="filter form-control">
             <?php foreach($filters as $key => $value): ?>
              <?php if($parameter==$value->filter_value): ?>
              <option value="<?= $value->filter_value ?>" selected><?= $value->filter_name ?></option>
              <?php else: ?>
                <option value="<?= $value->filter_value ?>"><?= $value->filter_name ?></option>
            <?php endif; ?>
             <?php endforeach; ?>          
            </select>
                    </div> -->
                     <div class="col-md-4">
                        <?php if($parameter=='service'): ?>
                        <label>Search by <?= $parameter ?></label>
                         <select class="filter2 form-control">
                            <option value="all">All</option>
             <?php foreach($services as $key => $value): ?>
                 <?php if($type==$value->id): ?>
            <option value="<?= $value->id ?>" selected><?= $value->service_name ?></option>
            <?php else: ?>
                <option value="<?= $value->id ?>"><?= $value->service_name ?></option>
        <?php endif; ?>
             <?php endforeach; ?>          
            </select>
               <?php elseif($parameter=="packs"): ?>
                 <label>Search by <?= $parameter ?></label>
                         <select class="filter2 form-control">
                            <option value="all">All</option>
             <?php foreach($packs as $key => $value): ?>
               <?php if($type==$value->id): ?>
            <option value="<?= $value->id ?>" selected><?= $value->pack_name ?></option>
            <?php else: ?>
                <option value="<?= $value->id ?>"><?= $value->pack_name ?></option>
        <?php endif; ?>
             <?php endforeach; ?>          
            </select>
            <?php else: ?>
               <?php endif; ?>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <span class="red-skin"><i class="fa fa-usd1"></i></span>
                                <p><i class="fa  fa-arrow-up up"></i>Revenue - Today</p>
                                <h3><i class="fa fa-rupee"></i> <?= number_format($data['todayamount'])."<br /> <span style='font-size: 12px;'>No of Bookings: ".$data['todaysbookings']."</span>" ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <span class="red-skin"><i class="fa fa-usd1"></i></span>
                                <p><i class="fa  fa-arrow-down down"></i>Revenue - Total </p>
                                <h3><i class="fa fa-rupee"></i> <?= number_format($data['totalamount'])."<br /> <span style='font-size: 12px;'>No of Bookings: ".$data['totalsale']."</span>" ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <span class="red-skin"><i class="fa fa-usd1"></i></span>
                                <p><i class="fa  fa-arrow-down down"></i>Revenue - This Month </p>
                                <h3><i class="fa fa-rupee"></i> <?= number_format($data['monthlytotal'])."<br /> <span style='font-size: 12px;'>No of Bookings: ".$data['monthbookings']."</span>" ?></h3>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <span class="red-skin"><i class="fa fa-usd1"></i></span>
                                <p><i class="fa  fa-arrow-down down"></i>Revenue - Last Month </p>
                                <h3><i class="fa fa-rupee"></i> <?= number_format($data['lastmonth'])."<br /> <span style='font-size: 12px;'>No of Bookings: ".$data['lastmonthbookings']."</span>" ?></h3>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <span class="red-skin"><i class="fa fa-usd1"></i></span>
                                <p><i class="fa  fa-arrow-down down"></i>FOC - Today </p>
                                <h3><i class="fa fa-rupee"></i> <?php $foc = Helper::get_foc_amount('todays'); echo number_format($foc['amount'])."<br /> <span style='font-size: 12px;'>No of Bookings: ".$foc['count']."</span>" ?></h3>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <span class="red-skin"><i class="fa fa-usd1"></i></span>
                                <p><i class="fa  fa-arrow-down down"></i>FOC - TOTAL </p>
                                <h3><i class="fa fa-rupee"></i> <?php $foc = Helper::get_foc_amount('all'); echo number_format($foc['amount'])."<br /> <span style='font-size: 12px;'>No of Bookings: ".$foc['count']."</span>" ?></h3>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <span class="red-skin"><i class="fa fa-usd1"></i></span>
                                <p><i class="fa  fa-arrow-down down"></i>FOC - THIS MONTH </p>
                                <h3><i class="fa fa-rupee"></i> <?php $foc = Helper::get_foc_amount('monthly'); echo number_format($foc['amount'])."<br /> <span style='font-size: 12px;'>No of Bookings: ".$foc['count']."</span>" ?></h3>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <span class="red-skin"><i class="fa fa-usd1"></i></span>
                                <p><i class="fa  fa-arrow-down down"></i>FOC - LAST MONTH </p>
                                <h3><i class="fa fa-rupee"></i> <?php $foc = Helper::get_foc_amount('lastmonth'); echo number_format($foc['amount'])."<br /> <span style='font-size: 12px;'>No of Bookings: ".$foc['count']."</span>" ?></h3>
                            </div>
                        </div>
                    </div>
                     <!-- Foc Analysis -->
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <div id="chartContainerfoc" style="height: 370px; width: 100%;margin-top: 40px;"></div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <div id="chartContainerfoc2" style="height: 370px; width: 100%;margin-top: 40px;"></div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">            
                                <div id="chartContainerfoc3" style="height: 370px; width: 100%;margin-top: 40px;"></div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">                              
                               <div id="chartContainerfoc4" style="height: 370px; width: 100%;margin-top: 40px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- End Foc Analysis -->
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                              
                              <div id="chartpayment1" style="height: 370px; width: 100%;"></div>
                               
                                
                            </div>
                        </div>
                    </div>

                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                              
                              <div id="chartpayment2" style="height: 370px; width: 100%;"></div>
                               
                                
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                              
                              <div id="chartpayment3" style="height: 370px; width: 100%;"></div>
                               
                                
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                              
                              <div id="chartpayment4" style="height: 370px; width: 100%;"></div>
                               
                                
                            </div>
                        </div>
                    </div>
                    <!-- Payment Modes -->
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                              
                              <div id="chartmode1" style="height: 370px; width: 100%;"></div>
                               
                                
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                              
                              <div id="chartmode2" style="height: 370px; width: 100%;"></div>
                               
                                
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                              
                              <div id="chartmode3" style="height: 370px; width: 100%;"></div>
                               
                                
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                              
                              <div id="chartmode4" style="height: 370px; width: 100%;"></div>
                               
                                
                            </div>
                        </div>
                    </div>

                      <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                              
                              <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                               
                                
                            </div>
                        </div>
                    </div>
                       <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                              <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                       <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                              <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                       <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                              <div id="chartContainer4" style="height: 370px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>

                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <div id="chartContainerpacks" style="height: 370px; width: 100%;margin-top: 40px;"></div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <div id="chartContainer2packs" style="height: 370px; width: 100%;margin-top: 40px;"></div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">            
                                <div id="chartContainer3packs" style="height: 370px; width: 100%;margin-top: 40px;"></div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">                              
                               <div id="chartContainer4packs" style="height: 370px; width: 100%;margin-top: 40px;"></div>
                            </div>
                        </div>
                    </div>
                   
                    <?php foreach ($services as $key => $value): ?> 
                    <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <div style="margin-top: 10px;margin-left: 80px;font-size: 30px;"> <?php 
                                  $rating = Helper::get_average_ratings($value->id, 'service');
                                  echo " ".$rating." ";
                                  if ($rating==0) {
                                    echo '<i class="fa fa-star fa-lg" style="color:#ccc;"></i>';
                                  }else {
                                   echo '<i class="fa fa-star fa-lg" style="color:#FFD700;"></i>';
                                  }
                                  $count = Helper::get_average_ratings($value->id,'service');
                                  
                                ?></div>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <p><i class="fa fa-arrow-up up"></i> Ratings
                                 <?php 
                                  $response = Helper::get_number_of_ratings($value->id, 'service');
                                  echo "(".$response." responses)";
                                 ?>
                                </p>
                                <h3><?= $value->service_name ?><br /></h3>
                               
                            </div>
                        </div>
                    </div>
                  <?php endforeach; ?>
                     <?php foreach ($packs as $key => $value): ?> 
                    <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <div style="margin-top: 10px;margin-left: 80px;font-size: 30px;"><?php 
                                  $rating = Helper::get_average_ratings($value->id, 'packs');
                                  echo " ".$rating." ";
                                  if ($rating==0) {
                                    echo '<i class="fa fa-star fa-lg" style="color:#ccc;"></i>';
                                  }else {
                                   echo '<i class="fa fa-star fa-lg" style="color:#FFD700;"></i>';
                                  }
                                  $count = Helper::get_average_ratings($value->id,'packs');
                                  
                                ?></div>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <p><i class="fa fa-arrow-up up"></i> Ratings
                                 <?php 
                                  $response = Helper::get_number_of_ratings($value->id, 'packs');
                                  echo "(".$response." responses)";
                                 ?>
                                </p>
                                 <h3><?= $value->pack_name ?><br /></h3>
                                
                            </div>
                        </div>
                    </div>
                  <?php endforeach; ?>
                 <div class="col-md-6">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">                              
                               <div id="chartContainerline" style="height: 370px; width: 100%;margin-top: 40px;"></div>
                            </div>
                        </div>
                    </div>
                 
                  <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <span class="red-skin"><i class="fa fa-usd1"></i></span>
                                <p><i class="fa  fa-arrow-down down"></i>Wallet - TODAY </p>
                                <h3><i class="fa fa-rupee"></i> <?php $foc = Helper::get_wallet_revenue_by_day('todays'); echo number_format($foc); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <span class="red-skin"><i class="fa fa-usd1"></i></span>
                                <p><i class="fa  fa-arrow-down down"></i>Wallet - TOTAL </p>
                                <h3><i class="fa fa-rupee"></i> <?php $foc = Helper::get_wallet_revenue_by_day('total'); echo number_format($foc); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <span class="red-skin"><i class="fa fa-usd1"></i></span>
                                <p><i class="fa  fa-arrow-down down"></i>Wallet - THIS MONTH </p>
                                <h3><i class="fa fa-rupee"></i> <?php $foc = Helper::get_wallet_revenue_by_day('monthly'); echo number_format($foc); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="widget">
                            <div class="widget-controls">
                                <span class="refresh-content"><i class="fa fa-refresh"></i></span>
                            </div><!-- Widget Controls -->
                            <div class="mini-stats ">
                                <span class="red-skin"><i class="fa fa-usd1"></i></span>
                                <p><i class="fa  fa-arrow-down down"></i>Wallet - LAST MONTH </p>
                                <h3><i class="fa fa-rupee"></i> <?php $foc = Helper::get_wallet_revenue_by_day('lastmonth'); echo number_format($foc); ?></h3>
                            </div>
                        </div>
                    </div> 
                </div>
            </div><!-- Mini stats Sec --> 
        </div>
       
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="800">
            <defs>
            <filter id="goo">
                          <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
                          <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
                          <feComposite in="SourceGraphic" in2="goo" />
            </filter>
           </defs>
         </svg>
        </div>
        </div>
    </div>
     
    </div>
</div><!-- Panel Content -->


</div>
<?php

 $dataPointspayments = array();  $dataPointspayments2 = array();  $dataPointspayments3 = array();  $dataPointspayments4 = array();  
  foreach ($paymentcat as $key => $value) {
     $rand = rand(111,000);
     $todaysale = Helper::get_reports_service_total('0','todays','todays',$value->filter_value);
     $todaysalep = Helper::get_reports_packs_total('0','todays','todays',$value->filter_value);
     $todaytotal = $todaysale['amount'] + $todaysalep['amount'];
     if ($todaytotal != 0) {
       $dataPointspayments[] = array("label"=>$value->filter_name, "y" => $todaytotal);
     }
    
    $totalsale = Helper::get_reports_service_total('0','all','all',$value->filter_value);
     $totalsalep = Helper::get_reports_packs_total('0','all','all',$value->filter_value);
     $totalsale2 = $totalsale['amount'] + $totalsalep['amount'];
      if ($totalsale2 != 0) {
      $dataPointspayments2[] = array("label"=>$value->filter_name, "y"=>$totalsale2);
     }
     
     $thismonth = Helper::get_reports_service_total('0','monthly','monthly',$value->filter_value);
     $thismonth2 = Helper::get_reports_packs_total('0','monthly','monthly',$value->filter_value);
      $thismonth2 = $thismonth['amount'] + $thismonth2['amount'];
      if ($thismonth2 != 0) {
     $dataPointspayments3[] = array("label"=>$value->filter_name, "y"=>$thismonth2);
     }
     
      $lastmonth = Helper::get_reports_service_total('0','lastmonth','lastmonth',$value->filter_value);
       $lastmonthp = Helper::get_reports_packs_total('0','lastmonth','lastmonth',$value->filter_value);
       $lastmonth2 = $lastmonth['amount'] + $lastmonthp['amount'];
       if ($lastmonth2 != 0) {
      $dataPointspayments4[] = array("label"=>$value->filter_name, "y"=>$lastmonth2);
     }
    
    
  }
$dataPointsmode = array();  $dataPointsmode2 = array();  $dataPointsmode3 = array();  $dataPointsmode4 = array();  
  foreach ($paymentmode as $key => $value) {
     $rand = rand(111,000);
     $todaysale = Helper::get_reports_service_total('0','todays','todays',$value->filter_value);
     $todaysalep = Helper::get_reports_packs_total('0','todays','todays',$value->filter_value);
     $todaytotal = $todaysale['amount'] + $todaysalep['amount'];
     if ($todaytotal != 0) {
       $dataPointsmode[] = array("label"=>$value->filter_name, "y" => $todaytotal);
     }
    
    $totalsale = Helper::get_reports_service_total('0','all','all',$value->filter_value);
     $totalsalep = Helper::get_reports_packs_total('0','all','all',$value->filter_value);
     $totalsale2 = $totalsale['amount'] + $totalsalep['amount'];
      if ($totalsale2 != 0) {
      $dataPointsmode2[] = array("label"=>$value->filter_name, "y"=>$totalsale2);
     }
     
     $thismonth = Helper::get_reports_service_total('0','monthly','monthly',$value->filter_value);
     $thismonth2 = Helper::get_reports_packs_total('0','monthly','monthly',$value->filter_value);
      $thismonth2 = $thismonth['amount'] + $thismonth2['amount'];
      if ($thismonth2 != 0) {
     $dataPointsmode3[] = array("label"=>$value->filter_name, "y"=>$thismonth2);
     }
     
      $lastmonth = Helper::get_reports_service_total('0','lastmonth','lastmonth',$value->filter_value);
       $lastmonthp = Helper::get_reports_packs_total('0','lastmonth','lastmonth',$value->filter_value);
       $lastmonth2 = $lastmonth['amount'] + $lastmonthp['amount'];
       if ($lastmonth2 != 0) {
      $dataPointsmode4[] = array("label"=>$value->filter_name, "y"=>$lastmonth2);
     }
    
    
  }

  $dataPoints = array();  $dataPoints2 = array();  $dataPoints3 = array();  $dataPoints4 = array();  
  foreach ($services as $key => $value) {
    $rand = rand(111,000);
     $todaysale = Helper::get_reports_service_total($value->id,'todays','todays','all');
     if ($todaysale['amount'] != 0) {
       $dataPoints[] = array("label"=>$value->service_name, "y"=>$todaysale['amount']);
     }
    
    $totalsale = Helper::get_reports_service_total($value->id,'all','all','all');
      if ($totalsale['amount'] != 0) {
      $dataPoints2[] = array("label"=>$value->service_name, "y"=>$totalsale['amount']);
     }
     
     $thismonth = Helper::get_reports_service_total($value->id,'monthly','monthly','all');
      if ($thismonth['amount'] != 0) {
     $dataPoints3[] = array("label"=>$value->service_name, "y"=>$thismonth['amount']);
     }
     
      $lastmonth = Helper::get_reports_service_total($value->id,'lastmonth','lastmonth','all');
       if ($lastmonth['amount'] != 0) {
      $dataPoints4[] = array("label"=>$value->service_name, "y"=>$lastmonth['amount']);
     }
    
  }
   $dataPointsp = array(); $dataPoints2p = array();  $dataPoints3p = array();  $dataPoints4p = array();
foreach ($packs as $key => $value) {
    $rand = rand(111,000);
    $todaysale = Helper::get_reports_packs_total($value->id,'todays','todays','all');
    if ($todaysale['amount'] != 0) {
     $dataPointsp[] = array("label"=>$value->pack_name, "y"=>$todaysale['amount']);
    }
    
    $totalsale = Helper::get_reports_packs_total($value->id,'all','all','all');
     if ($totalsale['amount'] != 0) {
     $dataPoints2p[] = array("label"=>$value->pack_name, "y"=>$totalsale['amount']);
    }
    
    $thismonth = Helper::get_reports_packs_total($value->id,'monthly','monthly','all');
      if ($thismonth['amount'] != 0) {
     $dataPoints3p[] = array("label"=>$value->pack_name, "y"=>$thismonth['amount']);
    }
    
    $lastmonth = Helper::get_reports_packs_total($value->id,'lastmonth','lastmonth','all');
     if ($lastmonth['amount'] != 0) {
     $dataPoints4p[] = array("label"=>$value->pack_name, "y"=>$lastmonth['amount']);
    }
   
} 

 $dataPointsfoc = array(); $dataPointsfoc2 = array();  $dataPointsfoc3 = array();  $dataPointsfoc4 = array();
foreach ($foc_reasons as $key => $value) {
    $rand = rand(111,000);
    $todaysale = Helper::get_foc_stats($value->reason,'todays');
    if ($todaysale != 0) {
     $dataPointsfoc[] = array("label"=>$value->reason, "y"=>$todaysale);
    }
    
    $totalsale = Helper::get_foc_stats($value->reason,'all');
     if ($totalsale != 0) {
     $dataPointsfoc2[] = array("label"=>$value->reason, "y"=>$totalsale);
    }
    
    $thismonth = Helper::get_foc_stats($value->reason,'monthly');
      if ($thismonth != 0) {
     $dataPointsfoc3[] = array("label"=>$value->reason, "y"=>$thismonth);
    }
    
    $lastmonth = Helper::get_foc_stats($value->reason,'lastmonth');
     if ($lastmonth != 0) {
     $dataPointsfoc4[] = array("label"=>$value->reason, "y"=>$lastmonth);
    }
   
} 
$datalines = array();

for ($i=0; $i < 7; $i++) { 
   $date =  date('d', strtotime('+'.$i." days", strtotime('last week monday')));
   $date2 =  date('d-m-Y', strtotime('+'.$i." days", strtotime('last week monday')));
   $datalines[] = array("x" => $date, 'y' => Helper::get_wallet_revenue($date2));
}
$walletoday = array(); $walletotal = array(); $walletotal = array(); $walletlast = array();

?>
<script>
window.onload = function() {
 var chart = new CanvasJS.Chart("chartpayment1", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Payment Categories - Today"
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointspayments, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
  var chart = new CanvasJS.Chart("chartpayment2", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Payment Categories - Total"
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointspayments2, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
 var chart = new CanvasJS.Chart("chartpayment3", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Payment Categories - This Month"
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointspayments3, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
 var chart = new CanvasJS.Chart("chartpayment4", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Payment Categories - Last Month"
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointspayments4, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();

 var chart = new CanvasJS.Chart("chartmode1", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Payment Mode - Today"
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointsmode, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
  var chart = new CanvasJS.Chart("chartmode2", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Payment Mode - Total"
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointsmode2, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
 var chart = new CanvasJS.Chart("chartmode3", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Payment Mode - This Month"
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointsmode3, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
 var chart = new CanvasJS.Chart("chartmode4", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Payment Mode - Last Month"
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointsmode4, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Independent Services - Today"
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();

  var chart = new CanvasJS.Chart("chartContainerpacks", {
  animationEnabled: true,
  
  subtitles: [{
    text: "GV Packs - Today"
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointsp, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
 var chart = new CanvasJS.Chart("chartContainer2", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Independent Services - Total"
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
 var chart = new CanvasJS.Chart("chartContainer2packs", {
  animationEnabled: true,
  
  subtitles: [{
    text: "GV Packs - Total"
  }],
  data: [{
    type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPoints2p, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
var chart = new CanvasJS.Chart("chartContainer3", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Independent Services - This Month"
  }],
  data: [{
   type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
 var chart = new CanvasJS.Chart("chartContainer3packs", {
  animationEnabled: true,
  
  subtitles: [{
    text: "GV Packs - This Month"
  }],
  data: [{
   type: "pie",
   yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPoints3p, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
var chart = new CanvasJS.Chart("chartContainer4", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Independent Services - Last Month"
  }],
  data: [{
    type: "pie",
   yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
var chart = new CanvasJS.Chart("chartContainer4packs", {
  animationEnabled: true,
  
  subtitles: [{
    text: "GV Packs - Last Month"
  }],
  data: [{
   type: "pie",
   yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPoints4p, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();

var chart = new CanvasJS.Chart("chartContainerfoc", {
  animationEnabled: true,
  
  subtitles: [{
    text: "FOC - Today"
  }],
  data: [{
   type: "pie",
    yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointsfoc, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
 var chart = new CanvasJS.Chart("chartContainerfoc2", {
  animationEnabled: true,
  
  subtitles: [{
    text: "FOC - Total"
  }],
  data: [{
   type: "pie",
   yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointsfoc2, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
var chart = new CanvasJS.Chart("chartContainerfoc3", {
  animationEnabled: true,
  
  subtitles: [{
    text: "FOC - This Month"
  }],
  data: [{
    type: "pie",
   yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointsfoc3, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
var chart = new CanvasJS.Chart("chartContainerfoc4", {
  animationEnabled: true,
  
  subtitles: [{
    text: "FOC - Last Month"
  }],
  data: [{
   type: "pie",
   yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPointsfoc4, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();


var chart = new CanvasJS.Chart("chartContainerline", {
    animationEnabled: true,
    theme: "light3",
    title:{
        text: "GV Pay Balance: Weekly Progression"
    },
    axisY:{
        includeZero: false
    },
    data: [{  
      
        type: "line",       
        dataPoints: <?php echo json_encode($datalines, JSON_NUMERIC_CHECK); ?>
    }]
});
chart.render();
var chart = new CanvasJS.Chart("chartwalltoday", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Wallet - Today"
  }],
  data: [{
   type: "pie",
   yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
var chart = new CanvasJS.Chart("chartwalltotal", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Wallet - Total"
  }],
  data: [{
   type: "pie",
   yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
var chart = new CanvasJS.Chart("chartwallmonth", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Wallet - thismonth Month"
  }],
  data: [{
   type: "pie",
   yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
var chart = new CanvasJS.Chart("chartwalllast", {
  animationEnabled: true,
  
  subtitles: [{
    text: "Wallet - Last Month"
  }],
  data: [{
   type: "pie",
   yValueFormatString: "#,##0",
    indexLabel: "{y}",
    indexLabelPlacement: "inside",
    indexLabelFontWeight: "bolder",
    indexLabelFontColor: "transparent",
    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
}

</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".filter").change(function() {
        var data = $('.filter').find(":selected").val();
        var data2 = "all";
     var url = "<?= URL::to('admin/home/') ?>/"+data+"/"+data2;
    window.location = url;
    });
     $(".filter2").change(function() {
        var data = $('.filter').find(":selected").val();
        var data2 = $('.filter2').find(":selected").val();
    var url = "<?= URL::to('admin/home/') ?>/"+data+"/"+data2;
    window.location = url;
    });

     $(".refresh-content").click(function() {
           location.reload(true);
     });
    
  });
</script>
<style type="text/css">
  .canvasjs-chart-credit {
    display: none;
  }
</style>
@endsection