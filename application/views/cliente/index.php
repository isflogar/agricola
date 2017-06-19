<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>SISTEMA EXPERTO DE DIÁGNOTICO DE TIERRAS AGRÍCOLAS - DIRECCIÓN REGIONAL DE AGRICULTURA DE SAN MARTÍN</title>

<script src="<?=base_url()?>public/lib/bootstrap/js/jquery-1.11.2.js"></script>

<script src="<?=base_url()?>public/lib/select2/dist/js/select2.full.js"></script>

<!-- Google fonts -->
<!--<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Josefin+Sans:600' rel='stylesheet' type='text/css'>-->

<!-- font awesome -->
<link href="<?=base_url()?>public/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">

<!-- bootstrap -->
<link rel="stylesheet" href="<?=base_url()?>public/lib/bootstrap/css/bootstrap.min.css" />

<!-- animate.css -->
<link rel="stylesheet" href="<?=base_url()?>public/lib/assets/animate/animate.css" />
<link rel="stylesheet" href="<?=base_url()?>public/lib/assets/animate/set.css" />

<!-- gallery -->
<link rel="stylesheet" href="<?=base_url()?>public/lib/assets/gallery/blueimp-gallery.min.css">

<!-- favicon -->
<!--<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">-->
<link href="<?=base_url()?>public/lib/select2/dist/css/select2.min.css" rel="stylesheet" />


<link rel="stylesheet" href="<?=base_url()?>public/lib/assets/style.css">

</head>

<body>
<div class="topbar animated fadeInLeftBig"></div>

<!-- Header Starts -->
<div class="navbar-wrapper">
  <div class="container">
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="top-nav">
      <div class="container">
            <div class="navbar-header">
              <!-- Logo Starts -->
              <a class="navbar-brand" href="#home"><!--<img src="<?=base_url()?>public/lib/images/logo.png" alt="logo"><-->
                <h1 style="color: #FFF; margin-top: 2.5rem; font-size: 1.4rem;">SISTEMA EXPERTO DE DIÁGNOTICO DE TIERRAS AGRÍCOLAS - DIRECCIÓN REGIONAL DE AGRICULTURA DE SAN MARTÍN</h1>
              </a>
              <!-- #Logo Ends -->


              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>


            <!-- Nav Starts -->
            <div class="navbar-collapse  collapse">
              <ul class="nav navbar-nav navbar-right scroll">
                <li ><a href="<?=base_url()?>web/login">Intranet</a></li>
              </ul>
            </div>
            <!-- #Nav Ends -->
      </div>
    </div>
  </div>
</div>
<!-- #Header Starts -->




<div id="home">
<!-- Slider Starts -->
  <div class="banner">
  </div>
<!-- #Slider Ends -->
</div>

<div id="menu"  class="container spacer about" style="display:none"></div>
<!-- #Cirlce Ends -->


<!-- works -->
<div class="modal fade" id="modal_conocimiento">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:0px">
      <div class="modal-header">
        <h4 class="modal-title" id="nombre_conocimiento"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <center><img src="" id="imagen_conocimiento" alt="" class="img-responsive" style="border-radius:50%; height:12em; width:12em; box-shadow: 0px 0px 30px #000"></center>
          </div>
          <div class="col-md-6" style="text-align:justify; overflow-y: scroll; height: 12em;" id="descripcion_conocimiento">

          </div>

          <div class="col-md-12">
            <h4 style="  margin-top: 15px; margin-bottom: 5px; ">Propiedades</h4>
            <div id="ingre">

            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="foods"  class=" clearfix grid" style="padding-top:0px;
">
    <?php foreach ($sembrios as $key => $obj):?>
    <figure class="effect-oscar  wowload fadeInUp conocimiento" id-c="<?=$obj->id_conocimiento?>" id="comida_db<?=$obj->id_conocimiento?>">
        <img src="<?=base_url()?>uploads/<?=$obj->imagen?>" alt="<?=$obj->conocimiento?>" class="img-responsive" style="width: 102%; height: 300px;"/>
        <figcaption>
            <h2 class="nombre_conocimiento efecto oculto"><?=$obj->conocimiento?></h2>
            <p>
              <a href="javscript:void(0)" title="1" data-gallery>Ver mas</a>
            </p>
        </figcaption>
    </figure>
    <?php endforeach; ?>
</div>



<!-- Footer Starts -->
<div class="footer text-center spacer" style="position:fixed;   width: 100%; bottom: 0px; padding: 2% 0%;">
Dirección Regional de Agricultura - Todos los derechos reservados
</div>
<!-- # Footer Ends -->
<a href="#home" class="gototop "><i class="fa fa-angle-up  fa-3x"></i></a>

<!-- jquery -->

<!-- wow script -->
<script src="<?=base_url()?>public/lib/assets/wow/wow.min.js"></script>


<!-- boostrap -->
<script src="<?=base_url()?>public/lib/bootstrap/js/bootstrap.min.js" type="text/javascript" ></script>

<!-- jquery mobile -->
<script src="<?=base_url()?>public/lib/assets/mobile/touchSwipe.min.js"></script>
<script src="<?=base_url()?>public/lib/assets/respond/respond.js"></script>

<!-- gallery -->
<!--<script src="<?=base_url()?>public/lib/assets/gallery/jquery.blueimp-gallery.min.js"></script>-->


<!-- custom script -->

<script src="<?=base_url()?>public/lib/assets/script.js"></script>

</body>
</html>