 <?php if($file): ?>
        <?php $__currentLoopData = $file; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="container-avatar">
                <img src="<?php echo e(route('user.image',['filename'=>$f->image_path])); ?>" class='avatar'>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php /**PATH C:\Users\Leveque\ProjecteLarabel\laravel-bootstrap\resources\views/user/image.blade.php ENDPATH**/ ?>