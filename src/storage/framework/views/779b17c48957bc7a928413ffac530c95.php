<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/item-show.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="item-detail">
    <div class="item-image-container">
        <img src="<?php echo e(asset('storage/' . $item->image_path)); ?>" alt="<?php echo e($item->name); ?>" class="item-image">
    </div>

    <div class="item-info">
        <div class="item-name"><?php echo e($item->name); ?></div>
        <div class="brand-name"><?php echo e($item->brand); ?></div>

        <div class="price">
            ¥<span class="value"><?php echo e(number_format($item->price)); ?></span> (税込)
        </div>

        <div class="item-icons">
            <form action="<?php echo e(route('item.like', ['item_id' => $item->id])); ?>" method="POST" class="like-form">
                <?php echo csrf_field(); ?>
                <button type="submit" class="like-button <?php echo e($item->likedByUsers()->where('user_id', auth()->id())->exists() ? 'liked' : ''); ?>" data-item-id="<?php echo e($item->id); ?>">
                    <img src="<?php echo e(asset('images/icons/like-icon.png')); ?>" alt="いいね" class="icon">
                    <span class="likes-count"><?php echo e($item->likedByUsers()->count()); ?></span>
                </button>
            </form>
            <div class="comment-icon">
                <img src="<?php echo e(asset('images/icons/comment-icon.png')); ?>" alt="コメント" class="icon">
                <span class="comments-count"><?php echo e($item->comments()->count()); ?></span>
            </div>
        </div>

        <div class="purchase-button-container">
            <a href="<?php echo e(route('purchase.show', ['item_id' => $item->id])); ?>" class="submit-button">購入手続きへ</a>
        </div>

        <h2 class="item-description-label">商品説明</h2>
        <p class="item-description"><?php echo e($item->description); ?></p>

        <h2 class="item-information-label">商品の情報</h2>

        <!-- カテゴリ一覧 -->
        <div class="item-categories">
            <span class="category-label">カテゴリー</span>
            <div class="categories">
                <?php $__currentLoopData = $item->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="category-name"><?php echo e($category->name); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="item-condition">
            <span class="condition-label">商品の状態</span>
            <span class="condition"><?php echo e($item->condition); ?></span>
        </div>

        <!-- コメント一覧 -->
        <h2 class="comment-label">コメント（<?php echo e($item->comments()->count()); ?>）</h2>
        <div class="comments-section">
        <?php $__currentLoopData = $item->comments()->latest()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="comment">
                <div class="user-info">
                    <div class="user-image-container">
                        <img src="<?php echo e(asset('storage/' . $comment->user->profile_image)); ?>" class="user-image">
                    </div>
                    <span class="user-name"><?php echo e($comment->user->name); ?></span>
                </div>
                <div class="comment-content">
                    <p><?php echo e($comment->content); ?></p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="comment-form">
            <form action="<?php echo e(route('comments.store', ['item_id' => $item->id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <label for="comment-content" class="comment-form-label">商品へのコメント</label>
                <textarea name="content" rows="3" required maxlength="255"><?php echo e(old('content')); ?></textarea>
                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="error-message"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <button type="submit" class="submit-button">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        window.isAuthenticated = <?php echo json_encode(auth()->check(), 15, 512) ?>;
    </script>
    <script src="<?php echo e(asset('js/item-show.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/item/show.blade.php ENDPATH**/ ?>