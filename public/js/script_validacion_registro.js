function enviarDatos() {
    var placa = $("#placa").val();
    if (placa === "") {
        alert("Debe digitar la placa generada para el registro.");
        return;
    } else {
        $("#enviar").attr('disabled', 'true');
        $("#cancel").attr('disabled', 'true');
        $("#enviar").html("<i class='fa fa-spinner'></i> Enviando...");
        var conf = confirm("¿Está segur@ que desea guardar la validación del registro y notificar al usuario por e-mail?");
        if (conf) {
            alert("Este proceso puede tardar unos minutos por favor espere.");
            var id = $("#id").val();
            var url = $("#url").val();
            $.ajax({
                method: "get",
                url: url+"/indycom/validar",
                data: {id: id, url: url, placa: placa}
            }).done(function (result) {
                alert(result);
                var r = JSON.parse(result);
                if(r.estado === "ok"){
                    alert(r.mensaje);
                    window.location.href = url+"/admin_indycom/registros";
                }else if (r.estado === "fail"){
                    alert(r.mensaje);
                }
            });
        }
    }
}