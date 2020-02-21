 


<?php $__env->startSection('title'); ?>
Packs
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<?php
 $pack_name = "";
  $price = 0;
  $teaser_line_1 = "";
  $teaser_line_2 = "";
  $short_description = "";
  $description = "";
  $note = "";
  $alias = "";
  $slotsize = 0;
  $age = 0;
  $duration = 0;
  $wdays = "";
  $whours = "";
  $pack_type = "";
  $tax_type = "";
  $status  = "active";
foreach ($data as $key => $value) {
  $pack_name = $value->pack_name;
  $price = $value->price;
  $teaser_line_1 = $value->teaser_line_1;
  $teaser_line_2 = $value->teaser_line_2;
  $short_description = $value->short_description;
  $description = $value->description;
  $note = $value->note;
  $alias = $value->alias;
  $slotsize = $value->slotsize;
  $age = $value->age;
  $duration = $value->duration;
  $wdays = $value->wdays;
  $whours = $value->whours;
  $pack_type = $value->pack_type;
  $tax_type = $value->tax_type;
   $video = $value->video;
   $offline = $value->offline;
   $no_seats = $value->no_seats;
   $status = $value->status;
}
$selectedcat = "";
$selectedserv = "";
$squantity_service = "";
foreach ($packs_services as $key => $value) {
  $selectedcat .= $value->category_id.",";
  $selectedserv .= $value->service_id.",";
  $squantity_service .= $value->quantity."_".$value->service_id;
}
$selectcatarray = explode(",", $selectedcat);
$selectedservarray = explode(",", $selectedserv);
 
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
  <form action="<?php echo e(URL::to('admin/packs/update')); ?>" method="post">
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

                      <select class="form-control pack_type" name="pack_type" readonly>
                        <option value="<?= $pack_type ?>"><?= $pack_type ?></option>
                                          
                     </select>
                    </div>
             <div class="col-md-4">
                    <label>Pack Name</label>

                      <input type="text" class="form-control" name="pack_name" value="<?= $pack_name ?>">
                      <input type="hidden" name="pack_id" value="<?= $id ?>">
                    </div>


                  
              
                         <div class="col-md-4">
                    <label>Rate</label>
                      <input type="text" class="form-control" name="rates" value="<?= $price ?>"  required>
                    </div>
                      

                    

                  <?php foreach ($categories as $key => $value): ?>
                    
                  <div class="col-md-12 catop" style="padding-left:0px;padding-right:0px;"> <div class="col-md-4 margin-top" style="padding-left:6px;padding-right:6px;">
                    <label>Category</label><br />
                     <?php 
                      list($category_name, $category_id) = explode('_', $key); 
                      ?>
                      <?php if(in_array($category_id, $selectcatarray)): ?>
                        <input type="checkbox" name="category_id[]" value="<?= $category_id ?>" checked> <?= $category_name ?>
                        <?php else: ?>
                          <input type="checkbox" name="category_id[]" value="<?= $category_id ?>"> <?= $category_name ?>
                      <?php endif; ?>

                       
                    </div>
                    <div class="col-md-4 margin-top" style="padding-left: 40px;padding-top: 5px;">
                    <label>Services</label><br />
                   
                    <?php foreach($value as $k => $v): ?>
                       <?php if(in_array($v->service_id, $selectedservarray)): ?>
                     <div class="col-md-6">
                    <?php 
                       list($a, $b) = explode('_', $squantity_service);
                      
                    ?>
                     
                     
                      <input type="checkbox" name="services[]" value="<?= $v->service_id ?>" class="services2" checked> <?= $v->service_name ?>
                    </div>
                     <div class="col-md-6">
                 <input type="number" class="form-control quantity2" placeholder="Quantity"  value="<?= $a ?>"  name="quantity[]">
                 
                    </div>
                        <?php else: ?>
                          <div class="col-md-6">
                     
                      <input type="checkbox" name="services[]" value="<?= $v->service_id ?>"> <?= $v->service_name ?>
                      </div>
                        <div class="col-md-6">
                     <input type="number" class="form-control quantity2" placeholder="Quantity" value="0" name="quantity[]">
                      </div>
                      <?php endif; ?>
                    
                   
                      <?php endforeach; ?>
                 
                    </div></div>
                    <?php endforeach; ?>
                    
                     <div class="col-md-4 margin-top">
                      <label>Teaser Line 1</label><br />
                   <input type="text" class="form-control" name="line1" value="<?= $teaser_line_1 ?>"  required>
                   
                    </div>
                        <div class="col-md-4 margin-top">
                      <label>Teaser Line 2</label><br />
                   <input type="text" class="form-control" name="line2" value="<?= $teaser_line_2 ?>"  required>
                   
                    </div>
                      <div class="col-md-4 margin-top">
                      <label>Alias</label><br />
                   <input type="text" class="form-control" name="alias" value="<?= $alias ?>"  required>
                   
                    </div>
                    <div class="col-md-4 margin-top">
                       <label>Slot Size(Minutes)</label><br />
                   <input type="text" class="form-control" name="slotsize" value="<?= $slotsize ?>"  required>
                   
                    </div>
                     <div class="col-md-4 margin-top">
                      <label>Age</label><br />
                      <input type="text" class="form-control" name="age" value="<?= $slotsize ?>"  required>
                   
                    </div>
                    <div class="col-md-4 margin-top">
                      <label>Duration</label><br />
                      <input type="text" class="form-control" name="duration" value="<?= $duration ?>"  required>
                   
                    </div>
                     <div class="col-md-4 margin-top">
                      <label>Working Hours</label><br />
                      <input type="text" class="form-control" name="whours" value="<?= $whours ?>"  required>
                   
                    </div>
                     <div class="col-md-4 margin-top">
                      <label>Working Days</label><br />
                      <input type="text" class="form-control" name="wdays" value="<?= $wdays ?>"  required>
                   
                    </div>
                     <div class="col-md-4 margin-top">
                  <label>No of Seats</label>
                    <input type="text" class="form-control" name="no_of_seats" value="<?= $no_seats ?>"  required>
                  </div>
                     <div class="col-md-6">

                  <label>Rate Type</label><br />
                  <?php if($tax_type=="yes"): ?>
                   <input type="radio" name="tax_type" value="yes" checked> Tax Inclusive &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="tax_type" value="no"> Tax Exclusive

                   <?php else: ?>
                     <input type="radio" name="tax_type" value="yes" > Tax Inclusive &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="tax_type" value="no" checked> Tax Exclusive

                   <?php endif; ?>
                   
                    </div>
                     <div class="col-md-6 margin-top">
                      <label>Tax</label>
                       <select class="form-control" name="tax_id">

                      <?php foreach ($taxes as $key => $value): ?>
                        <option value="<?= $value->id ?>"><?= $value->tax_name ?> (<?= $value->tax_percent ?>%)</option>
                      <?php endforeach; ?>
                  </select>
                   
                    </div>
                       <div class="col-md-4" style="margin-bottom: 20px;">
                      <label>Featured</label><br />
                   <input type="checkbox" name="featured" value="yes">
                   
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
                      <div class="col-md-6" style="margin-bottom: 20px;">
                     <label>Video</label><br />
                   <input type="text" name="video" class="form-control" value="<?= $video ?>">
                   
                    </div>
                      <div class="col-md-6">
                      <label>Short Description</label><br />
                       <textarea class="form-control" id="summernote" name="shortdesc"><?= $short_description ?></textarea>
                   
                    </div>

                    <div class="col-md-6">
                      <label>Description</label><br />
                       <textarea class="form-control" id="summernote2" name="description"><?= $description ?></textarea>                  
                    </div>
                
                   <div class="col-md-12 margin-top">
                    <label>Special Note</label>
                      <input type="text" class="form-control" name="note" value="<?= $note ?>">
                    </div>
                    <?php 
                      $i = 1;
                    ?>
                    <?php if(count($packs_inclusions)==0): ?>
                      <div class="col-md-12 margin-top">
                    <label>Inclusion <?= $i ?></label>
                      <input type="text" class="form-control" name="inclusion[]" value="">
                    </div>
                    <?php else: ?>
                    <?php foreach($packs_inclusions as $key => $value): ?>
                      <div class="col-md-12 margin-top">
                    <label>Inclusion <?= $i ?></label>
                      <input type="text" class="form-control" name="inclusion[]" value="<?= $value->inclusions ?>">
                    </div>
                    <?php $i++; ?>
                  <?php endforeach; ?>
                  <?php endif; ?>
                     
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

$(document).ready(function() {

     
      $.each($(".services2:checked"), function(){            
         var service_id = $(this).val();

         var pack_id = "<?= $id ?>";
         var url = "<?= URL::to('admin/packs/get_quantity/"+service_id+"/"+pack_id+"') ?>";
           $.ajax({
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
           $(this).next().find('input.quantity2').attr('value',result[0]['quantity']);
        }
     })

      
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

<?php echo $__env->make('multiauth::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/packs/edit.blade.php ENDPATH**/ ?>