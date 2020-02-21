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
         
      foreach ($data as $key => $value) {
          $order_id = $value['order_id'];
          $name = $value['name'];
          $email = $value['email'];
          $phone = $value['phone'];
          $service_name = $value['event_name'];
          $date = $value['date'];
          $time = $value['time'];
          $quantity = $value['quantity'];
          $order_date = $value['created_at'];
          $amount = $value['amount'];
          $price += $value['price'];
          $tax_amount += $value['tax'];
         
          
      }


   
    ?>
    <table style="width: 800px;margin: 0 auto;border:solid 1px #ccc;padding:10px;">
      <tr>
        <td style="padding:10px;"> <div id="invoice" class="container">
        <div class="row mb-5">
            <table style="width: 100%">
                <tr>
                    <td style="padding:10px;"> <div class="col-md-7">
                <img src="{{ asset('public/images/logo.png') }}" style="width: 200px;">
                <h2 class="mt-4">INVOICE</h2>
                <p>Invoice Number: <?= $order_id ?></p>
            </div></td>
                    <td><div class="col-md-5">
                <p><strong>BHASIN INFOTECH AND INFRASTRUCTURE PRIVATE LIMITED</strong></p>
                <p>SH 3 Site IV, Suraj Pur Industrial Area Kasna, Greater</p>
                <p>Noida, Gautam Buddha Nagar, Uttar Pradesh-201301, India</p>
                <p>GSTIN: 09AACCB9344D1ZQ</p>
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
                <p><?= $email ?></p>
            </div></td>
                    <td> <div class="col-md-7">
                <p><strong>Details</strong></p>
                <p>Invoice Number: <?= $order_id ?></p>
                <p>Invoice Date: <?= date('d F Y, h:i A', strtotime($order_date)) ?></p>
                
            </div></td>
                </tr>
            </table>
            
           
        </div>
        <div class="row mt-4 mb-5">
           
            <div class="col-md-5">


                <p><strong>Product Details</strong></p>
                <table style="width: 100%">
                  <?php foreach ($data as $key => $value): ?>
                  <tr style="padding-top: 20px;">
                    <td style="width: 50%;">  <h4><span style="text-transform: uppercase;"><?= $value['event_name'] ?></span></h4>
                    </td>
                    <td>Day:  <?php
                  
                     echo date('d F Y',strtotime($value['date'])); ?><br />
                Arrival Time: <?= $value['time'] ?><br />
               
                Quantity: <?= $value['quantity'] ?><br /></td>
                    
                  </tr>
                <?php endforeach; ?>
                </table>
              
                
                <p>.........................................................................................................</p>
                 <p class="mt-2"><strong>Subtotal: </strong> <span class="price">Rs <?= $price ?></span></p>
                <p><strong>GST: </strong> <span class="price"> Rs <?= $tax_amount ?></span></p>
                <p>.........................................................................................................</p>
                <p class="my-4" style="font-size: 18px;"><strong>Total: </strong> <span class="price total-price">Rs <?= $amount ?></span></p>
                
               
           
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <ul>
                  <li>All sales final, no returns.</li>
                  <li>All disputes are subject to Delhi Courts.</li>
                  <li>For query, write to booking@veniceindia.com</li>
                </ul>
            </div>
        </div>
    </div></td>
      </tr>
    </table>
   
</body>

</html>