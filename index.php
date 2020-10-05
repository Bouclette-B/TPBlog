<?php
    session_start();
    include('./includes/navbar.php');
    require('model.php');

    $answer = getPosts($db);
    require('./views/indexView.php');