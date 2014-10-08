BEGIN TRANSACTION
/*package 1*/

CREATE TABLE Client(
	num_client serial PRIMARY KEY,
	nom VARCHAR(25)
	/*CHECK*/	
);

CREATE TABLE Professionnel(
	num_client INTEGER PRIMARY KEY REFERENCES Client(num_client),
	nom_entreprise VARCHAR(25)
);

CREATE TABLE Particulier(
	num_client INTEGER PRIMARY KEY REFERENCES Client(num_client)
);

CREATE VIEW vProfessionnel AS
SELECT p.num_client, p.nom_entreprise
FROM Client c, Professionnel p
WHERE c.num_client = p.num_client;

CREATE VIEW vParticulier AS
SELECT p.num_client
FROM CLient c, Particulier p
WHERE c.num_client = p.num_client;

/*package 2*/

CREATE TABLE Employe(
	id serial PRIMARY KEY,
	nom VARCHAR(25),
	prenom VARCHAR(25)
	/*CHECK*/
);

CREATE TABLE Membre_SAV(
	id INTEGER PRIMARY KEY REFERENCES Employe(id)
);

CREATE VIEW vMembre_SAV AS
	SELECT e.id, e.nom, e.prenom
	FROM Employe e, Membre_SAV m
	WHERE e.id = m.id;

CREATE TABLE Membre_Achat(
	id INTEGER PRIMARY KEY REFERENCES Employe(id)
);

CREATE VIEW vMembre_achat AS
	SELECT e.id, e.nom, e.prenom
	FROM Membre_Achat ma, Employe e
	WHERE ma.id = e.id;

CREATE TABLE Membre_Vente(
	id INTEGER PRIMARY KEY REFERENCES Employe(id)
);

CREATE VIEW vMembre_vente AS
	SELECT e.id, e.nom, e.prenom
	FROM Membre_Vente mv, Employe e
	WHERE mv.id = e.id;

/*package 3*/

CREATE TABLE Categorie (
	nom VARCHAR(25) PRIMARY KEY
	);

CREATE TABLE Sous_categorie (
	nom VARCHAR(25) UNIQUE NOT NULL,
	categorie VARCHAR(25) REFERENCES Categorie(nom),
	PRIMARY KEY(nom,categorie)
	);
CREATE TABLE Marque (
	nom VARCHAR(25) PRIMARY KEY
);
CREATE TABLE Modele (
	reference serial PRIMARY KEY,
	sous_categorie VARCHAR(25) NOT NULL REFERENCES Sous_categorie(nom),
	categorie VARCHAR(25) NOT NULL REFERENCES Categorie(nom),
	prix_reference INTEGER,
	consommation INTEGER,
	garantie INTEGER,
	extension BOOLEAN,
	marque VARCHAR(25) NOT NULL REFERENCES Marque(nom)
);

CREATE TABLE Fournisseur(
	num_fournisseur serial PRIMARY KEY,
	nom_fournisseur VARCHAR(25)
);

CREATE TABLE Produit (
	num_serie serial PRIMARY KEY,
	modele INTEGER REFERENCES Modele(reference),
	prix_affiche INTEGER,
	num_fournisseur INTEGER REFERENCES Fournisseur(num_fournisseur),
	client INTEGER REFERENCES Client(num_client)
);

CREATE TABLE Appareil (
	num INTEGER PRIMARY KEY,
	FOREIGN KEY(num) REFERENCES Produit(num_serie)
);

CREATE TABLE ticket_prise_en_charge (
	num_ticket serial PRIMARY KEY,
	date_prise_en_charge DATE,
	membre INTEGER NOT NULL REFERENCES Membre_SAV(id),
	appareil INTEGER NOT NULL REFERENCES Appareil(num)
);

CREATE TABLE Operation (
	num_op serial PRIMARY KEY,
	ticket INTEGER UNIQUE NOT NULL REFERENCES ticket_prise_en_charge(num_ticket),
	membre INTEGER NOT NULL REFERENCES Membre_SAV(id)
);

CREATE TABLE Reprise(
	num_op serial PRIMARY KEY,
	prix_reprise INTEGER,
	FOREIGN KEY (num_op) REFERENCES Operation(num_op)
);

CREATE TABLE Reparation (
	num_op serial PRIMARY KEY,
	duree_reparation INTEGER,
	FOREIGN KEY (num_op) REFERENCES Operation(num_op)
);

CREATE TABLE Refus (
	num_op serial PRIMARY KEY,
	FOREIGN KEY (num_op) REFERENCES Operation(num_op)
);


CREATE TABLE Bon_commande(
	num_commande serial PRIMARY KEY,
	ref_produit INTEGER,
	quantite INTEGER,
	destinataire INTEGER NOT NULL REFERENCES Membre_Achat(id), 
	membre_vente INTEGER NOT NULL REFERENCES Membre_Vente(id),
	modele INTEGER NOT NULL REFERENCES Modele(reference),
	fournisseur INTEGER REFERENCES Fournisseur(num_fournisseur),
	prixUnitaireAchat DECIMAL,
	commandepassee BOOLEAN
);

CREATE TABLE Piece_detachees (
	num INTEGER PRIMARY KEY,
	num_op INTEGER UNIQUE REFERENCES Reparation(num_op),
	FOREIGN KEY(num) REFERENCES Produit(num_serie)	
);
	
CREATE TABLE Accessoire (
	num INTEGER PRIMARY KEY,
	FOREIGN KEY(num) REFERENCES Produit(num_serie)
);

CREATE TABLE Compatible (
	ref1 INTEGER REFERENCES Modele(reference),
	ref2 INTEGER REFERENCES Modele(reference),
	PRIMARY KEY(ref1,ref2)
);

CREATE TABLE Propose (
	modele INTEGER REFERENCES Modele(reference),
	fournisseur INTEGER REFERENCES Fournisseur(num_fournisseur),
	PRIMARY KEY(modele,fournisseur)
);

CREATE TABLE Facture(
    num_facture serial PRIMARY KEY,
    prix INTEGER,
    date_facture DATE,
    client INTEGER NOT NULL REFERENCES Client(num_client),
    membre_vente INTEGER REFERENCES Membre_vente(id)
);

CREATE TABLE Facture_reprise(
    num INTEGER PRIMARY KEY REFERENCES Facture(num_facture),
    num_op INTEGER NOT NULL UNIQUE REFERENCES Reprise(num_op)
);

CREATE TABLE Facture_vente(
    num INTEGER PRIMARY KEY REFERENCES Facture(num_facture)
);

CREATE TABLE Facture_reparation(
    num INTEGER PRIMARY KEY REFERENCES Facture(num_facture),
    num_op INTEGER NOT NULL UNIQUE REFERENCES Reparation(num_op)
);

CREATE TABLE Facturation(
    facture INTEGER REFERENCES Facture(num_facture),
    produit INTEGER REFERENCES Produit(num_serie),
    remise INTEGER,
    specialiste BOOLEAN,
    extension BOOLEAN,
    PRIMARY KEY(facture, produit)
);

COMMIT TRANSACTION;