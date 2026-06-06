<?php
session_start(); //inicia a sessão

session_destroy(); //destroi a sessão

header('Location: login.php'); //joga ele pro login

?>