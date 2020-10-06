<?php
    session_start();
    require('model.php');

    $idPost = htmlspecialchars($_GET['id']);
    $post = getPost($db, $idPost);
    insertComment($db, $idPost);
    $comments = getComments($db, $idPost);
    $pageTitle = $post['titre'];
    require('./views/postView.php');