-- Crear tabla de profesores
CREATE TABLE profesores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    telefono VARCHAR(15)
);

-- Crear tabla de cursos
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    prof_id INT,  -- Relación con la tabla profesores
    imagen VARCHAR(255) default('img/default.png'),
    FOREIGN KEY (prof_id) REFERENCES profesores(id)
);
INSERT INTO profesores (nombre, email, telefono)
VALUES
('Juan Rodríguez', 'juan.rodriguez@email.com', '123456789'),
('Ana López', 'ana.lopez@email.com', '987654321');

INSERT INTO cursos (nombre, descripcion, prof_id)
VALUES
('Matemáticas Avanzadas', 'Curso de matemáticas de nivel avanzado.', 1),
('Introducción a la Física', 'Curso básico de física.', 1),  
('Literatura Contemporánea', 'Curso sobre literatura moderna y contemporánea.', 2);  


