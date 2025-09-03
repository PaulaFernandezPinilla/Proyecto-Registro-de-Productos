<?php
// Conexión a la base de datos
require 'database_connection.php';
header('Content-Type: application/json');
// Validar que se haya recibido una bodega
if (!isset($_GET['store_id'])) {
    http_response_code(400); // error del cliente
    echo json_encode(['error' => 'Bodega requerida']);
    exit;
}
$store_id = $_GET['store_id'];
try {
    // Preparar la consulta SQL
    $estado = $conexion->prepare("SELECT id, name_branch FROM branch WHERE store_id = :id ORDER BY name_branch ASC");

    // Ejecutar la consulta con el parámetro
    $estado->execute(['id' => $store_id]);

    // Obtener resultados y devolverlos como JSON
    $sucursales = $estado->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($sucursales);
} catch (PDOException $e) {
    http_response_code(500); // error del servidor
    echo json_encode([
        'error' => 'Error de base de datos',
        'detalles' => $e->getMessage()
    ]);
}
