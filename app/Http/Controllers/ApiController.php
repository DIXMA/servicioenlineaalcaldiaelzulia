<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Modelos\ActividadEconomica;
use App\Modelos\TipoActividadEconomica;
use \App\Modelos\RegistroIndycom;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\DB;
use App\Modelos\ObservacionRegistro;
use \App\Modelos\Sisben;
use Barryvdh\DomPDF\Facade as PDF;
use Mockery\CountValidator\Exception;

class ApiController extends Controller
{

    /****************************************************************************************************************
     * FUNCIONES SISBEN
     ****************************************************************************************************************/

    /**
     * Función que devuelve el resultado de la consulta en la base de datos del sisben
     * @param $ced Documento a consultar
     * @return mixed Información obtenida de la BD
     */
    function consultarSisben($ced)
    {
        $sisben = Sisben::where('numero_documento', '=', $ced)->first();
        return $sisben;
    }

    /**
     * Función que carga y convierte el pdf para la consulta del SISBEN
     * @param $id Número de documento consultado en la base de datos del SISBEN
     * @return mixed PDF
     */
    function sisbenPDF($id)
    {
        $sisben = Sisben::where('numero_documento', '=', $id)->first();
        $dia = date("d");
        $mes = date("m");
        $ano = date("Y");
        return PDF::loadView('pdf.certificado_sisben', array('user' => $sisben, 'dia' => $dia, 'mes' => $mes, 'ano' => $ano))->setPaper('a4', 'landscape')->stream('certificado.pdf');
    }

    /****************************************************************************************************************
     * FUNCIONES LOGIN
     ****************************************************************************************************************/

    /**
     * Función que realiza el proceso de inicio de sesión en la plataforma
     * @return \Illuminate\Http\RedirectResponse
     */
    function login()
    {
        $email = Input::get('email');
        $password = md5(Input::get('pass'));
        $user = User::where('email', '=', $email)->where('password', 'LIKE', $password)->first();
        if ($user) {
            Auth::login($user);
            if ($user->rol_id == 1) {
                return redirect('admin_indycom/registros')->with('mensaje', 'Se ha iniciado sesión.');
            } else if ($user->rol_id == 2) {
                return redirect('user_indycom/registro')->with('mensaje', 'Se ha iniciado sesión.');
            }
        }
        return redirect('admin_indycom')->with('error', "No coinciden los datos de acceso, por favor intentelo de nuevo.");
    }

