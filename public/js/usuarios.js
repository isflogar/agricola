var table = $("#table");
var estado_r, url_base, param;
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
	//listar();

	$("#form").submit(function(event){
		event.preventDefault();
		estado_r = $("#btnRealizar").attr("data-e");

		$("#btnRealizar").button("loading");
		if(estado_r==="R"){
			$.post(url_base+"/usuario/procesar", $("#form").serialize(), function(data) {
				if(data===1 || data==="1"){
					alert("USUARIO REAGISTRADO");
					listar();
					limpiar();
				}else{
					alert(data);
				}
			}).always(function(){
				$("#btnRealizar").button("reset");
			});
		}else if(estado_r==="E"){
			$.post(url_base+"/usuario/procesar", $("#form").serialize(), function(data) {
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
			alert("ERROR :v");
		}
	});

	$("#id_tipo_usuario").change(function(){
		if($(this).val()==="2"){
			$("#data-doc").html("RUC");
			$("#dni").attr("maxlength", "11");
		}else{
			$("#data-doc").html("DNI");
			$("#dni").attr("maxlength", "8");
		}

		$("#dni").val("");
	});
});

$(document).on("click", ".btn-editar", function(){
	$("#btnRealizar").attr("data-e", "E");
	t_u = $(this).attr("id-t-u");
	$("#id_tipo_usuario").val(t_u);
	id_u = $(this).attr("id-u");
	$("#id_usuario").val(id_u);
	$("#nombre").val($(this).parent().parent().parent().find("td:nth-child(1)").html());
	$("#user").val($(this).parent().parent().parent().find("td:nth-child(3)").html());
	$("#myModalLabel").html("Editar Usuario");
	$("#clave").val("");
	$("#modal_registro").modal("show");
});

$(document).on("click", ".btn-eliminar", function(){
	if (confirm("¿ESTAS SEGURO DE ELIMINAR ESTOS DATOS?")) {
		id = $(this).attr("id-u");
		$.post(url_base+"/usuario/eliminar", {
			id_usuario:id
		}, function(data) {
				if(data===1 || data==="1"){
					alert("DAT0S ELIMINADOS");
					listar();
				}else{
					alert(data);
				}
		});
	}else{
		return;
	}
});

function limpiar(){
	$("#form input, #form select").val("");
	$("#btnRealizar").attr("data-e", "R");
	$("#modal_registro").modal("hide");
	$("#myModalLabel").html("Registrar Usuario");
}

function listar(){
	$.post(url_base+"/usuario/datos", function(data) {
		table.fnDestroy();
		var ap,doc;
		$("#table tbody").html("");
		$.each(data, function(index, el) {
			t="<tr>";
			t+="<td>"+el.nombre+"</td>";
			t+="<td>"+el.descripcion+"</td>";
			t+="<td>"+el.user+"</td>";
			t+="<td><center><button type='button' class='btn btn-sm btn-warning btn-editar' id-u='"+el.id_usuario+"' id-t-u='"+el.id_tipo_usuario+"'><i class='fa fa-pencil'></i> Editar</button> | <button type='button' class='btn btn-sm btn-danger btn-eliminar' id-u='"+el.id_usuario+"'><i class='fa fa-trash'></i> Eliminar</button></center></td>";
			t+="</tr>";
			$("#table tbody").append(t);
		});
		table.dataTable(param);
	},'json');
}