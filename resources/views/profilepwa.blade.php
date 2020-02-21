@extends('layouts.main2')

@section('title')
Profile
@endsection

@section('content')
<div class="tabs">
      <div class="tab tabopen" id="profile">
      Update Profile
      </div>
      <div class="tab" id="updatepin">
        Update PIN
      </div>
      
    </div>
<div class="recyclerview profile profileaream" style="margin-top: 100px;padding-top: 40px;">
	  <form class="" method="post" action="{{ URL::to('profile/update') }}">
	  	    @csrf
                            @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                           </div>
                          
                           @endif
                            @if (session('status'))
                           <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                           </div>
                           @endif
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<input type="text" name="name" class="form-control" placeholder="Name" value="<?= Auth::user()->name ?>">
				
			</div>
			<div class="form-group">
				<input type="text" name="phone" class="form-control" placeholder="Phone" value="<?= Auth::user()->phone ?>" readonly>
				
			</div>
			<div class="form-group">
				<input type="text" name="email" class="form-control" placeholder="Email" value="<?= Auth::user()->email ?>">
				
			</div>
			<div class="form-group">
				 <button type="submit" class="btn checkoutbtn"> Update</button>
				
			</div>
		</div>

	</div>
</form>
</div>
<div class="recyclerview updatepin profileaream" style="margin-top: 100px;padding-top: 40px;">
	 <form class="" method="post" action="{{ URL::to('pin/update') }}">
	  	    @csrf
                            @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                           </div>
                          
                           @endif
                            @if (session('status'))
                           <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                           </div>
                           @endif
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<input type="password" name="oldpin" class="form-control" placeholder="Old PIN" maxlength="4">
				
			</div>
			<div class="form-group">
				<input type="password" name="newpin" class="form-control" placeholder="New PIN" maxlength="4">
				
			</div>
			<div class="form-group">
				<input type="password" name="cnewpin" class="form-control" placeholder="Confirm PIN" maxlength="4">
				
			</div>
			<div class="form-group">
				 <button type="submit" class="btn checkoutbtn">UPDATE PIN</button>
				
			</div>
		</div>
	</div>
</form>
</div>
<div class="recyclerview" style="padding: 40px;margin-top: 10px;">
<div class="row">
    <div  class="recyclerviewhead" style="font-size: 12px;padding-left: 10px;">
      Order History<br />
    </div>
    <div class="recyclerviewhead2" >
      <a href="<?= URL::to('history/all') ?>">View All</a>
    </div>
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
<script type="text/javascript">
	$('.tab').click(function () {
    var id = $(this).attr('id');
    $(".profileaream").css('display','none');
    $("."+id).css('display','block');
    $('.tabopen').removeClass('tabopen');
    $(this).addClass('tabopen');
});

</script>
<style type="text/css">
	.updatepin {
		display: none;
	}
</style>
@endsection