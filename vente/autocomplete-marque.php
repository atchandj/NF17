<?php
	require '../connect.php';

	if(!isset($_POST["marque"])){
		echo "<header>";
		echo "<h1>400 Bad Request</h1>";
		echo "</header>";
		header($_SERVER["SERVER_PROTOCOL"] . " 400");
	} else {
		$connection = fConnect();

		$query = null;

		header("Content-type: text/javascript");
		$query = "SELECT nom FROM marque WHERE LOWER(nom) LIKE LOWER('$_POST[marque]%') LIMIT 5";
		$result = pg_query($connection, $query);

		$aclist = array();
		while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			$aclist[] = $row["nom"];
		}

		$acjson = json_encode($aclist);
		echo $acjson;
	}
?>