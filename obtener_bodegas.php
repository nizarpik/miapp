<?php
require_once "conexion.php";
header('Content-Type: application/json; charset=utf-8');
$res = $conn->query("SELECT id, nombre FROM bodegas ORDER BY nombre");
$rows = [];
while ($r = $res->fetch_assoc()) { $rows[] = $r; }
echo json_encode($rows);
?>
