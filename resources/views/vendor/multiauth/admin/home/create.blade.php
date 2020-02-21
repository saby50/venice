@extends('multiauth::layouts.main') 
@section('title')
Slider
@endsection
@section('content')
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Create</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Slider</h2>

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
  <form action="{{ URL::to('admin/slide/add') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
          <div class="row">
            <div class="col-md-12">
         
              </div>
					<div class="row formarea">
            <div class="col-md-6">
                <label>Slider Name</label>
                <input type="text" class="form-control" name="slider_name"  required>
              </div>
              <div class="col-md-6">
                <label>Slider Position</label>
                <input type="text" class="form-control" name="position"  required>
              </div> 
                 <div class="col-md-6">
                <label>Slider Link</label>
                <input type="text" class="form-control" name="slider_link"  required>
              </div>        
              <div class="col-md-12">              
                <input type="submit" class="btn btn-primary" value="Next">
              </div>
					</div>

				</div>
			</div>
	
	</div>
</form>
</div><!-- Panel Content -->
</div>

@endsection
