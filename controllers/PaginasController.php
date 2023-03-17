<?php

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Ponente;
use Model\Categoria;

class PaginasController
{
    public static function index(Router $router)
    {

        // Render a la Vista
        $router->render('paginas/index', [
            'titulo' => 'Inicio',
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
        $eventos_formateados = [];

        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);

            // Conferencias, día Viernes
            if ($evento->categoria_id === CONFERENCIA && $evento->dia_id === VIERNES)
                $eventos_formateados['conferencias_v'][] = $evento;

            // Conferencias, día Sábado
            if ($evento->categoria_id === CONFERENCIA && $evento->dia_id === SABADO)
                $eventos_formateados['conferencias_s'][] = $evento;

            // Workshops, día Viernes
            if ($evento->categoria_id === WORKSHOP && $evento->dia_id === VIERNES)
                $eventos_formateados['workshops_v'][] = $evento;

            // Workshops, día Sábado
            if ($evento->categoria_id === WORKSHOP && $evento->dia_id === SABADO)
                $eventos_formateados['workshops_s'][] = $evento;
        }

        // Render a la Vista
        $router->render('paginas/conferencias', [
            'titulo' => 'Conferencias & Workshops',
            'eventos' => $eventos_formateados
        ]);
    }
}
