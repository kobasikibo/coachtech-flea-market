<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/show.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="profile-container">
        <div class="user-info">
            <div class="image-container">
                <?php if($user->image_path): ?>
                    <img src="<?php echo e(asset('storage/' . $user->image_path)); ?>" alt="User Image" class="user-image">
                <?php endif; ?>
            </div>
            <div class="user-name"><?php echo e($user->name); ?></div>
            <a href="<?php echo e(route('profile.edit')); ?>" class="edit-profile-link">プロフィールを編集</a>
        </div>

        <div class="tab-container">
            <a href="#" class="tab-link active">出品した商品</a>
            <a href="#" class="tab-link disabled">購入した商品（未実装）</a>
        </div>

        <div class="item-list">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="item">
                    <img src="<?php echo e(asset('storage/' . $item->image_path)); ?>" alt="<?php echo e($item->name); ?>" class="item-image">
                    <div class="item-name"><?php echo e($item->name); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/profile.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/profile/show.blade.php ENDPATH**/ ?>