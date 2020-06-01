@extends('layouts.main2')

@section('title')
e-Pass
@endsection

@section('content')
<div class="recyclerview firstbox">
	<div class="row">
		<h4 style="text-align: center;width: 100%;">Scan e-Pass</h4>
		<div class="qrcode"><?= QrCode::size(300)->generate(Auth::user()->id); ?>
			<center><strong>Name:</strong> <?= Auth::user()->name ?><br /> <strong>Phone:</strong> <?= Auth::user()->phone ?></center>
		</div>
		
	</div>
	
</div>
<style type="text/css">
	.qrcode {
		margin: 0 auto;
		margin-top: -20px;
	}
</style>
@endsection