<?php
session_start();
include '../config.php';

if (!isset($_SESSION['username']) || $_SESSION['tipo'] != 'usuario') {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['user_id'];
$horario_id = $_POST['horario_id'];
$fecha = $_POST['fecha'];

// Validar que el horario no esté agendado
$sql_check = "SELECT * FROM horarios WHERE id = ? AND agendada = 0";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $horario_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Insertar la cita
    $sql_insert = "INSERT INTO citas (usuario_id, horario_id, fecha) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iis", $usuario_id, $horario_id, $fecha);

    if ($stmt_insert->execute()) {
        // Marcar el horario como agendado
        $sql_update = "UPDATE horarios SET agendada = 1 WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $horario_id);
        $stmt_update->execute();

        echo "Cita agendada exitosamente.";
    } else {
        echo "Error al agendar la cita.";
    }

    $stmt_insert->close();
    $stmt_update->close();
} else {
    echo "El horario ya está reservado.";
}

$stmt_check->close();
$conn->close();

header("Location: generar_cita.php");
exit();
?>
