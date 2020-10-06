<?php
session_start();
require('model.php');
$member = getMember($db);
$pageTitle = getPageTitle($db);

function checkForm($req) {
    if (!($_SERVER['REQUEST_METHOD'] === 'POST')) {
        return false;
    }

    [$pseudo, $passW, $checkPassW, $email, $userAnswer] = getUserInfo();
    $data = $req->fetch();
    if (!empty($data['pseudo'])) {
        echo 'Ce pseudo est déjà pris !';
        return false;
    }
    $req->closeCursor();

    if (!($passW === $checkPassW)) {
        echo 'Erreur de mot de passe.';
        return false;
    }

    if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {
        echo 'Adresse mail non valide.';
        return false;
    }

    if (!in_array($userAnswer, $_SESSION['answer'])) {
        echo 'Tu as mal répondu à la question. Essaie encore !';
        return false;
    }
    
    return [$pseudo, $passW, $checkPassW, $email, $userAnswer];
}

function getUserInfo () {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $passW = htmlspecialchars($_POST['passW']);
    $checkPassW = htmlspecialchars($_POST['checkPassW']);
    $email = htmlspecialchars($_POST['email']);
    $userAnswer = htmlspecialchars($_POST['captchaAnswer']);
    return [$pseudo, $passW, $checkPassW, $email, $userAnswer];
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

require('./views/subscribeView.php');

if(!(checkForm($member))){
    die();
}

[$pseudo, $passW, $checkPassW, $email, $userAnswer] = checkForm($req);
addNewMember($db, $passW, $pseudo, $email);

