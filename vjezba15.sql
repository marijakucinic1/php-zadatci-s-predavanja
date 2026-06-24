-- vjezba15.sql — DDL ALTER: nadogradnja tablice users
-- Autor: Marija Kučinić

USE vjezba14;

-- Dodaj stupac email (NOT NULL)
ALTER TABLE users
  ADD COLUMN email VARCHAR(100) NOT NULL;

-- Dodaj stupac phone
ALTER TABLE users
  ADD COLUMN phone VARCHAR(30) NULL;

-- Promijeni name da bude obavezan (NOT NULL)
ALTER TABLE users
  MODIFY COLUMN name VARCHAR(100) NOT NULL;

-- Promijeni lastname da bude obavezan (NOT NULL)
ALTER TABLE users
  MODIFY COLUMN lastname VARCHAR(100) NOT NULL;

-- Dodaj jedinstveni ključ na email
ALTER TABLE users
  ADD CONSTRAINT uq_users_email UNIQUE (email);
