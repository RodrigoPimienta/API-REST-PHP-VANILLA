<?php
require_once('../models/conexion.php');

require_once '../models/usuarios.php';
require_once '../classes/usuarios.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $conexion = new Conexion();
        $db = $conexion->conectar();
        // Obtener usuarios
        $usersModel = new UsersModel($db);
        $resultado = $usersModel->getUsuarios();
        echo $resultado;
        break;
    case 'POST':
        echo "POST";
        // // Crear usuario
        // $usuario = new Usuario(null, $_POST['nombre'], $_POST['correo'], $_POST['estado']);
        // //pasarle la conexion
        // $usersModel = new UsersModel($db);
        // $usersModel->crearUsuario($usuario);
        // echo json_encode($usuario);
        break;
    case 'PUT':
        echo "PUT";
        // // Actualizar usuario
        // $_PUT = json_decode(file_get_contents('php://input'), true);
        // $usuario = new Usuario($_PUT['id'], $_PUT['nombre'], $_PUT['correo'], $_PUT['estado']);
        // $usersModel->actualizarUsuario($usuario);
        // echo json_encode($usuario);
        break;
    case 'DELETE':
        echo "DELETE";
        // // Eliminar usuario
        // $_DELETE = json_decode(file_get_contents('php://input'), true);
        // $usersModel->eliminarUsuario($_DELETE['id']);
        // echo json_encode(array('mensaje' => 'Usuario eliminado'));
        break;
    default:
        echo "default";
        break;
}
?>