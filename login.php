<?php
require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT user_id, full_name, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['full_name'] = $row['full_name'];
            if (isset($_POST['remember_me'])) {
                setcookie("user_email", $email, time() + (86400 * 30), "/");
            }
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateLoginForm() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!email.includes("@")) {
                alert("Please enter a valid email.");
                return false;
            }
            if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <form method="POST" onsubmit="return validateLoginForm()">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>

            <label>
                <input type="checkbox" name="remember_me"> Remember Me
            </label><br><br>

            <button type="submit">Login</button>
            <a href="register.php">Don't have an account? Register here</a>
        </form>
    </div>
</body>
</html>
