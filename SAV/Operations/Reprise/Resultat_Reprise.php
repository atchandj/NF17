<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>Resultat_Rprise</title>
	</head>
	<body>
		<div align="center">
			<table border="1">
				<tr>
					<th align="center">N_Opération</th>
					<th align="center">Nom_Chargeur</th>
					<th align="center">Prénom_Chargeur</th>
					<th align="center">Appareil</th>
					<th align="center">Date</th>
				</tr>
				<?php
					error_reporting(0);
					$nom=$_POST['nom'];
					$prenom=$_POST['prenom'];
					$date1=$_POST['date1'];
					$num=$_POST['num'];
					$appareil=$_POST['appareil'];
					$prix= - $_POST['prix'];
					echo "<tr><td align='center'>$num</td><td align='center'>$nom</td><td align='center'>$prenom</td><td align='center'>$appareil</td><td align='center'>$date1</td></tr></table>";
					
					include "../../../connect.php";
					$vConn = fConnect();
					$vSql = "insert into reprise(num_op,prix_reprise) values($num,$prix);";
					$vQuerry = pg_query($vConn, $vSql);
					if($vQuerry == FALSE)
						echo "<h1 align='center'>On ne peut pas le reprendre</h1>";
					else{
						echo "<h1 align='center'>Succès</h1>";
						
						$vSql = "select client from Produit where num_serie = $appareil;";
						$vQuerry = pg_query($vConn, $vSql);
						$vResult = pg_fetch_array($vQuerry,null, PGSQL_ASSOC);
						
						$vSql = "insert into Facture (prix, date_facture,client,membre_vente) VALUES ($prix, CURRENT_DATE,$vResult[client],NULL)";
						$vQuerry = pg_query($vConn, $vSql);
						
						$vSql = "select max(num_facture) as fact 
						from Facture;";
						$vQuerry = pg_query($vConn, $vSql);
						$vResult = pg_fetch_array($vQuerry,null, PGSQL_ASSOC);
						$vSql = "INSERT INTO Facture_reprise (num,num_op) VALUES ($vResult[fact],$num);";
						$vQuerry = pg_query($vConn, $vSql);
					}
				?>
				<h4>Retourner à <a = href ="../Valider_les_opérations.php">la liste de les opérations</a></h4>
				<h4>Retourner à l'<a = href ="../../Accueil/accueil_SAV.html">Accueil SAV</a></h4>
		<div>
	</body>
<html>