    /**
     * Función que realiza el cierre de sesión en el sistema
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function logout()
    {
        if (Auth::check()) { //valido que el usuario este logueado
            Auth::logout();//cierro la sesión
        }
        return redirect('/');//redirecciona al inicio
    }


    /****************************************************************************************************************
     * FUNCIONES INDYCOM
     ****************************************************************************************************************/
    /**
     * Función que muestra el formulario para el registro en Cámara de Comercio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function verFomRegistroIndyCom()
    {
        $actividad = ActividadEconomica::all();
        $tipo_actividad = TipoActividadEconomica::all();
        return view('indycom.web.form_registro_indycom', ['actividades' => $actividad, 'tipo_actividades' => $tipo_actividad]);
    }

    /**
     * Función que guarda la información de un nuevo registro en Cámara de Comercio
     * @return \Illuminate\Http\RedirectResponse
     */
    function guardarRegistroIndycom()
    {
        $tipotramite = Input::get('tipotramite');
        $tipodocumento = Input::get('tipodocumento');
        $fecha = Input::get('fecha');
        $naturalezajuridica = Input::get('naturalezajuridica');
        $numero = Input::get('numero');
        $nombres = Input::get('nombres');
        $nombre_comercial = Input::get('nombre_comercial');
        $direccion = Input::get('direccion');
        $actividadeconomica = explode('_', Input::get('actividadeconomica'))[1];
        $direccionestablecimiento = Input::get('direccionestablecimiento');
        $tipoactividad = Input::get('tipoactividadeconomica');
        $telefono = Input::get('telefono');
        $regimen = Input::get('regimen');
        $matricula = Input::get('matricula');
        $fecha_matricula = Input::get('fecha_matricula');
        $camaracomercio = Input::file('camaracomercio');
        $cedula = Input::file('cedula');
        $rut = Input::file('rut');
        $banco = Input::file('banco');
        $email = Input::get('email');
        $registro = RegistroIndycom::where('numero_identificacion', '=', $numero)->first();
        if (!$registro) {
            if ($tipotramite && $tipodocumento && $fecha && $naturalezajuridica && $numero && $nombres && $direccion && $actividadeconomica && $direccionestablecimiento && $tipoactividad && $telefono && $regimen && $matricula && $fecha_matricula && $camaracomercio && $cedula && $rut && $banco && $email && $nombre_comercial) {
                $registro = new RegistroIndycom();
                $registro->estado = 'Pendiente';
                $registro->email = $email;
                $registro->tipo_tramite = $tipotramite;
                $registro->fecha = $fecha;
                $registro->tipo_documento = $tipodocumento;
                $registro->numero_identificacion = $numero;
                $registro->naturaleza_juridica = $naturalezajuridica;
                $registro->razon_social = $nombres;
                $registro->nombre_comercial = $nombre_comercial;
                $registro->direccion_notificacion = $direccion;
                $registro->actividad_economica = $actividadeconomica;
                $registro->direccion_establecimiento = $direccionestablecimiento;
                $registro->tipo_actividad = $tipoactividad;
                $registro->telefono = $telefono;
                $registro->regimen = $regimen;
                $registro->matricula = $matricula;
                $registro->fecha_matricula = $fecha_matricula;
                $registro->save();
                $registro->url_documento = $this->subir_archivo($cedula, $registro->id, 'documento');
                $registro->url_camaracomercio = $this->subir_archivo($camaracomercio, $registro->id, 'camaracomercio');
                $registro->url_rut = $this->subir_archivo($rut, $registro->id, 'rut');
                $registro->url_banco = $this->subir_archivo($banco, $registro->id, 'banco');
                $registro->save();
                $this->enviarMail(
                    'Pre Registro Industria y Comercio',
                    'Se ha realizado el regsitro existoamente, los datos serán validados y se notificara por este medio del resultado del proceso.',
                    $email
                );
                return redirect()->back()->with('mensaje', "El pre - registro se ha realizado exitosamente, se ha enviado un email de verificación del hecho a {$email}. \n Ahora entra en un proceso de validación de información, se comunicará el resultado por correo electrónico.");
            }
        } else {
            return redirect()->back()->with('error', "Ya se ha realizado con el npumero de identificación: $numero");
        }
        return redirect()->back()->with('error', 'no se ha registrado');
    }

