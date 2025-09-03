<?php
require 'database_connection.php';

//aqui estan las validaciones del servidor
$code = $_POST['code'] ?? '';
$name = $_POST['name'] ?? '';
$store = $_POST['store'] ?? '';
$branch = $_POST['branch'] ?? '';
$coins = $_POST['coins'] ?? '';
$price = $_POST['price'] ?? '';
$description = $_POST['description'] ?? '';
$materials = $_POST['materials'] ?? [];

if (empty($code) || empty($name) || empty($store) || empty($branch) || empty($coins) || empty($price) || empty($description) || count($materials) < 2) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

// Verifico si el código ya existe
$check = $conexion->prepare("SELECT id FROM products WHERE code = :code");
$check->execute(['code' => $code]);
if ($check->rowCount() > 0) {
    echo json_encode(['success' => false, 'message' => 'El código del producto ya está registrado.']);
    exit;
}

// Inserto producto
$consulta = $conexion->prepare("INSERT INTO products (code, name_products, store_id, branch_id,  coins_id, price, description) 
                       VALUES (:code, :name, :store, :branch, :coins, :price, :description)");
$consulta->execute([
    'code' => $code,
    'name' => $name,
    'store' => $store,
    'branch' => $branch,
    'coins' => $coins,
    'price' => $price,
    'description' => $description
]);
$products_id = $conexion->lastInsertId();
// Inserto materiales
foreach ($materials as $mat) {
    $consultaMat = $conexion->prepare("INSERT INTO materials_products (products_id, materials_id) VALUES (:products, :materials)");
    $consultaMat->execute([
        'products' => $products_id,
        'materials' => $mat
    ]);
}

echo json_encode(['success' => true]);