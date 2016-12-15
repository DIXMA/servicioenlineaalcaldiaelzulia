function consultar(url) {
    var doc = $("#documento").val();
    if (doc) {
        $("#result").html("<center><i class='fa fa-spinner'></i>Consultando...</center>");
        $.ajax({
            method: "get",
            url: url+"/sisben/consultar/"+doc
        }).done(function (msg) {
            //alert(msg.numero_documento);
            if(msg){
                $("#result").html("Se encuentra un registro a nombre de: <b>"+msg.nombre1+" "+msg.nombre2+" "+msg.apellidos1+" "+msg.apellidos2+"</b><br/><a href='"+url+"/sisben/certificado/"+doc+"' target='_blank'>PDF</a>");
            }else{
                $("#result").html("<p class='bg-danger'>No se encuentra un registro en la Base local del SISBEN con el número de documento indicado.</p>");
            }            
        });
    }else{
        alert("Debe digitar un número de documento.");
    }
}

function validarExtension(id, error) {
    var val = $("#" + id).val();

    var ext = (val.substring(val.lastIndexOf("."))).toLowerCase();
    if (ext !== '.csv') {
        var input = $('#' + id);
        var clon = input.clone();
        input.replaceWith(clon);
        $("#" + error).text("El archivo que intenta cargar no es un PDF, verifique e intentelo de nuevo.").show().fadeOut(8000);
    } else {
        $("#" + error).text("");
    }
}

function ejecutar(url) {
    //alert("¡Atención!\n Vamos a iniciar el proceso de carga esto tardará un tiempo, por favor espera pacientemente, ");
    $("#boton").attr('disabled', 'true');
    $("#sisben").attr('disabled', 'true');
    var mostrar = '<div class="info-box bg-yellow">';
    mostrar += '<span class="info-box-icon"><img src="'+url+'" style="50%;"></span>';
    mostrar += '<div class="info-box-content">';
    mostrar += '<span class="info-box-text">Los datos se estan cargando</span>';
    mostrar += '<span class="info-box-number">Esto tomará un tiempo, por favor espera pacientemente. POR FAVOR NO RECARGUE LA PAGINA NI ACCEDA A OTRO LINK, ESTO OCASIONARA QUE SE CANCELE EL PROCESO.</span>';
    mostrar += '<div class="progress">';
    mostrar += '<div class="progress-bar" style="width: 70%"></div>';
    mostrar += '</div>';
    mostrar += '<span class="progress-description">';
    mostrar += 'Estamos avanzando en el proeceso';
    mostrar += '</span>';
    mostrar += '</div>';
    mostrar += '</div>';
    $("#campos").html(mostrar);
    $("#formSisbenAct").submit();
}

