/*Global variables*/
var keyupfunctionOnRunning;
var modele_last_text = '';
var fournisseur_last_text = '';
var client_last_text = '';
var lastTextArray = new Array(4);
var xmlhttp;

/*Initialise components*/
function init (filename) {
	if (filename == "facture") {
		$("#date-facture").datepicker({ dateFormat: "yy-mm-dd" });
		$("#num-facture").keyup(function(){
			this.value = this.value.replace(/[^0-9]/g,'');
		});
		$("#prix-facture").keyup(function(){
			this.value = this.value.replace(/[^0-9]/g,'');
		});
		$("#num-operation").keyup(function(){
			this.value = this.value.replace(/[^0-9]/g,'');
		});
	} else if(filename == "boncommande"){
		$("#modele").keyup(function(){
			this.value = this.value.replace(/[^0-9]/g,'');
		});
		$("#quantite").keyup(function(){
			this.value = this.value.replace(/[^0-9]/g,'');
		});
		$("#search-annuler").click(function(){
			$("#modele-search-segment").hide("drop", 800);
		});
		$("#search-valider").click(function(){
			$("#modele-search-segment").hide("drop", 800);
		});
		$("#cm-button").click(function(){
			$("#modele-search-segment").show("drop", 800);
		});
	} else if (filename == "facturation") {
		$("#cpButton").click(function(){
			$("#produit-search-segment").show("drop", 800);
		});
		$("#search-annuler").click(function(){
			$("#produit-search-segment").hide("drop", 800);
		});
		$("#search-valider").click(function(){
			$("#produit-search-segment").hide("drop", 800);
		});
		$("#remise").keyup(function(){
			this.value = this.value.replace(/[^0-9]/g,'');
		});
		$("#serie-produit").keyup(function(){
			this.value = this.value.replace(/[^0-9]/g,'');
		});
		$("#prix-produit").keyup(function(){
			this.value = this.value.replace(/[^0-9]/g,'');
		});
		$("#modele-produit").keyup(function(){
			this.value = this.value.replace(/[^0-9]/g,'');
		});
		$("#remise").keyup(function(){
			this.value = this.value.replace(/[^0-9]/g,'');
		});

	}
}

function loadXMLHttp(){
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	}
	return new ActiveXObject("Microsoft.XMLHTTP");
}

/*AJAX autocomplete*/
function autocomplete_generator (textbox, type, id) {
	var text = textbox.value;

	/*Ajax part*/
	xmlhttp = loadXMLHttp();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			//Get data from server in JSON format
			autocomplete_activate(id);
		}
	}
	if(type < 2){
		xmlhttp.open("POST", "autocomplete-fournisseur-modele.php", true);
	} else if(type == 2){
		xmlhttp.open("POST", "autocomplete-client.php", true);		
	} else if(type == 3){
		xmlhttp.open("POST", "autocomplete-marque.php", true);
	}
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	if (type == 0) {
		xmlhttp.send("modele=" + text);
	} else if(type == 1){
		xmlhttp.send("fournisseur=" + text);
	} else if(type == 2){
		xmlhttp.send("client=" + text);
	} else if(type == 3){
		xmlhttp.send("marque=" + text);
	}
}
/*	type: 	0 - modele(useless) 
			1 - fournisseur
			2 - client
			3 - marque
	
	id: the id of text box
	
	textbox: text box object
*/
function keyupTrigger (textbox, type, id, delay) {
	clearTimeout(keyupfunctionOnRunning);
	keyupfunctionOnRunning = setTimeout(function(){
		keyupEventValidate(textbox, type, id);
	}, delay);
}

function keyupEventValidate (textbox, type, id) {
	if(textbox.value != '' && textbox.value != lastTextArray[type]){
		autocomplete_generator(textbox, type, id);
		lastTextArray[type] = textbox.value;
	} else if(textbox.value == ''){
		lastTextArray[type] = '';
	}
}

function autocomplete_activate (id) {
	var aclist = eval("(" + xmlhttp.responseText + ")");

	$('#' + id).autocomplete({
		source:aclist
	});
}

/*AJAX facture recherche*/
function rechercher_facture(event) {
	$("#submitButton").attr("disabled", "disabled");
	var type_select = document.getElementById("facture-type-select");
	factureRequest(type_select.selectedIndex);
}

