<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $tipo = $_POST['tipo'];
    $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : null;

    if ($password != $confirm_password) {
        echo "Las contraseñas no coinciden";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($tipo == "especialista" && $cedula) {
        $sql = "INSERT INTO especialistas (nombre, apellidos, fecha_nacimiento, username, password, tipo, cedula) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $nombre, $apellidos, $fecha_nacimiento, $username, $hashed_password, $tipo, $cedula);
    } else {
        $sql = "INSERT INTO users (nombre, apellidos, fecha_nacimiento, username, password, tipo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $nombre, $apellidos, $fecha_nacimiento, $username, $hashed_password, $tipo);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Cuenta creada'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
