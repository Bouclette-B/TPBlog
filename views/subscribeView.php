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
                    <label for="captchaQuestion">
                        <?php
                            if (!isset($_POST['captchaAnswer'])) {
                                [$_SESSION['questionAsked'], $_SESSION['answer']]= getCaptchaQuestion();
                            }
                            echo  $_SESSION['questionAsked'] 
                        ?></label>
                    <input type="text" name="captchaAnswer" class="form-control" required>
                </div>
                <input type="submit" class="btn btn-dark" value="Envoyer">
            </form>
            <div class="col-3"></div>
        </div>
    </div>
    
    <?php
    include('./includes/scripts.html');
    
    if (!(isset($_POST['pseudo']) && isset($_POST['passW']) && isset($_POST['checkPassW']) && isset($_POST['email']))) {
        die();
    }

    [$pseudo, $passW, $checkPassW, $email, $userAnswer] = setUserInfo();
    $data = $req->fetch();
    if (!empty($data['pseudo'])) {
        echo 'Ce pseudo est déjà pris !';
        die();
    }
    $req->closeCursor();

    if (!($passW === $checkPassW)) {
        echo 'Erreur de mot de passe.';
        die();
    }

    if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {
        echo 'Adresse mail non valide.';
        die();
    }

    if (!in_array($userAnswer, $_SESSION['answer'])) {
        echo 'Tu as mal répondu à la question. Essaie encore !';
        die();
    }

    $passW = password_hash($passW, PASSWORD_DEFAULT);
    $req2 = $bdd->prepare('INSERT INTO members (id, pseudo, passW, email, dateInscription) VALUES (NULL, :pseudo, :passW, :email, CURDATE())');
    $req2->execute(array(
        'pseudo' => $pseudo,
        'passW' => $passW,
        'email' => $email
    ));
    ?>
        <div class="row">
            <div class="col-3"></div>
            <p class="col-6">GG ! Inscription réussie :)</p>
            <div class="col-3"></div>
        </div>
    <?php

function writeUserInfo ($userInfo) {
    if (isset($_POST[$userInfo])) {
        echo $_POST[$userInfo];
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

function setUserInfo () {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $passW = htmlspecialchars($_POST['passW']);
    $checkPassW = htmlspecialchars($_POST['checkPassW']);
    $email = htmlspecialchars($_POST['email']);
    $userAnswer = htmlspecialchars($_POST['captchaAnswer']);
    return [$pseudo, $passW, $checkPassW, $email, $userAnswer];
    }
?>