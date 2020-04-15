 


<?php $__env->startSection('title'); ?>
Food Card Topup
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="main-content style2"> 
<div class="breadcrumbs">
  <ul>
    <li><a href="#/" title="">Home</a></li>
    <li><a href="#/pages/portfolio" title="">Food Card Topup</a></li>
  </ul>
</div>

<div class="heading-sec">
  <div class="row">
    <div class="col-md-4 column">
      <div class="heading-profile">
        <h2>Food Card Topups</h2>

      </div>
    </div>
    <div class="col-md-8 column">
      <div class="top-bar-chart">
        <div class="quick-report">
          <div class="quick-report-infos">

          </div>
          <span class="bar2"><a href="<?= URL::to('admin/food_card/refund/todays') ?>"><button class="btn btn-primary">Refund Queue</button></a></span>
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
    <form action="<?php echo e(URL::to('admin/food_card_topup/add')); ?>" method="post">
      <?php echo csrf_field(); ?>
    

    <div class="col-md-12">
      <div class="widget">
        <div class="product-filter">

          <div class="row">
            <div class="col-md-12" style="margin-left: 20px;margin-bottom: 20px;">
              <h4>Please enter the customer details!</h4>
            </div>
            
            <div class="col-md-12">
                <div class="col-md-6" >
                   <div class="form-group">
                    <label>Mobile No<span style="color: red;">*</span></label>
                    <input type="text" class="form-control phone" name="phone" placeholder="" required="required">
                    <input type="hidden" name="finalamount" value="0" class="finalamount">
                    <input type="hidden" name="extraamount" value="0" class="extraamount">
                   </div>
                   

                   <div class="form-group">
                    <label>Amount<span style="color: red;">*</span></label>
                    <input type="text" class="form-control amount mainam" name="amount" placeholder="Amount" required="required">
                  
                   </div>
                     <div class="form-group">
                   <ul class="recharge-denomination">
                   <?php foreach($denominations as $key => $value): ?>
                      <?php if($key==0): ?>
        <li class="selected" data="<?= $value->pricing ?>">+ <i class="fa fa-rupee"></i> <?= $value->pricing ?></li>
        <?php else: ?>
        <li data="<?= $value->pricing ?>">+ <i class="fa fa-rupee"></i> <?= $value->pricing ?></li>
        <?php endif; ?>
                   <?php endforeach; ?>
                  </ul>
                   </div>
                   
                    </div>
                    <div class="col-md-6">
                       <div class="form-group">
                        <label>Name<span style="color: red;">*</span></label>
                    <input type="text" class="form-control name" name="name" required="required" placeholder="Name">
                   </div>
                      <div class="form-group">
                   <label>Email</label>
                    <input type="text" class="form-control email" name="email" placeholder="Email">
                   </div>
                      <div class="form-group">
                   
                    <span class="currentbalance"></span>
                   </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" style="clear: both;">
                    <input type="submit" class="btn btn-primary checkoutbtn" name="submit" value="Top-up">
                   </div>
                      
                    </div>
                
            </div>
        
          
        
          </div>
           
 
          
        </div>
        <div class="col-md-4" style="text-align: center;padding-bottom: 20px; display: none;">
         <a href="<?= URL::to('admin/recharge/all/cash') ?>" target="_blank"> <h3>Total Food Card Sale</h3>
          <h3><i class="fa fa-rupee"></i> <span style="text-decoration: underline;"><?= Helper::get_recharg_history('all') ?></span></h3></a>
        </div>
         <div class="col-md-4" style="text-align: center;padding-bottom: 20px; display: none;">
         <a href="<?= URL::to('admin/recharge/monthly/cash') ?>" target="_blank">  <h3>POS  Food Card This Month</h3>
          <h3><i class="fa fa-rupee"></i> <span style="text-decoration: underline;"><?= Helper::get_recharg_history('monthly') ?></span></h3></a>
        </div>
         <div class="col-md-4" style="text-align: center;padding-bottom: 20px; display: none;">
         <a href="<?= URL::to('admin/recharge/todays/cash') ?>" target="_blank">  <h3>POS  Food Card Today</h3>
           <h3><i class="fa fa-rupee"></i> <span style="text-decoration: underline;"><?= Helper::get_recharg_history('todays') ?></span></h3></a>
        </div>
        
      </div>
    </div>
    </form>
  </div>
</div><!-- Panel Content -->
</div>

