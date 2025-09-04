<?php
// Ajusta estos valores a tu instalación local
$host = "localhost";
$user = "root";
$pass = ""; // En XAMPP por defecto está vacío
$db   = "miapp";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    http_response_code(500);
    die("Error de conexión a MySQL: " . $e->getMessage());
}
?>
