<?php
    session_start();
    include('navbar.php');
?>
<body>

    <h1>
        Bienvenue <?php 
            if(isset($_SESSION['pseudo'])){
                echo $_SESSION['pseudo'] . ' !';
            } else {
                echo 'sur mon super blog !';
            }?> 
    </h1>
    <?php
        try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', '');
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
        $reponse = $bdd->query('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts ORDER BY dateCreation LIMIT 5');
        while($data = $reponse->fetch())
        {?>
            <div class=post>
                <h2><?= strip_tags($data['titre']); ?> écrit le <?= strip_tags($data['date']); ?></h2>
                <p class=contenu><?= strip_tags($data['contenu']); ?></p>
                <a href="commentaires.php?id=<?= strip_tags($data['id']); ?>">Commentaires...</a>
            </div><?php
        }
        if(!isset($_SESSION['pseudo'])){
            ?><a class="btn btn-dark" href="inscription.php" role="button">S'inscrire</a>
        <a href="connexion.php" class="btn btn-dark" role="button">Connexion</a><?php
        } else {
            ?><a class="btn btn-dark" href="deconnexion.php" role="button">Se déconnecter</a><?php
        }
    ?>
<!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script></body>
</html>