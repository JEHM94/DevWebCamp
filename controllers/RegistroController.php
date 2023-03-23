<?php

namespace Controllers;

use Model\Paquete;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistroController
{
    public static function crear(Router $router)
    {
        // Verifica si el Usuario ya tiene un plan Registrado
        $registro = Registro::where('usuario_id', $_SESSION['id']);

        if ($registro) header('Location: /boleto?token=' . $registro->token);

        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro'
        ]);
    }

    public static function gratis()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Verifica si el Usuario ya tiene un plan Registrado
            $registro = Registro::where('usuario_id', $_SESSION['id']);

            if ($registro) {
                header('Location: /boleto?token=' . $registro->token);
                return;
            }


            // Crea un nuevo token para el boleto
            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            // Datos para  el Registro
            $datos = [
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            ];

            // Instancia el nuevo Registro
            $registro = new Registro($datos);

            // Guarda el nuevo registro y muestra el boleto virtual
            if ($registro->guardar()) header('Location: /boleto?token=' . urlencode($registro->token));
        }
    }

    public static function pago()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Verifica si el Usuario ya tiene un plan Registrado
            $registro = Registro::where('usuario_id', $_SESSION['id']);

            if ($registro) {
                header('Location: /boleto?token=' . $registro->token);
                return;
            }
            if (empty($_POST)) echo json_encode([
                'error' => 'Datos no válidos',
                'code' => '400'
            ]);


            // Datos para  el Registro
            $datos = $_POST;
            // Crea un nuevo token para el boleto
            $datos['token'] = substr(md5(uniqid(rand(), true)), 0, 8);
            $datos['usuario_id'] = $_SESSION['id'];

            try {
                // Instancia el nuevo Registro
                $registro = new Registro($datos);
                // Guarda el nuevo registro y muestra el boleto virtual
                $resultado = $registro->guardar();

                echo json_encode($resultado);
            } catch (\Throwable $th) {
                echo json_encode([
                    'error' => 'Datos no válidos',
                    'code' => '400'
                ]);
            }
        }
    }

    public static function boleto(Router $router)
    {
        // Validación de token
        $token = $_GET['token'] ?? '';

        // Verifica que sea un token válido
        if (!$token || strlen($token) !== 8) header('Location: /');

        // Busca si hay un registro con el token ingresado
        $registro = Registro::where('token', $token);

        // Verifica que exista el boleto
        if (!$registro) header('Location: /');

        // LLena el Objeto del Registro para mostrar el Boleto
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);

        $router->render('registro/boleto', [
            'titulo' => 'Boleto Virtual',
            'registro' => $registro
        ]);
    }
}
