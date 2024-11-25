CREATE DATABASE reclamation_db;

USE reclamation_db;

CREATE TABLE reclamations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    identifier VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    details TEXT,
    message TEXT NOT NULL,
    priority ENUM('enseignant', 'etudiant') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);