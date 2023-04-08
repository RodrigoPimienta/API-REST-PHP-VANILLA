<?php
require_once('../models/conexion.php');

require_once '../models/usuarios.php';
require_once '../classes/usuarios.php';

$conexion = new Conexion();
$db = $conexion->conectar();

// obtener el body de postman
$data = file_get_contents("php://input");
$data = json_decode($data, true);

// si data contiene comando
if (isset($data["comando"])) {
    $comando = $data["comando"];
} else {
    $comando = "";
}

//sacar de la sesion el id del usuario
session_start();
$_SESSION['id_usuario'] = 3;
$_SESSION['correo'] = "rpimienta@ucol.mx";
$_SESSION['nombre'] = "Rodrigo Pimienta";


if (isset($_SESSION['correo'])) {
    $idUsuarioSesion = $_SESSION['id_usuario'];
    $correoSesion = $_SESSION['correo'];
    $nombreSesion = $_SESSION['nombre'];
} else {
    // die("No tienes sesion cerdo, ve y paga tu colegiatura asqueroso");
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($comando) {
            case "getUsuarios":
                // Obtener usuarios
                $usersModel = new UsersModel($db);
                $resultado = $usersModel->getUsuarios();
                echo $resultado;
                break;
            default:
                echo json_encode(array('erro' => true, 'mensaje' => 'Comando no encontrado', 'valor' => '', 'datos' => ''));
                break;
        }
        break;
    case 'POST':
        switch ($comando) {
            case "verificarDatosUsuario":
                // Verificar datos de usuario
                $usuario = new Usuario(0, $nombreSesion, $correoSesion, 1);
                $usersModel = new UsersModel($db);
                $resultado = $usersModel->verificarDatosUsuario($usuario);
                echo $resultado;
                break;
            default:
                echo json_encode(array('erro' => true, 'mensaje' => 'Comando no encontrado', 'valor' => '', 'datos' => ''));
                break;
        }
        break;
    case 'PUT':
        echo "PUT";
        break;
    case 'DELETE':
        switch ($comando) {
            case "eliminarUsuario":
                // Eliminar usuario
                $usuario = new Usuario($idUsuarioSesion, $nombreSesion, $correoSesion, 1);
                $usersModel = new UsersModel($db);
                $resultado = $usersModel->eliminarUsuario($usuario);
                echo $resultado;
                break;
            default:
                break;
        }
        break;
    default:
        echo "default";
        break;
}
?>