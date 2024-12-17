<?php
require 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (full_name, phone_number, address, email, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $full_name, $phone_number, $address, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
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
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateRegisterForm() {
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
        <h2>Register</h2>
        <form method="POST" onsubmit="return validateRegisterForm()">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" id="full_name" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" required>

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Register</button>
            <a href="login.php">Already have an account? Login here</a>
        </form>
    </div>
</body>
</html>
