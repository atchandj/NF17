
<?php
	function fConnect() {
		$vHost="tuxa.sme.utc";
		$vDbname="dbnf17p007";
		$vPort="5432";
		$vUser="nf17p007";
		$vPassword="iW1udJTo";
		$vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");
		return $vConn;
	}
?>
