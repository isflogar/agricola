var table = $("#table");
var table_hecho = $("#table-hecho");
var table_hecho_lista = $("#table-hecho-lista");
var array_hechos = [];

var estado_r, url_base, id_pro, param, link, id_conoci, band;
$(document).ready(function() {
    param = {
        "lengthMenu": [[10, 20, 100], [10, 20, 100]],
        "language": {
             "lengthMenu": "Cantidad de registros ",
             "zeroRecords": "No hay registros",
             "info": "",
                //"info": "Pagina _PAGE_ de _PAGES_",
                //"info": "<buton type='button' class='btn btn-sm btn-success' title='Exportar a un archivo Excel'><i class='fa fa-file-excel-o'></i></buton>",
             "infoEmpty": "Registro no encontrado",
             "infoFiltered": "(buscado en _MAX_ registros)",
             "search":         "Buscar: ",
             "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "<i class='fa fa-angle-double-right'></i>",
                "previous":   "<i class='fa fa-angle-double-left'></i>"
            },
        }
    };

    url_base = $("body").attr("url");

    table.dataTable(param);
    //table_hecho.dataTable(param);
    table_hecho_lista.dataTable(param);

    link = url_base.split("index.php");
    link = link[0];

    $("#form").submit(function(event){
        event.preventDefault();
        estado_r = $("#btnRealizar").attr("data-e");

        $("#btnRealizar").button("loading");
        if(estado_r==="R"){
            if($("#logo").val()!==""){
                $("#logo").upload(url_base+"/conocimientos/cargar_imagen",{logo: $("#logo").val()},function(res){
                    if(res[0]===1 || res[0]==="1"){
                        $("#imagen").val(res[1]);
                        $.post(url_base+"/conocimientos/registrar", $("#form").serialize(), function(data) {
                            if(data===1 || data==="1"){
                                alert("CONOCIMIENTOS REAGISTRADO");
                                listar();
                                limpiar();
                            }else{
                                alert(data);
                            }
                        }).always(function(){
                            $("#btnRealizar").button("reset");
                        },'json');
                    }else{
                        alert("ERROR AL GUARDAR");
                    }
                }, function(progreso, valor){
                    $("#progreso-barra").css('width', valor+'%');
                    $("#progreso-num").html(valor+"% Completo");
                },'json');
            }else{
                /*$("#imagen").val("");
                $.post(url_base+"/conocimientos/registrar", $("#form").serialize(), function(data) {
                    if(data===1 || data==="1"){
                        alert("CONOCIMIENTOS REGISTRADO");
                        listar();
                        limpiar();
                    }else if(data===2 || data==="2"){
                        alert(data);
                    }
                }).always(function(){
                    $("#btnRealizar").button("reset");
                });*/
                alert("CARGUE UNA IMAGEN PARA EL CONOCIMIENTO");
                $("#logo").focus();
            }
        }else if(estado_r==="E"){
            if($("#logo").val()!==""){
                $("#logo").upload(url_base+"/conocimientos/cargar_imagen",{logo: $("#logo").val()},function(res){
                    if(res[0]===1 || res[0]==="1"){
                        $("#imagen").val(res[1]);
                        $.post(url_base+"/conocimientos/editar", $("#form").serialize(), function(data) {
                            if(data===1 || data==="1"){
                                alert("DAT0S MODIFICAdOS");
                                listar();
                                limpiar();
                            }else{
                                alert(data);
                            }
                        }).always(function(){
                            $("#btnRealizar").button("reset");
                        });
                    }else{
                        alert("ERROR AL GUARDAR");
                    }
                }, function(progreso, valor){
                    $("#progreso-barra").css('width', valor+'%');
                    $("#progreso-num").html(valor+"% Completo");
                },'json');
            }else{
                $.post(url_base+"/conocimientos/editar", $("#form").serialize(), function(data) {
                    if(data===1 || data==="1"){
                        alert("DAT0S MODIFICAdOS");
                        listar();
                        limpiar();
                    }else{
                        alert(data);
                    }
                }).always(function(){
                    $("#btnRealizar").button("reset");
                });
            }


        }else{
            alert("ERROR :v");
        }
    });

    $("#reg_hecho").submit(function(event) {
        event.preventDefault();
        $("#btnRegHecho").button("loading");

        if($("#id_hecho").val()===""){
            $.post(url_base+'/hechos/registrar', $("#reg_hecho").serialize(), function(data) {
                if(data===1 || data==="1"){
                    alert("HECHO REGISTRADO");
                    $("#modal_registro_hecho").modal("hide");
                    listar_hechos_tabla();
                }else if(data===2 || data==="2"){
                        alert("YA EXITE REGISTRADO UN HECHO CON EL MISMO NOMBRE");
                }else{
                        alert("HECHO NO REGISTRADO");
                }
            }).always(function(){
                $("#btnRegHecho").button("reset");
            });
        }else{
            $.post(url_base+'/hechos/editar', $("#reg_hecho").serialize(), function(data) {
                if(data===1 || data==="1"){
                    alert("HECHO EDITADO");
                    $("#modal_registro_hecho").modal("hide");
                    listar_hechos_tabla();
                }else if(data===2 || data==="2"){
                        alert("YA EXITE REGISTRADO UN HECHO CON EL MISMO NOMBRE");
                }else{
                        alert("HECHO NO REGISTRADO");
                }
            }).always(function(){
                $("#btnRegHecho").button("reset");
            });
        }
    });
});

