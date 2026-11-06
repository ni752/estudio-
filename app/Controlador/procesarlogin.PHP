<?php
session_start();
require_once __DIR__ . '/../modelo/ConectorPDO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $clave = $_POST['clave'] ?? '';

    $db = ConectorPDO::obtenerInstancia()->getConexion();
    
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
    $stmt->execute([':usuario' => $usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($clave, $user['clave'])) {
        $_SESSION['usuario'] = $user['usuario'];
        // Redirigir al panel principal del taller
        header('Location: ../../public/index.html');
        exit();
    } else {
        echo "Usuario o contraseña incorrectos. <a href='../../public/login.html'>Volver</a>";
    }
}
?>