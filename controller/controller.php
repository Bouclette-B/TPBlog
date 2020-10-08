<?php
require_once('./model/PostManager.php');
require_once('./model/CommentManager.php');
require_once('./model/UserManager.php');
require_once('./model/FormChecker.php');

function listPosts() {
    session_start();
    $postManager = new PostManager();
    $posts = $postManager->getPosts();
    $pageTitle = 'Accueil';
    require('./views/listPostsView.php');
}

function post() {
    session_start();
    $idPost = (isset($_GET['id']) && strlen($_GET['id'])) ? htmlspecialchars($_GET['id']) : NULL;
    $comment = (isset($_POST['content'])) ? htmlspecialchars($_POST['content']) : NULL;
    $postManager = new PostManager();
    $userManager = new UserManager();
    $post = $postManager->getPost($idPost);
    if(empty($post)){
        throw new Exception('Article non trouvé.');
    }
    $commentManager = new CommentManager;
    $connectedUser = $userManager->isUserConnected();
    $commentManager->insertComment($idPost, $comment);
    $comments = $commentManager->getComments($idPost);
    $pageTitle = $post['titre'];
    require('./views/postView.php');
}

function logIn(){
    $userManager = new UserManager;
    $pseudo = (isset($_POST['pseudo'])) ? $_POST['pseudo'] : NULL;
    $member = $userManager->getMember($pseudo);
    $pageTitle = 'Connexion';
    require('./views/logInView.php');
}

function subscribe() {
    session_start();
    $pageTitle = 'Inscription';
    $formError = "";
    $subscriptionSuccess = false;
    $userManager = new UserManager;
    $formChecker = new FormChecker($userManager);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $member = $userManager->getMember($_POST['pseudo']);
        $subscribeForm = [
            "pseudo" => htmlspecialchars($_POST['pseudo']),
            "passW" => htmlspecialchars($_POST['passW']),
            "checkPassW" => htmlspecialchars($_POST['checkPassW']),
            "email" => htmlspecialchars($_POST['email']),
            "userAnswer" => htmlspecialchars($_POST['captchaAnswer'])
        ];
        if($formChecker->checkForm($subscribeForm, $formError)){
            $userManager->addNewMember($subscribeForm["passW"], $subscribeForm["pseudo"], $subscribeForm["email"]);
            $subscriptionSuccess = true;
            $_SESSION['pseudo'] = $subscribeForm["pseudo"];
        }
    }
    require('./views/subscribeView.php');
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
    $commentManager = new CommentManager;
    $comment = $commentManager->getComment($idComment);
    $idPost = $comment['idPost'];
    $newComment = (isset($_POST['newComment'])) ? htmlspecialchars($_POST['newComment']) : NULL;
    $commentManager->updateComment($newComment, $idComment, $idPost);
    $pageTitle = 'Modifier votre commentaire';
    require('./views/modifyCommentView.php');
}