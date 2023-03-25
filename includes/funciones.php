<?php

use Model\Dia;
use Model\Hora;
use Model\Ponente;
use Model\Categoria;

define('NUEVO', 'nuevo');
define('EXISTENTE', 'existente');
define('RECUPERAR_CUENTA', 'recuperar_cuenta');
define('CAMBIAR_PASSWORD', 'cambiar_password');
define('NUEVO_PASSWORD', 'nuevo_password');
define('ACTUALIZAR_PERFIL', 'actualizar_perfil');

// Nombre de clase css para Alertas
define('ERROR', 'error');
define('EXITO', 'exito');
define('NEUTRAL', 'neutral');

// Eventos
define('CONFERENCIA', '1');
define('WORKSHOP', '2');
define('VIERNES', '1');
define('SABADO', '2');


function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

function paginaActual($path): bool
{
    return str_contains($_SERVER['PATH_INFO'] ?? '/', $path) ? true : false;
}

// Devuelve un efecto Aleatorio de la librería AOS
function aos_animacion(): void
{
    $efectos = [
        'fade-up',
        'fade-down',
        'fade-left',
        'fade-right',
        'flip-left',
        'flip-right',
        'zoom-in',
        'zoom-out',
        'zoom-in-up',
        'zoom-in-down'
    ];
    echo ' data-aos="' . $efectos[array_rand($efectos, 1)] . '" ';
}

// Separa y  Ordena los eventos
function formatearEventos($eventos = []): array
{
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

    return $eventos_formateados;
}
