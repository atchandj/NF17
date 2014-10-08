<?php
	
	require '../connect.php';

	if (!isset($_POST["category"])) {
		header($_SERVER["SERVER_PROTOCOL"] . "400");
		echo "<header>";
		echo "<h1>400 Bad Request</h1>";
		echo "</header>";
	} else{
		header("Content-type: text/javascript");
		$connection = fConnect();
		$sCategoryQuery = "SELECT nom FROM sous_categorie WHERE categorie = '$_POST[category]'";
		$result = pg_query($connection, $sCategoryQuery);
		
		$response = array(); 
		while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			$response[] = $row["nom"];
		}

		echo json_encode($response);
	}
?>