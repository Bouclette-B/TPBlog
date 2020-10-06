<?php
    session_start();
    include('./includes/navbar/navbar.php');
    require('model.php');

    $idPost = htmlspecialchars($_GET['id']);
    $post = getPost($db, $idPost);
    insertComment($db, $idPost);
    $comments = getComments($db, $idPost);

    require('./views/postView.php');
    include('./includes/scripts.html');