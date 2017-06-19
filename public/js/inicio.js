table_sembrios = $("#table-sembrio");
table_hechos = $("#table-hecho");
table_propiedades = $("#table-propiedad");

ban = 0;
hechos_selected=[];
plantas = [];
var image1, image2, image3, myCanvas, label;

$(document).on('click', '#imprimir-fundos', function(event) {
	$.post(url_aplication+'fundo/fundo_porcentaje', function(data) {
		exportar_grafico(data, "total_fundo");
	},'json');
});

$(document).on('click', '.reporte_pdf_fundo', function(event) {
	id = $(this).attr("id-fundo");
	nom = $(this).parent().parent().find(".box-title").html();

	$.post(url_aplication+'fundo/porcentaje', {
		id_fundo : id
    }, function(data, textStatus, xhr) {
    	exportar_grafico(data[0], "fundo", id);
	},'json');
});

$(document).on('click', '.reporte_pdf_parcela', function(event) {
	id_p = $(this).attr("id-parcela");
	$.post(url_aplication+'parcela/data_parcela_procentaje', {
		id_parcela: id_p
	}, function(data, textStatus, xhr) {
		exportar_grafico(data[1], "parcela", id_p);
	},'json');
});

function exportar_grafico(data, type, id_f){
	$("#carga").show();
	bar_data = [];
    label = [];

    bandera_recomendables = 1;

        $.each(data, function(index, obj) {
            bar_data.push({
                data : [[bandera_recomendables-1, obj.porcentaje]],
                color : obj.color
            });

            label.push([bandera_recomendables-1, obj.nombre+"("+obj.porcentaje+"%)"]);
            bandera_recomendables++;
        });

        $.plot("#grafico_exportar", bar_data, {
          grid: {
            borderWidth: 1,
            borderColor: "#f3f3f3",
            tickColor: "#f3f3f3",
            backgroundColor: { colors: ["#fff", "#eee"]},
            canvasText: {
                show: true,
                font: "sans 8px bold",
                seriesFont: "sans 20px",
                lineBreaks: {
                	show: true,
                	marginTop: 13,
                	marginBottom: 5,
                	lineSpacing: 6
                }
            }
          },
          series: {
            bars: {
              show: true,
              barWidth: 0.5,
              align: "center"
            },

            lines: { show: true },
          },
          xaxis: {
            ticks : label
          },
        });

        html = "";

        saveFlotGraphAsPNG("grafico_exportar","export_imagen", type, id_f);
}


function saveFlotGraphAsPNG(placeholderID, targetID, type , id_fundo) {
    var divobj = document.getElementById(placeholderID);

    var oImg = Canvas2Image.saveAsPNG(divobj.childNodes[0], true);

   	if (!oImg) {
        alert("Sorry, this browser is not capable of saving PNG files!");
        return false;
    }

   	oImg.id = "canvasimage";

    document.getElementById(targetID).removeChild(document.getElementById(targetID).childNodes[0]);
    document.getElementById(targetID).appendChild(oImg);

    $("#"+placeholderID).html("");

    link = $("#canvasimage").attr("src");

    $.post(url_aplication+'reporte/base64', {
    	img: link
    }, function(data, textStatus, xhr) {
    	if(data===1){
    		if(id_fundo===""){
    			window.open(url_aplication+"reporte?type="+type);
    		}else{
    			window.open(url_aplication+"reporte?type="+type+"&id_fundo="+id_fundo);
    		}
    	}else{
    		alert("ERROR");
    	}

    	$("#carga").hide();
    },'json');

}



$(document).ready(function() {
	//jijij prueba
	$.post(url_aplication+'conocimientos/datos', function(data, textStatus, xhr) {
		$.each(data, function(index, obj) {
			plantas.push({
				"id_conocimiento" : obj.id_conocimiento,
				"planta" : obj.conocimiento
			});
		});
	},'json');

	$("#tipo_encuesta, #encuesta").modal({backdrop: 'static', show:false});

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

    table_sembrios = table_sembrios.dataTable(param);
    table_propiedades = table_propiedades.dataTable(param);

	$("#agregar_fundo").click(function(){
		if(confirm("¿ESTAS SEGURO DE AGREGAR UN NUEVO FUNDO?")){
			$.post(url_aplication+'fundo/agregar', function(data, textStatus, xhr) {
				$("#carga").show();
				if(data[0]==="ok"){
					add_fundo(data[1][0].nro, data[1][0].id_fundo);
				}else{
					alert("Error al agregar");
				}
				$("#carga").hide();
			},'json');
		}else{
			return false;
		}
	});
});

