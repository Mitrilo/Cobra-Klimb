<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            

                        
        <?php if($file): ?>
            <?php $__currentLoopData = $file; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="container-avatar">
                    <img src="<?php echo e(route('user.image',['filename'=>$f->image_path])); ?>" width="50%" height="50%">
                    <span class="nickname date">
                        <br>
                        @<?php print($f->user->nick) ?><?php echo e(' | '.\FormatTime::LongTimeFilter($f->created_at)); ?>

                    </span>
                    <br>
                    <p><?php print($f->description) ?></p>
                    <hr>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <div>
        <?php echo e($file->links()); ?>

        </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Leveque\ProjecteLarabel\laravel-bootstrap\resources\views/home.blade.php ENDPATH**/ ?>