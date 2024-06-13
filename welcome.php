<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

echo "Welcome, " . $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
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
        
        h1 {
            font-size: 1.5em;
            color: #ffffff;
        }
        
        .box {
            background: white;
            width: 300px;
            border-radius: 6px;
            margin: 0 auto;
            padding: 20px;
            border: #2980b9 4px solid;
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
            font-weight: 800;
            font-size: 0.8em;
            cursor: pointer;
        }
        
        .btn:hover {
            background: #2CC06B;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>
