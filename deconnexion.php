<?php
    session_start();
    include('navbar.php');
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
    
    
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>