    /**
     * Función que muestra los registros pendientes por validar en el sistema
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    function registrosPendientes()
    {
        if (Auth::check()) {
            $registros = DB::table('indycom_registro')
                ->join('indycom_tipotramite', 'indycom_tipotramite.id', '=', 'indycom_registro.tipo_tramite')
                ->join('indycom_actividadeconomica', 'indycom_actividadeconomica.id', '=', 'indycom_registro.actividad_economica')
                ->join('indycom_tipoactividadeconomica', 'indycom_tipoactividadeconomica.id', '=', 'indycom_registro.tipo_actividad')
                ->where('indycom_registro.estado', 'LIKE', 'Pendiente')
                ->select(
                    'indycom_registro.id', 'indycom_registro.estado', 'indycom_registro.tipo_tramite as tipo_tramite_id', 'indycom_tipotramite.name as tipo_tramite_name', 'indycom_registro.fecha as fecha_registro', 'indycom_registro.tipo_documento', 'indycom_registro.numero_identificacion', 'indycom_registro.naturaleza_juridica', 'indycom_registro.razon_social', 'indycom_registro.direccion_notificacion', 'indycom_registro.actividad_economica as actividad_economica_id', 'indycom_actividadeconomica.name as actividad_economica_name', 'indycom_registro.direccion_establecimiento', 'indycom_registro.tipo_actividad as tipo_actividad_id', 'indycom_tipoactividadeconomica.name as tipo_actividad_name', 'indycom_registro.telefono', 'indycom_registro.regimen', 'indycom_registro.url_documento', 'indycom_registro.url_camaracomercio', 'indycom_registro.url_rut'
                )
                ->paginate(8);
            $cant_regP = count(RegistroIndycom::where('estado', 'LIKE', 'Pendiente')->get());
            $cant_regV = count(RegistroIndycom::where('estado', 'LIKE', 'Validado')->get());
            $cant_regO = count(RegistroIndycom::where('estado', 'LIKE', 'Observaciones')->get());
            return view('indycom.admin.registrospendientes', ['registros' => $registros, 'cant_pendientes' => $cant_regP, 'cant_validados' => $cant_regV, 'cant_observaciones' => $cant_regO]);
        }
        return redirect('/')->with('error', 'Debe estar autenticado para acceder a está página.');
    }

    /**
     * Función que valida un registro de industria y comercio, con el estado Pendiente o Validado
     * @return \Illuminate\Http\RedirectResponse
     */
    function validarRegistro()
    {
        $id = Input::get('id');
        $obs_general = Input::get('obs_general');
        $obs_documento = Input::get('obs_documento');
        $obs_camaradecomercio = Input::get('obs_camaradecomercio');
        $obs_rut = Input::get('obs_rut');
        $obs_banco = Input::get('obs_banco');
        $estado = Input::get('validado');
        $url = Input::get('url');

        $observacionregistro = new ObservacionRegistro();
        $observacionregistro->observacion_general = $obs_general;
        $observacionregistro->observacion_cedula = $obs_documento;
        $observacionregistro->observacion_rut = $obs_rut;
        $observacionregistro->observacion_camaracomercio = $obs_camaradecomercio;
        $observacionregistro->observacion_banco = $obs_banco;
        $observacionregistro->estado = $estado;
        $observacionregistro->registro_id = $id;

        $observacionregistro->save();
        $id_c = encrypt($id);

        $registro = RegistroIndycom::findOrFail($id);
        $registro->estado = $estado;
        $registro->save();
        if ($estado == "Validado") {
            return redirect("indycom/send_mail/{$id_c}")->with("mensaje", "Se ha validado el registro como {$estado}, hora envíale la respuesta al usuario.");
        } else {
            $this->enviarMail("Observaciones Registro Industria y Comercio",
                $this->getMensajeHTMLvalidacionPendienteIndyCom(
                    'Resultado del Proceso de Verificación',
                    "Hemos encontrado unas inconsistencias generales al registro realizado en Industria y Comercio, a continuaión indicamos la sobservaciones para que sean subsanadas",
                    $obs_general,
                    $obs_documento,
                    $obs_camaradecomercio,
                    $obs_rut,
                    $obs_banco, $url, $id_c),
                $registro->email
            );
        }
        return redirect()->back()->with("mensaje", "Se ha validado el registro como {$estado}, se ha enviado por email, las observaciones generadas, para que el usuario las subsane.");
    }

    /**
     * Función que muestra los datos del registro para agregar la placa y enviar por email
     * @param $id Identificador del registro
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    function mailValidacion($id)
    {
        $id2 = decrypt($id);
        $registro = RegistroIndycom::findOrFail($id2);
        $actividad = ActividadEconomica::findOrFail($registro->tipo_actividad);
        $tipo_actividad = TipoActividadEconomica::findOrFail($actividad->tipo_actividad);
        if ($registro) {
            return view('indycom.admin.send_mail', ['id' => $id, 'registro' => $registro, 'actividad' => $actividad, 'tipo_act' => $tipo_actividad]);
        }
        return redirect()->back()->with('error', "No se reconoce la información, por favor intentelo de nuevo.");
    }

    /**
     * Funcion que guarada la informacion de la placa del registro validado, y notifica por correo al usuario del hecho, indicandole la url de descarga del certificado
     * @return string
     */
    function enviarValidacion()
    {
        $id = Input::get('id');
        $url = Input::get('url');
        $placa = Input::get('placa');
        if ($id && $url && $placa) {
            $registro = RegistroIndycom::findOrFail($id);
            $registro->placa = $placa;
            $registro->save();
            $this->enviarMail(
                'Certificado Inscripción Camara de Comercio',
                $this->getMensajeValidacionPlaca('Certificado Inscripción Camara de Comercio', $url, $id),
                $registro->email
            );
            return json_encode(array('estado' => 'ok', 'mensaje' => 'Se ha almacenado la información y se ha notificado por correo al usuario.'));
        } else {
            return json_encode(array('estado' => 'fail', 'mensaje' => 'Ha ocurrido un error interno, verifique e intentelo de nuevo.'));
        }
    }

