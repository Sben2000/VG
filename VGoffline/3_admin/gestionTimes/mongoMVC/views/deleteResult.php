    <link href="../css/style.css"	rel="stylesheet">

<div class="feedback">
        <?php
            //retour du resultat $response affiché à l'utilisateur
            if(@$response == "success"){
                ?>
                <p class="success" style='color:green'><strong>L'accès a bien été supprimé</strong></p>

                <?php
            }else{
                ?>
                    <p class="error" style ='color:darkred'><?=@$response?></p>
                <?php
            }
        ?>
      </div>
      <div >
        <button type="button" class="backToListButton"><a href="index.php?action=list">Revenir à la liste</a></button>
      </div>
