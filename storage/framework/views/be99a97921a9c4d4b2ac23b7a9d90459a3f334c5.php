 
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><?php echo e(ucfirst(config('multiauth.prefix'))); ?> Change Your Password</div>

                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('admin.password.change')); ?>" aria-label="<?php echo e(__('Admin Change Password')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group row">
                            <label for="oldPassword" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Old Password')); ?></label>

                            <div class="col-md-6">
                                <input id="oldPassword" type="password" class="form-control<?php echo e($errors->has('oldPassword') ? ' is-invalid' : ''); ?>" name="oldPassword" value="<?php echo e($oldPassword ?? old('oldPassword')); ?>"
                                    required autofocus> <?php if($errors->has('oldPassword')): ?>
                                <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('oldPassword')); ?></strong>
                                    </span> <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Password')); ?></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password"
                                    required> <?php if($errors->has('password')): ?>
                                <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span> <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Confirm Password')); ?></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo e(__('Change Password')); ?>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('multiauth::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/admin/passwords/change.blade.php */ ?>