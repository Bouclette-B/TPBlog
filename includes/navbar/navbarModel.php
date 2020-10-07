<?php

function writeNavBar () {
    getNavLinks('everyone');
    if(isset($_SESSION['pseudo'])){
        getNavLinks('logedIn');
    } else {
        getNavLinks('notLogedIn');
    }
}

function getNavLinks ($memberStatus) {
    $json = file_get_contents('./config/navbar_config.json');
    $jsonInfo = json_decode($json, true);
    $navLinks = $jsonInfo[$memberStatus][0];
    foreach ($navLinks as $title => $url) {
        echo '<a href="' . $url . '"class=\'nav-link\'>' . $title . '</a>';
    }
}
?>
