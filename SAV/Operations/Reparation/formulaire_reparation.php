<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>Formulaire de la facture de la reparation</title>
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
			echo "<br /><br/><br /><form method='POST' action='resultat_facture_reparation.php' style='background-color:black'>
					<font color='#FFFFFF'>Donnez le prix de la reparation<input type='text' name='prix'></font>
					<input type='hidden' name='num_op' value=$num_op>
					<input type='hidden' name='ticket' value=$ticket>
					<input type='hidden' name='marque' value=$marque>
					<input type='hidden' name='modele' value=$modele>
					<input type='hidden' name='date_prise_en_charge' value=$date_prise_en_charge>
					<input type='hidden' name='nom' value=$nom>
					<input type='hidden' name='prenom' value=$prenom>
				<input type='submit' value='Créer la facture' style='background-color:white'>
				</form>
			";
		?>
		</div>
		<br /><br /><div align="center" name="retourner">
			<h4>Retourner à l'<a = href = "../../Accueil.accueil_SAV.html">Accueil SAV</a></h4>
			<h4>Retourner aux <a = href ="Resultat_Reparation_de_Produits.php">opérations des reparation</a></h4>
		</div>
	</body>
</html>