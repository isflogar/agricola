<div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" >Registrar Tipo Hecho</h4>
      </div>

      <form id='form' method="post">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="input-group">
                    <input type="hidden" id="id_tipo_hecho" name="id_tipo_hecho" value="">
                    <span class="input-group-addon">Descripción</span>
                    <input name="descripcion" type="text" class="form-control" id="descripcion" required="">
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Pregunta Empirica</span>
                    <input name="pregunta_empirica" type="text" class="form-control" id="pregunta_empirica">
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Pregunta Cientifica</span>
                    <input name="pregunta_cientifica" type="text" class="form-control" id="pregunta_cientifica">
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
            Tipo Hecho
            <small>Panel de Control</small>
          </h1>
    </section>
    <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="panel-body table-responsive">
            <button class='btn btn-flat btn-success' data-toggle="modal" data-target="#modal_registro">Registrar</button><br><br>
            <table id="table" class="table table-bordered">
              <thead>
                <tr class="bg-primary">
                    <th>Descripción</th>
                    <th>Pregunta Empirica</th>
                    <th>Pregunta Cientifica</th>
                    <th width="250"></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </section>
</div>