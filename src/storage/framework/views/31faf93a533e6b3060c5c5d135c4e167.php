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
                    <span class="value"><span class="currency-symbol">¥ </span><?php echo e(number_format($item->price)); ?></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="payment-label-container">
                <div class="payment-label">支払い方法</div>
                <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <select name="payment_method" required>
                <option value="convenience" disabled selected hidden>選択してください</option>
                <option value="convenience" <?php echo e(old('payment_method') === 'convenience' ? 'selected' : ''); ?>>コンビニ支払い</option>
                <option value="card" <?php echo e(old('payment_method') === 'card' ? 'selected' : ''); ?>>カード支払い</option>
            </select>
        </div>

        <div class="form-group">
            <div class="label-container">
                <div class="address-label">配送先</div>
                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <a href="<?php echo e(route('purchase.address.edit', ['item_id' => $item->id])); ?>" class="btn-change-address">変更する</a>
            </div>
            <div class="address-info">
                <?php if(!empty($address['zip_code'])): ?>
                    <p>〒 <?php echo e($address['zip_code']); ?></p>
                <?php endif; ?>
                <p><?php echo e($shippingAddress ?? $address['address'] ?? ''); ?><p>
                <p><?php echo e($shippingBuilding ?? $address['building'] ?? ''); ?></p>
            </div>
        </div>
    </div>

    <div class="right-content">
        <div class="order-summary">
            <div class="summary-item">
                <p class="summary-label">商品代金</p>
                <p class="summary-value"><span class="currency-symbol">¥ </span><?php echo e(number_format($item->price)); ?></p>
            </div>
            <div class="summary-item">
                <p class="summary-label">支払い方法</p>
                <p class="summary-value"><span id="payment-method-display"></span></p>
            </div>
        </div>
        <button type="submit" class="btn-purchase">購入する</button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/item-purchase.js')); ?>"></script>
    <script src="https://js.stripe.com/v3/"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/item/purchase.blade.php ENDPATH**/ ?>