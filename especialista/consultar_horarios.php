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
        body {
            font-family: 'Poppins', sans-serif;
            background: #87CEFA;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            margin: 0;
            overflow: hidden;
            opacity: 0;
            animation: fadeIn 0.5s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
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
            transition: transform 0.3s;
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

        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 1200px;
        }

        .title {
            font-size: 36px;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
            text-transform: uppercase;
            text-align: center;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            width: 100%;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding: 10px;
            justify-content: center;
        }

        .container > .card {
            scroll-snap-align: start;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card h3 {
            background-color: #87CEFA;
            color: white;
            padding: 10px;
            margin: -20px -20px 20px -20px;
            border-radius: 10px 10px 0 0;
            width: 100%;
            text-align: center;
        }

        .horario {
            width: 100%;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .horario:last-child {
            border-bottom: none;
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

        .no-horarios {
            text-align: center;
            color: #555;
            margin-top: 20px;
        }

        .btn-agregar {
            background-color: #6495ED;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn-agregar:hover {
            background-color: #4169E1;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="../esp_dashboard.html">Serenity</a>
    </div>
    <div class="main-container">
        <h2 class="title">Mis Horarios</h2>
        <div class="container">
            <?php if (!empty($horarios)): ?>
                <?php foreach ($horarios as $dia => $dia_horarios): ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($dia); ?></h3>
                        <?php foreach ($dia_horarios as $horario): ?>
                            <div class="horario">
                                <span><?php echo htmlspecialchars($horario['hora_inicio']); ?> - <?php echo htmlspecialchars($horario['hora_fin']); ?></span>
                                <form method="POST" action="eliminar_horario.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $horario['id']; ?>">
                                    <input type="submit" value="Eliminar" class="btn-eliminar">
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-horarios">No tienes horarios creados.</p>
            <?php endif; ?>
        </div>
        <a href="horarios.html" class="btn-agregar">Agregar Horario</a>
    </div>
</body>
</html>
