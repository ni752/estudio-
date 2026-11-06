<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Vehículos - Taller</title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h2>
    <a href="cerrarSesion.php">Cerrar Sesión</a>
    <hr>

    <h3>Lista de Vehículos</h3>
    <label>Filtrar por estado:</label>
    <select id="filtro-estado">
        <option value="">Todos</option>
        <option value="En mantenimiento">En mantenimiento</option>
        <option value="reparado">Reparado</option>
    </select>

    <table id="tabla-vehiculos" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Ingreso</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script src="js/vehiculos.js"></script>
</body>
</html>