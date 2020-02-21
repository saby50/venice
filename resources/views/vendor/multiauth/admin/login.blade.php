@extends('multiauth::layouts.main2') 
@section('content')
<div class="account-user-sec">
    <div class="account-sec">
        <div class="account-top-bar">
            <div class="container">
                 <div class="logo">
                    <a href="#/" title=""><i class="fa fa-deviantart"></i> Electric</a>
                </div>
                <ul class="account-header-link">
                    <li><a title="" href="#/register">Register</a></li>
                    <li><a title="" href="#/forgot-password">Forgot Your Password</a></li>
                    <li><a title="">Email us</a></li>
                </ul>
            </div>
        </div>
        <div class="acount-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="account-detail">
                            <ul>
                                <li>
                                    <h3><i class="fa  fa-television"></i>  Keep everything Sync</h3>
                                    <p>Dnim eiusmod high life accusamus terry </br>richardson ado squid.</p>
                                </li>
                                <li>
                                    <h3><i class="fa fa-map-o"></i> Emails & Calendars is with you</h3>
                                    <p>Dnim eiusmod high life accusamus terry </br>richardson ado squid.</p>
                                </li>
                                <li>
                                    <h3><i class="fa  fa-send-o"></i> Simple Elegant & Super Fast</h3>
                                    <p>Dnim eiusmod high life accusamus terry </br>richardson ado squid.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="contact-sec">
                            <div class="row">
                                <div class="col-md-6">  
                                    <div class="widget-title">
                                        <h3>Admin Panel Login</h3>
                                        <span>Fill your detail to get in</span>
                                    </div><!-- Widget title -->
                                    <div class="account-form">
                                        <form>
                                            <div class="row">
                                                <div class="feild col-md-12">
                                                    <input type="text" placeholder="Username" />
                                                </div>
                                                <div class="feild col-md-12">
                                                    <input type="password" placeholder="Password" />
                                                </div>
                                                <div class="feild col-md-12">
                                                    <input type="submit" value="Login Now" />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="more-option">
                                        <span>OR</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="creat-an-account">
                                        <span>Don't have an account?</span>
                                        <a href="#/register" title="">Create Account</a>
                                        <h4>You can also Signup using</h4>
                                        <ul>
                                            <li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#" title=""><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div><!-- Create an account -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="container">
                <p>© 2015 Webinane Technologies Ltd.  Made with <i class="fa fa-heart"></i></p>
            </div>
        </footer>
    </div><!-- Account Sec -->
</div>

@endsection