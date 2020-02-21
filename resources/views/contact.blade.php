@extends('layouts.main2')

@section('title')
Contact Us
@endsection
@section('includes')
     <meta property="og:title" content="The Grand Venice Mall | Contact Us">
    <meta property="og:description" content="Get In Touch & We Would Be Honoured To Address Your Queries">
    <meta property="og:image" content="{{ asset('public/images/GV03.jpg') }}">
@endsection
@section('content')
 <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<section class="<?php echo (Helper::get_device_platform()=="android" ||  Helper::get_device_platform()=="ios") ? "recyclerview": "hero"; ?> firstbox" style="margin-top: 100px;">
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<p style="color: #EF9E11; font-weight: bold; font-size: 27px;">Main Office</p>
			<div class="kleo_text_column wpb_content_element ">
<div class="wpb_wrapper">
<p><strong>Address:</strong></p>
<p>Bhasin Infotech And Infrastructure Private Limited<br>
Plot No SH3, Site IV, Near Pari Chowk, Block B, Industrial Area, <br />Surajpur Site 4, Greater Noida, Uttar Pradesh 201308<br /><br />
<strong>Email: </strong> <a style="color: #EF9E11; font-weight: 600;font-family: inherit;" href="mailto:info@veniceindia.com" target="_top">info@veniceindia.com</a><br>
<strong>Phone: </strong> <a style="color: #EF9E11; font-weight: 600;font-family: inherit;" href="tel:00918860666666">+91 88606-66666</a></p>
</div>
</div>

		</div>
		<div class="col-md-4">
			<p style="color: #EF9E11; font-weight: bold; font-size: 27px;">Contact Us</p>
			<form action="<?= URL::to('sendcontact') ?>" method="post">
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
				<div class="form-group">
					<label>Name<span style="color: red;">*</span></label>
					<input type="text" name="name" class="form-control" required="required">
				</div>
				<div class="form-group">
					<label>Email<span style="color: red;">*</span></label>
					<input type="text" name="email" class="form-control" required="required">
				</div>
				<div class="form-group">
					<label>Phone<span style="color: red;">*</span></label>
					<input type="text" name="phone" class="form-control" required="required">
				</div>
				<div class="form-group">
					<label> Message<span style="color: red;">*</span></label>
					<textarea name="message" class="form-control" required="required"></textarea>
				</div>
				<div class="form-group">
					 <div class="g-recaptcha" data-sitekey="6LcynKQUAAAAACaCtqaFWb28znlAQgquBKMKcUQv"></div>
					
				</div>
				<div class="form-group">
					
					<button type="submit" class="btn checkoutbtn" style="width: 100%;">Submit</button>
				</div>
			</form>
			<p></p>
		</div>
	</div>
	
</div>
</section>

<div class="maparea">
	<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7015.770322307344!2d77.525994!3d28.452878!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf4077203c436ddc2!2sThe+Grand+Venice+Mall!5e0!3m2!1sen!2sin!4v1557303679206!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>

@include('include/subfooter')

<style type="text/css">
@media (max-width: 425px) {
	.hero {
      margin-top: 70px !important;
      background: #FFF;
   }
   .hero .col-md-8 {
      padding-top: 20px;
   }
}
</style>
@endsection