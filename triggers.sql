/*------------------------------------------------------Facture trigger------------------------------------------------------*/
CREATE OR REPLACE FUNCTION ip_facture_trigg_function()
	RETURNS trigger AS $ip_facture_trigg_function$
BEGIN
	IF TG_OP = 'INSERT' OR TG_OP = 'UPDATE' THEN
		IF TG_TABLE_NAME = 'facture_vente' THEN
			IF (EXISTS(SELECT 1 FROM facture_reprise WHERE num = NEW.num) OR
				EXISTS(SELECT 1 FROM facture_reparation WHERE num = NEW.num)) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que ce facture est déjà dans d''autres tables de facture.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		ELSIF TG_TABLE_NAME = 'facture_reprise' THEN
			IF (EXISTS(SELECT 1 FROM facture_vente WHERE num = NEW.num) OR
				EXISTS(SELECT 1 FROM facture_reparation WHERE num = NEW.num)) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que ce facture est déjà dans d''autres tables de facture.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		ELSIF TG_TABLE_NAME = 'facture_reparation' THEN
			IF (EXISTS(SELECT 1 FROM facture_reprise WHERE num = NEW.num) OR
				EXISTS(SELECT 1 FROM facture_vente WHERE num = NEW.num)) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que ce facture est déjà dans d''autres tables de facture.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		END IF;
	END IF;

	RETURN null;
END;
$ip_facture_trigg_function$
	LANGUAGE plpgsql;

CREATE TRIGGER ip_facture_trigger
BEFORE INSERT OR UPDATE
ON facture_vente
FOR EACH ROW
EXECUTE PROCEDURE ip_facture_trigg_function();

CREATE TRIGGER ip_facture_trigger
BEFORE INSERT OR UPDATE
ON facture_reprise
FOR EACH ROW
EXECUTE PROCEDURE ip_facture_trigg_function();

CREATE TRIGGER ip_facture_trigger
BEFORE INSERT OR UPDATE
ON facture_reparation
FOR EACH ROW
EXECUTE PROCEDURE ip_facture_trigg_function();

/*-------------------------------------------Client trigger------------------------------------------------------------*/
CREATE OR REPLACE FUNCTION ip_client_trigg_function()
	RETURNS trigger AS $ip_client_trigg_function$
BEGIN
	IF (TG_OP = 'INSERT' OR TG_OP = 'UPDATE') THEN
		IF TG_TABLE_NAME = 'particulier' THEN
			IF EXISTS(SELECT 1 FROM professionnel WHERE num_client = NEW.num_client) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que ce client est déjà dans la table ''professionnel''.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		ELSIF TG_TABLE_NAME = 'professionnel' THEN
			IF EXISTS(SELECT 1 FROM particulier WHERE num_client = NEW.num_client) THEN
				RAISE EXCEPTION E'L''insertion dans ''%'' a échoué, parce que ce client est déjà dans la table ''particulier''.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		END IF;
	END IF;

	RETURN null;
END;
$ip_client_trigg_function$
	LANGUAGE plpgsql;

CREATE TRIGGER ip_client_trigger
BEFORE INSERT OR UPDATE
ON particulier
FOR EACH ROW
EXECUTE PROCEDURE ip_client_trigg_function();

CREATE TRIGGER ip_client_trigger
BEFORE INSERT OR UPDATE
ON professionnel
FOR EACH ROW
EXECUTE PROCEDURE ip_client_trigg_function();

/*---------------------------------------------------Produit trigger----------------------------------------------------------*/
CREATE OR REPLACE FUNCTION ip_produit_trigg_function()
	RETURNS trigger AS $ip_produit_trigg_function$
BEGIN
	IF TG_OP = 'INSERT' OR TG_OP = 'UPDATE' THEN
		IF TG_TABLE_NAME = 'appareil' THEN
			IF (EXISTS(SELECT 1 FROM piece_detachees WHERE num = NEW.num) OR
				EXISTS(SELECT 1 FROM accessoire WHERE num = NEW.num)) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que ce produit est déjà un produit d''autre genre.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		ELSIF TG_TABLE_NAME = 'piece_detachees' THEN
			IF (EXISTS(SELECT 1 FROM appareil WHERE num = NEW.num) OR
				EXISTS(SELECT 1 FROM accessoire WHERE num = NEW.num)) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que ce produit est déjà un produit d''autre genre.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		ELSIF TG_TABLE_NAME = 'accessoire' THEN
			IF (EXISTS(SELECT 1 FROM piece_detachees WHERE num = NEW.num) OR
				EXISTS(SELECT 1 FROM appareil WHERE num = NEW.num)) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que ce produit est déjà un produit d''autre genre.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		END IF;
	END IF;

	RETURN null;
END;
$ip_produit_trigg_function$
	LANGUAGE plpgsql;

CREATE TRIGGER ip_produit_trigger
BEFORE INSERT OR UPDATE
ON appareil
FOR EACH ROW
EXECUTE PROCEDURE ip_produit_trigg_function();

CREATE TRIGGER ip_produit_trigger
BEFORE INSERT OR UPDATE
ON accessoire
FOR EACH ROW
EXECUTE PROCEDURE ip_produit_trigg_function();

CREATE TRIGGER ip_produit_trigger
BEFORE INSERT OR UPDATE
ON piece_detachees
FOR EACH ROW
EXECUTE PROCEDURE ip_produit_trigg_function();

/*------------------------------------------------employé trigger----------------------------------------------------------------*/
CREATE OR REPLACE FUNCTION ip_employe_trigg_function()
	RETURNS trigger AS $ip_employe_trigg_function$
BEGIN
	IF TG_OP = 'INSERT' OR TG_OP = 'UPDATE' THEN
		IF TG_TABLE_NAME = 'membre_achat' THEN
			IF (EXISTS(SELECT 1 FROM membre_sav WHERE id = NEW.id) OR
				EXISTS(SELECT 1 FROM membre_vente WHERE id = NEW.id)) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que ce employé est déjà dans un autre département.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		ELSIF TG_TABLE_NAME = 'membre_sav' THEN
			IF (EXISTS(SELECT 1 FROM membre_achat WHERE id = NEW.id) OR
				EXISTS(SELECT 1 FROM membre_vente WHERE id = NEW.id)) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que ce employé est déjà dans un autre département.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		ELSIF TG_TABLE_NAME = 'membre_vente' THEN
			IF (EXISTS(SELECT 1 FROM membre_sav WHERE id = NEW.id) OR
				EXISTS(SELECT 1 FROM membre_achat WHERE id = NEW.id)) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que ce employé est déjà dans un autre département.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		END IF;
	END IF;

	RETURN null;
END;
$ip_employe_trigg_function$
	LANGUAGE plpgsql;

CREATE TRIGGER ip_employe_trigger
BEFORE INSERT OR UPDATE
ON membre_achat
FOR EACH ROW
EXECUTE PROCEDURE ip_employe_trigg_function();

CREATE TRIGGER ip_employe_trigger
BEFORE INSERT OR UPDATE
ON membre_vente
FOR EACH ROW
EXECUTE PROCEDURE ip_employe_trigg_function();

CREATE TRIGGER ip_employe_trigger
BEFORE INSERT OR UPDATE
ON membre_sav
FOR EACH ROW
EXECUTE PROCEDURE ip_employe_trigg_function();

/*---------------------------------------------opération trigger---------------------------------------------------*/
CREATE OR REPLACE FUNCTION ip_operation_trigg_function()
	RETURNS trigger AS $ip_operation_trigg_function$
BEGIN
	IF TG_OP = 'INSERT' OR TG_OP = 'UPDATE' THEN
		IF TG_TABLE_NAME = 'reparation' THEN
			IF (EXISTS(SELECT 1 FROM reprise WHERE num_op = NEW.num_op) OR
				EXISTS(SELECT 1 FROM refus WHERE num_op = NEW.num_op)) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que cette opération est déjà est une opération d''autre sorte.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		ELSIF TG_TABLE_NAME = 'reprise' THEN
			IF (EXISTS(SELECT 1 FROM reparation WHERE num_op = NEW.num_op) OR
				EXISTS(SELECT 1 FROM refus WHERE num_op = NEW.num_op)) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que cette opération est déjà est une opération d''autre sorte.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		ELSIF TG_TABLE_NAME = 'refus' THEN
			IF (EXISTS(SELECT 1 FROM reprise WHERE num_op = NEW.num_op) OR
				EXISTS(SELECT 1 FROM reparation WHERE num_op = NEW.num_op)) THEN
				RAISE EXCEPTION 'L''insertion dans ''%'' a échoué, parce que cette opération est déjà est une opération d''autre sorte.', TG_TABLE_NAME;
				RETURN null;
			END IF;

			RETURN NEW;
		END IF;
	END IF;

	RETURN null;
END;
$ip_operation_trigg_function$
	LANGUAGE plpgsql;

CREATE TRIGGER ip_operation_trigger
BEFORE INSERT OR UPDATE
ON reparation
FOR EACH ROW
EXECUTE PROCEDURE ip_operation_trigg_function();

CREATE TRIGGER ip_operation_trigger
BEFORE INSERT OR UPDATE
ON reprise
FOR EACH ROW
EXECUTE PROCEDURE ip_operation_trigg_function();

CREATE TRIGGER ip_operation_trigger
BEFORE INSERT OR UPDATE
ON refus
FOR EACH ROW
EXECUTE PROCEDURE ip_operation_trigg_function();