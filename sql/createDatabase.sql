DROP DATABASE IF EXISTS Educem;
CREATE DATABASE IF NOT EXISTS Educem;
USE Educem;

DROP TABLE IF EXISTS `Curso`;
CREATE TABLE IF NOT EXISTS `Curso` (
  idCurso INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(32) NOT NULL,
  Año VARCHAR(9) NOT NULL,
  ipCurso VARCHAR(15) UNIQUE NOT NULL,
  PRIMARY KEY (idCurso)
);

DROP TABLE IF EXISTS `Usuarios`;
CREATE TABLE IF NOT EXISTS `Usuarios` (
  idUsuario INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(32) NOT NULL,
  Apellidos VARCHAR(64) NOT NULL,
  DNI CHAR(9) UNIQUE NOT NULL,
  Correo VARCHAR(128) UNIQUE NOT NULL,
  Usuario VARCHAR(16) UNIQUE NOT NULL,
  Contraseña VARCHAR(256) NOT NULL,
  ipAlumno VARCHAR(15) UNIQUE NULL,
  Roles ENUM('Profesores', 'Alumnos') NOT NULL,
  PRIMARY KEY (idUsuario)
);


DROP TABLE IF EXISTS `Software`;
CREATE TABLE IF NOT EXISTS `Software` (
  idSoftware INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(32) NOT NULL,
  repVersion VARCHAR(16) NOT NULL,
  puerto INT NOT NULL,
  PRIMARY KEY (idSoftware)
);

DROP TABLE IF EXISTS `Curso_usuario`;
CREATE TABLE IF NOT EXISTS `Curso_usuario` (
  idCurso INT NOT NULL,
  idUsuario INT NOT NULL,
  PRIMARY KEY (idCurso, idUsuario),
  FOREIGN KEY (idCurso) REFERENCES Curso(idCurso)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (idUsuario) REFERENCES Usuarios(idUsuario)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

DROP TABLE IF EXISTS `Curso_software`;
CREATE TABLE IF NOT EXISTS `Curso_software` (
  idCurso INT NOT NULL,
  idSoftware INT NOT NULL,
  PRIMARY KEY (idCurso, idSoftware),
  FOREIGN KEY (idCurso) REFERENCES Curso(idCurso)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (idSoftware) REFERENCES Software(idSoftware)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);
INSERT INTO Curso (Nombre, Año, ipCurso) VALUES 
    ('ASIX1', '2024', '192.168.10.21'),
    ('DAM1', '2024', '192.168.10.31'),
    ('ADMIN', '2024', '192.168.10.14');

INSERT INTO Usuarios (Nombre, Apellidos, DNI, Correo, Usuario, Contraseña, Roles, ipAlumno) VALUES 
    ('Juan', 'González Pérez', '123456789', 'juan@example.com', 'juang', '$2y$10$dHLqRiK4VFeq.YoqIkwRmOKQEbkIBsgf90wDXfCvm8SnOgv3JNnxu', 'Alumnos', '192.168.10.22'),
    ('María', 'López Martínez', '987654321', 'maria@example.com', 'marial', '$2y$10$dHLqRiK4VFeq.YoqIkwRmOKQEbkIBsgf90wDXfCvm8SnOgv3JNnxu', 'Alumnos', '192.168.10.23'),
    ('Pedro', 'Sánchez Rodríguez', '456789123', 'pedro@example.com', 'pedros', '$2y$10$dHLqRiK4VFeq.YoqIkwRmOKQEbkIBsgf90wDXfCvm8SnOgv3JNnxu', 'Alumnos', '192.168.10.32'),
    ('Admin', 'Admin Admin', '45678234', 'profe@example.com', 'admin', '$2y$10$dHLqRiK4VFeq.YoqIkwRmOKQEbkIBsgf90wDXfCvm8SnOgv3JNnxu', 'Profesores', '192.168.10.14');

INSERT INTO Software (Nombre, repVersion, puerto) VALUES 
    ('VSCODE', '1.0','3000'),
    ('MYSQL', '8.1','8080'),
    ('PORTAINER', '1.0','9000'),
    ('KALI', '1.0','9020'),
    ('UBUNTU', '1.0','9090'),
    ('MAILHOG', '1.0', '8025');


INSERT INTO Curso_usuario (idCurso, idUsuario) VALUES 
    (1, 1), -- Juan en ASIX1
    (1, 2), -- María en ASIX1
    (1, 4), -- Admin en ADMIN
    (2, 3); -- Pedro en DAM1

INSERT INTO Curso_software (idCurso, idSoftware) VALUES 
    /* ASIX */
    (1, 1), -- VSCODE en ASIX1
    (1, 2), -- MYSQL en ASIX1
    (1, 4), -- KALI en ASIX1
    (1, 5), -- UBUNTU en ASIX1
    (1, 6), -- MAILHOG en ASIX1
    /* DAM */
    (2, 1); -- VSCODE en DAM1
    /* ADMIN */
    (3, 1), -- VSCODE en ASIX1
    (3, 2), -- MYSQL en ASIX1
    (3, 3), -- PORTAINER en ADMIN
    (3, 4), -- KALI en ASIX1
    (3, 5), -- UBUNTU en ASIX1
    (3, 6), -- MAILHOG en ASIX1