<?php
//La modification est plus ou moins ressamblant à la création, on duplique ainsi la page create que l'on réadapte en ajoutant les value

$title = 'Modifier les données d\'accès employé';
//var_dump($libelle); pour voir les valeurs récupérées


ob_start();//début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<!--redirigé préalablement vers update.php mais désormais vers action=uptade suite au routage via index.php-->
<form action="index.php?action=update" method="post"><!--Les données seront envoyées dans update.php (action = update.php) pour être modifié-->
    <div class="form">
    
            <!--on récupère l'id mais ne l'affiche pas (type="hidden) pour qu il ne soit pas modifié mais uniquement récupéré-->
        <input type="hidden" name="id" value=<?=$employee->utilisateur_id?>>
   
        <label for="username"><strong>Nom d'utilisateur:</strong></label>
            <!--on ajoute la value dans laquelle on affiche la valeur récupérée de l'id si le user souhaite le modifier-->
            <!--cf function dans le controller editAction() qui récupère = view($id);-->
        <input type="text"  name="username" class="withRequirement"
        value=<?php 
        /*Gestion du cas ou l'utilisateur efface la donnée et tente de la soumettre -> n'affiche pas les tags générés dans l'input par la BDD  */
        if(empty($employee->nom_utilisateur)){
            echo "";
            }else{
                echo $employee->nom_utilisateur;
                } ?>>
            <p class="requirement">requis: caract.: alphanum_- ,max:15 - min: 3</p>
        <label for="email"><strong>Email: </strong></label>
        <input type="email"  name="email"         value=<?php 
        /*Gestion du cas ou l'utilisateur efface la donnée et tente de la soumettre -> n'affiche pas les tags générés dans l'input par la BDD  */
        if(empty($employee->email)){
            echo "";
            }else{
                echo $employee->email;
                } ?>>
        <label for="password"><strong>Mot de Passe: </strong></label>
        <input type="text"  name="password" class="withRequirement"        value=<?php 
        /*Gestion du cas ou l'utilisateur efface la donnée et tente de la soumettre -> n'affiche pas les tags générés dans l'input par la BDD  */
        if(empty($employee->password)){
            echo "";
            }else{
                echo $employee->password;
                } ?>>
        <p class="requirement">requis: caract.: au moins 1 Maj. 1min 1digit 1caract.spéc:$%!.&@* - ,max:20 - min: 10</p>
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
