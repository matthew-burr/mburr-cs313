-- This script produces sample data for use with the recipe box app
BEGIN;
-- To facilitate easy searching, set our search path
SET search_path TO recipe_box, public;

-- Reset all our sequences to 1
ALTER SEQUENCE ingredient_id_seq RESTART WITH 1;
ALTER SEQUENCE recipe_id_seq RESTART WITH 1;
ALTER SEQUENCE user_id_seq RESTART WITH 1;

-- Add referenced data first
INSERT INTO "user" (email, password, first_name, last_name) VALUES
('matt@fakeemail.com', 'blank', 'Matthew', 'Burr'),
('amy@fakeemail.com', 'blank', 'Amy', 'Burr');

INSERT INTO "recipe" (name, owner_user_id, servings, meal, instructions) VALUES
('Recipe 1', 1 /* Matt */, 4, 'breakfast', 'Yada yada yada'),
('Recipe 2', 1, 8, 'lunch', 'Yada yada yada'),
('Recipe 3', 2 /* Amy */, 2, 'dinner', 'Yum yum yum'),
('Recipe 4', 2, 10, 'dessert', 'Yum yum yum');

INSERT INTO "ingredient" (name) VALUES
('ingredient 1'),
('ingredient 2'),
('ingredient 3'),
('ingredient 4');

-- Now we proceed to populate M2M tables
INSERT INTO user_recipe (user_id, recipe_id) VALUES 
(2, 1); /* Amy can see one of Matt's recipes */

INSERT INTO recipe_ingredient (recipe_id, ingredient_id)
SELECT r."id", i."id"
  FROM recipe AS r
 CROSS JOIN ingredient AS i; /* We're just gonna dump all the possible recipe/ingredient combos */

END;
