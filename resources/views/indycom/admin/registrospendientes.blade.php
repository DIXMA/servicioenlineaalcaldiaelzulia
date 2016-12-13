@extends("template.template_admin_indycom")

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Registros</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a href="#"><i class="fa fa-inbox"></i> Pendientes <span
                                            class="label label-primary pull-right">{{$cant_pendientes}}</span></a></li>
                            <li><a href="#"><i class="fa fa-envelope-o"></i> Validados <span
                                            class="label label-success pull-right">{{$cant_validados}}</span></a></li>
                            </a></li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Listado de Registros Pendientes</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="mailbox-controls">

                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped" id="registros">
                                <tbody>
                                @if(count($registros) > 0)
                                    @foreach($registros as $r)
                                        <tr>
                                            <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a>
                                            </td>
                                            <td class="mailbox-name">
                                                <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg"
                                                   onclick="info('{{$r->id}}', '{{$r->tipo_tramite_name}}', '{{$r->tipo_documento}}', '{{$r->numero_identificacion}}', '{{$r->naturaleza_juridica}}', '{{$r->razon_social}}', '{{$r->direccion_notificacion}}', '{{$r->actividad_economica_name}}', '{{$r->direccion_establecimiento}}', '{{$r->tipo_actividad_name}}', '{{$r->telefono}}', '{{$r->regimen}}', '{{URL::to($r->url_documento)}}', '{{URL::to($r->url_camaracomercio)}}', '{{URL::to($r->url_rut)}}')">
                                                    {{$r->razon_social}}
                                                </a>
                                            </td>
                                            <td class="mailbox-subject"><b></b> {{$r->actividad_economica_name}}
                                                - {{$r->tipo_tramite_name}}...
                                            </td>
                                            <td class="mailbox-attachment"></td>
                                            <td class="mailbox-date">{{$r->fecha_registro}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">No se encontraron registros pendientes</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <center>
                                {{ $registros->links() }}
                            </center>
                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer no-padding">

                    </div>
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Detalles del Registro</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Tipo Trámite</th>
                                    <td id="tipo_tramite"></td>
                                </tr>
                                <tr>
                                    <th>Tipo Documento</th>
                                    <td id="tipo_documento"></td>
                                </tr>
                                <tr>
                                    <th>Numero Identificacion</th>
                                    <td id="numero_identificacion"></td>
                                </tr>
                                <tr>
                                    <th>Naturaleza Jurídica</th>
                                    <td id="naturaleza_juridica"></td>
                                </tr>
                                <tr>
                                    <th>Razón Social</th>
                                    <td id="razon_social"></td>
                                </tr>
                                <tr>
                                    <th>Dirección de Notificación</th>
                                    <td id="direccion_notificacion"></td>
                                </tr>
                                <tr>
                                    <th>Actividad Económica</th>
                                    <td id="actividad_economica"></td>
                                </tr>
                                <tr>
                                    <th>Dirección Establecimiento</th>
                                    <td id="direccion_establecimiento"></td>
                                </tr>
                                <tr>
                                    <th>Tipo Actividad</th>
                                    <td id="tipo_actividad"></td>
                                </tr>
                                <tr>
                                    <th>Teléfono</th>
                                    <td id="telefono"></td>
                                </tr>
                                <tr>
                                    <th>Régimen</th>
                                    <td id="regimen"></td>
                                </tr>
                                <tr>
                                    <th>Copia del Documento</th>
                                    <td id="url_documento"></td>
                                </tr>
                                <tr>
                                    <th>Copia Cámara de Comercio</th>
                                    <td id="url_camaracomercio"></td>
                                </tr>
                                <tr>
                                    <th>Copia RUT</th>
                                    <td id="url_rut"></td>
                                </tr>
                            </table>
                        </div>
                        {!! Form::open(array('url' => 'indycom/validar_registro', 'method' => 'post', 'id' => 'formOsbRegi')) !!}
                        <div class="row-border">
                            <input type="hidden" value="" name="id" id="id">
                            <input type="hidden" value="" name="url" id="{{URL::to('/')}}">

                            <div class="form-group">
                                <label>Observación General</label>
                                <textarea name="obs_general" id="obs_general" class="form-control"
                                          required="true"></textarea>
                                <span style="color: red;" id="error_obs_general"></span>
                            </div>
                            <div class="form-group">
                                <label>Observación Adjunto Documento</label>
                                <textarea name="obs_documento" id="obs_documento" class="form-control"
                                          required="true"></textarea>
                                <span style="color: red;" id="error_obs_documento"></span>
                            </div>
                            <div class="form-group">
                                <label>Observación Adjunto Camara de Comercio</label>
                                <textarea name="obs_camaradecomercio" id="obs_camaradecomercio" class="form-control"
                                          required="true"></textarea>
                                <span style="color: red;" id="error_obs_camaradecomercio"></span>
                            </div>
                            <div class="form-group">
                                <label>Observación Adjunto RUT</label>
                                <textarea name="obs_rut" class="form-control"></textarea>
                                <span style="color: red;" id="error_obs_rut"></span>
                            </div>
                            <div class="form-group">
                                <label>Validacion</label>
                                <select class="form-control" name="validado" id="validado">
                                    <option value="x">- Seleccione una opción -</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Validado">Validado</option>
                                </select>
                                <span style="color: red;" id="error_chec"></span>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" onclick="validarObservaciones()">Validar</button>
                    </div>
                    {!! Form::close() !!}

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </section>
    <script src="{{URL::to('js/script_registros_admin.js')}}"></script>

@endsection()
