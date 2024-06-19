<?php
session_start();
include '../../config.php';

if (!isset($_SESSION['username']) || $_SESSION['tipo'] != 'usuario') {
    header("Location: ../../login.php");
    exit();
}

$usuario_id = $_SESSION['user_id'];

$sql = "SELECT fecha, estado_animo, calidad_sueno, nivel_estres, nivel_energia, ansiedad_depresion, concentracion FROM seguimientos WHERE usuario_id = ? ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$seguimientos = [];
while ($row = $result->fetch_assoc()) {
    $seguimientos[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Seguimiento</title>
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
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1000px;
            padding: 20px;
            text-align: center;
        }

        .title {
            font-size: 24px;
            font-weight: 700;
            color: #87CEFA;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #87CEFA;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="../../user_dashboard.html">Serenity</a>
    </div>
    <div class="container">
        <div class="title">Registros de Seguimiento</div>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Estado de Ánimo</th>
                    <th>Calidad del Sueño</th>
                    <th>Nivel de Estrés</th>
                    <th>Nivel de Energía</th>
                    <th>Ansiedad/Depresión</th>
                    <th>Concentración</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($seguimientos)): ?>
                    <?php foreach ($seguimientos as $seguimiento): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($seguimiento['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($seguimiento['estado_animo']); ?></td>
                            <td><?php echo htmlspecialchars($seguimiento['calidad_sueno']); ?></td>
                            <td><?php echo htmlspecialchars($seguimiento['nivel_estres']); ?></td>
                            <td><?php echo htmlspecialchars($seguimiento['nivel_energia']); ?></td>
                            <td><?php echo htmlspecialchars($seguimiento['ansiedad_depresion']); ?></td>
                            <td><?php echo htmlspecialchars($seguimiento['concentracion']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No hay registros de seguimiento.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