$(document).on('click', '.colapsar', function(event) {
	event.preventDefault();

	if($(this).find(".fa").hasClass('fa-plus')){
		$(this).find(".fa").removeClass('fa-plus');
		$(this).find(".fa").addClass('fa-minus');
	}else{
		$(this).find(".fa").removeClass('fa-minus');
		$(this).find(".fa").addClass('fa-plus');
	}
	$(this).parent().parent().parent().find(".box-footer").slideToggle();
});

function add_fundo(n, id){
	$("#fundo_add .id_fundo").attr("id", "fundo"+id);
	$("#fundo_add .view_parcela").attr("id-fundo", id);
	$("#fundo_add .nro_fundo").html(n);
	$("#fundo_add .lista_parcelas").attr("id", "lista_parcelas"+id);
	$("#fundo_add .reporte_procentaje_fundo").attr("id-fundo", id);
	$("#fundo_add .evento_eliminar_fundo").attr("onclick", "eliminar_fundo("+id+")");
	$("#fundo_add .evento_agregar_parcela").attr("onclick", "agregar_parcela("+id+", 'Fundo N°"+n+"')");
	new_fundo = $("#fundo_add").html();
	$("#lista_fundos .lista_fundos").append(new_fundo);
	$("#fundo_add .id_fundo").attr("id", "");
	$("#fundo_add .lista_parcelas").attr("id", "");

}

function eliminar_fundo(id){
	if (confirm("¿ESTAS SEGURO DE ELIMINAR?")) {
		$.post(url_aplication+'fundo/eliminar', {
			id_fundo: id
		}, function(data) {
			$("#carga").show();
			if(data==="ok"){
				$("#fundo"+id).remove();
			}else{
				alert(data);
			}
			$("#carga").hide();
		},'json');
	}
}

//----------->AGREGAR PARCELA

function agregar_parcela(key_fundo, fundo){
	$("#num_fundo").html(fundo);
	$("#id_fundo").val(key_fundo);
	$("#add_registro_parcela").modal("show");
}

$("#formParcela").submit(function(event) {
	event.preventDefault();
	$("#carga").show();
	$.post(url_aplication+'parcela/agregar', $("#formParcela").serialize(), function(data, textStatus, xhr) {
		$("#carga").show();
			if(data[0]==="ok"){
				add_parcela(data[1][0].nro, data[1][0].id_parcela, data[1][0].id_fundo);
			}else{
				alert("Error al agregar");
			}
			$("#carga").hide();
			limpiar_form_parcela();
	},'json');
});

function limpiar_form_parcela(){
	$("#formParcela input").val("");
	$("#add_registro_parcela").modal("hide");
}

function add_parcela(n, id_p, id_f){
	$("#parcela_add .id_parcela").attr("id", "parcela"+id_p);
	$("#parcela_add .reporte_procentaje_parcela").attr("id-parcela", id_p);
	$("#parcela_add .reporte_pdf_parcela").attr("id-parcela", id_p);
	$("#parcela_add .nro_parcela").html(n);
	$("#parcela_add .evento_eliminar_parcela").attr("onclick", "eliminar_parcela("+id_p+")");
	$("#parcela_add .sembrios").attr("onclick", "lista_sembrios("+id_p+")");
	$("#parcela_add .propiedades_tierra").attr("onclick", "lista_propiedades("+id_p+")");
	new_parcela = $("#parcela_add").html();
	$("#lista_parcelas"+id_f+" .parcelitas").append(new_parcela);
}

function eliminar_parcela(id){
	if (confirm("¿ESTAS SEGURO DE ELIMINAR?")) {
		$.post(url_aplication+'parcela/eliminar', {
			id_parcela: id
		}, function(data) {
			$("#carga").show();
			if(data==="ok"){
				$("#parcela"+id).remove();
			}else{
				alert(data);
			}
			$("#carga").hide();
		},'json');
	}
}


function lista_sembrios(id_par){
	id_parcela_selected = id_par;
	$.post(url_aplication+'parcela/lista_sembrio', {
		id_parcela: id_par
	}, function(data, textStatus, xhr) {
		t="";
		$.each(data, function(index, obj) {
			t+="<tr>";
			t+="<td><input type='hidden' class='sembrio_id' value='"+obj.id_conocimiento+"'>"+obj.conocimiento+"</td>";
			t+="<td style='text-align:center'><button class='btn btn-danger btn-sm' onclick='quitar_sembrio("+obj.id_parcela_conocimiento+")' title='Quitar Sembrio'><i class='fa fa-trash'></i></button></td>";
			t+="</tr>";
		});
		$("#table-sembrio-agregados tbody").html(t);
	},'json');

	$("#lista_sembrios_agregados").modal();
}

function agregar_sembrio(id_sem){
	if($(".sembrio_id[value='"+id_sem+"']").length){
		alert("EL SEMBRIO YA ESTA AGREGADO");
	}else{
		$.post(url_aplication+'parcela/agregar_sembrio', {
			id_parcela: id_parcela_selected,
			id_conocimiento : id_sem
		}, function(data) {
			if(data==1){
				lista_sembrios(id_parcela_selected);
			}else{
				alert("Error :v");
			}
		});
	}
}

