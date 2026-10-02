<?php
require_once '../database/conexao.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificaUser.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Todas</title>
</head>

<body>
    <?php  include __DIR__ . '/../includes/header.php';?>

    <main>
        <?php
        verTodas($pdo);
        ?>
    </main>
    
    <?php include __DIR__ . '/../includes/footer.php';?>
</body>

</html>