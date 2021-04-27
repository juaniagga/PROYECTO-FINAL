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
    acreditados int not NULL,
    estado TINYINT NOT null,
    organizador varchar(30) not null,
    limite int(8) UNSIGNED not NULL,
    ubicacion varchar(30) NOT NULL,
    descripcion varchar(1000) NOT NULL,
    info_pago varchar(20) not null,
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
    id_orador int NOT NULL AUTO_INCREMENT,
    id_evento int NOT NULL,
    dni int(8) UNSIGNED NOT NULL,
    nombre varchar(20) NOT NULL,
    apellido varchar(20) NOT NULL,
    biografia text(600) NOT NULL,
    imagen varchar(20) not null,
    PRIMARY KEY(id_orador),
    FOREIGN KEY(id_evento) REFERENCES evento(id_evento) ON DELETE CASCADE
);

CREATE TABLE dicta(
    id_orador int NOT NULL,
    id_actividad int NOT NULL,
    PRIMARY KEY(id_orador,id_actividad),
    FOREIGN KEY(id_orador) REFERENCES orador(id_orador) ON DELETE CASCADE,
    FOREIGN KEY(id_actividad) REFERENCES actividad(id_actividad) ON DELETE CASCADE
);

CREATE TABLE categoria_participante(
    id_categoria int NOT NULL AUTO_INCREMENT,
    nombre varchar(20) NOT NULL,
    autoreg TINYINT not NULL,
    PRIMARY KEY(id_categoria)
);

CREATE TABLE cat_asociadas(
    id_evento int NOT NULL,
    id_categoria int NOT NULL,
    tarifa float not NULL,
    PRIMARY KEY(id_evento,id_categoria),
    FOREIGN KEY(id_evento) REFERENCES evento(id_evento) ON DELETE CASCADE,
    FOREIGN KEY(id_categoria) REFERENCES categoria_participante(id_categoria) ON DELETE CASCADE
);

CREATE TABLE usuario(
    id_user int NOT NULL AUTO_INCREMENT,  
    email varchar(40) NOT NULL UNIQUE,
    clave varchar(255) NOT NULL,
    dni int(8) UNSIGNED NOT NULL,
    nombre varchar(20) NOT NULL,
    apellido varchar(20) NOT NULL,
    telefono varchar(20) not null,
    calle varchar(30) NOT NULL,
    numero int NOT NULL,
    ciudad varchar(30) NOT NULL,
    provincia varchar(20) NOT NULL,
    pais varchar(20) NOT NULL,
    trabajo_cientifico TINYINT not NULL,
    institucion varchar(30) not null,
    cargo varchar(20) not null,
    PRIMARY KEY(id_user)
);

CREATE TABLE participante(
    id_participante int NOT NULL AUTO_INCREMENT,
    id_user int NOT NULL UNIQUE,
    id_evento int NOT NULL,
    id_categoria int NOT NULL,
    fecha_registro DATE NOT NULL,
    acreditado TINYINT not NULL,
    forma_pago varchar(30) not null,
    importe_abonado float not null,
    comprobante varchar(50) not null,
    fecha_pago date not null,
    comentario_pago varchar(300) not null,
    pago_confirmado TINYINT not NULL,
    exento TINYINT not NULL,
    facturacion TINYINT not NULL,
    iva varchar(15) not null,
    cuit int(12) not null,
    adicionales varchar(50) not null,
    nombre_factura varchar(30) not null,
    alojamiento varchar(30) not null,
    fecha_arribo date not null,
    fecha_partida date not null,
    traslado varchar(20) not null,
    PRIMARY KEY(id_participante),
    FOREIGN KEY(id_user) REFERENCES usuario(id_user) ON DELETE CASCADE,
    FOREIGN KEY(id_evento) REFERENCES evento(id_evento) ON DELETE CASCADE,
    FOREIGN KEY(id_categoria) REFERENCES categoria_participante(id_categoria) ON DELETE CASCADE
);

