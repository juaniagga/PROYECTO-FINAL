DROP DATABASE proyecto_final;

CREATE DATABASE proyecto_final;

USE proyecto_final;

CREATE TABLE categoria_act(
    id_categoria int NOT NULL AUTO_INCREMENT,
    nombre varchar(50) NOT NULL,
    icono varchar(20) not NULL,
    PRIMARY KEY(id_categoria)
);

CREATE TABLE evento(
    id_evento int NOT NULL AUTO_INCREMENT,
    nombre varchar(200) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    inscriptos int not NULL,
    acreditados int not NULL,
    estado TINYINT NOT null,
    organizador varchar(100) not null,
    limite int(8) UNSIGNED not NULL,
    ubicacion varchar(30) NOT NULL,
    descripcion varchar(1000) NOT NULL,
    imagen varchar(50) not null,
    info_pago varchar(30) not null,
    PRIMARY KEY(id_evento)
);



CREATE TABLE actividad(
    id_actividad int NOT NULL AUTO_INCREMENT,
    nombre_act varchar(100) NOT NULL,
    fecha DATE NOT NULL,
    hora_inicio time NOT NULL,
    hora_fin time NOT NULL,
    descripcion varchar(1000) NOT NULL,
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
    nombre varchar(50) NOT NULL,
    apellido varchar(50) NOT NULL,
    biografia text(1000) NOT NULL,
    imagen varchar(50) not null,
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
    nombre varchar(50) NOT NULL,
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
    email varchar(50) NOT NULL UNIQUE,
    clave varchar(255) NOT NULL,
    dni int(8) UNSIGNED NOT NULL,
    nombre varchar(50) NOT NULL,
    apellido varchar(50) NOT NULL,
    telefono varchar(20) not null,
    calle varchar(50) NOT NULL,
    numero int NOT NULL,
    ciudad varchar(40) NOT NULL,
    provincia varchar(30) NOT NULL,
    pais varchar(30) NOT NULL,
    trabajo_cientifico TINYINT not NULL,
    institucion varchar(100) not null,
    cargo varchar(30) not null,
    PRIMARY KEY(id_user)
);

CREATE TABLE participante(
    id_participante int NOT NULL AUTO_INCREMENT,
    id_user int NOT NULL,
    id_evento int NOT NULL,
    id_categoria int NOT NULL,
    fecha_registro DATE NOT NULL,
    acreditado TINYINT not NULL,
    forma_pago varchar(40) not null,
    importe_abonado float not null,
    comprobante varchar(50) not null,
    fecha_pago date not null,
    comentario_pago varchar(600) not null,
    pago_confirmado TINYINT not NULL,
    exento TINYINT not NULL,
    facturacion TINYINT not NULL,
    iva varchar(15) not null,
    cuit int(12) not null,
    adicionales varchar(600) not null,
    nombre_factura varchar(50) not null,
    alojamiento varchar(100) not null,
    fecha_arribo date not null,
    fecha_partida date not null,
    traslado varchar(50) not null,
    PRIMARY KEY(id_participante),
    UNIQUE KEY (id_user,id_evento),
    FOREIGN KEY(id_user) REFERENCES usuario(id_user) ON DELETE CASCADE,
    FOREIGN KEY(id_evento) REFERENCES evento(id_evento) ON DELETE CASCADE,
    FOREIGN KEY(id_categoria) REFERENCES categoria_participante(id_categoria) ON DELETE CASCADE
);

CREATE TABLE administrador(
    id_admin int NOT NULL AUTO_INCREMENT,
    usuario varchar(50) NOT NULL UNIQUE,
    clave varchar(255) NOT NULL,
    email varchar(50) NOT NULL,
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
    nombre varchar(50) NOT NULL,
    estado TINYINT not NULL,
    PRIMARY KEY(id_medio)
);





/* INSERCIONES ------------------------------- */
INSERT INTO
    categoria_act(nombre, icono)
VALUES
    ('Charla', 'fa-comment'),
    ('Taller', 'fa-graduation-cap'),
    ('Curso', ''),
    ('Seminario', 'fa-university');


INSERT INTO
    evento(nombre,fecha_inicio,fecha_fin,inscriptos, acreditados, organizador, ubicacion, descripcion, imagen)
VALUES
    ('Fiesa','2021-11-16','2021-11-17', 7, 6, 'UNMdP','Deán Funes 3350','La Feria Internacional de Educación Superior Argentina (FIESA) es un encuentro internacional de Instituciones de Educación Superior que tendrá a la Universidad Nacional de Mar del Plata y a la Ciudad de Mar del Plata como anfitrionas y reunirá a referentes de todo el mundo.', "fiesa.jpg"),
    ('Dia del ingeniero','2021-06-16','2021-06-16', 0, 0, 'UNMdP','Deán Funes 3350','Actividades para celebrar el día del ingeniero.',""),
    ('Día del estudiante','2021-09-21','2021-09-21', 0, 0, 'UNMdP','Deán Funes 3350','Actividades para celebrar el día del estudiante.',"");


