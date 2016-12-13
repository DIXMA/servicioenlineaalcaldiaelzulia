<?php
/**
 * Created by PhpStorm.
 * User: inc_cortex
 * Date: 12/12/2016
 * Time: 10:15 PM
 */
?>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Mail</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <h1>{{$titulo}} - estado {{$estado}}</h1>
        <br/>

        <h3 style="text-align: justify;">{{$contenido}}}</h3>
    </div>
    <div class="row">
        <h2 style="text-align: justify;">Observaciones Generales:</h2>
        <h4>{{$general}}</h4>
        <br/>

        <h2 style="text-align: justify;">Observaciones del Documento Adjunto:</h2>
        <h4>{{$documento}}</h4>
        <br/>

        <h2 style="text-align: justify;">Observaciones del Rut Adjunto:</h2>
        <h4>{{$rut}}</h4>
        <br/>

        <h2 style="text-align: justify;">Observaciones del documento de Cámara de Comercio Adjunto:</h2>
        <h4>{{$camcom}}</h4>
    </div>
    <div class="row">
        <br/>
        <h3>Nota:</h3>
        <h5>Este correo es enviado a través de los servicios en línea de la Alcaldía de el Zulia.</h5>
        <h5>Por favor, no responder este correo.</h5>
    </div>
</div>
</body>
</html>
