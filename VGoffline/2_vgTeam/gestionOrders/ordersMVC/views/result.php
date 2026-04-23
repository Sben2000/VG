    <link href="../css/style.css"	rel="stylesheet">

<div class="feedback">
        <?php
            //retour du resultat $response affiché à l'utilisateur
                //si le resultat de la function est successXXXX
            if(@$response == "successCreate"){
                ?>
                <!--afficher : -->
                <p class="success" style='color:green'><strong>La commande a été créée avec succès!</strong></p>

                <?php
            }elseif(@$response == "successEdit"){
                ?>
                <!--afficher : -->
                <p class="success" style='color:green'><strong>La modification a bien été réalisée !</strong></p>

                <?php
           }elseif(@$response == "successDelete"){
                                ?>
                <!--afficher : -->
                <p class="success" style='color:green'><strong>La commande a bien été supprimé !</strong></p>

                <?php
            }else{
                ?><!--sinon retourner le résultat de la sous function qui a soulevé une erreur dans registerUser()-->
                    <p class="error" style ='color:darkred'><strong><?=@$response?></strong></p>
                <?php
            }
        ?>
      </div>
      <div >
        <button type="button" class="backToListButton"><a href="index.php?action=list">Revenir à la liste</a></button>
      </div>
