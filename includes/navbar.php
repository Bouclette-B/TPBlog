<!DOCTYPE html>
<html lang="fr">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?= getPageTitle()?></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-liht">
        <a href="index.php" class="navbar-brand">BLOG</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle-navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav"><?php writeNavBar();?>    
            </div>
        </div>
    </nav>

<?php 

function getPageTitle (){
    $getPageUrl = explode('/', $_SERVER['SCRIPT_FILENAME']);
    $getPageUrl = end($getPageUrl);
    $getPageUrl = explode('.', $getPageUrl);
    $getPageUrl = $getPageUrl[0];
    $json = file_get_contents('./config/navbar_config.json');
    $jsonInfo = json_decode($json, true);
    $pageTitles = $jsonInfo[1]['pageTitleArray'][0];
    if($getPageUrl == 'post'){
        $pageTitle = getPostTitle();
    } else {
    $pageTitle = $pageTitles[$getPageUrl];
    }
    return $pageTitle;
}

function writeNavBar () {
    getNavLinks('everyone');
    if(isset($_SESSION['pseudo'])){
        getNavLinks('logedIn');
    } else {
        getNavLinks('notLogedIn');
    }
}

function getPostTitle () {
try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
findPostTitle ($bdd);
}

function getNavLinks ($memberStatus) {
    $json = file_get_contents('./config/navbar_config.json');
    $jsonInfo = json_decode($json, true);
    $navLinks = $jsonInfo[0][$memberStatus][0];
    foreach ($navLinks as $title => $url) {
        echo '<a href="' . $url . '"class=\'nav-link\'>' . $title . '</a>';
    }
}

function findPostTitle ($bdd) {
    $idPost = htmlspecialchars($_GET['id']);
$reponsePost = $bdd->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts WHERE id = ?');
$reponsePost->execute(array($idPost));
$data = $reponsePost->fetch();
echo $data['titre'];
$reponsePost->closeCursor();
}


?>