<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIEventoController;
use Controllers\APIPonenteController;
use MVC\Router;
use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\EventosController;
use Controllers\PonentesController;
use Controllers\RegalosController;
use Controllers\RegistradosController;

$router = new Router();

// ** Area de Autenticación **
// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);

// ** Area de API **
$router->get('/api/eventos-horario', [APIEventoController::class, 'index']);
$router->get('/api/ponentes', [APIPonenteController::class, 'index']);

// ** Area de Administración **
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

// Ponentes
$router->get('/admin/ponentes', [PonentesController::class, 'index']);
// Crear
$router->get('/admin/ponentes/crear', [PonentesController::class, 'crear']);
$router->post('/admin/ponentes/crear', [PonentesController::class, 'crear']);
// Editar
$router->get('/admin/ponentes/editar', [PonentesController::class, 'editar']);
$router->post('/admin/ponentes/editar', [PonentesController::class, 'editar']);
// Eliminar
$router->post('/admin/ponentes/eliminar', [PonentesController::class, 'eliminar']);

// Eventos
$router->get('/admin/eventos', [EventosController::class, 'index']);
// Crear
$router->get('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->post('/admin/eventos/crear', [EventosController::class, 'crear']);
// Edittar
$router->get('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/editar', [EventosController::class, 'editar']);
// Eliminar
$router->post('/admin/eventos/eliminar', [EventosController::class, 'eliminar']);

// Registrados
$router->get('/admin/registrados', [RegistradosController::class, 'index']);

// Regalos
$router->get('/admin/regalos', [RegalosController::class, 'index']);



$router->comprobarRutas();
