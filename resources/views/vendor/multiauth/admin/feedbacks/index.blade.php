@extends('multiauth::layouts.main') 
@section('title')
Feedbacks
@endsection
@section('content')
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Feedbacks</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Feedback(s): <?= $data->total() ?> Records</h2>

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
		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
					<div class="row" style="margin-bottom: 40px;">
						<div class="col-md-4">
							<label>Filter</label>
							<select class="form-control servicefilter">
								<option value="all" data="all">All Services</option>
								<?php foreach($services as $key => $value): ?>
									<?php if($value->alias==$type2): ?>
									<option value="<?= $value->alias ?>" data="service" selected><?= $value->service_name ?></option>
									<?php else: ?>
										<option value="<?= $value->alias ?>" data="service"><?= $value->service_name ?></option>
								<?php endif; ?>
								<?php endforeach; ?>
								<?php foreach($packs as $key => $value): ?>
									<?php if($value->alias==$type2): ?>
									<option value="<?= $value->alias ?>" data="packs" selected><?= $value->pack_name ?></option>
									<?php else: ?>
										<option value="<?= $value->alias ?>" data="packs"><?= $value->pack_name ?></option>
								<?php endif; ?>
								<?php endforeach; ?>
								
							</select>
							
						</div>
						
					</div>

					<div class="row">

					<?php if(count($data) != 0): ?>
						<table class="table">
								<thead>
									<tr>
										<th>Customer Details</th>
										
										<th>Service</th>
										<th>Rating</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
						<?php foreach($data as $key => $value): ?>
							<tr>
								<td> <?= $value->name ?><br />
									<?php if ($value->email != "") {
										echo $value->email."<br />";
									}  ?><?= $value->phone ?></td>
								<td><strong><?= $value->order_id ?></strong><br /><?php 
                                  	$details = Helper::check_feedback_service($value->order_id,$value->type);
                                   	foreach ($details as $k => $v) {
                                   		if ($value->type=="packs") {
                                   			echo $v->pack_name."<br />";
                                   		}else {
                                   			echo $v->service_name."<br />";
                                   		}
                                   		
                                   		echo "<strong>Arrival Date:</strong> ".date('d M Y', strtotime($v->date))."<br />";
                                   		echo "<strong>Arrival Time:</strong> ".$v->time;
                                   	}
                       
								?></td>
								<td style="width: 200px;"><?php echo $value->rating.'<i class="fa fa-star fa-lg" style="color:#FFD700;"></i> '; ?><br /><br /><?= $value->comments ?></td>
								<td><?= date('d M, Y H:i A', strtotime($value->created_at)) ?></td>
							</tr>
							
								
							
						<?php endforeach; ?>
						</tbody>
						</table>
						{{ $data->links() }}
                    <?php else: ?>
                    	<h3>No Feedback Found!</h3>
					<?php endif; ?>	


					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- Panel Content -->
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(".servicefilter").change(function() {
				var data = $('.servicefilter').find(":selected").val();
				var data2  = $('.servicefilter').find(":selected").attr('data');
		var url = "<?= URL::to('admin/feedbacks') ?>/"+data+"/"+data2;
		window.location = url;
		});
	});
</script>
@endsection
