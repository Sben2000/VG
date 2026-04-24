<?php
$title = 'Associer un allergène à un plat';


ob_start();//début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
 
<form action="index.php?action=store" method="post" enctype="multipart/form-data"><!--Les données seront envoyées dans store.php (action = store.php)-->
					<div class="selectList">
						<!--Liste Déroulante Plat -->
						<label for="plats" class="label">
							<p><strong>1. Sélectionner un plat</strong></p>
						</label>
						<select name="plats" id="selectorPlats"  value=<?php if (!['plat_id']){echo"";}else{echo $plat['plat_id'];} ?>> <!--onclick="getPlatJS(this.value)"-->
					
						<option class="none" disabled  selected>Plat</option><!--la première option de la liste déroulante avec l'invitation à sélectionner-->
							<optgroup label="Sélectionner">
								<!--Les thèmes de la liste sont fetch de la DB en utilisant la function du model getPlats()-->
								<?php
								//on récupère chaque donnée de la DB via la variable qui a récupéré les éléments de la liste (dans la partie controller)
								foreach ($plats as $plat) {
								?>
									<!--on attribue à value l'id du thème selectionné et on affiche le libellé du plat dans l'option, on récupère également au clic la value (contenant l'ID) que l'on traite au travers de la function JS mentionné précédemment -->
									<option  id="optionDBplat" class="database" value=<?php echo $plat['plat_id'] ?>><?= $plat['titre_plat'] ?></option>
								<?php
								}
								?>
							</optgroup>
						</select>
						<!-- Affichera l'option Sélectionnée dans la div ci dessous après Fetch JS. -->
						<div class="selectedPlat" id="startSelectedPlat">

						</div>
            <p class="requirement"><strong>Note: Pour ajouter un plat à la liste:</strong> <br>
            →  Veuillez cliquer sur l'onglet "Liste des plats" sur la barre de navigation<br> ou<br> →  Vous rendre sur l'onglet: &nbsp;&nbsp; "Gestion"> "Plats" depuis la page d'accueil</p>
			<!--Liste Déroulante Allergène -->
			<label for="allergenes" class="label">
				<p><strong>2. Sélectionner un allergène</strong></p>
			</label>
			<!-- au click, on fait appel à la function JS(cf.fichier JS) pour afficher dans un input la catégorie sélectionnée ainsi que son id-->
			<select name="allergenes" id="selectorAllergenes"> <!--onclick="getAllergenesJS(this.value)"-->
				<option class="none" disabled selected>Allergène</option><!--la première option de la liste déroulante avec l'invitation à sélectionner-->
				<optgroup label="Sélectionner">
					<!--Les régimes de la liste sont fetch de la DB en utilisant la function du model getAllergenes()-->
					<?php
					//on récupère chaque donnée de la DB via la variable qui a récupéré les éléments de la liste (dans la partie controller)
					foreach ($allergenes as $allergene) {
					?>
						<!--on attribue à value l'id selectionné et on affiche le libellé  dans l'option, on récupère également au clic la value (contenant l'ID) que l'on traite au travers de la function JS mentionné précédemment -->
						<option id="optionDBallergene" class="database" value=<?php echo $allergene['allergene_id'] ?>><?= $allergene['libelle'] ?></option>
					<?php
					}
					?>
				</optgroup>
			</select>
			<!-- Affichera l'option Sélectionnée dans la div ci dessous après Fetch JS. -->
			<div class="selectedAllergene" id="startSelectedAllergene">

			</div>
            <p class="requirement"><strong>Note: Pour ajouter un allergène à la liste</strong> <br> → Veuillez vous rendre sur l'onglet:&nbsp;&nbsp; "Gestion"> "Libelles">"Allergènes" </p>
					</div>





    <div >
        <!--au clic, soumettra le form à action=update pour l'id et le libellé concerné-->
        <button class="addButton" name="addButton">Associer</button>
        <!--retour à la list-->
        <button class="backToListButton"><a href="index.php?action=list" >Revenir à la liste</a></button>
    </div> 
    
             <?php
            //retour du resultat $response affiché à l'utilisateur
                //si le resultat de la function est success
            if(@$response == "success"){
                ?>
                    <p class="success" style='color:green'>L' association a été réalisé avec succès!</p>
                    <p class="success" style='color:darkblue'>⮕ Associer de nouveau ou revenez à la liste</p>
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
