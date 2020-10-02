<?php
    include('./includes/navbar.php');
    function setSessionStart() {
        session_start();
    }
    function setHeader() {
        header('Location: index.php');
    }

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $req = $bdd->prepare('SELECT id, pseudo, passW FROM members WHERE pseudo = ?');
        $req->execute(array($_POST['pseudo']));
    }
    require('affichageConnexion.php');
    include('./includes/scripts.html');?>