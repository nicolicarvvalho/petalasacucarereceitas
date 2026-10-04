<style>
    header .logo {
        background-color: #f6edde;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px 0;
        width: 100%;
    }

    header .logo img {
        height: 100px;
        width: auto;
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
        <img src="../imagens/logos.png" alt="Logo Pétalas, Açúcar e Receitas">
    </div>

    <div class="navegacao">
        <ul>
            <li><a href="../app/create.php">Adicionar</a></li>
            <li><a href="../app/update.php">Atualizar</a></li>
            <li><a href="../app/delete.php">Excluir</a></li>
            <li><a href="../app/select.php">Ver todas</a></li>
            <li><a href="../app/select_w.php">Pesquisar</a></li>
            <li><a href="../inicio.php">Início</a></li>
            <li><a href="../login/sair.php">Sair</a></li>
        </ul>
    </div>
</header>