<div class="content-wrapper">
    <div id="export_imagen" class="col-md-12" style="display:none; height:400px">

    </div>

    <section class="content">
    <div class="row" id="contenedor_principal">
      <div class="col-md-8">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Lista de Fundos</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-danger btn-sm" type="button" id="imprimir-fundos" title="Imprimir Reporte"><i class="fa fa-file-pdf-o"></i></button>

                <button type="button" class="btn btn-warning btn-sm reporte_lista_fundo" data-toggle="tooltip" data-placement="top" title="Sacar datos estadisticos"><i class="fa fa-bar-chart"></i></button>

                <a href="javascript:void(0)" class="btn btn-sm btn-success" id="agregar_fundo" style="color:#FFF" data-toggle="tooltip" data-placement="top" title="Agregar Fundo"><i class="fa fa-plus-circle"></i> Agregar</a>

                <button class="btn btn-sm btn-box-tool btn-default" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body" id="lista_fundos" style="height: auto; position: relative; top: -10px padding:20px 10px;height: 320px; overflow-y:scroll; overflow-x: hidden;">
            <div class="row lista_fundos">
              <?php foreach($fundo as $obj): ?>
                <div class="col-md-6 col-sm-6" id="fundo<?=$obj->id_fundo?>">
                  <div class="box box-solid bg-green-gradient collapsed-box">
                      <div class="box-header">
                        <i class="fa fa-ship"></i>
                        <h4 class="box-title">Fundo N° <?=$obj->nro?></h4>
                        <div class="pull-right box-tools">
                          <button type="button" class="btn btn-danger btn-sm reporte_pdf_fundo" id-fundo="<?=$obj->id_fundo?>" title='imprimir reporte'><i class="fa fa-file-pdf-o"></i></button>

                          <button type="button" class="btn btn-warning btn-sm reporte_procentaje_fundo" id-fundo="<?=$obj->id_fundo?>"><i class="fa fa-bar-chart"></i></button>

                          <button type="button" class="btn btn-primary btn-sm view_parcela" data-widget="collapse" estado="N" id-fundo="<?=$obj->id_fundo?>"><i class="fa fa-plus"></i></button>
                          <button type="button" class="btn btn-danger btn-sm" onclick="eliminar_fundo(<?=$obj->id_fundo?>)" title="Eliminar Fundo"><i class="fa fa-trash"></i></button>
                        </div>
                      </div>

                      <!--PARCELAS-->
                      <div class="box-footer text-black">
                        <div class="box box-success">
                          <div class="box-header">
                            <i class="fa fa-th"></i>
                            <h3 class="box-title">Parcelas</h3>

                            <div class="box-tools pull-right">
                              <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="agregar_parcela(<?=$obj->id_fundo?>, 'Fundo N° <?=$obj->nro?>')" style="color:#FFF" data-toggle="tooltip" data-placement="top" title="Agregar Parcela"><i class="fa fa-plus-circle"></i> Agregar</a>

                              <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                          </div>
                          <div class="box-footer text-black" id="lista_parcelas<?=$obj->id_fundo?>" style="display: none !important">
                            <div class="row parcelitas"></div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="col-md-12" id="msg_general" style="background: #fff; margin: 0px 0px 0px 0px; position: absolute; width: 100%;bottom: 0px; opacity:0.9; box-shadow:0px 0px 4px #000; display:none; color: red; font-size:1.5rem"></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="row">
          <div class="box box-success">
            <div class="box-header with-border">
              <h5 id="text-graf" class="box-title"></h5>
            </div>
            <div class="box-body">
              <div id="grafico_flot" style="width:100%; height:300px"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div id="grafico_exportar" style="width:100%; height:400px; display:block"></div>
      </div>
    </div>

    </section>
</div>

