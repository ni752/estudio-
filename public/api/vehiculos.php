<?php
require_once __DIR__ . '/../../app/modelo/ConectorPDO.php';

header("Content-Type: application/json; charset=UTF-8");
$metodo = $_SERVER['REQUEST_METHOD'];
$conexion = ConectorPDO::conectar();

// Obtener la ruta o ID si existe (ej: /api/vehiculos.php/1)
$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
$segmentos = explode('/', trim($path_info, '/'));
$id = !empty($segmentos[0]) ? $segmentos[0] : null;

switch ($metodo) {
    case 'GET':
        if ($id) {
            $stmt = $conexion->prepare("SELECT * FROM vehiculos WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $estado = $_GET['estado'] ?? '';
            if ($estado) {
                $stmt = $conexion->prepare("SELECT * FROM vehiculos WHERE estado = ?");
                $stmt->execute([$estado]);
            } else {
                $stmt = $conexion->query("SELECT * FROM vehiculos");
            }
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['marca']) && !empty($data['modelo']) && !empty($data['anio'])) {
            $stmt = $conexion->prepare("INSERT INTO vehiculos (marca, modelo, anio, fecha_ingreso, fecha_salida, estado) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['marca'],
                $data['modelo'],
                $data['anio'],
                $data['fecha_ingreso'] ?? date('Y-m-d'),
                $data['fecha_salida'] ?? null,
                $data['estado'] ?? 'En mantenimiento'
            ]);
            http_response_code(201);
            echo json_encode(["mensaje" => "Vehículo creado con éxito"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos obligatorios"]);
        }
        break;

    case 'PATCH':
        if ($id) {
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data['estado'])) {
                $stmt = $conexion->prepare("UPDATE vehiculos SET estado = ? WHERE id = ?");
                $stmt->execute([$data['estado'], $id]);
                echo json_encode(["mensaje" => "Estado actualizado"]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Estado no especificado"]);
            }
        }
        break;

    case 'DELETE':
        if ($id) {
            $stmt = $conexion->prepare("DELETE FROM vehiculos WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(["mensaje" => "Vehículo eliminado"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>