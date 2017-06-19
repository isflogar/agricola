var plantas = [];
$(document).ready(function() {
	$.post(url_aplication+'conocimientos/datos', function(data, textStatus, xhr) {
		$.each(data, function(index, obj) {
			plantas.push({
				"id_conocimiento" : obj.id_conocimiento,
				"planta" : obj.conocimiento
			});
		});
	},'json');

	$.post(url_aplication+'estadistica_usuario/estadistica', function(data, textStatus, xhr) {
		//$("#carga").show();

		$(".new_graf").remove();
		cont = 0;
		$.each(data, function(key, obj) {
			bar_data = [];
			text = "Se registra que en un :<br>";
			text_auxiliar = "";

			bandera_recomendables = 1;
			bandera_no_recomendables = 0;

			bar_recomendables = [];
			bar_no_recomendables = [];

			ticks_bar = [];
			ticks_bar_recomendables = [];
			ticks_bar_no_recomendables = [];

			new_graf = '<div class="col-md-4 new_graf" id="new_graf'+cont+'"><div class="row"><div class="box box-warning"><div class="box-header with-border"><h5 class="box-title">'+key+' | Hectareas : '+obj[0].hectareas+'</h5></div><div class="box-body"><div class="grafico_flot_new" style="width:100%; height:300px"></div><div class="mensaje"></div> <h2>Recomendables</h2><div class="grafico_flot_new1" style="width:100%; height:300px"></div> <h2>No recomendables</h2><div class="grafico_flot_new2" style="width:100%; height:300px"></div></div></div></div></div>';

			$(".lista_fundos").append(new_graf);
			text = "<br>Se registra que en un :<br>";
			$.each(obj, function(llave, obj2) {
				bar_data.push({
	        		data : [[bandera_recomendables-1, obj2.porcentaje]],
	        		color : obj2.color,
	        		hect : obj2.hectareas
	        	});

	        	//selecionando las 3 recomendables y las que no sirven para nada :v
	        	if(bandera_recomendables<=3){
	        		bar_recomendables.push({
		        		data : [[bandera_recomendables-1, obj2.porcentaje]],
		        		color : obj2.color,
		        		hect : obj2.hectareas
		        	});

			        ticks_bar_recomendables.push([bandera_recomendables-1, obj2.nombre+"<br><b>("+obj2.porcentaje+"%)</b>"]);

	        		text_auxiliar = "<b> - <span style='color:#00A65A'>Se recomienda</span></b>";
	        	}else{
	        		bar_no_recomendables.push({
		        		data : [[bandera_no_recomendables, obj2.porcentaje]],
		        		color : obj2.color,
		        		hect : obj2.hectareas
		        	});

			        ticks_bar_no_recomendables.push([bandera_no_recomendables, obj2.nombre+"<br><b>("+obj2.porcentaje+"%)</b>"]);

	        		text_auxiliar = "<b> - <span style='color:#FF0000'>No se recomienda</span></b>";

	        		bandera_no_recomendables++;
	        	}

	        	text+="- "+obj2.porcentaje+"% se puede sembrar "+obj2.nombre+" "+text_auxiliar+".<br>";

	        	ticks_bar.push([bandera_recomendables-1, obj2.nombre+"<br><b>("+obj2.porcentaje+"%)</b>"]);

	        	bandera_recomendables++;
			});

			$('#new_graf'+cont+" .mensaje").html(text);

			$.plot('#new_graf'+cont+" .grafico_flot_new", bar_data, {
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

			$.plot('#new_graf'+cont+" .grafico_flot_new1", bar_recomendables, {
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

			$.plot('#new_graf'+cont+" .grafico_flot_new2", bar_no_recomendables, {
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

		$(".lista_fundos").css("margin", "0px");
	},'json').always(function(){
		//$("#carga").hide();
	});
});

function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'+series.data[0][1]+"%</div>";
}

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
            	$("#name_planta").html("<img src='"+url_aplication+"uploads/"+data[0].imagen+"' alt='' style='width:100%'/>");
            	$("#desc_planta").html("<h3 style='text-align:center'>"+data[0].conocimiento+"</h3><div style='text-align:justify'>"+data[0].descripcion+"</div> <br><div><b>Insecticidadas recomendables</b><br>"+data[0].insecticidas+" </div> <br><div><b>Periodo de Crecimiento : </b><br>"+data[0].periodo_crecimiento+" </div> <br><div><b>Densidad por hectareas : </b> "+data[0].kilos_hectarea+"</div> <br><div><b>Toneladas por hectareas : </b> "+data[0].toneladas_hectarea+" Kg</div> <br><div><b>Costo por hectareas : </b> S/."+data[0].costo_hectarea+"</div> <br><div><b>Total de hectareas : </b> "+hectareas+"</div> <br><div><b>Costo Total: </b> S/."+costo_total+"</div>");
            	$("#descripcion_planta").modal();
            },'json');

        }
});