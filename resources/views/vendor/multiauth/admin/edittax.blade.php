@extends('multiauth::layouts.main') 
@section('title')
Edit Taxes
@endsection
@section('content')
<div class="main-content style2"> 

<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Taxes</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Edit Tax</h2>
			</div>
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
						<div class="top-margin">
							<div class="filter-products">
								<form class="form" action="{{ URL::to('admin/updatetax') }}" method="post">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="col-md-6">
									<label>Tax Name</label>
									<input type="text" class="form-control" name="tax_name" value="<?= $data[0]->tax_name ?>" required="">

								<input type="hidden" name="taxid"  value="<?= $data[0]->id ?>">
								</div>
								<div class="col-md-6">
									<label>Percentage</label>
									<input type="text" class="form-control" name="tax_percent" value="<?= $data[0]->tax_percent ?>" required="">

								
								</div>
								<div class="col-md-12" style="margin-top: 40px;">
								
									<input type="submit" value="Submit" class="btn btn-primary">

								
								</div>
								</form>
							</div>
						</div>
					</div><!-- End Row -->
						
				</div>
			</div>
		</div>
	</div>
</div><!-- Panel Content -->


</div>
@endsection