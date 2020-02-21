 
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><?php echo e(ucfirst(config('multiauth.prefix'))); ?> Dashboard</div>

                <div class="card-body">
                <?php echo $__env->make('multiauth::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                     You are logged in to <?php echo e(config('multiauth.prefix')); ?> side!
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('multiauth::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\xampp\nxampp\htdocs\venice\vendor\bitfumes\laravel-multiauth\src/views/admin/home.blade.php */ ?>