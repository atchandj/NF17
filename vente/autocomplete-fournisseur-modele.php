<?php
	require '../connect.php';

	if(!isset($_POST["modele"]) && !isset($_POST["fournisseur"])){
		echo "<header>";
		echo "<h1>400 Bad Request</h1>";
		echo "</header>";
		header($_SERVER["SERVER_PROTOCOL"] . " 400");
	} else{
		$query = null;
		header("Content-type: text/javascript");
		if (isset($_POST["modele"])) {
			$query = "SELECT reference FROM modele WHERE reference LIKE '$_POST[modele]%' LIMIT 5";
			serializeToJSON($query, "reference");
		} else if(isset($_POST["fournisseur"])){
			$query = "SELECT nom_fournisseur FROM fournisseur WHERE LOWER(nom_fournisseur) LIKE LOWER('$_POST[fournisseur]%') LIMIT 5";
			serializeToJSON($query, "nom_fournisseur");
		}
	}

	function serializeToJSON($inst, $keyword)
	{
		$connect = fConnect();

		$result = pg_query($connect, $inst);

		$list = array();
		while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			$list[] = $row[$keyword];
		}

		echo json_encode($list);
	}
?>