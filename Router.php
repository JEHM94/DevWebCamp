<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {

        //$currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        //******* RUTAS PROTEGIDAS ******
        session_start();
        // Autenticación del usuario
        $auth = $_SESSION['login'] ?? null;
        $admin = $_SESSION['admin'] ?? null;

        // Array de Rutas Protegidas
        $protectedRoutes = [
            '/logout',
            '/finalizar-registro'
        ];

        // Array de Rutas Login
        $loginRoutes = [
            '/login',
            '/registro',
            '/olvide',
            '/reestablecer',
            '/mensaje',
            '/confirmar-cuenta'
        ];

        // Array de Rutas Protegidas de Administrador
        $adminRoutes = [
            '/admin/dashboard',
            '/admin/ponentes',
            '/admin/ponentes/crear',
            '/admin/ponentes/editar',
            '/admin/ponentes/eliminar',
            '/admin/eventos',
            '/admin/eventos/crear',
            '/admin/eventos/editar',
            '/admin/eventos/eliminar',
            '/api/eventos-horario',
            '/api/ponentes'
        ];

        // Si la Url actual es una ruta protegida
        // y el usuario no está autenticado, redirecciona a /
        if (in_array($currentUrl, $protectedRoutes) && !$auth) {
            header('Location: /login');
            // Retorna para prevenir la ejecución del código del controlador y la función asociada
            return;
        }

        // Si la Url actual es una ruta de login
        // y ya existe una sesión activa, redirecciona a /dashboard
        if (in_array($currentUrl, $loginRoutes) && $auth) {
            header('Location: /finalizar-registro');
            // Retorna para prevenir la ejecución del código del controlador y la función asociada
            return;
        }
        // Si la Url actual es una ruta de Administrador
        // y el usuario no está autenticado como Admin, redirecciona a /
        if (in_array($currentUrl, $adminRoutes) && !$admin) {
            header('Location: /login');
            // Retorna para prevenir la ejecución del código del controlador y la función asociada
            return;
        }



        //******* RUTAS PROTEGIDAS FIN ******


        if ($fn) {
            // Call user fn va a llamar una función cuando no sabemos cual sera
            call_user_func($fn, $this); // This es para pasar argumentos
        } else {
            header('Location: /404');
        }
    }

    public function render($view, $datos = [])
    {

        // Leer lo que le pasamos  a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
        }

        ob_start(); // Almacenamiento en memoria durante un momento...

        // entonces incluimos la vista en el layout
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpia el Buffer

        // Utilizar el layout de acuerdo a la URL
        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';

        // Muestra la vista de administracion
        if (str_contains($currentUrl, '/admin')) {
            include_once __DIR__ . '/views/admin-layout.php';
            return;
        }

        // Muestra la vista de usuario general
        include_once __DIR__ . '/views/layout.php';
    }
}
