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

    function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect('/');
    }

    function verFomRegistroIndyCom()
    {
        $actividad = ActividadEconomica::all();
        $tipo_actividad = TipoActividadEconomica::all();
        return view('indycom.web.form_registro_indycom', ['actividades' => $actividad, 'tipo_actividades' => $tipo_actividad]);
    }

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
        $email = Input::get('email');
        $registro = RegistroIndycom::where('numero_identificacion', '=', $numero)->first();
        if (!$registro) {
            if ($tipotramite && $tipodocumento && $fecha && $naturalezajuridica && $numero && $nombres && $direccion && $actividadeconomica && $direccionestablecimiento && $tipoactividad && $telefono && $regimen && $camaracomercio && $cedula && $rut && $email) {
                $user = new User();
                $user->name = $nombres;
                $user->email = $email;
                $user->password = md5($numero);
                $user->estado = 1;
                $user->rol_id = 2;
                $user->remember_token = '';
                $user->save();
                $registro = new RegistroIndycom();
                $registro->estado = 'Pendiente';
                $registro->user_id = $user->id;
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
                $registro->save();
                /*$this->enviarMail(
                    'Pre Registro Industria y Comercio',
                    'Se ha realizado el regsitro existoamente, los datos serán validados y se notifica´ra por este medio del resultado del proceso.',
                    $email,
                    "email_template"
                );*/
                return redirect()->back()->with('mensaje', 'se ha registrado');
            }
        } else {
            return redirect()->back()->with('error', "Ya se ha realizado con el npumero de identificación: $numero");
        }
        return redirect()->back()->with('error', 'no se ha registrado');
    }

    private function subir_archivo($imagen_principal, $id, $tipo)
    {
        $nombre = $imagen_principal->getClientOriginalName();
        $extension = explode('.', $nombre);
        $ruta_disco = public_path() . '/archivos/' . $id;
        $imagen_principal->move($ruta_disco, "{$tipo}_{$id}.{$extension[1]}");
        //error_log("NOMBRE . . - - - " . $ruta_disco . $nombre);
        $ruta = "archivos/$id/{$tipo}_{$id}.{$extension[1]}";
        return $ruta;
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
        $url_ini = Input::get('url');

        $observacionregistro = new ObservacionRegistro();
        $observacionregistro->observacion_general = $obs_general;
        $observacionregistro->observacion_cedula = $obs_documento;
        $observacionregistro->observacion_rut = $obs_rut;
        $observacionregistro->observacion_camaracomercio = $obs_camaradecomercio;
        $observacionregistro->estado = $estado;
        $observacionregistro->registro_id = $id;

        $observacionregistro->save();
        $id_c = encrypt($id);
        return redirect("indycom/send_mail/{$id_c}")->with("mensaje", "Se ha validado el registro como {$estado}, hora envíale la respuesta al usuario.");

    }

    function enviarMail($titulo, $contenido, $email, $template)
    {
        Mail::send("emails.email_template", ['titulo' => $titulo, 'contenido' => $contenido], function ($messaje) use ($titulo, $email) {
            $messaje->to($email, '')
                ->from('contacto.alcaldielzuliands@gmail.com', 'Contacto AlcaldiaElZulia')
                ->subject($titulo);
        });
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

    function consultarSisben($ced)
    {
        $sisben = Sisben::where('numero_documento', '=', $ced)->first();
        return $sisben;
    }

    function sisbenPDF($id)
    {
        $sisben = Sisben::where('numero_documento', '=', $id)->first();
        $dia = date("d");
        $mes = date("m");
        $ano = date("Y");
        return PDF::loadView('pdf.certificado_sisben', array('user' => $sisben, 'dia' => $dia, 'mes' => $mes, 'ano' => $ano))->setPaper('a4', 'landscape')->stream('certificado.pdf');
    }

}
