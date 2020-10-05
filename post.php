<?php
    session_start();
    include('./includes/navbar.php');
    require('model.php');

    $idPost = htmlspecialchars($_GET['id']);
    $answerPost = selectPost($idPost);
    insertComment($idPost);
    $answerComment = getComments($idPost);

    require('./views/postView.php');
    include('./includes/scripts.html');