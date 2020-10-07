<?php
require ('controller.php');


if(isset($_GET['action'])) {
    $action = $_GET['action'];
    if($action == 'listPosts') {
        listPosts($db);
    }
    elseif ($action == 'post') {
        if(isset($_GET['id']) && !(preg_match("#[^0-9]+#", $_GET['id']))) {
            posts($db);
        }
        else {
            echo '<p>Article non trouvé.</p>';
        }
    }
    elseif ($action == 'logIn'){
        logIn($db);
    }
    elseif ($action == 'subscribe') {
        subscribe($db);
    }
    elseif ($action == 'logOut'){
        logOut($db);
    }
}
else {
    listPosts($db);
}
