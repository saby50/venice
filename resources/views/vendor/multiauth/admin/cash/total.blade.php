@extends('multiauth::layouts.main') 


@section('title')
Cash
@endsection

@section('content')
<?php 
$seconds = time();
  $rounded_seconds = ceil($seconds / (15 * 60)) * (15 * 60);
  $rounded =  date('g:i', $rounded_seconds);
 
   $currenttime = date('h', strtotime('+1 hour')).":00 ".date('A', strtotime('+1 hour')); 

  
?>
<div class="main-content style2"> 
<div class="breadcrumbs">
  <ul>
    <li><a href="#/" title="">Home</a></li>
    <li><a href="#/pages/portfolio" title="">POS Helpdesk</a></li>
  </ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-12 column">
			<div class="heading-profile">
				<h2>POS Helpdesk | Date: <?= date('l') ?> | Date: <?= date('d F, Y') ?> | Time: <?= $currenttime ?> | User: <?= Auth::user()->name ?></h2>

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
			</div>
	<div class="row">
		<form action="{{ URL::to('admin/booking/cash') }}" method="post">
			@csrf
		

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">

					<div class="row">
						
						<div class="col-md-12">
							  <div class="col-md-12" style="text-align: center;padding: 40px;font-size: 14px;">
                      <?php if($status=="success"): ?>
                   <img src="{{ asset('images/yeah.png') }}"><br /><br />
                   Payment has been successfully done.<br />
                   Enjoy your ride.

                   <?php else: ?>
                      <img src="{{ asset('images/oops.png') }}"><br /><br />
                   Looks like something went wrong.<br />
                   Please try again.

                   <?php endif; ?>

                   <br />
                   <br />
                    <?php if($status=="success"): ?>
                   <a href="{{ URL::to('admin/cash_bookings') }}"><button type="button" class="btn checkoutbtn btn-width btn-primary">Continue</button></a>
                   <?php else: ?>
                    <a href="{{ URL::to('admin/cash_bookings') }}"><button type="button" class="btn checkoutbtn btn-width btn-primary">Retry</button></a>
                   <?php endif; ?>
                      
                    </div>
							
						</div>
				
					
				
					</div>

					
				</div>
			</div>
		</div>
		</form>
	</div>
</div><!-- Panel Content -->
</div>



@endsection
