<?php
class FormChecker
{
    protected $userManager;

    public function __construct($userManager)
    {
        $this->userManager = $userManager;
    }

    public function checkForm($subscribeForm, &$errorMsg) {
        $member = $this->userManager->getMember($subscribeForm["pseudo"]);
        if (!empty($member['pseudo'])) {
            $errorMsg = 'Ce pseudo est déjà pris !';
            return false;
        }
    
        if (!($subscribeForm["passW"] === $subscribeForm["checkPassW"])) {
            $errorMsg = 'Erreur de mot de passe.';
            return false;
        }
    
        if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $subscribeForm["email"])) {
            $errorMsg = 'Adresse mail non valide.';
            return false;
        }
    
        if (!in_array($subscribeForm["userAnswer"], $_SESSION['captchaAnswer'])) {
            $errorMsg = 'Tu as mal répondu à la question. Essaie encore !';
            return false;
        }
        return true;
    }

    public function setCaptcha() {
        return [$_SESSION['captchaQuestion'], $_SESSION['captchaAnswer']] = $this->getCaptcha();
    }

    public function memorizeCaptcha($captchaQuestion, $captchaAnswer) {
        return [$captchaQuestion, $captchaAnswer] = [$_SESSION['captchaQuestion'], $_SESSION['captchaAnswer']];
    }

    public function getCaptcha() {
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

}