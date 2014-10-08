<?php
	
	require '../connect.php';

	$modele = NULL;
	$fournisseur = NULL;
	$quantite = NULL;
	$destinataire = NULL;
	$membre_vente = NULL;

 	if( isset($_POST["modele"]) && 
		isset($_POST["fournisseur"]) && 
		isset($_POST["quantite"]) &&
		isset($_POST["destinataire"]) &&
		isset($_POST["membre_vente"]) ) {

 		$modele = $_POST["modele"];
		$fournisseur = $_POST["fournisseur"];
		$quantite = $_POST["quantite"];
		$destinataire = $_POST["destinataire"];
		$membre_vente = $_POST["membre_vente"];
	  	
		$connect = fConnect();
		
		/*Search the corresponding client number by name*/		
		$query_fournisseur = "SELECT num_fournisseur FROM fournisseur WHERE LOWER(nom_fournisseur) = LOWER('$fournisseur')";
		$vQuery = pg_query($connect, $query_fournisseur);
		$vRes = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
		$fournisseur = $vRes["num_fournisseur"];

		$insert_list = array(
				"modele" => $modele,
				"fournisseur" => $fournisseur,
				"quantite" => $quantite,
				"destinataire" => $destinataire,
				"membre_vente" => $membre_vente,
				"ref_produit" => -1,
				"commandepassee" => FALSE
		);

	  	$res = pg_insert($connect, 'bon_commande', $insert_list);
	  	if($res){
	  		echo "Bon de commande enregistré.";
		} else{
			header($_SERVER['SERVER_PROTOCOL'] . "500");
	  		echo "L'échec de insertion de bon de commande.";
  		}
	} else{
		header($_SERVER["SERVER_PROTOCOL"] . "400");
		echo "<h1>Il faut remplir tous les valeurs.</h1><br/>";
	}
?>