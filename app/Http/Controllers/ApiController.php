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
        $direccion = Input::get('direccion');
        $actividadeconomica = explode('_', Input::get('actividadeconomica'))[1];
        $direccionestablecimiento = Input::get('direccionestablecimiento');
        $tipoactividad = Input::get('tipoactividadeconomica');
        $telefono = Input::get('telefono');
        $regimen = Input::get('regimen');

        $camaracomercio = Input::file('camaracomercio');
        $cedula = Input::file('cedula');
        $rut = Input::file('rut');
        $banco = Input::file('banco');
        $email = Input::get('email');
        $registro = RegistroIndycom::where('numero_identificacion', '=', $numero)->first();
        if (!$registro) {
            if ($tipotramite && $tipodocumento && $fecha && $naturalezajuridica && $numero && $nombres && $direccion && $actividadeconomica && $direccionestablecimiento && $tipoactividad && $telefono && $regimen && $camaracomercio && $cedula && $rut && $banco && $email) {
                /*$user = new User();
                $user->name = $nombres;
                $user->email = $email;
                $user->password = md5($numero);
                $user->estado = 1;
                $user->rol_id = 2;
                $user->remember_token = '';
                $user->save();*/
                $registro = new RegistroIndycom();
                $registro->estado = 'Pendiente';
                $registro->email = $email;
                $registro->tipo_tramite = $tipotramite;
                $registro->fecha = $fecha;
                $registro->tipo_documento = $tipodocumento;
                $registro->numero_identificacion = $numero;
                $registro->naturaleza_juridica = $naturalezajuridica;
                $registro->razon_social = $nombres;
                $registro->direccion_notificacion = $direccion;
                $registro->actividad_economica = $actividadeconomica;
                $registro->direccion_establecimiento = $direccionestablecimiento;
                $registro->tipo_actividad = $tipoactividad;
                $registro->telefono = $telefono;
                $registro->regimen = $regimen;
                $registro->url_documento = $this->subir_archivo($cedula, $user->id, 'documento');
                $registro->url_camaracomercio = $this->subir_archivo($camaracomercio, $user->id, 'camaracomercio');
                $registro->url_rut = $this->subir_archivo($rut, $user->id, 'rut');
                $registro->url_banco = $this->subir_archivo($banco, $user->id, 'banco');
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



    function registrosPendientes()
    {
        if (Auth::check()) {
            $registros = DB::table('indycom_registro')
                ->join('indycom_tipotramite', 'indycom_tipotramite.id', '=', 'indycom_registro.tipo_tramite')
                ->join('indycom_actividadeconomica', 'indycom_actividadeconomica.id', '=', 'indycom_registro.actividad_economica')
                ->join('indycom_tipoactividadeconomica', 'indycom_tipoactividadeconomica.id', '=', 'indycom_registro.tipo_actividad')
                ->where('indycom_registro.estado', 'LIKE', 'Pendiente')
                ->select(
                    'indycom_registro.id', 'indycom_registro.estado', 'indycom_registro.user_id', 'indycom_registro.tipo_tramite as tipo_tramite_id', 'indycom_tipotramite.name as tipo_tramite_name', 'indycom_registro.fecha as fecha_registro', 'indycom_registro.tipo_documento', 'indycom_registro.numero_identificacion', 'indycom_registro.naturaleza_juridica', 'indycom_registro.razon_social', 'indycom_registro.direccion_notificacion', 'indycom_registro.actividad_economica as actividad_economica_id', 'indycom_actividadeconomica.name as actividad_economica_name', 'indycom_registro.direccion_establecimiento', 'indycom_registro.tipo_actividad as tipo_actividad_id', 'indycom_tipoactividadeconomica.name as tipo_actividad_name', 'indycom_registro.telefono', 'indycom_registro.regimen', 'indycom_registro.url_documento', 'indycom_registro.url_camaracomercio', 'indycom_registro.url_rut'
                )
                ->paginate(15);
            $cant_regP = count(RegistroIndycom::where('estado', 'LIKE', 'Pendiente')->get());
            $cant_regV = count(RegistroIndycom::where('estado', 'LIKE', 'Validado')->get());
            return view('indycom.admin.registrospendientes', ['registros' => $registros, 'cant_pendientes' => $cant_regP, 'cant_validados' => $cant_regV]);
        }
        return redirect('/')->with('error', 'Debe estar autenticado para acceder a está página.');
    }

    function validarRegistro()
    {
        $id = Input::get('id');
        $obs_general = Input::get('obs_general');
        $obs_documento = Input::get('obs_documento');
        $obs_camaradecomercio = Input::get('obs_camaradecomercio');
        $obs_rut = Input::get('obs_rut');
        $estado = Input::get('validado');

        $observacionregistro = new ObservacionRegistro();
        $observacionregistro->observacion_general = $obs_general;
        $observacionregistro->observacion_cedula = $obs_documento;
        $observacionregistro->observacion_rut = $obs_rut;
        $observacionregistro->observacion_camaracomercio = $obs_camaradecomercio;
        $observacionregistro->estado = $estado;
        $observacionregistro->registro_id = $id;

        $observacionregistro->save();
        $id_c = encrypt($id);

        $registro = RegistroIndycom::findOrFail($id);
        $registro->estado = $estado;
        $registro->save();

        return redirect("indycom/send_mail/{$id_c}")->with("mensaje", "Se ha validado el registro como {$estado}, hora envíale la respuesta al usuario.");
    }

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

    function mailValidacion($id)
    {
        $id2 = decrypt($id);
        $registro = RegistroIndycom::findOrFail($id2);
        if ($registro) {
            $user = User::findOrFail($registro->user_id);
            return view('indycom.admin.send_mail', ['id' => $id, 'email' => $user->email]);
        }
        return redirect()->back()->with('error', "No se reconoce la información, por favor intentelo de nuevo.");
    }

    function enviarMailValidacion()
    {
        $id = decrypt(Input::get('id'));
        $asunto = Input::get('asunto');
        $mensaje = Input::get('mensaje');
        if (!$asunto) {
            $asunto = "Validación registro Industria y Comercio";
        }
        $registro = RegistroIndycom::findOrFail($id);
        $observaciones = ObservacionRegistro::where('registro_id', '=', $id)->first();
        $user = User::findOrFail($registro->user_id);
        $email = $user->email;
        $general = $observaciones->observacion_general;
        $documento = $observaciones->observacion_cedula;
        $rut = $observaciones->observacion_rut;
        $camcom = $observaciones->observacion_camaracomercio;
        $estado = $observaciones->estado;


        /*Mail::send("emails.email_template", ['titulo' => $asunto, 'contenido' => $mensaje, 'email' => $email, 'general' => $general, 'documento' => $documento, 'rut' => $rut, 'camcom' => $camcom, 'estado' => $estado], function ($messaje) use ($asunto, $mensaje, $email, $general, $documento, $rut, $camcom, $estado) {
            $messaje->to($email, '')
                ->from('contacto.alcaldielzuliands@gmail.com', 'Contacto AlcaldiaElZulia')
                ->subject($asunto);
        });*/

        return redirect('admin_indycom/registros')->with('mensaje', 'Se ha notificado al usuario.');
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
    protected function subir_archivo($archivo, $id, $tipo)
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
    protected function getMensajeHTMLregistroIndyCom($titulo, $contenido){
        $msj = "<h1> $titulo </h1><br/>";
        $msj .= "<h3 style='text-aling: justify;'>$contenido</h3>";
        $msj .= "<h3>Nota:</h3>";
        $msj .= "<h5>Este correo es enviado a través de los servicios en línea de la Alcaldía de el Zulia.</h5>";
        $msj .= "<h5>Por favor, no responder este correo.</h5>";
        return $msj;
    }

}