function factureRequest (factureType) {

	var xmlhttp_fact = loadXMLHttp();

	var url = "factureQuery.php?timeStamp=" + new Date().getTime();

	xmlhttp_fact.onreadystatechange = function(){
		if (xmlhttp_fact.readyState == 4 && xmlhttp_fact.status == 200) {
			refreshTabData(xmlhttp_fact.responseText);
		}
	}

	xmlhttp_fact.open("POST", url, true);
	xmlhttp_fact.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	var sendtext = '';

	if (document.getElementById("num-facture").value > 0) {
		sendtext = "num=" + document.getElementById("num-facture").value + "&&factureType=" + factureType;
	} else{
		var prix = document.getElementById("prix-facture").value;
		var date = document.getElementById("date-facture").value;
		var client = document.getElementById("client-facture").value.trim();
		var membre_vente = document.getElementById("membre-vente-facture").value;

		if (prix != '' && prix != null) {
			sendtext += ("prix=" + prix);
		}
		if (date != '' && date != null) {
			sendtext += ("&date=" + date);
		}
		if (client != '' && client != null) {
			sendtext += ("&client=" + client);
		}
		if (membre_vente != 0) {
			sendtext += ("&membre_vente=" + membre_vente);
		}

		if (!sendtext == '') {
			sendtext += "&factureType=" + factureType;
		} else{
			sendtext = "factureType=" + factureType + "&nofilter=1";
		}
	}

	xmlhttp_fact.send(sendtext);
}

function refreshTabData (jsonText) {
	var tab_data = eval('(' + jsonText + ')');
	var table = document.getElementById("facture-tab");
	table.innerHTML = "<tr><th>Numéro</th><th>Prix</th>" + 
		"<th>Date</th>" + "<th>Client</th><th>Membre vente</th></tr>";
	for (var i = 0; i < tab_data.length; i++) {
		table.innerHTML += 
		"<tr><td>" + tab_data[i]['num'] + "</td>" +
		"<td>" + tab_data[i]['prix'] + "</td>" +
		"<td>" + tab_data[i]['date'] + "</td>" +
		"<td>" + tab_data[i]['client'] + "</td>" +
		"<td>" + tab_data[i]['membre_vente'] + "</td>";
	}

	document.getElementById("tab-title").style.display = "block";
	$("#submitButton").removeAttr("disabled");
}

/*Facture type change handler*/
function factureTypeChange (selectObject) {
	if(selectObject.selectedIndex == 0 || selectObject.selectedIndex == 3){
		document.getElementById("num-operation-block").style.display = 'none';
	} else {
		document.getElementById("num-operation-block").style.display = 'inline-block';
	}
}

/*Vendre des produits*/
function spCheckBoxChangeState (id) {
	if (id == "specialiste-oui") {
		document.getElementById("specialiste-non").checked = false;
	} else if(id == "specialiste-non"){
		document.getElementById("specialiste-oui").checked = false;
	}
}

function exCheckBoxChangeState (id) {
	if (id == "extension-oui") {
		document.getElementById("extension-non").checked = false;
	} else if(id == "extension-non"){
		document.getElementById("extension-oui").checked = false;
	}
}

function categoryChose (selectObject) {
	if (selectObject.selectedIndex != 0) {
		var cValue = selectObject.options[selectObject.selectedIndex].value;
		ccXmlHttp = loadXMLHttp();
		ccXmlHttp.onreadystatechange = function(){
			if (ccXmlHttp.readyState == 4 && ccXmlHttp.status == 200) {
				var scList = eval('(' + ccXmlHttp.responseText + ')');

				var scs = document.getElementById("sous-category-select");
				scs.innerHTML = "<option value='invalid'>------------------</option>";

				for (var i = 0; i < scList.length; i++) {
					scs.innerHTML += "<option value='" + scList[i] + "'>" + scList[i] + "</option>";
				}

				document.getElementById("sous-category-block").style.display = "inline-block";
			}
		}
		ccXmlHttp.open("POST", "scategory-query.php", true);
		ccXmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ccXmlHttp.send("category=" + cValue);
	} else{
		document.getElementById("sous-category-block").style.display = "none";
		document.getElementById("sous-category-select").innerHTML = "<option value='invalid'>------------------</option>";
	}
}

