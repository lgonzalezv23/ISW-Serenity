<?php
session_start();
include '../../config.php';

if (!isset($_SESSION['username']) || $_SESSION['tipo'] != 'usuario') {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['user_id'];

// Obtener los últimos 10 seguimientos
$sql = "SELECT * FROM seguimientos WHERE usuario_id = ? ORDER BY fecha DESC LIMIT 10";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$seguimientos = [];
while ($row = $result->fetch_assoc()) {
    $seguimientos[] = $row;
}

$stmt->close();

// Calcular el promedio de los seguimientos
$total_seguimientos = count($seguimientos);
if ($total_seguimientos > 0) {
    $sum_estado_animo = 0;
    $sum_calidad_sueno = 0;
    $sum_nivel_estres = 0;
    $sum_nivel_energia = 0;
    $sum_ansiedad_depresion = 0;
    $sum_concentracion = 0;

    foreach ($seguimientos as $seguimiento) {
        $sum_estado_animo += $seguimiento['estado_animo'];
        $sum_calidad_sueno += $seguimiento['calidad_sueno'];
        $sum_nivel_estres += $seguimiento['nivel_estres'];
        $sum_nivel_energia += $seguimiento['nivel_energia'];
        $sum_ansiedad_depresion += $seguimiento['ansiedad_depresion'];
        $sum_concentracion += $seguimiento['concentracion'];
    }

    $prom_estado_animo = $sum_estado_animo / $total_seguimientos;
    $prom_calidad_sueno = $sum_calidad_sueno / $total_seguimientos;
    $prom_nivel_estres = $sum_nivel_estres / $total_seguimientos;
    $prom_nivel_energia = $sum_nivel_energia / $total_seguimientos;
    $prom_ansiedad_depresion = $sum_ansiedad_depresion / $total_seguimientos;
    $prom_concentracion = $sum_concentracion / $total_seguimientos;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de Progreso</title>
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
        }

        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 500px;
            padding: 20px;
            text-align: center;
        }

        .title {
            font-size: 24px;
            font-weight: 700;
            color: #87CEFA;
            margin-bottom: 20px;
        }

        .results {
            text-align: left;
            margin-top: 20px;
        }

        .result-item {
            margin-bottom: 10px;
        }

        .result-item span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Análisis de Progreso</div>
        <div class="results">
            <div class="result-item">
                <span>Estado de Ánimo Promedio:</span> <?php echo round($prom_estado_animo, 2); ?>
            </div>
            <div class="result-item">
                <span>Calidad del Sueño Promedio:</span> <?php echo round($prom_calidad_sueno, 2); ?>
            </div>
            <div class="result-item">
                <span>Nivel de Estrés Promedio:</span> <?php echo round($prom_nivel_estres, 2); ?>
            </div>
            <div class="result-item">
                <span>Nivel de Energía Promedio:</span> <?php echo round($prom_nivel_energia, 2); ?>
            </div>
            <div class="result-item">
                <span>Ansiedad/Depresión Promedio:</span> <?php echo round($prom_ansiedad_depresion, 2); ?>
            </div>
            <div class="result-item">
                <span>Capacidad de Concentración Promedio:</span> <?php echo round($prom_concentracion, 2); ?>
            </div>
        </div>
    </div>
</body>
</html>
