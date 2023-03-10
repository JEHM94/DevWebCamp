<?php

namespace Model;

class Ponente extends ActiveRecord
{
    protected static $tabla = 'ponentes';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'ciudad', 'pais', 'imagen', 'tags', 'redes'];

    public $id;
    public $nombre;
    public $apellido;
    public $ciudad;
    public $pais;
    public $imagen;
    public $tags;
    public $redes;

    public function __construct($arr = [])
    {
        $this->id = $arr['id'] ?? null;
        $this->nombre = $arr['nombre'] ?? '';
        $this->apellido = $arr['apellido'] ?? '';
        $this->ciudad = $arr['ciudad'] ?? '';
        $this->pais = $arr['pais'] ?? '';
        $this->imagen = $arr['imagen'] ?? '';
        $this->tags = $arr['tags'] ?? '';
        $this->redes = $arr['redes'] ?? '';
    }


    public function validar(): array
    {
        // Validación de Nombre del Ponente
        if (!$this->nombre) {
            self::$alertas[ERROR][] = 'El nombre es obligatorio';
        }

        // Validación de Apellido del Ponente
        if (!$this->apellido) {
            self::$alertas[ERROR][] = 'El apellido es obligatorio';
        }

        // Validación de Cuidad del Ponente
        if (!$this->ciudad) {
            self::$alertas[ERROR][] = 'Debe Ingresar una Ciudad';
        }

        // Validación de País del Ponente
        if (!$this->pais) {
            self::$alertas[ERROR][] = 'Debe Ingresar un Pais';
        }

        // Validación de Imagen del Ponente
        if (!$this->imagen) {
            self::$alertas[ERROR][] = 'La imagen es obligatoria';
        }

        // Validación de Tags del Ponente
        if (!$this->tags) {
            self::$alertas[ERROR][] = 'Las áreas de experiencia son obligatorias';
        }

        return self::$alertas;
    }
}
