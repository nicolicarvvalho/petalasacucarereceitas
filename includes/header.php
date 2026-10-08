

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
        width: auto;/*como ja foi definid */
        display: block;
    }

    header .navegacao {
        background-color: #d63765;
        width: 100%;
        padding: 14px 0;
    }

    header .navegacao ul {
        list-style: none;
        padding: 0 20px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
    }

    header .navegacao ul li {
        display: inline-block;
    }

    header .navegacao ul li a {
        color: #f6edde;
        text-decoration: none;
        font-weight: bold;
        font-size: 1.1rem;
        font-family: sans-serif;
        transition: opacity 0.2s;
    }

    header .navegacao ul li a:hover {
        opacity: 0.8;
    }
</style>

<header>
    <div class="logo">
<img src="<?php echo $base; ?>imagens/logos.png" alt="Logo Pétalas, Açúcar e Receitas">    </div>

    <div class="navegacao">
        <ul>
            <li><a href="<?php echo $base; ?>app/create.php">Adicionar</a></li>
            <li><a href="<?php echo $base; ?>app/update.php">Atualizar</a></li>
            <li><a href="<?php echo $base; ?>app/delete.php">Excluir</a></li>
            <li><a href="<?php echo $base; ?>app/select.php">Ver todas</a></li>
            <li><a href="<?php echo $base; ?>app/select_w.php">Pesquisar</a></li>
            <li><a href="<?php echo $base; ?>inicio.php">Início</a></li>
            <li><a href="<?php echo $base; ?>login/sair.php">Sair</a></li>
        </ul>
    </div>
</header>