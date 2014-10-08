<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>formulaire_ticket</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  	<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700' type='text/css'>
	<link rel="stylesheet" href="abase.css">
	<link rel="stylesheet" href="askeleton.css">
	<link rel="stylesheet" href="alayout.css">
</head>
<body background="bpage-bg.jpg">
	<div class="header-section">
	<div class="container">
		<div class="eight columns">
			<h1>Ticket</h1>
			<h2>prise en charge</h2>
		</div>
		<div class="eight columns">
			<img src="bproduct-shot.png" alt="Product" class="scale-with-grid" />
		</div>
	</div>
</div>
	<div class="information-section">
		<div class="container">
			<?php
				include '../../connect.php';
				$appareil = $_POST["serie"];
				$id_membre = $_POST["membre"];
				$vConn = fConnect();
				$vSql = "select num from Appareil  where num= $appareil;";
				$vQuerry = pg_query($vConn, $vSql);
				$vResult = pg_fetch_array($vQuerry, null, PGSQL_ASSOC);
				if(empty($vResult))
				{
					echo "<p color = red>Ce produit n'existe pas !</p>";
				}
				else
				{
					$vSql = "INSERT INTO ticket_prise_en_charge(date_prise_en_charge,membre,appareil) VALUES (CURRENT_DATE,$id_membre,$appareil)";
					$vQuerry = pg_query($vConn, $vSql);
					echo "<p>Création du ticket réussi !</p>";
				}
				
			?>
			Retourner à l'<a = href ="../Accueil/accueil_SAV.html">Accueil SAV</a>
		</div>
	</div>
	<div class="gallery-section">
	</div>
	<div class="footer">
		<div class="container">
			<div class="eight columns">
				<img src="bcompany-logo.png" alt="Company Logo" />
			</div>
			<div class="eight columns copyright">
				<p>Entreprise de vente</p>
			</div>
		</div>
	</div>
</body>
</html>