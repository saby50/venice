@extends('multiauth::layouts.main') 


@section('title')
User Checkins
@endsection

@section('content')
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Checkin(s)</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-8">
					<h3>Checkin(s) </h3>
				</div>
				
             <div class="col-md-4 column">
      <div class="top-bar-chart" style="text-align: right;">
      
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
	
	

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
					<div class="row">
                       <div class="col-md-4">
						
					   </div>
					</div>
					<div class="row">
						<table class="table
						">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Date</th>
							</tr>
						</thead>
							<tbody>
						 <?php foreach($data as $key => $value): ?>
						 	<?php 
                              $userinfo = Helper::get_user_info($value->user_id);
						 	?>
						 	<?php foreach($userinfo as $k => $v): ?>
							<tr>
								<td><?= $v->name ?></td>
								<td><?= $v->email ?></td>
								<td><?= $v->phone ?></td>
								<td><?= date('d-m-Y', strtotime($value->created_at)) ?></td>
							</tr>
							<?php endforeach; ?>
						<?php endforeach; ?>
						</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div><!-- Panel Content -->
</div>
<style type="text/css">
	.datearea {
		display: none;
	}
	table.table tr td {
		min-width: 170px !important;
	}
	.wrapper1, .wrapper2 {
  width: 100%;
  overflow-x: scroll;
  overflow-y:hidden;
}
.div1 {
  width:8000px;
  height: 20px;
}
</style>


@endsection
