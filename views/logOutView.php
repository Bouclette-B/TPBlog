<?php ob_start(); ?>
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
                    <div><input type="submit" name="logOut" value="Se déconnecter" class="btn btn-dark"></div>
                </div>
            </form>
        <div class="col-3"></div>
    </div>
</div>
<?php
$content = ob_get_clean();
require('./template/template.php');