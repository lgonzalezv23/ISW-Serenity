<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: #3498db;
            margin: 0 auto;
            width: 100%;
            text-align: center;
            margin: 20px 0;
        }

        p {
            font-size: 12px;
            text-decoration: none;
            color: #ffffff;
        }

        h1 {
            font-size: 1.5em;
            color: #525252;
        }

        .box {
            background: white;
            width: 300px;
            border-radius: 6px;
            margin: 0 auto;
            padding: 0px 0px 70px 0px;
            border: #2980b9 4px solid;
        }

        .input {
            background: #ecf0f1;
            border: #ccc 1px solid;
            border-bottom: #ccc 2px solid;
            padding: 8px;
            width: 250px;
            color: #AAAAAA;
            margin-top: 10px;
            font-size: 1em;
            border-radius: 4px;
        }

        .btn {
            background: #2ecc71;
            width: 125px;
            padding-top: 5px;
            padding-bottom: 5px;
            color: white;
            border-radius: 4px;
            border: #27ae60 1px solid;
            margin-top: 20px;
            margin-bottom: 20px;
            float: left;
            margin-left: 16px;
            font-weight: 800;
            font-size: 0.8em;
            cursor: pointer;
        }

        .btn:hover {
            background: #2CC06B;
        }

        #btn2 {
            float: left;
            background: #3498db;
            width: 125px;
            padding-top: 5px;
            padding-bottom: 5px;
            color: white;
            border-radius: 4px;
            border: #2980b9 1px solid;
            margin-top: 20px;
            margin-bottom: 20px;
            margin-left: 10px;
            font-weight: 800;
            font-size: 0.8em;
            cursor: pointer;
        }

        #btn2:hover {
            background: #3594D2;
        }

        .select {
            background: #ecf0f1;
            border: #ccc 1px solid;
            border-bottom: #ccc 2px solid;
            padding: 8px;
            width: 266px;
            color: #AAAAAA;
            margin-top: 10px;
            font-size: 1em;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <form method="POST" action="register.php">
        <div class="box">
            <h1>Sign Up</h1>
            <input type="text" name="nombre" placeholder="Nombre" class="input" required />
            <input type="text" name="apellidos" placeholder="Apellidos" class="input" required />
            <input type="date" name="fecha_nacimiento" class="input" required />
            <input type="text" name="username" placeholder="Correo o Nombre de Usuario" class="input" required />
            <input type="password" name="password" placeholder="Contraseña" class="input" required />
            <input type="password" name="confirm_password" placeholder="Confirmar Contraseña" class="input" required />
            <select name="tipo" class="select" required>
                <option value="" disabled selected>Seleccionar tipo</option>
                <option value="usuario">Usuario</option>
                <option value="especialista">Especialista</option>
            </select>
            <input type="submit" value="Crear Cuenta" class="btn" />
            <div id="btn2" onclick="window.location.href='index2.html'">Home</div> <!-- End Btn2 -->
        </div> <!-- End Box -->
    </form>
</body>
</html>
