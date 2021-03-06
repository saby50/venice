@extends('multiauth::layouts.main') 


@section('title')
Food Card Topup
@endsection

@section('content')
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
        <h2>Food Card Topup</h2>

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
       @if (session('error'))
        <div class="widget no-color">
            <div class="alert alert-danger">
                <div class="notify-content">
                   {{ session('error') }}!

                </div>
            </div>
            </div>
        </div>
      @endif
      </div>
  <div class="row">

    <form action="{{ URL::to('admin/food_card_topup/add') }}" method="post">
      @csrf
    

    <div class="col-md-12">
      <div class="widget">
        <div class="product-filter2" style="padding: 20px;">

          <div class="row">
            <div class="col-md-12" style="margin-left: 20px;margin-bottom: 20px;">
              <h4>Please enter the customer details!</h4>
            </div>
            
            <div class="col-md-12">
                <div class="col-md-6" >
                   <div class="form-group">
                    <label>Mobile No<span style="color: red;">*</span></label>
                    <input type="text" class="form-control phone" name="phone" maxlength="10" placeholder="" required="required" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
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
           
   <hr />
          
        </div>
        <div class="col-md-4" style="text-align: center;padding-bottom: 20px; ">
         <a href="<?= URL::to('admin/food_card/revenue/all') ?>" target="_blank"> <h3>FC Sale Total</h3>
          <h3><i class="fa fa-rupee"></i> <span style="text-decoration: underline;"><?= Helper::get_fc_topup('all') ?></span></h3></a>
        </div>
         <div class="col-md-4" style="text-align: center;padding-bottom: 20px;">
         <a href="<?= URL::to('admin/food_card/revenue/monthly') ?>" target="_blank">  <h3>FC Sale This Month</h3>
          <h3><i class="fa fa-rupee"></i> <span style="text-decoration: underline;"><?= Helper::get_fc_topup('monthly') ?></span></h3></a>
        </div>
         <div class="col-md-4" style="text-align: center;padding-bottom: 20px; ">
         <a href="<?= URL::to('admin/food_card/revenue/todays') ?>" target="_blank">  <h3> FC Sale Today</h3>
           <h3><i class="fa fa-rupee"></i> <span style="text-decoration: underline;"><?= Helper::get_fc_topup('todays') ?></span></h3></a>
        </div>
        
      </div>
    </div>
    </form>
  </div>
  <div class="row">
    <form action="{{ URL::to('admin/fc_refund') }}" method="post">
      @csrf
    

    <div class="col-md-12">
      <div class="widget">
        <div class="product-filter2" style="padding: 30px;">

          <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
              <h4>Refund Process</h4>
            </div>
            
         
                <div class="col-md-6" >
                 
                    <label>Mobile No<span style="color: red;">*</span></label>
                    <input type="text" class="form-control phone2" name="phone" placeholder="" required="required" maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                
                   
                    </div>
                 
                     
                      <div class="col-md-12" style="margin-top: 20px;">
                   <span class="namelabel"></span>
                   <span class="emailLabel"></span>
                    <span class="currentbalance2"></span>
                    <input type="hidden" name="food_card" class="food_card">
                     <input type="hidden" class="form-control email2" name="email">
                    <input type="hidden" class="form-control name2" name="name" >
                   </div>
                    </div>
                    <div class="col-md-6" style="margin-top: 20px;padding-left: 0px !important;">
                      <div class="form-group" style="clear: both;">
                    <input type="submit" class="btn btn-primary checkoutbtn2" name="submit" value="Request Refund">
                   </div>
                      
                    </div>
               
          </div>
        </div>
      </div>
    </div>
    </form>
  </div>
</div><!-- Panel Content -->
</div><!-- Panel Content -->

<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form action="<?= URL::to('admin/food_card_refund') ?>" method="post">
    @csrf
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verify Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <label>Phone</label>
       <input type="text" name="phone" class="form-control vphone" readonly="readonly">
       <br />
        <label>OTP</label>
       <input type="text" name="otp" class="form-control" required="required" maxlength="6" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
       <input type="hidden" name="order_id" value="" class="order_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Verify</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="modalcontent"></div>
      </div>
      <div class="modal-footer">
       
        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
$(".phone2").on('keyup', function() {
         var phone = $(this).val();
         if (phone.length==10) {
          var url = "<?= URL::to('admin/checkuser') ?>/"+phone;
            $.get(url, function( result ) {

              if (result.length != 0) {
                 $(".name2").attr('value',result[0]['name']);
                 $(".namelabel").html("<strong>Name:</strong> "+result[0]['name']+"<br />");
             $(".email2").attr('value',result[0]['email']);
             $(".emailLabel").html("<strong>Email:</strong> "+result[0]['email']+"<br />");
             $(".currentbalance2").html("<strong>Current Balance:</strong> Rs."+result[0]['food_card']+"");
             $(".food_card").val(result[0]['food_card']);
           }else {
             $(".name2").attr('value','');
             $(".email2").attr('value','');
           }
           
            
        });
         }
         
    });
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
        $(".checkoutbtn2").click(function() {
           var name = $(".name2").val();
           var phone = $(".phone2").val();
           var email = $(".email2").val();
           var amount = $(".food_card").val();
           var url = "<?= URL::to('admin/fc_refund') ?>";
           var formData = {
                '_token':'{{ csrf_token()}}',
                 'name': name,
                 'phone': phone,
                 'email' : email
           };
           
           if (name=="" || phone=="" || email=="") {
            $("#exampleModal").modal("show");
              $(".modalcontent").html("Please fill all the required fields!");
            return false;
           }else {
            if (amount==0) {
              $("#exampleModal").modal("show");
              $(".modalcontent").html("Insufficient balance!");
             return false;
            }else {
              $(".vphone").val(phone);

              $.post(url,  formData,
            function (resp,textStatus, jqXHR) {
              if (resp=="failed") {
                alert("Refund process failed!");

              }else {
                $(".order_id").val(resp);
                $("#exampleModal2").modal("show");
              }
            });
              return false;
            }
            
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
@endsection
