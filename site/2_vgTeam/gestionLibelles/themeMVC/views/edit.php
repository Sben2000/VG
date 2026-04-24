<?php
//La modification est plus ou moins ressamblant à la création, on duplique ainsi la page create que l'on réadapte en ajoutant les value

$title = 'Modifier le libelle';
//var_dump($libelle); pour voir les valeurs récupérées


ob_start();//début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<!--redirigé préalablement vers update.php mais désormais vers action=uptade suite au routage via index.php-->
<form action="index.php?action=update" method="post"><!--Les données seront envoyées dans update.php (action = update.php) pour être modifié-->
    <h3>Thème:</h3>
    <div >
            <!--on récupère l'id mais ne l'affiche pas (type="hidden) pour qu il ne soit pas modifié mais uniquement récupéré-->
        <input type="hidden" name="id" value=<?=$theme->theme_id?>>
    </div>
    <div >
        <label for="nom">Libelle: </label>
            <!--on ajoute la value dans laquelle on affiche la valeur récupérée de l'id si le user souhaite le modifier-->
            <!--cf function dans le controller editAction() qui récupère = view($id);-->
        <input type="text"  name="libelle" 
        value=<?php 
        /*Gestion du cas ou l'utilisateur efface la donnée et tente de la soumettre -> n'affiche pas les tags générés dans l'input par la BDD  */
        if(empty($theme->libelle)){
            echo "";
            }else{
                echo $theme->libelle;
                } ?>>
    </div>
    <div >
    <!--au clic, soumettra le form à action=update pour l'id et le libellé concerné-->
    <button class="modifyButton" >Modifier</button>
    <!--retour à la list-->
    <button class="backToListButton"><a href="index.php?action=list" >Revenir à la liste</a></button>
    </div>   
</form>

<?php $content = ob_get_clean(); //fin de la récupération ci dessus et assignement à $content défini dans views/layout?>
<?php include_once 'views/layout.php';?>
