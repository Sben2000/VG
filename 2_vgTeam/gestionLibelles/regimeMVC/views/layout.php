<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href=<?php require_once LIBELLESROOT."/css/style.css" ?>	rel="stylesheet"/>
    <?php require_once "routes/rootPath.php" ?>
    <?php require_once LIBELLESROOT."/includes/navbar.php" ?>
</head>

<body>
    <div class="container mt-2">
        <h2><?= $title ?></h2>
        <hr>
        <?=$content ?>
        
             <?php
            //retour du resultat $response affiché à l'utilisateur
                //si le resultat de la function est success
            if(@$response == "success"){
                ?>
                <!--afficher : inscription réussi-->
                <p class="success" style='color:green'>La donnée a bien été enregistrée</p>

                <?php
            }else{
                ?><!--sinon retourner le résultat de la sous function qui a soulevé une erreur dans registerUser()-->
                    <p class="error" style ='color:darkred'><?=@$response?></p>
                <?php
            }
        ?>

    </div>

</body>

</html>