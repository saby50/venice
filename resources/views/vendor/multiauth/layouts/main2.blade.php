<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" data-ng-app="tutorialWebApp"> <!--<![endif]-->
<head>

    <!-- Meta-Information -->
    <title>Venice: Login</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="{{ asset('images/favicon.png') }}">
    <!-- Vendor: Bootstrap Stylesheets http://getbootstrap.com -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Our Website CSS Styles -->
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sass.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

</head>
<body>


  		<div class="acount-sec maincontainer" style="height:100vh">
  			<div class="container">
  				<div class="row">

  					<div class="col-md-4 col-md-offset-4" style="text-align: center;">
  						<div class="contact-sec">
  							<div class="row">
  								<div class="col-md-12">
  									<div class="widget-title"  style="text-align: center;margin-top: 20px;">
                      <center><a href="#/" title=""><img src="{{ asset('images/logo.png') }}" width="150" style="margin-top: -50px;"></a></center><br /><br />
  										<h3>Venice: Admin Zone</h3>
  										<span>Please enter your credentials to continue:</span>
  									</div><!-- Widget title -->
  									<div class="account-form" style="text-align: center;">
  										<form method="POST" action="{{ route('admin.login') }}" aria-label="{{ __('Admin Login') }}">
                      {{ csrf_field() }}
                        <div class="row">
  												<div class="feild col-md-12">
  													<input type="text" name="email" value="{{ old('email') }}"  placeholder="Email" />
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
  												</div>
                          <input type="hidden" name="user_type" value="">
  												<div class="feild col-md-12">
  													<input type="password" name="password" placeholder="Password" />
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
  												</div>
  												<div class="feild col-md-12">
  													<input type="submit" class="loginbtn" value="Login" style="" />
  												</div>
  											</div>
  										</form>
  									</div>

  								</div>

  							</div>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>

  	</div><!-- Account Sec -->
  </div>

<style media="screen">
  .loginbtn {
    text-transform: uppercase;
    border-radius: 0px !important;
  }
  .loginbtn:hover {
  background: #000 !important;
  }
</style>

<!-- Vendor: Javascripts -->
<script src="{{ asset('js/jquery-2.1.3.js') }}"></script>
<script src="{{asset('js/bootstrap.min.js') }}"></script>

<!-- Vendor: Angular, followed by our custom Javascripts -->
<script src="{{ asset('js/angular.min.js') }}"></script>
<script src="{{ asset('js/angular-route.min.js') }}"></script>
<script src="https://maps.google.com/maps/api/js?sensor=false"></script>
<style>
.maincontainer {
  background: url({{ asset('images/loginbg.jpg') }});
  background-size: cover;
}
.help-block {
    color: #ff0000 !important;
    font-size: 12px !important;
}
h3, h4,h5 {
  text-align: center;
  float: none !important;
}
.account-form > form .feild > input[type="submit"] {
  float:none !important;
}
</style>

</body>
</html>
