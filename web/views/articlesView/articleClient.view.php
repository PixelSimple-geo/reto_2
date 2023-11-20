<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title><?php echo $article['title'] ?? 'Article Details'; ?></title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div class="contentsContainer">
        <h1><?php echo $article['title'] ?? 'No Title'; ?></h1>
        <div class="formulario">
            
            <?php if (!empty($article['description'])): ?>
                <p>Description: <?php echo $article['description']; ?></p>
            <?php endif; ?>

            <?php if (!empty($article['created_date'])): ?>
                <p>Created Date: <?php echo $article['created_date']; ?></p>
            <?php endif; ?>

            <?php if (!empty($article['modified_date'])): ?>
                <p>Modified Date: <?php echo $article['modified_date']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
