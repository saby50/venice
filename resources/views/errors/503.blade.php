@extends('layouts.main2')

@section('title')
Cart
@endsection

@section('content')
<div class="row" style="margin-top: 60px; text-align: center;">
  <div class="col-md-12">
    <img src="{{ asset('public/images/updating.jpg') }}" class="maintain">
    
  </div>
  
</div>
<style type="text/css">
	.maintain {
		width: 100%;
	}
	@media only screen and (min-width: 1024px) and (max-width: 2500px) {
       .maintain {
		width: 1024px;
	}

	}
</style>
@endsection