<html>

<head>
	<title>Inscription Soutenance NF17 - Suite</title>
	<meta charset ="UTF-8">
</head>

<body>

<p>
  <table border="1">
	<tr>
	<td width="200pt">Numero de commande</td>
	<td width="100pt">Quantite</td>
	<td width="200pt">Membre vente</td>
	<td width="100pt">Modele</td>
	<td width="100pt">Fournisseur</td>
	<td width="100pt">Prix unitaire</td>
	</tr>

<?php
  include "../connect.php";
  $vConn = fConnect();
  $nom_employe=$_POST['nom_employe'];
  $vConn = fConnect();
  $vSql ="SELECT b.num_commande AS num, quantite AS qte, v.nom, v.prenom, modele AS mod, f.nom_fournisseur
          FROM bon_commande b, vMembre_vente v, vMembre_achat a, Fournisseur f
          WHERE a.nom ='$nom_employe' and b.destinataire=a.id AND b.commandepassee=FALSE and b.membre_vente = v.id and b.fournisseur = f.num_fournisseur;";
  $vQuery=pg_query($vConn,$vSql);
  while ($vResult = pg_fetch_array($vQuery)){
	echo "<tr>";
	echo "<td>$vResult[num]</td>";
	echo "<td>$vResult[qte]</td>";
	echo "<td>$vResult[nom] $vResult[prenom]</td>";
	echo "<td>$vResult[mod]</td>";
	echo "<td>$vResult[nom_fournisseur]</td>";
	echo "<td><form method='POST' action='Resultat_commande.php' name='validation'>
			<input type='hidden' name='num' value='$vResult[num]'/>
			<input type='number' name='prix' />
			<input type='submit' value='Envoyer' style='width:100px;color:green'/>
			</form>
		</td>";
	echo "</tr>";
  }
  
  
  pg_close($vConn);
?> 
  </table>
</p>

<hr/>
  <a href="Passer_commande.html">Retourner à la page précédante</a>
</body>
</html>






