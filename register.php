<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    try {
        $stmt->execute([$username, $password]);
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Username already exists.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Plant Monitor</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #eaf6f6;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .header-text {
            color: #2c786c;
            margin-bottom: 20px;
        }

        .register-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        .register-box h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #333;
        }

        .register-box input[type="text"],
        .register-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .register-box button {
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('image/growth-close-up-environmental-lush-natural.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            border: none;
            padding: 12px 20px;
            width: 100%;
            height: 50px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            text-shadow: 1px 1px 2px #000;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        .register-box button:hover {
            opacity: 0.9;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .login-link {
            margin-top: 20px;
            text-align: center;
        }

        .login-link a {
            color: #2c786c;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="header-text">
        <h1>Welcome to your Plant Health Doctor</h1>
        <p>We are here to ensure your plants stay lively and healthy to meet your expectations.</p>
    </div>

    <div class="register-box">
        <h2>Create Account</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit"><span>Register</span></button>
        </form>

        <?php if (isset($error)) echo "<div class='error-message'>$error</div>"; ?>

        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>

</body>
</html>
