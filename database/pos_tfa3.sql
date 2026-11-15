CREATE DATABASE IF NOT EXISTS pos_tfa3 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pos_tfa3;
CREATE TABLE IF NOT EXISTS customers (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(150) NOT NULL,
 email VARCHAR(254) NOT NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS users (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(60) NOT NULL UNIQUE,
 full_name VARCHAR(150) NOT NULL,
 avatar VARCHAR(255) NULL
) ENGINE=InnoDB;
INSERT INTO customers (full_name,email) VALUES ('Sample Customer','customer@example.com');
INSERT INTO users (username,full_name,avatar) VALUES ('sampleuser','Sample User',NULL);
