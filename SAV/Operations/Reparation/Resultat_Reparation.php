<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>Resultat_Reparation</title>
	</head>
	<body>
		<div align="center">
			<table border="1">
				<tr>
					<th align="center">Numéro Opération</th>
					<th align="center">Numéro Ticket</th>
					<th align="center">Appareil</th>
					<th align="center">Date de prise en charge</th>
					<th align="center">Chargé de l'opération</th>
				</tr>
			<?php
				error_reporting(0);
				include "../../../connect.php";
				//include "irreparable.php";
				$vConn = fConnect();
				
				$appareil=$_POST['appareil'];
				$date_p=$_POST['date_p'];
				$nom_c=$_POST['nom_c'];
				$num_ticket = $_POST['num_ticket'];
				$num_op=$_POST['num_op'];
				$duree=$_POST['duree'];
				
				echo "<tr><td align='center'>$num_op</td><td align='center'>$num_ticket</td><td align='center'>$appareil</td><td align='center'>$date_p</td><td align='center'>$nom_c</td></tr></table>";
				$vSql = "insert into reparation(num_op,duree_reparation) values($num_op,$duree);";
				$vQuerry = pg_query($vConn, $vSql);
				//SI c'est irréparable
				$vSql = "select c.ref1, c.ref2
				from Compatible c , Appareil a, Produit p, Modele m
				where c.ref2 = p.modele and p.num_serie = a.num and a.num = $appareil;";
				$vQuerry = pg_query($vConn, $vSql);
				$vResult = pg_fetch_array($vQuerry,null, PGSQL_ASSOC);
				//if($vQuerry == FALSE)
				if(empty($vResult)){
					echo "<h1 align='center'>On ne peut pas le reparer : pas assez de piece detaches !</h1>";
					//On va faire la facture
					
					$vSql = "select c.num_client
					from client c, Produit p
					where p.num_serie = $appareil and p.client = c.num_client;";
					$vQuerry = pg_query($vConn, $vSql);
					$vResult = pg_fetch_array($vQuerry,null, PGSQL_ASSOC);
					
					$vSql = "INSERT INTO Facture (prix, date_facture,client,membre_vente) VALUES (0,CURRENT_DATE,$vResult[num_client],NULL) ;";
					$vQuerry = pg_query($vConn, $vSql);
					
					$vSql = "select max(num_facture) as fact 
					from Facture;";
					$vQuerry = pg_query($vConn, $vSql);
					$vResult = pg_fetch_array($vQuerry,null, PGSQL_ASSOC);
					$vSql = "INSERT INTO Facture_reparation (num,num_op) VALUES ($vResult[fact],$num_op);";
					$vQuerry = pg_query($vConn, $vSql);
					header ('Refresh: 2;URL= facturation.php?num_fact='.$vResult[fact].'&produit='.$appareil.'');

				}
				else
					echo "<h1 align='center'>Le produit sera réparé, attendez avec patience</h1>";
				pg_close($vConn);
				
				
			?>
			<br><br>
				<h4>Retourner à <a = href ="../Valider_les_opérations.php">la liste de les opérations</a></h4>
				<h4>Retourner à l'<a = href ="../../Accueil/accueil_SAV.html">Accueil SAV</a></h4>
			</div>
		</body>
</html>