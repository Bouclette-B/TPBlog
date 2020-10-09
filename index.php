<?php
require ('./controller/controller.php');

$manager = new Manager;
$postManager = new PostManager;

try { 
    $action = $manager->isGet($_GET['action']);
    switch($action) {
        case 'listPosts' :
            listPosts();
            break;
        case 'post' :
            $postID = $manager->isGet($_GET['id']);
            $post = $postManager->checkPostExistence($postID);
            if($post) { 
                post();
            } else {
                throw new Exception('Article non trouvé.');
            }
            break;
        case 'logIn' :
            logIn();
            break;
        case 'subscribe' :
            subscribe();
            break;
        case 'logOut' :
            logOut();
            break;
        case 'modifyComment' :
            modifyComment();
            break;
        default :
            listPosts();
    }
}
    catch (Exception $e) {
    $error = $e->getMessage();
    $pageTitle = 'Erreur :(';
    require('./views/errorView.php');
}