$(document).on("click", ".btn-editar-hecho", function(){
    $("#id_hecho").val($(this).attr("id-h"));
    $("#descripcion_hecho").val($(this).parent().parent().parent().find("td:nth-child(1)").html());
    $("#myModalLabel_hecho").html("Editar Hecho");
    $("#modal_registro_hecho").modal("show");
});

function limpiar_hecho(){
    $("#id_hecho, #descripcion_hecho").val("");
    $("#myModalLabel_hecho").html("Registrar Hecho");
    $("#modal_registro_hecho").modal("hide");
}

$(document).on("click", ".btn-editar", function(){
    //alert("hola");
    $("#btnRealizar").attr("data-e", "E");
    $("#nombre").val($(this).parent().parent().parent().find("td:nth-child(1)").html());
    $("#descripcion").val($(this).parent().parent().parent().find("td:nth-child(3)").html());
    $("#id_conocimientos").val($(this).attr("id-u"));
    img = $(this).attr("img");
    $("#imagen").val(img);

    $.post(url_base+'/conocimientos/datos', {
        id:$("#id_conocimientos").val()
    }, function(data) {
        $("#descripcion").val(data[0][0].descripcion);
        $("#insecticidas").val(data[0][0].insecticidas);
        $("#toneladas_hectarea").val(data[0][0].toneladas_hectarea);
        $("#costo_hectarea").val(data[0][0].costo_hectarea);
        $("#periodo_crecimiento").val(data[0][0].periodo_crecimiento);
        $("#ganancia").val(data[0][0].ganancia);
        $("#myModalLabel").html("Editar conocimientos");

        $("#modal_registro").modal("show");
    },'json');

    /*
    $.post(url_base+'/conocimientos/datos', {
        id:$("#id_conocimientos")
    }, function(data) {

    });

    /*$("#myModalLabel").html("Editar conocimientos");

    $("#modal_registro").modal("show");*/
});

$(document).on("click", ".btn-hechos", function(){
    id_conoci = $(this).attr("id-u");
    btn = $(this);
    btn.button("loading");
    $.post(url_base+"/conocimientos/lista_hechos", {
        id : id_conoci
    }, function(data) {
        t = "";
        $.each(data, function(key, obj) {
            t+="<tr id-hecho='"+obj.id_hechos+"' id='li_co"+obj.id_hechos+"'>";
            t+="<td>"+obj.descripcion+" - <b>"+obj.tipo_hecho+"</b> || <b>"+obj.tipo_investigacion+"</b><input type='hidden' class='id_conocimiento_hecho' value='"+obj.id_hechos+"'/></td>";
            t +="<td style='font-size:12px'><input type='number' class='form-control input-peso' value='"+obj.peso+"' data-val='"+obj.peso+"' style='text-align:right'/></td>";
            t += "<td><center><button class='btn btn-danger btn-sm btn-quitar-hecho' title='Quitar Hecho'><i class='fa fa-trash'></i></button></center></td>";
            t+="</tr>";
        });
        //table_hecho.fnDestroy();
        table_hecho.find("tbody").html(t);
        //table_hecho.dataTable(param);

    },'json').always(function(){
        btn.button("reset");
        $("#nombre_conocimiento").html(btn.parent().parent().parent().find("td:nth-child(1)").html());
        $("#modal_hechos").modal("show");
    });
});

