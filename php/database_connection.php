<?php
// Parámetros de conexión a la base de datos
$host = 'localhost';
$port = '5432';
$dbname = 'system_products_db';
$user = 'postgres';
$password = 'admin1';
try {
    // Crear conexión con PDO usando PostgreSQL
    $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Manejo de error si la conexión falla
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
