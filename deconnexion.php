<?php
    session_start();
    include('./includes/navbar.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_destroy();
            header('Location: index.php');
    }
require('affichageDeconnexion.html');
include('./includes/scripts.html');?>