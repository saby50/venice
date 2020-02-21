@extends('layouts.main2')

@section('title')
Change Pin
@endsection

@section('content')

 <section id="hero_login">
        <div class="hero-container">
            <div class="row" style="width: 100%;">
                <div class="col-md-2 col-12"></div>
                <div class="col-md-8 col-12 my-profile">
                    <div class="head row">
                        <div class="col-md-6" style="padding: 10px;padding-left: 40px;padding-top: 20px;">
                            <h3>My Profile</h3>
                        </div>
                        <div class="col-md-6" style="display: none;">
                            <a href="my-profile.html" class="btn btn_active pull-right">My Profile</a>
                            <a href="order-history.html" class="pull-right" style="padding-right: 10px; padding-top: 12px;">Order History</a>
                        </div>
                    </div>
                    <hr />
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item " id="tab01">
                            <a class="nav-link " id="" href="<?= URL::to('profile') ?>">Personal Details</a>
                        </li>
                        <li class="nav-item active" id="tab02">
                            <a class="nav-link active" id="" href="<?= URL::to('profile/pin') ?>">Change PIN</a>
                        </li>
                         <li class="nav-item" id="tab02">
                            <a class="nav-link" id="" href="<?= URL::to('history/all') ?>">Order History</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane container active" id="tab11">
                            <div style="">
                           <form class="mt-5 profilemar" method="post" action="{{ URL::to('pin/update') }}">
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
                                <div class="form-group pinarea">
                                    <label for="pincode-input1">Old PIN</label><br>
                                    <input type="text" id="pincode-input1">
                                    <input type="hidden" class="oldpin" name="oldpin">
                                </div>
                                <div class="form-group pinarea">
                                    <label for="pincode-input2">New PIN</label><br>
                                    <input type="text" id="pincode-input2">
                                    <input type="hidden" class="newpin" name="newpin">
                                </div>
                                <div class="form-group pinarea">
                                    <label for="pincode-input3">Confirm PIN</label><br>
                                    <input type="text" id="pincode-input3">
                                    <input type="hidden" class="cnewpin" name="cnewpin">
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">UPDATE PIN</button>
                                </div>
                            </form>
                            </div>
                        </div>
                        <div class="tab-pane container" id="tab22">
                           
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-12"></div>
            </div>
        </div>
    </section><!-- #hero -->
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
@media (max-width: 425px){
.tab-content {
    border-top: 1px solid #EF9E11 !important;
    padding: 0px;
}
}
</style>

    <script>
     $(document).ready(function() {
        $('#pincode-input1').pincodeInput({
            hidedigits: true,
            complete: function(value, e, errorElement) {
               $(".oldpin").attr('value',value);
            }
        });
        $('#pincode-input2').pincodeInput({
            hidedigits: true,
            complete: function(value, e, errorElement) {
               $(".newpin").attr('value',value);
            }
        });
         $('#pincode-input3').pincodeInput({
            hidedigits: true,
            complete: function(value, e, errorElement) {
               $(".cnewpin").attr('value',value);
            }
        });
    });
    </script>

@endsection