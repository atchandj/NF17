<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<title>Facturation : Demande de la remise</title>
	</head>
	<body>
		<div align="center">
		
		<FORM METHOD = "POST" ACTION="resultat_facturation.php">
		<fieldset>
		<legend>Demande de la remise </legend>
		<p>
		<label for="remise" >Remise : </label> 
		<input type ="text" name = "remise" placeholder="Ex : 153" id ="remise">
		<?php
		echo "<input type='hidden' name='num_fact' value='".$_GET['num_fact']."'/>";
		echo "<input type='hidden' name='produit' value='".$_GET['produit']."'/>";
		?>
		</p>
		<input type="submit" value="Envoyer" />
		</fieldset>
		</FORM>
			</div>
		</body>
</html>