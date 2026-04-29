CREATE DATABASE Notes;

USE Notes;

CREATE TABLE Eleves (
    id INT PRIMARY KEY AUTO_INCREMENT,
    Nom VARCHAR(100),
    Prenom VARCHAR(100),
);

CREATE TABLE Matiere(
    id_matiere INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    credit INT
);
CREATE TABLE Note (
    id_note INT PRIMARY KEY AUTO_INCREMENT,
    valeur DECIMAL(10,2),
    id_eleve INT,
    id_matiere INT
);

CREATE TABLE Semestre (
    id_semestre INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(10)
);
CREATE TABLE SemestreFille (
    id_fille INT PRIMARY KEY AUTO_INCREMENT,
    id_mere INT,
    id_matiere INT
);