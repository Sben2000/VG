<?php

$title = 'Liste des commandes';


ob_start(); //début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<div>
<div class="multiSectionsRight">
				<section class="Section">
					<div class="SectionContent Criterias">
						<h2>Trier par statut de commande ?</h2>
						<div class="rollingMenuCriterias" id="filterSelection">
							<div><label>
									<h6 id="filterCriteria">Status commandes</h6>
									<select name="selectFilter" id="selectFilter" class="filter">
										<option class="none" value="none" disabled selected>Sélectionner</option>
										<optgroup label="Tous">
										<option value="all" default>Tout status</option>
										<optgroup label="Filtres commandes">
										<option value="créée" >Créée</option>
											<option value="validée">Validée</option>
											<option value="en_préparation">En préparation</option>
											<option value="materiel_manquant">Matériel manquant</option>
                                            <option value="terminée">Terminée</option>
                                            <option value="annulée">Annulée</option>
										</optgroup>
									</select>
								</label></div>
						</div>
			
					<div class="resetFilters">
						<input type="submit" name="resetFilters" value="Reinitialiser par défaut" id="resetFilters" onclick="location.reload()" />
					</div>
				</section>
                </div>
</div>
<h2><u>Status </u>: <em><span id="heading">Tout les status</span></em></h2>
<p class="note"><u>Note </u>: Les commandes sont affichées par ordre de priorité (date de prestation souhaitée), hormis pour les commandes terminées et annulées</p>
<div id="orderContainer"> 

<?php foreach ($orders as $order): ?>
    <!--Par défaut lors de l'accès à la page, les éléments ci dessous sont affichées (critères: Tous)-->               
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
                    <th class="firstC">Statut cde</th>
                    <td><strong><?= $order->statut ?></strong></td>
                </tr>
                <tr>
                    <th class="firstC">Prix détaillé</th>
                    <td>
                        <em>Menu: <?= $order->prix_par_personne ?> &euro;, Réduct.: <?= $order->reduction?>%, Livr.: <?= $order->prix_livraison ?> &euro;</em><br>
                        <strong>Prix total (TTC): <?= $order->prix_TTC ?> &euro;</strong>
                    </td>
                </tr>
                <tr>
                    <th class="firstC">Coordonnées</th>
                    <td>
                        <?= $order->nom_livraison ?>&nbsp;<?= $order->prenom_livraison?><br>
                        <?= $order->adresse_postale_livraison ?>,<br>
                        <?= $order->code_postal_livraison ?>&nbsp;<?= $order->ville_livraison ?>.<br>
                        &#x260E;: 0<?= $order->telephone_livraison ?><br>
                        <?= $order->email?>
                    </td>
                </tr>
                <tr>
                    <th class="firstC">Actions</th><!--Ajouté afin de supprimer ou modifier une commande-->
                    <div class="actionButtons">
                        
                        <td>
                                <button class="modifyButton"><a href="index.php?action=edit&id=<?php echo $order->commande_id ?>">Modifier le status</a></button>
                        </td>
                    </div>
                </tr>
               
        </tbody>

    </table>

<?php endforeach; ?> 

</div>
<!--Le script est de type module et importe des functions d'autres fichiers-->
<script type="module" src="./JS/orders.js"></script>
    <?php $content = ob_get_clean(); //fin de la récupération ci dessus et assignement à $content défini dans views/layout
    ?>
    <?php include_once 'views/layout.php'; ?>
</div>