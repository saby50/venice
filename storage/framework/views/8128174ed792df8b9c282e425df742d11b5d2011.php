 


<?php $__env->startSection('title'); ?>
Bookings
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php 
  $user_type = "";
    $manager_id = 0;
    $name = "";
if ($type=="app") {
      $manager = DB::table('admins')
    ->where('admins.user_type','manager')
    ->where('admins.email',$email)
    ->get();
     $manager_id = 0;
      foreach ($manager as $key => $value) {
        $name = $value->name;    
        $user_type = $value->user_type;      
      }
      
    }else {
        $name = Auth::user()->name;
        $user_type = Auth::user()->user_type;
    }
$serviceids = "";

?>
<div class="main-content style2"> 
<div class="breadcrumbs">
  <ul>
    <li><a href="#/" title="">Home</a></li>
    <li><a href="#/pages/portfolio" title="">Booking(s)</a></li>
  </ul>
</div>

<div class="heading-sec">
  <div class="row">
    <div class="col-md-6 column">
      <div class="heading-profile">
        <h2><?php        
          if ($user_type=="manager") {
            echo "Welcome, ".$name;
          }else {
            echo "Booking(s)";
          }
        ?> </h2>

      </div>
    </div>
    <div class="col-md-6 column">
      <div class="top-bar-chart" style="text-align: right;">
        <a href="#" style="color: #000;" class="refresh-content" title="Refresh"><i class="fa fa-refresh fa-2x" aria-hidden="true"></i></a>
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
      <?php if ($type=="app"): ?>
     <li class=""><a  href="<?= URL::to('admin/get_app_managers_access/'.$email.'/app') ?>">Today's Arrival</a></li>
     <li class="active"><a  href="<?= URL::to('admin/get_app_managers_all_access/'.$email.'/app/all') ?>">All Bookings</a></li>
      <?php else: ?>
        <li class=""><a  href="<?php echo e(URL::to('admin/bookings/today')); ?>">Today's Arrival</a></li>
    <li  class="active"><a  href="<?php echo e(URL::to('admin/bookings/s/todays/all')); ?>">All Bookings</a></li>
    <?php endif; ?>
     <?php if($user_type=="superadmin" || $user_type=="analyst" || $user_type=="lead_manager"): ?>
    <li  class=""><a  href="<?php echo e(URL::to('admin/events_bookings/all')); ?>">Events</a></li>

  <?php endif; ?>
    

  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
   
    </div>
    <div id="menu1" class="tab-pane fade in active">
      <?php 
           $totalamount = 0;
      ?>
      <?php if($user_type != "manager"): ?>
        <div class="row" style="margin-top: 20px;margin-bottom: 20px;width: 80%;margin-left:auto;margin-right: auto;">
          <div class="col-md-4">
            <h4><?= count($data2) ?> Records, Total:  <i class="fa fa-inr"></i> <span class="totalamount"></span></h4>
          </div>
        
           <div class="col-md-2" style="margin-bottom: 20px;">
            <select class="filter form-control">
             <?php foreach($filters as $key => $value): ?>
              <?php if($parameter==$value->filter_value): ?>
              <option value="<?= $value->filter_value ?>" selected><?= $value->filter_name ?></option>
              <?php else: ?>
                <option value="<?= $value->filter_value ?>"><?= $value->filter_name ?></option>
            <?php endif; ?>
             <?php endforeach; ?>          
            </select>
            <?php if($parameter=="custom"): ?>
              <?php 
              if (isset($parameter2)) {
                list($from,$to) = explode('_', $parameter2);
              }
                               
              ?>
              <?php if(isset($parameter2)): ?>             
             <div class="col-md-6" style="margin-top: 20px;margin-bottom: 20px;">
               <input type="text" name="fromdate" placeholder="From Date" id="from" value="<?= $from ?>" class="form-control" autocomplete="off">
             </div>
                <div class="col-md-6" style="margin-top: 20px;margin-bottom: 20px;">
               <input type="text" name="todate" placeholder="To Date" id="to"  value="<?= $to ?>" class="form-control" autocomplete="off">
             </div>
             <?php else: ?>
              <div class="col-md-6" style="margin-top: 20px;margin-bottom: 20px;">
               <input type="text" name="fromdate" placeholder="From Date" id="from" class="form-control" autocomplete="off">
             </div>
                <div class="col-md-6" style="margin-top: 20px;margin-bottom: 20px;">
               <input type="text" name="todate" placeholder="To Date" id="to" class="form-control" autocomplete="off">
             </div>
               <?php endif; ?>
            <?php endif; ?>
          </div>
            <div class="col-md-2">
            <select class="filter2 form-control">
              <?php foreach($filter2 as $key => $value): ?>
                 <?php if($type3==$value->filter_value): ?>
              <option value="<?= $value->filter_value ?>" selected><?= $value->filter_name ?></option>
              <?php else: ?>
                <option value="<?= $value->filter_value ?>"><?= $value->filter_name ?></option>
            <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>
          <?php if($user_type=="superadmin"): ?>
          <div class="col-md-2" style="margin-bottom: 20px;">
           <select  class="form-control allSelect2">
              <option value="">All Activities</option>
             <?php foreach($services as $key => $value): ?>
              <option value="<?= $value->service_name ?>"><?= $value->service_name ?></option>
             <?php endforeach; ?>
            <?php foreach($packs as $key => $value): ?>
              <option value="<?= $value->pack_name ?>"><?= $value->pack_name ?></option>
             <?php endforeach; ?>
            </select>
          </div>
        <?php endif; ?>
          <?php if($user_type=="superadmin"): ?>
        <div class="col-md-2" style="margin-bottom: 20px;">
          <?php else: ?>
            <div class="col-md-4" style="margin-bottom: 20px;">
          <?php endif; ?>
          <input type="text" placeholder="Search.." class="form-control allInput2">
        </div>
        
        
      </div>
    <?php endif; ?>
      <?php if (count($data2) != 0): ?>
      
            <?php if($type=="app"): ?>
             <table class="table allTable2" >

            <?php else: ?>

             <table class="table allTable2" style="width: 80%;margin:0 auto;margin-top: 40px;">

             <?php endif; ?>
          <thead>
            <tr>             
              <th>Details</th>
              <th>Booking Details</th>
              <th>Price</th>
           <th></th>
            </tr>
          </thead>
          <tbody>

            <?php 
           usort($data2, function($a, $b) {
                return $a[0]['created_at'] < $b[0]['created_at'];
           });

 
            ?>
            
            <?php 
           
           
             if ($user_type=="superadmin" || $user_type=="analyst" || $user_type=="manager" || $user_type=="lead_manager" || $user_type=="pos" || $user_type=="leadanalyst" || $user_type=="editor"):
            ?>
            <!-- Preview for Superuser -->
         
           <?php foreach($data2 as $key => $value): ?>
            <?php 
                  $order_id = $value[0]['order_id'];

            ?>
         
          <tr>
       
            <td><strong class="bluecode"><?= $value[0]['order_id'] ?></strong><br /><strong>Name:</strong> <?= $value[0]['name'] ?> <?php if ($value[0]['email']!="") {
              echo "<br /><strong>Email: </strong>".$value[0]['email'];
            }  ?><br /><strong>Phone:</strong> <?= $value[0]['phone'] ?><br />
            <?php
               $created_at  = "";
              foreach ($value as $k => $v) {
                 $created_at = $v['created_at'];
               } 
              ?>

              <?php 
              $time = "";
              $quantity = 0;
              foreach($value as $k => $v) {
                list($a, $b, $c) = explode('-', $v['date']); 
                $newdate = $a."-".$b."-".$c;
                $time = $v['time'];
                $quantity = $v['quantity'];
              } 
              ?>
              


             <strong>Booked on: </strong><?php
                
               echo date('d M, Y h:i A',strtotime($value[0]['created_at']));
              ?>
             <br /><?php 
            if ($v['payment_method']=="instamojo") {
             echo "EC(Instamojo)";
            }else if($v['payment_method']=="cash") {
              echo "POS(Cash)";

            }else if($v['payment_method']=="card") {
              echo "POS(CARD)";

            } else if($v['payment_method']=="paytm_qr") {
              echo "POS(Paytm QR)";

            }else if($v['payment_method']=="bookmyshow") {
              echo "EC(Bookmyshow) - ".Helper::get_bms_id($value[0]['order_id']);
            }else if($v['payment_method']=="wallet") {
              echo "(GV Pay)";
            }      
            ?><br /><?php 
            $foc_status = Helper::check_foc_status($value[0]['order_id']);
            if (count($foc_status) != 0) {
              $fstatus = "";
              foreach ($foc_status as $t => $j) {
                $fstatus = $j->status;
                $reason = $j->reason;
              }
              echo "<span style='color:red;'>FOC(".$fstatus."): ".$reason."</span>";

            }
            ?></td>
            <td style="width: 400px;">
           
              
              <?php foreach($value as $k => $v): ?>
              <div class="col-md-8">
            <span style="text-transform: uppercase;font-size: 14px;font-weight: 600" class="bluecode"><?= $v['service_name'] ?> <br /> 
           
             <?php if($v['option_name'] != ""): ?>
            (<?= $v['option_name'] ?>)<br />
            <?php endif; ?>
            
            </span>
             <strong><?php
              if($v['occasion_type']!="0") {
                echo Helper::get_occassion_type($v['occasion_type'])."<br />";
               }
              ?></strong>
             <?php           
               echo "<strong>Arrival Date: </strong> ".date('d F Y', strtotime($v['date']));

               if ($v['date'] >= date('d-m-Y')) {
                if ($user_type=="superadmin") {
                   echo " <a href='#' class='changedate' data='".$order_id."' data1='".$v['service_id']."' data2='".$v['type']."'>Change</a>";
                }
                 
               }

              

             ?><br />
             <strong>Arrival Time: </strong><?= $v['time'] ?><br />
           <strong>Quantity: </strong><?= $v['quantity'] ?><br /> 
           <strong>Price: </strong><i class="fa fa-inr"></i> <?= $v['price'] + $v['tax'] ?> <br /> 

          
             <span style="color: red;"><?php
              if($v['checkin_time']!=null) {
                echo "Check-in: Yes<br /> ".$v['checkin_time']."<br />";
               }elseif(date('d-m-Y') < $v['date']) {
                echo "Check-in: N/A<br />";
               }else {
                echo "Check-in: No<br />";
               }
               $checkinby = Helper::get_gondoliers_order_id($order_id);
               if ($checkinby != "") {
                 echo "(".$checkinby.")";
               }
               
              ?></span><br />
            
            </div>
           <div class="col-md-4" style="margin-bottom: 10px;">
  
           </div>
            <?php endforeach; ?>
              <div class="col-md-12"> <br /><strong>Platform:</strong> <?php 
               if ($v['platform']=="web") {
                echo '<i class="fa fa-globe fa-lg" aria-hidden="true" title="Web"></i>';
               }else if($v['platform']=="android") {
                  echo '<i class="fa fa-android fa-lg" aria-hidden="true" title="Android"></i>';

               }
              ?>
             
            </div>
              

            </td>
              <td>
                  <?php
                  $totalamount += $v['amount'];

                   ?>
                  <input type="hidden" name="totalamount" class="totalamount" value="<?= $v['amount'] ?>">
                  
                <i class="fa fa-inr"></i> <?= $v['amount'] ?>
                <?php 
                $refund = $v['refund'];
                if ($refund=="yes") {
                  echo "<br />";
                   echo "<span style='color:red;'>(Refunded)</span>";
                 } 
                ?></td>
                <td>
                 <?php if($user_type=="superadmin" || $user_type=="pos"): ?>
                  <div class="dropdown">
  <button class="dropbtn"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
  <div class="dropdown-content">
    <?php if($user_type=="superadmin"): ?>
    <a href="#" class="refund" data="<?= $v['order_id'] ?>">Initiate a Refund</a>
    <a href="#" class="delete" data="<?= URL::to('admin/deletebooking/'.Crypt::encrypt($v['order_id'])) ?>">Delete</a>
    <?php 
        if($v['checkin_time']!=null) {
              echo '<a href="#" class="assignment" data="'.$v['order_id'].'">Change Gondolier</a>';
        }
    ?>
    
    <?php endif; ?>
     <?php if($user_type=="pos" || $user_type=="superadmin"): ?>
      <?php  if($v['option_name'] != ""): ?>
      <a href="#" class="changecanal" data="<?= $v['order_id'] ?>">Change Canal</a>
    <?php endif; ?>
    <?php endif; ?>

  </div>
