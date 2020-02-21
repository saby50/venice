@extends('layouts.main2')

@section('title')
Register
@endsection

@section('content')
 <script type="text/javascript" src="{{ asset('public/js/bootstrap-pincode-input.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/bootstrap-pincode-input.css') }}">
<section>
	
	<div class="recyclerview login-form firstbox">
		<div>
	    	<center><img src="{{ asset('public/images/registerarwork.jpg') }}" class="loginimg"></center>
          </div>	
		<form action="{{ URL::to('cregister') }}" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <h5 style="text-align: center;">Register</h5>
       <p style="text-align: center;">Please register to access your account!</p>
         <div class="form-group">
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
       </div>
       <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="name" required="required">
        
       </div>

       <div class="form-group">
       	<label>Phone</label>
       	<input type="number" class="form-control" name="phone" required="required" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
       	
       </div>
       <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" name="email" required="required">
        
       </div>
       <div class="form-group">
    <div class="pinarea">
                            <label for="pincode-input1">PIN</label><br>
                            <div class="pincode-input-container"><div style="display: none;"><input type="number" inputmode="numeric" id="preventautofill" autocomplete="off" class="pincode-input-text-masked"></div><input type="number" name="pin1" maxlength="1" autocomplete="off" class="form-control pincode-input-text pincode-input-text-masked first" required="required"><input type="number" maxlength="1" autocomplete="off" name="pin2" class="form-control pincode-input-text pincode-input-text-masked first" required="required"><input type="number" maxlength="1" autocomplete="off" class="form-control pincode-input-text pincode-input-text-masked first" name="pin3" required="required"><input type="number" maxlength="1" autocomplete="off" class="form-control pincode-input-text pincode-input-text-masked first" name="pin4" required="required">
                        </div>
       </div>
         <div class="form-group " style="margin-top: 20px;">
       <button type="submit" class="btn checkoutbtn"> Continue</button>
       </div>
   </form>

	</div>
	<div class="row">
<div class="col-12" style="text-align: center;">
		<a href="{{ URL::to('login') }}" class="removeItem" style="font-size: 14px;">Login</a>
	</div>
	
	</div>
	</div>
</section>
<script>
     $(document).ready(function() {
      $(".pincode-input-text").keyup(function () {
    if (this.value.length == this.maxLength) {
      var $next = $(this).next('.pincode-input-text');
      if ($next.length)
          $(this).next('.pincode-input-text').focus();
      else
          $(this).blur();
    }
});
    });
    </script>
    
@endsection