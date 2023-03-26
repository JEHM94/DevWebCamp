<?php

namespace Controllers;

use Model\Regalo;
use Model\Registro;

class APIRegaloController
{
    public static function index()
    {
        $regalos = Regalo::all();

        foreach ($regalos as $regalo) {
            $regalo->total = Registro::countWhere([
                'regalo_id' => $regalo->id,
                'paquete_id' => "1"
            ]);
        }

        echo json_encode([
            'body' => $regalos  ?? [],
            'code' => '200'
        ]);
    }
}
