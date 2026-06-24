-- vjezba17.sql — Relacija users i countries
-- Autor: Marija Kučinić

CREATE DATABASE IF NOT EXISTS vjezba17 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vjezba17;

CREATE TABLE IF NOT EXISTS countries (
  id      INT          NOT NULL AUTO_INCREMENT,
  name    VARCHAR(100) NOT NULL UNIQUE,
  code    CHAR(2)      NOT NULL UNIQUE,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users (
  id          INT           NOT NULL AUTO_INCREMENT,
  name        VARCHAR(100)  NOT NULL,
  lastname    VARCHAR(100)  NOT NULL,
  email       VARCHAR(100)  NOT NULL UNIQUE,
  username    VARCHAR(10)   NOT NULL UNIQUE,
  password    VARCHAR(255)  NOT NULL,
  country_id  INT           NULL,
  description TEXT          NULL,
  created_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT fk_users_country
    FOREIGN KEY (country_id) REFERENCES countries(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inicijalni podaci: države
INSERT INTO countries (name, code) VALUES
  ('Argentina',   'AR'),
  ('Australia',   'AU'),
  ('Austria',     'AT'),
  ('Bosnia and Herzegovina', 'BA'),
  ('Brazil',      'BR'),
  ('Canada',      'CA'),
  ('China',       'CN'),
  ('Croatia',     'HR'),
  ('France',      'FR'),
  ('Germany',     'DE'),
  ('Italy',       'IT'),
  ('Japan',       'JP'),
  ('Netherlands', 'NL'),
  ('Poland',      'PL'),
  ('Serbia',      'RS'),
  ('Slovenia',    'SI'),
  ('Spain',       'ES'),
  ('Sweden',      'SE'),
  ('United Kingdom', 'GB'),
  ('United States',  'US');

-- Inicijalni podaci: korisnici
INSERT INTO users (name, lastname, email, username, password, country_id) VALUES
  ('Bob',     'Johnson', 'bob.johnson@email.com',     'bobjohn',   '$2y$10$examplehash1', 1),
  ('Charlie', 'Brown',   'charlie.brown@email.com',   'cbrown',    '$2y$10$examplehash2', 1),
  ('Frank',   'Miller',  'frank.miller@email.com',    'fmiller',   '$2y$10$examplehash3', 1),
  ('Grace',   'Moore',   'grace.moore@email.com',     'gmoore',    '$2y$10$examplehash4', 1),
  ('Winnie',  'Young',   'winnie.young@email.com',    'wyoung',    '$2y$10$examplehash5', 2);
