<?php
session_start();
include 'db_connect.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT user_id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: " . ($user['role'] == "admin" ? "admin_panel.php" : "member_dashboard.php"));
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Sports Club</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            width: 800px;
            margin: 50px auto;
            display: flex;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .left {
            background: linear-gradient(to right, #1d4ed8, #3b82f6);
            color: white;
            padding: 40px 30px;
            flex: 1;
        }

        .left h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .right {
            background-color: white;
            padding: 40px 30px;
            flex: 1;
        }

        .right h2 {
            margin-bottom: 30px;
        }

        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 25px;
            outline: none;
        }

        form input[type="checkbox"] {
            margin-right: 5px;
        }

        form button {
            width: 100%;
            padding: 12px;
            background-color: #1e3a8a;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            cursor: pointer;
        }

        .extra-options {
            margin-top: 10px;
            text-align: right;
        }

        .extra-options a {
            color: #7c3aed;
            text-decoration: none;
            font-size: 0.9em;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <h1>Sports Club</h1>
            <p>A Sports Club Management System in Northern Bukidnon State College</p>
        </div>
        <div class="right">
            <h2>Login</h2>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            <?php if (isset($_GET['registration_success'])) echo "<p class='success'>Registration successful! Please log in.</p>"; ?>

            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <div>
                    <label><input type="checkbox" name="remember"> Remember</label>
                </div>
                <div class="extra-options">
                    <a href="#">Forgot password?</a>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
