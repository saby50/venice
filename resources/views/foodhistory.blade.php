@extends('layouts.main2')

@section('title')
Order Details
@endsection

@section('content')
<?php 
$created_at = ""; $payment_method = ""; $refund = "";
$amount = 0; $nprice = 0; $nquantity = 0; $subtotal = 0;
foreach ($data as $key => $value) {
  $created_at = $value->created_at;
  $payment_method = $value->payment_method;
  $amount = $value->amount;
  $refund = $value->refund;
}

?>
<div class="recyclerview firstbox" style="padding: 40px;margin-top: 40px;">
<div class="row">
    <div class="col-12 recent">
      Order Details<br />
    </div>
    <div class="details ">
      <div class="row">
        
      
      <div class="col-6 left">
       <div class="cirlce pink"></div> Order No.
      </div>
      <div class="col-6 right">
        <?= $getid ?>
      </div>
      <div class="col-6 left">
      <div class="cirlce green"></div> Payment
      </div>
      <div class="col-6 right">
        <?= ucfirst($payment_method) ?>
      </div>
       <div class="col-6 left">
      <div class="cirlce skyblue"></div>  Time
      </div>
      <div class="col-6 right">
        <?= date('M d, h:i A', strtotime($created_at)) ?>
      </div>
    </div>
    </div>
    <div class="details">
      <div class="row">
      <div class="col-12 left">
    <div style="display: inline-block;margin-right: 20px;margin-bottom: 20px;"><img src="{{ asset('public/images/profile.jpg') }}" width="40px" style="margin-top: -30px;"></div><div style="display: inline-block;padding-top: 10px;margin-bottom: 20px;">Order Total<br />
      <h5 style="color: #ef9e17;display: inline;"><i class="fa fa-rupee"></i> <?= $amount ?><?php if($value->refund=="yes"): ?>
          <span style="color: red;font-size: 13px;">(Refunded)</span>
        <?php endif; ?></h5> </div>
      </div>
      <?php

      $db = DB::table('food_orders')->where('order_id',$getid)->get();
           
           
    ?>
     <?php foreach ($db as $m => $n): ?>
       <div class="col-6 left">
        <?php 
        $food_details = Helper::get_menu_item_details($n->item_id);
        foreach ($food_details as $k => $v): ?>
        <?= $v->item_name ?><br />
       <?= $n->quantity ?> x <?php 
       echo $price = $v->price;

       $nprice = $price * $n->quantity;
       $nquantity+= $n->quantity;
       $subtotal+= $nprice;
        

        ?>
      <?php endforeach; ?>
      </div>
      <div class="col-6 right">
        <i class="fa fa-rupee"></i>  <?= $nprice ?>
      </div>
       <div class="col-11" style="height: 1px;border-bottom: dashed 1px #ccc;margin: 0 auto;margin-bottom: 10px;"></div>
    <?php endforeach; ?>
   
    <div class="col-6 left">
      Total Items
    </div>
     <div class="col-6 right">
      <?= $nquantity ?>
    </div>
    <div class="col-6 left">
      Sub-Total
    </div>
     <div class="col-6 right">
     <i class="fa fa-rupee"></i> 
     <?php if($refund=="yes"): ?>
      0
     <?php endif ?>
      <?= $subtotal ?>
     <?php endif; ?>
     
    </div>
    <div class="col-6 left">
     GST(18%)
    </div>
     <div class="col-6 right">
     <i class="fa fa-rupee"></i>
     <?php if($refund=="yes"): ?>
      0
     <?php endif ?>
      <?= $amount - $subtotal ?>
     <?php endif; ?> 
    </div>
    </div>
    </div>
  </div>
</div>
@endsection