<?php
session_start();
include '../../config.php';

if (!isset($_SESSION['username']) || $_SESSION['tipo'] != 'usuario') {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['user_id'];

// Obtener todos los seguimientos
$sql = "SELECT * FROM seguimientos WHERE usuario_id = ? ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$seguimientos = [];
while ($row = $result->fetch_assoc()) {
    $seguimientos[] = $row;
}

$stmt->close();

$promedios = [];
$acumulados = [
    'estado_animo' => 0,
    'calidad_sueno' => 0,
    'nivel_estres' => 0,
    'nivel_energia' => 0,
    'ansiedad_depresion' => 0,
    'concentracion' => 0
];
$total_seguimientos = count($seguimientos);

for ($i = 0; $i < $total_seguimientos; $i++) {
    $acumulados['estado_animo'] += $seguimientos[$i]['estado_animo'];
    $acumulados['calidad_sueno'] += $seguimientos[$i]['calidad_sueno'];
    $acumulados['nivel_estres'] += $seguimientos[$i]['nivel_estres'];
    $acumulados['nivel_energia'] += $seguimientos[$i]['nivel_energia'];
    $acumulados['ansiedad_depresion'] += $seguimientos[$i]['ansiedad_depresion'];
    $acumulados['concentracion'] += $seguimientos[$i]['concentracion'];

    if (($i + 1) % 3 == 0 || $i == $total_seguimientos - 1) {
        $segment_promedios = [
            'estado_animo' => round($acumulados['estado_animo'] / ($i + 1), 2),
            'calidad_sueno' => round($acumulados['calidad_sueno'] / ($i + 1), 2),
            'nivel_estres' => round($acumulados['nivel_estres'] / ($i + 1), 2),
            'nivel_energia' => round($acumulados['nivel_energia'] / ($i + 1), 2),
            'ansiedad_depresion' => round($acumulados['ansiedad_depresion'] / ($i + 1), 2),
            'concentracion' => round($acumulados['concentracion'] / ($i + 1), 2)
        ];
        $promedios[] = $segment_promedios;
    }
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
            background: #f0f2f5;
            padding: 20px;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .header {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 24px;
            font-weight: 700;
            color: #4a90e2;
        }

        .header a {
            color: #4a90e2;
            text-decoration: none;
        }

        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            color: #4a90e2;
            margin-bottom: 20px;
        }

        canvas {
            margin-top: 20px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="header">
        <a href="../../user_dashboard.html">Serenity</a>
    </div>
    <div class="title">Análisis de Progreso</div>
    <?php foreach ($promedios as $index => $prom): ?>
        <div class="container">
            <canvas id="progresoChart<?php echo $index; ?>"></canvas>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('progresoChart<?php echo $index; ?>').getContext('2d');
                new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: ['Estado de Ánimo', 'Calidad del Sueño', 'Nivel de Estrés', 'Nivel de Energía', 'Ansiedad/Depresión', 'Concentración'],
                        datasets: [{
                            label: 'Promedios acumulados',
                            data: [
                                <?php echo htmlspecialchars($prom['estado_animo']); ?>,
                                <?php echo htmlspecialchars($prom['calidad_sueno']); ?>,
                                <?php echo htmlspecialchars($prom['nivel_estres']); ?>,
                                <?php echo htmlspecialchars($prom['nivel_energia']); ?>,
                                <?php echo htmlspecialchars($prom['ansiedad_depresion']); ?>,
                                <?php echo htmlspecialchars($prom['concentracion']); ?>
                            ],
                            backgroundColor: 'rgba(74, 144, 226, 0.2)',
                            borderColor: 'rgba(74, 144, 226, 1)',
                            borderWidth: 3,
                            pointBackgroundColor: 'rgba(74, 144, 226, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(74, 144, 226, 1)'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            r: {
                                angleLines: {
                                    display: true,
                                    color: '#dfe3e6',
                                    lineWidth: 2
                                },
                                grid: {
                                    color: '#dfe3e6',
                                    lineWidth: 1.5
                                },
                                pointLabels: {
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    color: '#4a4a4a'
                                },
                                ticks: {
                                    backdropColor: '#f0f2f5',
                                    font: {
                                        size: 12
                                    },
                                    color: '#4a4a4a'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    color: '#4a4a4a',
                                    font: {
                                        size: 16
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.dataset.label}: ${context.parsed.r}`;
                                    }
                                },
                                backgroundColor: '#4a90e2',
                                titleFont: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 14
                                },
                                borderColor: '#fff',
                                borderWidth: 1
                            }
                        }
                    }
                });
            });
        </script>
    <?php endforeach; ?>
</body>
</html>
