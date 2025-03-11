<?php
// login.php

include "../modelo/conexion.php";
include "../controlador/ControladorLogin.php";

// Aquí termina la lógica de login/redirección
// y empieza el HTML solo si aún no se ha redirigido.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #232834;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            background-color: #282e3b;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            margin: 0 20px;
        }

        .login-title {
            color: white;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .login-subtitle {
            color: #a0a8b9;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 14px;
            color: #a0a8b9;
        }

        .form-input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: none;
            border-radius: 5px;
            background-color: #1e2430;
            color: white;
            font-size: 16px;
            outline: none;
        }

        .form-input::placeholder {
            color: #6b7280;
        }

        .login-button {
            width: 100px;
            padding: 12px 0;
            background-color: #5a67d8;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #4c51bf;
        }

        .forgot-password {
            text-align: right;
            margin-top: 10px;
            font-size: 14px;
        }

        .forgot-password a {
            color: #5a67d8;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">Login</h1>
        <p class="login-subtitle">Sign In to your account</p>
        <form method="post" action="">
            <div class="input-group">
                <i>👤</i>
                <input name="gmail" type="text" class="form-input" placeholder="gmail" required>
            </div>
            
            <div class="input-group">
                <i>🔒</i>
                <input name="password" type="password" class="form-input" placeholder="Password" required>
            </div>
            
            <div class="form-footer">
                <input name="btningresar" type="submit" class="login-button" value="Login">
                <div class="forgot-password">
                    <a href="#">Forgot password?</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>