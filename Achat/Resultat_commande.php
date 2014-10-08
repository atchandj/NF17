<html>

<head>
	<title>Inscription Soutenance NF17 - Suite</title>
	<meta charset ="UTF-8">
</head>

<body>

<p>

<?php
  include "../connect.php";
  $vConn = fConnect();
  
  $prix = $_POST['prix'];
  $bon = $_POST['num'];
  $vSql = "UPDATE bon_commande
			SET commandepassee = TRUE ,prixUnitaireAchat = $prix
			WHERE num_commande = $bon;";
  $vQuery=pg_query($vConn,$vSql);
  if($vQuery == FALSE)
		echo "<h3>Erreur lors de la mise à jour de la base de donnee !</h3>";
	else
		echo "<h3>Bon de commande mis à jour !</h3>";
  pg_close($vConn);
?> 
  </table>
</p>

<hr/>
  <a href="Passer_commande.html">Retourner à la page précédante</a>
</body>
</html>






