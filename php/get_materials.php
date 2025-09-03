<?php
// Conexion a la base de datos
require 'database_connection.php';
header('Content-Type: application/json');

try {
   //  Obtener materiales
 $estado = $conexion->query("SELECT id, name_materials FROM materials ORDER BY name_materials ASC");
     //Resultados de la consulta
 $materials = $estado->fetchAll(PDO::FETCH_ASSOC);

   // json de respuesta
 echo json_encode($materials);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error de base de datos',
        'detalles' => $e->getMessage()
    ]);
}