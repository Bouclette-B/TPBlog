<?php
    session_start();
    require('model.php');
    
    $posts = getPosts($db);
    $pageTitle = getPageTitle($db);
    require('./views/indexView.php');