@extends('template.template_web')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Consulta del Registro en el SISBEN</h3>

                </div>
                <div class="box-body no-padding">
                    <center>
                        <img src="{{URL::to('img/bdlocal.jpg')}}">                        
                    </center>
                    <div class="col-sm-2 col-md-8 col-md-offset-2">
                        <br/>
                        <p style="text-align: justify;">
                            La Alcaldía Municipal de El Zulia ha dispuesto la siguiente aplicación para permitir a los inscritos en la base de datos local de Potenciales Beneficiarios a programas Sociales - SISBEN, verificar su información para fines de corrección de llegar a presentar alguna inconsistencia. esta información puede descargarse en línea.
                            <br/><br/>
                            Para realizar la busqueda solo tiene que escoger el tipo de documento y digitar el número de identificación sin puntos.
                        </p>
                    </div>

                    <div class="col-sm-2 col-md-8 col-md-offset-2"> 
                        <br/>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Tipo de Documento</label>
                                    <select name="tipo_doc" id="tipo_doc" class="form-control">
                                        <option value="x">- Seleccione una Opción -</option>
                                        <option value="1">Cédula de Ciudadanía</option>
                                        <option value="2">Tarjeta de Identidad</option> 
                                        <option value="CE">Cédula de Extranjería</option>
                                        <option value="PA">Pasaporte</option>
                                        <option value="4">Registro Civil</option> 
                                        <option value="NU">No. Unico de Id. Personal</option>
                                        <option value="AS">Adulto sin Identificacion</option>
                                        <option value="MS">Menor sin Identificacion</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Número de Documento</label>
                                    <input type="text" name="documento" id="documento" value="" class="form-control" placeholder="Digite el número de documento a consultar.">
                                </div>
                                <div class="form-group">
                                    <center>
                                        <button class="btn btn-lg btn-info" onclick="consultar('{{URL::to("/")}}')"><i class="fa fa-search"> </i> Consultar</button>
                                    </center>
                                </div>
                            </div>
                            <div class="panel-footer" id="result">
                                <center>
                                    No se ha generado una consulta.
                                </center>
                            </div>
                        </div>                        
                    </div>
                </div>
                <!-- /.box-body -->
            </div>

        </div>
    </div>
</section>
<script src="{{URL::to('js/script_sisben.js')}}"></script>
@endsection