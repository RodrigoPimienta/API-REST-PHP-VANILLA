<?php

class UsersModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getUsuarios()
    {
        // Implementación para obtener usuarios de la base de datos
        $sql = "SELECT * FROM usuarios";
        $result = $this->db->query($sql);

        //verificar si result es falso
        if (!$result) {
            return json_encode(array('erro' => true, 'mensaje' => 'Error en la consulta', 'valor' => '', 'datos' => ''));
        }

        $usuarios = array();
        while ($row = $result->fetch_assoc()) {
            $usuario = new Usuario($row['id'], $row['nombre'], $row['correo'], $row['estado']);
            array_push($usuarios, $usuario);
        }
        //verificar si el array esta vacio
        if (empty($usuarios)) {
            return json_encode(array('erro' => true, 'mensaje' => 'No hay usuarios', 'valor' => '', 'datos' => ''));
        }

        return json_encode(array('erro' => false, 'mensaje' => '', 'valor' => '', 'datos' => $usuarios));
    }

    public function crearUsuario($usuario)
    {
        // hacer el insert
        $sql = "INSERT INTO usuarios (nombre, correo, estado) VALUES ('" . $usuario->nombre . "', '" . $usuario->correo . "', '" . $usuario->estado . "')";
    }

    public function actualizarUsuario($usuario)
    {
        // Implementación para actualizar un usuario en la base de datos
    }

    public function eliminarUsuario($id)
    {
        // Implementación para eliminar un usuario de la base de datos
    }
}
?>