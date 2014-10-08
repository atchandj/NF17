<?php  
	require '../connect.php';
	
	if (!isset($_POST["factureType"])) {
		header($_SERVER["SERVER_PROTOCOL"] . " 400");
		echo "<header>";
		echo "<h1>400 Bad Request</h1>";
		echo "</header>";
	} else if(isset($_POST["nofilter"])){
		/*No condition is selected, list all the factures*/
		$tab_name = fact_table_name($_POST["factureType"]);
		$queryFacture = null;
		if ($tab_name != "facture") {
			if ($tab_name != "facture_vente") {
				$queryFacture = "SELECT DISTINCT f.num_facture,f.prix,f.date_facture,c.nom AS client, tn.num_op" . 
					" FROM facture f, client c, $tab_name tn WHERE tn.num = f.num_facture AND f.client = c.num_client;";
			} else{
				$queryFacture = "SELECT f.num_facture,f.prix,f.date_facture,c.nom AS client,mv.nom AS mv_n, mv.prenom AS mv_p" . 
					" FROM facture f, client c, vmembre_vente mv, $tab_name tn WHERE tn.num = f.num_facture AND f.client = c.num_client AND mv.id = f.membre_vente";
			}
		} else{
			$queryFacture = "SELECT f.num_facture,f.prix,f.date_facture,c.nom AS client,mv.nom AS mv_n, mv.prenom AS mv_p" . 
		" FROM facture f, client c, vmembre_vente mv WHERE f.client = c.num_client AND mv.id = f.membre_vente;";
		}

		startQuery($queryFacture, $_POST["factureType"]);
	} else if(isset($_POST["num"])){
		/*If we have number of the facture, the facture already unique.*/
		$queryFacture = "SELECT f.num_facture,f.prix,f.date_facture,c.nom AS client,mv.nom AS mv_n, mv.prenom AS mv_p" . 
		" FROM facture f, client c, vmembre_vente mv WHERE num_facture = $_POST[num] AND f.client = c.num_client AND mv.id = f.membre_vente";
		
		startQuery($queryFacture, $_POST["factureType"]);
	} else{
		/*Specific conditions have been chosen, list the corresponding factures*/
		$tab_name = fact_table_name($_POST["factureType"]);
		$queryFacture = null;
		
		if ($tab_name != "facture") {
			if($tab_name != "facture_vente"){
				$queryFacture = "SELECT f.num_facture,f.prix,f.date_facture,c.nom AS client,mv.nom AS mv_n, mv.prenom AS mv_p, tn.num_op" . 
				" FROM facture f, client c, vmembre_vente mv, $tab_name tn WHERE f.num_facture = tn.num AND f.client = c.num_client AND mv.id = f.membre_vente ";
			} else{
				$queryFacture = "SELECT f.num_facture,f.prix,f.date_facture,c.nom AS client,mv.nom AS mv_n, mv.prenom AS mv_p" . 
				" FROM facture f, client c, vmembre_vente mv, $tab_name tn WHERE f.num_facture = tn.num AND f.client = c.num_client AND mv.id = f.membre_vente ";
			}
		} else {
			$queryFacture = "SELECT f.num_facture,f.prix,f.date_facture,c.nom AS client,mv.nom AS mv_n, mv.prenom AS mv_p" . 
			" FROM facture f, client c, vmembre_vente mv WHERE f.client = c.num_client AND mv.id = f.membre_vente ";
		}

		/*Add constraint*/
		if (isset($_POST["prix"])) {
			$queryFacture .= "AND f.prix = $_POST[prix] ";
		}
		if (isset($_POST["date"])) {
			$queryFacture .= "AND f.date_facture = to_date('$_POST[date]', 'YYYY-MM-DD') ";
		}
		if (isset($_POST["emetteur"])) {
			$queryFacture .= "AND LOWER(f.emetteur) = LOWER('$_POST[emetteur]') ";
		}
		if (isset($_POST["client"])) {
			$queryFacture .= "AND LOWER(c.nom) = LOWER('$_POST[client]') ";
		}
		if (isset($_POST["destinataire"])) {
			$queryFacture .= "AND LOWER(f.destinataire) = LOWER('$_POST[destinataire]') ";
		}
		if (isset($_POST["membre_vente"])) {
			$queryFacture .= "AND f.membre_vente = $_POST[membre_vente]";
		}

			startQuery($queryFacture, $_POST["factureType"]);
	}

	function fact_table_name($factureType){
		$fact_table_name = null;

		if ($factureType == 0) {
			$fact_table_name = "facture";
		} else if ($factureType == 1){
			$fact_table_name = "facture_reparation";
		} else if($factureType == 2){
			$fact_table_name = "facture_reprise";
		} else if($factureType == 3){
			$fact_table_name = "facture_vente";
		}
		
		return $fact_table_name;
	}

	function startQuery($inst, $factureType)
	{
		$connection = fConnect();

		header("Content-type: text/javascript");
		$result = pg_query($connection, $inst);
		
		$response = array();
		while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		
		foreach($row["mv_p"] as $element)
			{
				if($element == NULL)
					$element = "Aucun";
			}
			if ($factureType == 0 || $factureType == 3) {
				/*For facture and facture vente*/
				$response[] = array(
					"num" => $row["num_facture"],
					"prix" => $row["prix"], 
					"date" => $row["date_facture"], 
					"client" => $row["client"], 
					"membre_vente" => $row["mv_p"] . " " . $row["mv_n"]
				);
			} else if($factureType == 2 || $factureType == 1){
				/*For facture reprise and facture reparation*/
				$response[] = array(
					"num" => $row["num_facture"],
					"num_op" => $row["num_op"],
					"prix" => $row["prix"], 
					"date" => $row["date_facture"], 
					"client" => $row["client"], 
					"membre_vente" => "Aucun" //$row["mv_p"] . " " . $row["mv_n"]
				);
			}
		}

		echo json_encode($response);
	}
?>