<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">


  
</head>

<body>
    <?php 

       $data = Helper::get_service_details($orderid);
       $services2 = Helper::get_pack_details($orderid);

        $order_id = "";
          $name = "";
          $email = "";
          $phone = "";
          $service_name = "";
          $date = "";
          $time = "";
          $quantity = "";
          $order_date = "";
          $amount = "";
          $price = 0;
          $tax_amount = 0;
          $alias = "";
          $option_name = "";
          $payment_method = "";
       if (count($data)==0) {
         foreach ($services2 as $key => $value) {
           $order_id = $value->order_id;
          $name = $value->name;
          $email = $value->email;
          $phone = $value->phone;
          $date = $value->date;
          $time = $value->time;
          $quantity = $value->quantity;
          $order_date = $value->created_at;
          $amount = $value->amount;
          $price += $value->price;
          $tax_amount += $value->tax;
          $refund = $value->refund;
          $payment_method = $value->payment_method;
           $is_coupon_applied = $value->is_coupon_applied;
          $coupon_id = $value->coupon_id;
          $discountamount = $value->discountamount;

      }
       }else {
         foreach ($data as $key => $value) {
          $order_id = $value->order_id;
          $name = $value->name;
          $email = $value->email;
          $phone = $value->phone;
          $service_name = $value->service_name;
          $date = $value->date;
          $time = $value->time;
          $quantity = $value->quantity;
          $order_date = $value->created_at;
          $amount = $value->amount;
          $price += $value->price;
          $tax_amount += $value->tax;
          $alias = $value->alias;
          $option_name = $value->option_name;
          $refund = $value->refund;
          $payment_method = $value->payment_method;
          $is_coupon_applied = $value->is_coupon_applied;
          $coupon_id = $value->coupon_id;
          $discountamount = $value->discountamount;


      }
       }

     
     
   
    ?>
    <div id="invoice" class="container">
        <div class="row mb-5">
            <table style="width: 100%">
                <tr>
                    <td> <div class="col-md-7">
                <img src="<?php echo e(asset('public/images/logo.png')); ?>" style="width: 200px;">
                <h2 class="mt-4">INVOICE</h2>
                <p>Invoice Number: <?= $orderid ?></p>
            </div></td>
                    <td><div class="col-md-5">
                <p><strong>BHASIN INFOTECH AND INFRASTRUCTURE PRIVATE LIMITED</strong></p>
                <p>SH 3 Site IV, Suraj Pur Industrial Area Kasna, Greater</p>
                <p>Noida, Gautam Buddha Nagar, Uttar Pradesh-201301, India</p>
                <p>GSTIN: 09AACCB9344D1ZQ , Call: 8860 666 666</p>
            </div></td>
                </tr>
            </table>
           
            
        </div>
        <hr>
        <div class="row">
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%;"><div class="col-md-7">
                <p><strong>Bill To</strong></p>
                <p><?= $name ?></p>
                <p><?= $phone ?></p>
                <p><?php 
                   if ($email!="null@null.com") {
                     echo $email;
                   }
                  ?></p>
            </div></td>
                    <td> <div class="col-md-7">
                <p><strong>Details</strong></p>
                <p>Invoice Number: <?= $orderid ?></p>
                <p>Invoice Date: <?= date('d F Y, h:i A', strtotime($order_date)) ?></p>
                <?php if($refund=="yes"): ?>
                  <p>Status: Refunded</p>
                <?php endif; ?>
                
            </div></td>
                </tr>
            </table>
            
           
        </div>
        <div class="row">          
            <div class="col-md-12">
              <?php
                  $mprice = 0;
                  $mtax  = 0;
               ?>
                <p><strong>Product Details</strong></p>
                <table style="width: 100%">
                  <?php foreach ($data as $key => $value): ?>
                  <tr style="padding: 10px;">
                    <td style="padding: 10px;"> <span style="text-transform: uppercase;font-weight: bold;"><?= $value->service_name ?>: </span> (Arrival Date:  <?php
                      list($a, $b, $c) = explode('-', $value->date);
                      $ndate = $b.'-'.$a.'-'.$c;
                     echo date('d F Y',strtotime($value->date)); ?>, 
                Arrival Time: <?= $value->time ?>, 
                  <?php 

                     $mprice += $value->price;
                     $mtax += $value->tax;
                ?>
                <?php if($alias=="gondola"): ?>
                Canal: <?= $value->option_name ?>,
              
                <?php endif; ?>
                Quantity: <?= $value->quantity ?>)  </td>                
                  </tr>
                <?php endforeach; ?>
                
                <?php foreach ($services2 as $key => $value): ?>
                  <tr style="padding: 10px;">
                    <td  style="padding: 10px;">  <span style="text-transform: uppercase;font-weight: bold;"><?= $value->pack_name ?>: </span> (Arrival Date:  <?php
                      list($a, $b, $c) = explode('-', $value->date);
                      $ndate = $b.'-'.$a.'-'.$c;
                     echo date('d F Y',strtotime($value->date)); ?>, 
                Arrival Time: <?= $value->time ?>,
                  <?php 

                   $mprice += $value->price;
                      $mtax += $value->tax;
                    
                ?>
                    <?php if($alias=="gondola"): ?>
                Canal: <?= $value->option_name ?>, 
                <?php endif; ?>
                 <?php if($value->occasion_type!=0): ?>
                 <?= $value->type ?> - <?= $value->cuisine ?>,
                <?php endif; ?>
                Quantity: <?= $value->quantity ?>)</td>
                    
                  </tr>
                <?php endforeach; ?>
                </table>
              
                
                <p>.........................................................................................................</p>
                 <p class="mt-2"><strong>Subtotal: </strong> <span class="price">Rs <?= $mprice ?></span></p>
                
                <p><strong>GST: </strong> <span class="price"> Rs <?= $mtax ?></span></p>
                 <?php if($is_coupon_applied=="yes"): ?>
                <p><strong>Coupon: </strong> <span class="price"> Rs -<?= $discountamount ?> (<?= Helper::get_coupon_name($coupon_id) ?>)</span></p>

              <?php endif; ?>
                <p>.........................................................................................................</p>
                <p class="my-4"><strong>Total In INR</strong> <span class="price total-price">Rs <?= $amount ?></span> 
                  <?php 
            if ($payment_method=="instamojo") {
             echo "EC(Instamojo)";
            }else if($payment_method=="cash") {
              echo "POS(Cash)";

            }else if($payment_method=="card") {
              echo "POS(CARD)";

            } else if($payment_method=="paytm_qr") {
              echo "POS(Paytm QR)";

            }else if($payment_method=="wallet") {
              echo "(GV Pay)";

            }   
            ?></p>
                
               
           
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <ul>
                  <li>All sales final, no returns.</li>
                  <li>All disputes are subject to Delhi Courts.</li>
                  <li>For queries, contact at info@veniceindia.com or call 8860 666 666</li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/invoice.blade.php ENDPATH**/ ?>