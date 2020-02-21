<?php
  $addons = Helper::get_item_addons($item_id);
?>
<?php $__env->startSection('title'); ?>
Add Ons
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form method="post" action="<?= URL::to('update_cart') ?>">
  <?php echo csrf_field(); ?>
<div class="recyclerview login-form firstbox" style="font-size: 14px;">
<div class="row">
  <div class="col-md-12">
    <?php $titles=""; foreach($addons as $key => $value): ?>
      <div class="addontitle"><?= $value->title ?></div>
      <?php 
          $title = strtolower($value->title);
          $title_name = str_replace(" ", "_", $title);
          $titles.= $title_name.",";



      ?>
     
    <?php 
        $addonlist = Helper::get_item_addons_list($value->id);
        foreach ($addonlist as $k => $v):
     ?>
     <?php if($value->type=="radio"): ?>
      <?php if($k==0): ?>
     <input type="radio" name="<?= $title_name ?>" value="<?= $v->addon_name."_".$v->cost ?>" checked="checked"> <?= $v->addon_name ?> <span style="font-size: 12px;"><i class="fa fa-inr"></i> <?= $v->cost ?></span>
     <?php else: ?>
      <input type="radio" name="<?= $title_name ?>" value="<?= $v->addon_name."_".$v->cost ?>"> <?= $v->addon_name ?> <span style="font-size: 12px;"><i class="fa fa-inr"></i> <?= $v->cost ?></span>
     <?php endif; ?>
     <?php else: ?>
      <input type="checkbox" name="<?= $title_name ?>[]" value="<?= $v->addon_name."_".$v->cost ?>"> <?= $v->addon_name ?> <span style="font-size: 12px;"><i class="fa fa-inr"></i> <?= $v->cost ?></span>
     <?php endif; ?>
     <br />
   <?php endforeach; ?>
   <br />
    <?php endforeach; ?>

    
    
  </div>
  <div class="col-md-12" style="margin-top: 20px;">
    <input type="submit" class="form-control" name="update_order" value="Update Order">
    
  </div>
  
</div>

</div>
<input type="hidden" name="item_id" value="<?= $item_id ?>">
 <input type="hidden" name="titles" value="<?= rtrim($titles,",") ?>">
</form>
<style type="text/css">
  .addontitle {
    font-weight:600;
    margin-bottom: 10px;
    font-size: 14px;
  }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/menu/addons.blade.php ENDPATH**/ ?>