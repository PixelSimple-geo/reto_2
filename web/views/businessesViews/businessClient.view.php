<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title><?php echo $businessesClient['name']; ?> - Business Details</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>
    
    <div class="business">
        <a href="/comerces">Volver a los comercios</a>
        <div>
            <?php if(!empty($businessesClient)): ?>
            <h2><?= htmlspecialchars($businessesClient["name"]) ?></h2>
                <?php if(!empty($category)): ?>
                    <p id=<?=$category['categoryId']?>><?=$category["name"]?></p>
                <?php endif; ?>
            <p><?= htmlspecialchars($businessesClient['description']) ?></p>
            <?php endif; ?>
        </div>
        <div>
            <?php if(!empty($contacts)): ?>
                <section>
                    <h3>Contacto</h3>
                    <?php foreach ($contacts as $contact): ?>
                        <p><?php echo "$contact[type]: $contact[value]"  ?></p>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <?php if(!empty($addresses)): ?>
            <section>
                <h3>Direcciones</h3>
                <?php foreach ($addresses as $address): ?>
                <p><?php echo "$address[address], $address[postalCode]"  ?></p>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>
        </div>
    </div>

        <div class="contentsContainer">
            <h2>Adverts:</h2>

            <div class="contents">
                <?php
                $itemsPerPage = 6;
                $totalAdverts = count($advertsByBusiness);

                $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                $offset = ($currentPage - 1) * $itemsPerPage;

                $pagedAdverts = array_slice($advertsByBusiness, $offset, $itemsPerPage);

                if (isset($pagedAdverts) && !empty($pagedAdverts)) {
                    foreach ($pagedAdverts as $advert) {
                        echo '<div>';
                        echo "<img src='$advert[coverImg]' alt='Portada del anuncio'>";
                        echo '<h3>' . $advert['title'] . '</h3>';
                        echo '<p>Description: ' . $advert['description'] . '</p>';
                        echo '</div>';
                    }

                    $totalPages = ceil($totalAdverts / $itemsPerPage);

                    if ($totalPages > 1) {
                        echo '<ul class="paginas">';
                        for ($i = 1; $i <= $totalPages; $i++) {
                            $class = ($i == $currentPage) ? 'current' : '';
                            echo '<li><a href="?page=' . $i . '" class="' . $class . '">' . $i . '</a></li>';
                        }
                        echo '</ul>';
                    }
                } else {
                    echo '<p>No hay anuncios disponibles para este negocio.</p>';
                }
                ?>
            </div>
        </div>
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
