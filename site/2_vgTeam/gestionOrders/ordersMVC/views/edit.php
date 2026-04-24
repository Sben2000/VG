<?php
//La modification est plus ou moins ressamblant à la création, on duplique ainsi la page create que l'on réadapte en ajoutant les value

$title = "Modifier le statut d'une commande";


ob_start(); //début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>

<form id ="myForm" action="index.php?action=update" method="post" enctype="multipart/form-data"><!--Les données seront envoyées dans update.php (action = update.php) pour être modifié-->
    <table class="access">
        <thead>
            <tr>
                <th>Réf.Commande </th>
                <th><strong><?= $order->numero_commande ?></strong><br>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="firstC">N°Id <br>et<br> date de Cde</th>
                <td class="idMenu">
                    <label>Id: </label><strong><?= $order->commande_id ?></strong><br>
                    <input type="hidden" id="orderID" name="orderID" value=<?= $order->commande_id ?>>
                    <label>cde du: </label><strong><?php
                                                    //mise de la date (sql) au format lisible PHP 
                                                    $date_cde_php = new DateTime($order->date_commande);
                                                    echo $date_cde_php->format("d/m/Y");

                                                    ?></strong>
                </td>
            <tr>
                <th class="firstC">nom_du_menu <br>Nbre de pers.</th>
                <td class="idMenu"><strong>
                        <?= $order->titre ?><br>
                        <?= $order->nbr_pers ?> personne(s)
                    </strong>
                </td>
            </tr>
            <tr>
                <th class="firstC">Date et horaires <br> de prestation</th>
                <td class="idMenu">
                    <strong><?php
                            //mise de la date (sql) au format lisible PHP 
                            $date_prestat_php = new DateTime($order->date_prestation);
                            echo $date_prestat_php->format("d/m/Y") ?></strong><br>
                    <strong><?= $order->heure_livraison ?></strong>
                </td>
            </tr>
            <tr>
                <th class="firstC">Prix détaillé</th>
                <td>
                    <em>Menu: <?= $order->prix_par_personne ?> &euro;, Réduct.: <?= $order->reduction ?>%, Livr.: <?= $order->prix_livraison ?> &euro;</em><br>
                    <strong>Prix total (TTC): <?= $order->prix_TTC ?> &euro;</strong>
                </td>
            </tr>
            <tr>
                <th class="firstC">Coordonnées</th>
                <td>
                    <?= $order->nom_livraison ?>&nbsp;<?= $order->prenom_livraison ?><br>
                    <?= $order->adresse_postale_livraison ?>,<br>
                    <?= $order->code_postal_livraison ?>&nbsp;<?= $order->ville_livraison ?>.<br>
                    &#x260E;: 0<?= $order->telephone_livraison ?><br>
                    <?= $order->email ?>
                </td>
            </tr>
            <tr>
                <th class="firstC">Statut cde</th>
                <td>
                <div class="detailedInput fetch">
				<label for="currentStatus"><strong>Status actuel: </strong></label>
				<input type="text" id="currentStatus" name="currentStatus" value="<?= $order->statut ?>"  readonly  />
				</div>
                </td>
            </tr>
            <tr>
                <th class="firstC">Statut de<br>substitution</th>
                <td>
                <!-- Text input-->
                <div class="detailedInput fetch">
                    <label for="newStatus"><strong>Nouveau statut:</strong></label>
									<select name="selectFilter" id="selectFilter" class="filter">
										<option class="none" value="none" disabled selected>Sélectionner</option>
										<optgroup label="Filtres commandes">
											<option value="créée" >Créée</option>
											<option value="validée">Validée</option>
											<option value="en_préparation">En préparation</option>
											<option value="materiel_manquant">Matériel manquant</option>
                                            <option value="terminée">Terminée</option>
                                            <option value="annulée">Annulée</option>
										</optgroup>
									</select><br>
                    <input type="text" id="newStatus" name="newStatus" class="fetch" value="" readonly>
                </div>
                </td>
                </div>
            </tr>

        </tbody>

    </table>
    <div>
        <p class="infoMessage">=>Veuillez sélectionner un statut de substitution conforme pour pouvoir Modifier</p>
        
        <!--au clic, soumettra le form à action=update pour l'id et le libellé concerné-->
        <button class="modifyButton" id="Btn" name="modifyButton" disabled>Modifier</button>
        <!--retour à la list-->
        <button class="backToListButton"><a href="index.php?action=list">Revenir à la liste</a></button>
        <p class="successMessage"></p>
        <p class="errorMessage"></p>
    </div>
</form>

<script  src="./JS/editOrders.js"></script>

<?php $content = ob_get_clean(); //fin de la récupération ci dessus et assignement à $content défini dans views/layout
?>
<?php include_once 'views/layout.php'; ?>