var table = $("#table");

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

	table = table.dataTable(param);

	listar("");

	$("#form").submit(function(event) {
		event.preventDefault();
		$.post(url_aplication+'tipohecho/procesar', $("#form").serialize(), function(data) {
			$("#carga").show();
			if(data===1 || data==="1"){
				alert("PROCESO REALIZADO");
				limpiar();
				listar("");
			}else{
				alert(data);
			}
			$("#carga").hide();
		});
	});
});

function listar(key){
	$.post(url_aplication+'tipohecho/datos', {
		id: key
	}, function(data) {
		if(key==="" || key===undefined){
			table.fnClearTable();
            $.each(data, function(key, obj) {
                table.fnAddData([
                	obj.descripcion,
                	obj.pregunta_empirica,
                	obj.pregunta_cientifica,
                	'<center><button type="button" class="btn btn-sm btn-warning" onclick="editar('+obj.id_tipo_hecho+')"><i class="fa fa-pencil"></i> Editar</button> | <button type="button" class="btn btn-sm btn-danger" onclick="eliminar('+obj.id_tipo_hecho+')"><i class="fa fa-trash"></i> Eliminar</button></center>'
                ]);
            });
		}else{
			$("#myModalLabel").html("Editar Tipo Hecho");
			$("#id_tipo_hecho").val(data[0].id_tipo_hecho);
			$("#descripcion").val(data[0].descripcion);
			$("#pregunta_empirica").val(data[0].pregunta_empirica);
			$("#pregunta_cientifica").val(data[0].pregunta_cientifica);
			$("#modal_registro").modal("show");
		}
	},'json');
}

function eliminar(key){
	if(confirm("¿ELIMINAR?")){
		$.post(url_aplication+'tipohecho/eliminar', {
			id_tipo_hecho: key
		}, function(data, textStatus, xhr) {
			if(data===1 || data==="1"){
				listar();
			}else{
				alert(data);
			}
		});
	}
}

function editar(id){
	listar(id);
}

function limpiar(){
	$("#myModalLabel").html("Registrar Tipo Hecho");
	$("#form input, #form select, #form textarea").val("");
	$("#modal_registro").modal("hide");
}