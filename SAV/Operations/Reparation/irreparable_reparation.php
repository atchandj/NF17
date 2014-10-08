<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>Resultat_Reparation_de_Produits</title>
	</head>
	<body>
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
					echo "
						<tr>
							<td align='center'>$_POST[num_op]</td>
							<td align='center'>$_POST[ticket]</td>
							<td align='center'>$_POST[marque] $_POST[modele]</td>
							<td align='center'>$_POST[date_prise_en_charge]</td>
							<td align='center'>$_POST[nom] $_POST[prenom]</td>
						</tr> 
					";
					include "../../../connect.php";
					$vConn = fConnect();
					$num_op = $_POST[num_op];
					$vSql = "select  p.client, t.appareil
						from operation o, ticket_prise_en_charge t, Produit p
						where o.num_op = $num_op	
						and t.num_ticket = o.ticket
						and p.num_serie = t.appareil;";
					$vQuerry = pg_query($vConn, $vSql);
					$vResult = pg_fetch_array($vQuerry,null, PGSQL_ASSOC);
					$client=$vResult[client];
					$appareil = $vResult[appareil];
					$vSql = "insert into facture(prix,date_facture,client,membre_vente) values(0,CURRENT_DATE,$client,null);";
					$vQuerry = pg_query($vConn, $vSql);
					
					$vSql = "select max(num_facture) as fact 
					from Facture;";
					$vQuerry = pg_query($vConn, $vSql);
					$vResult = pg_fetch_array($vQuerry,null, PGSQL_ASSOC);
					$vSql = "INSERT INTO Facture_reparation (num,num_op) VALUES ($vResult[fact],$num_op);";
					$vQuerry = pg_query($vConn, $vSql);

					pg_close($vConn);
					header ('Refresh: 2;URL= facturation.php?num_fact='.$vResult[fact].'&produit='.$appareil.'');
				?>
			</table>
		</div>
		<div align="center" name="retourner">
			<h3>La produit est irréparable</h3>
			<h4>Retourner à l'<a = href ="../../Accueil/accueil_SAV.html">Accueil SAV</a></h4>
		</div>
	</body>
</html>