<?php
// Conexión a la base de datos
require 'database_connection.php';
// Obtener el código del producto desde la URL, o una cadena vacía si no viene
$codigoProducto = $_GET['code'] ?? '';
// Preparar consulta para buscar si existe ese código en la base de datos
$consulta = $conexion->prepare("SELECT id FROM products WHERE code = :code");
$consulta->execute(['code' => $codigoProducto]);
// Devolver si el producto existe (true/false) en formato JSON
echo json_encode(['exists' => $consulta->rowCount() > 0]);