/*Serach the product*/
function searchButtonPressed (type) {
	$("#search-submit").attr("disabled", "disabled");
	if (type == "product") {
		productSearchStart();
	} else if(type == "modele"){
		modeleSearchStart();
	}
}

function productSearchStart () {
	var psXMLHttp = loadXMLHttp();

	psXMLHttp.onreadystatechange = function(){
		if (psXMLHttp.readyState == 4 && psXMLHttp.status == 200) {
			refreshProduitTab(psXMLHttp.responseText);
		}
	}

	psXMLHttp.open("POST", "produit-query.php", true);
	psXMLHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	/*Category*/
	var categorySelect = document.getElementById("category-select");
	var category = categorySelect.options[categorySelect.selectedIndex].value;
	var subCategory = "invalid";
	if (category != "invalid") {
		var subCategorySelect = document.getElementById("sous-category-select");
		subCategory = subCategorySelect.options[subCategorySelect.selectedIndex].value;
	}

	/*Type*/
	var typeSelect = document.getElementById("type-produit-select");
	var type_produit = typeSelect.options[typeSelect.selectedIndex].value;

	/*others*/
	var num = document.getElementById("serie-produit").value;
	var prix = document.getElementById("prix-produit").value;
	var modele = document.getElementById("modele-produit").value;
	var fournisseur = document.getElementById("fournisseur-produit").value;

	var sendtext = "type=" + type_produit;
	
	if (category != "invalid") {
		sendtext += ("&category=" + category); 
	}
	if (subCategory != "invalid") {
		sendtext += ("&scategory=" + subCategory); 
	}
	if (num != '' && num != null) {
		sendtext += ("&num=" + num);
	}
	if (prix != '' && prix != null) {
		sendtext += ("&prix=" + prix);
	}
	if (modele != '' && modele != null) {
		sendtext += ("&modele=" + modele);
	}
	if (fournisseur != '' && fournisseur != null) {
		sendtext += ("&fournisseur=" + fournisseur);
	}

	/*No standard*/
	if (sendtext == ("type=" + type_produit)) {
		sendtext += "&nofilter=1";
	}
	psXMLHttp.send(sendtext);
}

function modeleSearchStart () {
	var msXMLHttp = loadXMLHttp();

	msXMLHttp.onreadystatechange = function(){
		if (msXMLHttp.readyState == 4 && msXMLHttp.status == 200) {
			refreshModeleTab(msXMLHttp.responseText);
		}
	}

	msXMLHttp.open("POST", "modele-query.php", true);
	msXMLHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	/*Category*/
	var categorySelect = document.getElementById("category-select");
	var category = categorySelect.options[categorySelect.selectedIndex].value;
	var subCategory = "invalid";
	if (category != "invalid") {
		var subCategorySelect = document.getElementById("sous-category-select");
		subCategory = subCategorySelect.options[subCategorySelect.selectedIndex].value;
	}

	/*extension*/
	var extensionSelect = document.getElementById("extension-modele");
	var extension = extensionSelect.options[extensionSelect.selectedIndex].value;

	/*others*/
	var ref = document.getElementById("reference-modele").value;
	var prix = document.getElementById("prix-modele").value;
	var consommation = document.getElementById("consommation-modele").value;
	var garantie = document.getElementById("garantie-modele").value;
	var marque = document.getElementById("marque-modele").value;

	var sendtext = '';
	
	if (category != "invalid") {
		sendtext += ("&category=" + category); 
	}
	if (subCategory != "invalid") {
		sendtext += ("&scategory=" + subCategory); 
	}
	if (extension != "invalid") {
		sendtext += ("&extension=" + extension); 
	}
	if (ref != '' && ref != null) {
		sendtext += ("&ref=" + ref);
	}
	if (prix != '' && prix != null) {
		sendtext += ("&prix=" + prix);
	}
	if (consommation != '' && consommation != null) {
		sendtext += ("&consommation=" + consommation);
	}
	if (garantie != '' && garantie != null) {
		sendtext += ("&garantie=" + garantie);
	}
	if (marque != '' && marque != null) {
		sendtext += ("&marque=" + marque);
	}

	/*No standard*/
	if (sendtext == '') {
		sendtext += "nofilter=1";
	}

	msXMLHttp.send(sendtext);
}

