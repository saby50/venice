 


<?php $__env->startSection('title'); ?>
Packs
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
        <h2>Packs</h2>

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
  <form action="<?php echo e(URL::to('admin/packs/add')); ?>" method="post">
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
                 <div class="col-md-4">
                    <label>Pack Type</label>

                      <select class="form-control pack_type" name="pack_type">
                        <?php foreach($packs_options as $key => $value): ?>
                           <?php if(Request::segment(4)==$value->alias): ?>
                           <option value="<?= $value->alias ?>" selected><?= $value->pack_type ?></option>
                        <?php else: ?>
                           <option value="<?= $value->alias ?>"><?= $value->pack_type ?></option>
                        <?php endif; ?>   
                        <?php endforeach; ?>
                                          
                     </select>
                    </div>
             <div class="col-md-4">
                    <label>Pack Name</label>

                      <input type="text" class="form-control" name="pack_name" >
                    </div>


                  
              
                         <div class="col-md-4">
                    <label>Rate</label>
                      <input type="text" class="form-control" name="rates"  required>
                    </div>


                 


                  <?php foreach ($categories as $key => $value): ?>
                    
                  <div class="col-md-12 catop" style="padding-left:0px;padding-right:0px;"> <div class="col-md-4 margin-top" style="padding-left:6px;padding-right:6px;">
                    <label>Category</label><br />
                     <?php 
                      list($category_name, $category_id) = explode('_', $key); 
                      ?>
                        <input type="checkbox" name="category_id[]" value="<?= $category_id ?>"> <?= $category_name ?>
                       
                    </div>
                    <div class="col-md-4 margin-top" style="padding-left: 40px;padding-top: 5px;">
                    <label>Services</label><br />
                    <?php foreach($value as $k => $v): ?>
                     <div class="col-md-6"> <input type="checkbox" name="services[]" value="<?= $v->service_id ?>"> <?= $v->service_name ?></div>
                     <div class="col-md-6">
                   
                      <input type="number" class="form-control" placeholder="Quantity" name="quantity[]">
                    </div>
                      <?php endforeach; ?>
                 
                    </div></div>
                    <?php endforeach; ?>

                    
                   

                    

                    
                      <div class="col-md-4 margin-top">
                      <label>Teaser Line 1</label><br />
                   <input type="text" class="form-control" name="line1"  required>
                   
                    </div>
                        <div class="col-md-4 margin-top">
                      <label>Teaser Line 2</label><br />
                   <input type="text" class="form-control" name="line2"  required>
                   
                    </div>
                      <div class="col-md-4 margin-top">
                      <label>Alias</label><br />
                   <input type="text" class="form-control" name="alias"  required>
                   
                    </div>
                    <div class="col-md-4 margin-top">
                       <label>Slot Size(Minutes)</label><br />
                   <input type="text" class="form-control" name="slotsize"  required>
                   
                    </div>
                     <div class="col-md-4 margin-top">
                      <label>Age</label><br />
                      <input type="text" class="form-control" name="age"  required>
                   
                    </div>
                    <div class="col-md-4 margin-top">
                      <label>Duration</label><br />
                      <input type="text" class="form-control" name="duration"  required>
                   
                    </div>
                     <div class="col-md-4 margin-top">
                      <label>Working Hours</label><br />
                      <input type="text" class="form-control" name="whours"  required>
                   
                    </div>
                     <div class="col-md-4 margin-top">
                      <label>Working Days</label><br />
                      <input type="text" class="form-control" name="wdays"  required>
                   
                    </div>
                    <div class="col-md-4 margin-top">
                  <label>No of Seats</label>
                    <input type="text" class="form-control" name="no_of_seats"  required>
                  </div>
                    <div class="col-md-6 margin-top">
                        <label>Rate Type</label><br />
                   <input type="radio" name="tax_type" value="yes" checked="checked"> Tax Inclusive &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="tax_type" value="no"> Tax Exclusive
                   
                   
                    </div>
                     <div class="col-md-6 margin-top">
                      <label>Tax</label>
                       <select class="form-control" name="tax_id">

                      <?php foreach ($taxes as $key => $value): ?>
                        <option value="<?= $value->id ?>"><?= $value->tax_name ?> (<?= $value->tax_percent ?>%)</option>
                      <?php endforeach; ?>
                  </select>
                   
                    </div>
                      <div class="col-md-6" style="margin-bottom: 20px;">
                      <label>Featured</label><br />
                   <input type="checkbox" name="featured" value="yes">
                   
                    </div>
                      <div class="col-md-6" style="margin-bottom: 20px;">
                      <label>Available for offline</label><br />
                   <input type="radio" name="offline" value="yes"> Yes &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="offline" value="no" checked="checked"> No
                   
                    </div>
                      <div class="col-md-12" style="margin-bottom: 20px;">
                     <label>Video</label><br />
                   <input type="text" name="video" value="" class="form-control">
                   
                    </div>
                      <div class="col-md-6 margin-top">
                      <label>Short Description</label><br />
                       <textarea class="form-control" id="summernote" name="shortdesc"></textarea>
                   
                    </div>

                    <div class="col-md-6 margin-top">
                      <label>Description</label><br />
                       <textarea class="form-control" id="summernote2" name="description"></textarea>                  
                    </div>
                
                   <div class="col-md-12 margin-top">
                    <label>Special Note</label>
                      <input type="text" class="form-control" name="note">
                    </div>
                      <div class="col-md-12 margin-top">
                    <label>Inclusion 1</label>
                      <input type="text" class="form-control" name="inclusion[]">
                     

                    </div>
                     <div class="col-md-12 margin-top">
                    <label>Inclusion 2</label>
                      <input type="text" class="form-control" name="inclusion[]">
                     

                    </div>
                      <span class="addonfields"></span>
                    <div class="col-md-12" style="text-align: right;margin-top: 20px;">
                       <input type="button" class="btn btn-default addfield" value="Add More">
                    </div>
              <div class="col-md-12" style="margin-top: 20px;">
              
                <input type="submit" class="btn btn-primary" value="Submit">

              </div>
          </div>

        </div>
      </div>
  
  </div>
