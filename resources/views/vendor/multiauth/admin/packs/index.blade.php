@extends('multiauth::layouts.main') 


@section('title')
Packs
@endsection

@section('content')
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Packs</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Pack(s)</h2>

			</div>
		</div>
		<div class="col-md-8 column">
			<div class="top-bar-chart">
				<div class="quick-report">
					<div class="quick-report-infos">

					</div>
					<?php 

                     
					?>
					<span class="bar2"><a href="<?= URL::to('admin/packs/create/'.$packs_options->alias) ?>"><button class="btn btn-primary">Create</button></a></span>
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
							<?php foreach ($data as $key => $value): ?>

								<div class="col-md-4 box_area">
									<div class="col-md-3" style="text-align:center;">
										<img src="{{ asset('images/Event_1.png') }}" style="margin-left: -30px;"><br /><br />

										<a href="<?= URL::to('admin/packs/edit/'.$value->id.'') ?>"  class="edit"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;
<a href="#" data="<?= URL::to('admin/packs/delete/'.$value->id.'') ?>" class="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a> &nbsp;
									</div>
									<div class="col-md-9">
										<h4> <?= $value->pack_name ?></h4>
										Rs. <?= $value->price ?><br />
										
									
									</div>

								</div>

							<?php endforeach; ?>
							<?php else: ?>
								No Packs Found
						<?php endif; ?>



					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- Panel Content -->
</div>
@endsection
