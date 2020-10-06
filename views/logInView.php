<?php ob_start(); ?>
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
if(isset($_POST['pseudo']) && isset($_POST['passW'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $passW = htmlspecialchars($_POST['passW']);

    $correctPassword = password_verify($passW, $member['passW']);

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
$content = ob_get_clean();
require('./template/template.php');
