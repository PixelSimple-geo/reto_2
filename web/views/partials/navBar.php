<?php global $userAccount; ?>

<div class="header">
    <!--Logo-->
    <a href="/index"><img src="/statics/media/comvit.png" alt="logo"></a>
    <!--Searchbar
    <form action="/index" method="POST" class="search">
        <input type="text" name="search" placeholder="¿Que deseas buscar?">
        <button type="submit"><img src="/statics/media/search.svg" alt="search"></button>
    </form>
    -->
    <!--Sesion-->
    <?php
    if (!isset($userAccount)) :
        ?>
        <a href="/login">
            <img src="/statics/media/profile.svg" alt="Profile">
        </a>
    <?php else : ?>
        <div class="dropdown">
            <button class="dropbtn">
                <img src="/statics/media/profile.svg" alt="Profile">
            </button>
            <div class="dropdown-content">
                <a href="/account">Editar Perfil</a>
                <a href="/businesses/crud/all">Ver Negocios</a>
                <a href="/articles/crud/all">Ver tus artículos</a>
                <a href="/logout">Cerrar Sesion</a>
            </div>
        </div>
    <?php endif; ?>


</div>
<!--Navegator-->
<nav class="navbar">
    <a href="/index">Inicio</a>
    <a href="/articleNews">Noticias</a>
    <a href="/history">Historia</a>
    <?php //TODO ?>
    <a href="/products">Productos</a>
    <a href="/businesses/all">Comercios</a>
    <a href="/contact">Contacto</a>
</nav>