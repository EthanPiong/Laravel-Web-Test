

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="mb-4">Our Menu</h1>
    
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0"><?php echo e($category->name); ?></h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php $__currentLoopData = $category->menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <?php if($item->image_url): ?>
                                    <img src="<?php echo e($item->image_url); ?>" class="card-img-top" alt="<?php echo e($item->name); ?>">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo e($item->name); ?></h5>
                                    <p class="card-text"><?php echo e($item->description); ?></p>
                                    <p class="card-text"><strong>$<?php echo e(number_format($item->price, 2)); ?></strong></p>
                                    
                                    <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="menu_item_id" value="<?php echo e($item->id); ?>">
                                        <div class="form-group">
                                            <label for="quantity">Quantity:</label>
                                            <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1">
                                        </div>
                                        <div class="form-group">
                                            <label for="instructions">Special Instructions:</label>
                                            <textarea name="instructions" id="instructions" class="form-control" rows="2"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\foodWeb\resources\views/menu/index.blade.php ENDPATH**/ ?>