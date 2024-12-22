<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/form-styles.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/item-create.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h1>商品の出品</h1>

    <?php if($errors->any()): ?>
        <div class="error">
            <ul class="error-list">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="error-item"><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('item.store')); ?>" method="POST" enctype="multipart/form-data" novalidate>
        <?php echo csrf_field(); ?>

        <div class="image-label">商品画像</div>
        <div class="image-container">
            <img class="image" src="" alt="Image">
            <input type="file" name="image" class="image-upload" required accept=".jpeg,.png" onchange="previewImage(event)">
            <label class="upload-button" onclick="document.querySelector('.image-upload').click();">画像を選択する</label>
        </div>

        <!-- 商品の詳細セクション -->
        <h2 class="section-title">商品の詳細</h2>

        <div class="category-label">カテゴリー</div>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="category-item">
                    <input type="checkbox" name="category_ids[]" value="<?php echo e($category->id); ?>" id="category-<?php echo e($loop->index); ?>" class="category-checkbox">
                    <label class="category" for="category-<?php echo e($loop->index); ?>"><?php echo e($category->name); ?></label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="form-group">
            <div class="condition-label">商品の状態</div>
            <select name="condition" class="form-input" required>
                <option value="" class="disabled" disabled selected hidden>選択してください</option>
                <?php $__currentLoopData = $conditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($condition); ?>"><?php echo e($condition); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <h2 class="section-title">商品名と説明</h2>

        <div class="form-group">
            <div class="name-label">商品名</div>
            <input type="text" name="name" class="form-input" required>
        </div>

        <div class="form-group">
            <div class="brand-label">ブランド名</div>
            <input type="text" name="brand" class="form-input">
        </div>

        <div class="form-group">
            <div class="description-label">商品の説明</div>
            <textarea rows="3" name="description" class="form-input" required></textarea>
        </div>

        <div class="form-group">
            <div class="price-label">販売価格</div>
            <input type="text" name="price" class="form-input" required>
        </div>

        <button type="submit" class="btn-submit">出品する</button>
    </form>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/item-create.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/item/create.blade.php ENDPATH**/ ?>