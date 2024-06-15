<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$username = $_SESSION['username'];
$sql = "SELECT nombre, apellidos, fecha_nacimiento, username, tipo FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $apellidos = $row['apellidos'];
    $fecha_nacimiento = $row['fecha_nacimiento'];
    $tipo = $row['tipo'];
} else {
    echo "No user found with that username";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Card</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.13.0/devicon.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            height: 100%;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Open Sans', sans-serif;
            width: 100%;
            min-height: 100%;
            background: #87CEFA;
            font-size: 16px;
            overflow: hidden;
        }

        .content {
            position: relative;
            animation: animatop 0.9s cubic-bezier(0.425, 1.140, 0.470, 1.125) forwards;
        }

        .card {
            width: 500px;
            min-height: 100px;
            padding: 20px;
            border-radius: 3px;
            background-color: white;
            box-shadow: 0px 10px 20px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }

        .card::after {
            content: '';
            display: block;
            width: 190px;
            height: 300px;
            background: cadetblue;
            position: absolute;
            animation: rotatemagic 0.75s cubic-bezier(0.425, 1.040, 0.470, 1.105) 1s both;
        }

        .badgescard {
            padding: 10px 20px;
            border-radius: 3px;
            background-color: #ECECEC;
            width: 480px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            position: absolute;
            z-index: -1;
            left: 10px;
            bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: animainfos 0.5s cubic-bezier(0.425, 1.040, 0.470, 1.105) 0.75s forwards;
        }

        .badgescard span {
            font-size: 1.6em;
            margin: 0px 6px;
            opacity: 0.6;
        }

        .firstinfo {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;
            z-index: 2;
            position: relative;
        }

        .firstinfo img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
        }

        .profileinfo {
            padding: 0px 20px;
        }

        .profileinfo h1 {
            font-size: 1.8em;
        }

        .profileinfo h3 {
            font-size: 1.2em;
            color: #009688;
            font-style: italic;
        }

        .bio {
            padding: 10px 0px;
            color: #5A5A5A;
            line-height: 1.2;
        }

        .buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .btn, .btn-home, .btn-appointments {
            width: 125px;
            padding-top: 10px;
            padding-bottom: 10px;
            color: white;
            border-radius: 4px;
            font-weight: 800;
            font-size: 0.8em;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background 0.3s ease-in-out;
        }

        .btn {
            background: #2ecc71;
            border: #27ae60 1px solid;
        }

        .btn:hover {
            background: #2CC06B;
        }

        .btn-home {
            background: #e74c3c;
            border: #c0392b 1px solid;
        }

        .btn-home:hover {
            background: #d62c1a;
        }

        .btn-appointments {
            background: #f39c12;
            border: #e67e22 1px solid;
        }

        .btn-appointments:hover {
            background: #e67e22;
        }

        @keyframes animatop {
            0% {
                opacity: 0;
                bottom: -500px;
            }
            100% {
                opacity: 1;
                bottom: 0px;
            }
        }

        @keyframes animainfos {
            0% {
                bottom: 10px;
            }
            100% {
                bottom: -42px;
            }
        }

        @keyframes rotatemagic {
            0% {
                opacity: 0;
                transform: rotate(0deg);
                top: -24px;
                left: -253px;
            }
            100% {
                transform: rotate(-30deg);
                top: -24px;
                left: -78px;
            }
        }
    </style>
    <script>
        function redirectHome() {
            <?php if ($tipo == 'usuario') { ?>
                window.location.href = 'user_dashboard.html';
            <?php } else if ($tipo == 'especialista') { ?>
                window.location.href = 'esp_dashboard.html';
            <?php } ?>
        }
    </script>
</head>
<body>
    <div class="content">
        <div class="card">
            <div class="firstinfo">
                <img src="https://randomuser.me/api/portraits/lego/6.jpg" alt="Profile Picture">
                <div class="profileinfo">
                    <h1><?php echo htmlspecialchars($nombre . ' ' . $apellidos); ?></h1>
                    <h3><?php echo htmlspecialchars($tipo); ?></h3>
                    <p class="bio">
                        Fecha de Nacimiento: <?php echo htmlspecialchars($fecha_nacimiento); ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="badgescard">
            <span class="devicons devicons-django"></span>
            <span class="devicons devicons-python"></span>
            <span class="devicons devicons-codepen"></span>
            <span class="devicons devicons-javascript_badge"></span>
            <span class="devicons devicons-gulp"></span>
            <span class="devicons devicons-angular"></span>
            <span class="devicons devicons-sass"></span>
        </div>
        <div class="buttons">
            <a href="logout.php" class="btn">Logout</a>
            <div class="btn-home" onclick="redirectHome()">Home</div>
            <a href="appointments.php" class="btn-appointments">Mis Citas</a>
        </div>
    </div>
</body>
</html>
