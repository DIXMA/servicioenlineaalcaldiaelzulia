@extends('template.template_web')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-offset-1 col-md-10 col-sm-1">

                <div class="box">
                    <div class="box-header with-border" style="background-color: #d9d9d9; color: #ffffff;">
                        <h3 class="box-title">DATOS BÁSICOS DEL ESTABLECIMIENTO</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>Identificación:</th>
                                <td colspan="5">{{$registro->numero_identificacion}}</td>
                            </tr>
                            <tr>
                                <th>Razón Social:</th>
                                <td colspan="5">{{$registro->razon_social}}</td>
                            </tr>
                            <tr>
                                <th>Nombre Comercial:</th>
                                <td colspan="5">{{$registro->nombre_comercial}}</td>
                            </tr>
                            <tr>
                                <th>Id. Propietario:</th>
                                <td>{{$registro->numero_identificacion}}</td>
                                <th>Propietario</th>
                                <td colspan="3">{{$registro->razon_social}}</td>
                            </tr>
                            <tr>
                                <th>Id. Rep. Legal:</th>
                                <td>{{$registro->numero_identificacion}}</td>
                                <th>Rep. Legal:</th>
                                <td colspan="3">{{$registro->razon_social}}</td>
                            </tr>
                            <tr>
                                <th>Dirección:</th>
                                <td colspan="5">{{$registro->direccion_establecimiento}}</td>
                            </tr>
                            <tr>
                                <th>Estado:</th>
                                <td>A</td>
                                <th>Regimen:</th>
                                <td>{{$registro->regimen}}</td>
                                <th>Tipo Cotribuyente:</th>
                                <td>J</td>
                            </tr>
                            <tr>
                                <th>Fecha Inscripción:</th>
                                <?php
                                $date = date_create($registro->fecha);
                                $date2 = date_create($registro->fecha_matricula);
                                $f = date_format($date, 'd/m/Y');
                                $f2 = date_format($date2, 'd/m/Y');
                                ?>
                                <td>{{$f}}</td>
                                <th>Fecha de Inicio:</th>
                                <td colspan="3">{{$f}}</td>
                            </tr>
                            <tr>
                                <th>Camara Cio:</th>
                                <td colspan="3">{{$registro->matricula}}</td>
                                <th>Fecha Camara:</th>
                                <td colspan="2">{{$f2}}</td>
                            </tr>
                            <tr>
                                <th>e-mail:</th>
                                <td colspan="5">{{$registro->email}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-header with-border" style="background-color: #d9d9d9; color: #ffffff;">
                        DATOS A CARGAR
                    </div>
                    <div class="box-body">
                        {!! Form::open(array('url' => 'indycom/editar_registro', 'method' => 'post', 'files' => 'yes', 'id' => 'formIndyCom')) !!}
                        <div class="form-group">
                            <label for="">* Fotocopia de la Cámara de Comercio: </label>
                            <input type="file" class="form-control" name="camaracomercio" id="camaracomercio"
                                   accept=".pdf"
                                   onchange="validarExtension('camaracomercio', 'errorcarmaracomercio')">
                            <span style="color: red;" id="errorcarmaracomercio"></span>
                            <span style="color: red;" id="errorcarmaracomercio2"></span>
                        </div>
                        <div class="form-group">
                            <label for="">* Fotocopia de la Cédula: </label>
                            <input type="file" class="form-control" name="cedula" id="cedula" accept=".pdf"
                                   onchange="validarExtension('cedula', 'errorcedula')">
                            <span style="color: red;" id="errorcedula"></span>
                            <span style="color: red;" id="errorcedula2"></span>
                        </div>
                        <div class="form-group">
                            <label for="">* Fotocopia del Rut: </label>
                            <input type="file" class="form-control" name="rut" id="rut" accept=".pdf"
                                   onchange="validarExtension('rut', 'errorrut')">
                            <span style="color: red;" id="errorrut"></span>
                            <span style="color: red;" id="errorrut2"></span>
                        </div>
                        <div class="form-group">
                            <label for="">* Fotocopia del Pago en Banco consignación $34350: </label>
                            <input type="file" class="form-control" name="banco" id="banco" accept=".pdf"
                                   onchange="validarExtension('banco', 'errorbanco')">
                            <span style="color: red;" id="errorbanco"></span>
                            <span style="color: red;" id="errorbanco2"></span>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <input type="hidden" name="id" id="id" value="{{$registro->id}}">
                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                        <a href="{{URL::to('/')}}" class="btn btn-danger pull-left" id="cancel"><i
                                    class="fa fa-close"></i> Cancelar
                        </a>
                        <button class="btn btn-success pull-right" id="enviar" onclick="enviarDatosEditar()"><i
                                    class="fa fa-send"></i> Enviar
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <script src="{{URL::to('js/script_form_indycom.js')}}"></script>
@endsection