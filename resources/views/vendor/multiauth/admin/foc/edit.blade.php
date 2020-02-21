@extends('multiauth::layouts.main') 


@section('title')
Managers
@endsection


@section('content')
<?php 
  $name = "";
  $phone = "";
  $email = "";
foreach ($data as $key => $value) {
  $name = $value->name;
  $phone = $value->phone;
  $email = $value->email;
}
?>
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Edit</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>FOC Managers</h2>

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
  <form action="{{ URL::to('admin/foc/update') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
          <div class="row">
            <div class="col-md-12">
          @if (session('status'))
                <div class="widget no-color">
                    <div class="notify orange-skin with-color">
                        <div class="notify-content">
                            <h3>Congratulation! {{ session('status') }}</h3>

                        <a title="" class="close">x</a>
                        </div>
                    </div>
                    </div>
                </div>
              @endif
              </div>
					<div class="row formarea">
              <div class="col-md-6">
               <label>Name</label>
               <input type="text" class="form-control" name="name" value="<?= $name ?>" required>
              </div>
                 <div class="col-md-6">
                    <label>Email</label>
                      <input type="text" class="form-control" name="email" value="<?= $email ?>" required>
                    </div>

              <div class="col-md-6">
               <label>Phone</label>
               <input type="text" class="form-control" name="phone" value="<?= $phone ?>" required>
              </div>
              <input type="hidden" name="foc_id" value="<?= $id ?>">
               
            
              <div class="col-md-12">
               <br />
                <input type="submit" class="btn btn-primary" value="Submit">

              </div>
					</div>

				</div>
			</div>
	
	</div>
</form>
</div><!-- Panel Content -->
</div>

@endsection
