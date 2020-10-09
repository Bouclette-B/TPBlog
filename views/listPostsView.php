<?php ob_start(); ?>
<div class="container container-title">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h1 class="index">
                Bienvenue <?php 
                    if(isset($_SESSION['pseudo'])){
                        echo $_SESSION['pseudo'] . ' !';
                    } else {
                        echo 'sur mon super blog !';
                    }?> 
            </h1>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<?php
foreach ($posts as $post)
{?>
<div class="container"></div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h2><?= htmlspecialchars($post['title']); ?> écrit le <?= htmlspecialchars($post['date']); ?></h2>
            <p class=contenu><?= htmlspecialchars($post['content']); ?></p>
            <a href="index.php?action=post&amp;id=<?= htmlspecialchars($post['id']); ?>">Commentaires...</a>
        </div>
        <div class="col-2"></div>
    </div><?php
}?>
    <div class="row row-button">
        <div class="col-2"></div>
        <div class="col-8">
            <?php if(!isset($_SESSION['pseudo'])){?>
                <a class="btn btn-dark" href="index.php?action=subscribe" role="button">S'inscrire</a>
                <a href="index.php?action=logIn" class="btn btn-dark" role="button">Connexion</a><?php
            } else {?>
                <a class="btn btn-dark" href="index.php?action=logOut" role="button">Se déconnecter</a><?php
            }?>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require('./template/template.php'); 
?>