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
            <div class="col-md-12">
                {!! Form::open(array('url' => 'indycom/enviar', 'method' => 'post')) !!}
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Compose New Message</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <label>Para: </label>
                            <input class="form-control" placeholder="Para:" readonly value="{{$email}}">
                        </div>
                        <div class="form-group">
                            <label>Asunto: </label>
                            <input class="form-control" placeholder="Asunto:" name="asunto">
                        </div>
                        <div class="form-group">
                            <label>Mensaje: </label>
                            <textarea class="form-control" name="mensaje" style="height: 300px;" placeholder="Escriba aquí la información necesaria para el usuario, la demás información será anexada al envío del correo."></textarea>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="hidden" name="id" value="{{$id}}">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-envelope-o"></i> Enviar</button>
                        </div>
                        <button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</button>
                    </div>
                    <!-- /.box-footer -->
                </div>
                {!! Form::close() !!}
                <!-- /. box -->
            </div>
        </div>
    </section>
@endsection
