<?php

namespace Controllers;

use MVC\Router;

class PonentesController
{
    public static function index(Router $router){
        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas'
        ]);
    }

    public static function crear(Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

        }

        $alertas = [];
        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente',
            'alertas' => $alertas
        ]);
    }
}