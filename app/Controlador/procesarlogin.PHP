<?php
session_start();
require_once __DIR__ . '/../modelo/ConectorPDO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($usuario) && !empty($password)) {
        $conexion = ConectorPDO::conectar();
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $stmt = $conexion->prepare($sql);
        $stmt->execute(['usuario' => $usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['id_usuario'] = $user['id'];
            
            header("Location: /Taller-Mecanica/public/gestionvehiculos.php");
            exit();
        } else {
            header("Location: /Taller-Mecanica/public/login.html?error=Credenciales incorrectas");
            exit();
        }
    } else {
        header("Location: /Taller-Mecanica/public/login.html?error=Campos vacios");
        exit();
    }
}
?>