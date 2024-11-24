<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/address-edit.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/profile-edit.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h1>プロフィール設定</h1>

    <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" novalidate>
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="image-group">
            <div class="image-container">
                <?php if($user->profile_image): ?>
                    <img src="<?php echo e(asset('storage/' . $user->profile_image)); ?>" class="user-image">
                <?php endif; ?>
            </div>
            <label class="file-label">
                画像を選択する
                <input type="file" name="profile-image" class="profile-image">
            </label>

            <?php $__errorArgs = ['profile_image'];
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

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" name="name" class="form-input" value="<?php echo e(old('name', $user->name)); ?>" required>

            <?php $__errorArgs = ['name'];
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

        <div class="form-group">
            <label for="zip_code">郵便番号</label>
            <input type="text" name="zip_code" class="form-input" value="<?php echo e(old('zip_code', $address->zip_code ?? '')); ?>" required>

            <?php $__errorArgs = ['zip_code'];
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

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" class="form-input" value="<?php echo e(old('address', $address->address ?? '')); ?>" required>

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
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" class="form-input" value="<?php echo e(old('building', $address->building ?? '')); ?>" required>

            <?php $__errorArgs = ['building'];
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

        <button type="submit" class="btn-update">更新する</button>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/profile-edit.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/profile/edit.blade.php ENDPATH**/ ?>