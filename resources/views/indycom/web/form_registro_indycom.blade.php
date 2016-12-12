@extends("template.template_web")

@section('content')
<div class="col-md-12">
    {!! Form::open(array('url' => 'indycom/guardar_registro', 'method' => 'post', 'files' => 'yes', 'id' => 'formIndyCom')) !!}
    <div class="box">
        <div class="box-header with-border" style="text-align: center;">
            <h2>MUNICIPIO DE EL ZULIA</h2>
            <p>Secretaría de Hacienda</p>
            <p>Formulario de Registro de Información Tributaria</p>
            <p>Impuesto de Industria y Comercio</p>
        </div>
        <hr />
        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipotrammite">* Tipo de Trámite: </label>
                    <select class="form-control" name="tipotramite" id="tipotramite" required="true">
                        <option value="1">Inscripción</option>
                    </select> 
                </div>
                <div class="form-group">
                    <label for="tipodocumento">* Tipo Documento: </label>
                    <select class="form-control" name="tipodocumento" id="tipodocumento" required="true">
                        <option value="x">- Seleccione una opción -</option>
                        <option value="Cédula de Ciudadanía">Cédula de Ciudadanía</option>
                        <option value="Número de Identificación">Número de Identificación</option>
                    </select>
                    <span style="color: red;" id="errortipodocumento"></span>
                </div>                       
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fecha">* Fecha de inicio, novedad o cese:</label>
                    <input type="date" name="fecha" id="fecha" required="true" class="form-control"> 
                    <span style="color: red;" id="errorfecha"></span>
                </div>
                <div class="form-group">
                    <label for="naturalezajuridica">* Naturaleza Jurídica: </label>
                    <select class="form-control" name="naturalezajuridica" id="naturalezajuridica" required="true">
                        <option value="Persona Natural">Persona Natural</option>
                        <option value="Persona Jurídica">Persona Jurídica</option>
                        <option value="Sociedad de hecho">Sociedad de hecho</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="numero">* Número:</label>
                    <input type="text" name="numero" id="numero" class="form-control" placeholder="Documento o Identificación" required="true" min="100000"> 
                    <span style="color: red;" id="errornumero"></span>
                </div> 
                <div class="form-group">
                    <label for="nombres">* Apellidos y Nombres o Razón Social: </label>
                    <input type="text" class="form-control" name="nombres" id="nombres" required="true" placeholder="Apellidos y Nombres o Razón Social">
                    <span style="color: red;" id="errornombres"></span>
                </div>
                <div class="form-group">
                    <label for="direccion">* Dirección de Notificación: </label>
                    <input type="text" class="form-control" name="direccion" id="direccion" required="true" placeholder="Apellidos y Nombres o Razón Social">
                    <span style="color: red;" id="errordireccion"></span>
                </div>
                <div class="form-group">
                    <label for="actividadeconomica">* Actividad económica del contribuyente: </label>
                    @if(count($actividades) > 0)
                    <select class="form-control" name="actividadeconomica" id="actividadeconomica" required="true" onchange="cambioTipoActividad()">
                        <option value="x_x">- Seleccione una Opción -</option>
                        @foreach($actividades as $act)
                        <option value="{{$act->id}}_{{$act->tipo_actividad}}">{{$act->codigo}} - {{$act->name}}</option>
                        @endforeach
                    </select>
                    @endif
                    <span style="color: red;" id="erroractividadeconomica"></span>
                </div>
                <div class="form-group">
                    <label for="direccionestablecimiento">* Dirección de establecimiento de comercio ubicado en el municipio: </label>
                    <input type="text" class="form-control" name="direccionestablecimiento" id="direccionestablecimiento" required="true" placeholder="Dirección de establecimiento de comercio ubicado en el municipio">
                    <span style="color: red;" id="errordireccionestablecimiento"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipoactividad">Tipo de Actividad: </label>                        
                    <select name="tipoactividadeconomica" id="tipoactividad" class="form-control">
                        <option value="x">- No Seleccionado -</option>
                        @foreach($tipo_actividades as $tpc)
                        <option value="{{$tpc->id}}">{{$tpc->name}}</option>
                        @endforeach
                    </select>
                    <span style="color: red;" id="errortipoactividad"></span>
                </div>                    
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telefono">* Número de Teléfono: </label>
                    <input type="tel" class="form-control" name="telefono" id="telefono" placeholder="Número de Teléfono">
                    <span style="color: red;" id="errortelefono"></span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="regimen">* Regimen al que pertenece: </label>
                    <select class="form-control" name="regimen" id="regimen" required="true">
                        <option value="Común">Común</option>
                        <option value="Simplificado">Simplificado</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">* Fotocopia de la Cámara de Comercio: </label>
                    <input type="file" class="form-control" name="camaracomercio" id="camaracomercio" accept=".pdf" onchange="validarExtension('camaracomercio', 'errorcarmaracomercio')">
                    <span style="color: red;" id="errorcarmaracomercio"></span>
                    <span style="color: red;" id="errorcarmaracomercio2"></span>
                </div>
                <div class="form-group">
                    <label for="">* Fotocopia de la Cédula: </label>
                    <input type="file" class="form-control" name="cedula" id="cedula" accept=".pdf" onchange="validarExtension('cedula', 'errorcedula')">
                    <span style="color: red;" id="errorcedula"></span>
                    <span style="color: red;" id="errorcedula2"></span>
                </div>
                <div class="form-group">
                    <label for="">* Fotocopia del Rut: </label>
                    <input type="file" class="form-control" name="rut" id="rut" accept=".pdf" onchange="validarExtension('rut', 'errorrut')">
                    <span style="color: red;" id="errorrut"></span>
                    <span style="color: red;" id="errorrut2"></span>
                </div>
                <div class="form-group">
                    <label for="email">* Correo de contacto:</label>
                    <input type="email" name="email" id="emal" placeholder="Correo de Contacto" required="true" class="form-control">
                    <span style="color: red;" id="erroremail"></span>
                </div>
            </div>                
            <div class="box-footer clearfix no-border">
                <button type="button" class="btn btn-success pull-right" onclick="enviarForm('{{URL::to("/")}}')"><i class="fa fa-send"></i> Enviar</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

</div>
<script src="{{URL::to('js/script_form_indycom.js')}}"></script>
@endsection