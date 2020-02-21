 


<?php $__env->startSection('title'); ?>
Services
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
<?php 
$note = "";
$status  = "active";
foreach ($data as $key => $value) {
  $service_name = $value->service_name;
  $no_seats = $value->no_seats;

   $category_id = $value->category_id;
   $tax_id = $value->tax_id;
   $service_id = $value->id;
   $tax_id = $value->tax_id;
   $teaser_line_1 = $value->teaser_line_1;
   $teaser_line_2 = $value->teaser_line_2;
   $short_description = $value->short_description;
   $description = $value->description;
   $tax_type = $value->tax_type;
   $suspend = $value->suspend;
   $duration = $value->duration;
   $age = $value->age;
   $alias = $value->alias;
   $slotsize = $value->slotsize;
   $video = $value->video;
   $featured = $value->featured;
   $note = $value->notes;
   $offline = $value->offline;
   $status = $value->status;

}

?>
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
        <h2>Services</h2>

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
  <form action="<?php echo e(URL::to('admin/services/update')); ?>" method="post">
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
                <label>Service Name</label>
                <input type="text" class="form-control" name="service_name" value="<?= $service_name ?>" required>
              </div>
              
                <div class="col-md-6">
                  <label>No of Seats</label>
                    <input type="text" class="form-control" name="no_of_seats" value="<?= $no_seats ?>"  required>
                  </div>
                   <div class="col-md-6">
                  <label>Duration</label>
                    <input type="text" class="form-control" name="duration" value="<?= $duration ?>" required>
                  </div>
            <div class="col-md-6">
                  <label>Age</label>
                    <input type="text" class="form-control" name="age" value="<?= $age ?>" required>
                  </div>
                  <div class="col-md-6">
                    <label>Category</label>
                       <select class="form-control" name="category_id">

                      <?php foreach ($categories as $key => $value): ?>
                        <?php if($category_id==$value->id): ?>
                        <option value="<?= $value->id ?>" selected><?= $value->category_name ?></option>
                        <?php else: ?>
                          <option value="<?= $value->id ?>"><?= $value->category_name ?></option> 
                        <?php endif; ?>
                      <?php endforeach; ?>
                  </select>
                  <input type="hidden" name="service_id" value="<?= $service_id ?>">
                    </div>
   <div class="col-md-6">
                    <label>Tax</label>
                       <select class="form-control" name="tax_id">

                      <?php foreach ($taxes as $key => $value): ?>
                        <option value="<?= $value->id ?>"><?= $value->tax_name ?> (<?= $value->tax_percent ?>%)</option>
                      <?php endforeach; ?>
                  </select>
                    </div>
                 <div class="col-md-6">
                      <label>Slot Size(Minutes)</label><br />
                   <input type="text" class="form-control" name="slotsize" value="<?= $slotsize ?>"  required>
                   
                    </div>
                     <div class="col-md-6">
                      <label>Alias</label><br />
                   <input type="text" class="form-control" name="alias" value="<?= $alias ?>"  required>
                   
                    </div>
                        <div class="col-md-6">
                      <label>Teaser Line 1</label><br />
                   <input type="text" class="form-control" name="line1" value="<?= $teaser_line_1 ?>"  required>
                   
                    </div>
                        <div class="col-md-6">
                      <label>Teaser Line 2</label><br />
                   <input type="text" class="form-control" name="line2" value="<?= $teaser_line_2 ?>"  required>
                   
                    </div>
                      <div class="col-md-6">
                      <label>Short Description</label><br />
                       <textarea class="form-control" id="summernote" name="shortdesc"><?= $short_description ?></textarea>
                   
                    </div>
                    <div class="col-md-6">
                      <label>Description</label><br />
                       <textarea class="form-control" id="summernote2" name="description"><?= $description ?></textarea>                  
                    </div>
                 
                     
                     
                     <div class="col-md-6">

                  <label>Rate Type</label><br />
                  <?php if($tax_type=="yes"): ?>
                   <input type="radio" name="tax_type" value="yes" checked> Tax Inclusive &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="tax_type" value="no"> Tax Exclusive

                   <?php else: ?>
                     <input type="radio" name="tax_type" value="yes" > Tax Inclusive &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="tax_type" value="no" checked> Tax Exclusive

                   <?php endif; ?>
                   
                    </div>
                    <div class="col-md-6">
                      <label>Suspend</label><br />
                      <?php if($suspend=="yes"): ?>
                         <input type="radio" name="suspend" value="yes" checked="checked"> Yes &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="suspend" value="no"  > No

                      <?php else: ?>
                         <input type="radio" name="suspend" value="yes"> Yes &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="suspend" value="no"  checked="checked"> No

                      <?php endif; ?>
                  
                   
                    </div>
                    <div class="col-md-4" style="margin-bottom: 20px;">
                      <label>Featured</label><br />
                      <?php if($featured=="yes"): ?>
                   <input type="checkbox" name="featured" value="yes" checked="checked">
                   <?php else: ?>
                    <input type="checkbox" name="featured" value="yes">
                   <?php endif; ?>
                   
                    </div>
                     <div class="col-md-4" style="margin-bottom: 20px;">
                      <label>Available for offline</label><br />
                       <?php if($offline=="yes"): ?>
                       <input type="radio" name="offline" value="yes" checked="checked"> Yes &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="offline" value="no"> No

                      <?php else: ?>
                        <input type="radio" name="offline" value="yes"> Yes &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="offline" value="no" checked="checked"> No

                      <?php endif; ?>
                   
                   
                    </div>
                     <div class="col-md-4" style="margin-bottom: 20px;">
                      <label>Status</label><br />
                       <?php if($status=="active"): ?>
                       <input type="radio" name="status" value="active" checked="checked"> Active &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="status" value="inactive"> Inactive

                      <?php else: ?>
                        <input type="radio" name="status" value="active"> Active &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="status" value="inactive" checked="checked"> Inactive

                      <?php endif; ?>
                   
                   
                    </div>
                     <div class="col-md-12" style="margin-bottom: 20px;">
                      <label>Video</label><br />
                   <input type="text" name="video" value="<?= $video ?>" class="form-control">
                   
                    </div>
                      <div class="col-md-12 margin-top" style="margin-bottom: 20px;">
                    <label>Special Note</label>
                      <input type="text" class="form-control" name="note" value="<?= $note ?>">
                    </div>
                    <?php foreach($service_options as $key => $value): ?>
                        <div class="col-md-6">
                         <label>Custom Options</label><br />
                    <input type="text" class="form-control" name="custom_options[]" value="<?= $value->option_name ?>" disabled>
                    </div>
                      <div class="col-md-6">
                         <label>Capacity</label><br />
                    <input type="number" class="form-control" name="capacity[]" value="<?= $value->capacity ?>" disabled>
                    </div>
                  <?php endforeach; ?>
                     <span class="addonfields"></span>
                    <div class="col-md-12" style="text-align: right;">
                       <input type="button" class="btn btn-default addfield" value="Add More">
                    </div>
                      

              <div class="col-md-12">
                <br />
                <table id="address" style="display:none;">
                  <tr>
                    <td class="label">Street address</td>
                    <td class="slimField"><input class="field" id="street_number"
                          disabled="true"></input></td>
                    <td class="wideField" colspan="2"><input class="field" id="route"
                          disabled="true"></input></td>
                  </tr>
                  <tr>
                    <td class="label">City</td>
                    <!-- Note: Selection of address components in this example is typical.
                         You may need to adjust it for the locations relevant to your app. See
                         https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform
                    -->
                    <td class="wideField" colspan="3"><input class="field" id="locality"
                          disabled="true"></input></td>
                  </tr>
                  <tr>
                    <td class="label">State</td>
                    <td class="slimField"><input class="field"
                          id="administrative_area_level_1" disabled="true"></input></td>
                    <td class="label">Zip code</td>
                    <td class="wideField"><input class="field" id="postal_code"
                          disabled="true"></input></td>
                  </tr>
                  <tr>
                    <td class="label">Country</td>
                    <td class="wideField" colspan="3"><input class="field"
                          id="country" disabled="true"></input></td>
                  </tr>
                </table>
                <input type="submit" class="btn btn-primary" value="Next">

              </div>
          </div>

        </div>
      </div>
  
  </div>
</form>
</div><!-- Panel Content -->
</div>
<script>
$(document).ready(function()
{
 $('#summernote').summernote();
   $('#summernote2').summernote();
  $(".addfield").click(function() {
    $(".addonfields")
    .append(' <div class="row1">    <div class="col-md-6" style="margin-top:0px;"> \n\
            <label>Custom Option</label>\n\
              <input type="text" class="form-control" name="custom_options[]" required>\n\
      </div>\n\
      <div class="col-md-6" style="margin-top:0px;">\n\
        <label>Capacity</label>\n\
          <input type="number" class="form-control" name="capacity[]" required>\n\
          <a class="minus"><i class="fa fa-minus-square-o removeto" aria-hidden="true"></i></a>\n\
  </div></div>');
  });
  $(document).on("click", ".removeto", function (e) { //user click on remove text
      e.preventDefault();
      $(this).closest('.row1').remove();
      x--;
  })
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/services/edit.blade.php ENDPATH**/ ?>