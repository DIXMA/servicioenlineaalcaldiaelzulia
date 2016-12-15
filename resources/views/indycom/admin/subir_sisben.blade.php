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
                            <button type="button" class="btn btn-lg btn-success" id="boton" onclick="ejecutar('{{URL::to('img/cargando2.gif')}}')"><i class="fa fa-cloud-upload"></i>
                                Subir
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
    <script src="{{URL::to('js/script_sisben.js')}}"></script>
@endsection