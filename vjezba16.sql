-- vjezba16.sql — Registracijska forma: baza i tablica
-- Autor: Marija Kučinić

CREATE DATABASE IF NOT EXISTS vjezba16 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vjezba16;

CREATE TABLE IF NOT EXISTS users (
  id          INT           NOT NULL AUTO_INCREMENT,
  name        VARCHAR(100)  NOT NULL,
  lastname    VARCHAR(100)  NOT NULL,
  email       VARCHAR(100)  NOT NULL UNIQUE,
  username    VARCHAR(10)   NOT NULL UNIQUE,
  password    VARCHAR(255)  NOT NULL,
  country     VARCHAR(100)  NULL,
  created_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
