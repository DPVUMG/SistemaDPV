<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::post('login', 'Auth\LoginController@login')->middleware('guest');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm')->middleware('auth');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm')->middleware('auth');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');


Route::group(['middleware' => ['auth']], function () {
    Route::name('sistema.')->group(function () {
        Route::get('/dashboard', 'HomeController@index')->name('home');
    });
});


/* ================================== RUTAS PARA LOS CONTROLADORES =============================== */

Route::group(['middleware' => ['auth']], function () {
    Route::name('configuracion.')->group(function () {
        Route::get('configuracion/page', 'ConfiguracionController@index_pagina')->name('index_pagina');
        Route::put('configuracion/update/{configuracion}', 'ConfiguracionController@update')->name('update');
        Route::put('configuracion/telefono/{configuracion}', 'ConfiguracionController@telefono_store')->name('telefono_store');
        Route::put('configuracion/direccion/{configuracion}', 'ConfiguracionController@direccion_store')->name('direccion_store');
        Route::delete('configuracion/telefono_delete/{telefono}', 'ConfiguracionController@telefono_delete')->name('telefono_delete');
        Route::delete('configuracion/direccion_delete/{direccion}', 'ConfiguracionController@direccion_delete')->name('direccion_delete');
    });

    Route::resource('marca', 'MarcaController')->except(['create', 'show']);
    Route::resource('variante', 'VarianteController')->except(['create', 'show']);
    Route::resource('categoria', 'CategoriaController')->except(['create']);
    Route::resource('sub_categoria', 'SubCategoriaController')->except(['index', 'create', 'show']);
    Route::resource('presentacion', 'PresentacionController')->except(['create', 'show']);
    Route::resource('variante_presentacion', 'VariantePresentacionController')->except(['create', 'show', 'edit', 'update']);

    Route::resource('producto', 'ProductoController')->except(['create', 'destroy']);

    Route::resource('producto_variante', 'ProductoVarianteController')->except(['create', 'store', 'edit']);
    Route::resource('producto_foto', 'ProductoFotoController')->except(['index', 'create', 'store']);

    Route::name('catalogo_escuela.')->group(function () {
        Route::get('/catalogo_escuela', 'CatalogoEscuelaController@index')->name('index');
        Route::post('/catalogo_escuela/departamental', 'CatalogoEscuelaController@departamental')->name('departamental');
        Route::get('/catalogo_escuela/supervisor', 'CatalogoEscuelaController@supervisor')->name('supervisor');
        Route::post('/catalogo_escuela/distrito', 'CatalogoEscuelaController@distrito')->name('distrito');
        Route::get('/catalogo_escuela/nivel', 'CatalogoEscuelaController@nivel')->name('nivel');
        Route::post('/catalogo_escuela/director', 'CatalogoEscuelaController@director')->name('director');
        Route::post('/catalogo_escuela/plan', 'CatalogoEscuelaController@plan')->name('plan');
        Route::get('/catalogo_escuela/escuela_codigos/{escuela}', 'CatalogoEscuelaController@escuela_codigos')->name('escuela_codigos');
        Route::get('/catalogo_escuela/escuelas', 'CatalogoEscuelaController@escuelas')->name('escuelas');
        Route::post('/catalogo_escuela/banco', 'CatalogoEscuelaController@banco')->name('banco');
    });

    Route::resource('departamental', 'DepartamentalController')->except(['create', 'show']);
    Route::resource('distrito', 'DistritoController')->except(['create', 'show']);
    Route::resource('nivel', 'NivelController')->except(['create', 'show']);
    Route::resource('supervisor', 'SupervisorController')->except(['create']);

    Route::resource('escuela', 'EscuelaController');
    Route::get('/escuela/status/{escuela}', 'EscuelaController@status')->name('escuela.status');
    Route::resource('escuela_codigo', 'EscuelaCodigoController')->only(['show', 'update', 'destroy']);
    Route::resource('escuela_alumno', 'EscuelaCodigoAlumnoController')->only(['show', 'update', 'destroy']);
    Route::resource('escuela_supervisor', 'EscuelaSupervisorController')->only(['show', 'update', 'destroy']);
    Route::resource('director', 'DirectorController')->only(['index', 'show', 'update', 'destroy']);

    Route::resource('escuela_usuario', 'EscuelaUsuarioController')->except('destroy');
    Route::get('/escuela_usuario/status/{escuela_usuario}', 'EscuelaUsuarioController@status')->name('escuela_usuario.status');

    Route::resource('escuela_descuento', 'EscuelaDescuentoController')->except(['create', 'edit']);
    Route::get('/escuela_descuento/status/{escuela_descuento}', 'EscuelaDescuentoController@status')->name('escuela_descuento.status');

    Route::resource('usuario', 'UsuarioControlller')->except(['destroy', 'show']);
    Route::get('/usuario/status/{usuario}', 'UsuarioControlller@status')->name('usuario.status');

    Route::resource('contacto', 'ContactoController')->only(['index']);

    Route::resource('escuela_pedido', 'EscuelaPedidoController')->only(['index', 'show', 'update', 'destroy']);
    Route::get('/escuela_pedido/estado/{estado}', 'EscuelaPedidoController@estado')->name('escuela_pedido.estado');
    Route::get('/escuela_pedido/entregado/{escuela_pedido}', 'EscuelaPedidoController@entregado')->name('escuela_pedido.entregado');
    Route::get('/escuela_pedido/ingresado/{escuela_pedido}', 'EscuelaPedidoController@ingresado')->name('escuela_pedido.ingresado');
    Route::resource('escuela_pedido_detalle', 'EscuelaDetallePedidoController')->only(['show', 'update', 'destroy']);
    Route::resource('escuela_pedido_historial', 'EscuelaPedidoHistorialController')->only(['index', 'show']);
    Route::resource('pago', 'PagoPedidoController')->only(['index', 'store', 'show', 'destroy']);

    Route::resource('gasto', 'GastoController')->except(['create', 'edit', 'update']);

    Route::name('reporte.')->group(function () {
        Route::get('reporte/index', 'ReporteController@index')->name('index');
        Route::get('reporte/pagos_realizados', 'ReporteController@pagos_realizados')->name('pagos_realizados');
        Route::get('reporte/pagos_pendientes', 'ReporteController@pagos_pendientes')->name('pagos_pendientes');
        Route::get('reporte/pedidos_escuelas', 'ReporteController@pedidos_escuelas')->name('pedidos_escuelas');
    });

    Route::name('pdf.')->group(function () {
        Route::get('pdf/pagos_realizados/{date_start}/{date_end}', 'PDFController@pagos_realizados')->name('pagos_realizados');
        Route::get('pdf/pagos_pendientes/{date_start}/{date_end}', 'PDFController@pagos_pendientes')->name('pagos_pendientes');
        Route::get('pdf/pedidos_escuelas/{escuela_id}', 'PDFController@pedidos_escuelas')->name('pedidos_escuelas');
    });
});

Route::group(['middleware' => ['auth']], function () {
    Route::name('configuracion.')->group(function () {
        Route::get('configuracion/system', 'ConfiguracionController@index_sistema')->name('index_sistema');
        Route::post('configuracion/store', 'ConfiguracionController@store')->name('store');
    });
});
