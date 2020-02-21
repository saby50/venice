@extends('multiauth::layouts.main') 


@section('title')
Settings
@endsection

@section('content')
<?php 
foreach ($data as $key => $value) {
	$emails = $value->emails;
	$service = $value->service;
}

?>
<div class="main-content style2"> 


<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Setting(s)</h2>

			</div>
		</div>
		<div class="col-md-8 column">
			<div class="top-bar-chart">
				<div class="quick-report">
					<div class="quick-report-infos">

					</div>
					<!-- <span class="bar2"><a href="{{URL::to('admin/venue/create')}}"><button class="btn btn-primary">Create</button></a></span> -->
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

					<div class="row" style="min-height: 200px;">
						<form action="{{ URL::to('admin/updatemailers') }}" method="post">
							@csrf
						<div class="col-md-4">
							<label>Select Service</label>
							<select class="form-control" name="service">
								<?php if($service=="contact"): ?>
									<option value="contact" selected>Contact Form</option>
							    <?php else: ?>
								  <option value="contact">Contact Form</option>
								<?php endif; ?>
								
							<?php foreach($services as $key => $value): ?>
										<?php if($service==$value->alias): ?>
									<option value="<?= $value->alias ?>" selected><?= $value->service_name ?></option>
							    <?php else: ?>
								  <option value="<?= $value->alias ?>"><?= $value->service_name ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php foreach($packs as $key => $value): ?>
									<?php if($service==$value->alias): ?>
									<option value="<?= $value->alias ?>" selected><?= $value->pack_name ?></option>
							    <?php else: ?>
								  <option value="<?= $value->alias ?>"><?= $value->pack_name ?></option>
								<?php endif; ?>

							<?php endforeach; ?>
						</select>
						<input type="hidden" name="id" value="<?= $id ?>">
						</div>
						<div class="col-md-4">
							<label>Enter Email</label>
							<input type="text" name="email" class="form-control" value="<?= $emails ?>">
						</div>
						<div class="col-md-4" style="padding-top: 5px;">
							<br />
							<input type="submit" name="" class="btn btn-primary" value="Update">			
						</div>
                      </form>
					</div>
					<div class="row">
						<?php if(count($data) != 0): ?>
							<table class="table">
								<thead>
									<tr>
										<th>Service</th>
										<th>Email</th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($data as $key => $value): ?>
										<tr>
											<td><?= $value->service ?></td>
											<td><?= $value->emails ?></td>
											<td><a href="<?= URL::to('admin/edit_mailer/'.$value->id) ?>" class="edit"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a></td>
											<td><a href="#" data="<?= URL::to('admin/delete_mailer/'.$value->id) ?>" class="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
								
							</table>
                        <?php else: ?>
                        	<h3>No Emailers Added</h3>

						<?php endif; ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- Panel Content -->
</div>
@endsection
