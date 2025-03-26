
-- Crear la tabla principal (lado 1 de la relación)

CREATE TABLE categorias (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR(50) UNIQUE NOT NULL
);



-- Crear la tabla relacionada (lado N de la relación)

CREATE TABLE productos (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR(100) UNIQUE NOT NULL,
 descripcion TEXT, -- Campo nuevo de tipo TEXT
 imagen VARCHAR(255) DEFAULT 'img/default.png', -- Valor por defecto
 categoria_id INT NOT NULL,
 FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
);



-- Insertar datos de ejemplo en la tabla "categoria"

INSERT INTO categorias (nombre) VALUES
('Electrónica'),
('Ropa'),
('Hogar');



-- Insertar datos de ejemplo en la tabla "producto"

INSERT INTO productos (nombre, descripcion, categoria_id) VALUES
('Smartphone X10', 'Un smartphone de última generación con pantalla OLED.', 1),
('Laptop Pro 2023', 'Una laptop potente ideal para trabajo y gaming.', 1),
('Camiseta básica', 'Camiseta de algodón disponible en varios colores.', 2),
('Pantalón vaquero', 'Pantalón vaquero clásico con diseño moderno.', 2),
('Sofá moderno', 'Sofá de tres plazas con estructura de madera.', 3),
('Lámpara de pie', 'Lámpara de pie con diseño minimalista.', 3);