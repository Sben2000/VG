<!--fichier dupliqué de category.php et complété/modifié avec les éléments propres à product.php-->

<?php require "php/functions.php" ?> <!--requiert le fichier functions.php du dossier php-->
<?php
/*on surveille si il y a une requête selectionnant le lien faisant appel à la colonne ['title'] devellopée dans le lien product:
	 <a href="product.php?title=<?php echo urlencode($product['title']) ?>"> */
if (isset($_GET['title'])) {
	/*si le lien est selectionné, on decode le titre du produit [title] selectionné que l on assigne à une variable $title*/
	$title = urldecode($_GET['title']);
	/*on vient ensuite faire appel à une fonction "getProductByTitle($title)" avec en argument le $title défini à aller récupérer */
	/*On l'assigne à la variable $product*/
	$product = getProductByTitle($title);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!--Meta tags ajouté, aide pour le référencement SEO-->
	<!--ici, au lieu de phones, books, games,.. on récupère la valeur[0] de la colonne meta_description en utilisant la variable qui aura permit de fetch en tableau assoc le produit(title) souhaité-->
	<meta name="description" content=<?php echo $product[0]['meta_description'] ?> />
	<!--même chose que ci dessous avec la colonne du ['meta_keywords'] du tableau associatif $product (fetch_assoc de la requête spécifiant le produit(title) souhaité).-->
	<meta name="keywords" content=<?php echo $product[0]['meta_keywords'] ?> />
	<link rel="stylesheet" href="./css/styles.css" />
	<style>
		footer {
			/*personalisation de la position du  footer dans cette page en complément du stylesheet déjà importé*/
			position: fixed;
			bottom: 0;
		}
	</style>

	<!--On affiche ici le titre du produit selectionné défini en argument dans getProductByTitle($title)-->
	<title><?php echo $title ?></title>
</head>

<body>

	<?php include "./includes/nav.php" ?>
	<?php include "./includes/header.php" ?>

	<main>
		<div class="left">
			<div class="section-title">Product Categories</div>
			<!--Cette partie reste comme elle était dans index , car on est succeptible de selectionner une autre category dans cette même page et afficher uniquement les éléments de la category selectionné (ex: Books, Games,..)-->
			<?php
			/* on récupère dans la db les éléments de la catégory séléctionnée grâce à la function getCategories que l'on assigne à $categories */
			$categories = getCategories();
			?>
			<?php
			/*on affiche chaque catégory du tableau dans une balise lien */
			foreach ($categories as $category) {
			?>
				<a href="category.php?category=<?php echo urlencode($category['category']) ?>"> <!--Nous envoyons ds l'url de la page category.php (qui sera crée), le nom de la catégory sélectionné ->l'url sera encodé (url-encoded) pour pouvoir être envoyé sur internet en utilisant les caractères ASCII : ASCII stands for the "American Standard Code for Information Interchange": was the first character set (encoding standard) used between computers on the Internet..(URL encoding normally replaces a space with a plus (+) sign or with %20.)-->
					<?php echo ucfirst($category['category'])/*ucfirst met en capitale la première lettre de valeur associée à la clé (col) 'category' */ ?>
				</a>
			<?php
			}
			?>

		</div>

		<div class="right">
			<div class="section-title">Product Details</div>

			<div class="product">


				<div class="product-left">
					<!--on affiche ds le chemin img, le nom (valeur de $product[0]['image']) de l'img présent dans la variable $products (et pas toute la loop comme précédemment ->d'ou [0][image])	-->
					<img src="<?php echo "products_img/{$product[0]['image']}" ?>" alt="">
				</div>
				<div class="product-right">
					<p class="title">

						<!--on affiche le titres du produit affiché via $product[0]['title'], on a qu'un seul index (ligne récupérée par $produit) dans ce cas[0]-->
						<?php echo $product[0]['title']  ?>
						</a>
					</p>
					<p class="description">
						<!--on récupère la description du seul produit récupéré par $product dans son tableau assoc-->
						<?php echo $product[0]['description'] ?>
					</p>
					<p class="price">
						<!--on récupère le prix du seul produit récupéré par $product dans son tableau assoc-->
						<?php echo $product[0]['price'] ?> &euro;
					</p>

				</div>
			</div>
		</div>

	</main>

	<?php include "./includes/footer.php" ?>

	<script src="./javascript/script.js"></script>
</body>

</html>