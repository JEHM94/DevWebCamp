<?php

namespace Controllers;

use MVC\Router;
use Model\Registro;
use Classes\Paginacion;
use Model\Paquete;
use Model\Usuario;

class RegistradosController
{
    public static function index(Router $router)
    {

        // ***** Paginación *****
        $pagina_actual = $_GET['page'] ?? '';
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/registrados?page=1');
        }

        // Cantidad de Registros que se mostrarán por Página
        $registros_por_pagina = 10;
        // Total de Ponentes Registrados
        $total_registros = Registro::count();

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        // Verifica que la Página que se intenta consultar no sea mayor al total de páginas
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/registrados?page=1');
        }

        // Obtiene los Registros
        $registros = Registro::paginar($registros_por_pagina, $paginacion->offset());
        // ***** Paginación *****

        foreach ($registros as $registro) {
            $registro->usuario = Usuario::find($registro->usuario_id);
            $registro->paquete = Paquete::find($registro->paquete_id);
        }

        $router->render('admin/registrados/index', [
            'titulo' => 'Usuarios Registrados',
            'registros' => $registros,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
}
