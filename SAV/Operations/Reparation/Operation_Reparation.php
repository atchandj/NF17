<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>Reparation</title>
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
				$vConn = fConnect();
				
				/*$appareil=$_POST['appareil'];
				$date_p=$_POST['date_p'];
				$nom_c=$_POST['nom_c'];
				$num_ticket = $_POST['num_ticket'];*/
				$num_op=$_POST['num_op'];
				$vSql = "select * from Operation o, ticket_prise_en_charge t where o.num_op = $num_op and t.num_ticket =o.ticket ;";
				$vQuerry = pg_query($vConn, $vSql);
				$vResult = pg_fetch_array($vQuerry, null, PGSQL_ASSOC);
				echo "<tr><td align='center'>$vResult[num_op]</td>";
				echo "<td align='center'>$vResult[ticket]</td>";
				echo "<td align='center'>$vResult[appareil]</td>";
				echo "<td align='center'>$vResult[date_prise_en_charge]</td>";
				echo "<td align='center'>$vResult[membre]</td>";
				echo "</tr></table>";
				echo "
					<form method='POST' action='Resultat_Reparation.php'>
						<h1>Donnez la durée de la reparation<input type='text' name='duree' placeholder='Le nombre de jours!'></h1>
						<input type='hidden' name='num_op' value='$num_op'/>
						<input type='hidden' name='appareil' value='$vResult[appareil]'/>
						<input type='hidden' name='num_ticket' value='$vResult[ticket]'/>
						<input type='hidden' name='date_p' value='$vResult[date_prise_en_charge]'/>
						<input type='hidden' name='nom_c' value='$vResult[membre]'/>
						<input type='submit' value='Valider'>
					</form>";
				pg_close($vConn);
			?>
		</div>
	</body>
</html>