@extends('layouts.main2')

@section('title')
e-Pass
@endsection

@section('content')
<div class="recyclerview firstbox">

	<div class="row">
		<div class="row" style="width: 100%;margin: 0 auto;">
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
		</div>	
		<h4 style="text-align: center;width: 100%;">Scan e-Pass</h4>
		<div class="qrcode"><?= QrCode::size(300)->generate(Auth::user()->id); ?>
			<center><strong>Name:</strong> <?= Auth::user()->name ?><br /> <strong>Phone:</strong> <?= Auth::user()->phone ?></center>
		</div>
		<h4 style="margin-top: 40px;text-align: center;width: 100%;">Book Your Slot</h4>
		
		<div class="slot-box">
	       
			<form method="post" action="<?= URL::to('book_slot') ?>">
				@csrf

			<label>Date</label>
			<input type="date" name="date" class="form-control">
			<label>Time</label>
			<input type="time" name="time" class="form-control"><br />
			<button type="Submit" class="btn btn-primary form-control">Submit</button>
			</form>
		</div>
		
	</div>
	
</div>
<style type="text/css">
	.qrcode {
		margin: 0 auto;
		margin-top: -20px;
	}
	.slot-box {
		width: 100%;
    padding: 20px;
	}
</style>
@endsection