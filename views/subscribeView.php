<?php ob_start(); ?>
<div class="container">
    <div class="row">
        <div class="col-3"></div>
        <h2 class="col-6">Formulaire d'inscription</h2>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <form action="subscribe.php" method="post" class="col-6">
            <div class="form-group">
                <label for="pseudo">Pseudo :</label>
                <input type="text" name="pseudo" class="form-control" required value="<?php writeUserInfo('pseudo')?>">
            </div>
            <div class="form-group">
                <label for="passW">Mot de passe : </label>
                <input type="password" name="passW" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="checkPassW">Confirmez votre mot de passe : </label>
                <input type="password" name="checkPassW" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email : </label>
                <input type="email" name="email" class="form-control" required value="<?php writeUserInfo('email')?>">
            </div>
            <div class="form-group">
                <p><em>Êtes-vous un robot ? Pour être sûr, répondez à la question :)</em></p>
                <label for="captchaQuestion"><?php
                    if (!isset($_POST['captchaAnswer'])) {
                        [$_SESSION['questionAsked'], $_SESSION['answer']]= getCaptchaQuestion();
                    }
                    echo  $_SESSION['questionAsked'];
                    ?></label>
                <input type="text" name="captchaAnswer" class="form-control" required>
            </div>
                <input type="submit" class="btn btn-dark" value="Envoyer">
        </form>
        <div class="col-3"></div>
    </div>
    
    <?php

    if(!(checkForm($member))){
        $content = ob_get_clean();
        require('./template/template.php');
        die();
    }?>
    <div class="row">
        <div class="col-3"></div>
        <p class="col-6">GG ! Inscription réussie :)</p>
        <div class="col-3"></div>
    </div> 

<?php
$content = ob_get_clean();
require('./template/template.php');
?>