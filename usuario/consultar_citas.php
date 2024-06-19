<?php
session_start();
include '../config.php';

if (!isset($_SESSION['username']) || $_SESSION['tipo'] != 'usuario') {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['user_id'];

// Obtener citas del usuario
$sql_citas = "SELECT c.id, c.fecha, h.dia_semana, h.hora_inicio, h.hora_fin, e.nombre, e.apellidos 
              FROM citas c
              JOIN horarios h ON c.horario_id = h.id
              JOIN especialistas e ON h.especialista_id = e.id
              WHERE c.usuario_id = ?
              ORDER BY c.fecha DESC";
$stmt_citas = $conn->prepare($sql_citas);
$stmt_citas->bind_param("i", $usuario_id);
$stmt_citas->execute();
$result_citas = $stmt_citas->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #87CEFA;
            padding: 20px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            opacity: 0;
            animation: fadeInUp 1s forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header a {
            color: inherit;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: transform 0.3s;
        }

        .header a:hover {
            transform: scale(1.1);
            color: inherit; /* Asegura que el color no cambie */
        }

        .container {
            width: 80%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .titulo {
            font-size: 24px;
            font-weight: 700;
            color: white;
            padding: 20px;
            background: #87CEFA;
            text-align: center;
            margin: 0;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .content {
            padding: 20px;
            width: 100%;
        }

        .citas table {
            width: 100%;
            border-collapse: collapse;
        }

        .citas th, .citas td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .citas th {
            background: #87CEFA;
            color: white;
        }

        .cancelar-button {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .cancelar-button:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="../user_dashboard.html">Serenity</a>
    </div>
    <div class="container">
        <div class="titulo">Mis Citas</div>
        <div class="content">
            <div class="citas">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Día</th>
                            <th>Hora de Inicio</th>
                            <th>Hora de Fin</th>
                            <th>Especialista</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_citas->num_rows > 0): ?>
                            <?php while ($row = $result_citas->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['fecha']); ?></td>
                                    <td><?php echo htmlspecialchars($row['dia_semana']); ?></td>
                                    <td><?php echo htmlspecialchars($row['hora_inicio']); ?></td>
                                    <td><?php echo htmlspecialchars($row['hora_fin']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre'] . " " . $row['apellidos']); ?></td>
                                    <td>
                                        <form method="POST" action="cancelar_cita.php" style="display:inline;">
                                            <input type="hidden" name="cita_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="cancelar-button">Cancelar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No tienes citas agendadas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$stmt_citas->close();
$conn->close();
?>
