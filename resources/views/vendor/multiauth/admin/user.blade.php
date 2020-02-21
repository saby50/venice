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
					<span class="bar2"><a href="{{ URL::to('admin/users/export') }}"><button class="btn btn-primary">Export</button></a></span>
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
		<form action="{{ URL::to('admin/users/sendsms') }}" method="post">
			@csrf
		

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">

					<div class="row">
						<div class="col-md-10"  style="margin-top: -20px;"><h3><?= $data->total() ?> Users</h3>
							<br />
							<input type="checkbox" name="selectall" id="checkAll"> Select All  &nbsp;&nbsp;&nbsp; <input type="submit" name="submit" value="Send SMS" class="btn btn-primary"></div>
						
						<div class="col-md-2" style="margin-bottom: 20px;">
          <input type="text" placeholder="Search.." class="form-control allInput2">
        </div>
					</div>

					<div class="row">

						<?php if (count($data) != 0): ?>
							 <table class="table allTable2">
          <thead>
            <tr>
              
							<th>Personal Details</th>
              <th>Total Bookings</th>
							<th>Amount</th>
              
             <th>Platform</th>
             	<th>Last Transaction Date</th>
							<th>Join Date</th>
							
            </tr>
          </thead>
          <tbody>

          <?php foreach($data as $key => $value): ?>
          <tr>
            
						<td><input type="checkbox" name="user_phone[]" value="<?= $value->phone ?>"> <?= $value->name ?><br /><?php if ($value->email!="") {
							echo $value->email."<br />";
						} ?><?= $value->phone ?></td>
						<td>
						<?php 
						$bookings = Helper::get_booking_amount($value->id);
                         echo $bookings['no_of_bookings'];
						?></td>
						<td><i class="fa fa-rupee" aria-hidden="true"></i> <?php 
                         echo number_format($bookings['amount']);
						?></td>
            <td><?php 
               if ($value->platform=="web") {
                echo '<i class="fa fa-globe fa-lg" aria-hidden="true" title="Web"></i>';
               }else if($value->platform=="android") {
                  echo '<i class="fa fa-android fa-lg" aria-hidden="true" title="Android"></i>';

               }
              ?></td>
              <td><?php 
              if ($bookings['date'] != "") {
              	echo date('d-M-y, H:i A',strtotime($bookings['date']));
              }else {
              	echo "N/A";
                } 
              ?></td>
              
            <td><?= date('d-M-y, H:i A',strtotime($value->created_at)) ?></td>
						
				  </tr>
				<?php endforeach; ?>



          </tbody>
        </table>
        {{ $data->links() }}
          
							<?php else: ?>
								No Categories Found
						<?php endif; ?>



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
