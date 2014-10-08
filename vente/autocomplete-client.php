<?php
	require '../connect.php';

	if(!isset($_POST["client"])){
		echo "<header>";
		echo "<h1>400 Bad Request</h1>";
		echo "</header>";
		header($_SERVER["SERVER_PROTOCOL"] . " 400");
	} else {
		$connection = fConnect();

		$query = null;

		header("Content-type: text/javascript");
		$query = "SELECT nom FROM client WHERE LOWER(nom) LIKE LOWER('$_POST[client]%') LIMIT 5";
		$result = pg_query($connection, $query);

		$aclist = array();
		while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			$aclist[] = $row["nom"];
		}

		$acjson = json_encode($aclist);
		echo $acjson;
	}
?>