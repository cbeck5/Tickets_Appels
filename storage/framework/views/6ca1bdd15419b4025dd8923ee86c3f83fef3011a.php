<?php $__env->startSection('content'); ?>


	<div class="contentBody">

		<?php if(Session::has('message')): ?>
			<p class="alert alert-info"><?php echo e(Session::get('message')); ?></p>
		<?php elseif(Session::has('error')): ?>
			<p class="alert alert-danger"><?php echo e(Session::get('error')); ?></p>
		<?php endif; ?>

		<h1>Chargement d'un relevé de consommation</h1>

		<div style="margin-top: 50px;margin-bottom: 50px;">
	        <form action="<?php echo e(route('uploadFile')); ?>" method="POST" class="form-upload" enctype="multipart/form-data">
	    		<?php echo csrf_field(); ?>
				<div class="row">
					<div class="col-md-3">
						<label>Sélectionner un fichier CSV :</label>
					</div>
					<div class="col-md-5">
						<div class="form-control">
							<input type="file" id="file_upload_id" name="file_upload" accept=".csv" />
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-example">
							<input class="form-control btn btn-primary" type="submit" value="Valider">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

<?php $__env->stopSection(); ?>  
<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ticketsAppels/resources/views/home.blade.php ENDPATH**/ ?>