function quitar_sembrio(id_det){
	if(confirm("¿ESTAS SEGURO DE QUITAR EL SEMBRIO?")){
		$.post(url_aplication+'parcela/quitar_sembrio', {
			id_parcela_conocimiento: id_det
		}, function(data, textStatus, xhr) {
			if(data==1){
				lista_sembrios(id_parcela_selected);
			}else{
				alert("Error :v");
			}
		});
	}
}

//--PROPIEDADES TIERRA
function lista_propiedades(id_par){
	id_parcela_selected = id_par;
	$.post(url_aplication+'parcela/lista_propiedad', {
		id_parcela: id_par
	}, function(data, textStatus, xhr) {

		if(data.length===0 || data.length==="0"){
			if(confirm("Se hara una pequeña encuesta con el fin de recopilar información para poder sacar la probabilidad de sembrios que podra sembrar en esta parcela. Una vez realizada y aceptada la encuesta no se podra revertir los cambios. ¿Desea continuar?")){
				$("#tipo_encuesta").modal("show");
			}else{
				return;
			}
		}else{
			t="";
			$.each(data, function(index, obj) {
				t+="<tr>";
				t+="<td><input type='hidden' class='propiedad_id' value='"+obj.id_hechos+"'>"+obj.descripcion+" - <b>"+obj.tipo_hecho+"</b></td>";
				//t+="<td style='text-align:center'><button class='btn btn-danger btn-sm' onclick='quitar_propiedad("+obj.id_parcela_hechos+")' title='Quitar Propiedad'><i class='fa fa-trash'></i></button></td>";
				t+="</tr>";
			});
			$("#table-propiedad-agregados tbody").html(t);
			$("#lista_propiedades_agregados").modal();
		}
	},'json');

	//$("#lista_propiedades_agregados").modal();
}

function agregar_propiedad(id_sem){
	if($(".propiedad_id[value='"+id_sem+"']").length){
		alert("LA PROPIEDAD YA ESTA AGREGADA");
	}else{
		$.post(url_aplication+'parcela/agregar_propiedad', {
			id_parcela: id_parcela_selected,
			id_hechos : id_sem
		}, function(data) {
			if(data==1){
				lista_propiedades(id_parcela_selected);
			}else{
				alert("Error :v");
			}
		});
	}
}

function quitar_propiedad(id_det){
	if(confirm("¿ESTAS SEGURO DE QUITAR LA PROPIEDAD?")){
		$.post(url_aplication+'parcela/quitar_propiedad', {
			id_parcela_hechos: id_det
		}, function(data, textStatus, xhr) {
			if(data==1){
				lista_propiedades(id_parcela_selected);
			}else{
				alert("Error :v");
			}
		});
	}
}

function encuesta(key){
	type_investigacion = key;

	$.post(url_aplication+'parcela/encuesta', {
		id_tipo_investigacion : key
	}, function(data, textStatus, xhr) {
		cantidad_pregunta = -1;
		preguntas = data;

		new_preguntas = [];

		$.each(preguntas, function(index, val) {
			cantidad_pregunta++;
			new_preguntas[cantidad_pregunta] = {
				pregunta:index,
				respuestas:val
			};
		});

		lista_pregunta(ban);
		$("#encuesta").modal("show");
	},'json');
}

function lista_pregunta(num){
	if(num<=0){
		ban=0;
		$("#inicio_pregunta, #realizar_encuesta").css("display", "none");
		$(".siguiente_pregunta").css("display", "block");
	}else if(num<cantidad_pregunta){
		$("#inicio_pregunta, .siguiente_pregunta").css("display", "block");
		$("#realizar_encuesta").css("display", "none");
	}else if(num==cantidad_pregunta){
		$("#realizar_encuesta").css("display", "block");
		$(".siguiente_pregunta").css("display", "none");
	}

	$("#pregunta").html((ban+1)+". "+new_preguntas[num].pregunta);

	t="";
	$.each(new_preguntas[num].respuestas, function(index, obj) {
		checked = in_array(obj.id_hecho);
		t+="<div class='col-md-12'><div class='checkbox'><label><input type='checkbox' class='hechos_id' value='"+obj.id_hecho+"' "+checked+"> "+obj.descripcion+"</label></div></div>";
	});

	$("#contenedor_respuesta").html(t);
}

function in_array(val){
	if(hechos_selected.length===0){
		return "";
	}else{
		for (var i = 0; i < hechos_selected.length; i++) {
			if(val==hechos_selected[i]){
				che = "checked";
				break;
			}else{
				che = "";
			}
		}

		return che;
	}
}