<script type="text/javascript">
  $(document).ready(function() {

    $(".phone").on('keyup', function() {
         var phone = $(this).val();
         if (phone.length==10) {
          var url = "<?= URL::to('admin/checkuser') ?>/"+phone;
            $.get(url, function( result ) {

              if (result.length != 0) {
                 $(".name").attr('value',result[0]['name']);
             $(".email").attr('value',result[0]['email']);
             $(".currentbalance").html("<strong>Current Balance: Rs."+result[0]['food_card']+"</strong>");
           }else {
             $(".name").attr('value','');
             $(".email").attr('value','');
           }
           
            
        });
         }
         
    });
    
       $('.amount').keyup(function() {
        var data = $(this).val();
       
        if ($(this).val()=="") {
          var data = 0;
        }

        var url = "<?= URL::to('api/get_denom_percent/"+data+"') ?>";
    var percent = 0;
    $.get(url, function( result ) {
            
            var extra = Math.round(data * percent/100);
    var finalamount = Math.round(parseFloat(data) + parseFloat(extra));
    
     $('.finalamount').attr('value',finalamount);
     $('.extraamount').attr('value',extra);
     $('.finalam').html('Final Amount: '+finalamount+" ("+percent+"% Extra)");

        });
        
      });
       $(".checkoutbtn").click(function() {
           if ($('.amount').val() < 100) {
             alert("A minimum recharge of INR 500 need to be done");
             return false;
           }else if ($('.amount').val() > 10000) {
              alert("A maximum recharge limit is INR 10000");
             return false;
           }else {
            return true;
           }
           return false;
       });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var data = $('ul.recharge-denomination li.selected').attr('data');
    var url = "<?= URL::to('api/get_denom_percent/"+data+"') ?>";
    var percent = 0;
    $.get(url, function( result ) {
      
    $('.ramount').attr('value', data);
    var extra = Math.round(data * percent/100);
    var finalamount = Math.round(parseFloat(data) + parseFloat(extra));
     $('.mainam').attr('value',data);
     $('.finalamount').attr('value',finalamount);
     $('.extraamount').attr('value',extra);
     $('.finalam').html('Final Amount: '+finalamount+" ("+percent+"% Extra)");
        });
        
      $('ul.recharge-denomination li').click(function() {
        var data = $(this).attr('data');
        $('ul.recharge-denomination li').removeClass('selected');
        $(this).addClass('selected');
        var url = "<?= URL::to('api/get_denom_percent/"+data+"') ?>";
    var percent = 0;
    $.get(url, function( result ) {
        
        $('.ramount').attr('value', data);
        var extra = Math.round(data * percent/100);
        var finalamount = Math.round(parseFloat(data) + parseFloat(extra));
        $('.finalamount').attr('value',finalamount);
        $('.extraamount').attr('value',extra);
        $('.mainam').val(data);
        $('.finalam').html('Final Amount: '+finalamount+" ("+percent+"% Extra)");
     });
      });
       $('.ramount').keyup(function() {
        var data = $(this).val();
        if ($(this).val()=="") {
          var data = 0;
        }
        var url = "<?= URL::to('api/get_denom_percent/"+data+"') ?>";
         var percent = 0;
    $.get(url, function( result ) {
      percent = result;
        var extra = data * percent/100;
    var finalamount = parseFloat(data) + parseFloat(extra);
     $('.finalamount').html(finalamount);
     $('.mainamount').html(data);
     $('.extraamount').html(extra);
     $('.mainam').attr('value',data);
     $('.extram').attr('value',extra);
    });
      });
       $(".checkoutbtn").click(function() {
           if ($('.ramount').val() < 100) {
             $('#snackbar').stop().fadeIn(400).delay(3000).fadeOut(400);
             $("#snackbar").html("A minimum recharge of INR 500 need to be done");
             return false;
           }else if ($('.ramount').val() > 10000) {
             $('#snackbar').stop().fadeIn(400).delay(3000).fadeOut(400);
             $("#snackbar").html("A maximum recharge limit is INR 10000");
             return false;
           }else {
            return true;
           }
           return false;
       });
  });
</script>
<style type="text/css">
  ul.recharge-denomination {
    list-style: none;
    margin-top: 20px;
    padding: 0px;
}
ul.recharge-denomination li.selected {
    color: #EF9E11;
    border: solid 1px #EF9E11;
}
ul.recharge-denomination li {
    font-size: 16px;
    border: solid 1px #999;
    border-radius: 5px;
    color: #999;
    float: left;
    width: 85px;
    height: 35px;
    text-align: center;
    margin-right: 20px;
    margin-bottom: 20px;
    padding-top: 5px;
    padding-bottom: 5px;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/cash/foodcardtopup.blade.php ENDPATH**/ ?>