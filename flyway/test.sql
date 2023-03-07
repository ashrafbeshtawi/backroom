-- V1__create_table.sql

CREATE TABLE IF NOT EXISTS customers (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);
