<!DOCTYPE html>
<html>
<head id="head">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SISTEMA EXPERTO DE DIÁGNOTICO DE TIERRAS AGRÍCOLAS - DIRECCIÓN REGIONAL DE AGRICULTURA DE SAN MARTÍN</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/lib/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/lib/ionicons/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/lib/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/lib/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/lib/dataTables/css/dataTables.bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/lib/datepicker/datepicker3.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/css/estilos.css">
	<script src="<?=base_url()?>public/lib/bootstrap/js/jquery-1.11.2.js" type="text/javascript"></script>
	<script type="text/javascript">
		function Hora(){
			momentoActual = new Date();
			hora = momentoActual.getHours();
			min = momentoActual.getMinutes();
			seg = momentoActual.getSeconds();
			if(min<10){
				min="0"+min;
			}

			if(seg<10){
				seg="0"+seg;
			}

			if(hora>12){
				hora = hora-12;
				HoraActual = hora+":"+min+":"+seg+" pm";
			}else{
				HoraActual = hora+":"+min+":"+seg+" am";
			}


			$("#hora").html("<b>"+HoraActual+"</b>");
			crear_fecha();

			menu = $("body").attr("option");
			if(menu==="" || menu===undefined){
				menu = "00";
			}

			$("#option"+menu).addClass('active');
		}

		function crear_fecha()
		{
			meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

			f = new Date();
			fecha = f.getDate()+" de "+meses[f.getMonth()]+" del "+f.getFullYear();

			$("#fecha").html("<b>"+f.getDate()+"/"+f.getMonth()+"/"+f.getFullYear()+"</b>");
			$("#dia").html("<b>"+fecha+"</b>");
		}
		//crear_fecha();
		setInterval(Hora, 1000);
	</script>
	<style>
		.input-group-addon {
		    background: #E7EBEF !important;
		}

		.flotTip
	    {
	      padding: 3px 5px;
	      background-color: #000;
	      z-index: 100;
	      color: #fff;
	      box-shadow: 0 0 10px #555;
	      opacity: .7;
	      filter: alpha(opacity=70);
	      border: 2px solid #fff;
	      -webkit-border-radius: 4px;
	      -moz-border-radius: 4px;
	      border-radius: 4px;
	    }
	</style>
</head>
<body url="<?=base_url()?>index.php" class="skin-blue" option='<?php echo @$_GET['option']?>'>
		<?php
			if(!isset($menu)):
				echo '<div class="container-fluid">';
			endif;
		?>