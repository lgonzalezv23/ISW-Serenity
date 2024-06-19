<?php
session_start();
include '../config.php';

if (!isset($_SESSION['username']) || $_SESSION['tipo'] != 'especialista') {
    header("Location: login.php");
    exit();
}

$especialista_id = $_SESSION['user_id']; // Asegúrate de que user_id está almacenado en la sesión correctamente

$sql = "SELECT id, dia_semana, hora_inicio, hora_fin FROM horarios WHERE especialista_id = ? ORDER BY FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $especialista_id);
$stmt->execute();
$result = $stmt->get_result();

$horarios = [];
while ($row = $result->fetch_assoc()) {
    $horarios[$row['dia_semana']][] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Horarios</title>
    <style>
        /* Estilos básicos */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #87CEFA;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h3 {
            background-color: #87CEFA;
            color: white;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .btn-eliminar {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<a href="../esp_dashboard.html">Serenity</a>
    <h2>Mis Horarios</h2>
    <?php if (!empty($horarios)): ?>
        <?php foreach ($horarios as $dia => $dia_horarios): ?>
            <h3><?php echo htmlspecialchars($dia); ?></h3>
            <table>
                <thead>
                    <tr>
                        <th>Hora de Inicio</th>
                        <th>Hora de Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dia_horarios as $horario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($horario['hora_inicio']); ?></td>
                            <td><?php echo htmlspecialchars($horario['hora_fin']); ?></td>
                            <td>
                                <form method="POST" action="eliminar_horario.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $horario['id']; ?>">
                                    <input type="submit" value="Eliminar" class="btn-eliminar">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No tienes horarios creados.</p>
    <?php endif; ?>
</body>
</html>
