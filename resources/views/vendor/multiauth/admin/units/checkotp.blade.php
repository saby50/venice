@extends('multiauth::layouts.main') 


@section('title')
Check OTP
@endsection

@section('content')
<form action="{{ URL::to('admin/send_otp') }}" method="post">
	@csrf
<div class="main-content style2"> 

<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Shops</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Unit(s)</h2>

			</div>
		</div>
		<div class="col-md-8 column">
			<div class="top-bar-chart">
				<div class="quick-report">
					<div class="quick-report-infos">

					</div>
					
				</div>

			</div><!-- Top Bar Chart -->
		</div>
	</div>
</div><!-- Top Bar Chart -->

<div class="panel-content">
	<div class="row">
	@if (session('status'))
				<div class="widget no-color">
						<div class="alert alert-success">
								<div class="notify-content">
									 {{ session('status') }}!

								</div>
						</div>
						</div>
				</div>
			@endif
				@if (session('error'))
				<div class="widget no-color">
						<div class="alert alert-danger">
								<div class="notify-content">
									 {{ session('error') }}!

								</div>
						</div>
						</div>
				</div>
			@endif
			</div>
	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">

					<div class="row">
						<div class="col-md-6">
							
						<p>Please enter the Customer OTP:</p>
						<div class="form-group">
							<label>Enter OTP</label>
							<input type="text" name="otp" value="" class="form-control" required="required">
							<input type="hidden" name="phone" value="<?= $phone ?>">
						</div>
						
						<div class="form-group">
							<input type="submit" name="submit" value="Submit OTP" class="btn btn-primary">
							
						</div>

			</div>
	</div>
	</div>
	</div>
	</div>
	</div>
</div><!-- Panel Content -->
</div>
</form>
@endsection
