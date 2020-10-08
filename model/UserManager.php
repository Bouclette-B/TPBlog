<?php
require_once('./model/Manager.php');
class UserManager extends Manager
{
    public function getMember($pseudo) {
        $db = $this->dbConnect();
        $member = $db->prepare('SELECT * FROM members WHERE pseudo = ?');
        $member->execute(array($pseudo));
        return $member->fetch();
    }

    public function addNewMember ($passW, $pseudo, $email) {
        $db = $this->dbConnect();
        $passW = password_hash($passW, PASSWORD_DEFAULT);
        $req = $db->prepare('INSERT INTO members (id, pseudo, passW, email, dateInscription) VALUES (NULL, :pseudo, :passW, :email, CURDATE())');
        $req->execute(array(
            'pseudo' => $pseudo,
            'passW' => $passW,
            'email' => $email
        ));
        $req->closeCursor();
    }

    public function isUserConnected() {
        if(isset($_SESSION['pseudo'])){
            return $_SESSION['pseudo'];
        }return false;
    }
}