    /**
     * Función que muestra los registros validados.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    function registrosValidados()
    {
        if (Auth::check()) {
            $registros = DB::table('indycom_registro')
                ->join('indycom_tipotramite', 'indycom_tipotramite.id', '=', 'indycom_registro.tipo_tramite')
                ->join('indycom_actividadeconomica', 'indycom_actividadeconomica.id', '=', 'indycom_registro.actividad_economica')
                ->join('indycom_tipoactividadeconomica', 'indycom_tipoactividadeconomica.id', '=', 'indycom_registro.tipo_actividad')
                ->where('indycom_registro.estado', 'LIKE', 'Validado')
                ->select(
                    'indycom_registro.id', 'indycom_registro.estado', 'indycom_registro.tipo_tramite as tipo_tramite_id', 'indycom_tipotramite.name as tipo_tramite_name', 'indycom_registro.fecha as fecha_registro', 'indycom_registro.tipo_documento', 'indycom_registro.numero_identificacion', 'indycom_registro.naturaleza_juridica', 'indycom_registro.razon_social', 'indycom_registro.direccion_notificacion', 'indycom_registro.actividad_economica as actividad_economica_id', 'indycom_actividadeconomica.name as actividad_economica_name', 'indycom_registro.direccion_establecimiento', 'indycom_registro.tipo_actividad as tipo_actividad_id', 'indycom_tipoactividadeconomica.name as tipo_actividad_name', 'indycom_registro.telefono', 'indycom_registro.regimen', 'indycom_registro.url_documento', 'indycom_registro.url_camaracomercio', 'indycom_registro.url_rut'
                )
                ->paginate(8);
            $cant_regP = count(RegistroIndycom::where('estado', 'LIKE', 'Pendiente')->get());
            $cant_regV = count(RegistroIndycom::where('estado', 'LIKE', 'Validado')->get());
            $cant_regO = count(RegistroIndycom::where('estado', 'LIKE', 'Observaciones')->get());
            return view('indycom.admin.registrosvalidados', ['registros' => $registros, 'cant_pendientes' => $cant_regP, 'cant_validados' => $cant_regV, 'cant_observaciones' => $cant_regO]);
        }
        return redirect('/')->with('error', 'Debe estar autenticado para acceder a está página.');
    }

    /**
     * Función que muestra en pdf los datos de registro de industria y comercio
     * @param $id Identificador de registro en industria y comercio
     * @return \Illuminate\Http\RedirectResponse
     */
    function indycomPDF($id)
    {
        $registro = RegistroIndycom::findOrFail($id);
        if ($registro) {
            $actividad = ActividadEconomica::findOrFail($registro->tipo_actividad);
            $tipo_actividad = TipoActividadEconomica::findOrFail($actividad->tipo_actividad);
            $dia = date("d");
            $mes = date("m");
            $ano = date("Y");
            return PDF::loadView(
                'pdf.certificado_inycom',
                array(
                    'registro' => $registro,
                    'dia' => $dia,
                    'mes' => $mes,
                    'ano' => $ano,
                    'actividad' => $actividad,
                    'tipo_act' => $tipo_actividad
                ))->setPaper('a4', '')->stream('certificado.pdf');
        }
        return redirect('/')->with('error', 'No se reconoce la informacion, verifique e intentelo de nuevo.');
    }