<div id="fundo_add" style="display:none"><!--ADGREGAR UN FUNDO-->
  <div class="col-md-6 col-sm-6 id_fundo" id="">
    <div class="box box-solid bg-green-gradient collapsed-box">
      <div class="box-header">
          <i class="fa fa-ship"></i>
          <h4 class="box-title">Fundo N° <span class="nro_fundo"></span></h4>
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-warning btn-sm reporte_procentaje_fundo" id-fundo=""><i class="fa fa-bar-chart"></i></button>

            <button type="button" class="btn btn-primary btn-sm colapsar view_parcela" data-widget="collapse" estado="N" id-fundo="">
              <i class="fa fa-plus"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm evento_eliminar_fundo" onclick="eliminar_fundo()"><i class="fa fa-trash"></i></button>
          </div>
      </div>

      <!--PARCELAS-->
      <div class="box-footer text-black">
        <div class="box box-success">
          <div class="box-header">
            <i class="fa fa-th"></i>
            <h3 class="box-title">Parcelas</h3>

            <div class="box-tools pull-right">
              <a href="javascript:void(0)" class="btn btn-sm btn-success evento_agregar_parcela" onclick="agregar_parcela()" style="color:#FFF"><i class="fa fa-plus-circle"></i> Agregar</a>

                <button type="button" class="btn btn-default btn-sm colapsar" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-footer text-black lista_parcelas" id="">
            <div class="row parcelitas"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="parcela_add" style="display:none"><!--PARCELA AGREGADA-->
  <div class="col-md-12 col-sm-12 id_parcela" id="">
    <div class="box box-solid box-primary collapsed-box">
      <div class="box-header">
          <i class="fa fa-list"></i>
          <h4 class="box-title">Parcela N° <span class="nro_parcela"></span></h4>
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-danger btn-sm reporte_pdf_parcela" id-parcela="" title="Grafico PDF Parcela"><i class="fa fa-file-pdf-o"></i></button>

            <button type="button" class="btn btn-warning btn-sm reporte_procentaje_parcela" id-parcela="" title="Sacar Grafico por Parcela"><i class="fa fa-bar-chart"></i></button>

            <button type="button" class="btn btn-success btn-sm colapsar" data-widget="collapse">
              <i class="fa fa-plus"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm evento_eliminar_parcela" onclick="eliminar_parcela()"><i class="fa fa-trash"></i></button>
          </div>
      </div>

      <!--PARCELAS-->
      <div class="box-footer text-black">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12" style="margin-bottom:10px">
            <center>
              <button class="btn btn-sm btn-success sembrios" type="button" onclick="lista_sembrios">
                <i class="fa fa-leaf"></i> Sembrios
              </button>
            </center>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <center>
              <button class="btn btn-sm btn-warning propiedades_tierra" type="button" onclick="lista_propiedades">
                <i class="fa fa-server"></i> Propiedades
              </button>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="add_registro_parcela" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" >Agregar Parcela [<b><span id="num_fundo"></span></b>]</h4>
      </div>

      <form id='formParcela' method="post">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="input-group">
                    <input type="hidden" id="id_fundo" name="id_fundo" value="">
                    <span class="input-group-addon">Dimensión(Hectareas)</span>
                    <input name="dimension" type="text" class="form-control" id="dimension" required="" placeholder="Ingrese la cantidad de hectareas que tiene la parcela">
                </div>
              </div>
            </div>
          </div>
        </div>

          <div class="modal-footer clearfix">
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="limpiar_form_parcela()"><i class="fa fa-times"></i> Cancelar</button>

            <button type="submit" class="btn btn-success" id="btnRealizar" data-e="R" data-loading-text="Procesando...<i class='fa fa-refresh fa-spin'></i>"><i class="fa fa-check"></i> Realizar</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="lista_sembrios_agregados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" >Lista de Sembrios</h4>
      </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#lista_sembrios">Agregar Sembrio
              </button><br><br>
              <table class="table table-bordered" id="table-sembrio-agregados">
                <thead>
                  <tr class="bg-success">
                    <th>Sembrio</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>

          <div class="modal-footer clearfix">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          </div>
    </div>
  </div>
</div>

