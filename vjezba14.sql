-- vjezba14.sql — DDL CREATE: tablica users
-- Autor: Marija Kučinić

CREATE DATABASE IF NOT EXISTS vjezba14 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vjezba14;

CREATE TABLE IF NOT EXISTS users (
  id          INT           NOT NULL AUTO_INCREMENT,
  name        VARCHAR(100)  NULL,
  lastname    VARCHAR(100)  NULL,
  username    VARCHAR(100)  NOT NULL UNIQUE,
  password    VARCHAR(255)  NOT NULL,
  country     VARCHAR(100)  NULL,
  description TEXT          NULL,
  created_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
