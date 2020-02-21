@extends('multiauth::layouts.main') 


@section('title')
Users
@endsection

@section('content')
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">User(s)</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>User(s)</h2>

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
		<form action="{{ URL::to('admin/users/send') }}" method="post">
			@csrf
		

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">

					<div class="row">
						
						<label>Message</label>

						<textarea name="message" class="form-control"></textarea><br /><br />

						<input type="submit" name="submit" value="Send SMS" class="btn btn-primary">
						
					
				
					</div>

					
				</div>
			</div>
		</div>
		</form>
	</div>
</div><!-- Panel Content -->
</div>


<script>
$(document).ready(function(){
  $(".allInput2").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".allTable2 tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  }); 
  $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
}); 
});
</script>
@endsection
