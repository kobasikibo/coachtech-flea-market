<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/profile.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="profile-container">
        <div class="profile-image <?php echo e($user->profile_image ? '' : 'default-profile'); ?>">
            <?php if($user->profile_image): ?>
                <img src="<?php echo e(asset('storage/' . $user->profile_image)); ?>" alt="プロフィール画像">
            <?php else: ?>
                <span class="default-text">画像がありません</span>
            <?php endif; ?>
        </div>

        <div class="profile-info">
            <h2><?php echo e($user->name); ?></h2>
            <a href="<?php echo e(route('profile.edit')); ?>" class="btn">プロフィールを編集</a>
        </div>

        <!-- タブの切り替え -->
        <div class="tabs">
            <ul class="tab-list">
                <li class="tab-item <?php echo e(request('tab') === 'sell' ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('mypage.show', ['tab' => 'sell'])); ?>">出品した商品</a>
                </li>
                <li class="tab-item <?php echo e(request('tab') === 'buy' ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('mypage.show', ['tab' => 'buy'])); ?>">購入した商品</a>
                </li>
            </ul>
        </div>

        <!-- 商品一覧 -->
        <div class="item-list">
            
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/profile/show.blade.php ENDPATH**/ ?>