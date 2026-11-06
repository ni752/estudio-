<?php
class ConectorPDO {
    public static function conectar() {
        $host = 'localhost';
        $db = 'taller_mecanica';
        $user = 'root';
        $password = ''; 

        try {
            $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>