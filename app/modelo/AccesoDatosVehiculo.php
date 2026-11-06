<?php
require_once __DIR__ . '/ConectorPDO.php';

class AccesoDatosVehiculo {

    public static function obtenerVehiculos($estado = null) {
        $conexion = ConectorPDO::conectar();
        if ($estado) {
            $sql = "SELECT * FROM vehiculos WHERE estado = :estado";
            $stmt = $conexion->prepare($sql);
            $stmt->execute(['estado' => $estado]);
        } else {
            $sql = "SELECT * FROM vehiculos";
            $stmt = $conexion->query($sql);
        }
        return $stmt->fetchAll();
    }

    public static function obtenerVehiculoPorId($id) {
        $conexion = ConectorPDO::conectar();
        $sql = "SELECT * FROM vehiculos WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function crearVehiculo($modelo, $marca, $anio, $fecha_ingreso, $fecha_salida, $estado) {
        $conexion = ConectorPDO::conectar();
        $sql = "INSERT INTO vehiculos (modelo, marca, anio, fecha_ingreso, fecha_salida, estado) 
                VALUES (:modelo, :marca, :anio, :fecha_ingreso, :fecha_salida, :estado)";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute([
            'modelo' => $modelo,
            'marca' => $marca,
            'anio' => $anio,
            'fecha_ingreso' => $fecha_ingreso,
            'fecha_salida' => $fecha_salida,
            'estado' => $estado
        ]);
    }

    public static function actualizarVehiculoCompleto($id, $modelo, $marca, $anio, $fecha_ingreso, $fecha_salida, $estado) {
        $conexion = ConectorPDO::conectar();
        $sql = "UPDATE vehiculos SET modelo = :modelo, marca = :marca, anio = :anio, 
                fecha_ingreso = :fecha_ingreso, fecha_salida = :fecha_salida, estado = :estado 
                WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'modelo' => $modelo,
            'marca' => $marca,
            'anio' => $anio,
            'fecha_ingreso' => $fecha_ingreso,
            'fecha_salida' => $fecha_salida,
            'estado' => $estado
        ]);
    }

    public static function actualizarEstadoVehiculo($id, $estado) {
        $conexion = ConectorPDO::conectar();
        $sql = "UPDATE vehiculos SET estado = :estado WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'estado' => $estado
        ]);
    }

    public static function eliminarVehiculo($id) {
        $conexion = ConectorPDO::conectar();
        $sql = "DELETE FROM vehiculos WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>