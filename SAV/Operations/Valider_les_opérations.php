<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>Valider les opérations</title>
	</head>
	
	<body style="background-color:#000">
		<div align="center">
        	<font size="+6" color="#FFFFFF">Validation des opérations</font>>
		<br/>
		<div align="center">
			<table border="1" align="center"  style="background-image:url(btk.jpg)">
				<tr>
					<th align="center">Numéro Opération</th>
					<th>Numéro Ticket</th>
					<th>Appareil</th>
					<th>Date de prise en charge</th>
					<th>Chargé de l'opération</th>
					<th>Opération</th>
				</tr>
				<?php
					include "../../connect.php";
					$vConn = fConnect();
					$vSql = "select * from ticket_prise_en_charge where not exists(select * from operation where ticket_prise_en_charge.num_ticket=operation.ticket);";
					$vQuerry = pg_query($vConn, $vSql);
					while($vResult = pg_fetch_array($vQuerry, null, PGSQL_ASSOC))
					{
						$vSql = "insert into operation(ticket,membre) values($vResult[num_ticket],$vResult[membre]);";
						$vQuerry2 = pg_query($vConn, $vSql);
					}
					$vSql = "select o.num_op ,t.num_ticket,t.date_prise_en_charge,m.nom, p.modele, mod.marque 
							from operation o,ticket_prise_en_charge t, vMembre_SAV m, Modele mod, Produit p
							where not exists(select * from reparation where reparation.num_op=o.num_op)
							and not exists(select * from reprise where reprise.num_op=o.num_op)
							and not exists(select * from refus where refus.num_op=o.num_op) and
							m.id = t.membre and t.appareil = p.num_serie and mod.reference =  p.modele and o.ticket = t.num_ticket;";
					$vQuerry = pg_query($vConn, $vSql);
					while($vResult = pg_fetch_array($vQuerry,null, PGSQL_ASSOC))
					{
						echo "<tr><td align='center'>$vResult[num_op]</td>";
						echo "<td align='center'>$vResult[num_ticket]</td>";
						echo "<td align='center'>$vResult[marque] $vResult[modele]</td>";
						echo "<td align='center'>$vResult[date_prise_en_charge]</td>";
						echo "<td align='center'>$vResult[nom]</td>";
						echo "<td><form method='POST' action='Refus/Operation_Refus.php' name='validation1'>
								<input type='hidden' name='num_op' value='$vResult[num_op]'/>
								<input type='hidden' name='appareil' value='$vResult[marque]'/>
								<input type='hidden' name='num_ticket' value='$vResult[num_ticket]'/>
								<input type='hidden' name='date_p' value='$vResult[date_prise_en_charge]'/>
								<input type='hidden' name='nom_c' value='$vResult[nom]'/>
								<input type='submit' value='Refus' style='width:100px;color:red'/></form>
								
								<form method='POST' action='Reprise/Operation_Reprise.php' name='validation2'>
								<input type='hidden' name='num_op' value='$vResult[num_op]'/>
								<input type='hidden' name='appareil' value='$vResult[marque]'/>
								<input type='hidden' name='num_ticket' value='$vResult[num_ticket]'/>
								<input type='hidden' name='date_p' value='$vResult[date_prise_en_charge]'/>
								<input type='hidden' name='nom_c' value='$vResult[nom]'/>
								<input type='submit' value='Reprise' style='width:100px;color:blue'/></form>
								
								<form method='POST' action='Reparation/Operation_Reparation.php' name='validation3'>
								<input type='hidden' name='num_op' value='$vResult[num_op]'/>
								<input type='hidden' name='appareil' value='$vResult[marque]'/>
								<input type='hidden' name='num_ticket' value='$vResult[num_ticket]'/>
								<input type='hidden' name='date_p' value='$vResult[date_prise_en_charge]'/>
								<input type='hidden' name='nom_c' value='$vResult[nom]'/>
								<input type='submit' value='Reparation' style='width:100px;color:green'/>
								</form><td></tr>";
					}
				?>
			</table>
			<font size="+6" color="#FFFFFF">Retourner à l'<a = href ="../Accueil/accueil_SAV.html">Accueil SAV</a></h1></font>
		</div>
	</body>
	</html>