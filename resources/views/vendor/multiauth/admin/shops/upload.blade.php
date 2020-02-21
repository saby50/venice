@extends('multiauth::layouts.main') 


@section('title')
Shops
@endsection


@section('content')

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
				<h2>Shops</h2>

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
  <form action="{{ URL::to('admin/shops/uploadr') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
          <div class="row">
            <div class="col-md-12">
          @if (session('status'))
                <div class="widget no-color">
                    <div class="notify orange-skin with-color">
                        <div class="notify-content">
                            <h3>Congratulation! {{ session('status') }}</h3>

                        <a title="" class="close">x</a>
                        </div>
                    </div>
                    </div>
                </div>
              @endif
              </div>
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
                       <h5><strong>Upload Gallery Images</strong></h5>
                      <div id="fileuploader2">Upload</div>
                    </div>
                     <div class="col-md-12">
                       <hr />
                     </div>
                    <div class="col-md-6">
                     
                      
                       <h5><strong>Upload Homepage Square Image</strong></h5>
                      <div id="fileuploader4">Upload</div>
                    </div>
                    <div class="col-md-6">                      
                      <h5><strong>Upload Logo</strong></h5>
                     <div id="fileuploader9">Upload</div>
                    </div>
                     <div class="col-md-12">
                       <hr />
                     </div>
                    <div class="col-md-6">                     
                    <h5><strong>Upload Homepage Footer Banner</strong></h5>
                    <div id="fileuploader7">Upload</div>
                    </div>
                    <div class="col-md-6">                      
                    <h5><strong>Upload Homepage Footer Mobile Banner</strong></h5>
                    <div id="fileuploader8">Upload</div>
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
$("#fileuploader7").uploadFile({
  url:"<?= URL::to('admin/shops/upload_home_banner') ?>",
  maxFileCount:1,
  fileName:"myfile",
  formData: {"_token":"{{ csrf_token()}}", 'id': "<?= $id ?>"},
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
         url: "<?= URL::to('admin/shops/load_home_banner/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/shops/delete_home_banner/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"{{ csrf_token()}}"},
            function (resp,textStatus, jqXHR) {
                //Show Message
                alert("File Deleted");
            });
    }
    pd.statusbar.hide(); //You choice.

}
  
});
$("#fileuploader9").uploadFile({
  url:"<?= URL::to('admin/shops/upload_logo') ?>",
  maxFileCount:1,
  fileName:"myfile",
  formData: {"_token":"{{ csrf_token()}}", 'id': "<?= $id ?>"},
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
         url: "<?= URL::to('admin/shops/load_logo/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/shops/delete_logo/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"{{ csrf_token()}}"},
            function (resp,textStatus, jqXHR) {
                //Show Message
                alert("File Deleted");
            });
    }
    pd.statusbar.hide(); //You choice.

}
  
});
$("#fileuploader8").uploadFile({
  url:"<?= URL::to('admin/shops/upload_home_mobile_banner') ?>",
  maxFileCount:1,
  fileName:"myfile",
  formData: {"_token":"{{ csrf_token()}}", 'id': "<?= $id ?>"},
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
         url: "<?= URL::to('admin/shops/load_home_mobile_banner/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/shops/delete_home_mobile_banner/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"{{ csrf_token()}}"},
            function (resp,textStatus, jqXHR) {
                //Show Message
                alert("File Deleted");
            });
    }
    pd.statusbar.hide(); //You choice.

}
  
});
$("#fileuploader4").uploadFile({
  url:"<?= URL::to('admin/shops/upload_featured') ?>",
  maxFileCount:1,
  fileName:"myfile",
  formData: {"_token":"{{ csrf_token()}}", 'id': "<?= $id ?>"},
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
         url: "<?= URL::to('admin/shops/load_featured/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/shops/delete_featured/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"{{ csrf_token()}}"},
            function (resp,textStatus, jqXHR) {
                //Show Message
                alert("File Deleted");
            });
    }
    pd.statusbar.hide(); //You choice.

}
  
});
$("#fileuploader3").uploadFile({
  url:"<?= URL::to('admin/shops/upload_banner') ?>",
  maxFileCount:1,
  fileName:"myfile",
  formData: {"_token":"{{ csrf_token()}}", 'id': "<?= $id ?>"},
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
         url: "<?= URL::to('admin/shops/load_banner/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/shops/delete_banner/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"{{ csrf_token()}}"},
            function (resp,textStatus, jqXHR) {
                //Show Message
                alert("File Deleted");
            });
    }
    pd.statusbar.hide(); //You choice.

}
  
});
$("#fileuploader5").uploadFile({
  url:"<?= URL::to('admin/shops/upload_mobile_banner') ?>",
  maxFileCount:1,
  fileName:"myfile",
  formData: {"_token":"{{ csrf_token()}}", 'id': "<?= $id ?>"},
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
         url: "<?= URL::to('admin/shops/load_mobile_banner/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/shops/delete_mobile_banner/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"{{ csrf_token()}}"},
            function (resp,textStatus, jqXHR) {
                //Show Message
                alert("File Deleted");
            });
    }
    pd.statusbar.hide(); //You choice.

}
  
});
  $("#fileuploader2").uploadFile({
 url:"<?= URL::to('admin/shops/upload_gallery') ?>",
  fileName:"myfile2",
  formData: {"_token":"{{ csrf_token()}}", 'id': "<?= $id ?>"},
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
         url: "<?= URL::to('admin/shops/load_gallery/'.Request::segment(4)) ?>",
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
        $.post("<?= URL::to('admin/shops/delete_gallery/') ?>",  {op: "delete",name: data[i], id : "<?= Request::segment(4) ?>","_token":"{{ csrf_token()}}"},
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
@endsection
