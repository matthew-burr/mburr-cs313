-- This script clears out all data from the database
-- ** USE WITH CAUTION ** --
SELECT 'Due to the risk involved, you must manually edit the script to comment the following line (add "--") to run this.';
--/*
BEGIN;

DELETE FROM recipe_box.recipe_ingredient;
DELETE FROM recipe_box.user_recipe;
DELETE FROM recipe_box.ingredient;
DELETE FROM recipe_box.recipe;
DELETE FROM recipe_box."user";

ALTER SEQUENCE recipe_box.ingredient_id_seq RESTART WITH 1;
ALTER SEQUENCE recipe_box.recipe_id_seq RESTART WITH 1;
ALTER SEQUENCE recipe_box.user_id_seq RESTART WITH 1;

END;
--*/
