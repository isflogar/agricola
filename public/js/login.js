$(document).ready(function() {
	$("#form_login").submit(function(event){
		event.preventDefault();
		$("#btnLogin").button("loading");
		$.post(url_aplication+"usuario/validar_acceso", $(this).serialize(), function(data) {
			if(data==="1" || data===1){
				$("#mensaje_login").removeClass('alert-danger').addClass('alert-success').html("<i class='fa fa-check-circle'></i> Redireccionando...........<i class='fa fa-refresh fa-spin'></i>").slideToggle(800, function(){
					window.location = url_aplication+"app";
				});
			}else{
				$("#mensaje_login").removeClass('alert-success').addClass('alert-danger').html("<i class='fa fa-times'></i> Datos incorrectos").slideToggle(1500, function(){
					$("#mensaje_login").fadeToggle(2500);
				});
			}
		}).always(function(){
    		$("#btnLogin").button("reset");
		});
	});
});
