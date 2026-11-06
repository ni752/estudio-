<?php
class ConectorPDO {
    private static $instancia = null;
    private $conexion;

    private function __construct() {
        $host = 'localhost';
        $dbname = 'taller_mecanica';
        $username = 'root'; // Usuario por defecto en XAMPP/Laragon
        $password = '';     // Contraseña por defecto (vacía)

        try {
            $this->conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public static function obtenerInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new ConectorPDO();
        }
        return self::$instancia;
    }

    public function getConexion() {
        return $this->conexion;
    }
}
?>