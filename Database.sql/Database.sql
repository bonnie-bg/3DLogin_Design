-- --------DROP DATABASE E_commercedb if exist---------------------------------------------------------
-- DROP DATABASE E_commercedb if EXISTS;
-- --------CREATE DATABASE E_commercedb ---------------------------------------------------------------
CREATE DATABASE E_commercedb;
-- --------Use DATABASE E_commercedb ------------------------------------------------------------------
USE E_commercedb;
-- -------------CREATE TABLE E_commercedb.register-----------------------------------------------------
CREATE TABLE E_commercedb.`register`(
	fullname VARCHAR(255) NOT NULL ,
	email VARCHAR(255) NOT NULL ,
	contact INT(12) NOT NULL ,
	location VARCHAR(255) NOT NULL ,
	city VARCHAR(255) NOT NULL ,
	country VARCHAR(255) NOT NULL ,
	password VARCHAR(255) NOT NULL ,
	date  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
	PRIMARY KEY (`email`)
) ENGINE = InnoDB;

