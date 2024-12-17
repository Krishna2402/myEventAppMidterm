<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h2>
        <p>You are now logged in to the MyEvent app.</p>

        <!-- Button to go to Products Page -->
        <a href="products.php">
            <button class="btn">View Products</button>
        </a>

        <!-- Logout Button in top-right corner -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
