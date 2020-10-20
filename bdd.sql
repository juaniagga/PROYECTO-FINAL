DROP DATABASE proyecto_final;

CREATE DATABASE proyecto_final;

USE proyecto_final;

CREATE TABLE categoria_act(
    id_categoria int NOT NULL AUTO_INCREMENT,
    nombre varchar(20) NOT NULL,
    icono varchar(20) not NULL,
    PRIMARY KEY(id_categoria)
);

CREATE TABLE evento(
    id_evento int NOT NULL AUTO_INCREMENT,
    nombre varchar(50) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    inscriptos int not NULL,
    asistencias int not NULL,
    ubicacion varchar(30) NOT NULL,
    descripcion varchar(1000) NOT NULL,
    PRIMARY KEY(id_evento)
);

CREATE TABLE actividad(
    id_actividad int NOT NULL AUTO_INCREMENT,
    nombre_act varchar(30) NOT NULL,
    fecha DATE NOT NULL,
    hora_inicio time NOT NULL,
    hora_fin time NOT NULL,
    descripcion varchar(130) NOT NULL,
    id_categoria INT NOT NULL,
    id_evento int NOT NULL,
    PRIMARY KEY(id_actividad),
    FOREIGN KEY(id_categoria) REFERENCES categoria_act(id_categoria) ON DELETE CASCADE,
    FOREIGN KEY(id_evento) REFERENCES evento(id_evento) ON DELETE CASCADE
);

CREATE TABLE orador(
    dni varchar(11) NOT NULL,
    nombre varchar(20) NOT NULL,
    apellido varchar(20) NOT NULL,
    descripcion text(600) NOT NULL,
    url_imagen varchar(50),
    PRIMARY KEY(dni)
);

CREATE TABLE dicta(
    dni varchar(11) NOT NULL,
    id_actividad int NOT NULL,
    PRIMARY KEY(dni,id_actividad),
    FOREIGN KEY(dni) REFERENCES orador(dni) ON DELETE CASCADE,
    FOREIGN KEY(id_actividad) REFERENCES actividad(id_actividad) ON DELETE CASCADE
);

CREATE TABLE categoria_participante(
    id_categoria int NOT NULL AUTO_INCREMENT,
    nombre varchar(20) NOT NULL,
    precio float not NULL,
    PRIMARY KEY(id_categoria)
);

CREATE TABLE participante(
    nombre varchar(20) NOT NULL,
    apellido varchar(20) NOT NULL,
    dni varchar(11) NOT NULL,
    mail varchar(30) NOT NULL,
    ciudad varchar(30) NOT NULL,
    provincia varchar(20) NOT NULL,
    pais varchar(20) NOT NULL,
    documento varchar(20),
    id_categoria int NOT NULL,
    PRIMARY KEY(dni),
    FOREIGN KEY(id_categoria) REFERENCES categoria_participante(id_categoria) ON DELETE CASCADE
);

CREATE TABLE Administrador(
    legajo varchar(15) NOT NULL,
    nombre varchar(20) NOT NULL,
    apellido varchar(20) NOT NULL,
    dni varchar(11) NOT NULL,
    usuario varchar(20) NOT NULL,
    contraseña varchar(30) NOT NULL,
    PRIMARY KEY(legajo)
);

CREATE TABLE se_inscribe(
    dni varchar(11) NOT NULL,
    id_evento int NOT NULL,
    PRIMARY KEY(dni, id_evento),
    FOREIGN KEY(dni) REFERENCES participante(dni) ON DELETE CASCADE,
    FOREIGN KEY(id_evento) REFERENCES evento(id_evento) ON DELETE CASCADE
);



-- INSERCIONES  ------------------------------------------------------------------------------------------------------

INSERT INTO
    categoria_act(nombre, icono)
VALUES
    ('Charla', 'fa-comment'),
    ('Taller', 'fa-graduation-cap'),
    ('Curso', ''),
    ('Seminario', 'fa-university');


INSERT INTO
    evento(nombre,fecha_inicio,fecha_fin,inscriptos, asistencias, ubicacion, descripcion)
VALUES
    ('Fiesa','2021-03-16','2021-03-17', 0, 0, 'UNMDP','La Feria Internacional de Educación Superior Argentina (FIESA) es un encuentro internacional de Instituciones de Educación Superior que tendrá a la Universidad Nacional de Mar del Plata y a la Ciudad de Mar del Plata como anfitrionas y reunirá a referentes de todo el mundo.');


INSERT INTO
    actividad(nombre_act, fecha, hora_inicio, hora_fin, descripcion, id_categoria, id_evento)
VALUES
    ('Nuevas técnicas de educación','2021-03-16', '09:00', '11:00', 'Se abordarán las nuevas técnicas
    educativas que utilizan la tecnología como principal herramienta.', 1, 1),
    ('IoT','2021-03-16', '14:00', '15:00', 'Auge del Internet of Things.', 4, 1),
    ('Software libre', '2021-03-17','10:30','12:00', 'Tecnologías Open Source de 2020.', 1, 1);


INSERT INTO
    orador(dni, nombre, apellido, descripcion, url_imagen)
VALUES
    ('20150120', 'Fernando', 'Perez', 'Vice del departamento de Ingenieria en Informatica.', 'fernando.jpg'),
    ('20312120', 'Josefina', 'Costa', 'Profesor de Ingenieria en Informatica.', 'josefina.jpg');


INSERT INTO
    dicta(dni, id_actividad)
VALUES
    ('20150120',1),
    ('20312120',1),
    ('20150120',2),
    ('20312120',3);