<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/item.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header-center'); ?>
    <div class="header__center">
        <form class="search-form" action="/search" method="GET">
            <input type="text" name="query" placeholder="なにをお探しですか？">
            <button type="submit">検索</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header-right'); ?>
    <div class="header__right-links">
        <?php if(auth()->guard()->check()): ?>
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
                <?php echo csrf_field(); ?>
                <button type="submit" class="link-style-button">ログアウト</button>
            </form>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="link-login">ログイン</a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/item.blade.php ENDPATH**/ ?>