
<body>
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
while($data = $answer->fetch())
    {?>
    <div class="container"></div>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <h2><?= strip_tags($data['titre']); ?> écrit le <?= strip_tags($data['date']); ?></h2>
                <p class=contenu><?= strip_tags($data['contenu']); ?></p>
                <a href="post.php?id=<?= strip_tags($data['id']); ?>">Commentaires...</a>
            </div>
            <div class="col-2"></div>
        </div><?php
    }?>
        <div class="row row-button">
            <div class="col-2"></div>
            <div class="col-8">
                <?php if(!isset($_SESSION['pseudo'])){?>
                    <a class="btn btn-dark" href="inscription.php" role="button">S'inscrire</a>
                    <a href="connexion.php" class="btn btn-dark" role="button">Connexion</a><?php
                } else {?>
                    <a class="btn btn-dark" href="deconnexion.php" role="button">Se déconnecter</a><?php
                }?>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
<?php 
    $answer->closeCursor();
    include('./includes/scripts.html');?>