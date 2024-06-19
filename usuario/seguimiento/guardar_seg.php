<?php
session_start();
include '../../config.php';

if (!isset($_SESSION['username']) || $_SESSION['tipo'] != 'usuario') {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['user_id'];
$fecha = date('Y-m-d');
$estado_animo = $_POST['estado_animo'];
$calidad_sueno = $_POST['calidad_sueno'];
$nivel_estres = $_POST['nivel_estres'];
$nivel_energia = $_POST['nivel_energia'];
$ansiedad_depresion = $_POST['ansiedad_depresion'];
$concentracion = $_POST['concentracion'];

$sql = "INSERT INTO seguimientos (usuario_id, fecha, estado_animo, calidad_sueno, nivel_estres, nivel_energia, ansiedad_depresion, concentracion)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isiiiiii", $usuario_id, $fecha, $estado_animo, $calidad_sueno, $nivel_estres, $nivel_energia, $ansiedad_depresion, $concentracion);

if ($stmt->execute()) {
    header("Location: seguimiento_exito.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
