<?php
    session_start();
    include('./includes/navbar.php');
    require('model.php');

    $idPost = htmlspecialchars($_GET['id']);
    $answerPost = selectPost($db, $idPost);
    insertComment($db, $idPost);
    $answerComment = getComments($db, $idPost);

    require('./views/postView.php');
    include('./includes/scripts.html');