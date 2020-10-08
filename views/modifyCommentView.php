<?php ob_start(); ?>
<div class="container">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h2>Modifiez votre commentaire</h2>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h3>Votre ancien commentaire :</h3>
            <p><strong><?=$comment['author']?></strong>, le <?=$comment['dateComments']?></p>
            <p><em><?=$comment['comment']?></em></p>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <form action="" method="post">
                <p><textarea name="newComment" cols="60" rows="5">Écrivez votre nouveau commentaire</textarea></p>
                <p><input type="submit" value="Envoyer" class="btn btn-dark"></p>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require('./template/template.php');
?>