//---------------------
$(document).on('click', '.view_parcela', function(event) {
	event.preventDefault();
	id_f = $(this).attr("id-fundo");
	estado = $(this).attr("estado");

	if(estado==="N"){
		$(this).attr("estado", "S");
		$.post(url_aplication+'parcela/datos', {
			id_fundo : id_f
		}, function(data, textStatus, xhr) {
			$.each(data, function(index, obj) {
				add_parcela(obj.nro, obj.id_parcela, obj.id_fundo);
			});
		},'json');
	}
});

$(document).on('click', '.reporte_procentaje_parcela', function(event) {
	event.preventDefault();
	$("#carga").show();
	$(".new_graf").remove();
	id_p = $(this).attr("id-parcela");
	$.post(url_aplication+'parcela/data_parcela_procentaje', {
		id_parcela: id_p
	}, function(data, textStatus, xhr) {
		if(data[0].length===0){
			alert("REALIZE LA ENCUESTA PARA LA PARCELA");
			return;
		}

		hectareas = data[1][0].hectareas;

		t = "Fundo N° <b>"+data[0][0].nro_fundo+"</b> | Parcela N° <b>"+data[0][0].nro_parcela+"</b> | <b>"+data[0][0].tipo_investigacion+"</b> | <b>Tot. Hect. :</b> "+hectareas;
		$("#text-graf").html(t);


		bar_data = [];
		text = "Se registra que en un :<br>";
		text_general = "El sistema experto para el Fundo N° <b>"+data[0][0].nro_fundo+"</b> - Parcela N° <b>"+data[0][0].nro_parcela+"</b>  le recomienda los cultivos de:";
		text_auxiliar = "";

		bandera_recomendables = 1;
		bandera_no_recomendables = 0;

		bar_recomendables = [];
		bar_no_recomendables = [];

		ticks_bar = [];
		ticks_bar_recomendables = [];
		ticks_bar_no_recomendables = [];


        $.each(data[1], function(index, obj) {
        	bar_data.push({
        		data : [[bandera_recomendables-1, obj.porcentaje]],
        		color : obj.color,
        		hect : hectareas
        	});

        	//selecionando las 3 recomendables y las que no sirven para nada :v
        	if(bandera_recomendables<=3){
        		bar_recomendables.push({
	        		data : [[bandera_recomendables-1, obj.porcentaje]],
	        		color : obj.color,
	        		hect : hectareas
	        	});

		        ticks_bar_recomendables.push([bandera_recomendables-1, obj.nombre+"<br><b>("+obj.porcentaje+"%)</b>"]);

        		text_auxiliar = "<b> - Se recomienda</b>";

        		if(bandera_recomendables==3){
        			text_general+="<b>"+bandera_recomendables+"."+obj.nombre+"</b>. <br>";
        		}else{
        			text_general+="<b>"+bandera_recomendables+"."+obj.nombre+"</b>, ";
        		}
        	}else{
        		bar_no_recomendables.push({
	        		data : [[bandera_no_recomendables, obj.porcentaje]],
	        		color : obj.color,
	        		hect : hectareas
	        	});

		        ticks_bar_no_recomendables.push([bandera_no_recomendables, obj.nombre+"<br><b>("+obj.porcentaje+"%)</b>"]);

        		text_auxiliar = "<b> - No se recomienda</b>";

        		bandera_no_recomendables++;
        	}

        	text+="- "+obj.porcentaje+"% se puede sembrar "+obj.nombre+" "+text_auxiliar+".<br>";

        	ticks_bar.push([bandera_recomendables-1, obj.nombre+"<br><b>("+obj.porcentaje+"%)</b>"]);

        	bandera_recomendables++;
        });

		$("#msg_general").fadeIn("slow", function(){
			$("#msg_general").html(text_general+" La información detallada del diagnostico lo encontrará en los gráficos de la derecha");
		});

	    $.plot("#grafico_flot", bar_data, {
	    	grid: {
		        borderWidth: 1,
		        borderColor: "#f3f3f3",
		        tickColor: "#f3f3f3",
		        hoverable: true,
	            clickable:true
		      },
	      	series: {
		        bars: {
		            show: true,
		            barWidth: 0.3,
		            align: "center",
		            lineWidth: 0,
		            fill:.75
		        }
		    },
	      	xaxis: {
	        	ticks : ticks_bar
	      	}

	    });

	    $("#grafico_flot").parent().find(".text-reporte").remove();

		$("#grafico_flot").after("<h3 class='text-reporte'>Siembrios no recomendables</h3><div id='grafico2' class='text-reporte' style='width:100%; height:300px'></div>");

		$("#grafico_flot").after("<h3 class='text-reporte'>Siembrios recomendables</h3><div id='grafico1' class='text-reporte' style='width:100%; height:300px'></div>");

		$("#grafico_flot").after("<div class='text-reporte'>"+text+"</div>");

		$.plot("#grafico1", bar_recomendables, {
	      grid: {
	        borderWidth: 1,
	        borderColor: "#f3f3f3",
	        tickColor: "#f3f3f3",
	        hoverable: true,
            clickable:true
	      },
	      series: {
	        bars: {
	          show: true,
	          barWidth: 0.5,
	          align: "center"
	        }
	      },
	      xaxis: {
	        ticks : ticks_bar_recomendables
	      }

	    });

	    $.plot("#grafico2", bar_no_recomendables, {
	      grid: {
	        borderWidth: 1,
	        borderColor: "#f3f3f3",
	        tickColor: "#f3f3f3",
	        hoverable: true,
            clickable:true
	      },
	      series: {
	        bars: {
	          show: true,
	          barWidth: 0.5,
	          align: "center"
	        }
	      },
	      xaxis: {
	        ticks : ticks_bar_no_recomendables
	      }

	    });

		$("#carga").hide();
	},'json');
});

