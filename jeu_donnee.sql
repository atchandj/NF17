BEGIN TRANSACTION

--Employe--

INSERT INTO Employe (nom,prenom) VALUES ('Tchandjou','Adrien');
INSERT INTO Employe (nom,prenom) VALUES ('Xia','Yiming');
INSERT INTO Employe (nom,prenom) VALUES ('Pannequin','Emmanuel');
INSERT INTO Employe (nom,prenom) VALUES ('Hao','Ren');
INSERT INTO Employe (nom,prenom) VALUES ('Barthelemy','Olympio');
INSERT INTO Employe (nom,prenom) VALUES ('Safraoui','Yannick');
INSERT INTO Employe (nom,prenom) VALUES ('Fodju','Yannick');
INSERT INTO Employe (nom,prenom) VALUES ('Kemajou','Danniel');
INSERT INTO Employe (nom,prenom) VALUES ('Fonkoua','Dianne');


--SAV--

INSERT INTO Membre_SAV (id) VALUES (1);
INSERT INTO Membre_SAV (id) VALUES (4);
INSERT INTO Membre_SAV (id) VALUES (7);

--Membre_Vente--

INSERT INTO Membre_Vente (id) VALUES (2);
INSERT INTO Membre_Vente (id) VALUES (5);
INSERT INTO Membre_Vente (id) VALUES (8);

--Membre_Achat--

INSERT INTO Membre_Achat (id) VALUES (3);
INSERT INTO Membre_Achat (id) VALUES (6);
INSERT INTO Membre_Achat (id) VALUES (9);

--Client--

INSERT INTO Client (nom) VALUES ('Brunet');
INSERT INTO Client (nom) VALUES ('Benjelloun');
INSERT INTO Client (nom) VALUES ('Fabo');
INSERT INTO Client (nom) VALUES ('Garcia');
INSERT INTO Client (nom) VALUES ('Haddad');
INSERT INTO Client (nom) VALUES ('Karoubi');
INSERT INTO Client (nom) VALUES ('Lalouni');
INSERT INTO Client (nom) VALUES ('Luu');
INSERT INTO Client (nom) VALUES ('Le CALVE');
INSERT INTO Client (nom) VALUES ('Perrault');

--Particulier--

INSERT INTO Particulier (num_client) VALUES (1);
INSERT INTO Particulier (num_client) VALUES (3);
INSERT INTO Particulier (num_client) VALUES (5);
INSERT INTO Particulier (num_client) VALUES (7);
INSERT INTO Particulier (num_client) VALUES (9);

--Professionnel--

INSERT INTO Professionnel (num_client,nom_entreprise) VALUES (2,'Digia');
INSERT INTO Professionnel (num_client,nom_entreprise) VALUES (4,'Cilova');
INSERT INTO Professionnel (num_client,nom_entreprise) VALUES (6,'Conforama');
INSERT INTO Professionnel (num_client,nom_entreprise) VALUES (8,'FNAC');
INSERT INTO Professionnel (num_client,nom_entreprise) VALUES (10,'Inergy');

--Fournisseur--
INSERT INTO Fournisseur (nom_fournisseur) VALUES ('Darty');
INSERT INTO Fournisseur (nom_fournisseur) VALUES ('CDiscout');
INSERT INTO Fournisseur (nom_fournisseur) VALUES ('PixMania-Pro');
INSERT INTO Fournisseur (nom_fournisseur) VALUES ('Fnac');
INSERT INTO Fournisseur (nom_fournisseur) VALUES ('Amazon');
INSERT INTO Fournisseur (nom_fournisseur) VALUES ('Carrefour');

--Categorie--
INSERT INTO Categorie(nom) VALUES ('Téléviseur');
INSERT INTO Categorie(nom) VALUES ('Ordinateur');
INSERT INTO Categorie(nom) VALUES ('Vis');
INSERT INTO Categorie(nom) VALUES ('Oreillette');		

--Sous_categorie--
INSERT INTO Sous_categorie (nom,categorie) VALUES ('Ordinateur portable','Ordinateur');
INSERT INTO Sous_categorie (nom,categorie) VALUES ('Ordinateur de bureau','Ordinateur');
INSERT INTO Sous_categorie (nom,categorie) VALUES ('Ordinateur Portable','Ordinateur');
INSERT INTO Sous_categorie (nom,categorie) VALUES ('Tablette PC','Ordinateur');
INSERT INTO Sous_categorie (nom,categorie) VALUES ('Plasma','Téléviseur');
INSERT INTO Sous_categorie (nom,categorie) VALUES ('LCD','Téléviseur');
INSERT INTO Sous_categorie (nom,categorie) VALUES ('LED','Téléviseur');
INSERT INTO Sous_categorie (nom,categorie) VALUES ('Vis de pression','Vis');
INSERT INTO Sous_categorie (nom,categorie) VALUES ('Oreillette bluetooth','Oreillette');

