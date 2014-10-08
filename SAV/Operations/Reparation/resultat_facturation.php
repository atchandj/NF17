<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>Resultat facturation</title>
	</head>
	<body>
		<div align="center">

			<?php
				error_reporting(0);
				include "../../../connect.php";
				$vConn = fConnect();
				
				$facture = $_POST['num_fact'];
				$produit = $_POST['produit'];
				$remise = $_POST['remise'];
				
				$vSql = "select m.extension from Produit p, Modele m where p.num_serie = $produit  and m.reference = p.modele;";
				$vQuerry = pg_query($vConn, $vSql);
				$vResult = pg_fetch_array($vQuerry,null, PGSQL_ASSOC);
				if(empty($vResult))
					echo "<h3>Erreur lors de la facturation !<h3>";
				else
				{
					if($vResult[extension] == TRUE)
						$vSql = "INSERT INTO Facturation VALUES ($facture, $produit,$remise,FALSE,TRUE);";
					else
						$vSql = "INSERT INTO Facturation VALUES ($facture, $produit,$remise,FALSE,FALSE);";
					$vQuerry = pg_query($vConn, $vSql);
					echo "<h3>Facturation reussi !</h3>";
				}
			?>
			<br><br>
				<h4>Retourner à <a = href ="../Valider_les_opérations.php">la liste de les opérations</a></h4>
				<h4>Retourner à l'<a = href ="../../Accueil/accueil_SAV.html">Accueil SAV</a></h4>
			</div>
		</body>
</html>