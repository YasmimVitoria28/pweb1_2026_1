<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start(); // se não existir uma seaaão na pagina, ele inicia uma
    }

    if(!isset($_SESSION['usuario_id'])){ //verifica se ta vazio
        header('Location: ../../../admin/login.php'); //verifica se a sessão ta logada, se não estiver ele joga la pra raiz
    }

?>