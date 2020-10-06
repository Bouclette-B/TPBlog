<?php
    function setSessionStart() {
        session_start();
    }
    function setHeader() {
        header('Location: index.php');
    }
    require('model.php');
    $member = getMember($db);
    $pageTitle = getPageTitle($db);
    require('./views/logInView.php');
