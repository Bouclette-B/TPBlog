<?php
require('model.php');

function listPosts() {
    session_start();
    $posts = getPosts();
    $pageTitle = 'Accueil';
    require('./views/listPostsView.php');
}

function posts() {
    session_start();
    $idPost = htmlspecialchars($_GET['id']);
    $postContent = (isset($_POST['content'])) ? htmlspecialchars($_POST['content']) : NULL;
    $post = getPost($idPost);
    insertComment($idPost, $postContent);
    $comments = getComments($idPost);
    $pageTitle = $post['titre'];
    require('./views/postView.php');
}

function logIn(){
    $pseudo = (isset($_POST['pseudo'])) ? $_POST['pseudo'] : NULL;
    $member = getMember($pseudo);
    $pageTitle = 'Connexion';
    require('./views/logInView.php');
    
}

function subscribe($db) {
    session_start();
    $pageTitle = 'Inscription';
    $formError = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $member = getMember($db, $_POST['pseudo']);
        $subscribeForm = [
            "pseudo" => htmlspecialchars($_POST['pseudo']),
            "passW" => htmlspecialchars($_POST['passW']),
            "checkPassW" => htmlspecialchars($_POST['checkPassW']),
            "email" => htmlspecialchars($_POST['email']),
            "userAnswer" => htmlspecialchars($_POST['captchaAnswer']),
        ];
        if(checkForm($subscribeForm, $formError)){
            addNewMember($subscribeForm["passW"], $subscribeForm["pseudo"], $subscribeForm["email"]);
            require('./views/subscribeView.php');
            ggSubscribe();
        } 
    }
    require('./views/subscribeView.php');
}

function logOut($db) {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_destroy();
        header('Location: index.php');
    }
    $pageTitle = 'Déconnexion';
    require('./views/logOutView.php');
}