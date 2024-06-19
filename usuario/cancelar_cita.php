<?php
session_start();
include '../config.php';

if (!isset($_SESSION['username']) || $_SESSION['tipo'] != 'usuario') {
    header("Location: login.php");
    exit();
}

$cita_id = $_POST['cita_id'];

// Obtener el horario_id de la cita
$sql_cita = "SELECT horario_id FROM citas WHERE id = ?";
$stmt_cita = $conn->prepare($sql_cita);
$stmt_cita->bind_param("i", $cita_id);
$stmt_cita->execute();
$result_cita = $stmt_cita->get_result();

if ($result_cita->num_rows > 0) {
    $row_cita = $result_cita->fetch_assoc();
    $horario_id = $row_cita['horario_id'];

    // Eliminar la cita
    $sql_delete = "DELETE FROM citas WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $cita_id);
    $stmt_delete->execute();

    // Marcar el horario como no agendado
    $sql_update = "UPDATE horarios SET agendada = 0 WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $horario_id);
    $stmt_update->execute();

    echo "Cita cancelada exitosamente.";
} else {
    echo "Error al cancelar la cita.";
}

$stmt_cita->close();
$stmt_delete->close();
$stmt_update->close();
$conn->close();

header("Location: consultar_citas.php");
exit();
?>