function refreshProduitTab (jsonText) {
	var produit_tab = eval('(' + jsonText + ')');

	var pTable = document.getElementById("produit-list-tab");

	pTable.innerHTML = 	"<tr>" +
						"<th></th>" +
						"<th>Numéro sérié</th>" +
						"<th>Prix</th>" +
						"<th>Fournisseur</th>" +
						"<th>Garantie durée</th>" +
						"<th>Extension</th>" +
						"<th>Catégorie</th>" + 
						"<th>Marque</th>" + 
						"</tr>";

	for (var i = 0; i < produit_tab.length; i++) {
		pTable.innerHTML += (
			"<tr>" +
			"<td><input type='radio' value='" + produit_tab[i]["num_serie"] + "' id='produit-row-" + (i + 1) + 
				"' onchange='rowRadioBoxOnChange(this.id, \"produit\");'></td>" +
			"<td id='numserie-row-" + (i + 1) +"'>" + produit_tab[i]["num_serie"] + "</td>" +	
			"<td>" + produit_tab[i]["prix"] + " &#8364" + "</td>" +
			"<td>" + produit_tab[i]["nom_fournisseur"] + "</td>" +	
			"<td>" + produit_tab[i]["garantie"] + "</td>" +
			"<td id='extension-row-" + (i + 1) + "'>" + produit_tab[i]["extension"] + "</td>" +	
			"<td>" + produit_tab[i]["sous_categorie"] + "</td>" +	
			"<td>" + produit_tab[i]["marque"] + "</td>" +
			"</tr>"
		)
	}

	$("#produit-list-tab tr:odd").css("background", "#81aa9c");
	$("#search-submit").removeAttr("disabled");
	$("#search-valider").attr("disabled", "disabled");
}

function refreshModeleTab (jsonText) {
	var modele_tab = eval('(' + jsonText + ')');

	var mTable = document.getElementById("modele-list-tab");

	mTable.innerHTML = 	"<tr>" +
						"<th></th>" +
						"<th>Référence</th>" +
						"<th>Prix de référence</th>" +
						"<th>Consommation</th>" +
						"<th>Garantie durée</th>" +
						"<th>Extension</th>" +
						"<th>Catégorie</th>" + 
						"<th>Marque</th>" + 
						"</tr>";

	for (var i = 0; i < modele_tab.length; i++) {
		mTable.innerHTML += (
			"<tr>" +
			"<td><input type='radio' value='" + modele_tab[i]["reference"] + "' id='modele-row-" + (i + 1) + 
				"' onchange='rowRadioBoxOnChange(this.id, \"modele\");'></td>" +
			"<td id='reference-row-" + (i + 1) +"'>" + modele_tab[i]["reference"] + "</td>" +	
			"<td>" + modele_tab[i]["prix"] + " &#8364" + "</td>" +
			"<td>" + modele_tab[i]["consommation"] + "</td>" +	
			"<td>" + modele_tab[i]["garantie"] + "</td>" +
			"<td>" + modele_tab[i]["extension"] + "</td>" +	
			"<td>" + modele_tab[i]["sous_categorie"] + "</td>" +	
			"<td>" + modele_tab[i]["marque"] + "</td>" +
			"</tr>"
		)
	}

	$("#modele-list-tab tr:odd").css("background", "#81aa9c");
	$("#search-submit").removeAttr("disabled");
	$("#search-valider").attr("disabled", "disabled");
}

/*keyword indicate the prefix of id*/
function rowRadioBoxOnChange (radioID, keyword) {
	var id = (radioID.split("-"))[2];

	var mRow = document.getElementById(keyword + "-list-tab").rows.length - 1;
	for (var i = 1; i <= mRow; i++) {
		if (i != id) {
			document.getElementById(keyword + "-row-" + i).checked = false;
		}
	}

	$("#search-valider").removeAttr("disabled");
}

