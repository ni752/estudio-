<?php
require_once __DIR__ . '/../../app/modelo/ConectorPDO.php';

header('Content-Type: application/json');
$db = ConectorPDO::obtenerInstancia()->getConexion();

$estadoFiltro = $_GET['estado'] ?? '';

if (!empty($estadoFiltro)) {
    $sql = "SELECT * FROM vehiculos WHERE estado = :estado";
    $stmt = $db->prepare($sql);
    $stmt->execute([':estado' => $estadoFiltro]);
} else {
    $sql = "SELECT * FROM vehiculos";
    $stmt = $db->query($sql);
}

$vehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($vehiculos);
?>