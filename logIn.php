<?php
    include('./includes/navbar.php');
    function setSessionStart() {
        session_start();
    }
    function setHeader() {
        header('Location: index.php');
    }
    require('model.php');
    $req = checkPseudo ();
    require('./views/logInView.php');
    include('./includes/scripts.html');