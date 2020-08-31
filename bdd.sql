-- DROP DATABASE proyecto_final;

-- CREATE DATABASE proyecto_final;

USE proyecto_final;

/*
 * Creacion de Tablas
 */
CREATE TABLE Titular(
    nro_socio varchar(15) NOT NULL,
    id_categoria varchar(15) NOT NULL,
    nombre varchar(20) NOT NULL,
    apellido varchar(20) NOT NULL,
    fecha_nac date NOT NULL,
    email varchar(30),
    celular char(11),
    telefono char(11) NOT NULL,
    domicilio varchar(20) NOT NULL,
    PRIMARY KEY(nro_socio),
    FOREIGN KEY(id_categoria) REFERENCES Categoria(id_categoria) ON DELETE CASCADE
);

CREATE TABLE Categoria_Evento(
    id_categoria int NOT NULL AUTO,
    descripcion varchar (30) NOT NULL,
    PRIMARY KEY(id_categoria)
)

CREATE TABLE Evento(
    id_evento int NOT NULL AUTO,
    -- año year not null,
    -- dia day NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    hora_inicio time NOT NULL,
    hora_fin time NOT NULL,
    lugar varchar(30) NOT NULL,
    id_categoria int NOT NULL,
    PRIMARY KEY(id_evento),
    FOREIGN KEY(id_categoria) REFERENCES Categoria_Evento(id_categoria) ON DELETE CASCADE
);

CREATE TABLE Orador(
    legajo varchar(15) NOT NULL,
    nombre varchar(20) NOT NULL,
    apellido varchar(20) NOT NULL,
    dni varchar(11) NOT NULL,
    descripcion text(600) NOT NULL,
    id_evento varchar(15) NOT NULL,
    url_imagen varchar(50),
    PRIMARY KEY(legajo),
    FOREIGN KEY(id_evento) REFERENCES Evento(id_evento) ON DELETE CASCADE
)



-- INSERCIONES  ------------------------------------------------------------------------------------------------------

INSERT INTO
    Categoria_Evento(id_categoria, descripcion)
VALUES
    (1, 'Charla'),
    (2, 'Taller'),
    (3, 'Congreso');


INSERT INTO
    Evento(id_evento,fecha_inicio,fecha_fin,hora_inicio,hora_fin,lugar, id_categoria)
VALUES
    (001,2021-03-16,2021-03-17, 09:00:00, 21:00:00,'UNMDP',3);


INSERT INTO
    Orador(legajo, nombre, apellido, dni, descripcion, id_evento, url_imagen)
VALUES
    ('12129', Felipe, Evans, 20150120, 'Vice del departamento de Ingeniería en Informática.', 001, orador1.jpg);