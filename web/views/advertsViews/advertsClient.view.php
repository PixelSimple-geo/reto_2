<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Product Details</title>
</head>
<body class="structure">
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div class="contentsContainer">
        <h2>Product Details</h2>

        <?php
        // Assuming you have a $productId variable containing the ID of the selected product
        $productId = $_GET['product_id']; // Adjust this based on your actual implementation

        // Find the product details based on $productId
        $selectedProduct = findProductById($productId); // Replace with your actual function

        if ($selectedProduct) {
            echo '<div>';
            echo "<img src='{$selectedProduct['coverImg']}' alt='Product Image'>";
            echo '<h3>' . $selectedProduct['title'] . '</h3>';
            echo '<p>Description: ' . $selectedProduct['description'] . '</p>';
            // Include additional details as needed
            echo '</div>';
        } else {
            echo '<p>Product not found.</p>';
        }
        ?>
    </div>
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
