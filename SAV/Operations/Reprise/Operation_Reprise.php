<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>Rprise</title>
	</head>
	
	<body>
	<h1>Remise du produit :</h1><br>;
		<div align="center">
			<table border="1">
				<tr>
					<th align="center">Numéro Opération</th>
					<th align="center">Chargé de l'opération</th>
					<th align="center">Appareil</th>
					<th align="center">Date</th>
					<th align="center">Prix de base du produit</th>
				</tr>
		<?php
			error_reporting(0);
			$num=$_POST['num_op'];
			include "../../../connect.php";
			$vConn = fConnect();
			$vSql = "select * from ticket_prise_en_charge where ticket_prise_en_charge.num_ticket=$num;";
			$vQuerry = pg_query($vConn, $vSql);
			$vResult = pg_fetch_array($vQuerry, null, PGSQL_ASSOC);
			$membre=$vResult['membre'];
			$appareil=$vResult['appareil'];
			$date1=$vResult['date_prise_en_charge'];
			

			$vSql = "select m.nom, m.prenom from ticket_prise_en_charge t,vMembre_SAV m where t.num_ticket=$num and m.id = t.membre;";
			$vQuerry = pg_query($vConn, $vSql);
			$vResult = pg_fetch_array($vQuerry, null, PGSQL_ASSOC);
			$nom=$vResult['nom'];
			$prenom=$vResult['prenom'];
			
			$vSql = "select * from produit where produit.num_serie=$appareil;";
			$vQuerry = pg_query($vConn, $vSql);
			$vResult = pg_fetch_array($vQuerry, null, PGSQL_ASSOC);
			$modele=$vResult['modele'];
			$vSql = "select * from modele where modele.reference=$modele;";
			$vQuerry = pg_query($vConn, $vSql);
			$vResult = pg_fetch_array($vQuerry, null, PGSQL_ASSOC);
			$appareil1=$vResult['marque'];
			
			$vSql = "select produit.prix_affiche from produit where produit.num_serie=$appareil;";
			$vQuerry = pg_query($vConn, $vSql);
			$vResult = pg_fetch_array($vQuerry, null, PGSQL_ASSOC);
			$prix = $vResult['prix_affiche'];
			
			echo "<tr><td align='center'>$num</td><td align='center'>$nom $prenom</td><td align='center'>$appareil1 $modele</td><td align='center'>$date1</td><td align='center'>$prix/td> </tr></table>";
			echo "<br><br><br>";
			echo "<form method='POST' action='Resultat_Reprise.php'>Donnez la prix pour reprise<input type='text' name='prix'><br>
			<input type='hidden' name='num' value='$num'><input type='hidden' name='nom' value='$nom'><input type='hidden' name='prenom' value='$prenom'><input type='hidden' name='date1' value='$date1'><input type='hidden' name='appareil' value='$appareil'>
			<input type='submit' value='Valider'>";
		?>
	</body>
</html>