CREATE TABLE administrador(
    id_admin int NOT NULL AUTO_INCREMENT,
    usuario varchar(30) NOT NULL UNIQUE,
    clave varchar(255) NOT NULL,
    email varchar(40) NOT NULL,
    nombre varchar(50) NOT NULL,
    apellido varchar(50) NOT NULL,
    permiso TINYINT NOT NULL,
    PRIMARY KEY(id_admin)
);

CREATE TABLE administrado(
    id_admin int NOT NULL,
    id_evento int not null,
    PRIMARY KEY(id_admin, id_evento),
    FOREIGN KEY(id_admin) REFERENCES administrador(id_admin) ON DELETE CASCADE,
    FOREIGN KEY(id_evento) REFERENCES evento(id_evento) ON DELETE CASCADE
);

CREATE TABLE medios_pago(
    id_medio int NOT NULL AUTO_INCREMENT,
    nombre varchar(30) NOT NULL,
    estado TINYINT not NULL,
    PRIMARY KEY(id_medio)
);


/* -- TRIGGER ---------------------------- */
CREATE TRIGGER add_inscripto
AFTER INSERT ON participante
FOR EACH ROW 
UPDATE evento
SET  inscriptos=inscriptos + 1
WHERE id_evento=NEW.id_evento;



/* INSERCIONES ------------------------------- */
INSERT INTO
    categoria_act(nombre, icono)
VALUES
    ('Charla', 'fa-comment'),
    ('Taller', 'fa-graduation-cap'),
    ('Curso', ''),
    ('Seminario', 'fa-university');


INSERT INTO
    evento(nombre,fecha_inicio,fecha_fin,inscriptos, acreditados, organizador, ubicacion, descripcion)
VALUES
    ('Fiesa','2021-03-16','2021-03-17', 0, 0, 'UNMdP','Deán Funes 3350','La Feria Internacional de Educación Superior Argentina (FIESA) es un encuentro internacional de Instituciones de Educación Superior que tendrá a la Universidad Nacional de Mar del Plata y a la Ciudad de Mar del Plata como anfitrionas y reunirá a referentes de todo el mundo.');


INSERT INTO
    actividad(nombre_act, fecha, hora_inicio, hora_fin, descripcion, id_categoria, id_evento)
VALUES
    ('Nuevas técnicas de educación','2021-03-16', '09:00', '11:00', 'Se abordarán las nuevas técnicas
    educativas que utilizan la tecnología como principal herramienta.', 1, 1),
    ('IoT','2021-03-16', '14:00', '15:00', 'Auge del Internet of Things.', 4, 1),
    ('Software libre', '2021-03-17','10:30','12:00', 'Tecnologías Open Source de 2020.', 1, 1);


INSERT INTO
    orador(dni, nombre, apellido, biografia, imagen, id_evento)
VALUES
    (20150120, 'Fernando', 'Perez', 'Vice del departamento de Ingenieria en Informatica.', 'fernando.jpg', 1),
    (20312120, 'Josefina', 'Costa', 'Profesor de Ingenieria en Informatica.', 'josefina.jpg', 1);


INSERT INTO
    dicta(id_orador, id_actividad)
VALUES
    (1,1),
    (2,1),
    (1,2),
    (2,3);

INSERT INTO
    administrador(usuario, clave, email, nombre, permiso)
VALUES
    ('juani', '$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','juani@fi', 'Juan Ignacio', 0);

INSERT INTO
    administrado(id_admin, id_evento)
VALUES
    (1, 1);

INSERT INTO
    administrador(usuario, clave, email, nombre, permiso)
VALUES
    ('juanimaster', '$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','juani@fi', 'Juan Ignacio', 1);


INSERT INTO
    categoria_participante(id_categoria, nombre, autoreg)
VALUES
    (1,'estudiante',1);

INSERT INTO
    cat_asociadas(id_evento, id_categoria, tarifa)
VALUES
    (1,1,0);


INSERT INTO
    medios_pago(nombre, estado)
VALUES
    ('Pago fácil', 1),
    ('Transferencia', 0);