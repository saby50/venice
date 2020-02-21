@extends('layouts.main2')

@section('title')
Login
@endsection

@section('content')

 <section id="hero_login">
        <div class="hero-container">
            <div class="row" style="width: 100%;">
                <div class="col-md-4"></div>
                <div class="col-md-4 login-form">
                    <h3 class="text-center loginhead"><span class="underline">Register</span></h3>
                    <p class="text-center">Please register to access your dashboard!</p>
                       @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                       @endif
                    <form action="{{ URL::to('cregister') }}" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group loginphone register-form">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group loginphone register-form">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                         <div class="form-group loginphone register-form">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group register-form">
                          <div class="pinarea">
                            <label for="pincode-input1">PIN</label><br>
                            <input type="text" name="pin" id="pincode-input1">
                            <input type="hidden" name="pinno" value="" class="pinno">
                            <input type="hidden" name="rd" value="index">
                            </div>
                        </div>
                        <div class="form-group text-center register-form">
                           <button type="submit" class="btn checkoutbtn btn-width">Continue</button>
                        </div>
                       
                        <div class="form-group text-center">
                           <a href="{{ URL::to('login') }}" style="font-size: 14px;">Login</a><br />
                            <a href="{{ URL::to('forgot') }}" style="font-size: 14px;">Forgot PIN?</a>
                        </div>

                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </section>  
    <!-- booking form success end -->
    <main id="main">

<div class="modal fade" id="bookingModal" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <label>Oops</label>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>
          <div class="modal-body">
            <div class="content"></div>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
<style type="text/css">
#hero {
  width: 100%;
  height: 100vh;
  background: url(<?= asset('public/images/dashboard.jpg') ?>) no-repeat top center;
  background-size: contain;
  position: relative;
}
.timepicker {
        padding: .375rem .75rem !important;
}
#price {
    font-size:24px;
    font-weight: bold;
    line-height: 3 !important;
    color: #000;
    text-align: center;
}
    .loader {
    display: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8) url({{ asset('public/images/loader2.gif')  }}) center center no-repeat;
    z-index: 1000;
}
    .loader {
    display: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8) url({{ asset('public/images/loader2.gif')  }}) center center no-repeat;
    z-index: 1000;
}
.remove {
  cursor: pointer;
}
 .loginphone {
        width: 260px;
        margin-bottom: 20px;
        margin-left: 70px;
      } 
</style>

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