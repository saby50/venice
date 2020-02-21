@extends('layouts.main2')

@section('title')
Wallet
@endsection

@section('content')
<div class="recyclerview firstbox">
	<div class="row">
		<div class="col-12 gv-balance">
			GV Pocket Balance<br />
			<h3 style="color: #EF9E11;"><i class="fa fa-rupee"></i> <?= Crypt::decrypt(Auth::user()->wall_am) ?></h3>
		</div>
	</div>
	<div class="row gv-box orangeborder ripple" data="{{ URL::to('wallet/recharge') }}">
		
		<div class="col-7">
			GV COIN<br />
			<span>100% Usage</span> <a href="#" class="info-icon"><i class="fa fa-info" aria-hidden="true"></i></a>


		</div>
		<div class="col-5">
			<h5><i class="fa fa-rupee"></i> <?= Crypt::decrypt(Auth::user()->wall_am) ?></h5>
		</div>
		
		<div class="col-12 gv-box-footer">

			<strong>+ TopUp GV Pocket </strong> (Get extra 5% GV Cash)
			<i class="fa fa-arrow-right" aria-hidden="true" style="float: right;"></i>

			
		</div>
		
	</div>
	<div class="row gv-box skyblueborder ripple" data="{{ URL::to('wallet/promo') }}">
		
		<div class="col-7">
			PROMOTIONAL CREDIT<br />
			<span>Restricted Usage</span> <a href="#" class="info-icon"><i class="fa fa-info" aria-hidden="true"></i></a>


		</div>
		<div class="col-5">
			<h5><i class="fa fa-rupee"></i> <?= Crypt::decrypt(Auth::user()->wall_am) ?></h5>
		</div>
		
		<div class="col-12 gv-box-footer">

			<a href="#">View Expiry Summary</a>
			<i class="fa fa-arrow-right" aria-hidden="true" style="float: right;"></i>

			
		</div>
		
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.gv-box').click(function() {
          var data = $(this).attr('data');
          window.location = data;
		});

	});
</script>

@endsection