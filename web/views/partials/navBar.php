<?php global $userAccount; ?>

<div class="header">
    <!--Logo-->
    <a href="/index"><img src="/statics/media/logo2.png" alt="logo"></a>
    <!--Searchbar-->
    <form action="/index" method="POST" class="search">
        <input type="text" name="search" placeholder="¿Que deseas buscar?">
        <button type="submit"><img src="/statics/media/search.svg" alt="search"></button>
    </form>
    <!--Sesion-->
    <?php
        if (!isset($userAccount)) {
            echo '<a href="/login"><img src="/statics/media/profile.svg" alt="Profile"></a>';
        } else {
            echo '<div class="dropdown">';
            echo '  <button class="dropbtn"><img src="/statics/media/profile.svg" alt="Profile"></button>';
            echo '  <div class="dropdown-content">';
            echo '    <a href="/account">Editar Perfil</a>';
            echo '    <a href="/businesses/crud/all">Ver Negocios</a>';
            echo '    <a href="/logout">Cerrar Sesion</a>';
            echo '    <a href="/articles?publisher=' . $userAccount['accountId'] . '">Ver Artículos</a>';
         

            echo '  </div>';
            echo '</div>';
        }
    ?>

</div>
<!--Navegator-->
<div class="navbar">
    <a href="/index">Inicio</a>
    <a href="/articleNews">Noticias</a>
    <a href="/views/history.view.php">Historia</a>
    <?php //TODO ?>
    <a href="/comerces">Comercios</a>
    <a href="/views/contact.view.php">Contacto</a>
</div>