    /**
     * Función que muestra los registros que tienen observaciones en el sistema
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    function registrosObservaciones()
    {
        if (Auth::check()) {
            $registros = DB::table('indycom_registro')
                ->join('indycom_tipotramite', 'indycom_tipotramite.id', '=', 'indycom_registro.tipo_tramite')
                ->join('indycom_actividadeconomica', 'indycom_actividadeconomica.id', '=', 'indycom_registro.actividad_economica')
                ->join('indycom_tipoactividadeconomica', 'indycom_tipoactividadeconomica.id', '=', 'indycom_registro.tipo_actividad')
                ->where('indycom_registro.estado', 'LIKE', 'Observaciones')
                ->select(
                    'indycom_registro.id', 'indycom_registro.estado', 'indycom_registro.tipo_tramite as tipo_tramite_id', 'indycom_tipotramite.name as tipo_tramite_name', 'indycom_registro.fecha as fecha_registro', 'indycom_registro.tipo_documento', 'indycom_registro.numero_identificacion', 'indycom_registro.naturaleza_juridica', 'indycom_registro.razon_social', 'indycom_registro.direccion_notificacion', 'indycom_registro.actividad_economica as actividad_economica_id', 'indycom_actividadeconomica.name as actividad_economica_name', 'indycom_registro.direccion_establecimiento', 'indycom_registro.tipo_actividad as tipo_actividad_id', 'indycom_tipoactividadeconomica.name as tipo_actividad_name', 'indycom_registro.telefono', 'indycom_registro.regimen', 'indycom_registro.url_documento', 'indycom_registro.url_camaracomercio', 'indycom_registro.url_rut'
                )
                ->paginate(8);
            $cant_regP = count(RegistroIndycom::where('estado', 'LIKE', 'Pendiente')->get());
            $cant_regV = count(RegistroIndycom::where('estado', 'LIKE', 'Validado')->get());
            $cant_regO = count(RegistroIndycom::where('estado', 'LIKE', 'Observaciones')->get());
            return view('indycom.admin.registrosobservaciones', ['registros' => $registros, 'cant_pendientes' => $cant_regP, 'cant_validados' => $cant_regV, 'cant_observaciones' => $cant_regO]);
        }
        return redirect('/')->with('error', 'Debe estar autenticado para acceder a está página.');
    }

    /**
     * Función que muestra el formulario para editar la información de un registro en indycom
     * @param $id Identificador del registro
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    function editarRegistroIndycom($id)
    {
        $registro = RegistroIndycom::findOrFail($id);
        if ($registro) {
            $actividad = ActividadEconomica::findOrFail($registro->tipo_actividad);
            $tipo_actividad = TipoActividadEconomica::findOrFail($actividad->tipo_actividad);
            return view('indycom.web.editar_form_inscripcion', ['registro' => $registro, 'actividad' => $actividad, 'tipo_act' => $tipo_actividad]);
        }
        return redirect('/')->with('error', 'No se encuentra la ifnromación necesaria para realizar el proceso, por favor verifique e intentelo de nuevo.');
    }

    /**
     * Funcion que edita la inforacion de los archivos de un registro indycom
     * @return \Illuminate\Http\RedirectResponse
     */
    function editarIndycom()
    {
        $id = Input::get('id');
        $registro = RegistroIndycom::findOrFail($id);
        if ($registro) {
            $cambios = 0;
            $ccm = Input::file('camaracomercio');
            if ($ccm) {
                $registro->url_camaracomercio = $this->subir_archivo($ccm, $id, 'camaracomercio');
                $cambios++;
            }
            $doc = Input::file('cedula');
            if ($doc) {
                $registro->url_documento = $this->subir_archivo($doc, $id, 'documento');
                $cambios++;
            }
            $rut = Input::file('rut');
            if ($rut) {
                $registro->url_rut = $this->subir_archivo($rut, $id, 'rut');
                $cambios++;
            }
            $banco = Input::file('banco');
            if ($banco) {
                $registro->url_banco = $this->subir_archivo($banco, $registro->id, 'banco');
                $cambios++;
            }

            if ($cambios > 0) {
                $registro->estado = 'Pendiente';
                $registro->save();
                $this->enviarMail(
                    'Se han realizado los cambios',
                    'Gracias por estar al tanto del proceso, los cambos han sido guardados y se procederá a verificar, se notificará por este medio cuando el proceso culmine.',
                    $registro->email
                );
                return redirect('/')->with('mensaje', "Se han realizado los cambios en el registro, agradecemos la paciencia, ahora iniciamos nuevamente el proceso de verifiación de la información. Una ve terminado el proceso se notificará por correo electrónico el resultado del proceso.");
            } else {
                return redirect()->back()->with('error', "No se ha realizado ningún cambio, por favor verifique bien el correo, y realice los cambios indicados en las observaciones al registro.");
            }
        }
        return redirect('/')->with('error', 'No se ha encontrado la información necesaria para ejecutar la acción, por favor verifique e intentelo de nuevo.');
    }

