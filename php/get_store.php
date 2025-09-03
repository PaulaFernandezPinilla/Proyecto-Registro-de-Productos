<?php
// Conexion a la base de datos
require 'database_connection.php';

header('Content-Type: application/json');

try {
    //Consulta sql usando PDO
 $estado = $conexion->query("SELECT id, name_store FROM store ORDER BY name_store ASC");
    //Resultados de la consulta
 $store = $estado->fetchAll(PDO::FETCH_ASSOC);
    // json de respuesta
    echo json_encode($store);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de base de datos', 'detalles' => $e->getMessage()]);
}