</div>
<?php endif; ?>
</td>
           
  
            
            
            
          </tr>
          
        <?php endforeach; ?>

           <!-- End Preview for Superuser -->

            <?php else: ?>

              

               <!-- Preview for Manager -->

               <?php foreach($data2 as $key => $value): ?>
          <?php if($value[0]['type']=="packs"): ?>
          <tr>
       
            <td><strong class="bluecode"><?= $value[0]['order_id'] ?></strong><br /><strong>Name:</strong> <?= $value[0]['name'] ?><?php if ($value[0]['email']!="") {
              echo "<br /><strong>Email:</strong> ".$value[0]['email'];
            }  ?><br /><strong>Phone:</strong> <?= $value[0]['phone'] ?><br />
            <?php
               $created_at  = "";
              foreach ($value as $k => $v) {
                 $created_at = $v['created_at'];
               } 
              ?>

              <?php 
              $time = "";
              $quantity = 0;
              foreach($value as $k => $v) {
                list($a, $b, $c) = explode('-', $v['date']); 
                $newdate = $a."-".$b."-".$c;
                $time = $v['time'];
                $quantity = $v['quantity'];
              } 
              ?>
              <?php           
               echo "<strong>Date: </strong> ".date('d F Y', strtotime($newdate));

             ?><br />
            <strong>Arrival Time: </strong><?= $time ?><br />
            
             <strong>Quantity: </strong><?= $quantity ?> <br />


            <strong>Booked on: </strong><?php
                
               echo date('d M, Y h:i A',strtotime($value[0]['created_at']));
              ?>
            
             <br /><?php 
            if ($v['payment_method']=="instamojo") {
             echo "EC(Instamojo)";
            }else if($v['payment_method']=="cash") {
              echo "POS(Cash)";

            }else if($v['payment_method']=="card") {
              echo "POS(CARD)";

            } else if($v['payment_method']=="paytm_qr") {
              echo "POS(Paytm QR)";

            } else if($v['payment_method']=="bookmyshow") {
              echo "EC(Bookmyshow) - ".Helper::get_bms_id($value[0]['order_id']);

            }else if($v['payment_method']=="wallet") {
               echo "(GV Pay)";
            }     
            ?><?php 
            $foc_status = Helper::check_foc_status($value[0]['order_id']);
            if (count($foc_status) != 0) {
              $fstatus = "";
              foreach ($foc_status as $t => $j) {
                $fstatus = $j->status;
              }
              echo "<span style='color:red;'>FOC(".$fstatus.")</span>";

            }
            ?></td>
            <td style="width: 400px;"><?php foreach($value as $k => $v): ?>
            <div class="col-md-8">
            <span style="text-transform: uppercase;font-size: 14px;font-weight: 600" class="bluecode"><?= $v['service_name'] ?><br /> 
             <?php if($v['option_name'] != ""): ?>
            (<?= $v['option_name'] ?>)<br />
           
            <?php endif; ?></span> 
             
            <span style="color: red;"><?php
              if($v['checkin']=="yes") {
                echo "Check-in: Yes<br /> (".$v['checkin_time'].")<br />";
               }elseif(date('d-m-Y') < $v['date']) {
                echo "Check-in: N/A<br />";
               }else {
                echo "Check-in: No<br />";
               }
              ?></span>
            
            </div>
           <div class="col-md-4" style="margin-bottom: 10px;">
  
           </div>
            <?php endforeach; ?>
              <div class="col-md-12"> <br /><strong>Platform:</strong> <?php 
               if ($v['platform']=="web") {
                echo '<i class="fa fa-globe fa-lg" aria-hidden="true" title="Web"></i>';
               }else if($v['platform']=="android") {
                  echo '<i class="fa fa-android fa-lg" aria-hidden="true" title="Android"></i>';

               }
              ?></div></td>
              <td>  <?php
                  $totalamount += $v['amount'];


                   ?><i class="fa fa-inr"></i> <?= $v['amount'] ?>
                  <input type="hidden" name="totalamount" class="totalamount" value="<?= $v['amount'] ?>"></td>
           
  
            
            
            
          </tr>
          <?php else: ?>
            <tr>
       
            <td><strong class="bluecode"><?= $value[0]['order_id'] ?></strong><br /><strong>Name:</strong> <?= $value[0]['name'] ?><br /><strong>Email:</strong> <?= $value[0]['email'] ?><br /><strong>Phone:</strong> <?= $value[0]['phone'] ?><br />
            <?php
               $created_at  = "";
              foreach ($value as $k => $v) {
                 $created_at = $v['created_at'];
               } 
              ?>

             
            


             <strong>Booked on:</strong> <?= $created_at ?>
             <br />
           <?php 
            if ($v['payment_method']=="instamojo") {
             echo "EC(Instamojo)";
            }else if($v['payment_method']=="cash") {
              echo "POS(Cash)";

            }else if($v['payment_method']=="card") {
              echo "POS(CARD)";

            } else if($v['payment_method']=="paytm_qr") {
              echo "POS(Paytm QR)";

            } else if($v['payment_method']=="bookmyshow") {
              echo "EC(Bookmyshow) - ".Helper::get_bms_id($value[0]['order_id']);

            }else if($v['payment_method']=="wallet") {
              echo "(GV Pay)";
            }       
            ?></td>
            <td style="width: 400px;"><?php foreach($value as $k => $v): ?>
            <div class="col-md-8">
            <span style="text-transform: uppercase;font-size: 14px;font-weight: 600" class="bluecode"><?= $v['service_name'] ?><br /> 
             <?php if($v['option_name'] != ""): ?>
            (<?= $v['option_name'] ?>)<br />
           
           
            <?php endif; ?>
            
          </span> 
        
           <span style="color: red;"><?php
               if($v['checkin']=="yes") {
                echo "Check-in: Yes <br />".$v['checkin_time']."<br />";
               }elseif(date('d-m-Y') < $v['date']) {
                echo "Check-in: N/A<br />";
               }else {
                echo "Check-in: No<br />";
               }
               
              ?></span>
          <?php 
              list($a, $b, $c) = explode('-', $v['date']); 
              $newdate = $a."-".$b."-".$c;
              $time = $v['time'];
              $quantity = $v['quantity'];
              echo "<strong>Date: </strong> ".date('d F Y', strtotime($newdate))."<br />";
              echo "<strong>Arrival Time:</strong> ".$time."<br />";

              echo "<strong>Quantity:</strong> ".$quantity;
            ?> 
            <br /><br />
            
            </div>
           <div class="col-md-4" style="margin-bottom: 10px;">
  
           </div>
            <?php endforeach; ?>
              <div class="col-md-12"> <br /><strong>Platform:</strong> <?php 
               if ($v['platform']=="web") {
                echo '<i class="fa fa-globe fa-lg" aria-hidden="true" title="Web"></i>';
               }else if($v['platform']=="android") {
                  echo '<i class="fa fa-android fa-lg" aria-hidden="true" title="Android"></i>';

               }
              ?></div></td>
              <td>  <?php
                  $totalamount += $v['amount'];

                   ?><i class="fa fa-inr"></i> <?= $v['amount'] ?>
                 <input type="hidden" name="totalamount" class="totalamount" value="<?= $v['amount'] ?>"></td>
          

            
            
          </tr>
        <?php endif; ?>
        <?php endforeach; ?>





               <!-- End Preview for Superuser -->


            <?php endif; ?>


          </tbody>
        </table>


       
       

      <?php else: ?>
            <div style="width: 80%;margin: 0 auto;"> <h3 style="margin-top: 40px;color: red;">  No Bookings</h3></div> 
            <?php endif; ?>
    </div>
    <div id="menu2" class="tab-pane fade">
       
      
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
<div class="modal fade" id="bookingModal" role="dialog">
  <form action="<?= URL::to('admin/bookings/checkin') ?>" method="post">
    <?php echo csrf_field(); ?>
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <label>Verify Mobile</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>
          <div class="modal-body">
            <div class="content">
              
              <label>Phone</label>
              <input type="number" class="form-control" name="phone" required="required">
              <input type="hidden" name="order_id" class="order_id" value="">
              <input type="hidden" name="service_id" class="service_id" value="">
            </div>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
             <button type="submit" class="btn btn-primary">SUBMIT</button>
          </div>
        </div>
      </div>
      </form>
    </div>

