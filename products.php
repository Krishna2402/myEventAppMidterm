<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db.php';

$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM products WHERE name LIKE ? LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($sql);
$searchTerm = "%$search%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$totalResult = $conn->query("SELECT COUNT(*) FROM products WHERE name LIKE '$searchTerm'")->fetch_row()[0];
$totalPages = ceil($totalResult / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Products</h2>
        <form method="POST">
            <input type="text" name="search" placeholder="Search for products" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>

        <ul>
            <?php while ($product = $result->fetch_assoc()) { ?>
                <li>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
                    <p><strong>Quantity:</strong> <?php echo htmlspecialchars($product['quantity']); ?></p>

                    <!-- Displaying image with fallback if none exists -->
                    <?php
                    $image = $product['picture'] ? $product['picture'] : 'default.jpg';  // Fallback to default image
                    ?>
                    <img src="images/<?php echo $image; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-width: 200px; height: auto;">
                </li>
            <?php } ?>
        </ul>

        <div class="pagination">
            <?php if ($page > 1) { ?>
                <a href="products.php?page=<?php echo $page - 1; ?>">Previous</a>
            <?php } ?>
            <?php if ($page < $totalPages) { ?>
                <a href="products.php?page=<?php echo $page + 1; ?>">Next</a>
            <?php } ?>
        </div>
    </div>
</body>
</html>
