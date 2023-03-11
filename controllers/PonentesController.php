<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController
{
    public static function index(Router $router)
    {
        // ***** Paginación *****
        $pagina_actual = $_GET['page'] ?? '';
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/ponentes?page=1');
        }

        // Cantidad de Registros que se mostrarán por Página
        $registros_por_pagina = 10;
        // Total de Ponentes Registrados
        $total_registros = Ponente::count();

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        // Verifica que la Página que se intenta consultar no sea mayor al total de páginas
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/ponentes?page=1');
        }

        // Obtiene los Ponentes
        $ponentes = Ponente::paginar($registros_por_pagina, $paginacion->offset());
        // ***** Paginación *****


        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas',
            'ponentes' => $ponentes,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router)
    {

        $ponente = new Ponente();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Leer la Imagen
            if (!empty($_FILES['imagen']['tmp_name'])) {
                // Directorio para las imagenes de los ponentes
                $carpeta_imagenes = '../public/img/speakers';

                // Crea la carpeta si no existe
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])
                    ->fit(800, 800)
                    ->encode('png', 80);

                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])
                    ->fit(800, 800)
                    ->encode('webp', 80);

                // Genera un nombre aleatorio para la imagen
                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;
            }

            // Formateamos el Array de redes a un string 
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

            $ponente->sincronizar($_POST);

            $alertas = $ponente->validar();

            if (empty($alertas)) {
                // Guarda las Imagenes en el Servidor
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');

                if ($ponente->guardar()) {
                    header('Location: /admin/ponentes');
                }
            }
        }

        $alertas = Ponente::getAlertas();

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente',
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes),
            'alertas' => $alertas
        ]);
    }

    public static function editar(Router $router)
    {
        // Verifica que sea un ID válido
        $id = $_GET['id'] ?? '';
        $id = filter_var($id, FILTER_VALIDATE_INT);

        // Si el id no es un número entero, redirecciona
        if (!$id) header('Location: /admin/ponentes');

        // Busca el Ponente con el id ingresado
        $ponente = Ponente::find($id);

        // Si no encuentra el Ponente, redirecciona
        if (!$ponente) header('Location: /admin/ponentes');

        $ponente->imagen_actual = $ponente->imagen;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer la Imagen
            if (!empty($_FILES['imagen']['tmp_name'])) {
                // Directorio para las imagenes de los ponentes
                $carpeta_imagenes = '../public/img/speakers';

                // Crea la carpeta si no existe
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])
                    ->fit(800, 800)
                    ->encode('png', 80);

                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])
                    ->fit(800, 800)
                    ->encode('webp', 80);

                // Genera un nombre aleatorio para la imagen
                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $ponente->imagen_actual;
            }

            // Formateamos el Array de redes a un string 
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

            $ponente->sincronizar($_POST);

            $alertas = $ponente->validar();

            if (empty($alertas)) {
                // Verifica si se agregó una nueva imagen
                if (isset($nombre_imagen)) {
                    // Guarda las Imagenes en el Servidor
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                }

                if ($ponente->guardar()) {
                    header('Location: /admin/ponentes');
                }
            }
        }

        $alertas = Ponente::getAlertas();

        $router->render('admin/ponentes/editar', [
            'titulo' => 'Actualizar Ponente',
            'ponente' => $ponente ?? '',
            'redes' => json_decode($ponente->redes),
            'alertas' => $alertas
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifica que sea un ID válido
            $id = $_POST['id'] ?? '';
            $id = filter_var($id, FILTER_VALIDATE_INT);

            // Si el id no es un número entero, redirecciona
            if (!$id) header('Location: /admin/ponentes');

            // Busca el Ponente con el id ingresado
            $ponente = Ponente::find($id);

            // Si no encuentra el Ponente, redirecciona
            if (!$ponente) header('Location: /admin/ponentes');

            if ($ponente->eliminar()) {
                header('Location: /admin/ponentes');
            }
        }
    }
}
