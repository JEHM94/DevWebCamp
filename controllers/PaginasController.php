<?php

namespace Controllers;

use MVC\Router;
use Model\Evento;
use Model\Ponente;

class PaginasController
{
    public static function index(Router $router)
    {
        $eventos = Evento::ordenar('hora_id', 'ASC');

        // Separa y  Ordena los eventos
        $eventos_formateados = formatearEventos($eventos);

        // Obtiene el total de cada bloque
        $totalPonentes = Ponente::count();
        $totalConferencias = Evento::count('categoria_id', 1);
        $totalWorkshops = Evento::count('categoria_id', 2);

        // Ponentes
        $ponentes = Ponente::all();

        // Render a la Vista
        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'eventos' => $eventos_formateados,
            'totalPonentes' => $totalPonentes,
            'totalConferencias' => $totalConferencias,
            'totalWorkshops' => $totalWorkshops,
            'ponentes' => $ponentes,
        ]);
    }

    public static function evento(Router $router)
    {

        // Render a la Vista
        $router->render('paginas/devwebcamp', [
            'titulo' => 'Sobre Nosotros',
        ]);
    }

    public static function paquetes(Router $router)
    {

        // Render a la Vista
        $router->render('paginas/paquetes', [
            'titulo' => 'Nuestros Paquetes',
        ]);
    }

    public static function conferencias(Router $router)
    {
        $eventos = Evento::ordenar('hora_id', 'ASC');

        // Separa y  Ordena los eventos
        $eventos_formateados = formatearEventos($eventos);

        // Render a la Vista
        $router->render('paginas/conferencias', [
            'titulo' => 'Conferencias & Workshops',
            'eventos' => $eventos_formateados
        ]);
    }

    public static function error(Router $router)
    {

        // Render a la Vista
        $router->render('paginas/error', [
            'titulo' => 'Página no encontrada',
        ]);
    }
}
