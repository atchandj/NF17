<!DOCTYPE html>
<html>
	<head>
		<title>Visualiser factures</title>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script type="text/javascript" src="js/function.js"></script>
	</head>
	<body onload="init('facture')">
		<?php require '../connect.php'; $connection = fConnect(); ?>
		<!-- title -->
		<header>
			<h1>Visualiser factures</h1><hr>
			<!-- navigation buttons -->
			<nav>
				<button onclick="window.location='accueil_vente.html'">Retourner à l'accueil</button>
				<button style="float:right;" onclick="window.location='facturation.php';">Facturation</button>
			</nav><hr>
		</header>
		<!-- filter segement -->
		<label for="facture-type-select">Filtre: </label>
		<select id="facture-type-select" onchange="factureTypeChange(this);">
			<option value="0">Tous les factures</option>
			<option value="1">Facture réparation</option>
			<option value="2">Facture reprise</option>
			<option value="3">Facture vente</option>
		</select><hr/>
		<form>
			<!-- numéro de facture -->
			<span class="filter-input">
				<label for="num-facture">Numéro de facture: </label>
				<input type="number" placeholder="num facture" id="num-facture" name="num-facture">
			</span>
			<!-- prix de facture -->
			<span class="filter-input">
				<label for="prix-facture">Prix: </label>
				<input type="number" placeholder="prix" id="prix-facture" name="prix-facture">
			</span>
			<!-- date de facture -->
			<span class="filter-input">
				<label for="date-facture">Date: </label>
				<input type="text" placeholder="date" id="date-facture" name="date-facture">
			</span>
			<!-- client -->
			<span class="filter-input">
				<label for="client-facture">Client: </label>
				<input type="text" placeholder="client" id="client-facture" name="client-facture" onkeyup="keyupTrigger(this, 2, this.id, 100)">
			</span>
			<!-- membre de vente -->
			<span class="filter-input">
				<label for="membre-vente-facture">Membre vente: </label>
				<select name="membre-vente-facture" id="membre-vente-facture">
					<option value="0">--------------</option>
					<?php  
						$queryMV = "SELECT * FROM vmembre_vente";
						$res = pg_query($connection, $queryMV);
						while ($row = pg_fetch_array($res, null, PGSQL_ASSOC)) {
							echo "<option value='$row[id]'>$row[prenom]-$row[nom]</option>";
						}
					?>
				</select>
			</span>
			<!-- numéro de opération -->
			<span class="filter-input" id="num-operation-block">
				<label for="num-operation">Numéro de opération: </label>
				<input type="number" placeholder="num opération" id="num-operation" name="num-operation">
			</span>
			<!-- button -->
			<input type="button" id="submitButton" value="Rechercher" onclick="rechercher_facture(event);">
		</form><hr/>
		<!-- Table de résultat -->
		<div id="tab-title">Résultat</div>
		<table border="1" id="facture-tab"></table>
	</body>
</html>