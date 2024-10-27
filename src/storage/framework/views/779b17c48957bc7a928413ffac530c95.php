<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/item-show.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="item-detail">
    <!-- 左側：商品画像 -->
    <div class="item-image-container">
        <img src="<?php echo e(asset('storage/' . $item->image_path)); ?>" alt="<?php echo e($item->name); ?>" class="item-image">
    </div>

    <!-- 右側：商品情報 -->
    <div class="item-info">
        <div class="item-name"><?php echo e($item->name); ?></div>
        <div class="brand-name">ブランド<?php echo e($item->brand); ?></div>

        <div class="price">
            ¥<span class="value"><?php echo e(number_format($item->price)); ?></span> (税込)
        </div>

        <!-- アイコン一覧 -->
        <div class="item-icons">
            <img src="<?php echo e(asset('images/icons/like-icon.png')); ?>" alt="いいね" class="icon">
            <img src="<?php echo e(asset('images/icons/comment-icon.png')); ?>" alt="コメント" class="icon">
        </div>

        <!-- 商品説明 -->
        <div class="item-description-label">商品説明</div>
        <p class="item-description"><?php echo e($item->description); ?></p>

        <!-- 商品の情報 -->
        <h2 class="item-information-label">商品の情報</h2>

        <!-- カテゴリ一覧 -->
        <div class="item-categories">
            <span class="category-label">カテゴリー</span>
            <?php $__currentLoopData = $item->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="category-name"><?php echo e($category->name); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="item-condition">
            <span class="condition-label">商品の状態</span>
            <span class="condition"><?php echo e($item->condition); ?></span>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/item/show.blade.php ENDPATH**/ ?>