<?php

include_once '../config.php';

class Conexion
{
    public function conectar()
    {
        // conexion
        try {
            $conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            return $conn;
        } catch (Exception $e) {
            return false;
        }
    }
}

?>