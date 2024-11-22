<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MaterialDidacticoController;
use App\Http\Controllers\SuscripcionController;

Route::get('/', function () {
    return view('client.home.index');
})->name('home');

//Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('auth')->group(function () {
    Route::get('/signin-index', function () {
        return view('auth.login');
    })->name('singin');

    Route::get('/signup-index', function () {
        return view('auth.register');
    })->name('singup');
});

// Rutas de cursos
Route::prefix('courses')->group(function () {
    Route::get('/index-cursos', [CursoController::class, 'cursosshow'])->name('courses.index');
    Route::get('/curso/{id}', [CursoController::class, 'show'])->name('curso.detalle');

});

// Ruta de registro

//Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');



// Rutas para administradores
Route::middleware('roles:admin')->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');

    Route::get('/admin/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');

    /* crud de usuarios */
    Route::resource('usuarios', AdminController::class);

    //rutas de secciones

    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('admin.secciones.usuarios');
    Route::get('/renovaciones', [AdminController::class, 'renovaciones'])->name('admin.secciones.renovaciones');
    Route::get('/subcripciones', [AdminController::class, 'subscripciones'])->name('admin.secciones.subscripciones');

    // Más rutas para el rol admin...
});

// Rutas para clientes
Route::middleware('roles:cliente')->group(function () {
    Route::get('/usuario', function () {
        return view('client.home.index');
    })->name('client.home');

    Route::get('/usuario/profile', function () {
        return view('client.profile');
    })->name('client.profile');

    Route::get('/usuario/orders', function () {
        return view('client.orders');
    })->name('client.orders');


    //crud curso para cliente

    Route::get('/curso-show',[CursoController::class,'index'])->name('client.courses.create');
    Route::get('/mis-cursos',[CursoController::class,'misCursos'])->name('mis-cursos');
    Route::post('/curso-store',[CursoController::class,'store'])->name('cursos.store');
    // Más rutas para el rol cliente...


    //material didactico

Route::get('cursos/{cursoId}/materiales', [MaterialDidacticoController::class, 'verMateriales'])->name('materiales.ver');
Route::get('cursos/{cursoId}/materiales/crear', [MaterialDidacticoController::class, 'crearMaterial'])->name('material.create');
Route::post('cursos/{cursoId}/materiales', [MaterialDidacticoController::class, 'guardarMaterial'])->name('materiales.guardar');



Route::get('/curso/{id}/detalles', [CursoController::class, 'detalles'])->name('curso.detalles');


});

Route::get('plan', [SuscripcionController::class, 'plan'])->name('plan');
Route::get('pago/{precio}', [SuscripcionController::class, 'pago'])->name('pago');
Route::get('/stripe/{precio}', [SuscripcionController::class, 'stripe']);
Route::post('stripe/{precio}', [SuscripcionController::class, 'stripePost'])
    ->name('stripe.post');