 


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
    
     <?php if ($type=="app"): ?>
     <li class="active"><a  href="<?= URL::to('admin/get_app_managers_access/'.$email.'/app') ?>">Today's Arrival</a></li>
     <li class=""><a  href="<?= URL::to('admin/get_app_managers_all_access/'.$email.'/app/all') ?>">All Bookings</a></li>
      <?php else: ?>
        <li class="active"><a  href="<?php echo e(URL::to('admin/bookings/today')); ?>">Today's Arrival</a></li>
    <li  class=""><a  href="<?php echo e(URL::to('admin/bookings/s/todays/all')); ?>">All Bookings</a></li>
    <?php endif; ?>
     <?php if($user_type=="superadmin" || $user_type=="analyst" || $user_type=="lead_manager" || $user_type=="pos" || $user_type=="leadanalyst" || $user_type=="editor"): ?>
    <li  class=""><a  href="<?php echo e(URL::to('admin/events_bookings/all')); ?>">Events</a></li>

  <?php endif; ?>

  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
     <?php if (count($data) != 0): ?>
       <div class="row" style="margin-top: 20px;margin-bottom: 20px;width: 80%;margin-left:auto;margin-right: auto;">
          <div class="col-md-8" style="margin-bottom: 20px;">
            <h4><?= count($data) ?> Records Found</h4>
          </div>
          <div class="col-md-2"  style="margin-bottom: 20px;">
            <select  class="form-control allSelect">
              <option value="">Services</option>
             <?php foreach($services as $key => $value): ?>
              <option value="<?= $value->service_name ?>"><?= $value->service_name ?></option>
             <?php endforeach; ?>
               <?php foreach($packs as $key => $value): ?>
              <option value="<?= $value->pack_name ?>"><?= $value->pack_name ?></option>
             <?php endforeach; ?>        
            </select>
          </div>
        <div class="col-md-2" style="margin-bottom: 20px;">
          <input type="text" placeholder="Search.." class="form-control allInput">
        </div>
        
        
      </div>
 
        <?php 
             if ($user_type=="superadmin" || $user_type=="analyst" || $user_type=="lead_manager" || $user_type=="pos" || $user_type=="leadanalyst" || $user_type=="editor"): ?>



            <!-- Preview for Superuser -->


             <table class="table allTable" style="width: 80%;margin:0 auto;">
          <thead>
            <tr>
              
              <th>Details</th>
              <th>Booking Details</th>
              <th>Price</th>
              
              
            </tr>
          </thead>
          <tbody>
  <?php 
           usort($data, function($a, $b) {
                return $a[0]['created_at'] < $b[0]['created_at'];
           });

 
            ?>
           
