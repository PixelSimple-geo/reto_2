<?php
// require "views/index.view.php"
include_once "models/driverManager.php"; // Include it only once

include "models/authorityDB.php";
$data = getAuthorities(getConnection());
?>

<!DOCTYPE html>
<html>
<body>
<?= "hello" ?>
<p><?= print_r($data)?></p>
</body>
</html>
