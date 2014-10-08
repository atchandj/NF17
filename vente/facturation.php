<!DOCTYPE html>
<html>
<head>
	<title>Facturation</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script type="text/javascript" src="js/function.js"></script>
</head>
<body onload="init('facturation');">
	<!-- title -->
	<header>
		<h1>Facturation</h1><hr>
		<nav>
			<button onclick="window.location='accueil_vente.html'">Retourner à l'accueil</button>
			<button style="float:right;" onclick="window.location='visualiser_facture.php';">Voir les factures</button>
		</nav><hr/>
	</header>
	<!-- page content -->
	<form id="vp-page-content">
	<fieldset>
		<!-- produit -->
		<div class="content-block">
			<label for="produit">Produit: </label>
			<input type="text" id="produit" placeholder="produit" required="true" readonly>
			<input type="button" id="cpButton" value="Chercher le produit">
		</div>
		<!-- client -->
		<div class="content-block">
			<label for="client">Client: </label>
			<input type="text" id="client" placeholder="client" required="true" onkeyup="keyupTrigger(this, 2, this.id, 100)">
		</div>
		<!-- remise -->
		<div class="content-block">
			<label for="remise">Remise: </label>
			<input type="number" id="remise" placeholder="remise">
		</div>
		<div class="content-block">
			<label for="membre_vente">Membre vente: </label>
			<select id="membre_vente">
				<?php
					require '../connect.php';

					$connection = fConnect();
					$query = "SELECT * FROM vMembre_vente";
					$vQUery = pg_query($connection, $query);
					while ($vResult = pg_fetch_array($vQUery, null, PGSQL_ASSOC)) {
						echo "<option value='$vResult[id]'>$vResult[prenom]-$vResult[nom]</option>";
					}	
				?>
			</select>
		</div>
		<!-- specialiste -->
		<div class="content-block">
			<p style="display:inline;">L'installation par specialiste?</p>
			<input type="radio" value="Oui" id="specialiste-oui" onchange="spCheckBoxChangeState(this.id);">Oui
			<input type="radio" value="none" id="specialiste-non" checked="true" onchange="spCheckBoxChangeState(this.id);">Non
		</div>
		<!-- extension -->
		<div class="content-block" id="extension-content-block">
			<p style="display:inline;">Extension?</p>
			<input type="radio" value="oui" id="extension-oui" onchange="exCheckBoxChangeState(this.id);">Oui
			<input type="radio" value="none" id="extension-non" checked="true" onchange="exCheckBoxChangeState(this.id);">Non
		</div>
		<!-- submit button -->
		<div class="content-block" style="text-align: center;">
			<input type="button" id="submit-button" value="Facturer" onclick="facturerButtonOnClick();">
		</div>
	</fieldset>
	</form>
	<!-- Search interface -->
	<div id="produit-search-segment">
		<form id="produit-search-form">
		<fieldset>
		<legend>Chercher le produit</legend>
			<!-- Select block -->
			<div class="cpcontent-block">
				<!-- Category -->
				<span class="cpcontent-inline-block" id="category-block">
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
				<span class="cpcontent-inline-block" id="sous-category-block" style="display:none;">
					<label for="sous-category-select">Sous Categorie:</label>
					<select id="sous-category-select"></select>
				</span>
				<!-- Type of product -->
				<span class="cpcontent-inline-block" id="type-produit-block">
					<label for="type-produit-select">Type de produit:</label>
					<select id="type-produit-select">
						<option value="produit">-----------</option>
						<option value="appareil">Appareil</option>
						<option value="accessoire">Accessoire</option>
						<option value="piece_detachees">Pièce détaché</option>
					</select>	
				</span>		
			</div>
			<!-- Other search standard -->
			<div class="cpcontent-block">
				<!-- Numéro sérié -->
				<span class="cpcontent-inline-block">
					<label for="serie-produit">Numéro sérié:</label>
					<input type="number" id="serie-produit" placeholder="numéro sérié de produit">
				</span>
				<!-- prix -->
				<span class="cpcontent-inline-block">
					<label for="prix-produit">Prix:</label>
					<input type="number" id="prix-produit" placeholder="prix de produit">
				</span>
				<!-- modèle -->
				<span class="cpcontent-inline-block">
					<label for="modele-produit">Modèle:</label>
					<input type="number" id="modele-produit" placeholder="référence de modèle">
				</span>
				<!-- fournisseur -->
				<span class="cpcontent-inline-block">
					<label for="fournisseur-produit">Fournisseur:</label>
					<input type="text" id="fournisseur-produit" placeholder="fournisseur de produit" onkeyup="keyupTrigger(this, 1, this.id, 100)">
				</span>
			</div>
			<!-- submit button -->
			<div class="cpcontent-block" style="text-align: center;">
				<input type="button" id="search-submit" value="Chercher" onclick="searchButtonPressed('product');">
				<input type="button" id="search-valider" value="Valider" disabled onclick="productOnValidate();">
				<input type="button" id="search-annuler" value="Annuler">
			</div>
		</fieldset>
		</form>
		<table id="produit-list-tab" border="1"></table>
	</div>
</body>
</html>