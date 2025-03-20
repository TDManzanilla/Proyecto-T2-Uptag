CREATE TABLE roles (
    id_rol INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(255) NOT NULL UNIQUE KEY,

    fecha_registro DATETIME NULL,
    fecha_actualizacion DATETIME NULL,
    estado VARCHAR(255) NOT NULL
) ENGINE=InnoDB; 

INSERT INTO roles (nombre_rol, fecha_registro, estado)
VALUES ('ADMINISTRADOR', NOW(), '1');

INSERT INTO roles (nombre_rol, fecha_registro, estado)
VALUES ('DIRECTIVO', NOW(), '1');

INSERT INTO roles (nombre_rol, fecha_registro, estado)
VALUES ('DOCENTE', NOW(), '1');

INSERT INTO roles (nombre_rol, fecha_registro, estado)
VALUES ('ESTUDIANTE', NOW(), '1');

INSERT INTO roles (nombre_rol, fecha_registro, estado)
VALUES ('PADRE DE FAMILIA', NOW(), '1');

INSERT INTO roles (nombre_rol, fecha_registro, estado)
VALUES ('PERSONAL DE CONTROL DE ESTUDIOS', NOW(), '1');

INSERT INTO roles (nombre_rol, fecha_registro, estado)
VALUES ('JEFE DE CONTROL DE ESTUDIOS', NOW(), '1');

CREATE TABLE usuarios (
    id_usuario INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(255) NOT NULL,
    rol_id INT(11) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE KEY,
    password TEXT NOT NULL,

    fecha_registro DATETIME NULL,
    fecha_actualizacion DATETIME NULL,
    estado VARCHAR(255) NOT NULL,

    FOREIGN KEY (rol_id) REFERENCES roles(id_rol) on delete no action on update cascade
) ENGINE=InnoDB;

INSERT INTO usuarios (nombres, rol_id, email, password, fecha_registro, estado)
VALUES ('Admin', 1, 'admin@admin.com','$2y$10$MSZ/4MeMVfdr4sPceTb6B.0.JPSOU.RAK3COyp8jLHpLfJpToclz2', NOW(), '1');

