

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="mb-4">Your Cart</h1>
    
    <?php if(session('cart') && count(session('cart')) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Instructions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0 ?>
                    <?php $__currentLoopData = session('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $total += $details['price'] * $details['quantity'] ?>
                        <tr>
                            <td><?php echo e($details['name']); ?></td>
                            <td>$<?php echo e(number_format($details['price'], 2)); ?></td>
                            <td><?php echo e($details['quantity']); ?></td>
                            <td>$<?php echo e(number_format($details['price'] * $details['quantity'], 2)); ?></td>
                            <td><?php echo e($details['instructions'] ?? 'None'); ?></td>
                            <td>
                                <form action="<?php echo e(route('cart.remove')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="id" value="<?php echo e($id); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td colspan="3"><strong>$<?php echo e(number_format($total, 2)); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="text-right mt-4">
            <a href="<?php echo e(route('menu.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
            
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('orders.create')); ?>" class="btn btn-success">
                    <i class="fas fa-check"></i> Proceed to Checkout
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login to Checkout
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Your cart is empty. <a href="<?php echo e(route('menu.index')); ?>">Browse our menu</a> to add items.
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\foodWeb\resources\views/cart.blade.php ENDPATH**/ ?>