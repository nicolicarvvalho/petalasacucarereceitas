<?php

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificaUser.php';

$usuario_id = $_SESSION['usuario_id'];
$usuario = consulta_id($pdo, $usuario_id);

// Caminho absoluto para o PHP ler os ficheiros do disco
$pasta_disco = __DIR__ . '/../imagens/carrossel/';

// Busca todas as imagens dentro de app/imagens/carrossel/
$imagens_disco = glob(
    $pasta_disco . "*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}",
    GLOB_BRACE
);

$imagens = [];

if (!empty($imagens_disco)) {
    // Converte os caminhos do servidor para caminhos web (relativos)
    foreach ($imagens_disco as $img) {
        $nome_ficheiro = basename($img);
        $imagens[] = "../imagens/carrossel/" . $nome_ficheiro;
    }
} else {
    // Se a pasta estiver vazia, carrega imagens de teste
    $imagens = [
        "https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&h=400&fit=crop",
        "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=800&h=400&fit=crop",
        "https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=800&h=400&fit=crop"
    ];
}

$total = count($imagens);

$regras_carrossel = "";
for ($i = 0; $i < $total; $i++) {
    $regras_carrossel .= "
        #radio-$i:checked ~ .carrossel-track {
            transform: translateX(-" . ($i * 100) . "%);
        }
        #radio-$i:checked ~ .carrossel-nav label[for=\"radio-$i\"] {
            transform: scale(1.2);
            background: #d63765;
        }
    ";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>
    <link rel="icon" type="image/png" href="../imagens/logo32.png">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #fbf5e9;
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
            color: #d63765;
        }

        .frase-carrossel {
            text-align: center;
            color: #d63765;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1.9rem;
            margin-top: 35px;
            margin-bottom: 25px;
        }

        .subfrase-carrossel {
            text-align: center;
            color: #d63765;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1.2rem;
            margin-top: 0;
            margin-bottom: 25px;
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
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ffffff;
            border: 2px solid #d63765;
            cursor: pointer;
            transition: 0.3s;
        }

        /* Regras dinâmicas geradas pelo PHP para N imagens */
        <?php echo $regras_carrossel; ?>
    </style>
</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Conta do usuário -->
    <div class="conta">
        <a href="../usuario/perfil.php">
            <img src="../imagens/<?php echo $usuario['fotoperfil']; ?>" alt="Foto de perfil">
            <p>Meu perfil</p>
        </a>
    </div>

    <!-- Carrossel -->
    <h1 class="frase-carrossel">
        Compartilhe seus melhores momentos em forma de receitas
    </h1>

    <p class="subfrase-carrossel">
        Se inspire, crie e compartilhe suas receitas favoritas
    </p>

    <div class="carrossel-container">

        <?php foreach ($imagens as $i => $img): ?>
            <input type="radio" name="carrossel-control" id="radio-<?php echo $i; ?>"
                <?php echo $i === 0 ? 'checked' : ''; ?>>
        <?php endforeach; ?>

        <div class="carrossel-track">
            <?php foreach ($imagens as $i => $img): ?>
                <div class="carrossel-item">
                    <img src="<?php echo $img; ?>">
                </div>
            <?php endforeach; ?>
        </div>

        <div class="carrossel-nav">
            <?php foreach ($imagens as $i => $img): ?>
                <label for="radio-<?php echo $i; ?>"></label>
            <?php endforeach; ?>
        </div>

    </div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>