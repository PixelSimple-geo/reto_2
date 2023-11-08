<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina principal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/idioma.css">
    <link rel="stylesheet" href="css/nocdiu.css">

</head>
    <body>
        <div class="header">
            <!--Searchbar-->
            <form action="index.view.php" method="POST" class="search">
                <input type="text" name="search" placeholder="¿Que deseas buscar?">
                <button type="submit"><img src="media/search.png" alt="search"></button>
            </form>
            <!--Lenguage-->            
                <ul>
                    <li><a href="#"><img src="media/idioma.png" alt="lang"> &dtrif;</a>
                    <ul>
                        <li><a href="./Spanish.html">Español</a></li>
                        <li><a href="./English.html">Ingles</a></li>
                    </ul>
                    </li>
                </ul>
            <!--Noc/Diu-->
            <div class="nocdiu">
                <div id="idSun" class="mode diu">
                    <img src="media/sol.png" alt="sun">
                </div>
                <div id="idMoon" class="mode noc">
                    <img src="media/luna.png" alt="moon">
                </div>
            </div>
            <!--Sesion-->
            <a href="views/login.view.php"><img src="media/perfil.png" alt="Profile"></a>
        </div>
        