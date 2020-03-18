@extends('layouts.main2')

@section('title')
Order History
@endsection

@section('content')

<?php 
$segment = Request::segment(2);

?>
 <section id="hero_login" class="cartarea">
        <div class="hero-container">
            <div class="row" style="width: 100%;">
                <div class="col-md-2 col-12"></div>
                <div class="col-md-8 col-12 my-profile">
                    <div class="head row">
                        <div class="col-md-6" style="padding: 10px;padding-left: 40px;padding-top: 20px;">
                            <h3>Order History</h3>
                        </div>
                        <div class="col-md-6" style="display: none;">
                            <a href="my-profile.html" class="btn pull-right">My Profile</a>
                            <a href="order-history.html" class="pull-right btn btn_active">Order History</a>
                        </div>
                    </div>
                    <hr />
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item active">
                            <label>Category:</label>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link <?php if($segment=="all") { echo 'active'; } ?>" href="<?= URL::to('history/all') ?>">All</a>
                        </li>

                        <?php foreach($categories as $key => $value): ?>
                            <li class="nav-item">
                            <a class="nav-link <?php if($segment==$value->alias) { echo 'active'; } ?>" href="<?= URL::to('history/'.$value->alias) ?>"><?= $value->category_name ?></a>
                        </li>

                        <?php endforeach; ?>
                        <li class="nav-item active">
                            <a class="nav-link <?php if($segment=="packs") { echo 'active'; } ?>" href="<?= URL::to('history/packs') ?>">Combo Packs</a>
                        </li>
                         <li class="nav-item active">
                            <a class="nav-link <?php if($segment=="events") { echo 'active'; } ?>" href="<?= URL::to('history/events') ?>">Events</a>
                        </li>
                         <li class="nav-item" id="tab02">
                            <a class="nav-link" id="" href="<?= URL::to('profile') ?>">My Profile</a>
                        </li>
                       
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane container active " id="tab11">
                          <div class="table-responsive">
                            <table id="order-table" class="mt-4 table">
                                <thead></thead>
                                <tbody>
                                    <?php if(count($bookings) != 0): ?>
                                      <?php if($type=="events"): ?>

                                        <!-- Event History -->
                                           <?php foreach($bookings as $key => $value): ?>
                                    <tr>
                                        <td style="width: 30%;">
                                            <div class="ride">
                                                <?php if($value->status=="success"): ?>
                                                <img src="{{ asset('public/images/Green-Symbol.jpg') }}">
                                                <?php else: ?>
                                                    <img src="{{ asset('public/images/Red-Symbol.jpg') }}">
                                                <?php endif; ?>
                                                <h4><strong><?= $value->order_id ?></strong></h4>
                                               <strong> <?php 
                                                 $packs = Helper::get_pack_details($value->order_id);
                                            
                                                 
                                                  
                                               ?></strong>

                                                <div class="clearfix"></div>
                                                <p><span class="text-muted">Booked on:</span> <strong><?= date('d M Y, h:i A', strtotime($value->updated_at)) ?></strong></p>
                                                
                                                
                                            </div>
                                            <div>


                                            </div>
                                            <div class="clearfix"></div>
                                        </td>
                                        <td>
                                            
                                            <p>
                                                <?php 
                                                   $events = Helper::get_event_details($value->order_id);
                                                    foreach ($events as $key => $value) {
                                                       echo '<strong>Event Name:</strong> '.$value->event_name."<br />";
                                                       echo '<strong>Event Time:</strong> '.$value->time."<br />";
                                                       echo '<strong>Event Date:</strong> ';
                                                       list($a, $b, $c) = explode('-', $value->date); 
                                                       $newdate = $b."-".$a."-".$c;
                                                       echo date('d F Y', strtotime($value->date));
                                                       echo "<br /><br />";
                                                   }

                                                ?>




                                            </p>
                                            
                                        </td>
                                       
                                        <td style="width: 25%;">
                                            <div class="price-box">
                                                <p class=""><strong>&#x20B9; <?= $value->amount ?></strong></p>
                                            </div>
                                            <a href="<?= URL::to('event_invoice/'.Crypt::encrypt($value->order_id)) ?>"><button type="button" class="btn-invoice" style="cursor: pointer;">Download Invoice</button></a>
                                            <br />
                                            <br />
                                            <h5 style="text-align: center;text-transform: uppercase;color: red;">
                                              <?php if($value->payment_method=="instamojo"): ?>
                                              EC(Instamojo)
                                              <?php elseif($value->payment_method=="cash"): ?>
                                              POS(Cash)
                                               <?php elseif($value->payment_method=="card"): ?>
                                              POS(CARD)
                                                 <?php elseif($value->payment_method=="paytm_qr"): ?>
                                              POS(Paytm QR)


                                            <?php endif; ?>
                                                
                                              </h5>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                              <?php elseif($type=="packs"): ?>


                                <!-- Else History -->
                                          <?php foreach($bookings as $key => $value): ?>
                                    <tr>
                                        <td style="width: 30%;">
                                            <div class="ride">
                                                <?php if($value->status=="success"): ?>
                                                <img src="{{ asset('public/images/Green-Symbol.jpg') }}">
                                                <?php else: ?>
                                                    <img src="{{ asset('public/images/Red-Symbol.jpg') }}">
                                                <?php endif; ?>
                                                <h4><strong><?= $value->order_id ?></strong></h4>
                                               <strong> <?php 
                                                 $packs = Helper::get_pack_details($value->order_id);
                                                 if (count($packs) != 0) {
                                                  foreach ($packs as $key => $value) {
                                                   $pack_name = $value->pack_name;
                                                 }
                                                 echo $pack_name;
                                                 }
                                                 
                                                  
                                               ?></strong>

                                                <div class="clearfix"></div>
                                                <p><span class="text-muted">Booked on:</span> <strong><?= date('d M Y, h:i A', strtotime($value->updated_at)) ?></strong></p>
                                                Refunded
                                            </div>
                                            <div>


                                            </div>
                                            <div class="clearfix"></div>
                                        </td>
                                        <td>
                                            
                                            <p>
                                              
                                                 <?php 
                                                   $services2 = Helper::get_pack_details($value->order_id);
                                                  
                                                   foreach ($services2 as $key => $value) {
                                                       echo '<strong>Pack Name:</strong> '.$value->pack_name;
                                                       $type = $value->pack_type;
                                                        if ($type=="occasional") {
                                                          $occasion_type = $value->occasion_type;
                                                          echo "<br /><strong>Cuisine: </strong>".Helper::get_occassion_type($occasion_type);

                                                        }
                                                        echo "<br />";
                                                       
                                                       echo '<strong>Arrival Time:</strong> '.$value->time."<br />";
                                                       echo '<strong>Arrival Date:</strong> ';
                                                       list($a, $b, $c) = explode('-', $value->date); 
                                                       $newdate = $b."-".$a."-".$c;
                                                       echo date('d F Y', strtotime($value->date))."<br />";
                                                         echo '<strong>Quantity:</strong> '.$value->quantity."<br />";
                                                       echo "<br />";
                                                   }

                                                ?>

                                            </p>

                                            
                                        </td>
                                        <td>
                                             <p>
                                                <?php 
                                                   
                                                   foreach ($services2 as $key => $value) {
                                                       echo '<div style="height:50px;"><p class="text-muted">Check-in Time</p>';
                                                       if ($value->checkin_time=="0000-00-00 00:00:00") {
                                                          echo '<p><strong>-----</strong></p><br />';           
                                                       }else {
                                                        echo '<p><strong>'.$value->checkin_time.'</strong></p></div><br />';           
                                                       }
                                                                                                
                                                   }

                                                ?>

                                            </p>
                                           
                                        </td>
                                        <td>
                                          
                                            
                                            
                                          
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="price-box">
                                                <p class=""><strong>&#x20B9; <?= $value->amount ?></strong></p>
                                            </div>
                                            <a href="<?= URL::to('invoice/'.Crypt::encrypt($value->order_id)) ?>"><button type="button" class="btn-invoice" style="cursor: pointer;">Download Invoice</button></a>
                                            <br />
                                            <br />
                                            <h5 style="text-align: center;text-transform: uppercase;color: red;">
                                              <?php if($value->payment_method=="instamojo"): ?>
                                              EC(Instamojo)
                                              <?php elseif($value->payment_method=="cash"): ?>
                                              POS(Cash)
                                               <?php elseif($value->payment_method=="card"): ?>
                                              POS(CARD)
                                                 <?php elseif($value->payment_method=="paytm_qr"): ?>
                                              POS(Paytm QR)


                                            <?php endif; ?>
                                                
                                              </h5>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                


                                        <?php else: ?>
                                          <!-- Else History -->
                                          <?php foreach($bookings as $key => $value): ?>
                                    <tr>
                                        <td style="width: 30%;">
                                            <div class="ride">
                                                <?php if($value->status=="success"): ?>
                                                <img src="{{ asset('public/images/Green-Symbol.jpg') }}">
                                                <?php else: ?>
                                                    <img src="{{ asset('public/images/Red-Symbol.jpg') }}">
                                                <?php endif; ?>
                                                <h4><strong><?= $value->order_id ?></strong></h4>
                                               <strong> <?php 
                                                 $packs = Helper::get_pack_details($value->order_id);
                                                 if (count($packs) != 0) {
                                                  foreach ($packs as $key => $value) {
                                                   $pack_name = $value->pack_name;
                                                 }
                                                 echo $pack_name;
                                                 }
                                                 
                                                  
                                               ?></strong>

                                                <div class="clearfix"></div>
                                                <p><span class="text-muted">Booked on:</span> <strong><?= date('d M Y, h:i A', strtotime($value->updated_at)) ?></strong></p>
                                                
                                            </div>
                                            <?php if($value->refund=="yes"): ?>
                                           <div class="col-md-12" style="text-align: center;margin-top: 10px;color:red;">(Refunded)</div>
                                           <?php endif; ?> 
                                            <div>


                                            </div>
                                            <div class="clearfix"></div>
                                        </td>
                                        <td>
                                            
                                            <p>
                                                <?php 
                                                   $services = Helper::get_order_items($value->order_id);
                                                   foreach ($services as $key => $value) {
                                                       echo '<strong>Service:</strong> '.$value->service_name."<br />";
                                                      
                                                       echo '<strong>Arrival Date:</strong> ';
                                                       list($a, $b, $c) = explode('-', $value->date); 
                                                       $newdate = $b."-".$a."-".$c;
                                                       echo date('d F Y', strtotime($value->date))."<br />";
                                                        echo '<strong>Arrival Time:</strong> '.$value->time."<br />";
                                                        echo '<strong>Quantity:</strong> '.$value->quantity."<br />";
                                                       echo "<br />";
                                                   }

                                                ?>
                                                 <?php 
                                                   $services2 = Helper::get_pack_details($value->order_id);
                                                  
                                                   foreach ($services2 as $key => $value) {
                                                       echo '<strong>Pack Name:</strong> '.$value->pack_name;
                                                       $type = $value->pack_type;
                                                        if ($type=="occasional") {
                                                          $occasion_type = $value->occasion_type;
                                                          echo "<br /><strong>Cuisine: </strong>".Helper::get_occassion_type($occasion_type);

                                                        }
                                                        echo "<br />";
                                                       
                                                      
                                                       echo '<strong>Arrival Date:</strong> ';
                                                       list($a, $b, $c) = explode('-', $value->date); 
                                                       $newdate = $b."-".$a."-".$c;
                                                      echo date('d F Y', strtotime($value->date))."<br />";
                                                       echo '<strong>Arrival Time:</strong> '.$value->time."<br />";
                                                         echo '<strong>Quantity:</strong> '.$value->quantity."<br />";
                                                        
                                                       echo "<br />";
                                                   }

                                                ?>

                                            </p>

                                            
                                        </td>
                                        <td>
                                             <p>
                                                <?php 
                                                   
                                                   foreach ($services as $key => $value) {
                                                       echo '<div style="height:50px;"><p class="text-muted">Check-in Time</p>';
                                                       if ($value->checkin_time=="0000-00-00 00:00:00") {
                                                          echo '<p><strong>-----</strong></p><br />';           
                                                       }else {
                                                        echo '<p><strong>'.$value->checkin_time.'</strong></p></div><br />';           
                                                       }
                                                                                                
                                                   }

                                                ?>

                                            </p>
                                           
                                        </td>
                                        <td>
                                            <?php 
                                                  
                                                   foreach ($services as $key => $value) {
                                                       echo '<div style="height:60px;"><p class="text-muted">Canal</p>';
                                                       if ($value->optional != NULL) {
                                                           echo '<p><strong>'.$value->option_name.'</strong></p><br />';
                                                       }else {
                                                        echo '<p><strong>N/A</strong></p><br />';
                                                       }
                                                       echo '</div>';
                                                                                                           
                                                   }

                                                ?>
                                            
                                            
                                          
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="price-box">
                                                <p class=""><strong>&#x20B9; <?= $value->amount ?></strong></p>
                                            </div>
                                            <a href="<?= URL::to('invoice/'.Crypt::encrypt($value->order_id)) ?>"><button type="button" class="btn-invoice" style="cursor: pointer;">Download Invoice</button></a>
                                            <br />
                                            <br />
                                            <h5 style="text-align: center;text-transform: uppercase;color: red;">
                                              <?php if($value->payment_method=="instamojo"): ?>
                                              EC(Instamojo)
                                              <?php elseif($value->payment_method=="cash"): ?>
                                              POS(Cash)
                                               <?php elseif($value->payment_method=="card"): ?>
                                              POS(CARD)
                                                 <?php elseif($value->payment_method=="paytm_qr"): ?>
                                              POS(Paytm QR)


                                            <?php endif; ?>
                                                
                                              </h5>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                        <?php endif; ?>
                                   
                                <?php else: ?>
                                    <br />
                                    <h4>No Bookings Found!</h4>
                                <?php endif; ?>
                                </tbody>
                            </table>
                            </div>
                            <div class="paging mt-4">
                             {{ $bookings->links('vendor.pagination.simple-bootstrap-4') }}
                            </div>
                        </div>
                        <div class="tab-pane container" id="tab22">
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-12"></div>
            </div>
        </div>
    </section><!-- #hero -->
    <main id="main">

<div class="modal fade" id="bookingModal" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <label>Oops</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>
          <div class="modal-body">
            <div class="content"></div>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
<style type="text/css">
#hero {
  width: 100%;
  height: 100vh;
  background: url(<?= asset('public/images/dashboard.jpg') ?>) no-repeat top center;
  background-size: contain;
  position: relative;
}
.timepicker {
        padding: .375rem .75rem !important;
}
#price {
    font-size:24px;
    font-weight: bold;
    line-height: 3 !important;
    color: #000;
    text-align: center;
}
    .loader {
    display: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8) url({{ asset('public/images/loader2.gif')  }}) center center no-repeat;
    z-index: 1000;
}
    .loader {
    display: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8) url({{ asset('public/images/loader2.gif')  }}) center center no-repeat;
    z-index: 1000;
}
.remove {
  cursor: pointer;
}
@media (max-width: 425px){
.tab-content {
    border-top: 1px solid #EF9E11 !important;
    padding: 0px;
}
}
</style>

    <script>
     $(document).ready(function() {
        $('#pincode-input1').pincodeInput({
            hidedigits: false,
            complete: function(value, e, errorElement) {
              

               $(".pinno").attr('value',value);


            }
        });
    });
    </script>

@endsection