<?php  
	require '../connect.php';


	if (!isset($_POST["type"])) {
		header($_SERVER["SERVER_PROTOCOL"] . " 400");
		echo "<header>";
		echo "<h1>400 Bad Request</h1>";
		echo "</header>";
	} else if (isset($_POST["nofilter"])) {
		runQuery(queryText(true, false, false));
	} else if(isset($_POST["num"])){
		runQuery(queryText(false, true, false));
	} else{
		runQuery(queryText(false, false, true));
	}

	function queryText($nofilter, $num, $other)
	{
		$prodcutQuery = "SELECT p.num_serie, p.prix_affiche AS prix, f.nom_fournisseur, m.garantie, m.extension, m.sous_categorie, m.marque " .
						"FROM modele m, ";
		/*Check the type and search the information from corresponding table*/
		if ($_POST["type"] == "produit") {
			$prodcutQuery .= "produit p, ";
		} else{
			$prodcutQuery .= "produit p, $_POST[type] tn, ";
		}
		/*Add constraints*/
		$prodcutQuery .= 	"fournisseur f " .
							"WHERE m.reference = p.modele AND f.num_fournisseur = p.num_fournisseur AND " .
							"p.num_serie NOT IN(SELECT produit from facturation) ";

		if ($_POST["type"] != "produit"){
			$prodcutQuery .= "AND p.num_serie = tn.num ";
		}	

		/*In the case where no filter has value(expect for type and category)*/
		if ($nofilter) {
			return $prodcutQuery;
		/*In the case where only numero serie has the value, but that's already sufficient to decide a product*/
		} else if ($num) {
			$prodcutQuery .= " AND p.num_serie = $_POST[num]";
			return $prodcutQuery;
		} else if ($other) {
			if (isset($_POST["category"])) {
				$prodcutQuery .= "AND m.categorie = '$_POST[category]' ";
			}
			if (isset($_POST["scategory"])) {
				$prodcutQuery .= "AND m.sous_categorie = '$_POST[scategory]' ";
			}
			if (isset($_POST["prix"])) {
				$prodcutQuery .= "AND p.prix_affiche = $_POST[prix] ";
			}
			if (isset($_POST["modele"])) {
				$prodcutQuery .= "AND p.modele = $_POST[modele] ";
			}
			if (isset($_POST["fournisseur"])) {
				$prodcutQuery .= "AND LOWER(f.nom_fournisseur) = LOWER('$_POST[fournisseur]') ";
			}
			return $prodcutQuery;
		}
	}

	function runQuery($inst)
	{
		header("Content-type: text/javascript");
	
		$connection = fConnect();
		$result = pg_query($connection, $inst);

		$response = array();
		while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			$response[] = array(
				"num_serie" => $row["num_serie"],
				"prix" => ($row["prix"]),
				"nom_fournisseur" => $row["nom_fournisseur"],
				"garantie" => $row["garantie"],
				"extension" => ($row["extension"] == 't')? "Oui" : "Non",
				"sous_categorie" => $row["sous_categorie"],
				"marque" => $row["marque"]
			);
		}

		echo json_encode($response);
	}
?>