function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'+series.data[0][1]+"%</div>";
        //console.log(series.data[0][1]);
}

$(document).on('click', '.atras_pregunta', function(event) {
	//event.preventDefault();
	if(hechos_selected[ban]==="" || hechos_selected[ban]===undefined){
		alert("SELECCIONE UNA RESPUESTA");
		return;
	}
	ban--;
	lista_pregunta(ban);
});

$(document).on('click', '.siguiente_pregunta', function(event) {
	//event.preventDefault();
	if(hechos_selected[ban]==="" || hechos_selected[ban]===undefined){
		alert("SELECCIONE UNA RESPUESTA");
		return;
	}

	ban++;
	lista_pregunta(ban);
});

$(document).on('click', '.hechos_id', function(event) {
	$(".hechos_id").prop('checked', '');
	$(this).prop('checked', 'checked');

	hechos_selected[ban] = $(this).val();
});

$(document).on('click', '#realizar_encuesta', function(event) {
	if(hechos_selected[ban]==="" || hechos_selected[ban]===undefined){
		alert("SELECCIONE UNA RESPUESTA");
		return;
	}

	if(confirm("¿ESTAS SEGURO DE GUARDAR LA ENCUESTA?")){
		$("#carga").show();
		$.post(url_aplication+'parcela/registrar_encuesta', {
			key_parcela : id_parcela_selected,
			key_tipo_investigacion : type_investigacion,
			lista_respuestas : hechos_selected
		}, function(data) {
			if(data===1 || data==="1"){
				alert("ENCUESTA REGISTRADA");
				$("#encuesta, #tipo_encuesta").modal("hide");
				hechos_selected = [];
				ban = 0;
			}else{
				alert("ERROR AL REGISTRAR");
			}

			$("#carga").hide();
		});
	}
});

