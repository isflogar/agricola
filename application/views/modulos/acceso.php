<div class="content-wrapper">
    <section class="content-header">
          <h1>
            Accesos
            <small>Panel de Control</small>
          </h1>
    </section>
    <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="panel-body table-responsive">
                <div class="row">
                       <div class="col-md-3 col-sm-4 col-xs-4">
                            <?php foreach($data as $obj){ ?>
                            <div class="radio">
                                <label>
                                <input type="radio" name="tipo_user" class="t_user" value="<?=$obj->id_tipo_usuario?>"> <?=$obj->descripcion?>
                                </label>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-9 col-md-3 col-sm-8 col-xs-8">
                            <div id="resultado">

                            </div>
                        </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
</div>