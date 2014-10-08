<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>Réparations_de_produits</title>
	</head>
	<body>
		<div align="center">
			<legend>Reparations_de_produit</legend>
		</div>
		<br>
		<form method="POST" action="Resultat_Reparation_de_Produits.php">
			<fieldset>
				<legend>Choisir la numéro de l'opération</legend>
				<label for="membre" >Numéro de l'opération</label> 
				<select name="num_op" id="num_op">
					<?php
						include '../../../connect.php';
						$vConn = fConnect();
						$vSql = "select * from reparation;";
						$vQuery=pg_query($vConn, $vSql);
						while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
							echo "<option value='$vResult[num_op]'> $vResult[num_op]</option>";
						}
						pg_close($vConn);
					?>
				</select>
				<input type="submit" value="Envoyer" />
			</fieldset>
		</FORM>
		<div align="center">
			<h4>Retourner à l'<a = href ="../../Accueil/accueil_SAV.html">Accueil SAV</a></h4>
		</div>
	</body>
</html>