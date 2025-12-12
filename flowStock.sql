DROP DATABASE IF EXISTS flowstock;
CREATE DATABASE flowstock CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE flowstock;

CREATE TABLE users (
  id_user SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  prenom VARCHAR(50) NOT NULL,
  nom VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL,
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (prenom, nom, email, username, password, role, date_creation)
VALUES 
('prenom1', 'nom1', 'admin@gmail.com', 'admin', '1234', 'admin', '2025-11-25'),
('prenom2', 'nom2', 'secretariat@gmail.com', 'secret', '1234', 'secretariat', '2025-11-25');

CREATE TABLE produit (
  id_produit SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nom_produit VARCHAR(100) NOT NULL,
  description_produit TEXT NOT NULL,  
  prix_produit DECIMAL(10,2) DEFAULT 0.00,
  mise_en_vente DATE,                 
  stock_produit SMALLINT DEFAULT 0,  
  proprietaire VARCHAR(100)          
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO produit (nom_produit, description_produit, prix_produit, mise_en_vente, stock_produit, proprietaire) VALUES
('dsqd', 'sqdsqd', 58.00, '2024-08-17', 10, 'gg'),
('NomProd1', 'description1', 140.25, '2022-05-19', 5, 'Test4dd Prénom4'),
('NomProd2', 'description2', 160.25, '2022-05-19', 12, 'Test9 Prénom9'),
('NomProd3', 'description3', 180.25, '2022-05-18', 10, 'Testtrize Prénomtestrelze'),
('NomProd4', 'description4', 45.25, '2022-05-18', 8, 'Test465 PrénomTest465'),
('NomProd5', 'description5', 66.50, '2022-05-18', 3, 'Test465 PrénomTest465'),
('Produit6', 'Desc6', 150.25, '2022-08-21', 10, 'gg'),
('Produit7', 'Desc7', 245.50, '2024-09-23', 5, 'Lampion Robert'),
('Produit8', 'Desc8', 45.25, '2024-08-05', 0, 'test60 Prénomtest60');