<div class="modal fade" id="refundModal" role="dialog">
  <form action="<?= URL::to('admin/refundinitiate/') ?>" method="post">
    <?php echo csrf_field(); ?>
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <label>Initiate a Refund</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>
          <div class="modal-body">
            <div class="content">
              
              <label>Refund ID</label>
              <input type="text" class="form-control" name="refund_id" required="required"><br />
              <label>Reason</label>
              <textarea class="form-control reason" name="reason" required="required" maxlength="160"></textarea>
              <span id="charNum"></span>
              <input type="hidden" name="order_id" class="order_id" value="">
            
            </div>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
             <button type="submit" class="btn btn-primary">SUBMIT</button>
          </div>
        </div>
      </div>
      </form>
    </div>
    <div class="modal fade" id="assignmentModal" role="dialog">
  <form action="<?= URL::to('admin/changeassignment') ?>" method="post">
    <?php echo csrf_field(); ?>
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <label>Select Gondolier</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>
          <div class="modal-body">
            <div class="content">
              
              <?php 
              $gondoliers = Helper::get_gondoliers(); ?>
            <?php foreach($gondoliers as $key => $value): ?>
             <input type="checkbox" name="gondolier[]" value="<?= $value->id ?>"> <?= $value->gondolier_name ?><br />
            <?php endforeach; ?> 
            <input type="hidden" name="order_id" value="" class="asignement_order_id">
            </div>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
             <button type="submit" class="btn btn-primary">SUBMIT</button>
          </div>
        </div>
      </div>
      </form>
    </div>
    <div class="modal fade" id="dateModal" role="dialog">
  <form action="<?= URL::to('admin/changedate') ?>" method="post">
    <?php echo csrf_field(); ?>
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <label>Change Arrival Date</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>
          <div class="modal-body">
            <div class="content">
              
              <label>From Date:</label>
              <input type="text" class="form-control " id="from2" name="fromdate" autocomplete="off" required="required">
              <input type="hidden" name="order_id" class="order_id" value="">
            <input type="hidden" name="service_id" class="service_id" value="">
            <input type="hidden" name="type" class="type" value="">
            </div>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
             <button type="submit" class="btn btn-primary">Change</button>
          </div>
        </div>
      </div>
      </form>
    </div>
     <div class="modal fade" id="changeModal2" role="dialog">
  <form action="<?= URL::to('admin/changecanal') ?>" method="post">
    <?php echo csrf_field(); ?>
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <label>Change Canal</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>
          <div class="modal-body">
            <div class="content">
              
              <label>Select Canal</label><br />
              <?php $canal = Helper::get_canal('1');
                    foreach($canal as $key => $value): ?>
              <input type="radio" name="canal" value="<?= $value->id ?>" checked> <?= $value->option_name ?> &nbsp;&nbsp;
              <?php endforeach; ?>

              <input type="hidden" name="order_id" class="order_id" value="">
     
            </div>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
             <button type="submit" class="btn btn-primary">Change</button>
          </div>
        </div>
      </div>
      </form>
    </div>
    <script type="text/javascript">
    

     $(function() {
      $(".checkinbtn").click(function() {
        var data = $(this).attr('data');
        var data1 = $(this).attr('data1');
        $('.order_id').attr('value',data);
        $('.service_id').attr('value',data1);
           $("#bookingModal").modal('show');
      });
       $(".refund").click(function() {
           var data = $(this).attr('data');
           $('.order_id').attr('value',data);
           $("#refundModal").modal('show');
      });
        $(".changedate").click(function() {
           var data = $(this).attr('data');
           var data1 = $(this).attr('data1');
           var data2 = $(this).attr('data2');
           $('.order_id').attr('value',data);
           $('.service_id').attr('value',data1);
           $('.type').attr('value',data2);
           $("#dateModal").modal('show');
      });
       $(".refresh-content").click(function() {
           location.reload(true);
     });
     });
    </script>
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
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".assignment").click(function() {
        var data = $(this).attr('data');
        $(".asignement_order_id").attr('value',data);
        $("#assignmentModal").modal('show');

    });
    $(".filter, .filter2").change(function() {
        var data = $('.filter').find(":selected").val();
       var type = "<?= $type ?>";
       var email = "<?= $email ?>";
       var filter2 = $(".filter2 option:selected").val();
      if (type=="app") {
        var url = "<?= URL::to('admin/get_app_managers_all_access/"+email+"/app/"+data+"') ?>";
      }else {
        if (data=="custom") {
          var daterange = $("#from").val()+"_"+$("#to").val();
          var url = "<?= URL::to('admin/bookings/choose/') ?>/"+daterange+"/"+filter2;

        }else {
          var url = "<?= URL::to('admin/bookings/s/') ?>/"+data+"/"+filter2;
        }
        
      }
    
    window.location = url;
    });
    

    $("#to").on('change', function() {
      var from = $("#from").val();
      var to = $("#to").val();

      var data = from+"_"+to;

       var type = "<?= $type ?>";
         var email = "<?= $email ?>"
      if (type=="app") {
        var url = "<?= URL::to('admin/get_app_managers_date_access/choose/"+email+"/app/"+data+"') ?>";
      }else {
        var url = "<?= URL::to('admin/bookings/choose/') ?>/"+data+"/all";
      }

       
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
  } );

  $(document).ready(function() {
    var total = "<?= number_format($totalamount) ?>";
    $(".totalamount").html(total);
    $("#from2").datepicker({
     defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat: 'yy-mm-dd',
        minDate: 0
  });
   $('.reason').keyup(function () {
  var max = 160;
  var len = $(this).val().length;
  var char = max - len;
    $('#charNum').text(char + ' Characters Left');
});
   $(".changecanal").click(function() {
    var data = $(this).attr('data');
    $("#changeModal2 .order_id").attr('value',data);
       $("#changeModal2").modal('show');
   });
 });
</script>
<style>
.dropbtn {
  background-color: red;
  color: white;
  padding: 10px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/bookings/all.blade.php ENDPATH**/ ?>