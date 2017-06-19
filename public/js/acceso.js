link_confirmar = "";

$(document).ready(function() {
    $(".t_user").click(function(){
        input = $(this);
        $.post(url_aplication+"acceso/datos", {
            id_tipo_usuario:input.val()
        }, function(data) {
            lista = '';
            $.each(data, function(index, mod) {
                if(mod.padre===0 || mod.padre==="0")
                {
                    lista+="<ul style='list-style:none'>";
                    if(mod.check===1 || mod.check==="1")
                    {
                        lista+="<li class='checkbox'><div class='checkbox'><label><input type='checkbox' id='mod"+mod.id_modulo+"' onclick='reg_permisos("+input.val()+", "+mod.id_modulo+")' checked/>"+mod.modulo+"</label></div><ul style='list-style:none'>";
                    }else{
                        lista+="<li class='checkbox'><div class='checkbox'><label><input type='checkbox' id='mod"+mod.id_modulo+"' onclick='reg_permisos("+input.val()+", "+mod.id_modulo+")'/>"+mod.modulo+"</label></div><ul style='list-style:none'>";
                    }

                    $.each(data, function(key, md_hijo) {
                        if(md_hijo.padre===mod.id_modulo)
                        {
                            if(md_hijo.check==1)
                            {
                                lista+="<li class='checkbox'><div class='checkbox'><label><input type='checkbox' id='mod"+md_hijo.id_modulo+"' onclick='reg_permisos("+input.val()+", "+md_hijo.id_modulo+")' checked/>"+md_hijo.modulo+"</label></div></li>";
                            }else{
                                lista+="<li class='checkbox'><div class='checkbox'><label><input type='checkbox' id='mod"+md_hijo.id_modulo+"' onclick='reg_permisos("+input.val()+", "+md_hijo.id_modulo+")' />"+md_hijo.modulo+"</label></div></li>";
                            }
                        }
                    });
                    lista+="</ul></li></ul>";
                }
                //lista = mod;
            });
            $("#resultado").css("display", "none");
            $("#resultado").html(lista);
            $("#resultado").slideDown();
            //console.log(lista);
        },'json');
    });
});

function reg_permisos(t_user, mod)
{
    if($("#mod"+mod).is(":checked"))
    {
        reg_permiso(t_user, mod);
    }else{
        eliminar_permiso(t_user, mod);
    }
}

function eliminar_permiso(user, mod)
{
    $.post(url_aplication+'acceso/eliminar', {id_modulo:mod, id_tipo_usuario:user}, function(data){});
}

function reg_permiso(user, mod)
{
    $.post(url_aplication+'acceso/registrar', {id_modulo:mod, id_tipo_usuario:user}, function(data){});
}