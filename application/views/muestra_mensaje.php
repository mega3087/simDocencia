<link href="<?php echo base_url('assets/inspinia/css/bootstrap.min.css');?>" rel="stylesheet">
<!-- Mainly scripts -->
<script src="<?php echo base_url('assets/inspinia/js/jquery-2.1.1.js'); ?>"></script>
<br />
<div class="col-lg-12">
	<?php if(!$mensaje) $mensaje=''; if(!$color) $color='danger'; ?>	
	<div class="alert alert-<?php echo $color; ?>">
		<?php echo $mensaje; ?>
	</div>
</div>