$(document).on('click', '.reporte_procentaje_fundo', function(event) {
	id = $(this).attr("id-fundo");
	nom = $(this).parent().parent().find(".box-title").html();

	$("#carga").show();

	$.post(url_aplication+'fundo/porcentaje', {
		id_fundo : id
    }, function(data, textStatus, xhr) {
    	//grafico genneral---->beach please
    	cant_hectareas = data[2][1];
    	t = nom+" | N° Parcelas : "+data[2][0]+" | Hectareas : "+data[2][1];
		$("#text-graf").html(t);

		cant_hectareas = data[2][1];

		bar_data = [];
		bar_recomendables = [];
		bar_no_recomendables = [];

		ticks_bar = [];
		ticks_bar_recomendables = [];
		ticks_bar_no_recomendables = [];



		bandera_recomendables = 1;
		bandera_no_recomendables = 0;

		text = "Se registra que en un :<br>";
		text_general = "El sistema experto recomienda para el <b>"+nom + "</b> los cultivos de : ";

        $.each(data[0], function(index, obj) {
        	bar_data.push({
        		data : [[bandera_recomendables-1, obj.porcentaje]],
        		color : obj.color,
        		hect:cant_hectareas
        	});

        	if(bandera_recomendables<=3){
        		bar_recomendables.push({
	        		data : [[bandera_recomendables-1, obj.porcentaje]],
	        		color : obj.color,
	        		hect:cant_hectareas
	        	});

		        ticks_bar_recomendables.push([bandera_recomendables-1, obj.nombre+"<br><b>("+obj.porcentaje+"%)</b>"]);

        		text_auxiliar = "<b> - Se recomienda</b>";

        		if(bandera_recomendables==3){
        			text_general+=" <b>"+bandera_recomendables+". "+obj.nombre+"</b>.<br>";
        		}else{
        			text_general+=" <b>"+bandera_recomendables+". "+obj.nombre+"</b>, ";
        		}
        	}else{
        		bar_no_recomendables.push({
	        		data : [[bandera_no_recomendables, obj.porcentaje]],
	        		color : obj.color,
	        		hect:cant_hectareas
	        	});

		        ticks_bar_no_recomendables.push([bandera_no_recomendables, obj.nombre+"<br><b>("+obj.porcentaje+"%)</b>"]);

        		text_auxiliar = "<b> - No se recomienda</b>";

        		bandera_no_recomendables++;
        	}

        	ticks_bar.push([bandera_recomendables-1, obj.nombre+"<br><b>("+obj.porcentaje+"%)</b>"]);
        	bandera_recomendables++;

        	text+="- "+obj.porcentaje+"% se puede sembrar "+obj.nombre+" "+text_auxiliar+".<br>";
        });

		$("#msg_general").fadeIn("slow", function(){
			$("#msg_general").html(text_general+"La información detallada del diagnostico lo contrará en los gráficos de la derecha.");
		});

	    $.plot("#grafico_flot", bar_data, {
	    	grid: {
		        borderWidth: 1,
		        borderColor: "#f3f3f3",
		        tickColor: "#f3f3f3",
		        hoverable: true,
	            clickable:true
		      },
	      	series: {
		        bars: {
		            show: true,
		            barWidth: 0.3,
		            align: "center",
		            lineWidth: 0,
		            fill:.75,
		        }
		    },
	      	xaxis: {
	        	ticks : ticks_bar
	      	}

	    });

	    $("#grafico_flot").parent().find(".text-reporte").remove();

		$("#grafico_flot").after("<h3 class='text-reporte'>Siembrios no recomendables</h3><div id='grafico2' class='text-reporte' style='width:100%; height:300px'></div>");

		$("#grafico_flot").after("<h3 class='text-reporte'>Siembrios recomendables</h3><div id='grafico1' class='text-reporte' style='width:100%; height:300px'></div>");

		$("#grafico_flot").after("<div class='text-reporte'>"+text+"</div>");

		$.plot("#grafico1", bar_recomendables, {
	    	grid: {
		        borderWidth: 1,
		        borderColor: "#f3f3f3",
		        tickColor: "#f3f3f3",
		        hoverable: true,
	            clickable:true
		      },
	      	series: {
		        bars: {
		            show: true,
		            barWidth: 0.3,
		            align: "center",
		            lineWidth: 0,
		            fill:.75
		        }
		    },
	      	xaxis: {
	        	ticks : ticks_bar_recomendables
	      	}

	    });

	    $.plot("#grafico2", bar_no_recomendables, {
	      grid: {
	        borderWidth: 1,
	        borderColor: "#f3f3f3",
	        tickColor: "#f3f3f3",
	        hoverable: true,
            clickable:true
	      },
	      series: {
	        bars: {
	          show: true,
	          barWidth: 0.5,
	          align: "center",
	          lineWidth: 0,
		      fill:.75
	        }
	      },
	      xaxis: {
	        ticks : ticks_bar_no_recomendables
	      }

	    });

	    ///las nuevas parcelas que dan la hostia :v

		$(".new_graf").remove();
		//PARCELAS
		total_parcela = data[1];
		//console.log(data[1]);
		cont = 0;
		$.each(total_parcela, function(key, obj1) {

			id_graf = cont;

			new_graf = '<div class="col-md-4 new_graf" id="new_graf'+id_graf+'"><div class="row"><div class="box box-warning"><div class="box-header with-border"><h5 class="box-title">'+key+'</h5></div><div class="box-body"><div class="grafico_flot_new" style="width:100%; height:300px"></div></div></div></div></div>';

			$("#contenedor_principal").append(new_graf);

			bar_data = [];
			bar_recomendables = [];
			bar_no_recomendables = [];

			ticks_bar = [];
			ticks_bar_recomendables = [];
			ticks_bar_no_recomendables = [];



			bandera_recomendables = 1;
			bandera_no_recomendables = 0;

			text1 = "Se registra que en un :<br>";

	        $.each(obj1, function(index, obj) {
	        	hectareas = obj.hectareas;
	        	bar_data.push({
	        		data : [[bandera_recomendables-1, obj.porcentaje]],
	        		color : obj.color,
	        		hect : hectareas
	        	});

	        	if(bandera_recomendables<=3){
	        		bar_recomendables.push({
		        		data : [[bandera_recomendables-1, obj.porcentaje]],
		        		color : obj.color,
		        		hect : hectareas
		        	});

			        ticks_bar_recomendables.push([bandera_recomendables-1, obj.nombre+"<br><b>("+obj.porcentaje+"%)</b>"]);

			        text_auxiliar = "<b> - Se recomienda</b>";
	        	}else{
	        		bar_no_recomendables.push({
		        		data : [[bandera_no_recomendables, obj.porcentaje]],
		        		color : obj.color,
		        		hect : hectareas
		        	});

			        ticks_bar_no_recomendables.push([bandera_no_recomendables, obj.nombre+"<br><b>("+obj.porcentaje+"%)</b>"]);

	        		text_auxiliar = "<b> - No se recomienda</b>";

	        		bandera_no_recomendables++;
	        	}

	        	ticks_bar.push([bandera_recomendables-1, obj.nombre+"<br><b>("+obj.porcentaje+"%)</b>"]);
        		bandera_recomendables++;

        		text1+="- "+obj.porcentaje+"% se puede sembrar "+obj.nombre+" "+text_auxiliar+".<br>";

	        });

		    $.plot('#new_graf'+id_graf+" .grafico_flot_new", bar_data, {
		      grid: {
		        borderWidth: 1,
		        borderColor: "#f3f3f3",
		        tickColor: "#f3f3f3",
		        hoverable: true,
	            clickable:true
		      },
		      series: {
		        bars: {
		          show: true,
		          barWidth: 0.5,
		          align: "center"
		        }
		      },
		      xaxis: {
		        ticks : ticks_bar
		      }

		    });

			$('#new_graf'+id_graf+" .grafico_flot_new").after("<h3 class='text-reporte'>Siembrios no recomendables</h3><div id='grafico"+id_graf+"-2' class='text-reporte' style='width:100%; height:300px'></div>");

			$('#new_graf'+id_graf+" .grafico_flot_new").after("<h3 class='text-reporte'>Siembrios recomendables</h3><div id='grafico"+id_graf+"-1'class='text-reporte' style='width:100%; height:300px'></div>");

			$('#new_graf'+id_graf+" .grafico_flot_new").after("<div class='text-reporte'>"+text1+"</div>");

			$.plot("#grafico"+id_graf+"-1", bar_recomendables, {
		      grid: {
		        borderWidth: 1,
		        borderColor: "#f3f3f3",
		        tickColor: "#f3f3f3",
		        hoverable: true,
	            clickable:true
		      },
		      series: {
		        bars: {
		          show: true,
		          barWidth: 0.5,
		          align: "center"
		        }
		      },
		      xaxis: {
		        ticks : ticks_bar_recomendables
		      }

		    });

		    $.plot("#grafico"+id_graf+"-2", bar_no_recomendables, {
		      grid: {
		        borderWidth: 1,
		        borderColor: "#f3f3f3",
		        tickColor: "#f3f3f3",
		        hoverable: true,
	            clickable:true
		      },
		      series: {
		        bars: {
		          show: true,
		          barWidth: 0.5,
		          align: "center"
		        }
		      },
		      xaxis: {
		        ticks : ticks_bar_no_recomendables
		      }

		    });

			cont++;
		});

		$("#carga").hide();
	},'json');
});

