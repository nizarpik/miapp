CREATE DATABASE IF NOT EXISTS miapp CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE miapp;

-- Tabla bodegas
CREATE TABLE IF NOT EXISTS bodegas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Tabla sucursales
CREATE TABLE IF NOT EXISTS sucursales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bodega_id INT NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    FOREIGN KEY (bodega_id) REFERENCES bodegas(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

-- Tabla monedas
CREATE TABLE IF NOT EXISTS monedas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL
);

-- Tabla productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(15) UNIQUE NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    bodega_id INT NOT NULL,
    sucursal_id INT NOT NULL,
    moneda_id INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    materiales VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bodega_id) REFERENCES bodegas(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (sucursal_id) REFERENCES sucursales(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (moneda_id) REFERENCES monedas(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

-- Datos iniciales
INSERT INTO bodegas (nombre) VALUES ('Bodega 1'), ('Bodega 2')
    ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);
INSERT INTO sucursales (bodega_id, nombre) VALUES 
    (1, 'Sucursal 1'), (1, 'Sucursal 2'), (2, 'Sucursal 3')
    ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);
INSERT INTO monedas (nombre) VALUES ('PESO'), ('DÓLAR'), ('EURO')
    ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);
