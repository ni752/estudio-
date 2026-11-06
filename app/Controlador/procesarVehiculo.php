<?php
require_once __DIR__ . '/../modelo/ConectorPDO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'guardar') {
        $id = $_POST['id'] ?? null;
        $modelo = $_POST['modelo'] ?? '';
        $marca = $_POST['marca'] ?? '';
        $anio = $_POST['anio'] ?? '';
        $fecha_ingreso = $_POST['fecha_ingreso'] ?? '';
        $estado = $_POST['estado'] ?? 'En mantenimiento';

        $dbInstance = ConectorPDO::obtenerInstancia();
        $db = $dbInstance->getConexion();

        if (empty($id)) {
            $sql = "INSERT INTO vehiculos (modelo, marca, anio, fecha_ingreso, estado) VALUES (:modelo, :marca, :anio, :fecha_ingreso, :estado)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':modelo' => $modelo,
                ':marca' => $marca,
                ':anio' => $anio,
                ':fecha_ingreso' => $fecha_ingreso,
                ':estado' => $estado
            ]);
        } else {
            $sql = "UPDATE vehiculos SET modelo = :modelo, marca = :marca, anio = :anio, fecha_ingreso = :fecha_ingreso, estado = :estado WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':modelo' => $modelo,
                ':marca' => $marca,
                ':anio' => $anio,
                ':fecha_ingreso' => $fecha_ingreso,
                ':estado' => $estado,
                ':id' => $id
            ]);
        }

        header('Location: ../../public/index.html');
        exit();
    }
}
?>