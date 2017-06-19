<div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" >Registrar Usuario</h4>
      </div>
                      <form id='form' method="post">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" id='id_usuario' name='id_usuario' value="">
                                    <span class="input-group-addon">Nombre</span>
                                    <input name="nombre" type="text" class="form-control" id="nombre" required>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                  <div class="input-group">
                                      <span class="input-group-addon">Tipo de Usuario</span>
                                      <select name="id_tipo_usuario" class="form-control" id="id_tipo_usuario" required>
                                          <option value="">Selecione.....</option>
                                          <?php foreach($t_user as $obj):?>
                                          <option value="<?=$obj->id_tipo_usuario?>"><?=$obj->descripcion?></option>
                                          <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Usuario</span>
                                    <input name="user" type="text" class="form-control" id="user" required>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Clave</span>
                                    <input name="clave" type="password" class="form-control" id="clave">
                                </div>
                              </div>
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

<div class="content-wrapper">
  <section class="content-header">
          <h1>
            Usuarios
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
                                                <th>Tipo Usuario</th>
                                                <th>Nombre de Usuario</th>
                                                <th width="200"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data as $user):?>
                                            <tr>
                                                <td><?=$user->nombre?></td>
                                                <td><?=$user->descripcion?></td>
                                                <td><?=$user->user?></td>
                                                <td><center><button type="button" class='btn btn-sm btn-warning btn-editar' id-u="<?=$user->id_usuario?>" id-t-u="<?=$user->id_tipo_usuario?>"><i class='fa fa-pencil'></i> Editar</button> | <button type="button" class='btn btn-sm btn-danger btn-eliminar' id-u="<?=$user->id_usuario?>"><i class='fa fa-trash'></i> Eliminar</button></center></td>
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