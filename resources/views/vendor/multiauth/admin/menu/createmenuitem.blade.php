@extends('multiauth::layouts.main') 


@section('title')
Order Menu - <?php $units = Helper::get_unit_info($unit_id); echo $units[0]->unit_name; ?>
@endsection

@section('content')
<form action="{{ URL::to('admin/addmenuitem') }}" method="post" enctype="multipart/form-data">
	@csrf
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Add Menu</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Menu - <?php $units = Helper::get_unit_info($unit_id); echo $units[0]->unit_name; ?></h2>

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

					<div class="row">
						<div class="col-md-6 form-group">
							<label>Dish Name</label>
							<input type="text" name="item_name" value="" class="form-control" placeholder="Dish Name" required="required">
							
						</div>

						<div class="col-md-6 form-group">
							<label>Price</label>
							<input type="text" name="price" value="" class="form-control" placeholder="Price" required="required">
							
						</div>
	                  
                       <div class="col-md-6  form-group">
                       	<label>Status: </label>
							<select class="form-control" name="status">
								<option value="active">Active</option>
								<option value="inactive">Inactive</option>
							</select>
							
						</div>
						 <div class="col-md-6 form-group">
	                   	<label>Category</label>
							<select name="food_category_id" class="form-control">
							<?php foreach($categories as $key => $value): ?>
								<option value="<?= $value->id ?>"><?= $value->category_name ?></option>
							<?php endforeach; ?>
							</select>
							
						</div>
						<input type="hidden" name="unit_id" value="<?= $unit_id ?>">
						<div class="col-md-6  form-group">
                       	<label>Featured: </label><br />
							<input type="radio" name="featured" class="featured" value="yes"> Yes &nbsp;&nbsp; <input type="radio" name="featured" class="featured" value="no" checked="checked"> No
							<br /><br />
						</div>
						<div class="col-md-6  form-group">
                       	<label>Veg/Nonveg: </label><br />
							<input type="radio" name="veg_nonveg" value="veg"  checked="checked"> Veg &nbsp;&nbsp; <input type="radio" name="veg_nonveg" value="nonveg"> Non Veg
							<br /><br />
						</div>
						 <div class="col-md-12 form-group">
	                   	<label>Description</label>
							<textarea class="form-control" name="description" placeholder="Description"></textarea>
							
						</div>
						 <div class="col-md-6 fileupload" style="margin-bottom: 40px;">
                <h5><strong>Featured Image</strong></h5>
                <input type="file" name="featured" value="">

                
              </div>
						<div class="col-md-12">
							<input type="submit" name="submit" value="Add Menu Item" class="btn btn-primary">
							
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- Panel Content -->
</div>
</form>
<style type="text/css">
	.fileupload {
		display: none;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
       $(".featured").change(function() {
          var value = $(this).val();
          if (value=="yes") {
          	$(".fileupload").show();
          }else {
          	$(".fileupload").hide();
          }
       });
	});
</script>
@endsection
