<?php
    include('./includes/navbar/navbar.php');
    function setSessionStart() {
        session_start();
    }
    function setHeader() {
        header('Location: index.php');
    }
    require('model.php');
    $member = getMember($db);
    require('./views/logInView.php');
    include('./includes/scripts.html');