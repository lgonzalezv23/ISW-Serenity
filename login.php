<?php
session_start();
include 'config.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['tipo'] = $row['tipo'];
            if ($row['tipo'] == 'usuario') {
                header("Location: user_dashboard.html");
            } else if ($row['tipo'] == 'especialista') {
                header("Location: esp_dashboard.html");
            }
            exit();
        } else {
            $error_message = "Invalid password";
        }
    } else {
        $error_message = "No user found with that username";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #87CEFA;
            overflow: hidden;
        }
        ::selection {
            background: rgba(135, 206, 250, 0.3);
        }
        .container {
            max-width: 440px;
            padding: 0 20px;
            margin: 170px auto;
        }
        .wrapper {
            width: 100%;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0px 4px 10px 1px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 1s forwards;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .wrapper .title {
            height: 90px;
            background: #87CEFA;
            border-radius: 5px 5px 0 0;
            color: #fff;
            font-size: 30px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .wrapper form {
            padding: 30px 25px 25px 25px;
        }
        .wrapper form .row {
            height: 45px;
            margin-bottom: 15px;
            position: relative;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s forwards;
            animation-delay: calc(0.1s * var(--i));
        }
        .wrapper form .row input {
            height: 100%;
            width: 100%;
            outline: none;
            padding-left: 60px;
            border-radius: 5px;
            border: 1px solid lightgrey;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        form .row input:focus {
            border-color: #87CEFA;
            box-shadow: inset 0px 0px 2px 2px rgba(135, 206, 250, 0.25);
        }
        form .row input::placeholder {
            color: #999;
        }
        .wrapper form .row i {
            position: absolute;
            width: 47px;
            height: 100%;
            color: #fff;
            font-size: 18px;
            background: #87CEFA;
            border: 1px solid #87CEFA;
            border-radius: 5px 0 0 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .wrapper form .pass {
            margin: -8px 0 20px 0;
        }
        .wrapper form .pass a {
            color: #87CEFA;
            font-size: 17px;
            text-decoration: none;
        }
        .wrapper form .pass a:hover {
            text-decoration: underline;
        }
        .wrapper form .button input {
            color: #fff;
            font-size: 20px;
            font-weight: 500;
            padding-left: 0px;
            background: #87CEFA;
            border: 1px solid #87CEFA;
            cursor: pointer;
        }
        form .button input:hover {
            background: #87B0E0;
        }
        .wrapper form .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 17px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s forwards;
            animation-delay: calc(0.1s * var(--i));
        }
        .wrapper form .signup-link a {
            color: #87CEFA;
            text-decoration: none;
        }
        form .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="title"><span>Iniciar Sesion</span></div>
            <form method="POST" action="">
                <div class="row" style="--i: 1;">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Email or User" required>
                </div>
                <div class="row" style="--i: 2;">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="pass" style="--i: 3;"><a href="#">Olvidaste password?</a></div>
                <div class="row button" style="--i: 4;">
                    <input type="submit" value="Login">
                </div>
                <?php
                if (!empty($error_message)) {
                    echo '<div class="signup-link" style="--i: 5; color: red;">' . $error_message . '</div>';
                }
                ?>
                <div class="signup-link" style="--i: 6;">No tienes cuenta? <a href="signup.php">Signup now</a></div>
                <div class="signup-link" style="--i: 7;">Regresar a <a href="init_dashboard.html">Home Page</a></div>
            </form>
        </div>
    </div>
</body>
</html>
