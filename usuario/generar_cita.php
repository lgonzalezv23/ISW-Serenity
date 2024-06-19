<?php
session_start();
include '../config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Verifica la conexión a la base de datos
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener lista de especialistas
$sql_especialistas = "SELECT id, nombre, apellidos, username FROM especialistas";
$result_especialistas = $conn->query($sql_especialistas);

// Verifica si la consulta fue exitosa
if ($result_especialistas === false) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Especialistas y Horarios</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #87CEFA;
            padding: 20px;
            margin: 0;
        }

        .header {
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
        }

        .especialistas {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .especialistas table {
            width: 100%;
            border-collapse: collapse;
        }

        .especialistas th, .especialistas td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .especialistas th {
            background: #87CEFA;
            color: white;
        }

        .horarios {
            margin-top: 20px;
        }

        .horarios table {
            width: 100%;
            border-collapse: collapse;
        }

        .horarios th, .horarios td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .horarios th {
            background: #ADD8E6;
            color: black;
        }

        .agendar-button {
            background: #32CD32;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .agendar-button:hover {
            background: #228B22;
        }
    </style>
</head>
<body>
    <div class="header">Lista de Especialistas y sus Horarios</div>

    <div class="especialistas">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_especialistas->num_rows > 0): ?>
                    <?php while ($row = $result_especialistas->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="horarios">
                                    <h3>Horarios:</h3>
                                    <?php
                                    // Obtener horarios del especialista que no estén agendados
                                    $especialista_id = $row['id'];
                                    $sql_horarios = "SELECT * FROM horarios WHERE especialista_id = $especialista_id AND agendada = 0";
                                    $result_horarios = $conn->query($sql_horarios);

                                    if ($result_horarios->num_rows > 0): ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Día</th>
                                                    <th>Hora de Inicio</th>
                                                    <th>Hora de Fin</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($horario = $result_horarios->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($horario['dia_semana']); ?></td>
                                                        <td><?php echo htmlspecialchars($horario['hora_inicio']); ?></td>
                                                        <td><?php echo htmlspecialchars($horario['hora_fin']); ?></td>
                                                        <td>
                                                            <form method="POST" action="agendar_cita.php">
                                                                <input type="hidden" name="horario_id" value="<?php echo $horario['id']; ?>">
                                                                <input type="hidden" name="fecha" value="<?php echo date('Y-m-d'); ?>"> <!-- Asigna la fecha de hoy por defecto -->
                                                                <button type="submit" class="agendar-button">Agendar</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p>No hay horarios disponibles.</p>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No se encontraron especialistas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
