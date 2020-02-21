 
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <?php echo e(ucfirst(config('multiauth.prefix'))); ?> List
                    <span class="float-right">
                        <a href="<?php echo e(route('admin.register')); ?>" class="btn btn-sm btn-success">New <?php echo e(ucfirst(config('multiauth.prefix'))); ?></a>
                    </span>
                </div>
                <div class="card-body">
    <?php echo $__env->make('multiauth::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <ul class="list-group">
                        <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo e($admin->name); ?>

                            <span class="badge">
                                    <?php $__currentLoopData = $admin->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge-warning badge-pill ml-2">
                                            <?php echo e($role->name); ?>

                                        </span> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </span>
                            <?php echo e($admin->active? 'Active' : 'Inactive'); ?>

                            <div class="float-right">
                                <a href="#" class="btn btn-sm btn-secondary mr-3" onclick="event.preventDefault(); document.getElementById('delete-form-<?php echo e($admin->id); ?>').submit();">Delete</a>
                                <form id="delete-form-<?php echo e($admin->id); ?>" action="<?php echo e(route('admin.delete',[$admin->id])); ?>" method="POST" style="display: none;">
                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                </form>

                                <a href="<?php echo e(route('admin.edit',[$admin->id])); ?>" class="btn btn-sm btn-primary mr-3">Edit</a>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php if($admins->count()==0): ?>
                        <p>No <?php echo e(config('multiauth.prefix')); ?> created Yet, only super <?php echo e(config('multiauth.prefix')); ?> is available.</p>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('multiauth::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/show.blade.php */ ?>