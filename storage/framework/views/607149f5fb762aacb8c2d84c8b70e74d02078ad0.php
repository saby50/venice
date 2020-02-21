<?php if(session()->has('message') || session()->has('status')): ?>
    <div class="alert alert-success"><?php echo e(session()->get('message')); ?></div>
<?php endif; ?>

<?php if($errors->count() > 0): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert alert-danger"><?php echo e($error); ?></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /* C:\xampp\nxampp\htdocs\venice\vendor\bitfumes\laravel-multiauth\src/views/message.blade.php */ ?>