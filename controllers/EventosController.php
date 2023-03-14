<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use MVC\Router;

class EventosController
{
    public static function index(Router $router)
    {
        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops'
        ]);
    }

    public static function crear(Router $router)
    {
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');


        $evento = new Evento();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $evento->sincronizar($_POST);

            $alertas = $evento->validar();

            if (empty($alertas)) {

                if ($evento->guardar()) {
                    header('Location: /admin/eventos');
                }
            }
        }

        $alertas = Evento::getAlertas();

        $router->render('admin/eventos/crear', [
            'titulo' => 'Registrar Evento',
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento,
            'alertas' => $alertas
        ]);
    }
}