<div class="modal fade" id="lista_sembrios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" >Sembrios</h4>
      </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered" id="table-sembrio">
                <thead>
                  <tr class="bg-success">
                    <th>Sembrio</th>
                    <th width="100">Imagen</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($sembrio as $obj): ?>
                <tr>
                  <td style="vertical-align:middle"><?=$obj->conocimiento?></td>
                  <td><img src="<?=base_url()?>uploads/<?=$obj->imagen?>" class="img-responsive" style='width:100%'></td>
                  <td style="vertical-align:middle; text-align:center" width="150">
                    <button class="btn btn-sm btn-success" onclick="agregar_sembrio(<?=$obj->id_conocimiento?>)"><i class="fa fa-check"></i> Agregar</button>
                  </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

          <div class="modal-footer clearfix">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          </div>
    </div>
  </div>
</div>

<!--PROPIEDADES TIERRA-->
<div class="modal fade" id="lista_propiedades_agregados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" >Lista de Propiedades</h4>
      </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <!--<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#lista_propiedades">Agregar Propiedad
              </button><br><br>-->
              <table class="table table-bordered" id="table-propiedad-agregados">
                <thead>
                  <tr class="bg-success">
                    <th>Propiedad</th>
                    <!--<th></th>-->
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>

          <div class="modal-footer clearfix">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          </div>
    </div>
  </div>
</div>

<div class="modal fade" id="lista_propiedades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" >Propiedades</h4>
      </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered" id="table-propiedad">
                <thead>
                  <tr class="bg-success">
                    <th>Propiedad</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($hecho as $obj): ?>
                <tr>
                  <td style="vertical-align:middle"><?=$obj->descripcion?> - <b><?=$obj->tipo_hecho?></b></td>
                  <td style="vertical-align:middle; text-align:center" width="150">
                    <button class="btn btn-sm btn-success" onclick="agregar_propiedad(<?=$obj->id_hechos?>)"><i class="fa fa-check"></i> Agregar</button>
                  </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

          <div class="modal-footer clearfix">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          </div>
    </div>
  </div>
</div>

<!--<div class="modal fade" id="lista_propiedades_parcela" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" >Fundo N° <b id="num_fundo_procentaje"></b> - Parcela N° <b id="num_parcela_procentaje"></b> || Probalidad de Sembrios</h4>
      </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-body" style="height:300px; width:100%; box-sizing: border-box; padding:0px" id="box-frame">
                  <iframe src="" frameborder="0" style='height:300px; width:100%;' id="frame_grafico_parcela"></iframe>
                </div>
              </div>
            </div>
          </div>
        </div>

          <div class="modal-footer clearfix">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          </div>
    </div>
  </div>
</div>-->

<div class="modal fade" id="tipo_encuesta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" >Tipo de Encuesta</h4>
      </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <center><button type="button" class="btn btn-md btn-primary" onclick="encuesta(1)">Cientifica</button></center>
            </div>

            <div class="col-md-6 col-sm-6">
              <center><button type="button" class="btn btn-md btn-info" onclick="encuesta(2)">Empirica</button></center>
            </div>
          </div>
        </div>

          <!--<div class="modal-footer clearfix">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          </div>-->
    </div>
  </div>
</div>

<div class="modal fade" id="encuesta" tabindex="-1" role="dialog" aria-labelledby="pregunta" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="pregunta" style="font-wieght:bold"></h4>
      </div>

        <div class="modal-body">
          <div class="row" id="contenedor_respuesta">

          </div>
        </div>

        <div class="modal-footer clearfix">
            <div class="row">
              <div class="col-md-4 col-sm-4">
                <center><button type="button" class="btn btn-md btn-danger atras_pregunta" id="inicio_pregunta"><i class="fa fa-angle-double-left"></i>Atras</button></center>
              </div>
              <div class="col-md-4 col-sm-4">
                <center><button type="button" class="btn btn-md btn-primary" id="realizar_encuesta" style="display:none"><i class="fa fa-save"></i> Finalizar</button></center>
              </div>
              <div class="col-md-4 col-sm-4">
                <center><button type="button" class="btn btn-md btn-success siguiente_pregunta">Siguiente <i class="fa fa-angle-double-right"></i></button></center>
              </div>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="descripcion_planta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3" id="name_planta">
            </div>
            <div class="col-md-9" id="desc_planta"></div>
          </div>
        </div>

          <div class="modal-footer clearfix">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
          </div>
    </div>
  </div>
</div>

<style>
  .container-fluid{
    padding-left:0px;
    padding-right:0px;
  }
</style>