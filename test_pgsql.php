<?php
$conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=admin1");

if ($conn) {
    echo "Conexión exitosa a PostgreSQL";
} else {
    echo "Error en la conexión a PostgreSQL";
}
?>
