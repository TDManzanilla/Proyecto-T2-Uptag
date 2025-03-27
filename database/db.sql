
CREATE TABLE roles (

  id_rol        INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre_rol    VARCHAR (255) NOT NULL UNIQUE KEY,

  fyh_creacion   DATETIME NULL,
  fyh_actualizacion DATETIME NULL,
  estado        VARCHAR (11)

)ENGINE=InnoDB;
INSERT INTO roles (nombre_rol,fyh_creacion,estado) VALUES  ('ADMINISTRADOR',NOW(),'1');
INSERT INTO roles (nombre_rol,fyh_creacion,estado) VALUES  ('DIRECTIVO',NOW(),'1');
INSERT INTO roles (nombre_rol,fyh_creacion,estado) VALUES  ('PERSONAL CDE',NOW(),'1');
INSERT INTO roles (nombre_rol,fyh_creacion,estado) VALUES  ('DOCENTE',NOW(),'1');
INSERT INTO roles (nombre_rol,fyh_creacion,estado) VALUES  ('ESTUDIANTE',NOW(),'1');

CREATE TABLE usuarios (

  id_usuario    INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  rol_id        INT (11) NOT NULL,
  email         VARCHAR (255) NOT NULL UNIQUE KEY,
  password      TEXT NOT NULL,

  fyh_creacion   DATETIME NULL,
  fyh_actualizacion DATETIME NULL,
  estado        VARCHAR (11),

  FOREIGN KEY (rol_id) REFERENCES roles (id_rol) on delete no action on update cascade

)ENGINE=InnoDB;
INSERT INTO usuarios (rol_id,email,password,fyh_creacion,estado)
VALUES ('1','admin@admin.com','$2y$10$0tYmdHU9uGCIxY1f90W1EuIm54NQ8axowkxL1WzLbqO2LdNa8m3l2',NOW(),'1');


CREATE TABLE personas (

  id_persona      INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  usuario_id             INT (11) NOT NULL,
  nombres            VARCHAR (50) NOT NULL,
  apellidos          VARCHAR (50) NOT NULL,
  ci                 VARCHAR (20) NOT NULL,
  fecha_nacimiento   VARCHAR (20) NOT NULL,
  profesion          VARCHAR (50) NOT NULL,
  direccion          VARCHAR (255) NOT NULL,
  celular            VARCHAR (20) NOT NULL,

  fyh_creacion   DATETIME NULL,
  fyh_actualizacion DATETIME NULL,
  estado        VARCHAR (11),

  FOREIGN KEY (usuario_id) REFERENCES usuarios (id_usuario) on delete no action on update cascade

)ENGINE=InnoDB;
INSERT INTO personas (usuario_id,nombres,apellidos,ci,fecha_nacimiento,profesion,direccion,celular,fyh_creacion,estado)
VALUES ('1','DALIOBERT ENRIQUE','TOYO AULAR','27811140','22/11/2000','ESTUDIANTE UPTAG','Urb Monseñor Iturriza III Etapa Calle 06 Casa #202','04120868498',NOW(),'1');

CREATE TABLE administrativos (

  id_administrativo      INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  persona_id             INT (11) NOT NULL,

  fyh_creacion   DATETIME NULL,
  fyh_actualizacion DATETIME NULL,
  estado        VARCHAR (11),

  FOREIGN KEY (persona_id) REFERENCES personas (id_persona) on delete no action on update cascade

)ENGINE=InnoDB;



CREATE TABLE docentes (

  id_docente             INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  persona_id             INT (11) NOT NULL,

  fyh_creacion   DATETIME NULL,
  fyh_actualizacion DATETIME NULL,
  estado        VARCHAR (11),

  FOREIGN KEY (persona_id) REFERENCES personas (id_persona) on delete no action on update cascade

)ENGINE=InnoDB;

CREATE TABLE configuracion_instituciones (

  id_config_institucion    INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre_institucion       VARCHAR (255) NOT NULL,
  logo                     VARCHAR (255) NULL,
  direccion                VARCHAR (255) NOT NULL,
  telefono                 VARCHAR (100) NULL,
  celular                  VARCHAR (100) NULL,
  correo                   VARCHAR (100) NULL,

  fyh_creacion   DATETIME NULL,
  fyh_actualizacion DATETIME NULL,
  estado        VARCHAR (11)

)ENGINE=InnoDB;
INSERT INTO configuracion_instituciones (nombre_institucion,logo,direccion,telefono,celular,correo,fyh_creacion,estado)
VALUES ('Complejo Escolar Pestalozzi','logo.jpg','Calle 23 de Enero con Calle Zamora Sector Pantano Abajo','04141691434','04262685370','uenpestalozzii@gmail.com',NOW(),'1');


