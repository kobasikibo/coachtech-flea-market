<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'coachtechフリマ'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/sanitize.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/common.css')); ?>">
    <?php echo $__env->yieldContent('css'); ?>
</head>

<body>
    <header class="header">
        <div class="header-inner">
            <div class="header-container">
                <a class="header-logo" href="/">
                    <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="coachtechフリマのロゴ">
                </a>
            </div>

            <?php if(!in_array(request()->route()->getName(), ['login', 'register'])): ?>
                <div class="header-container">
                    <div class="header-center">
                        <form class="search-form" action="<?php echo e(route('item.index')); ?>" method="GET">
                            <input type="hidden" name="tab" value="<?php echo e(request()->query('tab', 'recommend')); ?>">
                            <input type="text" name="query" value="<?php echo e(request()->get('query', '')); ?>" placeholder="なにをお探しですか？">
                        </form>
                    </div>
                </div>

                <div class="header-container">
                    <div class="header-links">
                        <?php if(auth()->guard()->check()): ?>
                            <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="link-style-button">ログアウト</button>
                            </form>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="link-login">ログイン</a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('mypage.show')); ?>" class="link-mypage">マイページ</a>
                        <a href="<?php echo e(route('item.create')); ?>" class="link-sell">出品</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html><?php /**PATH /var/www/resources/views/layouts/app.blade.php ENDPATH**/ ?>