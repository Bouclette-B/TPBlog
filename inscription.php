<?php
session_start();
include('./includes/navbar.php');

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

try {
    $bdd = new PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $req = $bdd->prepare('SELECT * FROM members WHERE pseudo = ?');
    $req->execute(array($_POST['pseudo']));
}
require('affichageInscription.php');
include('./includes/scripts.html');
?>