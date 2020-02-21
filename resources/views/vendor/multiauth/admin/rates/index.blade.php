@extends('multiauth::layouts.main') 


@section('title')
Rates
@endsection

@section('content')
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Rates</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Rate(s)</h2>

			</div>
		</div>
		<div class="col-md-8 column">
			<div class="top-bar-chart">
				<div class="quick-report">
					<div class="quick-report-infos">

					</div>
					<span class="bar2"><a href="<?= URL::to('admin/rates/create/'.$category_id) ?>"><button class="btn btn-primary">Create</button></a></span>
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
					<div class="row">
						<div class="col-md-3" style="margin-bottom: 20px;">
							<label>Categories</label>
							<select class="categories form-control">
								<?php if($category_id=="packs"): ?>
									<?php foreach($categories as $key => $value): ?>
								<option value="<?= $value->id ?>"><?= $value->category_name ?></option>
							    <?php endforeach; ?>
							    <option value="packs" selected>GV Packs</option>
								<?php else: ?>
									<?php foreach($categories as $key => $value): ?>
										<?php if($category_id==$value->id): ?>
								<option value="<?= $value->id ?>" selected><?= $value->category_name ?></option>
								<?php else: ?>
									<option value="<?= $value->id ?>"><?= $value->category_name ?></option>
								<?php endif; ?>
							    <?php endforeach; ?>
							    <option value="packs">GV Packs</option>
								<?php endif; ?>
								
							</select>
							
						</div>
						
					</div>

					<div class="row">

						<?php if (count($data) != 0): ?>
							<?php foreach ($data as $key => $value): ?>

								<div class="col-md-4 box_area">
									<div class="col-md-3" style="text-align:center;">
										<img src="{{ asset('images/Event_1.png') }}" style="margin-left: -30px;"><br /><br />

										<a href="<?= URL::to('admin/rates/edit/'.$value->id.'/'.$category_id) ?>"  class="edit"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;
<a href="#" data="<?= URL::to('admin/rates/delete/'.$value->id.'') ?>" class="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a> &nbsp;
									</div>
									<div class="col-md-9">
										<h4> <?= $value->fromtime ?> - <?= $value->totime ?></h4>
										Rs. <?= $value->rates ?><br />
										<b>Service:</b> <?= $value->service_name ?><br />
										<b>Type:</b> <?= ucfirst($value->rate_type) ?><br />
									
									</div>

								</div>

							<?php endforeach; ?>
							
							<?php else: ?>
								No Rates Found
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
		$(".categories").change(function() {
				var data = $('.categories').find(":selected").val();
		var url = "<?= URL::to('admin/rates') ?>/"+data;
		window.location = url;
		});
	});
</script>
@endsection
