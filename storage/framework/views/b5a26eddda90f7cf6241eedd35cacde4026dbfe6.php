 


<?php $__env->startSection('title'); ?>
Services
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
  <form action="<?php echo e(URL::to('admin/events/uploadr')); ?>" method="post">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
          <div class="row">
            
			        		<div class="row formarea">
                   
                       <div class="col-md-6">

                       <h5><strong>Upload Banner</strong></h5>
                      <div id="fileuploader3">Upload</div>
                       
                    </div>
                      <div class="col-md-6">
                     
                      
                       <h5><strong>Upload Mobile Banner</strong></h5>
                      <div id="fileuploader5">Upload</div>
                    </div>
                   
                      <div class="col-md-12">
                      <hr />
                       <h5><strong>Upload Gallery</strong></h5>
                      <div id="fileuploader2">Upload</div>
                    </div>
                 
                     <div class="col-md-6">
                      <hr />
                       <h5><strong>Upload Featured App</strong></h5>
                      <div id="fileuploader6">Upload</div>
                    </div>
                     <div class="col-md-6">
                      <hr />
                       <h5><strong>Upload Video Icon</strong></h5>
                      <div id="fileuploader7">Upload</div>
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
$("#fileuploader6").uploadFile({
  url:"<?= URL::to('admin/events/upload_featured_app') ?>",
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
         url: "<?= URL::to('admin/events/load_featured_app/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/events/delete_featured_app/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"<?php echo e(csrf_token()); ?>"},
            function (resp,textStatus, jqXHR) {
                //Show Message
                alert("File Deleted");
            });
    }
    pd.statusbar.hide(); //You choice.

}
  
});
$("#fileuploader7").uploadFile({
  url:"<?= URL::to('admin/events/upload_video_icon') ?>",
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
         url: "<?= URL::to('admin/events/load_video_icon/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/events/delete_video_icon/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"<?php echo e(csrf_token()); ?>"},
            function (resp,textStatus, jqXHR) {
                //Show Message
                alert("File Deleted");
            });
    }
    pd.statusbar.hide(); //You choice.

}
  
});
$("#fileuploader3").uploadFile({
  url:"<?= URL::to('admin/events/upload_banner') ?>",
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
         url: "<?= URL::to('admin/events/load_banner/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/events/delete_banner/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"<?php echo e(csrf_token()); ?>"},
            function (resp,textStatus, jqXHR) {
                //Show Message
                alert("File Deleted");
            });
    }
    pd.statusbar.hide(); //You choice.

}
  
});
$("#fileuploader5").uploadFile({
  url:"<?= URL::to('admin/events/upload_mobile_banner') ?>",
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
         url: "<?= URL::to('admin/events/load_mobile_banner/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/events/delete_mobile_banner/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"<?php echo e(csrf_token()); ?>"},
            function (resp,textStatus, jqXHR) {
                //Show Message
                alert("File Deleted");
            });
    }
    pd.statusbar.hide(); //You choice.

}
  
});
  $("#fileuploader2").uploadFile({
 url:"<?= URL::to('admin/events/upload_gallery') ?>",
  fileName:"myfile2",
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
         url: "<?= URL::to('admin/events/load_gallery/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/events/delete_gallery/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"<?php echo e(csrf_token()); ?>"},
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

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/events/uploads.blade.php ENDPATH**/ ?>