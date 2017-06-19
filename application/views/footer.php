		</div>
		<div id="carga" style="  z-index: 3000;background: rgba(255,255,255,0.7); border-radius: 3px; position: fixed;  top: 0;  left: 0;  width: 100%;  height: 100%; display:none">
	        <i class="fa fa-refresh fa-spin" style="position: fixed;  top: 50%;  left: 50%;  margin-left: -15px;  margin-top: -15px;  color: #000;  font-size: 30px;"></i>
	    </div>
		<script src="<?=base_url()?>public/lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?=base_url()?>public/lib/dist/js/app.min.js" type="text/javascript"></script>
		<script src="<?=base_url()?>public/lib/dist/js/pages/dashboard.js" type="text/javascript"></script>
		<script src="<?=base_url()?>public/lib/dist/js/demo.js" type="text/javascript"></script>
		<script src="<?=base_url()?>public/lib/iCheck/icheck.min.js" type="text/javascript"></script>
		<script src="<?=base_url()?>public/lib/dataTables/js/jquery.dataTables.js" type="text/javascript"></script>
		<script src="<?=base_url()?>public/lib/dataTables/js/dataTables.bootstrap.js" type="text/javascript"></script>
		<script src="<?=base_url()?>public/lib/upload.js" type="text/javascript"></script>
		<script src="<?=base_url()?>public/lib/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
		<script src="<?=base_url()?>public/lib/flot/jquery.flot.min.js" type="text/javascript"></script>
		<script src="<?=base_url()?>public/lib/flot/jquery.flot.text.js" type="text/javascript"></script>
		<script src="<?=base_url()?>public/lib/flot/base64.js" type="text/javascript"></script>
		<script src="<?=base_url()?>public/lib/flot/canvas2image.js" type="text/javascript"></script>
		<script>
			var url_aplication = "<?=base_url()?>";
		</script>
		<?php if(isset($js)){ ?>
		<script src="<?=base_url()?>public/js/<?=$js?>" type="text/javascript"></script>
		<?php } ?>

	</body>
</html>