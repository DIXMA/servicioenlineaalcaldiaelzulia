<html>
<head>
    <title>Certificado Sisben</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{URL::to('web_theme/bootstrap/css/bootstrap.min.css')}}">

</head>
<body>
<div class="row">
    <div>
        <img src="{{URL::to('img/sisben.png')}}" style="width: 25%;">
    </div>
    <div style="text-align: right; position: fixed;">
        <img src="{{URL::to('img/escudo.jpg')}}" style="width: 13%;">
    </div>

    <center>
        <h3 style="font-family: Impact, Helvetica, Arial, sans-serif;">
            <b>República de Colombia<br/>
                Departamento Norte de Santander<br/>
                Municipio de El Zulia</b>
        </h3>
        <br/><br/>
        <h4 style="font-family: Impact, Helvetica, Arial, sans-serif;"><b>EL COORDINADOR MUNICIPAL DEL SISBEN</b></h4>
        <h4 style="font-family: Impact, Helvetica, Arial, sans-serif;"><b>CERTIFICA</b></h4>
    </center>

    <p style="text-align: justify; padding-left: 8px; padding-right: 8px;">
        Que la persona relacionada en este documento, se encuentra registrada en la Base de Datos de Potenciales
        Beneficiarios para Programas Sociales (SISBEN).
        BASE DE DATOS LOCAL DEL MUNICIPIO y según ficha de Clasificación Socioeconomica, presenta la siguiente
        información:
    </p>
    <div style="padding-left: 40px; padding-right: 40px;">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Tipo Doc</th>
                <th>Documento</th>
                <th>1er. Nombre</th>
                <th>2do. Nombre</th>
                <th>1er. Apellido</th>
                <th>2do. Apellido</th>
                <th>Género</th>
                <th>Ficha</th>
                <th>Puntaje Sisben</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @if($user->tipo_documento == 1)
                    <td>Cédula de Ciudadanía</td>
                @elseif($user->tipo_documento == 2)
                    <td>Tarjeta de Identidad</td>
                @elseif($user->tipo_documento == 'CE')
                    <td>Cédula de Extranjería</td>
                @elseif($user->tipo_documento == 'PA')
                    <td>Pasaporte</td>
                @elseif($user->tipo_documento == '4')
                    <td>Registro Civil</td>
                @elseif($user->tipo_documento == 'NU')
                    <td>No. Unico de Id. Personal</td>
                @elseif($user->tipo_documento == 'AS')
                    <td>Adulto sin Identificacion</td>
                @elseif($user->tipo_documento == 'MS')
                    <td>Menor sin Identificacion</td>
                @endif
                <td>{{$user->numero_documento}}</td>
                <td>{{$user->nombre1}}</td>
                <td>{{$user->nombre2}}</td>
                <td>{{$user->apellidos1}}</td>
                <td>{{$user->apellidos2}}</td>
                @if($user->genero == 1)
                    <td>Masculino</td>
                @elseif($user->genero == 2)
                    <td>Femenino</td>
                @endif
                <td>{{$user->ficha}}</td>
                <td>13</td>
            </tr>
            </tbody>
        </table>
    </div>
    <p style="padding-left: 40px; padding-right: 40px;">
        Este documento se expide a solicitud del interesado a los {{$dia}} dia(s) del mes {{$mes}} de {{$ano}}
        y tiene una validez de un (1) mes a partir de la fecha.
        <br/>
        Base de datos a corte del 21 de Octure de 2016.
    </p>
    <img src="{{URL::to('img/Firma.png')}}" style="width: 40%;">
</div>
</body>
</html>