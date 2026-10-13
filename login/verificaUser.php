<?php 

if(session_status() == PHP_SESSION_NONE){//se a sessão ainda não tiver sido iniciada
    session_start();
}

if(!isset($_SESSION['usuario_id'])){ //se a sessão do usuario não está definida
    header("Location: ../login/entrar.php");//leve ele até a página de login
    exit();//quando fizer isso encerre o código
}

?>