--Marque--
INSERT INTO Marque (nom) VALUES('Toshiba');
INSERT INTO Marque (nom) VALUES('Samsung');
INSERT INTO Marque (nom) VALUES('Nokia');
INSERT INTO Marque (nom) VALUES('Apple');
INSERT INTO Marque (nom) VALUES('Panasonic');
INSERT INTO Marque (nom) VALUES('Packard');
INSERT INTO Marque (nom) VALUES('Philips');


--Modele--
INSERT INTO Modele (Sous_categorie,categorie,prix_reference,consommation,garantie,extension,marque)  VALUES('Tablette PC','Ordinateur',510,20,1,TRUE,'Packard');
INSERT INTO Modele (Sous_categorie,categorie,prix_reference,consommation,garantie,extension,marque)  VALUES('Ordinateur Portable','Ordinateur',900,35,2,FALSE,'Toshiba');
INSERT INTO Modele (Sous_categorie,categorie,prix_reference,consommation,garantie,extension,marque)  VALUES('Ordinateur de bureau','Ordinateur',1151,20,3,TRUE,'Apple');
INSERT INTO Modele (Sous_categorie,categorie,prix_reference,consommation,garantie,extension,marque)  VALUES('Plasma','Téléviseur',2450,255,3,FALSE,'Panasonic');
INSERT INTO Modele (Sous_categorie,categorie,prix_reference,consommation,garantie,extension,marque)  VALUES('LCD','Téléviseur',587,71,2,TRUE,'Samsung');
INSERT INTO Modele (Sous_categorie,categorie,prix_reference,consommation,garantie,extension,marque)  VALUES('LED','Téléviseur',759,71,2,FALSE,'Samsung');
INSERT INTO Modele (Sous_categorie,categorie,prix_reference,consommation,garantie,extension,marque)  VALUES('Vis de pression','Vis',1,0,0,FALSE,'Philips');
INSERT INTO Modele (Sous_categorie,categorie,prix_reference,consommation,garantie,extension,marque)  VALUES('Vis de pression','Vis',2,0,0,FALSE,'Philips');
INSERT INTO Modele (Sous_categorie,categorie,prix_reference,consommation,garantie,extension,marque)  VALUES('Oreillette bluetooth','Oreillette',20,10,0,FALSE,'Nokia');

--Produit--
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (1,525,2,2);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (3,1151,1,1);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (3,1151,2,5);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (4,2450,1,6);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (4,2450,4,8);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (5,588,5,9);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (5,588,6,8);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (6,765,1,3);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (6,765,4,4);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (1,525,3,6);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (2,910,6,9);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (2,910,5,2);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (7,1,1,3);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (8,2,4,7);
INSERT INTO Produit(modele,prix_affiche,num_fournisseur,client) VALUES (9,20,2,7);

--Appareil--
INSERT INTO Appareil (num) VALUES(1);
INSERT INTO Appareil (num) VALUES(2);
INSERT INTO Appareil (num) VALUES(3);
INSERT INTO Appareil (num) VALUES(4);
INSERT INTO Appareil (num) VALUES(5);
INSERT INTO Appareil (num) VALUES(6);
INSERT INTO Appareil (num) VALUES(7);
INSERT INTO Appareil (num) VALUES(8);
INSERT INTO Appareil (num) VALUES(9);
INSERT INTO Appareil (num) VALUES(10);
INSERT INTO Appareil (num) VALUES(11);

--Pièces détachées--
INSERT INTO Piece_detachees (num) VALUES (13);
INSERT INTO Piece_detachees (num) VALUES (12);

--Accessoire--
INSERT INTO Accessoire (num) VALUES (14);

--Compatible--
INSERT INTO Compatible (ref1, ref2) VALUES (7,2);
INSERT INTO Compatible (ref1, ref2) VALUES (8,3);
INSERT INTO Compatible (ref1, ref2) VALUES (7,4);
INSERT INTO Compatible (ref1, ref2) VALUES (8,1);

--Ticket prise en charge--

COMMIT TRANSACTION;

