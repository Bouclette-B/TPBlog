<?php ob_start(); ?>
<div class="container">
    <div class="row">
        <div class="col-3"></div>
        <h2 class="col-6">Formulaire d'inscription</h2>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <form action="index.php?action=subscribe" method="post" class="col-6">
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
        if(!empty($formError)){
            ?>
            <div class="row">
                <div class="col-3"></div>
            <div class="col-6 alert alert-danger">
                <?= $formError; ?>
            </div>
            <div class="col-3"></div>
            </div>
            <?php
        } else {
            
        }

function writeUserInfo($userInfo) {
    if (isset($_POST[$userInfo])) {
        echo htmlspecialchars($_POST[$userInfo]);
    } else {
        echo '';
    }
}

function getCaptchaQuestion () {
    $questionArray = array(
        'question1' => array(
            'question' => 'Quelle est la couleur du petit chaperon rouge ?',
            'answer' => array('rouge', 'red')
        ),
        'question2' => array(
            'question' => 'Combien font deux plus deux ?',
            'answer' => array('4', 'quatre')
        ),
        'question3' => array(
            'question' => 'Dans "Blanche neige et les 7 nains", combien y a t-il de nains ?',
            'answer' => array('sept', '7')
        ),
        'question4' => array(
            'question' => 'Combien font cinq plus zéro ?',
            'answer' => array('cinq', '5')
        )
    );
    $idQuestionAsked = array_rand($questionArray);
    $questionAsked = $questionArray[$idQuestionAsked]['question'];
    $answerOfQuestionAsked = $questionArray[$idQuestionAsked]['answer'];
    return [$questionAsked, $answerOfQuestionAsked];
}
$content = ob_get_clean();
require('./template/template.php');

function ggSubscribe() {?>
    <div class="row">
            <div class="col-3"></div>
            <p class="col-6">GG ! Inscription réussie :)</p>
            <div class="col-3"></div>
        </div>
        <?php ;
}
?>