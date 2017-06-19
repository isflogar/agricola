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
		$.post(url_aplication+'modulo/procesar', $("#form").serialize(), function(data) {
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
	$.post(url_aplication+'modulo/datos', {
		id: key
	}, function(data) {
		if(key==="" || key===undefined){
			table.fnClearTable();
            $.each(data, function(key, obj) {
                table.fnAddData([
                	obj.descripcion,
                	obj.url,
                	'<center><i class="'+obj.img+'"></i></center>',
                	obj.orden,
                	'<center><button type="button" class="btn btn-sm btn-warning" onclick="editar('+obj.id_modulo+')"><i class="fa fa-pencil"></i> Editar</button> | <button type="button" class="btn btn-sm btn-danger" onclick="eliminar('+obj.id_modulo+')"><i class="fa fa-trash"></i> Eliminar</button></center>'
                ]);
            });
		}else{
			$("#myModalLabel").html("Editar Modulo");
			$("#id_modulo").val(data[0].id_modulo);
			$("#descripcion").val(data[0].descripcion);
			$("#url").val(data[0].url);
			$("#img").val(data[0].img);
			$("#orden").val(data[0].orden);
			$("#modal_registro").modal("show");
		}
	},'json');
}

function eliminar(key){
	if(confirm("¿ELIMINAR?")){
		$.post(url_aplication+'modulo/eliminar', {
			id_modulo: key
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
	$("#myModalLabel").html("Registrar Modulo");
	$("#form input, #form select, #form textarea").val("");
	$("#modal_registro").modal("hide");
}