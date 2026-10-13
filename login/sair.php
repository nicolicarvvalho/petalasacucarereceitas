<?php

session_start();//incia a sessão

session_unset();// apaga todos os valores que estavam guardados dentro das variáveis de sessão.
session_destroy(); //Destrói completamente o arquivo de sessão que estava salvo no servidor para aquele usuário específico.

header("Location: entrar.php");//redireciona para a página de login
exit;//encerra o código
?>