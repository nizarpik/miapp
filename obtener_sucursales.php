<?php
require_once "conexion.php";
header('Content-Type: application/json; charset=utf-8');
$bodega_id = isset($_GET['bodega_id']) ? (int)$_GET['bodega_id'] : 0;
if ($bodega_id <= 0) { echo json_encode([]); exit; }
$stmt = $conn->prepare("SELECT id, nombre FROM sucursales WHERE bodega_id = ? ORDER BY nombre");
$stmt->bind_param("i", $bodega_id);
$stmt->execute();
$res = $stmt->get_result();
$rows = [];
while ($r = $res->fetch_assoc()) { $rows[] = $r; }
echo json_encode($rows);
?>
