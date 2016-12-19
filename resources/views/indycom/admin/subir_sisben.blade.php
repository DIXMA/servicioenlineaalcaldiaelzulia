@extends('template.template_admin_indycom')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Actualizar la Base de Datos del Sisben</h3>
                    </div>
                    {!! Form::open(array('url' => 'sisben/subir', 'method' => 'post', 'files' => 'yes', 'id' => 'formSisbenAct')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="sisben">* Seleccione un archivo en formato <b>.csv</b></label>
                            <input type="file" name="archivo" id="archivo" class="form-control" accept=".csv"
                                   onchange="validarExtension('archivo', 'sisben_error')" required>
                            <span style="color: red;" id="sisben_error"></span>
                        </div>
                        <div class="form-group" id="campos">
                            <button type="button" class="btn btn-lg btn-success" id="boton" data-toggle="modal"
                                    data-target="#myModal" onclick="ejecutar('{{URL::to('img/cargando2.gif')}}')"><i
                                        class="fa fa-cloud-upload"></i>
                                Subir
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-spinner"></i> Cargando Datos</h4>
                </div>
                <div class="modal-body">
                    <h3>Los datos se estan cargando</h3>
                    <p>
                        Este proceso puede tardar varios minutos, por favor espere pacientemente a que la totalidad de
                        los registros cargados en el archivo sean leídos y verificados, una vez finalizado el sistema le
                        notificará del hecho.
                    </p>
                    <center><img class="{{URL::to('img/cargando.gif')}}"></center>
                    <p>
                        Por favor no actualice la página, ni ejecute otra acción hasta que este proceso termine.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{URL::to('js/script_sisben.js')}}"></script>
@endsection