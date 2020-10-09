<?php
require ('./controller/controller.php');

try {
    if(isset($_GET['action'])) {
        $action = $_GET['action'];
        if($action == 'listPosts') {
            listPosts();
        }
        elseif ($action == 'post') {
            if(isset($_GET['id']) && !(preg_match("#[^0-9]+#", $_GET['id'])) && strlen($_GET['id']) <= 3) { 
                post();
            }
            else {
                throw new Exception('Article non trouvé.');
            }
        }
        elseif ($action == 'logIn'){
            logIn();
        }
        elseif ($action == 'subscribe') {
            subscribe();
        }
        elseif ($action == 'logOut'){
            logOut();
        }
        elseif($action == 'modifyComment') {
            modifyComment();
        }
    }
    else {
        listPosts();
    }
}
catch (Exception $e) {
    $error = $e->getMessage();
    $pageTitle = 'Erreur :(';
    require('./views/errorView.php');
}
