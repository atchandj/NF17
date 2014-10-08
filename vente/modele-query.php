<?php  
	require '../connect.php';

	/*-----------------------------------------Main process-----------------------------------------*/
	if (isset($_POST["nofilter"])) {
		runQuery(queryText(true));
	} else {
		runQuery(queryText(false));
	}

	/*-----------------------------------------Function---------------------------------------------*/
	function queryText($nofilter)
	{
		/*Normal query with all data*/
		$modeleQuery = "SELECT m.reference, m.prix_reference AS prix, m.garantie, m.extension, m.sous_categorie, m.marque, m.consommation FROM modele m";

		if ($nofilter) {
			/*In the case where no filter has value(expect for category)*/
			return $modeleQuery;
		} else {
			$modeleQuery .= " WHERE ";
			$moreThanOne = false;
			if (isset($_POST["ref"])) {
				$moreThanOne = true;
				$modeleQuery.= "m.reference = '$_POST[ref]' ";
			}
			if (isset($_POST["category"])) {
				$modeleQuery .= ($moreThanOne)? "AND " : '';
				$moreThanOne = true;
				
				$modeleQuery.= "m.categorie = '$_POST[category]' ";
			}
			if (isset($_POST["scategory"])) {
				$modeleQuery .= ($moreThanOne)? "AND " : '';
				$moreThanOne = true;
				
				$modeleQuery.= "m.sous_categorie = '$_POST[scategory]' ";
			}
			if (isset($_POST["prix"])) {
				$modeleQuery .= ($moreThanOne)? "AND " : '';
				$moreThanOne = true;
				
				$modeleQuery.= "m.prix_reference = $_POST[prix] ";
			}
			if (isset($_POST["extension"])) {
				$modeleQuery .= ($moreThanOne)? "AND " : '';
				$moreThanOne = true;
				
				$modeleQuery.= "m.extension = $_POST[extension] ";
			}
			if (isset($_POST["consommation"])) {
				$modeleQuery .= ($moreThanOne)? "AND " : '';
				$moreThanOne = true;
				
				$modeleQuery.= "m.consommation = $_POST[consommation] ";
			}
			if (isset($_POST["garantie"])) {
				$modeleQuery .= ($moreThanOne)? "AND " : '';
				$moreThanOne = true;
				
				$modeleQuery.= "m.garantie = $_POST[garantie] ";
			}
			if (isset($_POST["marque"])) {
				$modeleQuery .= ($moreThanOne)? "AND " : '';
				$moreThanOne = true;
				
				$modeleQuery.= "LOWER(m.marque) = LOWER('$_POST[marque]') ";
			}

			return $modeleQuery;
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
				"reference" => $row["reference"],
				"prix" => ($row["prix"]),
				"consommation" => $row["consommation"],
				"garantie" => $row["garantie"],
				"extension" => ($row["extension"] == 't')? "Oui" : "Non",
				"sous_categorie" => $row["sous_categorie"],
				"marque" => $row["marque"]
			);
		}

		echo json_encode($response);
	}
?>