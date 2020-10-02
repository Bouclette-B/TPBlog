<?php
    include('navbar.php');
    function setSessionStart() {
        session_start();
    }
    function setHeader() {
        header('Location: index.php');
    }
?>

    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <h2 class="col-6">Connexion</h2>
            <div class="col-3"></div>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <form action="" method="post" class="col-6">
                <div class="form-group">
                    <label for="pseudo">Pseudo :</label>
                    <input type="text" name="pseudo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="passW">Mot de passe : </label>
                    <input type="password" name="passW" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="stayLogedIn">Rester connecté : </label>
                    <input type="checkbox" name="stayLogedIn">
                </div>
                <input type="submit" class="btn btn-dark" value="Envoyer">
            </form>
        </div>
    </div>
    <?php
        try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', '');
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        catch(Exception $e)
            {
                die('Erreur : '.$e->getMessage());
            }

        if(isset($_POST['pseudo']) && isset($_POST['passW'])) {
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $passW = htmlspecialchars($_POST['passW']);

            $req = $bdd->prepare('SELECT id, pseudo, passW FROM members WHERE pseudo = ?');
            $req->execute(array($pseudo));

            $result = $req->fetch();
            $correctPassword = password_verify($passW, $result['passW']);

            if(!$correctPassword){
               ?><div class="container">
                    <div class="row">
                        <div class="col-3"></div>
                        <p class="col-6">Mauvais mot de passe ou pseudo.</p>
                        <div class="col-3"></div>
                    </div>
                </div><?php
            } else {
                setSessionStart();
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['id'] = $result['id'];
                setHeader();
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
</html>