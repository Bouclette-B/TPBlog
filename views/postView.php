<?php
ob_start();
?> 
<div class="container">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h2><?=$post['title']?></h2>
            <p class="article-info"><em>Écrit le<?=$post['date']?></em></p>
            <p class="article-content"><?=$post['content']?></p>
        </div>
    </div>
</div>

<?php 
if($connectedUser){?>
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
<?php           
}?>
<div class="container">
<?php
foreach($comments as $comment){
    ?>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <p><strong><?=$comment['author']?></strong>, le <?=$comment['dateComments']?>
            <?php if($connectedUser == $comment['author']) {
                ?><em><a href="index.php?action=modifyComment&amp;id=<?=$comment['id']?>"> Modifier</a></em>
                <?php }
                ?></p>
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