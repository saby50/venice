@extends('multiauth::layouts.main') 


@section('title')
Roles
@endsection

@section('content')
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Roles</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Roles</h2>

			</div>
		</div>
		<div class="col-md-8 column">
			<div class="top-bar-chart">
				<div class="quick-report">
					<div class="quick-report-infos">

					</div>
					<span class="bar2"><a href="{{URL::to('admin/manage_users/create')}}"><button class="btn btn-primary">Create</button></a></span>
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

						<?php if (count($data) != 0): ?>
							<table class="table">
								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Role</th>
										<th></th>
										<th></th>
									</tr>
								</thead>

							<tbody>
							<?php foreach ($data as $key => $value): ?>
								
									<tr>
										<td><?= $value->name ?></td>
										<td><?= $value->email ?></td>
										<td><?= $value->phone ?></td>
										<td><?php 
                                         echo Helper::get_roles_by_alias($value->user_type);
										 ?>
									</td>
										<td><a href="<?= URL::to('admin/manage_users/edit/'.$value->id.'') ?>"  class="edit"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a></td>
										<td><a href="#" data="<?= URL::to('admin/manage_users/delete/'.$value->id.'') ?>" class="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></td>
									</tr>
								

								
							<?php endforeach; ?>
							</tbody>
							</table>
							<?php else: ?>
								No Managers Found
						<?php endif; ?>



					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- Panel Content -->
</div>
@endsection
