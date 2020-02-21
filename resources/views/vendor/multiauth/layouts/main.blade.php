<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" data-ng-app="tutorialWebApp"> <!--<![endif]-->
<head>

    <!-- Meta-Information -->
    <title> {{ ucfirst(config('multiauth.prefix')) }}  @yield('title') </title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Vendor: Bootstrap Stylesheets http://getbootstrap.com -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Our Website CSS Styles -->
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sass.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
<script src="{{ asset('js/jquery-2.1.3.js') }}"></script>
<!-- include summernote css/js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
</head>
<body>
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Our Website Content Goes Here -->
@include('vendor.multiauth.layouts.header')
@yield('content') 

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- <script src="{{ asset('js/main.js') }}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
 <!-- Modal -->
 <div class="modal fade" id="myModalSuspended" role="dialog">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <div class="modal-header">
       
         <h4 class="modal-title">Oops</h4>
       </div>
       <div class="modal-body">
         <p>Your Unit is suspended by Admin! Please contact the support. </p>
       </div>
       <div class="modal-footer">
         <a href="/admin/logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><button type="button" class="btn btn-primary" id="yesExit">Logout</button></a>
                                                     
       </div>
     </div>
   </div>
 </div>
  <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Alert</h4>
       </div>
       <div class="modal-body">
         <p>Are you sure you want to delete?</p>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-primary" data="" id="yes" data-dismiss="modal">Yes</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
       </div>
     </div>
   </div>
 </div>
   <!-- Modal -->
 <div class="modal fade" id="notification" role="dialog">
   <div class="modal-dialog modal-md">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Notifications</h4>
       </div>
       <div class="modal-body">
        <?php 
          $data = Helper::get_unit_notifications();
        ?>
        <?php $i=0;  foreach($data as $key => $value): ?>
          <div class="featured-pwa ripple row">
          <div class="col-md-7">
             <span class="" style="font-size: 15px;color: #000000;font-weight: 500"><?= $value->title ?></span><br />
          </div>
          <div class="col-md-4" style="text-align: right;">
             <span class="date2"><?= date('d M, Y', strtotime($value->created_at)) ?></span><br />
          </div>
          <div class="col-md-12">
             <span class="desc"><?= $value->message ?></span><br />
          </div>
           
            
        </div>
  
        <?php if($i == count($data) - 1): ?>
        <?php else: ?>
          <hr />
        <?php endif; ?>
        

        <?php 
          $i++;
        ?>
        <?php endforeach; ?>
         
       </div>
       <div class="modal-footer" style="display: none;">
         <button type="button" class="btn btn-primary" data="" id="yes" data-dismiss="modal">Yes</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
       </div>
     </div>
   </div>
 </div>

 <script type="text/javascript">
        $(document).ready(function() {
        // $("header nav").css('display','block');
          $(".delete").click(function() {
          $("#myModal").modal("show");
          var data = $(this).attr("data");
          $("#yes").attr("data", data);

          });
          $("#yes").click(function() {
            var data = $(this).attr("data");
            window.location = data;
          });
        });

        $(document).ready(function() {
          $(".horizontal-menu").click(function() {
             // $("header nav").toggle('slow');
          });
          $("#notificationbtn").click(function() {
          //  $("header nav").css('display','block');
            $("#notification").modal("show");

          });
        });

      </script>
      <!-- include summernote css/js -->
      
<?php if($type=="web" || $type=="all"): ?>
 @include('multiauth::admin.notifications')
<?php endif; ?>  
<style type="text/css">
  .ripple {
    position: relative;
    overflow: hidden;
    transform: translate3d(0, 0, 0);
}
.date {
    font-size: 12px;
    color: #999;
}
.recyclerview {
    width: 100%;
    height: auto;
    background: #FFF;
    margin-top: 10px;
    padding: 20px;
}
.featured-pwa {
    margin-top: 10px;
}
</style>

</body>
</html>