<?php
require_once "conexion.php";

// Recoger datos
$codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$bodega = isset($_POST['bodega']) ? (int)$_POST['bodega'] : 0;
$sucursal = isset($_POST['sucursal']) ? (int)$_POST['sucursal'] : 0;
$moneda = isset($_POST['moneda']) ? (int)$_POST['moneda'] : 0;
$precio = isset($_POST['precio']) ? trim($_POST['precio']) : '';
$materiales = isset($_POST['material']) ? (array)$_POST['material'] : [];
$descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';

// Validaciones servidor (refuerzo)
if ($codigo === '') { exit("El código del producto no puede estar en blanco."); }
if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$/', $codigo)) {
    exit("El código del producto debe contener letras y números y tener entre 5 y 15 caracteres.");
}

if ($nombre === '') { exit("El nombre del producto no puede estar en blanco."); }
if (mb_strlen($nombre) < 2 || mb_strlen($nombre) > 50) {
    exit("El nombre del producto debe tener entre 2 y 50 caracteres.");
}

if ($bodega <= 0) { exit("Debe seleccionar una bodega."); }
if ($sucursal <= 0) { exit("Debe seleccionar una sucursal para la bodega seleccionada."); }
if ($moneda <= 0) { exit("Debe seleccionar una moneda para el producto."); }

if ($precio === '') { exit("El precio del producto no puede estar en blanco."); }
if (!preg_match('/^(?:0|[1-9]\d*)(?:\.\d{1,2})?$/', $precio)) {
    exit("El precio del producto debe ser un número positivo con hasta dos decimales.");
}

if (count($materiales) < 2) { exit("Debe seleccionar al menos dos materiales para el producto."); }

if ($descripcion === '') { exit("La descripción del producto no puede estar en blanco."); }
$lenDesc = mb_strlen($descripcion);
if ($lenDesc < 10 || $lenDesc > 1000) {
    exit("La descripción del producto debe tener entre 10 y 1000 caracteres.");
}

// Verificar unicidad de código
$stmt = $conn->prepare("SELECT 1 FROM productos WHERE codigo = ? LIMIT 1");
$stmt->bind_param("s", $codigo);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    exit("El código del producto ya está registrado.");
}
$stmt->close();

// Insert
$mats = implode(", ", array_map(fn($m) => substr(strip_tags($m), 0, 20), $materiales));
$precioNum = number_format((float)$precio, 2, '.', '');

$stmt = $conn->prepare("INSERT INTO productos (codigo, nombre, bodega_id, sucursal_id, moneda_id, precio, materiales, descripcion)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiiidss", $codigo, $nombre, $bodega, $sucursal, $moneda, $precioNum, $mats, $descripcion);

try {
    $stmt->execute();
    echo "Producto guardado con éxito.";
} catch (Exception $e) {
    http_response_code(500);
    echo "Error al guardar: " . $e->getMessage();
} finally {
    $stmt->close();
    $conn->close();
}
?>
