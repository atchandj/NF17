<?php  
	require '../connect.php';
	date_default_timezone_set('Europe/Paris');
	if (!isset($_POST["produit"]) || 
		!isset($_POST["client"]) ||
		!isset($_POST["membre_vente"]) ||
		!isset($_POST["extension"]) ||
		!isset($_POST["specialiste"])){

		header($_SERVER["SERVER_PROTOCOL"] . "400");
		echo "<header>";
		echo "<h1>400 Bad Request</h1>";
		echo "</header>";
	} else{
		$connection = fConnect();

		/*Search corresponding client numnber*/
		$clientQuery = "SELECT num_client FROM client WHERE LOWER(client.nom) = LOWER('$_POST[client]')";
		$cresult = pg_query($connection, $clientQuery);
		$row = null;
		$num_client = -1;
		if (($row = pg_fetch_array($cresult, null, PGSQL_ASSOC)) == null) {
			header($_SERVER["SERVER_PROTOCOL"] . "400");
			echo "<header>";
			echo "<h1>400 Bad Request</h1>";
			echo "</header>";
			echo "<p>No corresponding client is finded.</p>";
			exit(1);
		} else{
			$num_client = $row["num_client"];
		}

		/*Search product info*/
		$produitQuery = "SELECT prix_affiche FROM produit WHERE produit.num_serie = $_POST[produit]";
		$presult = pg_query($connection, $produitQuery);
		$row = null;
		$prix = -1;
		if (($row = pg_fetch_array($presult, null, PGSQL_ASSOC)) == null) {
			header($_SERVER["SERVER_PROTOCOL"] . "400");
			echo "<header>";
			echo "<h1>400 Bad Request</h1>";
			echo "</header>";
			echo "<p>No corresponding product is finded.</p>";
			exit(1);
		} else{
			$prix = $row["prix_affiche"];
		}

		/*Preapre data for the insertion*/
		$insert_list = array(
			"prix" => $prix,
			"date_facture" => date("Y-m-d"),
			"client" => $num_client,
			"membre_vente" => $_POST["membre_vente"]
		);

		/*Start transaction*/
		pg_query($connection, "BEGIN");

		$res = pg_insert($connection, "facture", $insert_list);
		if (!$res) {
			echo "L'échec de enregistrer le facture.";
			pg_query($connection, "ROLLBACK");
			exit(2);
		}

		/*Insert the facture number to facture vente*/
		$factureQuery = "SELECT max(num_facture) AS num FROM facture";
		$factureNumRow = (pg_fetch_array(pg_query($connection, $factureQuery), null, PGSQL_ASSOC));
		$lastFactureNum = $factureNumRow["num"];
		
		$fv = array(
			"num" => $lastFactureNum
		);

		$res = pg_insert($connection, "facture_vente", $fv);
		if (!$res) {
			header($_SERVER["SERVER_PROTOCOL"] . "500");
			echo "L'échec de enregistrer le facture vente.";
			pg_query($connection, "ROLLBACK");
			exit(3);
		}

		/*Insert the facturation*/
		$insert_list = array(
			"facture" => $lastFactureNum,
			"produit" => $_POST["produit"],
			"remise" => $_POST["remise"],
			"specialiste" => $_POST["specialiste"],
			"extension" => $_POST["extension"]
		);

		$res = pg_insert($connection, "facturation", $insert_list);
		if ($res) {
			echo "La facturation a bien enregistré.";
			pg_query($connection, "COMMIT");
		} else{
			echo "L'échec de enregistrer la facturation.";
			pg_query($connection, "ROLLBACK");
		}
	}
?>