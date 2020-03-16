@extends('multiauth::layouts.main') 
@section('title')
Events
@endsection
@section('content')
<?php
   $event_name = "";
   $event_alias = "";
   $end_date = "";
   $end_time = "";
   foreach ($data as $key => $value) {
     $event_name = $value->event_name;
     $event_alias = $value->event_alias;
     $end_date = $value->end_date;
     $price = $value->event_price;
     $end_time = $value->end_time;
     $teaser_line_1 = $value->teaser_line_1;
     $event_description = $value->event_description;
     $event_short_description = $value->event_short_description;
     $teaser_line_2 = $value->teaser_line_2;
   }
?>
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
				<h2>Event</h2>

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
  <form action="{{ URL::to('admin/events/add') }}" method="post">
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
                <label>Event Name</label>
                <input type="text" class="form-control" name="event_name" value="<?= $event_name ?>" required>
              </div>
              
                     <div class="col-md-6">
                      <label>Event Alias</label><br />
                   <input type="text" class="form-control" name="event_alias" value="<?= $event_alias ?>" required>
                   
                    </div>
                         <div class="col-md-6">
                  <label>Event Date</label>
                    <input type="text" class="form-control" name="event_date[]" value="<?= $end_date ?>" required>
                  </div>
                      <div class="col-md-6">
                  <label>Event Time</label>
                    <input type="text" class="form-control" name="event_time[]" value="<?= $end_time ?>" required>
                  </div>
                      <div class="col-md-6">
                      <label>Price</label><br />
                   <input type="text" class="form-control" name="price" value="<?= $price ?>"required>
                   
                    </div>
                         <div class="col-md-6">
                    <label>Tax</label>
                       <select class="form-control" name="tax_id">

                      <?php foreach ($taxes as $key => $value): ?>
                        <option value="<?= $value->id ?>"><?= $value->tax_name ?> (<?= $value->tax_percent ?>%)</option>
                      <?php endforeach; ?>
                  </select>
                    </div>
                        <div class="col-md-6">
                      <label>Teaser Line 1</label><br />
                   <input type="text" class="form-control" name="line1" value="<?= $teaser_line_1 ?>" required>
                   
                    </div>
                        <div class="col-md-6">
                      <label>Teaser Line 2</label><br />
                   <input type="text" class="form-control" name="line2"  value="<?= $teaser_line_2 ?>"  required>
                   
                    </div>

                      <div class="col-md-6">
                    	<label>Short Description</label><br />
                       <textarea class="form-control" id="summernote" name="shortdesc"><?= $event_short_description ?></textarea>
                   
                    </div>

                    <div class="col-md-6">
                      <label>Description</label><br />
                       <textarea class="form-control" id="summernote2" name="description"><?= $event_description ?></textarea>                  
                    </div> 
                      <div class="col-md-6" style="margin-bottom: 20px;">
                      <label>Suspend</label><br />
                   <input type="radio" name="suspend" value="yes"> Yes &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="suspend" value="no"  checked="checked"> No
                   
                    </div>
                     <div class="col-md-6" style="margin-bottom: 20px;">

                  <label>Rate Type</label><br />
                   <input type="radio" name="rate_type" value="yes" checked="checked"> Tax Inclusive &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="rate_type" value="no"> Tax Exclusive
                   
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
<script>
$(document).ready(function()
{
 $('#summernote').summernote();
   $('#summernote2').summernote();
  $(".addfield").click(function() {
    $(".addonfields")
    .append(' <div class="row1">    <div class="col-md-6" style="margin-top:0px;"> \n\
            <label>Custom Option</label>\n\
              <input type="text" class="form-control" name="custom_options[]" required>\n\
      </div>\n\
      <div class="col-md-6" style="margin-top:0px;">\n\
        <label>Capacity</label>\n\
          <input type="number" class="form-control" name="capacity[]" required>\n\
          <a class="minus"><i class="fa fa-minus-square-o removeto" aria-hidden="true"></i></a>\n\
  </div></div>');
  });
  $(document).on("click", ".removeto", function (e) { //user click on remove text
      e.preventDefault();
      $(this).closest('.row1').remove();
      x--;
  })
});
</script>
@endsection
