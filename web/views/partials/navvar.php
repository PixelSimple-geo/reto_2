        <div class="header">
            <!--Logo-->
            <a href="/views/index.view.php"><img src="/statics/media/logo2.png" alt="logo"></a>
            <!--Searchbar-->
            <form action="index.view.php" method="POST" class="search">
                <input type="text" name="search" placeholder="¿Que deseas buscar?">
                <button type="submit"><img src="/statics/media/search.svg" alt="search"></button>
            </form>
            <!--Noc/Diu-->
            <div class="nocdiu">
                <div id="idSun" class="mode diu">
                    <img src="/statics/media/sun.svg" alt="sun">
                </div>
                <div id="idMoon" class="mode noc">
                    <img src="/statics/media/moon.svg" alt="moon">
                </div>
            </div>
            <!--Sesion-->
            <?php
                if (!isset($userAccount)) {
                    echo '<a href="/login"><img src="/statics/media/profile.svg" alt="Profile"></a>';
                } else {
                    echo '<div class="dropdown">';
                    echo '  <button class="dropbtn"><img src="/statics/media/profile.svg" alt="Profile"></button>';
                    echo '  <div class="dropdown-content">';
                    echo '    <a href="/profile">Editar Perfil</a>';
                    echo '    <a href="/negocios">Ver Negocios</a>';
                    echo '    <a href="/logout">Cerrar Sesion</a>';

                    /* TODO necesito esta select para saber si un usuario es publisher y asi mostrar en el dropdown la opcion de ver los articulos
                    Verifica si el usuario tiene el rol de "publisher"
                    $query = "SELECT * FROM authorities_granted WHERE account_id = :account_id AND authority_id = (SELECT authority_id FROM authorities WHERE role = 'publisher')";
                    $statement = $conn->prepare($query);
                    $statement->bindParam(':account_id', $userAccount['account_id'], PDO::PARAM_INT);
                    $statement->execute();
                    $isPublisher = $statement->fetch(PDO::FETCH_ASSOC);
                    */
                    /*
                    if ($isPublisher) {
                        echo '    <a href="/articulos?publisher=' . $userAccount['account_id'] . '">Ver Artículos</a>';
                    }
                    */

                    echo '    <a href="#">Cerrar Sesión</a>';
                    echo '  </div>';
                    echo '</div>';
                }
            ?>

        </div>
        <!--Navegator-->
        <div class="navbar">
            <a href="/views/index.view.php">Inicio</a>
            <a href="/views/noticias.view.php">Noticias</a>
            <a href="/views/historia.view.php">Historia</a>
            <a href="#">Calle Gorbeia</a>
            <a href="/views/comerces.view.php">Comercios</a>
            <a href="/views/contacto.view.php">Contacto</a>    
        </div>