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
                        <img src="{{ URL::to('img/sisben.png') }}" style="width: 89%;">
                        <h3><a href="{{ URL::To('sisben') }}">Verifica el Certificado </a></h3>
                        Puedes descargar el certificado del SISBEN, compltamente gratis.
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 style="text-align: center;">INDUSTRIA Y COMERCIO</h3>
                    <div class="alert alert-info text-center">
                        <img src="{{ URL::to('img/indycom.png') }}" style="width: 100%;">

                        Realiza el registro de industria y comercio, desde esta plataforma.
                        <br/>
                        Requisitos
                        <ul>
                            <li>
                                Requisitos
                            </li>
                        </ul>
                        <h3><a href="{{ URL::to('indycom/registro') }}">Registrate</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection