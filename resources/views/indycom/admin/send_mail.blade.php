<?php
/**
 * Created by PhpStorm.
 * User: Diegox_Cortex
 * Date: 12/12/2016
 * Time: 10:29 PM
 */
?>

@extends('template.template_admin_indycom')

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
                                <th>Placa:</th>
                                <th><input type="text" class="form-control"
                                           placeholder="Digite el número de la placa generada para el registro." id="placa"></th>
                                <th>Identificación:</th>
                                <td colspan="3">{{$registro->numero_identificacion}}</td>
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
                        DATOS ACTIVIDAD
                    </div>
                    <div class="box-body">
                        <b>Actividad: </b>{{$actividad->codigo}}<br/>
                        <b>Descripción: </b>{{$actividad->name}}<br/>
                        <b>Tipo Actividad: </b>{{$tipo_act->name}}<br/>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <input type="hidden" name="id" id="id" value="{{$registro->id}}">
                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">

                        <button class="btn btn-success pull-right" id="enviar" onclick="enviarDatos()"><i class="fa fa-send"></i> Enviar</button>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <script src="{{URL::to('js/script_validacion_registro.js')}}"></script>
@endsection
