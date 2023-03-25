<?php

namespace Controllers;

use MVC\Router;
use Model\Evento;
use Model\EventosRegistros;
use Model\Regalo;
use Model\Paquete;
use Model\Usuario;
use Model\Registro;

class RegistroController
{
    public static function crear(Router $router)
    {
        // Verifica si el Usuario ya tiene un plan Registrado
        $registro = Registro::where('usuario_id', $_SESSION['id']);

        if ($registro && ($registro->paquete_id === "3" || $registro->paquete_id === "2")) {
            header('Location: /boleto?token=' . $registro->token);
            return;
        }

        // Si el usuario ya realizó el pago redirecciona a las conferencias
        if ($registro && $registro->paquete_id === "1") {
            header('Location: /finalizar-registro/conferencias');
            return;
        }


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
            if (empty($_POST)) {
                echo json_encode([
                    'error' => 'Datos no válidos',
                    'code' => '400'
                ]);
                return;
            }


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
                    'error' => 'Registro no válido',
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
        if (!$token || strlen($token) !== 8) {
            header('Location: /');
            return;
        }

        // Busca si hay un registro con el token ingresado
        $registro = Registro::where('token', $token);

        // Verifica que exista el boleto
        if (!$registro) {
            header('Location: /');
            return;
        }

        // LLena el Objeto del Registro para mostrar el Boleto
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);

        $router->render('registro/boleto', [
            'titulo' => 'Boleto Virtual',
            'registro' => $registro
        ]);
    }

    public static function conferencias(Router $router)
    {
        // Valida que el usuario tenga el plan presencial
        $registro = Registro::where('usuario_id', $_SESSION['id']);

        if ($registro && $registro->paquete_id === "2") {
            header('Location: /boleto?token=' . urlencode($registro->token));
            return;
        }

        if ($registro->paquete_id !== "1") {
            header('Location: /finalizar-registro');
            return;
        }

        // Redirecciona al Boleto virtual si el usuario ya registró sus conferencias
        $eventoRegistro = EventosRegistros::where('registro_id', $registro->id);
        if ($eventoRegistro && $registro->paquete_id === "1") {
            header('Location: /boleto?token=' . urlencode($registro->token));
            return;
        }

        $eventos = Evento::ordenar('hora_id', 'ASC');

        // Separa y  Ordena los eventos
        $eventos_formateados = formatearEventos($eventos);

        // Regalos
        $regalos = Regalo::all('ASC');

        // Registra al usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $eventos = explode(',', $_POST['eventos'] ?? '');

            // Verifica que existan eventos
            if ($eventos[0] === '') {
                echo json_encode([
                    'resultado' => false
                ]);
                return;
            }

            // Verifica que exista el registro y que el paquete del registro sea el Presencial
            if (!$registro || $registro->paquete_id !== "1") {
                echo json_encode([
                    'resultado' => false
                ]);
                return;
            }

            $eventos_array = [];
            // Verifica la disponibilidad de los eventos agregados
            foreach ($eventos as $evento_id) {
                $evento = Evento::find($evento_id);
                if (!$evento || $evento->disponibles === "0") {
                    echo json_encode([
                        'resultado' => false
                    ]);
                    return;
                }
                $eventos_array[] = $evento;
            }

            foreach ($eventos_array as $evento) {
                // Sustrae el lugar disponible y actualiza el evento
                $evento->disponibles -=  1;
                $evento->guardar();


                // Almacena el registro
                $datos = [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id,
                ];
                $registro_usuario = new EventosRegistros($datos);
                $registro_usuario->guardar();
            }

            // Almacena el Regalo
            $registro->sincronizar([
                'regalo_id' => $_POST['regalo_id']
            ]);
            $resultado = $registro->guardar();
            if ($resultado) {
                echo json_encode([
                    'resultado' => $resultado,
                    'token' => $registro->token
                ]);
            }
            return;
        }

        $router->render('registro/conferencias', [
            'titulo' => 'Elige Workshops y Conferencias',
            'eventos' => $eventos_formateados,
            'regalos' => $regalos
        ]);
    }
}
