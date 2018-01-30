CREATE SCHEMA IF NOT EXISTS recipe_box;

CREATE TYPE meal_type AS ENUM ('breakfast', 'lunch', 'dinner', 'appetizer', 'snack', 'dessert');

CREATE TABLE IF NOT EXISTS recipe_box.base_table (
  created TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT (current_timestamp),
  modified TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT (current_timestamp)
);

CREATE INDEX IF NOT EXISTS search_by_created ON recipe_box.base_table (created);
CREATE INDEX IF NOT EXISTS search_by_modified ON recipe_box.base_table (modified);

CREATE TABLE IF NOT EXISTS recipe_box.user (
  id SERIAL NOT NULL CONSTRAINT pk_recipe_box_user PRIMARY KEY,
  email TEXT NOT NULL CONSTRAINT recipe_box_user_email_is_unique UNIQUE,
  password TEXT NOT NULL,
  first_name TEXT NOT NULL,
  last_name TEXT NOT NULL
)
INHERITS (recipe_box.base_table);

CREATE TABLE IF NOT EXISTS recipe_box.recipe (
  id SERIAL NOT NULL CONSTRAINT pk_recipe_box_recipe PRIMARY KEY,
  name TEXT NOT NULL DEFAULT ('My Recipe'),
  owner_user_id INT NOT NULL
    CONSTRAINT recipe_box_owner_exists REFERENCES recipe_box.user (id),
  servings INT NOT NULL DEFAULT (1)
    CONSTRAINT servings_are_positive CHECK (servings >= 1),
  meal meal_type NOT NULL,
  instructions TEXT NOT NULL DEFAULT('Instruction are missing'),
  CONSTRAINT recipe_box_recipe_unique_name UNIQUE (owner_user_id, name)
)
INHERITS (recipe_box.base_table);

CREATE TABLE IF NOT EXISTS recipe_box.ingredient (
  id SERIAL NOT NULL CONSTRAINT pk_recipe_box_ingredient PRIMARY KEY,
  name TEXT NOT NULL DEFAULT ('Some Ingredient') CONSTRAINT recipe_box_ingredient_is_unique UNIQUE
)
INHERITS (recipe_box.base_table);

CREATE TABLE IF NOT EXISTS recipe_box.user_recipe (
  user_id INT CONSTRAINT recipe_box_user_recipe_user_exists REFERENCES recipe_box.user (id),
  recipe_id INT CONSTRAINT recipe_box_user_recipe_recipe_exists REFERENCES recipe_box.recipe (id),
  CONSTRAINT pk_recipe_box_user_recipe PRIMARY KEY (user_id, recipe_id)
)
INHERITS (recipe_box.base_table);

CREATE TABLE IF NOT EXISTS recipe_box.recipe_ingredient (
  recipe_id INT CONSTRAINT recipe_box_recipe_ingredient_ingredient_exists REFERENCES recipe_box.ingredient (id),
  ingredient_id INT CONSTRAINT recipe_box_recipe_ingredient_recipe_exists REFERENCES recipe_box.recipe (id),
  CONSTRAINT pk_recipe_box_recipe_ingredient PRIMARY KEY (recipe_id, ingredient_id)
)
INHERITS (recipe_box.base_table);
