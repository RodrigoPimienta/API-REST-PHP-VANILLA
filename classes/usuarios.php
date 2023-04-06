<?php
class Usuario
{
    // Propiedades
    public $id;
    public $nombre;
    public $correo;
    public $estado;

    // Método constructor
    public function __construct($id, $nombre, $correo, $estado)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->estado = $estado;
    }
}
?>