$(document).on('click', '.reporte_lista_fundo', function(event) {
	event.preventDefault();
	$("#carga").show();
	$(".new_graf").remove();

	$.post(url_aplication+'fundo/fundo_porcentaje', function(data) {
		console.log(data);
		hectareas = data[0].hectareas;
		$("#text-graf").html("Grafico de todos los fundos | Hectareas: "+hectareas);


		text = "Se registra que en un :<br>";
		text_general = "El sistema experto para el <b>total de fundos</b> le recomienda los cultivos de : ";

		bar_data = [];
		bar_recomendables = [];
		bar_no_recomendables = [];

		ticks_bar = [];
		ticks_bar_recomendables = [];
		ticks_bar_no_recomendables = [];



		bandera_recomendables = 1;
		bandera_no_recomendables = 0;

        $.each(data, function(index, obj) {
        	bar_data.push({
        		data : [[bandera_recomendables-1, obj.porcentaje]],
        		color : obj.color,
        		hect : hectareas
        	});

        	if(bandera_recomendables<=3){
        		bar_recomendables.push({
	        		data : [[bandera_recomendables-1, obj.porcentaje]],
	        		color : obj.color,
	        		hect : hectareas
	        	});

		        ticks_bar_recomendables.push([bandera_recomendables-1, obj.nombre+"<br><b>("+obj.porcentaje+"%)</b>"]);

        		text_auxiliar = "<b> - Se recomienda</b>";

        		if(bandera_recomendables==3){
        			text_general+=" <b>"+bandera_recomendables+"."+obj.nombre+"</b>. <br>";
        		}else{
        			text_general+=" <b>"+bandera_recomendables+"."+obj.nombre+"</b>, ";
        		}
        	}else{
        		bar_no_recomendables.push({
	        		data : [[bandera_no_recomendables, obj.porcentaje]],
	        		color : obj.color,
	        		hect : hectareas
	        	});

		        ticks_bar_no_recomendables.push([bandera_no_recomendables, obj.nombre+"<br><b>("+obj.porcentaje+"%)</b>"]);

        		text_auxiliar = "<b> - No se recomienda</b>";

        		bandera_no_recomendables++;
        	}

        	ticks_bar.push([bandera_recomendables-1, obj.nombre+"<br><b>("+obj.porcentaje+"%)</b>"]);
        	bandera_recomendables++;

        	text+="- "+obj.porcentaje+"% se puede sembrar "+obj.nombre+" "+text_auxiliar+".<br>";
        });

		$("#msg_general").fadeIn("slow", function(){
			$("#msg_general").html(text_general+" La información detallada del diagnostico lo encontrará en los gráficos de la derecha");
		});

	    $.plot("#grafico_flot", bar_data, {
	      grid: {
	        borderWidth: 1,
	        borderColor: "#f3f3f3",
	        tickColor: "#f3f3f3",
	        hoverable: true,
            clickable:true
	      },
	      series: {
	        bars: {
	          show: true,
	          barWidth: 0.5,
	          align: "center"
	        }
	      },
	      xaxis: {
	        ticks : ticks_bar
	      }
	    });

	    $("#grafico_flot").parent().find(".text-reporte").remove();

		$("#grafico_flot").after("<h3 class='text-reporte'>Siembrios no recomendables</h3><div id='grafico2' class='text-reporte' style='width:100%; height:300px'></div>");

		$("#grafico_flot").after("<h3 class='text-reporte'>Siembrios recomendables</h3><div id='grafico1' class='text-reporte' style='width:100%; height:300px'></div>");

		$("#grafico_flot").after("<div class='text-reporte'>"+text+"</div>");

		$.plot("#grafico1", bar_recomendables, {
	      grid: {
	        borderWidth: 1,
	        borderColor: "#f3f3f3",
	        tickColor: "#f3f3f3",
	        hoverable: true,
            clickable:true
	      },
	      series: {
	        bars: {
	          show: true,
	          barWidth: 0.5,
	          align: "center"
	        }
	      },
	      xaxis: {
	        ticks : ticks_bar_recomendables
	      }

	    });

	    $.plot("#grafico2", bar_no_recomendables, {
	      grid: {
	        borderWidth: 1,
	        borderColor: "#f3f3f3",
	        tickColor: "#f3f3f3",
	        hoverable: true,
            clickable:true
	      },
	      series: {
	        bars: {
	          show: true,
	          barWidth: 0.5,
	          align: "center"
	        }
	      },
	      xaxis: {
	        ticks : ticks_bar_no_recomendables
	      }

	    });

	    /*myCanvas = image1.getCanvas();
	    image1 = myCanvas.toDataURL("image/png").replace("image/png", "image/octet-stream");

	    window.location.href = image1;
	    console.log(image1);*/

	},'json').always(function(){
		$("#carga").hide();
	});
});

