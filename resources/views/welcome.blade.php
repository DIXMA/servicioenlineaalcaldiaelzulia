@extends("template.template_web")

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border" style="text-align: center;">
                    <h2>BIENVENIDO A LOS SERVICIOS EN LÍNEA</h2>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <h3 style="text-align: center;">SISBEN</h3>
                        <div class="alert alert-warning text-center">
                            <img src="{{ URL::to('img/sisben.png') }}" style="width: 89%;"><br>
                            <p>Puedes descargar el certificado del SISBEN, compltamente gratis.</p><br/>
                            <a href="{{ URL::To('sisben') }}" class="btn btn-warning pull-right"><i class="fa fa-file-pdf-o"></i> Consulta el Certificado </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 style="text-align: center;">INDUSTRIA Y COMERCIO</h3>
                        <div class="alert alert-info">
                            <img src="{{ URL::to('img/indycom.png') }}" style="width: 100%;">
                            Para realizar el registro de industria y comercio, desde esta plataforma de debe cumplir los
                            siguientes <b>requisitos</b>.
                            <div class="box-body">
                                <ul>
                                    <li><b>Tener en PDF la fotocopia de la Cámara de Comercio</b></li>
                                    <li><b>Tener en PDF la fotocpia del RUT</b></li>
                                    <li><b>Tener en PDF la fotocpia de la Cédula de Ciudadanía del representante legal</b></li>
                                    <li><b>Tener en PDF la fotocpia de la consignación en el Banco con los siguientes datos:</b></li>
                                    <ul>
                                        <li><b>BANCO DE BOGOTA</b></li>
                                        <li><b>VALOR $34350</b></li>
                                        <li><b>CUENTA No. 825 00017-7</b></li>
                                        <li><b>CUENTA CORRIENTE</b></li>
                                        <li><b>MUNICIPIO EL ZULIA</b></li>
                                    </ul>
                                </ul>
                            </div>
                            <a href="{{ URL::to('indycom/registro') }}" class="btn btn-primary pull-right"><i class="fa fa-send"></i> Hacer el Registro</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection