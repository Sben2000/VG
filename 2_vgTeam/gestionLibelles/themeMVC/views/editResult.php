
      <div class="feedback">
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
      <div class="backToList">
        <button type="button" class="btn btn-primary"><a href="index.php?action=list" >Revenir à la liste</a></button>
      </div>
