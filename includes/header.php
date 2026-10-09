<?php
// Usa $base se já foi definida na página, caso contrário usa "../"
$raiz = isset($base) ? $base : "../";
?>

<style>
    header .logo { /* "pegue a classe 'logo' que está dentro do header" */
        background-color: #f6edde; /* cor do fundo */
        display: flex; /* Transforma a <div> em um container flexível */
        justify-content: center; /* centraliza o conteudo no centro, aqui estou falando para a logo ficar no meio */
        align-items: center; /*esse deixa conteudo centralizado na vertical */
        padding: 15px 0;/* esse cria um espaço interno. o primeiro valor é de cima e o segundo é em baixo*/
        width: 100%; /* esse é para ocupar toda a largura disponível. o 100% significa o todo*/
    }

    header .logo img {/**aqui é para estilizar a imagem que está dentro da classe logo*/
        height: 100px;/*altura de 100 pixels */
        width: auto;/*como ja foi definida a altura, a largura é automatica */
        display: block;/*isso faz a imagem se comportar como um bloco */
    }

    header .navegacao { /*aqui estiliza a classe navegação */
        background-color: #d63765;/* cor de fundo */
        width: 100%;/*largura */
        padding: 14px 0;/*isso coloca espaço em cima e embaixo dos links. */
    }

    header .navegacao ul { /*aqui vai estilizar a lista que está dentro da classe navegação */
        list-style: none; /*esse tira as bolinhas que vem com a lista não ordenada */
        padding: 0 20px; /*aqui é o espaço */
        display: flex;/*isso deixa a organização flexível. sem isso os itens da lista ficariam um em baixo do outro */
        justify-content: space-around;/* deixa os links um do lado do outro com espaço entre eles */
        align-items: center; /*isso deixa os itens organizados verticalmente */
        max-width: 1200px; /*essa é a largura maxima que pode ficar */
        margin: 0 auto; /*esse deixa a margem em cima e em baixo = 0 e a margem da esquerda e direita = automática */
    }

    header .navegacao ul li {
        display: inline-block;/*iso aqui deixa que os itens da lista fiquem lado a lado */
    }

    header .navegacao ul li a { /*ess estiliza cada link */
        color: #f6edde; /*cor do link */
        text-decoration: none; /*tira o sublinhado do link */
        font-weight: bold; /*negrito */
        font-size: 1.1rem; /*tamanho */
        font-family: sans-serif; /*fonte sem serifa */
        transition: opacity 0.2s;/*Isso faz a mudança de transparência no hover acontecer suavemente. */
    }

    header .navegacao ul li a:hover {
        opacity: 0.8; /*esse é o efeito do mouse quando passa por cima */
    }
</style>

<header>
    <div class="logo">
        <img src="<?php echo $raiz; ?>imagens/logos.png" alt="Logo Pétalas, Açúcar e Receitas">
    </div>

    <div class="navegacao">
        <ul>
            <li><a href="<?php echo $raiz; ?>app/create.php">Adicionar</a></li>
            <li><a href="<?php echo $raiz; ?>app/update.php">Atualizar</a></li>
            <li><a href="<?php echo $raiz; ?>app/delete.php">Excluir</a></li>
            <li><a href="<?php echo $raiz; ?>app/select.php">Ver todas</a></li>
            <li><a href="<?php echo $raiz; ?>app/select_w.php">Pesquisar</a></li>
            <li><a href="<?php echo $raiz; ?>app/inicio.php">Início</a></li>
            <li><a href="<?php echo $raiz; ?>login/sair.php">Sair</a></li>
        </ul>
    </div>
</header>