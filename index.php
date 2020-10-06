<?php
    session_start();
    require('model.php');
    include('./includes/navbar/navbar.php');
    

    $posts = getPosts($db);
    require('./views/indexView.php');