<?php

namespace Model;

class Registro extends ActiveRecord
{
    protected static $tabla = 'registros';
    protected static $columnasDB = ['id', 'paquete_id', 'pago_id', 'token', 'usuario_id'];

    public $id;
    public $paquete_id;
    public $pago_id;
    public $token;
    public $usuario_id;

    public function __construct($arr = [])
    {
        $this->id = $arr['id'] ?? null;
        $this->paquete_id = $arr['paquete_id'] ?? '';
        $this->pago_id = $arr['pago_id'] ?? '';
        $this->token = $arr['token'] ?? '';
        $this->usuario_id = $arr['usuario_id'] ?? '';
    }
}
