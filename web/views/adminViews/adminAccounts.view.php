<!DOCTYPE html>
<html lang="es-ES">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php"?>
    <title>Inicio | Reto 2</title>
</head>

<body class="structure">
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/partials/navBar.php"; ?>

<main>
    <a href="/admin/adminPanel">Volver</a>
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Nombre de usuario</th>
            <th>email</th>
            <th>Fecha de creación</th>
            <th>Verificado</th>
            <th>Activo</th>
            <th>Permisos</th>
        </tr>
        </thead>
        <tbody>
        <?php if(isset($accounts)): ?>
            <?php foreach ($accounts as $account):
                $authoritiesIds = [];
                foreach ($account["authorities"] as $authority) $authoritiesIds[] = $authority["authorityId"];
            ?>
                <tr>
                    <td><?=$account["accountId"]?></td>
                    <td><?=$account["username"]?></td>
                    <td><?=$account["email"]?></td>
                    <td><?=$account["creationDate"]?></td>
                    <td><?=$account["verified"]?></td>
                    <td><?=$account["active"]?></td>
                    <td>
                        <?php if (isset($authorities)): ?>
                            <form action="/admin/accounts/updateAuthorities" method="POST">
                                <input type="hidden" name="account_id" value="<?=$account["accountId"]?>">
                                <?php foreach ($authorities as $authority): ?>
                                    <label>
                                        <?=$authority["role"]?>
                                        <input type="checkbox" name="authorities_id[]" value="<?=$authority["authorityId"]?>"
                                            <?php if (in_array($authority["authorityId"], $authoritiesIds)): ?>
                                                checked
                                            <?php endif; ?>>
                                    </label>
                                <?php endforeach; ?>
                                <button type="submit">Cambiar permisos</button>
                            </form>
                        <?php endif; ?>
                    </td>
                    <td>Aplicar cambios</td>
                    <td><a href="/admin/accounts/delete?account_id=<?=$account["accountId"]?>>">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