CREATE TABLE gestiones (

  id_gestion      INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  gestion         VARCHAR (255) NOT NULL,

  fyh_creacion   DATETIME NULL,
  fyh_actualizacion DATETIME NULL,
  estado        VARCHAR (11)

)ENGINE=InnoDB;
INSERT INTO gestiones (gestion,fyh_creacion,estado)
VALUES ('2024-2025',NOW(),'1');

CREATE TABLE niveles (

  id_nivel       INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  gestion_id     INT (11) NOT NULL,
  nivel          VARCHAR (255) NOT NULL,
  turno          VARCHAR (255) NOT NULL,

  fyh_creacion   DATETIME NULL,
  fyh_actualizacion DATETIME NULL,
  estado        VARCHAR (11),

  FOREIGN KEY (gestion_id) REFERENCES gestiones (id_gestion) on delete no action on update cascade

)ENGINE=InnoDB;
INSERT INTO niveles (gestion_id,nivel,turno,fyh_creacion,estado)
VALUES ('1','SECUNDARIA','MAÑANA',NOW(),'1');


CREATE TABLE grados (

  id_grado       INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nivel_id       INT (11) NOT NULL,
  curso          VARCHAR (255) NOT NULL,
  paralelo       VARCHAR (255) NOT NULL,

  fyh_creacion   DATETIME NULL,
  fyh_actualizacion DATETIME NULL,
  estado        VARCHAR (11),

  FOREIGN KEY (nivel_id) REFERENCES niveles (id_nivel) on delete no action on update cascade

)ENGINE=InnoDB;

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','PRIMER AÑO','A',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','PRIMER AÑO','B',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','PRIMER AÑO','C',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','SEGUNDO AÑO','A',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','SEGUNDO AÑO','B',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','SEGUNDO AÑO','C',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','SEGUNDO AÑO','D',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','TERCER AÑO','A',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','TERCER AÑO','B',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','TERCER AÑO','C',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','CUARTO AÑO','A',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','CUARTO AÑO','B',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','CUARTO AÑO','C',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','QUINTO AÑO','A',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','QUINTO AÑO','B',NOW(),'1');

INSERT INTO grados (nivel_id,curso,paralelo,fyh_creacion,estado)
VALUES ('1','QUINTO AÑO','C',NOW(),'1');

CREATE TABLE estudiantes (

  id_estudiante          INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  persona_id             INT (11) NOT NULL,
  nivel_id               INT (11) NOT NULL,
  grado_id               INT (11) NOT NULL,

  fyh_creacion   DATETIME NULL,
  fyh_actualizacion DATETIME NULL,
  estado        VARCHAR (11),

  FOREIGN KEY (persona_id) REFERENCES personas (id_persona) on delete no action on update cascade,
  FOREIGN KEY (nivel_id) REFERENCES niveles (id_nivel) on delete no action on update cascade,
  FOREIGN KEY (grado_id) REFERENCES grados (id_grado) on delete no action on update cascade

)ENGINE=InnoDB;

CREATE TABLE ppffs (

  id_ppff                        INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  estudiantes_id                 INT (11) NOT NULL,

  nombres_apellidos_ppff         VARCHAR (255) NOT NULL,
  ci_ppff                        VARCHAR (20) NOT NULL,
  celular_ppff                   VARCHAR (20) NOT NULL,
  direccion_ppff                 VARCHAR (255) NOT NULL,
  parentesco_ppff                VARCHAR (255) NOT NULL,
  ref_nombre_apellido_ppff       VARCHAR (255) NOT NULL,
  ref_celular_ppff               VARCHAR (20) NOT NULL,
  ref_parentesco_ppff            VARCHAR (255) NOT NULL,

  fyh_creacion   DATETIME NULL,
  fyh_actualizacion DATETIME NULL,
  estado        VARCHAR (11),

  FOREIGN KEY (estudiantes_id) REFERENCES estudiantes (id_estudiante) on delete no action on update cascade

)ENGINE=InnoDB;

CREATE TABLE materias (

  id_materia      INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre_materia         VARCHAR (255) NOT NULL,

  fyh_creacion   DATETIME NULL,
  fyh_actualizacion DATETIME NULL,
  estado        VARCHAR (11)

)ENGINE=InnoDB;

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('ORIENTACION Y CONVIVENCIA',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('CASTELLANO',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('INGLES',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('MATEMÁTICA',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('EDUCACION FISICA',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('GEOGRAFIA, HISTORIA Y CIUDADANIA',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('ARTE Y PATRIMONIO',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('CIENCIAS NATURALES',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('BIOLOGÍA',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('QUÍMICA',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('FISICA',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('FORMACION PARA LA SOBERANIA',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('CIENCIAS DE LA TIERRA',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('GRUPO DECREACIÓN, RECREACION Y PARTICIPACION',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('BIOQUÍMICA',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('PRACTICA SOCIOLABORAL',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('PROYECTO DE ECONOMÍA',NOW(),'1');

INSERT INTO materias (nombre_materia,fyh_creacion,estado)
VALUES ('TECNOLOGÍA DE LA SALUD',NOW(),'1');