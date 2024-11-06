-- create-database.sql

CREATE DATABASE IF NOT EXISTS books;

USE books;

-- Ejemplo de tabla, cámbiala según tus necesidades
CREATE TABLE IF NOT EXISTS books (
    title VARCHAR(250) NOT NULL,
    author VARCHAR(250) NOT NULL,
    isbn BIGINT(13) NOT NULL PRIMARY KEY,
    pubYear INT(4) NOT NULL
);

-- Agregar más tablas si es necesario