$(document).on("click", ".btn-eliminar-hecho", function(){
    if (confirm("¿ESTAS SEGURO DE ELIMINAR ESTOS DATOS?")) {
        id = $(this).attr("id-h");
        $.post(url_base+"/hechos/eliminar", {
            id_hecho:id
        }, function(data) {
                if(data===1 || data==="1"){
                    alert("DAT0S ELIMINADOS");
                    listar_hechos_tabla();
                    $("#li_co"+id).remove();
                }else{
                    alert("ERROR AL ELIMINAR");
                }
        });
    }else{
        return;
    }
});

$(document).on("click", ".btn-eliminar", function(){
    if (confirm("¿ESTAS SEGURO DE ELIMINAR ESTOS DATOS?")) {
        id = $(this).attr("id-u");
        $.post(url_base+"/conocimientos/eliminar", {
            id_conocimientos:id
        }, function(data) {
                if(data===1 || data==="1"){
                    alert("DAT0S ELIMINADOS");
                    listar();
                }else{
                    alert("ERROR AL ELIMINAR");
                }
        });
    }else{
        return;
    }
});

$(document).on("click","#modal_hechos_db", function(){
    $("#modal_hechos_db").button("loading");

    $.post(url_base+"/hechos/datos", function(data) {
        t = "";
        $.each(data, function(key, obj) {
            t+="<tr id='lista_hecho_tabla"+obj.id_hechos+"'>";
            t+="<td>"+obj.descripcion+" - <b>"+obj.tipo_hecho+"</b> || <b>"+obj.descripcion_tipo_investigacion+"</b></td>";
            t+="<td><center><button class='btn btn-success btn-agregar-hecho' id-h='"+obj.id_hechos+"'><i class='fa fa-check'></i> Agregar</button></center></td>";
            //t+="<td><center><button class='btn btn-success btn-agregar-hecho' id-h='"+obj.id_hecho+"'><i class='fa fa-check'></i> Agregar</button> | <button class='btn btn-warning btn-editar-hecho' id-h='"+obj.id_hecho+"'><i class='fa fa-pencil'></i> Editar</button> | <button class='btn btn-danger btn-eliminar-hecho' id-h='"+obj.id_hecho+"'><i class='fa fa-trash'></i> Eliminar</button></center></td>";
            t+="</tr>";
        });
        table_hecho_lista.fnDestroy();
        table_hecho_lista.find("tbody").html(t);
        table_hecho_lista.dataTable(param);

        $("#table-hecho tbody tr").each(function() {
            $("#lista_hecho_tabla"+$(this).attr("id-hecho")).addClass('bg-warning');
            //console.log($(this).attr("id-hecho"));
        });

    },'json').always(function(){
        $("#modal_hechos_db").button("reset");

        $("#nombre_conocimiento").html(btn.parent().parent().parent().find("td:nth-child(1)").html());
        $("#modal_hechos_lista").modal("show");
    });
});

function reg_hechos(){
    if($("#table-hecho tbody").html()===""){
            alert("NO HAY NINGUN HECHO AGREGADO");
        }else{
            band=0;
            $("#table-hecho tbody tr").each(function() {
                array_hechos.push([
                    $(this).attr("id-hecho"),
                    $(this).find("td:nth-child(2) input").val()
                ]);

                num = parseInt($(this).find("td:nth-child(2) input").val());
                if(num<=0 || num>10){
                    band++;
                }
            });

            if(band>0)
            {
                alert("EL PESO DE LOS HECHOS DEBE ESTAR ENTRE 1 y 10");
                array_hechos = [];
                band = 0;
            }else{
                $("#agregar_hecho_conocimiento").button("loading");
                $("#carga").show();
                $.post(url_base+'/conocimientos/registrar_detalle', {
                    id:id_conoci,
                    hechos:array_hechos
                }, function(data) {
                    if(data===1 || data==="1"){
                        alert("PROCESO REALIZADO");
                        band=0;
                        array_hechos = [];
                    }else{
                        alert("ERROR AL GUARDAR");
                        array_hechos = [];
                        band = 0;
                    }
                }).always(function(){
                    $("#agregar_hecho_conocimiento").button("reset");
                    $("#carga").hide();
                });
            }
        }
}

