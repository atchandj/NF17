<!DOCTYPE html>
<html>
<head>
	<title>Créer un bon de commande</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script type="text/javascript" src="js/function.js"></script>
</head>
<body onload="init('boncommande');">
	<header>
		<h1>Créer un bon de commande</h1><hr>
		<nav>
			<button onclick="window.location='accueil_vente.html'">Retourner à l'accueil</button>
			<button style="float:right;" onclick="window.location='facturation.php';">Facturation</button>
		</nav><hr>
	</header>
	<form id="bc-page-content" method="POST" action="creer_bon_de_commande.php">
	<fieldset>
		<!--modele-->
		<label for="modele">Modèle:</label>
		<input type="number" id="modele" name="modele" required="true" readonly>
		<input type="button" id="cm-button" value="Chercher le modèle"><br/><br/>
		<!-- quantite -->
		<label for="quantite">Quantité:</label>
		<input type="number" id="quantite" name="quantite" required="true"/><br/><br/>
		<!--fournisseur-->
		<label for="fournisseur">Fournisseur:</label>
		<input type="text" id="fournisseur" name="fournisseur" required="true" onkeyup="keyupTrigger(this, 1, this.id, 100)" /><br/><br/>
		<!--destinataire-->
		<label for="destinataire">Destinataire:</label>
		<select id="destinataire" name="destinataire">
			<?php
				require '../connect.php';
				$connection = fConnect ();
				$query = "SELECT * FROM vMembre_achat";
				$vQUery = pg_query($connection, $query);
				
				while ($vResult = pg_fetch_array($vQUery, null, PGSQL_ASSOC)) {
					echo "<option value='$vResult[id]'>$vResult[prenom]-$vResult[nom]</option>";
				}
			?>
		</select><br/><br/>
		<label for="membre_vente">Membre vente:</label>
		<select id="membre_vente" name="membre_vente">
			<?php
				$query = "SELECT * FROM vMembre_vente";
				$vQUery = pg_query($connection, $query);
				while ($vResult = pg_fetch_array($vQUery, null, PGSQL_ASSOC)) {
					echo "<option value='$vResult[id]'>$vResult[prenom]-$vResult[nom]</option>";
				}	
			?>
		</select><br/><br/>
		<input type="button" value="Créer" onclick="submit_bon_commande();">
	</fieldset>
	</form>
	<!-- modele search interface -->
	<div id="modele-search-segment">
		<form id="modele-search-form">
		<fieldset>
		<legend>Chercher le modele</legend>
			<!-- Select block -->
			<div class="cmcontent-block">
				<!-- Category -->
				<span class="cmcontent-inline-block" id="category-block">
					<label for="category-select">Categorie:</label>
					<select id="category-select" onchange="categoryChose(this);">
						<option value="invalid">------------------</option>
						<?php 
							$categoryQuery = "SELECT * FROM categorie";
							$result = pg_query($connection, $categoryQuery);
							while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
								echo "<option value='$row[nom]'>$row[nom]</option>";
							}
						?>
					</select>	
				</span>
				<!-- Sous-category -->
				<span class="cmcontent-inline-block" id="sous-category-block" style="display:none;">
					<label for="sous-category-select">Sous Categorie:</label>
					<select id="sous-category-select"></select>
				</span>
			</div>
			<!-- Other search standard -->
			<div class="cmcontent-block">
				<!-- référence -->
				<span class="cmcontent-inline-block">
					<label for="reference-modele">Référence:</label>
					<input type="number" id="reference-modele" placeholder="référence de modèle">
				</span>
				<!-- prix -->
				<span class="cmcontent-inline-block">
					<label for="prix-modele">Prix:</label>
					<input type="number" id="prix-modele" placeholder="prix de référence de modèle">
				</span>
				<!-- consommation -->
				<span class="cmcontent-inline-block">
					<label for="consommation-modele">Consommation:</label>
					<input type="number" id="consommation-modele" placeholder="consommation de modèle">
				</span>
				<!-- garantie -->
				<span class="cmcontent-inline-block">
					<label for="garantie-modele">Garantie:</label>
					<input type="text" id="garantie-modele" placeholder="garantie de modele">
				</span>
				<!-- extension -->
				<span class="cmcontent-inline-block">
					<label for="extension-modele">Extension possible? :</label>
					<select id="extension-modele">
						<option value="invalid">-------------</option>
						<option value="true">Oui</option>
						<option value="false">Non</option>
					</select>
				</span>
				<!-- marque -->
				<span class="cmcontent-inline-block">
					<label for="marque-modele">Marque:</label>
					<input type="text" id="marque-modele" placeholder="marque de modele" onkeyup="keyupTrigger(this, 3, this.id, 100)">
				</span>
			</div>
			<!-- submit button -->
			<div class="cmcontent-block" style="text-align: center;">
				<input type="button" id="search-submit" value="Chercher" onclick="searchButtonPressed('modele');">
				<input type="button" id="search-valider" value="Valider" disabled onclick="modeleOnValidate();">
				<input type="button" id="search-annuler" value="Annuler">
			</div>
		</fieldset>
		</form>
		<table id="modele-list-tab" border="1"></table>
	</div>
</body>
</html>