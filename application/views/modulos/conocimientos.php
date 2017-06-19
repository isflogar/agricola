<div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" >Registrar Conocimientos</h4>
      </div>
                      <form id='form' method="post">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" id='id_conocimientos' name='id_conocimientos' value="">
                                    <span class="input-group-addon">Nombre</span>
                                    <input name="nombre" type="text" class="form-control" id="nombre" required style="height: 40px;">
                                </div>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Imagen</span>
                                    <input name="logo" type="file" class="form-control" id="logo" style="height: 40px;">
                                    <input name="imagen" type="hidden" id="imagen">
                                </div>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Descripcion</span>
                                    <textarea name="descripcion" id="descripcion" class="form-control" style="  height: 300px;"></textarea>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Insecticidas</span>
                                    <textarea name="insecticidas" id="insecticidas" class="form-control" style="  height: 300px;"></textarea>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Toneladas por hectarea</span>
                                    <input name="toneladas_hectarea" type="text" class="form-control" id="toneladas_hectarea" required style="height: 40px;">
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Costo por hectarea</span>
                                    <input name="costo_hectarea" type="text" class="form-control" id="costo_hectarea" required style="height: 40px;">
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Periodo Crecimiento</span>
                                    <input name="periodo_crecimiento" type="text" class="form-control" id="periodo_crecimiento" required style="height: 40px;">
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Ganancia</span>
                                    <input name="ganancia" type="text" class="form-control" id="ganancia" required style="height: 40px;">
                                </div>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="progress" style="height:10px">
                                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" id="progreso-barra" style="width: 0%">
                                </div>
                              </div>
                              <center><span class="margin-top: -16px;display: block;" id="progreso-num">0% Completo</span></center>
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer clearfix">

                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="limpiar()"><i class="fa fa-times"></i> Cancelar</button>

                            <button type="submit" class="btn btn-success" id="btnRealizar" data-e="R" data-loading-text="Procesando...<i class='fa fa-refresh fa-spin'></i>"><i class="fa fa-check"></i> Realizar</button>
                        </div>
                    </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modal_hechos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" >Lista de Hechos [<span id="nombre_conocimiento"></span>]</h4>
      </div>
      <div class="modal-body">
        <button class='btn btn-flat btn-success' id="modal_hechos_db">Agregar Hecho</button><br><br>

            <div style="height:50px; overflow-y:scroll">
            <table id="table-hecho" class="table table-bordered scroll">
              <thead>
                <tr class="bg-success">
                  <th>Hechos</th>
                  <th style="width:150px">Peso</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            </div>
      </div>
      <div class="modal-footer clearfix">
        <button type="button" class="btn btn-success" onclick="reg_hechos()"><i class="fa fa-check"></i> Aceptar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_hechos_lista" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Hechos</h4>
      </div>
      <div class="modal-body">
        <!--<button class='btn btn-flat btn-success' data-toggle="modal" data-target="#modal_registro_hecho">Registrar Hecho</button><br><br>-->
        <table id="table-hecho-lista" class="table table-bordered">
          <thead>
            <tr class="bg-success">
              <th>Descripcion</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer clearfix">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_registro_hecho" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel_hecho">Registrar Hecho</h4>
      </div>
      <form id="reg_hecho" method="post">
        <div class="modal-body">
          <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                <div class="input-group">
                  <input type="hidden" name="id_hecho" id="id_hecho">
                  <span class="input-group-addon">Descripcion</span>
                  <input name="descripcion_hecho" type="text" class="form-control" id="descripcion_hecho" autofocus="autofocus" required>
                </div>
              </div>
          </div>
          </div>
        </div>
        <div class="modal-footer clearfix">
          <button type="button" class="btn btn-danger" onclick="limpiar_hecho()" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" class="btn btn-success" id="btnRegHecho"><i class="fa fa-check"></i> Aceptar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="content-wrapper">
  <section class="content-header">
          <h1>
            Conocimientos
            <small>Panel de Control</small>
          </h1>
    </section>
    <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="panel-body table-responsive">
            <button class='btn btn-flat btn-success' data-toggle="modal" data-target="#modal_registro">Registrar</button>
                                    <br><br>
            <table id="table" class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>Nombre</th>
                                                <th width="100">Imagen</th>
                                                <th width="400">Descripcion</th>
                                                <th width="">Insecticidas</th>
                                                <th width="">Tonel. Hect.</th>
                                                <th width="">Costo. Hect.</th>
                                                <th width="">Perio. Creci.</th>
                                                <th width="">Ganancia</th>
                                                <th style="width: 300px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data as $user):?>
                                            <tr>
                                                <td><?=$user->conocimiento?></td>
                                                <td><img src="<?=base_url()?>uploads/<?=$user->imagen?>" width="100" height="80" alt=""></td>
                                                <td><?=substr($user->descripcion, 0, 200)."....."?></td>
                                                <td><?=substr($user->insecticidas, 0, 200)."....."?></td>
                                                <td><?=$user->toneladas_hectarea?></td>
                                                <td><?=$user->costo_hectarea?></td>
                                                <td><?=$user->periodo_crecimiento?></td>
                                                <td><?=$user->ganancia?></td>
                                                <td style="vertical-align:middle">
                                                  <center>
                                                    <button type="button" class='btn btn-sm btn-warning btn-editar' id-u="<?=$user->id_conocimiento?>" img="<?=$user->imagen?>"><i class='fa fa-pencil'></i> Editar</button> | <button type="button" class='btn btn-sm btn-danger btn-eliminar' id-u="<?=$user->id_conocimiento?>"><i class='fa fa-trash'></i> Eliminar</button> | <button type="button" class='btn btn-sm btn-info btn-hechos' id-u="<?=$user->id_conocimiento?>"><i class='fa fa-book'></i> Hechos</button></center></td>
                                            </tr>
                                         <?php endforeach; ?>
                                        </tbody>
                                    </table>
          </div>
        </div>
      </div>
    </div>
    </section>
</div>