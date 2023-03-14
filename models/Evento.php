<?php

namespace Model;

class Evento extends ActiveRecord
{
    protected static $tabla = 'eventos';
    protected static $columnasDB = ['id', 'nombre', 'descripcion', 'disponibles', 'categoria_id', 'dia_id', 'hora_id', 'ponente_id'];

    public $id;
    public $nombre;
    public $descripcion;
    public $disponibles;
    public $categoria_id;
    public $dia_id;
    public $hora_id;
    public $ponente_id;

    public function __construct($arr = [])
    {
        $this->id = $arr['id'] ?? null;
        $this->nombre = $arr['nombre'] ?? '';
        $this->descripcion = $arr['descripcion'] ?? '';
        $this->disponibles = $arr['disponibles'] ?? '';
        $this->categoria_id = $arr['categoria_id'] ?? '';
        $this->dia_id = $arr['dia_id'] ?? '';
        $this->hora_id = $arr['hora_id'] ?? '';
        $this->ponente_id = $arr['ponente_id'] ?? '';
    }


    // Mensajes de validación para la creación de un evento
    public function validar()
    {
        // Valida el nombre del Evento
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }

        // Valida la descripción del Evento
        if (!$this->descripcion) {
            self::$alertas['error'][] = 'La descripción es Obligatoria';
        }

        // Valida la categoría del Evento
        if (!$this->categoria_id  || !filter_var($this->categoria_id, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'Elige una Categoría';
        }

        // Valida el día del Evento
        if (!$this->dia_id  || !filter_var($this->dia_id, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'Elige el Día del evento';
        }

        // Valida la hora del Evento
        if (!$this->hora_id  || !filter_var($this->hora_id, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'Elige la hora del evento';
        }

        // Valida el Ponente del Evento
        if (!$this->ponente_id || !filter_var($this->ponente_id, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'Selecciona la persona encargada del evento';
        }

        // Valida los cupos disponibles del Evento
        if (!$this->disponibles  || !filter_var($this->disponibles, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'Añade una cantidad de Lugares Disponibles';
        }

        return self::$alertas;
    }
}
