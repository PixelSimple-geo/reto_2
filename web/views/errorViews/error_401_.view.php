<!DOCTYPE html>
<html lang="en">
<head>
    <title>401</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>

</head>
<body class="structure">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div class="error">
        <h1>ERROR 401</h1>
        <p>No estás autenticado. Si quieres acceder a este recurso es necesario iniciar sesión.</p>    
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>