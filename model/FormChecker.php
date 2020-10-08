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
    
        if (!in_array($subscribeForm["userAnswer"], $_SESSION['answer'])) {
            $errorMsg = 'Tu as mal répondu à la question. Essaie encore !';
            return false;
        }
        return true;
    }
}