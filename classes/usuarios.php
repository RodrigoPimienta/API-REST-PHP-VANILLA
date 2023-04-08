<?php
class Usuario
{
    // Propiedades
    public int $id;
    public string $nombre;
    public string $correo;
    public int $estado;

    // Método constructor
    public function __construct(int $id, string $nombre, string $correo, int $estado)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->estado = $estado;
    }
}

?>