<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/item-purchase.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('purchase.store', ['item_id' => $item->id])); ?>" method="POST" class="purchase" id="purchase-form">
    <?php echo csrf_field(); ?>
    <div class="left-content">
        <div class="item-detail">
            <div class="item-image-container">
                <img src="<?php echo e(asset('storage/' . $item->image_path)); ?>" alt="<?php echo e($item->name); ?>" class="item-image">
            </div>

            <div class="item-info">
                <div class="item-name"><?php echo e($item->name); ?></div>
                <div class="price">
                    <span class="value">¥ <?php echo e(number_format($item->price)); ?></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="payment_method" class="payment-label">支払い方法</label>
            <select name="payment_method" id="payment_method" required>
                <option value="" disabled selected hidden>選択してください</option>
                <option value="convenience" <?php echo e(old('payment_method') === 'convenience' ? 'selected' : ''); ?>>コンビニ支払い</option>
                <option value="card" <?php echo e(old('payment_method') === 'card' ? 'selected' : ''); ?>>カード支払い</option>
            </select>
        </div>

        <div class="form-group">
            <div class="address-label">
                <div class="address">配送先</div>
                <a href="<?php echo e(route('purchase.address.edit', ['item_id' => $item->id])); ?>" class="btn-change-address">変更する</a>
            </div>
            <div class="address-info">
                <p>〒 <?php echo e($tempZipCode ?? $address['zip_code'] ?? '未登録'); ?></p>
                <p><?php echo e($tempAddress ?? $address['address'] ?? '未登録'); ?></p>
                <p><?php echo e($tempBuilding ?? $address['building'] ?? '未登録'); ?></p>
            </div>
        </div>
    </div>

    <div class="right-content">
        <div class="order-summary">
            <div class="summary-item">
                <p class="summary-label">商品代金</p>
                <p class="summary-value">¥ <?php echo e(number_format($item->price)); ?></p>
            </div>
            <div class="summary-item">
                <p class="summary-label">支払い方法</p>
                <p class="summary-value"><span id="payment-method-display">未選択</span></p>
            </div>
        </div>
        <div id="card-element" class="card-element"></div>
        <div id="card-errors" class="card-errors" role="alert"></div>
        <input type="hidden" name="stripeToken" id="stripe-token">
        <button type="submit" class="btn-purchase">購入する</button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/item-purchase.js')); ?>"></script>
    <script src="https://js.stripe.com/v3/"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/item/purchase.blade.php ENDPATH**/ ?>