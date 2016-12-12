@extends("template.template_web")

@section('content')
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h2>Inicia Sesión</h2>
            <p>Administración Registros de Industria y Comercio</p>
        </div>
    </div>
    <hr />
    <div class="row">  
        {!! Form::open(array('url' => 'admin_indycom/login', 'method' => 'post')) !!}
        <div class="col-md-offset-4 col-md-4 col-sm-4">
            <div class="form-group">
                <label for="username"><i class="fa fa-users"></i> Email *</label>
                <input type="email" value="" name="email" required="true" class="form-control" placeholder="Email del Usuario">
            </div>
            <div class="form-group">
                <label for="pass"><i class="fa fa-unlock-alt"></i> Contraseña *</label>
                <input type="password" value="" name="pass" required="true" class="form-control" placeholder="Digite la contraseña">
            </div>
            <div class="form-group">
                <button class="btn btn-info" value="Iniciar"><i class="fa fa-info"></i> Iniciar</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