</form>
</div><!-- Panel Content -->
</div>

        <script>
$(document).ready(function() {
  $('.from').timepicker({
    timeFormat: 'h:mm p',
    interval: 60,
    defaultTime: '8',
    startTime: '8:00',
    dynamic: false,
    dropdown: false,
    scrollbar: true
});
$('.to').timepicker({
  timeFormat: 'h:mm p',
  interval: 60,
  defaultTime: '16',
  startTime: '4:00',
  dynamic: false,
  dropdown: false,
  scrollbar: true
});
});

</script>
<script>
$(document).ready(function()
{ $('#summernote').summernote();
   $('#summernote2').summernote();
   var i = 3;
  $(".addfield").click(function() {

    $(".addonfields")
    .append('<div class="row1">    <div class="col-md-12 margin-top" style="padding-left:6px;padding-right:6px;">\n\
                    <label>Inclusion '+i+'</label>\n\
                      <input type="" class="form-control" name="inclusion[]">\n\
                    </div></div>');

    i++;
  });
  $(document).on("click", ".removeto", function (e) { //user click on remove text
      e.preventDefault();
      $(this).closest('.row1').remove();
      x--;
  })
  
});
$(document).on("change", ".service", function (e) { //user click on remove text
      e.preventDefault();
      var data = $(this).find(":selected").val();
     var url = "<?= URL::to('admin/get_services/"+data+"') ?>";
     var html="";
     var i = 1;
$.get(url, function(data) {

if (data.length != 0) {
  
  $.each(data, function(key, value) {
  html +=  '<div class="col-md-6"><input type="checkbox" name="services[]" value="'+value['id']+'">&nbsp;&nbsp;'+value['service_name']+"</div>";

  html += '<div class="col-md-6">\n\
                   \n\
                      <input type="number" class="form-control" placeholder="Quantity" name="quantity" required>\n\
                    </div>';
                    $('#location'+i).html(html);

                    i++;


  });
}else {
  html += "No Service Found";
}



});

});
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".pack_type").change(function() {
        var data = $('.pack_type').find(":selected").val();
    var url = "<?= URL::to('admin/packs/create') ?>/"+data;
    window.location = url;
    });
  });
</script>
<style type="text/css">
  .margin-top {
    margin-top: 20px;
  }
  .catop {
    margin-bottom: 10px;
    margin-top: 10px;
  }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/packs/create.blade.php ENDPATH**/ ?>