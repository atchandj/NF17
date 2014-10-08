<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>resultat_facture_reparation</title>
	</head>
	<body>
		<br />
		<br />
		<div align="center" style="background-color:black">
			<font size="+6" color="#FFFFFF">Formulaire de la facture de la reparation</font>
		</div>
		<br /><br />
		<div align="center" name="formulaire">
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
			$num_op=$_POST[num_op];
			$ticket=$_POST[ticket];
			$marque=$_POST[marque];
			$modele=$_POST[modele];
			$prix=$_POST[prix];
			$date_prise_en_charge=$_POST[date_prise_en_charge];
			$nom=$_POST[nom];
			$prenom=$_POST[prenom];
			$temps_final=$_POST[temps_final];
			echo "<tr>
				<td align='center'>$num_op</td>
				<td align='center'>$ticket</td>
				<td align='center'>$marque $modele</td>
				<td align='center'>$date_prise_en_charge</td>
				<td align='center'>$nom $prenom</td>
				</tr></table>
			";
			include "../../../connect.php";
			$vConn = fConnect();
			$vSql = "select  p.client ,p.num_serie
						from operation o, ticket_prise_en_charge t, Produit p
						where o.num_op = $num_op
						and t.num_ticket = o.ticket
						and p.num_serie = t.appareil;";
			$vQuerry = pg_query($vConn, $vSql);
			$vResult = pg_fetch_array($vQuerry,null, PGSQL_ASSOC);
			$client=$vResult[client];
			$produit=$vResult[num_serie];
			
			$vSql = "INSERT INTO Facture (prix, date_facture,client,membre_vente) values($prix,CURRENT_DATE,$client,null);";
			$vQuerry = pg_query($vConn, $vSql);
			
			if(Querry == FALSE)
				echo "<h3>Erreur lors de la création de la facture ! </h3>";
			else {
				$vSql = "select max(num_facture) as num_facture from facture;";
				$vQuerry = pg_query($vConn, $vSql);
				$vResult = pg_fetch_array($vQuerry,null, PGSQL_ASSOC);
				$num_facture=$vResult[num_facture];
				
				$vSql = "insert into Facture_reparation(num,num_op) values($num_facture,$num_op);";
				$vQuerry = pg_query($vConn, $vSql);
				
				if(Querry == FALSE)
					echo "<h3>Erreur lors de la création de la facture de reparation ! </h3>";
				else {
					$vSql = "select m.extension from Produit p, Modele m where p.num_serie = $produit  and m.reference = p.modele;";
						$vQuerry = pg_query($vConn, $vSql);
						$vResult = pg_fetch_array($vQuerry,null, PGSQL_ASSOC);
						if(empty($vResult))
							echo "<h3>Erreur lors de la facturation !<h3>";
						else
						{
							if($vResult[extension] == TRUE)
								$vSql = "INSERT INTO Facturation VALUES ($num_facture, $produit,$remise,FALSE,TRUE);";
							else
								$vSql = "INSERT INTO Facturation VALUES ($num_facture, $produit,$remise,FALSE,FALSE);";
							$vQuerry = pg_query($vConn, $vSql);
							echo "<h3>Facturation reussi !</h3>";
						}
					
					/*$vSql = "insert into Facturation(facture,produit) values($num_facture,$num_serie);";
					$vQuerry = pg_query($vConn, $vSql);*/
				}
			}
			
			pg_close($vConn);
			echo "<br /><font> Le numéro de votre facture est $num_facture</font><br />";
			?>
		</div>
		<br /><br /><div align="center" name="retourner">
			<br /><br />
			<div align="center" style="background-color:black">
				<font size="+4" style="background-color:white">La facture a bien créée</font>
			</div>
			<br /><br />
			<h4>Retourner à l'<a = href ="../../Accueil/accueil_SAV.html">Accueil SAV</a></h4>
			<h4>Retourner aux <a = href ="Resultat_Reparation_de_Produits.php">opérations des reparation</a></h4>
		</div>
	</body>
</html>