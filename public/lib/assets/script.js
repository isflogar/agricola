 var url_base = window.location.href;
 var c = 0;
 var array_hecho = [];
 jQuery(document).ready(function($) {

    /*$(".scroll a, .navbar-brand, .gototop,.explore").click(function(event){
    event.preventDefault();
    $('html,body').animate({scrollTop:$(this.hash).offset().top}, 600,'swing');
    $(".scroll li").removeClass('active');
    $(this).parents('li').toggleClass('active');
    });*/
    $("#hechos").select2({
        minimumResultsForSearch: Infinity,
        placeholder: "Busque los ingredientes",
    });

    $(".gototop ").addClass('oculto');

    $(".select2-container, .select2-search__field").css("width", "400px");

    $("#buscar_comida").click(function(){
        c=0;
        array_hecho = [];

        $(".select2-selection__choice").each(function() {
            c++;
        });

        if(c===0){
            alert("SELECCIONE LOS INGREDIENTES PARA REALIZAR LA BUSQUEDA");
        }else{
            $("#buscar_comida").button("loading");
            $(".select2-selection__choice").each(function() {
                val = $(this).html();
                val = val.split('<span class="select2-selection__choice__remove" role="presentation">×</span>');
                val = val [1];

                $("#hechos option").each(function(index, el) {
                    if(val===$(this).html()){
                        array_hecho.push($(this).attr("value"));
                        return false;
                    }
                });
            });

           $.post(url_base+'/index.php/conocimientos/porcentaje', {
            hechos : array_hecho
           }, function(data) {
                $(".conocimiento").css('display', "none");
                t="";
                for (var i = 0; i <data.length; i++) {
                    //$("#comida_db"+data[i].id_plato).css("display", "block");
                    //console.log(data)
                    t += '<figure class="effect-oscar  wowload fadeInUp conocimiento" id-c="'+data[i].id_p+'" id="comida_db<?=$obj->id_conocimiento?>"><img src="'+url_base+'/uploads/'+data[i].imagen+'" class="img-responsive" style="width: 102%; height: 300px;"/><figcaption><h2 class="nombre_conocimiento efecto oculto">'+data[i].nombre+'</h2><p><a href="javscript:void(0)" title="1" data-gallery>Ver mas</a></p></figcaption></figure>';
                }

                console.log(t);

                $("#foods").html(t);
           },'json').always(function(){
                $("#buscar_comida").button("reset");
           });
        }
    });
});

$(document).on("mouseover mouseout", ".conocimiento", function(){
    $(this).find(".nombre_conocimiento").toggleClass("oculto");
});

$(document).on("keyup", ".select2-search__field", function(){
    v = $(this).val();
    $.post(url_base+"/index.php/hechos/datos", {
        q:v
    }, function(data) {
        t="";
        $.each(data, function(index, obj) {
           t+="<li class='select2-results__option select2-results__option--highlighted'>"+obj.hecho+"</li>";
        });
        $("#hechos").html();
    },'json');
});






var wow = new WOW(
  {
    boxClass:     'wowload',      // animated element css class (default is wow)
    animateClass: 'animated', // animation css class (default is animated)
    offset:       0,          // distance to the element when triggering the animation (default is 0)
    mobile:       true,       // trigger animations on mobile devices (default is true)
    live:         true        // act on asynchronously loaded content (default is true)
  }
);
wow.init();




$('.carousel').swipe( {
     swipeLeft: function() {
         $(this).carousel('next');
     },
     swipeRight: function() {
         $(this).carousel('prev');
     },
     allowPageScroll: 'vertical'
 });


$(document).on("click", ".conocimiento", function(){
    id_c = $(this).attr("id-c");
    //console.log(url_base);
    $.post(url_base+"/index.php/conocimientos/datos", {
        id:id_c
    }, function(data, textStatus, xhr) {
        $.each(data[0], function(index, val) {
            $("#nombre_conocimiento").html(val.conocimiento);
            $("#descripcion_conocimiento").html(val.descripcion);
            $("#imagen_conocimiento").attr("src", url_base+"/uploads/"+val.imagen);
            $("#modal_conocimiento").modal();
        });

        t="<ul class='row'>";
        $.each(data[1], function(index, obj) {
            t+="<li class='col-md-6'>"+obj.descripcion+" - <b>"+obj.tipo_hecho+"</b></li>";
        });
        t+="<ul>";
        $("#ingre").html(t);
    },'json');
});




// map

