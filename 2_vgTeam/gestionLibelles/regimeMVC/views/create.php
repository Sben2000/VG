<?php
$title = 'Ajouter libelle';


ob_start();//début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<!--redirigé préalablement vers store.php mais désormais vers action=store suite au routage via index.php-->
<form action="index.php?action=store" method="post"><!--Les données seront envoyées dans store.php (action = store.php)-->
    <div class="form-group">
        <label for="nom">Libelle de regime</label>
        <input type="text" class="form-control" name="libelle">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-success my-2" value="Ajouter" name="ajouter">
        <a class ="btn btn-secondary" href="index.php?action=list" >Revenir à la liste</a>
    </div> 

     
</form>

<?php $content = ob_get_clean(); //fin de la récupération ci dessus et assignement à $content défini dans views/layout?>
<?php include_once 'views/layout.php';?>