    /**
     * Función que muestra el formulario para subir el archivo csv para actualizar en la base de datos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    function actualizarSisben()
    {
        if (Auth::check()) {
            return view('indycom.admin.subir_sisben');
        }
        return redirect('/')->with('error', 'No tiene permisos para acceder a esta acción.');
    }

    function subirSisben()
    {
        ini_set('max_execution_time', 3000); //300 seconds = 5 minutes
        try {
            if (Auth::check()) {

                //obtenemos el archivo .csv
                //$tipo = $_FILES['archivo']['type'];

                //$tamanio = $_FILES['archivo']['size'];

                $archivotmp = $_FILES['archivo']['tmp_name'];

                //cargamos el archivo
                $lineas = file($archivotmp);

                //inicializamos variable a 0, esto nos ayudará a indicarle que no lea la primera línea
                $i = 0;
                $j = 0;

                //Recorremos el bucle para leer línea por línea
                foreach ($lineas as $linea_num => $linea) {
                    //abrimos bucle
                    /*si es diferente a 0 significa que no se encuentra en la primera línea
                    (con los títulos de las columnas) y por lo tanto puede leerla*/
                    if ($i != 0) {
                        //abrimos condición, solo entrará en la condición a partir de la segunda pasada del bucle.
                        /* La funcion explode nos ayuda a delimitar los campos, por lo tanto irá
                        leyendo hasta que encuentre un ; */
                        $datos = explode(";", $linea);

                        //Almacenamos los datos que vamos leyendo en una variable
                        $ficha = trim($datos[0]);
                        $hogar = trim($datos[1]);
                        $apellidos1 = trim($datos[2]);
                        $apellidos2 = trim($datos[3]);
                        $nombre1 = trim($datos[4]);
                        $nombre2 = trim($datos[5]);
                        $genero = trim($datos[6]);
                        $tipo_documento = trim($datos[7]);
                        $numero_documento = trim($datos[8]);
                        $puntaje = trim($datos[9]);

                        $sisben = $this->sisbenByDoc($numero_documento);
                        if (!$sisben) {
                            $new_sisben = new Sisben();
                            $new_sisben->ficha = $ficha;
                            $new_sisben->hogar = $hogar;
                            $new_sisben->apellidos1 = $apellidos1;
                            $new_sisben->apellidos2 = $apellidos2;
                            $new_sisben->nombre1 = $nombre1;
                            $new_sisben->nombre2 = $nombre2;
                            $new_sisben->genero = $genero;
                            $new_sisben->tipo_documento = $tipo_documento;
                            $new_sisben->numero_documento = $numero_documento;
                            $new_sisben->puntaje = $puntaje;
                            $new_sisben->save();
                            $j++;
                        }

                        //guardamos en base de datos la línea leida

                        //cerramos condición
                    }

