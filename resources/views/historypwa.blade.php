@extends('layouts.main2')

@section('title')
Order History
@endsection

@section('content')
<div class="recyclerview firstbox">
  <div class="row">
      <div class="col-12 ">
        <nav>
          <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Services</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Food</a>
          
          </div>
        </nav>
        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="row">
    <?php if(count($bookings) != 0): ?>
    <?php foreach($bookings as $key => $value): ?>
     
      <div class="col-12 gv-history2">
      <div class="row">
      <div class="col-6">
        <strong class="history-title"><?= $value->order_id ?></strong>
      </div>
      <div class="col-6" style="text-align: right;">
      <span class="date"> <?= date('M d, h:i A', strtotime($value->created_at)) ?></span>
      </div>
      </div>
      <div class="row">
      <div class="col-12">
        <span class="history-subtitle"><?php 
          $service = Helper::get_service_details($value->order_id);
          $sv = "";
          foreach ($service as $key => $value) {
            $sv .= $value->quantity." ".$value->service_name." | ";
          }
          
          $packs = Helper::get_pack_details($value->order_id);
          foreach ($packs as $key => $value) {
            $sv .= $value->quantity." ".$value->pack_name." | ";
          }
          echo rtrim($sv,' | ');
        ?></span>
      </div>
      </div>
      <div class="row">
      <div class="col-6"><br /><br />
        <span class="history-price"><i class="fa fa-rupee"></i> <?= $value->amount ?></span>
      </div>
       <div class="col-6" style="text-align: right;"><br /><br />
        <a href="<?= URL::to('history/details/'.Crypt::encrypt($value->order_id)) ?>"><button class="orderDetails btn">View Order Details</button></a>
      </div>
      </div>
      </div>
    <?php endforeach; ?>
    <?php else: ?>
      <br /><br />
      <h5>No Bookings Found</h5>
    <?php endif; ?>
  </div>
          </div>
          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <div class="row">
    <?php if(count($food_history) != 0): ?>
    <?php foreach($food_history as $key => $value): ?>
     
      <div class="col-12 gv-history2">
      <div class="row">
      <div class="col-6">
        <strong class="history-title"><?= $value->order_id ?></strong>
      </div>
      <div class="col-6" style="text-align: right;">
      <span class="date"> <?= date('M d, h:i A', strtotime($value->created_at)) ?></span>
      </div>
      </div>
      <div class="row">
      <div class="col-12">
        <span class="history-subtitle">
          <?php
           $units = Helper::get_unit($value->unit_id);
             echo "<strong>".$units['unit_name']."</strong><br />";
            $db = DB::table('food_orders')->where('order_id',$value->order_id)->get();
            foreach ($db as $m => $n) {
               $food_details = Helper::get_menu_item_details($n->item_id);
            
            foreach ($food_details as $k => $v) {
              echo $value->quantity." x ".$v->item_name."<br />";
            }
            }
           
          ?>
        </span>
      </div>
      </div>
      <div class="row">
      <div class="col-6"><br /><br />
        <span class="history-price"><i class="fa fa-rupee"></i> <?= $value->amount ?></span>
      </div>
       <div class="col-6" style="text-align: right;"><br /><br />
        <a href="<?= URL::to('history/fooddetails/'.Crypt::encrypt($value->order_id)) ?>"><button class="orderDetails btn">View Order Details</button></a>
      </div>
      </div>
      </div>
    <?php endforeach; ?>
    <?php else: ?>
      <br /><br />
      <h5>No Bookings Found</h5>
    <?php endif; ?>
  </div>
          </div>
      
        </div>
      
      </div>
    </div>
</div>
</div>
<style type="text/css">
  .nav-tabs {
    margin-top: 0px !important;
    margin-left: 0px !important;
}
</style>
@endsection