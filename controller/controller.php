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
    $postManager = new PostManager();
    $userManager = new UserManager();
    $commentIsPost = $postManager->isPost($_POST['content']);
    $comment = ($commentIsPost ? $commentIsPost : NULL);
    $idPost = htmlspecialchars($_GET['id']);
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
    $manager = new Manager;
    $pseudoIsPost = $manager->isPost($_POST['pseudo']);
    $pseudo = ($pseudoIsPost ? $pseudoIsPost: NULL);
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
    $manager = new Manager;
    $userPseudo = $manager->writeUserInfo($_POST['pseudo']);
    $userEmail = $manager->writeUserInfo($_POST['email']);
    $captchaUserAnswer = $manager->isPost($_POST['captchaUserAnswer']);
    if(!$captchaUserAnswer){
        [$captchaQuestion, $captchaAnswer] = $formChecker->setCaptcha();
    } else {
        $member = $userManager->getMember($_POST['pseudo']);
        $subscribeForm = [
            "pseudo" => htmlspecialchars($_POST['pseudo']),
            "passW" => htmlspecialchars($_POST['passW']),
            "checkPassW" => htmlspecialchars($_POST['checkPassW']),
            "email" => htmlspecialchars($_POST['email']),
            "userAnswer" => htmlspecialchars($_POST['captchaUserAnswer'])
        ];
        [$captchaQuestion, $captchaAnswer] = $formChecker->memorizeCaptcha($captchaQuestion, $captchaAnswer);
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
    $manager = new Manager;
    $methodIsPost = $manager->isPost();
    if ($methodIsPost) {
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
    $manager = new Manager;
    $newCommentIsPost = $manager->isPost($_POST['newComment']);
    $newComment = ($newCommentIsPost ? htmlspecialchars($newCommentIsPost) : NULL);
    $commentManager->updateComment($newComment, $idComment, $idPost);
    $pageTitle = 'Modifier votre commentaire';
    require('./views/modifyCommentView.php');
}