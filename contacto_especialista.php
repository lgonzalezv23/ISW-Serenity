<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['tipo'] != 'especialista') {
    header("Location: login.php");
    exit();
}

$especialista_id = $_SESSION['user_id'];
$error_message = '';
$success_message = '';

// Verificar si ya existen datos de contacto
$sql = "SELECT correo, telefono FROM contacto_especialista WHERE especialista_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $especialista_id);
$stmt->execute();
$result = $stmt->get_result();
$contacto = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    if ($contacto) {
        // Actualizar datos de contacto
        $sql_update = "UPDATE contacto_especialista SET correo = ?, telefono = ? WHERE especialista_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssi", $correo, $telefono, $especialista_id);

        if ($stmt_update->execute()) {
            $success_message = "Información de contacto actualizada correctamente.";
        } else {
            $error_message = "Error al actualizar la información de contacto: " . $stmt_update->error;
        }
        $stmt_update->close();
    } else {
        // Insertar nuevos datos de contacto
        $sql_insert = "INSERT INTO contacto_especialista (especialista_id, correo, telefono) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iss", $especialista_id, $correo, $telefono);

        if ($stmt_insert->execute()) {
            $success_message = "Información de contacto agregada correctamente.";
        } else {
            $error_message = "Error al agregar la información de contacto: " . $stmt_insert->error;
        }
        $stmt_insert->close();
    }
    $contacto['correo'] = $correo;
    $contacto['telefono'] = $telefono;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto Especialista</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #87CEFA;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 20px;
        }

        .header {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            color: #555;
        }

        input[type="email"], input[type="tel"] {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background: #6495ED;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #4169E1;
        }

        .message {
            margin-top: 15px;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #6495ED;
            text-decoration: none;
            font-size: 16px;
        }

        .back-link:hover {
            color: #4169E1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Contacto Especialista</div>
        <?php if (!empty($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="contacto_especialista.php">
            <label for="correo">Correo:</label>
            <input type="email" name="correo" value="<?php echo isset($contacto['correo']) ? htmlspecialchars($contacto['correo']) : ''; ?>" required>
            
            <label for="telefono">Teléfono:</label>
            <input type="tel" name="telefono" value="<?php echo isset($contacto['telefono']) ? htmlspecialchars($contacto['telefono']) : ''; ?>" required>
            
            <input type="submit" value="<?php echo isset($contacto) ? 'Actualizar' : 'Agregar'; ?>">
        </form>
        <a href="welcome.php" class="back-link">Regresar</a>
    </div>
</body>
</html>
