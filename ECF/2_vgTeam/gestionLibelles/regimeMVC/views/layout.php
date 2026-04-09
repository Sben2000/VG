


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
      <!--
    <link
			href=<?php require_once LIBELLESROOT."/css/style.css" ?>
			rel="stylesheet"
		/>
-->
    <?php require_once "routes/rootPath.php" ?>
    <?php require_once LIBELLESROOT."/includes/navbar.php" ?>
</head>

<body>

    <div class="main">
        <h2><?= $title ?></h2>
        <hr>
        <?=$content ?>
    </div>

</body>

</html>