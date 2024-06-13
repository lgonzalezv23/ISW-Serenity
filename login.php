<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: welcome.php");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found with that username";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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
            padding: 0 0 70px 0;
            border: #2980b9 4px solid;
        }
        
        .email, .password {
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

        #btn3 {
            float: left;
            background: #e74c3c;
            width: 125px;
            padding-top: 5px;
            padding-bottom: 5px;
            color: white;
            border-radius: 4px;
            border: #c0392b 1px solid;
            margin-top: 20px;
            margin-bottom: 20px;
            margin-left: 10px;
            font-weight: 800;
            font-size: 0.8em;
            cursor: pointer;
        }
        
        #btn3:hover {
            background: #d62c1a;
        }
    </style>
</head>
<body>
    <form method="POST" action="login.php">
        <div class="box">
            <h1>Serenity</h1>
            <input type="text" name="username" value="username" onFocus="field_focus(this, 'username');" onblur="field_blur(this, 'username');" class="email" />
            <input type="password" name="password" value="password" onFocus="field_focus(this, 'password');" onblur="field_blur(this, 'password');" class="password" />
            <div class="btn" onclick="submitForm()">Sign In</div> <!-- End Btn -->
            <div id="btn2">Sign Up</div> <!-- End Btn2 -->
            <div id="btn3" onclick="window.location.href='index2.html'">Home</div> <!-- End Btn3 -->
        </div> <!-- End Box -->
    </form>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
    <script>
        function field_focus(field, default_text) {
            if(field.value == default_text) {
                field.value = '';
            }
        }

        function field_blur(field, default_text) {
            if(field.value == '') {
                field.value = default_text;
            }
        }

        // Fade in dashboard box
        $(document).ready(function(){
            $('.box').hide().fadeIn(1000);
        });

        // Stop click event
        $('a').click(function(event){
            event.preventDefault(); 
        });

        function submitForm() {
            document.forms[0].submit();
        }
    </script>
</body>
</html>
