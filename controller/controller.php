<?php
require('./model/model.php');
require_once('./model/PostManager.php');
require_once('./model/CommentManager.php');

function listPosts() {
    session_start();
    $postManager = new \Bouclette\TPBlog\Model\PostManager();
    $posts = $postManager->getPosts();
    $pageTitle = 'Accueil';
    require('./views/listPostsView.php');
}

function posts() {
    session_start();
    $idPost = htmlspecialchars($_GET['id']);
    $postContent = (isset($_POST['content'])) ? htmlspecialchars($_POST['content']) : NULL;
    $postManager = new \Bouclette\TPBlog\Model\PostManager();
    $post = $postManager->getPost($idPost);
    if(empty($post)){
        throw new Exception('Article non trouvé.');
    }
    $commentManager = new \Bouclette\TPBlog\Model\CommentManager;
    $commentManager->insertComment($idPost, $postContent);
    $comments = $commentManager->getComments($idPost);
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
        $member = getMember($_POST['pseudo']);
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
        } else {
            require('./views/subscribeView.php');
        } 
    } else {
        require('./views/subscribeView.php');
    }
    
}

function logOut() {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_destroy();
        header('Location: index.php');
    }
    $pageTitle = 'Déconnexion';
    require('./views/logOutView.php');
}

function modifyComment() {
    session_start();
    $idComment = htmlspecialchars($_GET['id']);
    $commentManager = new \Bouclette\TPBlog\Model\CommentManager;
    $comment = $commentManager->getComment($idComment);
    $idPost = $comment['idPost'];
    $newComment = (isset($_POST['newComment'])) ? htmlspecialchars($_POST['newComment']) : NULL;
    $commentManager->updateComment($newComment, $idComment, $idPost);
    $pageTitle = 'Modifier votre commentaire';
    require('./views/modifyCommentView.php');
}