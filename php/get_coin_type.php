<?php
// Conexion a la base de datos
require 'database_connection.php';

header('Content-Type: application/json');

try {
    //  obtener las monedas
$estado = $conexion->query("SELECT id, name_coins FROM coins ORDER BY name_coins ASC");
    //Resultados de la consulta
$coins= $estado->fetchAll(PDO::FETCH_ASSOC);
     // json de respuesta
    echo json_encode($coins);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error de base de datos',
        'detalles' => $e->getMessage()
    ]);
}