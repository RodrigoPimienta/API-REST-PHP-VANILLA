<?php

class UsersModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getUsuarios(): string
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
    public function getUsuariosByCorreo($usuario): string
    {
        // Implementación para obtener usuarios de la base de datos
        $sql = "SELECT * FROM usuarios WHERE correo = '{$usuario->correo}'";
        $result = $this->db->query($sql);

        //verificar si result es falso
        if (!$result) {
            return json_encode(array('erro' => true, 'mensaje' => 'Error en la consulta', 'valor' => '1', 'datos' => ''));
        }

        $usuarios = array();
        while ($row = $result->fetch_assoc()) {
            $usuario = new Usuario($row['id'], $row['nombre'], $row['correo'], $row['estado']);
            array_push($usuarios, $usuario);
        }
        //verificar si el array esta vacio
        if (empty($usuarios)) {
            return json_encode(array('erro' => false, 'mensaje' => 'No hay usuario', 'valor' => '2', 'datos' => ''));
        }

        return json_encode(array('erro' => false, 'mensaje' => 'Si hay usuario', 'valor' => '1', 'datos' => $usuarios));

    }


    public function crearUsuario($usuario)
    {
        // hacer el insert
        $sql = "INSERT INTO usuarios (nombre, correo, estado) VALUES ('{$usuario->nombre}', '{$usuario->correo}', {$usuario->estado})";
        $result = $this->db->query($sql);

        //verificar si result es falso
        if (!$result) {
            return json_encode(array('erro' => true, 'mensaje' => 'Error en la consulta', 'valor' => '', 'datos' => ''));
        }

        //obtener el id del usuario insertado
        $usuario->id = $this->db->insert_id;
        return json_encode(array('erro' => false, 'mensaje' => 'Usuario Creado', 'valor' => '', 'datos' => $usuario));
    }

    public function actualizarUsuario($usuario): string
    {
        // Implementación para actualizar un usuario en la base de datos
        //dado el id del usuario, actualizar el nombre y el correo
        $sql = "UPDATE usuarios SET nombre = '{$usuario->nombre}', correo = '{$usuario->correo}' WHERE id = {$usuario->id}";
        $result = $this->db->query($sql);

        //verificar si result es falso
        if (!$result) {
            return json_encode(array('erro' => true, 'mensaje' => 'Error en la consulta', 'valor' => '', 'datos' => ''));
        }

        return json_encode(array('erro' => false, 'mensaje' => 'El usuario se actualizo', 'valor' => '', 'datos' => ''));
    }

    public function eliminarUsuario($usuario): string
    {
        // Implementación para eliminar un usuario de la base de datos
        $sql = "DELETE FROM usuarios WHERE id = {$usuario->id}";
        $result = $this->db->query($sql);

        //verificar si result es falso
        if (!$result) {
            return json_encode(array('erro' => true, 'mensaje' => 'Error en la consulta', 'valor' => '', 'datos' => ''));
        }

        return json_encode(array('erro' => false, 'mensaje' => 'El usuario se elimino', 'valor' => '', 'datos' => ''));
    }

    public function verificarDatosUsuario($usuario): string
    {
        //consultar a la function getUsuariosByCorreo
        $resultado = $this->getUsuariosByCorreo($usuario);

        //  Verificar si el resultado es un error
        if (json_decode($resultado)->erro) {
            return $resultado;
        }

        $usuario->id = json_decode($resultado)->datos[0]->id;

        //verificar si valor es 1
        if (json_decode($resultado)->valor == '1') {
            //return json_encode(array('erro' => true, 'mensaje' => 'El correo ya existe', 'valor' => '1', 'datos' => ''));

            //verificar si el nombre es igual al nombre del usuario
            if (json_decode($resultado)->datos[0]->nombre == $usuario->nombre) {
                return json_encode(array('erro' => false, 'mensaje' => 'El usuario tiene sus datos actualizados', 'valor' => '1', 'datos' => $usuario->id));
            }

            //El nombre no es igual al nombre del usuario
            //mandar llamar la funcion actualizarUsuario
            $resultado2 = $this->actualizarUsuario($usuario);

            //verificar si el resultado es un error
            if (json_decode($resultado2)->erro) {
                return $resultado2;
            }

            return json_encode(array('erro' => false, 'mensaje' => 'El usuario se actualizo', 'valor' => '', 'datos' => $usuario->id));
        }

        //verificar si valor es 2
        if (json_decode($resultado)->valor == '2') {
            //return json_encode(array('erro' => false, 'mensaje' => 'El correo no existe', 'valor' => '2', 'datos' => ''));
            //mandar llamar la funcion crearUsuario
            $resultado = $this->crearUsuario($usuario);

            //verificar si el resultado es un error
            if (json_decode($resultado)->erro) {
                return $resultado;
            }

            return json_encode(array('erro' => false, 'mensaje' => 'El usuario se creo', 'valor' => '', 'datos' => json_decode($resultado)->datos->id));

        }

        return json_encode(array('erro' => true, 'mensaje' => 'Error en la consulta', 'valor' => '', 'datos' => ''));

    }
}
?>