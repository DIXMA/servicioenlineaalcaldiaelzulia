<?php


Route::get('/', function () {
    return view('welcome');
});

Route::get('admin_indycom', function () {
    return view('indycom.admin.login_admin');
});

Route::get('admin_indycom/registros', array(
    'uses' => 'ApiController@registrosPendientes'
));

Route::post('admin_indycom/login', array(
    'uses' => 'ApiController@login'
));

Route::get('admin_indycom/logout', array(
    'uses' => 'ApiController@logout'
));

Route::get('indycom/registro', array (
    'uses' => 'ApiController@verFomRegistroIndyCom'
));

Route::post('indycom/guardar_registro', array(
    'uses' => 'ApiController@guardarRegistroIndycom'
));

Route::post('indycom/validar_registro', array(
    'uses' => 'ApiController@validarRegistro'
));

Route::get('sisben', function () {
    return view('sisben.form_consultar_sisben');
});

Route::get('sisben/consultar/{ced}', array(
    'uses' => 'ApiController@consultarSisben'
));

Route::get('sisben/certificado/{id}', array(
    'uses' => 'ApiController@sisbenPDF'
));

Route::get('logout', array(
    'uses' => 'ApiController@logout'
));

Route::get('indycom/send_mail/{id}', array(
    'uses' => 'ApiController@mailValidacion'
));

Route::post('indycom/enviar', array(
    'uses' => 'ApiController@enviarMailValidacion'
));