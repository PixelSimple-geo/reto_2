<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php"?>
    <title>Inicio | Reto 2</title>
</head>

<body class="structure">
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/partials/navBar.php"; ?>
<main
    <nav>
        <ul>
            <li><a href="/admin/accounts/read">Cuentas</a></li>
            <li><a href="/admin/adverts/read">Anuncios</a></li>
            <li><a href="/admin/articles/read">Artículos</a></li>
            <li><a href="/admin/reviews/read">Reseñas</a></li>
            <li><a href="/admin/commentaries/read">Comentarios</a></li>
            <li><a href="/admin/businesses/read">Negocios</a></li>
            <li><a href="/admin/articlesCategories/read">Categoría de artículos</a></li>
            <li><a href="/admin/businessesCategories/read">Categoría de negocios</a></li>
        </ul>
    </nav>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>