<?php foreach($data as $key => $value): ?>
         
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
              }
              echo "<span style='color:red;'>FOC(".$fstatus.")</span>";

            }
            ?></td>
            <td style="width: 400px;">
           
              
              <?php foreach($value as $k => $v): ?>
              <div class="col-md-8">
            <span style="text-transform: uppercase;font-size: 14px;font-weight: 600" class="bluecode"><?= $v['service_name'] ?><br /> 
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
               echo "<strong>Arrival Date: </strong> ".date('d F Y', strtotime($newdate));

             ?><br />
             <strong>Arrival Time: </strong><?= $v['time'] ?><br />
           <strong>Quantity: </strong><?= $v['quantity'] ?><br /> 
           <strong>Price: </strong><i class="fa fa-inr"></i> <?= $v['price'] + $v['tax'] ?> <br /> <br />
             
            
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
              ?></div>

            </td>
              <td><i class="fa fa-inr"></i> <?= $v['amount'] ?></td>
           
            
            
            
          </tr>
          
        <?php endforeach; ?>
            


            



           



          </tbody>
        </table>
      <!-- End Preview for Superuser -->
        <?php else: ?>
      <!--  Preview for Manager -->

            <?php if($type=="app"): ?>
             <table class="table allTable">

            <?php else: ?>

             <table class="table allTable" style="width: 80%;margin:0 auto;">

             <?php endif; ?>
          <thead>
            <tr>
              
              <th>Details</th>
              <th>Booking Details</th>
             
              
              
              <th></th>
             
              
            </tr>
          </thead>
          <tbody>
             <?php 
           usort($data, function($a, $b) {
                return $a[0]['created_at'] < $b[0]['created_at'];
           });

 
            ?>
          <?php foreach($data as $key => $value): ?>
            <tr>
       
            <td><strong class="bluecode"><?= $value[0]['order_id'] ?></strong><br /><strong>Name:</strong> <?= $value[0]['name'] ?><?php if ($value[0]['email']!="") {
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
            ?></td>
            <td style="width: 400px;">
          
              
              <?php foreach($value as $k => $v): ?>

              <div class="col-md-8">
                <input type="checkbox" name="services" class="servicess" value="<?= $v['service_id'] ?>">
            <span style="text-transform: uppercase;font-size: 14px;font-weight: 600" class="bluecode"><?= $v['service_name'] ?><br /> 
               
             <?php if($v['option_name'] != ""): ?>
            (<?= $v['option_name'] ?>)<br />
            <?php endif; ?>
            
            </span>
             <?php           
               echo "<strong>Arrival Date: </strong> ".date('d F Y', strtotime($v['date']));

             ?><br />
             <strong>Arrival Time: </strong><?= $v['time'] ?><br />
           <strong>Quantity: </strong><?= $v['quantity'] ?><br /> 
          
             <span style="color: red;"><?php
              if($v['checkin']=="yes") {
                echo "Check-in: Yes<br /> (".$v['checkin_time'].")<br />";
               }elseif(date('d-m-Y') < $v['date']) {
                echo "Check-in: N/A<br />";
               }else {
                echo "Check-in: No<br />";
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
              ?></div>

            </td>
              <td> <?php if($user_type=="manager"): ?>
  
 <input type="button" name="" class="btn btn-primary checkinbtn" value="CHECK-IN" data="<?= $v['order_id'] ?>" data1="<?= rtrim($serviceids,",") ?>">
  <?php endif; ?></td>
            
           
  
            
            
            
          </tr>
        
        <?php endforeach; ?>


            



           



          </tbody>
        </table>

        <?php endif; ?>
        
      <?php else: ?>
              <h4 style="margin-top: 40px;">  No Bookings</h4>
            <?php endif; ?>
    </div>
    <div id="menu1" class="tab-pane fade">
       
    
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
<div class="modal fade center" id="bookingModal" role="dialog">
  <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
  <?php if($type=="app"): ?>
  <form action="<?= URL::to('admin/api/checkin') ?>" method="post">
    <?php else: ?>
      <form action="<?= URL::to('admin/bookings/checkin') ?>" method="post">
    <?php endif; ?>
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
              <input type="hidden" name="type" value="<?= $type ?>">
              <input type="hidden" name="email" value="<?= $email ?>">
              <input type="hidden" name="user_type" value="<?= $user_type ?>"><br />
             
              <?php
              if ($type=="web") {
                $user_email = Auth::user()->email;
              }else {
                $user_email = $email;
              }
              
               $gondoliers = Helper::get_gondoliers();
               if ($user_email!="mastiiizone@veniceindia.com"):
                echo "<label>Select Gondolier</label><br />";
  
               foreach($gondoliers as $key => $value): ?>
             <input type="checkbox" name="gondolier[]" value="<?= $value->id ?>"> <?= $value->gondolier_name ?><br />
            <?php endforeach; ?>
          <?php endif; ?>
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
</div></div>
<script type="text/javascript" src="https://staging.striker.academy/crm/public/js/dirPagination.js"></script>
    <script type="text/javascript">
    

     $(function() {
      $(".checkinbtn").click(function() {
       var favorite = [];
            $.each($("input[name='services']:checked"), function(){            
                favorite.push($(this).val());
            });
            
             var data = $(this).attr('data');        
            $('.order_id').attr('value',data); 
            $('.service_id').attr('value',favorite.join(","));
            $("#bookingModal").modal('show');
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

.modal {
}
.vertical-alignment-helper {
    display:table;
    height: 100%;
    width: 100%;
}
.vertical-align-center {
    /* To center vertically */
    display: table-cell;
    vertical-align: middle;
}
.modal-content {
    /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
    width:inherit;
    height:inherit;
    /* To center horizontally */
    margin: 0 auto;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/bookings/index.blade.php ENDPATH**/ ?>