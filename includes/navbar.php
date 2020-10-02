<?php 
$pageTitleArray = array(
    'index' => 'Accueil',
    'inscription' => 'Inscription',
    'connexion' => 'Connexion',
    'article' => 'Article',
    'deconnexion' => 'Déconnexion');

    $getTitle = function () use ($pageTitleArray){
        $getPageUrl = explode('/', $_SERVER['SCRIPT_FILENAME']);
        $getPageUrl = end($getPageUrl);
        $getPageUrl = explode('.', $getPageUrl);
        $getPageUrl = $getPageUrl[0];
        if($getPageUrl == 'article'){
            $getPageUrl = getArticleTitle();
        } else {
        $getPageUrl = $pageTitleArray[$getPageUrl];
        }
        return $getPageUrl;
    };

    function getArticleTitle () {
    try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', '');
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    $idPost = htmlspecialchars($_GET['id']);
    $reponsePost = $bdd->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts WHERE id = ?');
    $reponsePost->execute(array($idPost));
    $data = $reponsePost->fetch();
    echo $data['titre'];
    $reponsePost->closeCursor();
}?>

<!DOCTYPE html>
<html lang="fr">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?= $getTitle()?></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-liht">
        <a href="index.php" class="navbar-brand">BLOG</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle-navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav">
                <a href="index.php" class="nav-link">Accueil</a>
                <a href="inscription.php" class="nav-link">Inscription</a>
                <a href="connexion.php" class="nav-link">Connexion</a>
            </div>
        </div>
    </nav>