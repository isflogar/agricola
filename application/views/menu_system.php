<?php
  @session_start();
  if(!isset($_SESSION['menu'])){
    echo "alert('ACCESO DENEGADO'); window.location='<?=base_url()?>'";
  }
 ?>
<div class="wrapper">
	<header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo"><center><!--<img src="<?=base_url()?>upload/<?=$logo?>" width="140">--></center></a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <a href="javascript:void(0)"><span style="color: #FFF;font-size: 1.4rem; display: inline-block;
    margin-top: 1.5rem;">SISTEMA EXPERTO DE DIÁGNOTICO DE TIERRAS AGRÍCOLAS - DIRECCIÓN REGIONAL DE AGRICULTURA DE SAN MARTÍN</span></a>
          <!--<button type="button" class="btn btn-primary btn-md" style="margin-top: 10px;" id="novedades"><i class="fa fa-gift"></i> NOVEDADES</button>-->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="<?=base_url()?>app/salir" style="">
                  <span class="hidden-md">Salir</span>
                  <i class="fa fa-sign-out"></i>
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image" style="color:#FFF">
              <i class="fa fa-user fa-3x"></i>
            </div>
            <div class="pull-left info">
              <p><?=$nombre?></p>

              <a href="#"><i class="fa fa-circle text-success"></i> En Linea</a>
            </div>
          </div>
          <!-- search form -->
          	<div class="input-form" style="color:#FFFFD8; text-align: center; padding: 5px 0px;">
          		<center><span id='dia'></span>
          		<br>
          		<i class="fa fa-clock-o"></i> <span id='hora'></span></center>
         	</div>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
          	<?=$menu?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>