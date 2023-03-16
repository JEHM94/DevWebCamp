<?php

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Categoria;
use Classes\Paginacion;
use Model\Ponente;

class EventosController
{
    public static function index(Router $router)
    {
        // ***** Paginación *****
        $pagina_actual = $_GET['page'] ?? '';
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/eventos?page=1');
        }

        // Cantidad de Registros que se mostrarán por Página
        $registros_por_pagina = 10;
        // Total de Eventos Registrados
        $total_registros = Evento::count();

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        // Verifica que la Página que se intenta consultar no sea mayor al total de páginas
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/eventos?page=1');
        }

        // Obtiene los Eventos
        $eventos = Evento::paginar($registros_por_pagina, $paginacion->offset());
        // ***** Paginación *****

        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
        }


        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops',
            'eventos' => $eventos,
            'paginacion' => $paginacion->paginacion()
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
