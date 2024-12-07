<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/exhibition.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/profile-show.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="profile-container">
        <div class="user-info">
            <div class="image-container">
                <?php if($user->profile_image): ?>
                    <img src="<?php echo e(asset('storage/' . $user->profile_image)); ?>" class="user-image">
                <?php endif; ?>
            </div>
            <div class="user-name"><?php echo e($user->name); ?></div>
            <a href="<?php echo e(route('profile.edit')); ?>" class="edit-profile-link">プロフィールを編集</a>
        </div>

        <div class="tab-container">
            <a href="<?php echo e(url('/mypage?tab=sell')); ?>" class="tab-link <?php echo e($tab === 'sell' ? 'active' : ''); ?>">出品した商品</a>
            <a href="<?php echo e(url('/mypage?tab=buy')); ?>" class="tab-link <?php echo e($tab === 'buy' ? 'active' : ''); ?>">購入した商品</a>
        </div>

        <div class="item-list">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="item">
                    <a href="<?php echo e(route('item.show', ['item_id' => $item->id])); ?>">
                        <img src="<?php echo e(asset('storage/' . $item->image_path)); ?>" alt="<?php echo e($item->name); ?>">
                    </a>
                    <div class="item-name"><?php echo e($item->name); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/profile-show.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/profile/show.blade.php ENDPATH**/ ?>