@extends('layouts.main2')

@section('title')
Login
@endsection

@section('content')
 <script type="text/javascript" src="{{ asset('public/js/bootstrap-pincode-input.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/bootstrap-pincode-input.css') }}">
<section>
	
	<div class="recyclerview login-form firstbox">
		<div>
	    	<center><img src="{{ asset('public/images/forgotartwork.jpg') }}" class="loginimg"></center>
          </div>	
		<form action="{{ URL::to('forgot/sendpin') }}" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <h5 style="text-align: center;">Forgot PIN</h5>
       <p style="text-align: center;font-size: 12px;">Please enter your registered mobile number andwe shall send you the updated PIN</p>
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
       	<label>Phone</label>
       	<input type="number" class="form-control" name="phone" required="required" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
       	
       </div>
       
         <div class="form-group " style="margin-top: 20px;">
       <button type="submit" class="btn checkoutbtn"> SEND PIN</button>
       </div>
   </form>
<div class="row">
<div class="col-12" style="text-align: center;">
    <a href="{{ URL::to('login') }}" class="removeItem" style="font-size: 14px;">Login</a>
  </div>
  </div>
	</div>
	
	</div>
  
</section>

 <script>
     $(document).ready(function() {
        $('#pincode-input1').pincodeInput({
            hidedigits: true,
            complete: function(value, e, errorElement) {            
               $(".pinno").attr('value',value);
            }
        });
    });
    </script>
    
@endsection