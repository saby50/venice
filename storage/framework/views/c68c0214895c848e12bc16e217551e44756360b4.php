 


<?php $__env->startSection('title'); ?>
Rates
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
        <h2>Rates</h2>

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
  <form action="<?php echo e(URL::to('admin/rates/add')); ?>" method="post">
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
            <div class="col-md-12" style="margin-bottom: 20px;">
                      <label>Rate Type</label><br />
                   <input type="radio" name="rate_type" value="offline"> Offline &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="rate_type" value="online" checked="checked"> Online
                    </div>
             <div class="col-md-6">
                    <label>From</label>

                      <input type="text" class="form-control from" name="from" value="" autocomplete="off" id="from" required="">
                    </div>
                    <div class="col-md-6">
                      <label>To</label>
                      <input type="text" class="form-control to" name="to" value="" id="to" autocomplete="off" required="">
                    </div>
          
               <div class="col-md-6">
                   <?php if($category_id=="packs"): ?>
                   <label>Packs</label>
                       <select class="form-control" name="service_id">

                      <?php foreach ($services as $key => $value): ?>
                        <option value="<?= $value->id ?>"><?= $value->pack_name ?></option>
                      <?php endforeach; ?>
                  </select>
                  <?php else: ?>
                     <label>Service</label>
                       <select class="form-control" name="service_id">

                      <?php foreach ($services as $key => $value): ?>
                        <option value="<?= $value->id ?>"><?= $value->service_name ?></option>
                      <?php endforeach; ?>
                  </select>

                  <?php endif; ?>

                  <input type="hidden" name="type" value="<?= $category_id ?>">
                  <input type="hidden" name="category_id" value="<?= $category_id ?>">
                   
                    </div>
                         <div class="col-md-6">
                    <label>Rate</label>
                      <input type="text" class="form-control" name="rates"  required>
                    </div>
                     <div class="col-md-6">                     
                        <label>Days</label><br />
                        <?php foreach ($days as $key => $value): ?>
                          <label style="margin-right:20px;"> <input type="checkbox" class="form-control" value="<?= $value ?>" name="days[]"> <?= $value ?></label>
                        <?php endforeach; ?>
                    </div>
                     <div class="col-md-6">
                      <label>Select Time/Cuisine</label>
                      <select name="occasion_type" class="form-control">
                      <?php foreach($occasion_type as $key => $value): ?>
                      <option value="<?= $value->id ?>"><?= $value->type ?> - <?= $value->cuisine ?></option>
                      <?php endforeach; ?>
                    </select>
                    </div>
                     
                    <div class="col-md-12">                     
                      
                     <hr />
                    </div>
                  <div class="col-md-6">                     
                        <label>If Quantity</label>
                      <input type="number" class="form-control" name="quantity[]" value="">
                    </div>
                        <div class="col-md-6">                     
                        <label>Price</label>
                      <input type="number" class="form-control " name="price[]" value="">
                    </div>
                    <span class="addonfields"></span>
                    <div class="col-md-12" style="text-align: right;">
                      <input type="button" name="addmore" class="btn btn-default addfield" value="Add More">
                      
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
{
  $(".addfield").click(function() {
    $(".addonfields")
    .append(' <div class="row1">    <div class="col-md-6" style="margin-top:0px;"> \n\
            <label>If Quantity</label>\n\
              <input type="number" class="form-control" name="quantity[]" required>\n\
      </div>\n\
      <div class="col-md-6" style="margin-top:0px;">\n\
        <label>Price</label>\n\
          <input type="number" class="form-control" name="price[]" required>\n\
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

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/rates/create.blade.php ENDPATH**/ ?>