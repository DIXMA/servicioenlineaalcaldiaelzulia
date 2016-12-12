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

