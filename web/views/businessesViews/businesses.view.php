<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Comercios | Reto 2</title>
</head>

<body class="structure">
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div>
        <nav class="navbar">
        <a href="/businesses/all"><h2>Todo</h2></a>
            <?php if (isset($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <a href="/businesses/all?category_id=<?=$category["categoryId"]?>">
                        <h2><?= htmlspecialchars($category['name']) ?></h2>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </nav>
        <div class="contentsContainer">
            <div class="contents">
                <?php if(isset($businesses)):?>
                    <?php foreach ($businesses as $business): ?>
                        <a href="/businesses/business?business_id=<?=$business['businessId']?>">
                            <div>
                                <h3><?= $business['name'] ?></h3>
                                <p>Descripción: <?= $business['description'] ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>

</html>
