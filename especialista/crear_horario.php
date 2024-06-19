<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['tipo'] != 'especialista') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $especialista_id = $_SESSION['user_id'];
    $dia_semana = $_POST['dia_semana'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    $sql = "INSERT INTO horarios (especialista_id, dia_semana, hora_inicio, hora_fin) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $especialista_id, $dia_semana, $hora_inicio, $hora_fin);

    if ($stmt->execute()) {
        echo "Horario creado exitosamente";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
