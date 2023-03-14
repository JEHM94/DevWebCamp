<?php

namespace Controllers;

use Model\Ponente;

class APIPonenteController
{
    public static function index()
    {
        $ponentes = Ponente::all();

        echo json_encode([
            'body' => $ponentes  ?? [],
            'code' => '200'
        ]);
        
    }
}
