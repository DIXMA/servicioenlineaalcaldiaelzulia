function info(id, tipo_tramite, tipo_documento, numero_identificacion, naturaleza_juridica, razon_social, direccion_notificacion, actividad_economica, direccion_establecimiento, tipo_actividad, telefono, regimen, url_documento, url_camaracomercio, url_rut) {
    $("#tipo_tramite").html(tipo_tramite);
    $("#tipo_documento").html(tipo_documento);
    $("#numero_identificacion").html(numero_identificacion);
    $("#naturaleza_juridica").html(naturaleza_juridica);
    $("#razon_social").html(razon_social);
    $("#direccion_notificacion").html(direccion_notificacion);
    $("#actividad_economica").html(actividad_economica);
    $("#direccion_establecimiento").html(direccion_establecimiento);
    $("#tipo_actividad").html(tipo_actividad);
    $("#telefono").html(telefono);
    $("#regimen").html(regimen);
    $("#url_documento").html("<a href='" + url_documento + "' target='_blank'>Ver Adjunto</a>");
    $("#url_camaracomercio").html("<a href='" + url_camaracomercio + "' target='_blank'>Ver Adjunto</a>");
    $("#url_rut").html("<a href='" + url_rut + "' target='_blank'>Ver Adjunto</a>");
    $("#id").val(id);
}

function validarObservaciones() {
    var valida = 0;

    var obs_general = $("#obs_general").val();
    if (obs_general === "") {
        valida++;
        $("#error_obs_general").text('Debe llenar este campo.').delay(8000).hide(500);
    }
    var obs_documento = $("#obs_documento").val();
    if (obs_documento === "") {
        valida++;
        $("#error_obs_documento").text('Debe llenar este campo.').delay(8000).hide(500);
    }
    var obs_camaradecomercio = $("#obs_camaradecomercio").val();
    if (obs_camaradecomercio === "") {
        valida++;
        $("#error_obs_camaradecomercio").text('Debe llenar este campo.').delay(8000).hide(500);
    }
    var obs_rut = $("#obs_rut").val();
    if(obs_rut === ""){
        valida++;
        $("#error_obs_rut").text('Debe llenar este campo.').delay(8000).hide(500);
    }
    if($("#validado").val() === 'x'){
        valida++;
        $("#error_chec").text('Debe seleccionar una opción.').delay(8000).hide(500);
    }

    if (valida === 0) {
        document.getElementById("formOsbRegi").submit();
    } else {
        return;
    }
}
