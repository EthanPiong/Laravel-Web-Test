<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="jumbotron">
        <h1 class="display-4">Welcome to Food Ordering!</h1>
        <p class="lead">Order your favorite food online and get it delivered to your doorstep.</p>
        <hr class="my-4">
        <p>Browse our menu and place your order in just a few clicks.</p>
        <a class="btn btn-primary btn-lg" href="<?php echo e(route('menu.index')); ?>" role="button">View Menu</a>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-utensils fa-3x mb-3 text-primary"></i>
                    <h3 class="card-title">Wide Selection</h3>
                    <p class="card-text">Choose from a variety of delicious dishes from multiple cuisines.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-truck fa-3x mb-3 text-primary"></i>
                    <h3 class="card-title">Fast Delivery</h3>
                    <p class="card-text">Get your food delivered quickly to your doorstep.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-mobile-alt fa-3x mb-3 text-primary"></i>
                    <h3 class="card-title">Easy Ordering</h3>
                    <p class="card-text">Order food easily through our user-friendly platform.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\foodWeb\resources\views/home.blade.php ENDPATH**/ ?>