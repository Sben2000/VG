

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
      <!--
    <link
			href=<?php require_once ACCESSROOT."/css/style.css" ?>
			rel="stylesheet"
		/>
-->
    <?php require_once "routes/rootPath.php" ?>
    <?php require_once ACCESSROOT."/includes/navbar.php" ?>
</head>

<body>

    <div class="main">
        <h2><?= $title ?></h2>
        <hr>
        <?=$content ?>
    </div>
    
<!--Le script est de type module et importe des functions d'autres fichiers-->
<script type="module" src="./JS/menuPlats.js"></script>
</body>

</html>