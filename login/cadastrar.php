<?php
require_once __DIR__ . '/../includes/functions.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (cadastraUser($pdo, $email, $senha)) {
        header("Location: ../inicio.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>

<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f6edde; 
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh; 
}

.telaCadastro {
    display: flex;
    width: 900px;
    max-width: 95%;
    height: 500px;
    background-color: #f6edde;

}

.ladoEsquerdo {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
}

.logo {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.logo img {
    width: 150%;     
    max-width: none; 
    height: auto;
}


.ladoDireito {
    flex: 1; 
    background-color: #d63765; 
    display: flex;
    flex-direction: column; 
    justify-content: center;
    align-items: center;
    padding: 40px;
}

.cadastro {
    width: 100%;
    max-width: 320px; 
}

.ladoDireito h2 {
    color: #f6edde;
    font-family: 'Georgia', serif; 
    font-size: 2rem;
    text-align: center;
    margin-bottom: 35px;
    margin-top: 0;
}

.email {
    margin-bottom: 25px;
    display: flex;
    flex-direction: column;
}

.email label {
    color: #f6edde;
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 8px;
}

.email input {
    background-color: transparent;
    border: 2px solid #f6edde; 
    padding: 12px;
    color: #f6edde;
    font-size: 1rem;
    outline: none;
}

.email input::placeholder {
    color: #f6edde;
    opacity: 0.7;
}

.botaos {
    display: block;
    width: 100%; 
    background-color: #f6edde; 
    color: #d63765;            
    border: none;
    padding: 12px 0;
    font-size: 1.1rem;
    font-weight: bold;
    font-family: 'Georgia', serif;
    cursor: pointer;
    transition: background-color 0.2s;
    margin-bottom: 10px;
}

.botaos:hover {
    background-color: #f6edde; 
}

.botaol {
    display: block;
    width: 100%;
    background-color: transparent;
    color: #f6edde;
    border: 1px solid #f6edde;
    padding: 8px 0;
    font-size: 0.9rem;
    cursor: pointer;
    opacity: 0.8;
}

.botaol:hover {
    opacity: 1;
}
</style>
    
</head>

<body>

<div class="telaCadastro">
    
    <div class="ladoEsquerdo">
    <div class="logo">
        <img src="../imagens/logos.png" alt="Pétalas, Açúcar e Receitas Logo">
    </div>
</div>

    <div class="ladoDireito">

        <h2>Criar Conta</h2>

        <form action="" method="post" class="cadastro">
            
            <div class="email">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required>
            </div>

            <div class="email">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Digite uma senha forte" required>
            </div>

            <input type="submit" value="Criar Conta" class="botaos">
            
            <input type="reset" value="Limpar Campos" class="botaol">

        </form>

    </div>

</div> 

</body>
</html>
