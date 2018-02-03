-- This adds an update trigger to the base_table so that the modified column is set
-- when a row is updated.
-- Thanks to:
-- http://www.the-art-of-web.com/sql/trigger-update-timestamp/
-- https://www.revsys.com/blog/2006/aug/04/automatically-updating-a-timestamp-column-in-postgresql/
-- for examples

BEGIN;

  CREATE OR REPLACE FUNCTION update_modified()
  RETURNS TRIGGER AS $$
  BEGIN
    NEW.modified = now();
    RETURN NEW;
  END;
  $$ language 'plpgsql';

  CREATE TRIGGER row_updated 
    BEFORE UPDATE ON recipe_box."user"
    FOR EACH ROW
    EXECUTE PROCEDURE update_modified();

  CREATE TRIGGER row_updated 
    BEFORE UPDATE ON recipe_box.recipe
    FOR EACH ROW
    EXECUTE PROCEDURE update_modified();

  CREATE TRIGGER row_updated 
    BEFORE UPDATE ON recipe_box.ingredient
    FOR EACH ROW
    EXECUTE PROCEDURE update_modified();

  CREATE TRIGGER row_updated 
    BEFORE UPDATE ON recipe_box.recipe_ingredient
    FOR EACH ROW
    EXECUTE PROCEDURE update_modified();

  CREATE TRIGGER row_updated 
    BEFORE UPDATE ON recipe_box.user_recipe
    FOR EACH ROW
    EXECUTE PROCEDURE update_modified();

END;
