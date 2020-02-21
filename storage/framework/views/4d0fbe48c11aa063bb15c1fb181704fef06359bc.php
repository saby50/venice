 
<?php 
	$unit_id = "";
	foreach ($data as $key => $value) {
		$unit_id = $value->unit_id;
		$item_name = $value->item_name;
		$description = $value->description;
		$price = $value->price;
		$status = $value->status;
		$featured = $value->featured;
		$food_category_id = $value->food_category_id;
		$veg_nonveg = $value->veg_nonveg;
	} 
?>

<?php $__env->startSection('title'); ?>
Order Menu - <?php $units = Helper::get_unit_info($unit_id); echo $units[0]->unit_name; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(URL::to('admin/updatemenuitem')); ?>" method="post">
	<?php echo csrf_field(); ?>
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
	<?php if(session('status')): ?>
				<div class="widget no-color">
						<div class="alert alert-success">
								<div class="notify-content">
									 <?php echo e(session('status')); ?>!

								</div>
						</div>
						</div>
				</div>
			<?php endif; ?>
			</div>
	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">

					<div class="row">
						<div class="col-md-6 form-group">
							<label>Dish Name</label>
							<input type="text" name="item_name" value="<?= $item_name ?>" class="form-control" placeholder="Dish Name" required="required">
							
						</div>

						<div class="col-md-6 form-group">
							<label>Price</label>
							<input type="text" name="price" value="<?= $price ?>" class="form-control" placeholder="Price" required="required">
							
						</div>
	                  
                       <div class="col-md-6  form-group">
                       	<label>Status: </label>
							<select class="form-control" name="status">
								<?php if($status=="active"): ?>
									<option value="active" selected="selected">Active</option>
								    <option value="inactive">Inactive</option>
								<?php else: ?>
								    <option value="active">Active</option>
								    <option value="inactive" selected="selected">Inactive</option>
								<?php endif; ?>
								
							</select>
							
						</div>
						<input type="hidden" name="item_id" value="<?= $item_id ?>">
						 <div class="col-md-6 form-group">
	                   	<label>Category</label>
							<select name="food_category_id" class="form-control">
							<?php foreach($categories as $key => $value): ?>
								<?php if($food_category_id==$value->id): ?>
								<option value="<?= $value->id ?>" selected><?= $value->category_name ?></option>
								<?php else: ?>
								<option value="<?= $value->id ?>"><?= $value->category_name ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
							</select>
							
						</div>
						<input type="hidden" name="unit_id" value="<?= $unit_id ?>">
						<div class="col-md-6  form-group">
                       	<label>Featured: </label><br />
                       	<?php if($featured=="yes"): ?>
							<input type="radio" name="featured" value="yes" checked="checked"> Yes &nbsp;&nbsp; <input type="radio" name="featured" value="no"> No
						<?php else: ?>
							<input type="radio" name="featured" value="yes"> Yes &nbsp;&nbsp; <input type="radio" name="featured" value="no" checked="checked"> No
						<?php endif; ?>	
							<br /><br />
						</div>
						<div class="col-md-6  form-group">
                       	<label>Veg/Nonveg: </label><br />
                       		<?php if($veg_nonveg=="veg"): ?>
							<input type="radio" name="veg_nonveg" value="veg" checked="checked"> Veg &nbsp;&nbsp; <input type="radio" name="veg_nonveg" value="nonveg"> Non Veg
							<?php else: ?>
								<input type="radio" name="veg_nonveg" value="veg"> Veg &nbsp;&nbsp; <input type="radio" name="veg_nonveg" value="nonveg" checked="checked"> Non Veg
							<?php endif; ?>	
							<br /><br />
						</div>
						 <div class="col-md-12 form-group">
	                   	<label>Description</label>
							<textarea class="form-control" name="description" placeholder="Description"><?= $description ?></textarea>
							
						</div>
						
                    <div class="col-md-6" style="margin-bottom: 40px;">
                <h5><strong>Featured Image</strong></h5>
                <div id="fileuploader">Upload</div>

                
              </div>
              
            
             

             

              	
             
						<div class="col-md-12">
							<input type="submit" name="submit" value="Update Item" class="btn btn-primary">
							
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- Panel Content -->
</div>
</form>

<link href="https://hayageek.github.io/jQuery-Upload-File/4.0.11/uploadfile.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
  	$("#fileuploader").uploadFile({
  url:"<?= URL::to('admin/menu/upload_featured_item') ?>",
  maxFileCount:1,
  fileName:"myfile",
  formData: {"_token":"<?php echo e(csrf_token()); ?>", 'id': "<?= $item_id ?>"},
  acceptFiles:"image/*",
  showDelete: true,
  returnType: "json",
  showDownload:false,
  showPreview:true,
  previewHeight: "100px",
  previewWidth: "100px",
  onLoad:function(obj)
   {
    $.ajax({
        cache: false,
         url: "<?= URL::to('admin/menu/load_featured_item/'.$item_id) ?>",
        dataType: "json",
        success: function(data)
        {
          for(var i=0;i<data.length;i++)
          {
            obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
          }
          }
    });
  },
  deleteCallback: function (data, pd) {
    for (var i = 0; i < data.length; i++) {
        $.post("<?= URL::to('admin/menu/delete_featured_item/') ?>",  {op: "delete",name: data[i], id : "<?= $item_id ?>","_token":"<?php echo e(csrf_token()); ?>"},
            function (resp,textStatus, jqXHR) {
                //Show Message
                alert("File Deleted");
            });
    }
    pd.statusbar.hide(); //You choice.

}
  
});
	
  


  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/menu/editmenuitem.blade.php ENDPATH**/ ?>