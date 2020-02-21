<div class="toggle-content">
    <div class="panel-setting">
        <div class="row">
            <div class="col-md-2 column">
                <div class="custom-text">
                    <h4>Our Total Counts</h4>
                    <p>Rinter took a galley of type and scrambled ajnare tokeraline..</p>
                </div>
            </div>
            <div class="col-md-10 column">
                <div class="quick-stats">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="quick-stats-box">
                                <p class="data-attributes">
                                    <i>$56</i>
                                    <span data-peity='{ "fill": ["#faa5ff", "rgba(255,255,255,0.15)"],   "innerRadius": 47, "radius": 50 }'>5/7</span>
                                </p>
                                <span>Today Earnings</span>
                            </div>
                        </div>
                       <div class="col-md-2">
                            <div class="quick-stats-box">
                                <p class="data-attributes">
                                    <i>$786</i>
                                    <span data-peity='{ "fill": ["#ffb8b8", "rgba(255,255,255,0.15)"],   "innerRadius": 47, "radius": 50 }'>3/7</span>
                                </p>
                                <span>Refferel</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="quick-stats-box">
                                <p class="data-attributes">
                                    <i>$345</i>
                                    <span data-peity='{ "fill": ["#ace9ff", "rgba(255,255,255,0.15)"],   "innerRadius": 47, "radius": 50 }'>4/7</span>
                                </p>
                                <span>Commision</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="quick-stats-box">
                                <p class="data-attributes">
                                    <i>$223</i>
                                    <span data-peity='{ "fill": ["#b8b8ff", "rgba(255,255,255,0.15)"],   "innerRadius": 47, "radius": 50 }'>6/7</span>
                                </p>
                                <span>New Sales</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="total-sales-info">
                                <span>Total sales made of all time</span>
                                <h3>$1,225</h3>
                                <ul>
                                    <li>
                                        <span>Target</span>
                                        <h5>$2,251</h5>
                                    </li>
                                    <li>
                                        <span>Today</span>
                                        <h5>$107</h5>
                                    </li>
                                    <li>
                                        <span>All time</span>
                                        <h5>$3,463</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class="fa fa-close"></span>
</div><!-- Toggle Content -->

<?php if ($type=="app"): ?>
<?php else: ?>
    <div class="top-bar style2">
    <div class="logo">
        <a href="<?= URL::to('admin/home') ?>" title=""><i class="fa fa-deviantart"></i> <?php echo e(config('app.name', 'Laravel')); ?></a>
    </div>
    
   
</div><!-- Top Bar -->
<header class="horizontal-menu">
    <span class="open-hide-menu"><i class="fa fa-bars"></i></span>
   <?php echo $__env->make('vendor.multiauth.layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</header>
<?php endif; ?>
<?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/vendor/multiauth/layouts/header.blade.php ENDPATH**/ ?>