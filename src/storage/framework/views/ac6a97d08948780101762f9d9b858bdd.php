<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/create.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h1>商品の出品</h1>

    <?php if($errors->any()): ?>
        <div class="error-messages">
            <ul class="error-list">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="error-item"><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('item.store')); ?>" method="POST" enctype="multipart/form-data" novalidate>
        <?php echo csrf_field(); ?>

        <label class="image-label">商品画像</label>
        <div class="image-container">
            <img class="image" src="" alt="Image">
            <input type="file" name="image" class="image-upload" required accept=".jpeg,.png" onchange="previewImage(event)">
            <label class="upload-button" onclick="document.querySelector('.image-upload').click();">画像を選択する</label>
        </div>

        <!-- 商品の詳細セクション -->
        <h2 class="section-title">商品の詳細</h2>

        <h3 class="subsection-title">カテゴリー</h3>
        <div class="category-list">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="category-item">
                    <input type="checkbox" name="categories[]" value="<?php echo e($category->id); ?>" id="category-<?php echo e($loop->index); ?>" class="category-checkbox">
                    <label class="category-label" for="category-<?php echo e($loop->index); ?>"><?php echo e($category->name); ?></label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <h3 class="subsection-title">商品の状態</h3>
        <div class="condition">
            <select name="condition" class="condition-select" required>
                <option value="" disabled selected hidden>選択してください</option>
                <?php $__currentLoopData = $conditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($condition); ?>"><?php echo e($condition); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- 商品名と説明セクション -->
        <h2 class="section-title">商品名と説明</h2>

        <div class="name">
            <label class="name-label">商品名</label>
            <input type="text" name="name" class="name-input" required>
        </div>

        <div class="brand">
            <label class="brand-label">ブランド名</label>
            <input type="text" name="brand" class="brand-input" placeholder="例: Nike" >
        </div>

        <div class="description">
            <label class="description-label">商品の説明</label>
            <textarea name="description" class="description-textarea" required maxlength="255"></textarea>
        </div>

        <div class="price">
            <label class="price-label">販売価格</label>
            <input type="number" name="price" class="price-input" required min="0">
        </div>

        <button type="submit" class="submit-button">出品する</button>
    </form>

    <script>
        function previewImage(event) {
            const preview = document.querySelector('.image');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.add('show');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/item/create.blade.php ENDPATH**/ ?>