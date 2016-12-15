<?php
use Illuminate\Support\Facades\Crypt;

?>
@extends('template.template_admin_indycom')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-6">
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
                            <li><a href="{{URL::to('admin_indycom/registros')}}"><i
                                            class="fa fa-inbox"></i> Pendientes <span
                                            class="label label-primary pull-right">{{$cant_pendientes}}</span></a></li>
                            <li class="active"><a href="{{URL::to('indycom/registros/validados')}}"><i
                                            class="fa fa-check"></i>
                                    Validados <span
                                            class="label label-success pull-right">{{$cant_validados}}</span></a></li>
                            </a></li>
                            <li><a href="{{URL::to('indycom/registros/observciones')}}"><i class="fa fa-question-circle"></i> Observaciones <span
                                            class="label label-warning pull-right">{{$cant_observaciones}}</span></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>

            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Listado de Registros Validados</h3>
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
                                            <td class="mailbox-star"><a href="#"><i class="fa fa-star text-green"></i></a>
                                            </td>
                                            <td class="mailbox-name">
                                                {{$r->razon_social}}
                                            </td>
                                            <td class="mailbox-subject"><b></b> {{$r->actividad_economica_name}}
                                                - {{$r->tipo_tramite_name}}...
                                            </td>
                                            <td class="mailbox-attachment"></td>
                                            <td class="mailbox-date"><a href="{{URL::to('indycom/certificado/'.$r->id)}}"
                                                                        class="btn btn-danger" target="_blank"><i
                                                            class="fa fa-file-pdf-o"></i> PDF</a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">No se encontraron registros validados</td>
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
        </div>
    </section>
@endsection