@extends('layouts.main2')

@section('title')
Wallet
@endsection

@section('content')
<div class="recyclerview" style="margin-top: 70px;">
	<div class="row">
		<div class="col-12">
			GV Pocket Balance<br />
			<h3 style="color: #EF9E11;"><i class="fa fa-rupee"></i> <?= Crypt::decrypt(Auth::user()->wall_am) ?></h3>
		</div>
	</div>
</div>

@endsection