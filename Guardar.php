<?php
require __DIR__ . '/Conexion.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->set_charset('utf8mb4');

$numero_control = trim($_POST['numero_control'] ?? '');
$nombre         = trim($_POST['nombre'] ?? '');
$especialidad   = trim($_POST['especialidad'] ?? '');
$edad           = isset($_POST['edad'])     ? (int)$_POST['edad']     : null;
$promedio       = isset($_POST['promedio']) ? (float)$_POST['promedio'] : null;
$direccion      = trim($_POST['direccion'] ?? '');

if ($numero_control === '' || $nombre === '' || $especialidad === '' || $edad === null || $promedio === null || $direccion === '') {
    http_response_code(422);
    exit('Faltan campos obligatorios.');
}

if (!preg_match('/^\d{14}$/', $numero_control)) {
    http_response_code(422);
    exit('Número de control inválido.');
}

if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/u', $nombre)) {
    http_response_code(422);
    exit('Nombre inválido.');
}

$sql = "INSERT INTO alumnos (numero_control, nombre, especialidad, edad, promedio, direccion)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssids", $numero_control, $nombre, $especialidad, $edad, $promedio, $direccion);
$stmt->execute();
$stmt->close();
$conn->close();

header('Location: index.php');
exit;
?>