<?php

namespace Controllers;

use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController
{
    public static function index(Router $router)
    {
        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas'
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

            $alertas = $ponente->validar(NUEVO);

            if (empty($alertas)) {
                // Guarda las Imagenes en el Servidor
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');

                if($ponente->guardar()){
                    header('Location: /admin/ponentes');
                }
            }
        }

        $alertas = Ponente::getAlertas();
        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente',
            'ponente' => $ponente,
            'alertas' => $alertas
        ]);
    }
}
