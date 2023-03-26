<?php

namespace Controllers;

use Model\Evento;
use Model\Paquete;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class DashboardController
{
    public static function index(Router $router)
    {

        // Obtiene los últimos registros
        $registros = Registro::get(5);
        foreach ($registros as $registro) {
            $registro->usuario = Usuario::find($registro->usuario_id);
            $registro->paquete = Paquete::find($registro->paquete_id);
        }

        // Calcula los ingresos 
        $registrosPresenciales  = Registro::count('paquete_id', 1);
        $registrosVirtuales  = Registro::count('paquete_id', 2);

        $ingresos = [
            'presenciales' => $registrosPresenciales * 187.95,
            'virtuales' => $registrosVirtuales * 46.05,
            'total' => ($registrosPresenciales * 187.95) + ($registrosVirtuales * 46.05)
        ];


        // Obteniene los eventos con más y menos lugares disponibles
        $menos_disponibles = Evento::ordenarLimite('disponibles', 'ASC', 5);
        $mas_disponibles = Evento::ordenarLimite('disponibles', 'DESC', 5);


        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'registros' => $registros,
            'ingresos' => $ingresos,
            'menos_disponibles' => $menos_disponibles,
            'mas_disponibles' => $mas_disponibles
        ]);
    }
}