function productOnValidate () {
	var formProductNum = document.getElementById("produit");

	/*Get checked line*/
	var checkedItemRow = -1;
	var mRow = document.getElementById("produit-list-tab").rows.length - 1;
	for (var i = 1; i <= mRow; i++) {
		if (document.getElementById("produit-row-" + i).checked) {
			checkedItemRow = i;
			break;
		}
	}
	if (checkedItemRow != -1) {
		/*Value transfered to the text-box*/
		formProductNum.value = document.getElementById("numserie-row-" + checkedItemRow).innerHTML;

		/*Check if extension is valid*/
		var extension = document.getElementById("extension-row-" + checkedItemRow).innerHTML;
		if (extension == "Non") {
			$("#extension-oui").attr("disabled" ,"disabled");
			$("#extension-non").attr("disabled" ,"disabled");
		} else{
			$("#extension-oui").removeAttr("disabled");
			$("#extension-non").removeAttr("disabled");
		}
	}
}

function modeleOnValidate () {
	var formModeleRef = document.getElementById("modele");

	/*Get checked line*/
	var checkedItemRow = -1;
	var mRow = document.getElementById("modele-list-tab").rows.length - 1;
	for (var i = 1; i <= mRow; i++) {
		if (document.getElementById("modele-row-" + i).checked) {
			checkedItemRow = i;
			break;
		}
	}
	if (checkedItemRow != -1) {
		/*Value transfered to the text-box*/
		formModeleRef.value = document.getElementById("reference-row-" + checkedItemRow).innerHTML;
	}
}

function facturerButtonOnClick () {
	var produit = document.getElementById("produit").value;
	var client = document.getElementById("client").value;
	var remise = document.getElementById("remise").value;

	/*membre vente*/
	var mvSelect = document.getElementById("membre_vente");
	var membre_vente = mvSelect.options[mvSelect.selectedIndex].value;

	/*extension*/
	var extension = null;
	if (!document.getElementById("extension-oui").disabled) {
		extension = document.getElementById("extension-oui").checked ? true : false;
	} else{
		extension  = false;
	}
	/*specialiste*/
	specialiste = document.getElementById("specialiste-oui").checked ? true : false;

	/*AJAX Ready*/
	faXmlHttp = loadXMLHttp();
	faXmlHttp.onreadystatechange = function(){
		if (faXmlHttp.readyState == 4 && faXmlHttp.status == 200) {
			alert(faXmlHttp.responseText);
		}
	};

	faXmlHttp.open("POST", "creer-facture.php", true);
	faXmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	/*Check value*/
	var sendtext = '';
	if (produit != '' && produit != null) {
		sendtext += ("produit=" + produit);
	}
	if (client != '' && client != null) {
		sendtext += ("&client=" + client);
	}
	if (remise != '' && remise != null) {
		sendtext += ("&remise=" + remise);
	}

	sendtext += ("&membre_vente=" + membre_vente + "&specialiste=" + specialiste);
	if (extension != null) {
		sendtext += ("&extension=" + extension);
	}

	faXmlHttp.send(sendtext);
}

/*Bon de commande*/
function submit_bon_commande () {
	var sbcXmlHttp = loadXMLHttp();

	sbcXmlHttp.onreadystatechange = function(){
		if (sbcXmlHttp.readyState == 4 && sbcXmlHttp.status == 200) {
			alert(sbcXmlHttp.responseText);
		}
	};

	sbcXmlHttp.open("POST", "creer_bon_de_commande.php", true);
	sbcXmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	/*Prepare data*/
	var modele = document.getElementById("modele").value;
	var quantite = document.getElementById("quantite").value;
	var fournisseur = document.getElementById("fournisseur").value;

	var dSelect = document.getElementById("destinataire");
	var mvSelect = document.getElementById("membre_vente");
	var destinataire = dSelect.options[dSelect.selectedIndex].value;
	var membre_vente = mvSelect.options[mvSelect.selectedIndex].value;

	var sendtext = '';
	if (modele != '' && modele != null) {
		sendtext += ("modele=" + modele);
	} else{
		alert("Il faut remplir le modele.");
		return;
	}

	if (quantite != '' && quantite != null) {
		sendtext += ("&quantite=" + quantite);
	}
	if (fournisseur != '' && fournisseur != null) {
		sendtext += ("&fournisseur=" + fournisseur);
	}
	if (destinataire != '' && destinataire != null) {
		sendtext += ("&destinataire=" + destinataire);
	}
	if (membre_vente != '' && membre_vente != null) {
		sendtext += ("&membre_vente=" + membre_vente);
	}
	sbcXmlHttp.send(sendtext);
}