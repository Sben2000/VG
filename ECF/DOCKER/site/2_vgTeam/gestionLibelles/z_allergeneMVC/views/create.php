<?php
$title = 'Ajouter libelle';


ob_start();//début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<!--redirigé préalablement vers store.php mais désormais vers action=store suite au routage via index.php-->
<form action="index.php?action=store" method="post"><!--Les données seront envoyées dans store.php (action = store.php)-->
    <div class="form-group">
        <label for="nom">Libelle de allergene</label>
        <input type="text"  name="libelle">
    </div>
    <div >
        <!--au clic, soumettra le form à action=update pour l'id et le libellé concerné-->
        <button class="addButton">Ajouter</button>
        <!--retour à la list-->
        <button class="backToListButton"><a href="index.php?action=list" >Revenir à la liste</a></button>
    </div> 
    
             <?php
            //retour du resultat $response affiché à l'utilisateur
                //si le resultat de la function est success
            if(@$response == "success"){
                ?>
                    <p class="success" style='color:green'>La donnée a bien été enregistrée !</p>
                    <p class="success" style='color:darkblue'>⮕ Ajoutez de nouveau ou revenez à la liste</p>
                <?php
            }else{
                ?><!--sinon retourner le résultat de la sous function qui a soulevé une erreur dans registerUser()-->
                    <p class="error" style ='color:darkred'><?=@$response?></p>
                <?php
            }
        ?>
     
</form>

<?php $content = ob_get_clean(); //fin de la récupération ci dessus et assignement à $content défini dans views/layout?>
<?php include_once 'views/layout.php';?>
