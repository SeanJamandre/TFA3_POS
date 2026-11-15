-- Use on the existing TFA2 database ONLY if users.avatar does not already exist.
ALTER TABLE users ADD COLUMN avatar VARCHAR(255) NULL;
-- Ensure users.username has a UNIQUE index; add one only if absent:
-- ALTER TABLE users ADD UNIQUE KEY users_username_unique (username);
