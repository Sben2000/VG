<?php
//La modification est plus ou moins ressamblant à la création, on duplique ainsi la page create que l'on réadapte en ajoutant les value

$title = 'Modifier libelle';
//var_dump($libelle); pour voir les valeurs récupérées


ob_start();//début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<!--redirigé préalablement vers update.php mais désormais vers action=uptade suite au routage via index.php-->
<form action="index.php?action=update" method="post"><!--Les données seront envoyées dans update.php (action = update.php) pour être modifié-->
    <h1>theme</h1>
    <div class="form-group">
            <!--on récupère l'id mais ne l'affiche pas (type="hidden) pour qu il ne soit pas modifié mais uniquement récupéré-->
        <input type="hidden" class="form-control" name="id" value=<?=$theme->theme_id?>>
    </div>
    <div class="form-group">
        <label for="nom">Libelle</label>
            <!--on ajoute la value dans laquelle on affiche la valeur récupérée de l'id si le user souhaite le modifier-->
            <!--cf function dans le controller editAction() qui récupère = view($id);-->
        <input type="text" class="form-control" name="libelle" 
        value=<?php 
        /*Gestion du cas ou l'utilisateur efface la donnée et tente de la soumettre -> n'affiche pas les tags générés dans l'input par la BDD  */
        if(empty($theme->libelle)){
            echo "";
            }else{
                echo $theme->libelle;
                } ?>>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary my-2" value="modifier" name="modifier">
        <a class ="btn btn-secondary" href="index.php?action=list" >Revenir à la liste</a>
    </div>   
</form>

<?php $content = ob_get_clean(); //fin de la récupération ci dessus et assignement à $content défini dans views/layout?>
<?php include_once 'views/layout.php';?>
