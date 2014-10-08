<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>Refuser</title>
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
			include "../../../connect.php";
			$num = $_POST['num_op'];
			$vConn = fConnect();
			
			$vSql = "select * from ticket_prise_en_charge where ticket_prise_en_charge.num_ticket=$num;";
			$vQuerry = pg_query($vConn, $vSql);
			$vResult = pg_fetch_array($vQuerry, null, PGSQL_ASSOC);
			$membre=$vResult['membre'];
			$appareil=$vResult['appareil'];
			$date1=$vResult['date_prise_en_charge'];
			
			//$vSql = "select * from employe where employe.id=$num;";
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
			$appareil=$vResult['marque'];
			
			echo "<tr><td align='center'>$num</td><td align='center'>$nom</td><td align='center'>$prenom</td><td align='center'>$appareil $modele</td><td align='center'>$date1</td></tr></table>";
			$vSql = "insert into refus(num_op) values($num);";
			$vQuerry = pg_query($vConn, $vSql);
			if($vQuerry == FALSE)
				echo "<h1 align='center'>On ne peut pas le refuser</h1>";
			else
				echo "<h1 align='center'>Op&eacuteration de refus accept&eacutee</h1>";
		?>
		
		<div align="center">
			<h1>Retourner à <a = href ="../Valider_les_opérations.php">la liste de les opérations</a></h1>
			<h1>Retourner à l'<a = href ="../../Accueil/accueil_SAV.html">Accueil SAV</a></h1>
		<div>
	</body>
</html>