                    /*Cuando pase la primera pasada se incrementará nuestro valor y a la siguiente pasada ya
                    entraremos en la condición, de esta manera conseguimos que no lea la primera línea.*/
                    $i++;
                    //cerramos bucle
                }
                return redirect()->back()->with('mensaje', "Se han actualizado {$j} registros de  {$i} leidos en la Base de datos del Sisben, por favor verifique con el archivo si es consecuente, de lo contrario vuelva a cargarlo.");

            }
        } catch (Exception $e) {
            return redirect()->back()->with('mensaje', "Ha pasado mucho tiempo, tuvimos que detener el proceso para no ocasionar daños severos en el servidor, ahora llevamos leidos {$i} registros y almacenasdos {$j}, por favor verifique si hacen falta, de ser así, vualva a cargar el archivo.");
        }
        return redirect('/')->with('error', 'No tiene permisos para realizar esta acción.');
    }

    /****************************************************************************************************************
     * FUNCIONES PROTEGIDAS - PRIVADAS
     ****************************************************************************************************************/

    /**
     * Función que realiza la subida de un archivo en el servidor
     * @param $archivo Archivo tomado del formulario
     * @param $id Identificador del objeto con que se relaciona el archivo subido
     * @param $tipo Tipo de archivo que se sube - nombre
     * @return string Ruta donde se almacena el archivo.
     */
    protected
    function subir_archivo($archivo, $id, $tipo)
    {
        $nombre = $archivo->getClientOriginalName();
        $extension = explode('.', $nombre);
        $ruta_disco = public_path() . '/archivos/' . $id;
        $archivo->move($ruta_disco, "{$tipo}_{$id}.{$extension[1]}");
        //error_log("NOMBRE . . - - - " . $ruta_disco . $nombre);
        $ruta = "archivos/$id/{$tipo}_{$id}.{$extension[1]}";
        return $ruta;
    }

    /**
     * Función que obtiene el html para enviar el email qde informe de registro de indutria y comercio
     * @param $titulo Titulo del email
     * @param $contenido Contenido del email
     * @return string Html completo para el email enviado
     */
    protected
    function getMensajeHTMLregistroIndyCom($titulo, $contenido)
    {
        $msj = "<h1> $titulo </h1><br/>";
        $msj .= "<h3 style='text-aling: justify;'>$contenido</h3>";
        $msj .= "<h3>Nota:</h3>";
        $msj .= "<h5>Este correo es enviado a través de los servicios en línea de la Alcaldía de el Zulia.</h5>";
        $msj .= "<h5>Por favor, no responder este correo.</h5>";
        return $msj;
    }

    /**
     * Función que devuelve el html del contenido de mensaje de notificacion para una validacion de inscripcion como pendiente
     * @param $titulo Titulo del mensaje
     * @param $contenido Contenido del mensaje
     * @param $obsG Observaciones generales obtenidas
     * @param $obsD Observaciones del adjunto Documento de Identidad
     * @param $obsCm Observaciones del adjunto camara de comercio
     * @param $obsR Observaciones del adjunto rut
     * @param $obsB Observaciones del adjunto pago en el banco
     * @param $url Url del dominio para crear el link de descarga del certificado
     * @param $id Identificador encriptado del registro
     * @return string
     */
    protected
    function getMensajeHTMLvalidacionPendienteIndyCom($titulo, $contenido, $obsG, $obsD, $obsCm, $obsR, $obsB, $url, $id)
    {
        $msj = "<h3 style='text-aling: justify;'>$contenido</h3>";
        $msj .= "<h2>Observaciones Generales: </h2><p>$obsG</p>";
        $msj .= "<h2>Observaciones del Adjunto de Documento de Identidadc: </h2><p>$obsD</p>";
        $msj .= "<h2>Observaciones del Adjunto Cámara de Comercio: </h2><p>$obsCm</p>";
        $msj .= "<h2>Observaciones del Adjunto RUT: </h2><p>$obsR</p>";
        $msj .= "<h2>Observaciones del Adjunto Pago en Banco: </h2><p>$obsB</p><br/>";
        $msj .= '<b>Para realizar el proceso de correcciónes, puede acceder haciendo</b> <a href="' . $url . '/indycom/editar/' . decrypt($id) . '" target="_blank">clic aquí.</a>';
        $msj .= "<br/>";
        return $msj;
    }

    /**
     * Función que devuelve en HTML la estructura del contenido del correo que se envia al usuario informando el certificado del proceso
     * @param $titulo Título del email
     * @param $url Url del dominio para crear el link de descarga del certificado
     * @param $id Identificador del registro
     * @return string
     */
    protected
    function getMensajeValidacionPlaca($titulo, $url, $id)
    {
        $msj = "<h3 style='text-aling: justify;'>Se ha validado el registro hecho en Industria y comercio, a continuación puede descargar el certificado.</h3>";
        $msj .= 'Para descargar el certificado, puede hacerlo dando <a href="' . $url . '/indycom/certificado/' . $id . ' target="_blank">clic aquí.</a>';
        $msj .= "<br/>";
        $msj .= "<h3>Nota:</h3>";
        $msj .= "<h5>Este correo es enviado a través de los servicios en línea de la Alcaldía de el Zulia.</h5>";
        $msj .= "<h5>Por favor, no responder este correo.</h5>";
        return $msj;
    }

    /**
     * Función que envía un email
     * @param $titulo Título del email
     * @param $contenido Contenido del email
     * @param $email Correo al que se envía
     * @return string Ok
     * @throws \phpmailerException Excepciones que se capturan al no poder enviar el correo
     */
    protected
    function enviarMail($titulo, $contenido, $email)
    {
        $mail = new \PHPMailer(true); // notice the \  you have to use root namespace here
        try {
            $mail->isSMTP(); // tell to use smtp
            $mail->CharSet = "utf-8"; // set charset to utf8
            $mail->SMTPAuth = true;  // use smpt auth
            $mail->SMTPSecure = "tls"; // or ssl
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587; // most likely something different for you. This is the mailtrap.io port i use for testing.
            $mail->Username = "contacto.alcaldielzuliands@gmail.com";
            $mail->Password = "alcaldielzuliands";
            $mail->setFrom("contacto.alcaldielzuliands@gmail.com", "Alcaldia el Zulia");
            $mail->Subject = $titulo;
            $mail->MsgHTML($this->getMensajeHTMLregistroIndyCom($titulo, $contenido));
            $mail->addAddress($email, "");
            $mail->send();
        } catch (phpmailerException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }
        return 'ok';
    }

    protected function sisbenByDoc($doc)
    {
        return Sisben::where('numero_documento', '=', $doc)->first();
    }


}
