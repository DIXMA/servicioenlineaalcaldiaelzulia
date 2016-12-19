<html>
<head>
    <title>Certificado INDYCOM</title>
    <style type="text/css">
        .panel-heading {
            border: 2px;
            border-radius: 2%;
            border-color: #d5d5d5;
            background-color: #9d9d9d;
            color: #ffffff;
            width: 100%;
            padding-left: 1%;
            padding-top: 1%;
            padding-bottom: 1%;
            font-weight: bold;
        }

        .panel-contenido {
            border: 2px solid;
            border-color: #ddd;
            border-radius: 5%;
            padding: 2% 2% 2% 2%;
        }

        .table {

        }

        td {
            padding: 1% 1% 1% 1%;
        }
    </style>
</head>

<body>

<div style="position: fixed;">
    <img src="{{URL::to('img/escudo.jpg')}}" style="width: 15%;">
</div>
<div style="padding-left: 10%;">
    <center>
        <h2>REGISTRO DE INSCRIPCION DE INDUSTRIA Y COMERCIO</h2>
        <h4>ALCALDÍA MUNICIPAL DE ZULIA</h4>
        <h5>SECRETARIA DE HACIENDA MUNICIPAL</h5>
    </center>
</div>
<br/>

<div class="panel-heading">DATOS BASICOS DEL ESTABLECIMIENTO</div>
<div class="panel-contenido">
    <table class="table">
        <tr>
            <td>Placa: {{$registro->placa}}</td>
            <td>Identificación: {{$registro->numero_identificacion}}</td>
        </tr>
        <tr>
            <td colspan="2">Razón Social: {{$registro->razon_social}}</td>
        </tr>
        <tr>
            <td colspan="2">Nombre Comercial: {{$registro->nombre_comercial}}</td>
        </tr>
        <tr>
            <td>Id. Propietario: {{$registro->numero_identificacion}}</td>
            <td>Propietario: {{$registro->razon_social}}</td>
        </tr>
        <tr>
            <td>Id. Rep. Legal: {{$registro->numero_identificacion}}</td>
            <td>Rep. Legal: {{$registro->razon_social}}</td>
        </tr>
        <tr>
            <td colspan="2">Dirección: {{$registro->direccion_establecimiento}}</td>
        </tr>
        <tr>
            <td>Estado: A</td>
            <td>Regimen: {{$registro->regimen}}&nbsp;Tipo Contribuyente: J</td>
        </tr>
        <tr>
            <td>Fecha Inscripción: {{$registro->fecha}}</td>
            <td>Fecha Inicio: {{$registro->fecha}}</td>
        </tr>
        <tr>
            <td>Cámara de Comercio: {{$registro->matricula}}</td>
            <td>Fecha Cámara de Comercio: {{$registro->fecha_matricula}}</td>
        </tr>
        <tr>
            <td colspan="2">Email: {{$registro->email}}</td>
        </tr>
    </table>
</div>

<div class="panel-heading">DATOS ACTIVIDAD</div>
<div class="panel-contenido">
    <table>
        <tr>
            <td>Actividad: {{$actividad->codigo}}</td>
        </tr>
        <tr>
            <td>Descripción: {{$actividad->name}}</td>
        </tr>
        <tr>
            <td>Tipo Actividad: {{$tipo_act->name}}</td>
        </tr>
    </table>
</div>
<img src="{{URL::to('img/firma_indycom.png')}}" style="width: 20%; position: absolute;"><br/><br/>
<p>
    Gabriel Alejandro Robledo Escalante<br/>
    Auxiliar Administrativo
</p>


</body>
</html>