$(document).bind("plotclick", "#grafico_flot, #grafico1, #grafico2, .grafico_flot_new", function (event, pos, item) {
		console.log(item);
        if (item) {
        	key = item.seriesIndex;
            name = item.series.xaxis.ticks[key].label;
            the_name="";
            hectareas = item.series.hect;


            $.each(plantas, function(index, obj) {
            	cultivo = obj.planta;
            	new_name = name;
            	new_name = new_name.substr(0, cultivo.length);

            	if(new_name==cultivo){
            		the_name = new_name;
            		return false;
            	}
            });

            $.post(url_aplication+'conocimientos/for_name', {
            	name: the_name
            }, function(data, textStatus, xhr) {
            	costo_total = (hectareas*data[0].costo_hectarea).toFixed(2);
            	ganancia  = (costo_total*data[0].ganancia).toFixed(0);
            	$("#name_planta").html("<img src='"+url_aplication+"uploads/"+data[0].imagen+"' alt='' style='width:100%'/>");
            	$("#desc_planta").html("<h3 style='text-align:center'>"+data[0].conocimiento+"</h3><div style='text-align:justify'>"+data[0].descripcion+"</div> <br><div><b>Insecticidadas recomendables</b><br>"+data[0].insecticidas+" </div> <br><div><b>Periodo de Crecimiento : </b><br>"+data[0].periodo_crecimiento+" </div> <br><div><b>Densidad por hectareas : </b> La densidad de siembra del cultivo de <b>"+the_name+"</b> es de "+data[0].kilos_hectarea+" Plantas/Ha</div> <br><div><b>Toneladas por hectareas : </b> "+data[0].toneladas_hectarea+" Kg</div> <br><div><b>Costo por hectareas : </b> S/."+data[0].costo_hectarea+"</div> <br><div><b>Total de hectareas : </b> "+hectareas+"</div> <br><div><b>Costo Total: </b> S/."+costo_total+"</div> <br><div><b>Ganancia: </b> S/."+ganancia+"</div>");
            	$("#descripcion_planta").modal();
            },'json');

        }
});

