<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>Resultat_Reparation_de_Produits</title>
	</head>
	<body>
		<br />
		<br />
		<div align="center" style="background-color:black">
			<font size="+6" color="#FFFFFF">Les opérations des réparations</font>
		</div>
		<br /><br />
		<div align="center" name="formulaire">
			<table border="1">
				<tr>
					<th align="center">Numéro Opération</th>
					<th align="center">Numéro Ticket</th>
					<th align="center">Appareil</th>
					<th align="center">Date de prise en charge</th>
					<th align="center">Date de recuperer</th>
					<th align="center">Chargé de l'opération</th>
					<th align="center">Irréparable</th>
					<th align="center">Créer facture</th>
				</tr>
				<?php
					error_reporting(0);
					include "../../../connect.php";
					$vConn = fConnect();
					$vSql = "select t.date_prise_en_charge, o.ticket, m.nom, m.prenom, p.modele, mod.marque, re.duree_reparation, o.num_op
								from operation o, ticket_prise_en_charge t, vmembre_sav m , Modele mod, Produit p, reparation re
								where re.num_op = o.num_op
								and t.num_ticket = o.ticket
								and m.id = o.membre
								and p.num_serie = t.appareil
								and mod.reference =  p.modele
								and not exists(select * from facture_reparation fr where fr.num_op=o.num_op)
								order by re.num_op;";
					$vQuerry = pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuerry, null, PGSQL_ASSOC)){
						$time_c=$vResult['date_prise_en_charge'];
						$duree = $vResult['duree_reparation'];
						$temps_final=date('Y-m-d',strtotime("$time_c + $duree day"));
						echo "<tr>
								<td align='center'>$vResult[num_op]</td>
								<td align='center'>$vResult[ticket]</td>
								<td align='center'>$vResult[marque] $vResult[modele]</td>
								<td align='center'>$vResult[date_prise_en_charge]</td>
								<td align='center'>$temps_final</td>
								<td align='center'>$vResult[nom] $vResult[prenom]</td>";
						echo "<td align='center'>
							<form method='POST' action='irreparable_reparation.php'>
								<input type='hidden' name='num_op' value=$vResult[num_op]>
								<input type='hidden' name='ticket' value=$vResult[ticket]>
								<input type='hidden' name='marque' value=$vResult[marque]>
								<input type='hidden' name='modele' value=$vResult[modele]>
								<input type='hidden' name='date_prise_en_charge' value=$vResult[date_prise_en_charge]>
								<input type='hidden' name='nom' value=$vResult[nom]>
								<input type='hidden' name='prenom' value=$vResult[prenom]>
								<input type='submit' value='Irréparable'>
							</form>
							</td>";
						echo "<td align='center'>
							<form method='POST' action='formulaire_reparation.php'>
								<input type='hidden' name='num_op' value=$vResult[num_op]>
								<input type='hidden' name='ticket' value=$vResult[ticket]>
								<input type='hidden' name='marque' value=$vResult[marque]>
								<input type='hidden' name='modele' value=$vResult[modele]>
								<input type='hidden' name='date_prise_en_charge' value=$vResult[date_prise_en_charge]>
								<input type='hidden' name='nom' value=$vResult[nom]>
								<input type='hidden' name='prenom' value=$vResult[prenom]>
								<input type='hidden' name='temps_final' value=$temps_final>
								<input type='submit' value='Création de la Facture'>
							</form>
							</td>
							</tr>";
					}
					pg_close($vConn);
				?>
			</table>
		<div align="center" name="retourner">
			<h4>Retourner à l'<a = href ="../../Accueil/accueil_SAV.html">Accueil SAV</a></h4>
		</div>
	</body>
</html>