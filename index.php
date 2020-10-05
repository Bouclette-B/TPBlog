<?php
    session_start();
    include('./includes/navbar.php');
    require('model.php');

    $answer = getPosts();
    require('./views/indexView.php');