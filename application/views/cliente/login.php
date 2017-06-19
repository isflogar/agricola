<div class="row">
	<div class="col-md-4 col-md-offset-4">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="login-box-body" style="margin-top: 15%;">
                    <p class="login-box-msg"><!--<img src="<?=base_url()?>upload/<?=$logo?>" class="img-responsive">--></p>
                    <h2><center>ACCESO AL SISTEMA</center></h2>
                    <form  id="form_login" method="post">
                      <div class="alert alert-danger" id='mensaje_login' style="display: none"></div>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="usuario" placeholder="Usuario" required autofocus/>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div>
                      <div class="form-group has-feedback">
                        <input type="password" name="clave" class="form-control" placeholder="Clave" required/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                      <div class="row">
                        <div class="col-xs-8">
                            <span id='hora'></span> - <span id='dia'></span>
                        </div><!-- /.col -->
                        <div class="col-xs-4">
                          <button type="submit" class="btn btn-md btn-success btn-flat btn-block" id="btnLogin"  data-loading-text="Procesando...<i class='fa fa-refresh fa-spin'></i>">Ir <i class='fa fa-sign-in'></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
            </div>
        </div>
    </div>
</div>