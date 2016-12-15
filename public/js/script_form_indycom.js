function cambioTipoActividad() {
    var acti = $("#actividadeconomica").val();
    var res = acti.split("_");
    $("#tipoactividad option[value=" + res[1] + "]").attr("selected", "selected");
}

function validarExtension(id, error) {
    var val = $("#" + id).val();
    var input = document.getElementById(id);
    var file = input.files[0];
    //alert(file.size);
    if (file.size > 1000000) {
        var input = $('#' + id);
        var clon = input.clone();
        input.replaceWith(clon);
        $("#" + error + '2').html("El archivo debe pesar <b>MENOS</b> de 1 MegaByte, por favor verifique e intentelo de nuevo.").show().fadeOut(8000);
    } else {
        $("#" + error).text("");
    }
    var ext = (val.substring(val.lastIndexOf("."))).toLowerCase();
    if (ext !== '.pdf') {
        var input = $('#' + id);
        var clon = input.clone();
        input.replaceWith(clon);
        $("#" + error).text("El archivo que intenta cargar no es un PDF, verifique e intentelo de nuevo.").show().fadeOut(8000);
    } else {
        $("#" + error).text("");
    }
}

function enviarForm(url) {
    var valida = 0;
    //alert("VALIDA - " + valida);
    var tipodocumento = $("#tipodocumento").val();
    if (tipodocumento === "x") {
        valida++;
        $("#errortipodocumento").text("Debe seleccionar un tipo de documento.").show().fadeOut(6000);
    } else {
        $("#errortipodocumento").text("");
    }

    var fecha = $("#fecha").val();
    if (fecha === "") {
        valida++;
        $("#errorfecha").text("Debe seleccionar una fecha de nacimiento.").show().fadeOut(6000);
    } else {
        $("#errorfecha").text("");
    }

    var numero = $("#numero").val();
    if (numero === "") {
        valida++;
        $("#errornumero").text("Debe digitar el número de documento.").show().fadeOut(6000);
    } else {
        var x = parseInt(numero);
        if (x < 100000) {
            valida++;
            $("#errornumero").text("Debe digitar el número de documento.").show().fadeOut(6000);
        } else {
            $("#errorfecha").text("");
        }
    }

    var nombres = $("#nombres").val();
    if (nombres === "") {
        valida++;
        $("#errornombres").text("Debe digitar el número de documento.").show().fadeOut(6000);
    } else {
        $("#errornombres").text("").show().fadeOut(6000);
    }

    var errordireccion = $("#direccion").val();
    if (errordireccion === "") {
        valida++;
        $("#errordireccion").text("Debe digitar una dirección de notificación.").show().fadeOut(6000);
    } else {
        $("#errordireccion").text("");
    }

    var erroractividadeconomica = $("#erroractividadeconomica").val();
    if (erroractividadeconomica === "x_x") {
        valida++;
        $("#erroractividadeconomica").text("Debe seleccionar la activicad económica del contribuyente.").show().fadeOut(6000);
    } else {
        $("#erroractividadeconomica").text("");
    }

    var direccionestablecimiento = $("#direccionestablecimiento").val();
    if (direccionestablecimiento === "") {
        valida++;
        $("#errordireccionestablecimiento").text("Debe digitar la dirección del establecimiento.").show().fadeOut(6000);
    } else {
        $("#errordireccionestablecimiento").text("");
    }

    var tipoactividad = $("#tipoactividad").val();
    if (tipoactividad === "x") {
        valida++;
        $("#errortipoactividad").text("Debe seleccionar el tipo de actividad.").show().fadeOut(6000);
    } else {
        $("#errortipoactividad").text("");
    }

    var telefono = $("#telefono").val();
    if (telefono === "") {
        valida++;
        $("#errortelefono").text("Debe seleccionar el tipo de actividad.").show().fadeOut(6000);
    } else {
        $("#errortelefono").text("");
    }

    var matricula = $("#matricula").val();
    if (matricula === "") {
        valida++;
        $("#errormatricula").text("Debe digitar el número de matricula de cámara de comercio.").show().fadeOut(6000);
    } else {
        $("#errormatricula").text("");
    }

    var fmatricula = $("#fecha_matricula").val();
    if (fmatricula === "") {
        valida++;
        $("#errorfecha_matricula").text("Debe seleccionar la fecha de matricula de cámara de comercio.").show().fadeOut(6000);
    } else {
        $("#errorfecha_matricula").text("");
    }

    var camaracomercio = $("#camaracomercio").val();
    if (camaracomercio === "") {
        valida++;
        $("#errorcarmaracomercio").text("Debe adjuntar la copia de la camara de comercio.").show().fadeOut(6000);
    } else {
        $("#errorcarmaracomercio").text("");
    }

    var cedula = $("#cedula").val();
    if (cedula === "") {
        valida++;
        $("#errorcedula").text("Debe adjuntar la copiar de la cédula de ciudadania.").show().fadeOut(6000);
    } else {
        $("#errorcedula").text("");
    }

    var rut = $("#rut").val();
    if (rut === "") {
        valida++;
        $("#errorrut").text("Debe adjuntar la copiar del rut.").show().fadeOut(6000);
    } else {
        $("#errorrut").text("");
    }

    var banco = $("#banco").val();
    if (banco === "") {
        valida++;
        $("#errorbanco").text("Debe adjuntar la copiar del pago en el banco.").show().fadeOut(6000);
    } else {
        $("#errorbanco").text("");
    }

    var emal = $("#emal").val();
    if (emal === "") {
        valida++;
        $("#erroremail").text("Debe digitar un correo electrónico.").show().fadeOut(6000);
    } else {
        $("#erroremail").text("");
    }

    //alert(valida);

    if (valida === 0) {
        document.getElementById("formIndyCom").submit();
    } else {
        return;
    }
}

function enviarDatosEditar(){
    alert("YEah");
}


