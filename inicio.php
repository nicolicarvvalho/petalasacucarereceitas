<?php

require_once __DIR__ . '/includes/functions.php';

require_once __DIR__ . '/login/verificaUser.php';

$usuario_id = $_SESSION['usuario_id'];

$usuario = consulta_id($pdo, $usuario_id);

$pasta = "./imagens/carrossel/";

$imagens = glob(
    $pasta . "*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}",
    GLOB_BRACE
);

// Se não encontrar fotos na pasta, carrega imagens de teste

if (empty($imagens)) {

    $imagens = [
        "https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&h=400&fit=crop",
        "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=800&h=400&fit=crop",
        "https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=800&h=400&fit=crop"
    ];
}

$total = count($imagens);

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pétalas, Açúcar e Receitas</title>

        <link rel="icon" type="image/png" href="./imagens/logo32.png">


    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #fcf8f3;
        }

        /* Área da conta */

        .conta {
            text-align: center;
            width: 100px;
            margin-left: auto;
            margin-right: 30px;
            margin-top: 15px;
        }

        .conta a {
            text-decoration: none;
        }

        .conta img {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            object-fit: cover;
        }

        .conta p {
            margin-top: 5px;
            font-weight: bold;
        }

        /* Container do carrossel */

        .carrossel-container {
            max-width: 800px;
            margin: 40px auto;
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Esconde os radios */

        .carrossel-container input[type="radio"] {
            display: none;
        }

        /* Trilho das imagens */

        .carrossel-track {
            display: flex;
            width: 100%;
            transition: transform 0.4s ease;
        }

        /* Cada imagem ocupa toda a área do carrossel */

        .carrossel-item {
            flex: 0 0 100%;
            width: 100%;
        }

        .carrossel-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
        }

        /* Bolinhas de navegação */

        .carrossel-nav {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .carrossel-nav label {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #ffffff;
            border: 2px solid #ffffff;
            cursor: pointer;
            transition: 0.3s;
            transform: scale(1.2);
        }

        /* Quando a bolinha estiver selecionada */

        #radio-0:checked~.carrossel-track {
            transform: translateX(0%);
        }

        #radio-1:checked~.carrossel-track {
            transform: translateX(-100%);
        }

        #radio-2:checked~.carrossel-track {
            transform: translateX(-200%);
        }

        #radio-0:checked~.carrossel-nav label[for="radio-0"],
        #radio-1:checked~.carrossel-nav label[for="radio-1"],
        #radio-2:checked~.carrossel-nav label[for="radio-2"] {
            transform: scale(1.2);
        }
    </style>

</head>

<body>

    <?php include './includes/header.php'; ?>

    <!-- Conta do usuário -->

    <div class="conta">

        <a href="perfil.php">

            <img src="/imagens/<?php echo $usuario['fotoperfil']; ?>" alt="Foto de perfil">

        </a>

    </div>

    <!-- Carrossel -->

    <div class="carrossel-container">

        <?php foreach ($imagens as $i => $img): ?>

            <input type="radio" name="carrossel-control" id="radio-<?php echo $i; ?>"
                <?php echo $i === 0 ? 'checked' : ''; ?>>

        <?php endforeach; ?>

        <div class="carrossel-track">

            <?php foreach ($imagens as $i => $img): ?>

                <div class="carrossel-item">

                    <img src="<?php echo $img; ?>" alt="Foto <?php echo $i + 1; ?>">
                </div>

            <?php endforeach; ?>

        </div>

        <div class="carrossel-nav">

            <?php foreach ($imagens as $i => $img): ?>

                <label for="radio-<?php echo $i; ?>"></label>

            <?php endforeach; ?>

        </div>

    </div>

    <?php include './includes/footer.php'; ?>

</body>

</html>