INSERT INTO
    actividad(nombre_act, fecha, hora_inicio, hora_fin, descripcion, id_categoria, id_evento)
VALUES
    ('Nuevas técnicas de educación','2021-03-16', '09:00', '11:00', 'Se abordarán las nuevas técnicas
    educativas que utilizan la tecnología como principal herramienta.', 1, 1),
    ('IoT','2021-03-16', '14:00', '15:00', 'Auge del Internet of Things.', 4, 1),
    ('Software libre', '2021-03-17','10:30','12:00', 'Tecnologías Open Source de 2021.', 1, 1),
    ('Programación web', '2021-03-17','10:30','12:00', 'Tecnologías frontend en 2021.', 1, 1);


INSERT INTO
    orador(dni, nombre, apellido, biografia, imagen, id_evento)
VALUES
    (20150120, 'Fernando', 'Perez', 'Vice del departamento de Ingenieria en Informatica.', 'fernando.jpg', 1),
    (20312120, 'Josefina', 'Costa', 'Profesor de Ingenieria en Informatica.', 'josefina.jpg', 1),
    (20230232, 'Pilar', 'Mutti', 'Estudiante de Ingenieria en Informatica.', 'icono.png', 1);


INSERT INTO
    dicta(id_orador, id_actividad)
VALUES
    (1,1),
    (2,1),
    (1,2),
    (2,3),
    (3,4);

INSERT INTO
    administrador(usuario, clave, email, nombre, permiso)
VALUES
    ('juani', '$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','juani@fi.edu', 'Juan Ignacio', 0),
    ('pilar', '$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','pilar@fi.edu', 'Pilar', 0),
    ('juani2', '$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','juani@fi.edu', 'Juan Ignacio', 0),
    ('juani3', '$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','juani@fi.edu', 'Juan Ignacio', 0),
    ('carlos', '$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','carlos@fi.edu', 'Carlos', 1),
    ('violeta', '$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','viole@fi.edu', 'Violeta', 1);


INSERT INTO
    administrado(id_admin, id_evento)
VALUES
    (1, 1),
    (2, 1),
    (3, 2),
    (4, 3);

INSERT INTO
    categoria_participante(nombre, autoreg)
VALUES
    ('Estudiante',1),
    ('Docente',1),
    ('Particular',1),
    ('Prensa',0);

INSERT INTO
    cat_asociadas(id_evento, id_categoria, tarifa)
VALUES
    (1,1,0),
    (1,2,0),
    (1,3,500),
    (1,4,0);


INSERT INTO
    medios_pago(nombre, estado)
VALUES
    ('Pago fácil', 1),
    ('Tarjeta de crédito', 1),
    ('Transferencia bancaria', 1);


INSERT INTO 
    usuario(email, clave, dni, nombre, apellido, telefono, calle, numero, ciudad, provincia, pais, institucion)
VALUES 
    ('juani@gmail.com','$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','41106347','Juan','Aguinaga','5402235627288','Tres Arroyos','2323','Mar del Plata','Buenos Aires','Argentina','Universidad Nacional de Mar del Plata'),
    ('pilar@gmail.com','$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','43106347','Pilar','Mutti','5402235623488','San Lorenzo','2323','Mar del Plata','Buenos Aires','Argentina','Universidad Nacional de Mar del Plata'),
    ('facu@gmail.com','$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','43102347','Facundo','Perez','2233427288','Jara','231','Mar del Plata','Buenos Aires','Argentina','Universidad Nacional de Mar del Plata'),
    ('ramiro@gmail.com','$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','41103447','Ramiro','Gonzalez','2235622288','Belgrano','1323','La Plata','Buenos Aires','Argentina','Universidad Tecnológica Nacional'),
    ('laura@gmail.com','$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','41105647','Laura','Martinez','2235627288','San Martin','2523','Pinamar','Buenos Aires','Argentina','Fasta'),
    ('tomas@gmail.com','$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','40106347','Tomas','Sanchez','2235627288','Rivadavia','2313','San Isidro','Buenos Aires','Argentina','UADE'),
    ('alan@gmail.com','$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','41106347','Alan','Capano','2235231823','Constitución','3023','Mar del Plata','Buenos Aires','Argentina','Universidad Nacional de Mar del Plata'),
    ('claudia@gmail.com','$2y$10$sJeaOnfU5u0IpsYOv2b4Oepo/P0TuMoIn2F2unjZXIOrh6TfVbcza','47823123','Claudia','Dias','22357239232','Alvarado','1002','La Plata','Buenos Aires','Argentina','Universidad Tecnológica Nacional');


INSERT INTO 
    participante(id_user, id_evento, id_categoria, fecha_registro, acreditado)
VALUES 
    (1,1,1,'2021-06-05',1),
    (2,1,1,'2021-06-05',1),
    (3,1,1,'2021-06-05',0),
    (4,1,3,'2021-06-05',1),
    (5,1,3,'2021-06-05',1),
    (6,1,4,'2021-06-05',1),
    (7,1,1,'2021-06-05',1),
    (8,1,2,'2021-06-05',1);
