<?php
ob_start();
if(preg_match("#[^0-9]+#", $idPost)) {
    echo '<p>RATÉ !</p>';
    die();
}

if(empty($post)) {
    echo '<p>Article non trouvé.</p>';
}?> 
<div class="container">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h2><?=$post['titre']?></h2>
            <p class="article-info"><em>Écrit le<?=$post['date']?></em></p>
            <p class="article-content"><?=$post['contenu']?></p>
        </div>
    </div>
</div>

<?php 
if(isset($idPost) && strlen($idPost) <= 3 && isset($_SESSION['pseudo'])){?>
<div class="container">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <p><strong>COMMENTAIRES</strong></p>
            <form action="" method="post">
                <p><textarea name="content" cols="60" rows="5">Écrivez votre commentaire</textarea></p>
                <p><input type="submit" value="Envoyer"></p>
            </form>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<div class="container">
<?php           
}
foreach($comments as $comment){
    ?><div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <p><strong><?=$comment['author']?></strong>, le <?=$comment['dateComments']?></p>
            <p><em><?=$comment['comment']?></em></p>
        </div>
        <div class="col-2"></div>
    </div><?php
}?>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <a href="index.php">Retour à l'accueil</a>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<?php
$content = ob_get_clean();
require('./template/template.php');
?>