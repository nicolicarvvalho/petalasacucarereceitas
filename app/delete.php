<?php
require_once __DIR__ . '/../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <h1>Apagar Receita</h1>
    <main>
        <form action="" method="post">
            <input type="search" name="nome" id="nome">
            <input type="submit" value="Enviar">
            <input type="reset" value="Cancelar">


            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                apagar($pdo, $_POST['nome']);
            }
            ?>

            <?php include __DIR__ . '/../includes/footer.php'; ?>
    </main>

</body>

</html>