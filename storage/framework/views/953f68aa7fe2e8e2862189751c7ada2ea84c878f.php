 


<?php $__env->startSection('title'); ?>
Upload Cover
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

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
				<h2>Upload</h2>

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
  <form action="<?php echo e(URL::to('admin/movies/upload_r')); ?>" method="post">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
          <div class="row">
            <div class="col-md-12">
          <?php if(session('status')): ?>
                <div class="widget no-color">
                    <div class="notify orange-skin with-color">
                        <div class="notify-content">
                            <h3>Congratulation! <?php echo e(session('status')); ?></h3>

                        <a title="" class="close">x</a>
                        </div>
                    </div>
                    </div>
                </div>
              <?php endif; ?>
              </div>
			        		<div class="row formarea">
                    <div class="col-md-6">

                       <h5><strong>Upload Movie Cover</strong></h5>
                      <div id="fileuploader">Upload</div>
                      
                    </div>
                      
              <div class="col-md-12">
                <br />
		
                <input type="submit" class="btn btn-primary" value="Submit">

              </div>
					</div>

				</div>
			</div>
	
	</div>
</form>
</div><!-- Panel Content -->
</div>
<link href="https://hayageek.github.io/jQuery-Upload-File/4.0.11/uploadfile.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script>
<style type="text/css">
  .ajax-file-upload-statusbar {
        width: 500px !important;
            float: left;
  }
</style>
<script>
$(document).ready(function()
{
$("#fileuploader").uploadFile({
  url:"<?= URL::to('admin/movies/upload_icon') ?>",
  maxFileCount:1,
  fileName:"myfile",
  formData: {"_token":"<?php echo e(csrf_token()); ?>", 'id': "<?= $id ?>"},
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
         url: "<?= URL::to('admin/movies/load_icon/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/movies/delete_icon/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"<?php echo e(csrf_token()); ?>"},
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
   <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

<!-- The Templates plugin is included to render the upload/download listings -->
<script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- blueimp Gallery script -->
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/movies/upload.blade.php ENDPATH**/ ?>