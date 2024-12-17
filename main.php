<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

include 'db.php'; // Include the database connection

// Fetch all products from the database
$sql = "SELECT * FROM products"; // Adjust the table name if necessary
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

        <!-- Display products -->
        <div class="products">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($product = mysqli_fetch_assoc($result)) {
                    $imagePath = 'assets/image/' . htmlspecialchars($product['product_image']);
                    if (!file_exists($imagePath)) {
                        $imagePath = 'assets/image/default.jpg'; // Default image if no image exists
                    }
                    echo '
                    <div class="product">
                        <img src="' . $imagePath . '" alt="' . htmlspecialchars($product['product_name']) . '">
                        <h2>' . htmlspecialchars($product['product_name']) . '</h2>
                        <p>' . htmlspecialchars($product['product_description']) . '</p>
                        <p><strong>Price: </strong>' . htmlspecialchars($product['product_price']) . '</p>
                        <a href="product_detail.php?id=' . $product['product_id'] . '">View Details</a>
                    </div>
                    ';
                }
            } else {
                echo "<p>No products available.</p>";
            }
            ?>
        </div>

        <!-- Logout button -->
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</body>
</html>

