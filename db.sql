create database stageDB


CREATE TABLE Informations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Full_Name VARCHAR(55) NOT NULL,
    Email VARCHAR(250) NOT NULL UNIQUE, 
    Password VARCHAR(250) NOT NULL, 
    Terms_And_Conditions TINYINT(1) NOT NULL DEFAULT 0
);
