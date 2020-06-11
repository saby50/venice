@extends('multiauth::layouts.main') 


@section('title')
Reports
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
					<h3>Checkin(s) - <?php 
                     if ($parameter=="todays") {
                     	echo date('d-m-Y');
                     }elseif ($parameter=="monthly") {
                     	echo date('M Y');
                     }elseif ($parameter=="lastmonth") {
                     	echo date('M Y', strtotime('-1 Month'));
                     }elseif ($parameter=="yesterday") {
                     	echo date('d-m-Y', strtotime('-1 Day'));
                     }

					?></h3>
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
						<label>Filter by date: </label>
						<select name="filter" class="form-control type">
							<?php foreach($filters as $key => $value): ?>
								<?php if($parameter==$value->filter_value): ?>
								<option value="<?= $value->filter_value ?>" selected><?= $value->filter_name ?></option>
								<?php else: ?>
									<option value="<?= $value->filter_value ?>"><?= $value->filter_name ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					   </div>
					</div>
					<div class="row">
						<div id="root"></div>
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

<script type="text/javascript">
	$(document).ready(function() {
    function loadcontent() {
    	 var html = "";
          
	  var url = "<?= URL::to('/admin/api/getunitscheckins/'.$parameter) ?>/";
	  console.log(url);
	  $.get(url, function(data) {
	  	$("#root").html(data);
	  });
    }
    loadcontent();

	 setInterval(function(){
       loadcontent() // this will run after every 5 seconds
      }, 5000);

	 $(".type").change(function() {
	 	var data = $(this).val();
        var url = "<?= URL::to('admin/checkins/') ?>/"+data;
        window.location = url;
	 });
     
	});
	
</script>


@endsection
