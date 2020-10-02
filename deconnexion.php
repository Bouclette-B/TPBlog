<?php
    session_start();
    include('./includes/navbar.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_destroy();
            header('Location: index.php');
    }
?>
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <h2 class="col-6">Déconnexion</h2>
            <div class="col-3"></div>
        </div>
        <div class="row">
            <div class="col-3"></div>
                <form action="" class="col-6" method="post">
                    <div class="form-group">
                        <label for="logOut">Vous voulez vraiment partir ? :(</label>
                        <input type="submit" name="logOut" value="Se déconnecter" class="btn btn-dark">
                    </div>
                </form>
            <div class="col-3"></div>
        </div>
    </div>
    <?php include('./includes/scripts.html');?>