<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title> 
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #87CEFA;
            overflow: hidden;
        }
        .wrapper {
            position: relative;
            max-width: 430px;
            width: 100%;
            background: #fff;
            padding: 34px;
            border-radius: 6px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
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
        .wrapper h2 {
            position: relative;
            font-size: 22px;
            font-weight: 600;
            color: #333;
        }
        .wrapper h2::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 28px;
            border-radius: 12px;
            background: #87CEFA;
        }
        .wrapper form {
            margin-top: 30px;
        }
        .wrapper form .input-box {
            height: 52px;
            margin: 18px 0;
            position: relative;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s forwards;
            animation-delay: calc(0.1s * var(--i));
        }
        form .input-box input, form .input-box select {
            height: 100%;
            width: 100%;
            outline: none;
            padding: 0 15px;
            font-size: 17px;
            font-weight: 400;
            color: #333;
            border: 1.5px solid #C7BEBE;
            border-bottom-width: 2.5px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .input-box input:focus,
        .input-box input:valid,
        .input-box select:focus,
        .input-box select:valid {
            border-color: #87CEFA;
        }
        .input-box select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        form .policy {
            display: flex;
            align-items: center;
        }
        form h3 {
            color: #707070;
            font-size: 14px;
            font-weight: 500;
            margin-left: 10px;
        }
        .input-box.button input {
            color: #fff;
            letter-spacing: 1px;
            border: none;
            background: #87CEFA;
            cursor: pointer;
        }
        .input-box.button input:hover {
            background: #6ba7cf;
        }
        form .text h3 {
            color: #333;
            width: 100%;
            text-align: center;
        }
        form .text h3 a {
            color: #87CEFA;
            text-decoration: none;
        }
        form .text h3 a:hover {
            text-decoration: underline;
        }
        #btn2 {
            background: #87CEFA;
            color: white;
            border-radius: 4px;
            border: none;
            margin-top: 20px;
            margin-bottom: 20px;
            font-weight: 800;
            font-size: 0.8em;
            cursor: pointer;
            text-align: center;
            padding: 10px;
            display: block;
            width: 100%;
        }
        #btn2:hover {
            background: #6ba7cf;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Registration</h2>
        <form method="POST" action="register.php">
            <div class="input-box" style="--i: 1;">
                <input type="text" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="input-box" style="--i: 2;">
                <input type="text" name="apellidos" placeholder="Apellidos" required>
            </div>
            <div class="input-box" style="--i: 3;">
                <input type="date" name="fecha_nacimiento" required>
            </div>
            <div class="input-box" style="--i: 4;">
                <input type="text" name="username" placeholder="Correo o Nombre de Usuario" required>
            </div>
            <div class="input-box" style="--i: 5;">
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <div class="input-box" style="--i: 6;">
                <input type="password" name="confirm_password" placeholder="Confirmar Contraseña" required>
            </div>
            <div class="input-box" style="--i: 7;">
                <select name="tipo" required>
                    <option value="" disabled selected>Seleccionar tipo</option>
                    <option value="usuario">Usuario</option>
                    <option value="especialista">Especialista</option>
                </select>
            </div>
            <div class="input-box button" style="--i: 8;">
                <input type="submit" value="Crear Cuenta">
            </div>
            <div class="text" style="--i: 9;">
                <h3>Already have an account? <a href="login.php">Login now</a></h3>
            </div>
        </form>
    </div>
</body>
</html>
