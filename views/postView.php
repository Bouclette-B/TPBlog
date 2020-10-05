<?php

if(preg_match("#[^0-9]+#", $idPost)) {
    echo '<p>RATÉ !</p>';
    die();
}

$data = $answerPost->fetch();
        if(empty($data)) {
            echo '<p>Article non trouvé.</p>';
        }
?> 

<div class="container">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h2><?=$data['titre']?></h2>
            <p class="article-info"><em>Écrit le<?=$data['date']?></em></p>
            <p class="article-content"><?=$data['contenu']?></p>
        </div>
    </div>
    <?php
    $answerPost->closeCursor();

    if(isset($idPost) && strlen($idPost) <= 3 && isset($_SESSION['pseudo'])){
        ?><div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <p><strong>COMMENTAIRES</strong></p>
                <form action="" method="post">
                    <p><textarea name="content" cols="60" rows="5">Écrivez votre commentaire</textarea></p>
                    <p><input type="submit" value="Envoyer"></p>
                </form>
            </div>
            <div class="col-2"></div>
        </div><?php           
        }

    while($data = $answerComment->fetch()){?>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
            <p><strong><?=$data['author']?></strong>, le <?=$data['dateComments']?></p>
            <p><em><?=$data['comment']?></em></p>
            </div>
        </div><?php
    }
    $answerComment->closeCursor();?>
    
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <a href="index.php">Retour à l'accueil</a>
        </div>
        <div class="col-2"></div>
    </div>
</div>