$(document).on("click", ".btn-agregar-hecho", function(){
    id_h = $(this).attr('id-h');

    if($(".id_conocimiento_hecho[value='"+id_h+"']").length){
        alert("EL HECHO YA ESTA AGREGADO");
    }else{
        $(this).parent().parent().parent().addClass('bg-warning');
        t = "<tr id-hecho='"+id_h+"'>";
        t +="<td>"+$(this).parent().parent().parent().find("td:nth-child(1)").html()+" <input type='hidden' class='id_conocimiento_hecho' value='"+id_h+"'/></td>";
        t +="<td style='font-size:12px'><input type='number' class='form-control input-peso' value='1' data-val='1' style='text-align:right'/></td>";
        t += "<td><center><button class='btn btn-danger btn-sm btn-quitar-hecho' title='Quitar Hecho'><i class='fa fa-trash'></i></button></center></td>";
        t += "</tr>";
        $("#table-hecho tbody").append(t);
    }
});

$(document).on("click", ".btn-quitar-hecho", function(){
    id_hh = $(this).attr("id-hecho");
    $(this).parent().parent().parent().remove();
    $("#lista_hecho_tabla"+id_hh).removeClass('bg-warning');
});

function limpiar(){
    $("#form input, #form textarea,#form select, #form-stock input, #reg_hecho input, #reg_hecho select, #reg_hecho-stock input, #reg_hecho-stock textarea").val("");
    $("#btnRealizar").attr("data-e", "R");
    $("#modal_registro, #modal_stock").modal("hide");
    $("#myModalLabel").html("Registrar conocimientos");
    $("#progreso").html("0% Cargando");
    $("#progreso-barra").css("width", "0%");
}

function listar(){
    $.post(url_base+"/conocimientos/datos", function(data) {
        table.fnDestroy();
        $("#table tbody").html("");
        $.each(data, function(index, el) {
            des = el.descripcion;
            des = des.substr(0, 200)+".....";

            ins = el.insecticidas;

            t="<tr>";
            t+="<td style='text-align:left'>"+el.conocimiento+"</td>";
            t+="<td style='text-align:left'><img src='"+link+"uploads/"+el.imagen+"' width='100' height='80'></td>";
            t+="<td style='text-align:left'>"+des+"</td>";
            t+="<td style='text-align:left'>"+ins+"</td>";
            t+="<td style='text-align:left'>"+el.toneladas_hectarea+"</td>";
            t+="<td style='text-align:left'>"+el.costo_hectarea+"</td>";
            t+="<td style='text-align:left'>"+el.periodo_crecimiento+"</td>";
            t+="<td style='text-align:left'>"+el.ganancia+"</td>";
            t+="<td style='vertical-align:middle'><button type='button' class='btn btn-sm btn-warning btn-editar' id-u='"+el.id_conocimiento+"' img='"+el.imagen+"'><i class='fa fa-pencil'></i> Editar</button> | <button type='button' class='btn btn-sm btn-danger btn-eliminar' id-u='"+el.id_conocimiento+"'><i class='fa fa-trash'></i> Eliminar</button> | <button type='button' class='btn btn-sm btn-info btn-hechos' id-u='"+el.id_conocimiento+"'><i class='fa fa-book'></i> Hechos</button></center></td>";
            t+="</tr>";
            $("#table tbody").append(t);
        });
        table.dataTable(param);
    },'json');
}

function listar_hechos_tabla(){
    $.post(url_base+"/hechos/datos", function(data) {
        t = "";
        $.each(data, function(key, obj) {
            t+="<tr id='lista_hecho_tabla"+obj.id_hecho+"'>";
            t+="<td>"+obj.hecho+"</td>";
            t+="<td><center><button class='btn btn-success btn-agregar-hecho' id-h='"+obj.id_hecho+"'><i class='fa fa-check'></i> Agregar</button> | <button class='btn btn-warning btn-editar-hecho' id-h='"+obj.id_hecho+"'><i class='fa fa-pencil'></i> Editar</button> | <button class='btn btn-danger btn-eliminar-hecho' id-h='"+obj.id_hecho+"'><i class='fa fa-trash'></i> Eliminar</button></center></td>";
            t+="</tr>";
        });
        table_hecho_lista.fnDestroy();
        table_hecho_lista.find("tbody").html(t);
        table_hecho_lista.dataTable(param);
        $("#modal_registro_hecho").modal("hide");
        $("#reg_hecho input").val("");

        $("#table-hecho tbody tr").each(function() {
            $("#lista_hecho_tabla"+$(this).attr("id-hecho")).addClass('bg-warning');
            //console.log($(this).attr("id-hecho"));
        });
    },'json');
}

