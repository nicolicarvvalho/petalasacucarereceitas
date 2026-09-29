<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>

    <?php
    $pasta = "./imagens/carrossel/"; //a variável $pasta guarda as imagens que estão na pasta carrossel que estão dentro de imagens
    $imagens = glob($pasta . "*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}", GLOB_BRACE); //procura todas as imagens na pasta com essas extensões
    //Função glob() procura arquivos que tenham o padrão especificado. GLOB_BRACE permite buscar várias extensões de uma vez só (jpg, png...).

    // Se não achar fotos na pasta, carrega 3 imagens de teste automaticamente
    if (empty($imagens)) {
        $imagens = [
            "https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&h=400&fit=crop",
            "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=800&h=400&fit=crop",
            "https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=800&h=400&fit=crop"
        ];
    } //empty($imagens): Verifica se a busca não encontrou nenhum arquivo. Se isso tiver acontecido ele preenche a variável $imagens com as fotos acima.

    $total = count($imagens);  //count($imagens): Conta quantas fotos tem na variável $imagens. O valor é salvo em $total para ser usado nos cálculos de layout no CSS.
    ?>

    <style>
        * {
            box-sizing: border-box;
        }

        .carrossel-container {
            max-width: 800px;
            margin: 40px auto;
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Inputs radio escondidos */
        .carrossel-container input[type="radio"] {
            display: none;
        }

        /* Trilho das imagens */
        .carrossel-track {
            display: flex;
            width: <?php echo $total * 100; ?>%;
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .carrossel-item {
            width: <?php echo 100 / $total; ?>%;
        }

        .carrossel-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
        }

        /* Botões de navegação (bolinhas) */
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
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            border: 2px solid rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }

        /* Regra dinâmica para mover o carrossel conforme o radio marcado */
        <?php foreach ($imagens as $i => $img): ?>#radio-<?php echo $i; ?>:checked~.carrossel-track {
            transform: translateX(-<?php echo ($i * (100 / $total)); ?>%);
        }

        #radio-<?php echo $i; ?>:checked~.carrossel-nav label[for="radio-<?php echo $i; ?>"] {
            background: #ffffff;
            transform: scale(1.2);
        }

        <?php endforeach; ?>
    </style>
</head>

<body>

    <?php include './includes/header.php'; ?> <!-- Incluindo o header -->

    <div class="carrossel-container">

        <?php foreach ($imagens as $i => $img): ?> <!-- O laço foreach percorre as imagens. A cada imagem ele guarda a posição na variável $i -->
            <input type="radio" name="carrossel-control" id="radio-<?php echo $i; ?>" <?php echo $i === 0 ? 'checked' : ''; ?>> <!-- Coloca aquela bolinha em baixo das imagens,
            depois gera um id para cada botão baseado no id da imagem. 
            O último echo é um ternário, ele pergunta ao navegador algo como "essa imagem é a primeira da lista? se sim ele fala "checked" se não ele não fala nada.  -->
        <?php endforeach; ?> <!-- Acaba o laço -->

        <div class="carrossel-track">
            <?php foreach ($imagens as $i => $img): ?>
                <div class="carrossel-item">
                    <img src="<?php echo $img; ?>" alt="Foto <?php echo $i + 1; ?>"> <!-- Exibe as imagens e depois cria um texto para leitores de tela. Como a variável $i começa do zero, nós somamos +1 para criar uma legenda. Para a 1ª foto ($i = 0 ) fica alt="Foto 1" e assim por diante. -->
                </div>
            <?php endforeach; ?> <!-- Aacaba o laço -->
        </div>

        <div class="carrossel-nav">
            <?php foreach ($imagens as $i => $img): ?> <!-- Igual aos de cima garante que cada imagem tenha uma bolinha -->
                <label for="radio-<?php echo $i; ?>"></label> <!-- Insere um índice para cada bolinha. Para a 1ª bolinha ($i = 0): gera <label for="radio-0"></label> -->
            <?php endforeach; ?> <!-- Fim do laço-->
        </div>

    </div>

</body>

</html>