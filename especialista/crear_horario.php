<?php
session_start();
include '../config.php';

if (!isset($_SESSION['username']) || $_SESSION['tipo'] != 'especialista') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $especialista_id = $_SESSION['user_id'];
    $dia_semana = $_POST['dia_semana'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    // Verificar si el horario ya existe
    $sql_check = "SELECT * FROM horarios WHERE especialista_id = ? AND dia_semana = ? AND hora_inicio = ? AND hora_fin = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("isss", $especialista_id, $dia_semana, $hora_inicio, $hora_fin);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "Ya existe un horario para ese especialista en el mismo día y hora.";
    } else {
        // Insertar nuevo horario
        $sql = "INSERT INTO horarios (especialista_id, dia_semana, hora_inicio, hora_fin) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $especialista_id, $dia_semana, $hora_inicio, $hora_fin);

        if ($stmt->execute()) {
            // Redireccionar para recargar la página
            header("Location: horarios.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $stmt_check->close();
    $conn->close();
}
?>