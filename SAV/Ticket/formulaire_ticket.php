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
			<FORM METHOD = "POST" ACTION="resultat_ticket.php">
				<fieldset>
					<legend>Création de ticket de prise en charge </legend>
					<p>
					<label for="appareil" >Numéro de série du produit : </label> 
					<input type ="text" name = "serie" placeholder="Ex : 15314864" id ="appareil">
					</p>
					<p>
					<label for="membre" >Membre s'occupant de la requête :</label> 
					<select name="membre" id="membre">
					<?php
						include '../../connect.php';
						$vConn = fConnect();
						$vSql = "select * from vMembre_SAV;";
						$vQuery=pg_query($vConn, $vSql);
						while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
							echo "<option value='".$vResult[id]."'> $vResult[nom] $vResult[prenom]</option>";
						}
						pg_close($vConn);
						
					 ?>
				   </select>
					</p>
					<input type="submit" value="Envoyer" />
				</fieldset>
			</FORM>
			Retourner à l'<a  href ="../Accueil/accueil_SAV.html">Accueil SAV</a>
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