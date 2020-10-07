<?php ob_start(); ?>
<div class="container">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <h3>Erreur !</h3>
            <div class="alert alert-danger"><?= $error ?></alert-danger>
        </div>
        <div class="col-3"></div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require('./template/template.php');
?>