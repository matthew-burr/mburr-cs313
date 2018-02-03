CREATE ROLE recipe_rw WITH LOGIN PASSWORD 'wouldntulike2know?';
GRANT USAGE ON SCHEMA recipe_box TO recipe_rw;
GRANT ALL ON ALL TABLES IN SCHEMA recipe_box TO recipe_rw;
