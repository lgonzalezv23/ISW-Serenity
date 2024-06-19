<?php
session_start();
include '../config.php';

if (!isset($_SESSION['username']) || $_SESSION['tipo'] != 'especialista') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM horarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redireccionar de vuelta a la página de consulta de horarios
        header("Location: consultar_horarios.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
