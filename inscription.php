<?php
session_start();
include('navbar.php');
?>

    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <h2 class="col-6">Formulaire d'inscription</h2>
            <div class="col-3"></div>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <form action="inscription.php" method="post" class="col-6">
                <div class="form-group">
                    <label for="pseudo">Pseudo :</label>
                    <input type="text" name="pseudo" class="form-control" required value="<?php
                            if (isset($_POST['pseudo'])) {
                                echo $_POST['pseudo'];
                            } else {
                                echo '';
                            }?>">
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
                    <input type="email" name="email" class="form-control" required value="<?php
                            if (isset($_POST['email'])) {
                                echo $_POST['email'];
                            } else {
                                echo '';
                            }?>">
                </div>
                <?php
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
                ?>
                <div class="form-group">
                    <p><em>Êtes-vous un robot ? Pour être sûr, répondez à la question :)</em></p>
                    <label for="captchaQuestion">
                        <?php
                            if (!isset($_POST['captchaAnswer'])) {
                                $_SESSION['questionAsked'] = $questionArray[$idQuestionAsked]['question'];
                                $_SESSION['answer'] = $questionArray[$idQuestionAsked]['answer'];
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
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    if (isset($_POST['pseudo']) && isset($_POST['passW']) && isset($_POST['checkPassW']) && isset($_POST['email'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $passW = htmlspecialchars($_POST['passW']);
        $checkPassW = htmlspecialchars($_POST['checkPassW']);
        $email = htmlspecialchars($_POST['email']);
        $userAnswer = htmlspecialchars(($_POST['captchaAnswer']));

        $req = $bdd->prepare('SELECT * FROM members WHERE pseudo = ?');
        $req->execute(array($pseudo));

        $data = $req->fetch();

        if (empty($data['pseudo'])) {
            $req->closeCursor();
            if ($passW === $checkPassW) {
                if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {
                    if (in_array($userAnswer, $_SESSION['answer'])) {
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
                    } else {
                        echo 'Tu as mal répondu à la question. Essaie encore !';
                    }
                } else {
                    echo 'Adresse mail non valide.';
                }
            } else {
                echo 'Erreur mot de passe. Réessayez !';
            }
        } else {
            echo 'Ce pseudo est déjà pris :(';
        }
    }
    ?>

    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</body>

</html>