<?php
    session_start();
    include('./includes/navbar.php');
?>
        <?php
            try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', '');
            }
            catch(Exception $e)
            {
                die('Erreur : '.$e->getMessage());
            }
            $reponse = $bdd->query('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts ORDER BY dateCreation LIMIT 5');
           require('affichageAccueil.php');