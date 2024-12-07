<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/exhibition.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/item-index.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="tab-container">
        <a href="<?php echo e(url('/')); ?>?tab=recommend&query=<?php echo e(request('query', '')); ?>" class="tab-link <?php echo e(request('tab', 'recommend') === 'recommend' ? 'active' : ''); ?>">おすすめ</a>
        <a href="<?php echo e(url('/')); ?>?tab=mylist&query=<?php echo e(request('query', '')); ?>" class="tab-link <?php echo e(request('tab') === 'mylist' ? 'active' : ''); ?>">マイリスト</a>
    </div>

    <div class="item-list">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="item <?php if($item->is_purchased): ?> sold <?php endif; ?>">
                    <div class="item-img-container">
                        <a href="<?php echo e(route('item.show', ['item_id' => $item->id])); ?>">
                            <img src="<?php echo e(asset('storage/' . $item->image_path)); ?>" alt="<?php echo e($item->name); ?>">
                        </a>
                        <?php if($item->is_purchased): ?>
                            <div class="sold-label">Sold</div>
                        <?php endif; ?>
                    </div>
                <div class="item-name"><?php echo e($item->name); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/item-index.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/item/index.blade.php ENDPATH**/ ?>