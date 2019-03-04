<?php
    require_once("config.php");
    #On détruit la session
    $_SESSION = array();
    session_destroy();
    #On redirige vers la page d'accueil
    header('Location: connexion.php');
    exit;
?>