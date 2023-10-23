/***************** USUARIOS, ROLES, PERMISOS *****************/

CREATE TABLE usuarios
(
  ID INT(11) PRIMARY KEY AUTO_INCREMENT,
  USUARIOS VARCHAR(1000) NOT NULL,
  NOMBRES VARCHAR(1000) NOT NULL,
  PASSWORD VARCHAR(50) NOT NULL,
  ID_CAJA INT(11),
  ESTADO BOOLEAN DEFAULT 1
);

CREATE TABLE caja
(
  ID INT(11) PRIMARY KEY AUTO_INCREMENT,
  CAJA VARCHAR(50) NOT NULL,
  ESTADO BOOLEAN DEFAULT 1
);

CREATE TABLE permisos
(
  ID INT(11) PRIMARY KEY AUTO_INCREMENT,
  PERMISO VARCHAR(100) NOT NULL
);

CREATE TABLE detalle_permiso
(
  ID INT(11) PRIMARY KEY AUTO_INCREMENT,
  ID_ROL INT(11),
  ID_PERMISO INT(11) 
);

ALTER TABLE usuarios
ADD CONSTRAINT fk_usuarios_caja
FOREIGN KEY (ID_CAJA) REFERENCES caja(ID);


/***************** PACIENTES *****************/
/* REGISTRO *****************/
CREATE TABLE registro (
  ID_PACIENTE varchar(10) PRIMARY KEY NOT NULL,
  DNI varchar(11),
  NOMBRES varchar(400),
  GENERO varchar(50),
  CELULAR int(15),
  DIRECCION TEXT,
  LOCACION TEXT,
  EDAD int(3),
  SEDE varchar(50),
  ESTADO varchar(50),
  TIME_AMP varchar(100),
  CANAL varchar(100),
  MOTIVO varchar(500),
  OBSERVACION TEXT,
  FECHA date DEFAULT CURDATE(),
  CORREO varchar(300),
  FECHANAC date,
  AFECCIONES varchar(500),
  ALERGIAS varchar(200)
);

DELIMITER $$
CREATE TRIGGER tr_generar BEFORE INSERT ON registro FOR EACH ROW BEGIN 
	DECLARE COD INT;
    SET COD = (SELECT IFNULL(MAX(CONVERT(SUBSTRING(ID_PACIENTE, 2,5), SIGNED INTEGER)), 0) FROM REGISTRO) + 1;
    SET NEW.ID_PACIENTE = CONCAT('P', LPAD(COD,5,'0'));
END
$$
DELIMITER ;

CREATE TABLE trabajo
(
  ID INT(11) PRIMARY KEY NOT NULL,
  ID_PACIENTE VARCHAR(10),
  TIP_TRAB varchar(200),
  SUB_TRAB varchar(200),
)

ALTER TABLE trabajo
ADD CONSTRAINT fk_trabajo_registro
FOREIGN KEY (ID_PACIENTE) REFERENCES registro(ID_PACIENTE);



/* COTIZACION *****************/

CREATE TABLE cotizacion (
  ID INT(11) PRIMARY KEY AUTO_INCREMENT,
  ID_PACIENTE VARCHAR(10),
  FECHA DATE,
  MONTO DECIMAL(10, 2),
  OBSERVACION TEXT,
  TIP_TRAB VARCHAR(80),
  SUB_TRAB VARCHAR(80),
  PESO INT(3),
  IGV BOOLEAN DEFAULT 0,
  CANTIDAD INT(2)
);

CREATE TABLE lista_cotizacion (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  ID_COTI INT,
  LISTA TEXT
);

ALTER TABLE lista_cotizacion
ADD CONSTRAINT fk_lista_cotizacion_cotizacion
FOREIGN KEY (ID_COTI) REFERENCES cotizacion(ID);



/* CONTRATOS *****************/

CREATE TABLE contratos( 
  ID INT PRIMARY KEY AUTO_INCREMENT,
  FECHA DATE,
  ID_PACIENTE VARCHAR(10),
  MONTO DECIMAL(10, 2),
  TIP_TRAB VARCHAR(80),
  SUB_TRAB VARCHAR(80),
  PDF LONGBLOB
);

CREATE TABLE base_historial
(
  ID INT PRIMARY KEY AUTO_INCREMENT,
  ID_PACIENTE VARCHAR(10),
  TIP_TRAB VARCHAR(80),
  SUB_TRAB VARCHAR(80),
  PROCESO BOOLEAN DEFAULT 1
)

DELIMITER $$
CREATE TRIGGER tr_insertbasehisto AFTER INSERT ON contratos FOR EACH ROW BEGIN

  DECLARE _ID_PACIENTE VARCHAR(80);
  DECLARE _TIP_TRAB VARCHAR(80);
  DECLARE _SUB_TRAB VARCHAR(80);

  SET _ID_PACIENTE = NEW.ID_PACIENTE;
  SET _TIP_TRAB = NEW.TIP_TRAB;
  SET _SUB_TRAB = NEW.SUB_TRAB;

  INSERT INTO base_historial (ID_PACIENTE, TIP_TRAB, SUB_TRAB) VALUES (_ID_PACIENTE, _TIP_TRAB, _SUB_TRAB);
END
$$
DELIMITER ;


/* PAGOS CONTRATOS *****************/
CREATE TABLE pagoscontrato (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  ID_CONTRATO INT,
  ID_PACIENTE VARCHAR(10),
  FECHA DATE DEFAULT CURDATE(),
  NPAGO VARCHAR(20),
  ABONO DECIMAL(10,2),
  TIP_PAGO VARCHAR(50),
  METODO VARCHAR(100),
  COMPROBANTE LONGBLOB,
  TIPO VARCHAR(10)
  PDF LONGBLOB
);


ALTER TABLE pagoscontrato
ADD CONSTRAINT fk_pagoscontrato_contratos
FOREIGN KEY (ID_CONTRATO) REFERENCES contratos(ID);


DELIMITER //
CREATE TRIGGER update_contrato_estado
AFTER INSERT ON pagoscontrato
FOR EACH ROW
BEGIN
    DECLARE total_abonos DECIMAL(10, 2);
    SELECT SUM(ABONO) INTO total_abonos
    FROM pagoscontrato
    WHERE ID_CONTRATO = NEW.ID_CONTRATO;

    IF total_abonos = (SELECT MONTO FROM contratos WHERE ID = NEW.ID_CONTRATO) THEN
        UPDATE contratos
        SET ESTADO = 1
        WHERE ID = NEW.ID_CONTRATO;
    ELSE
        UPDATE contratos
        SET ESTADO = 0
        WHERE ID = NEW.ID_CONTRATO;
    END IF;
END;
//
DELIMITER ;


DELIMITER //
CREATE TRIGGER update_contrato_estado_on_delete
AFTER DELETE ON pagoscontrato
FOR EACH ROW
BEGIN
    DECLARE total_abonos DECIMAL(10, 2);
    SELECT SUM(ABONO) INTO total_abonos
    FROM pagoscontrato
    WHERE ID_CONTRATO = OLD.ID_CONTRATO;

    IF total_abonos = (SELECT MONTO FROM contratos WHERE ID = OLD.ID_CONTRATO) THEN
        UPDATE contratos
        SET ESTADO = 1
        WHERE ID = OLD.ID_CONTRATO;
    ELSE
        UPDATE contratos
        SET ESTADO = 0
        WHERE ID = OLD.ID_CONTRATO;
    END IF;
END;
//
DELIMITER ;


/* HISTORIAL *****************/
CREATE TABLE historial 
(
  ID INT(11) PRIMARY KEY AUTO_INCREMENT,
  ID_BASE INT(11),
  ID_PACIENTE VARCHAR(10),
  FECHACITA DATE,
  DESCRIPCION TEXT,
  TECNICO VARCHAR(50),
  PROCESO BOOLEAN DEFAULT 1
)

CREATE TABLE historial_img
(
  ID INT(11) PRIMARY KEY AUTO_INCREMENT,
  ID_HISTORIAL INT(11),
  ID_PACIENTE VARCHAR(10),
  IMG LONGBLOB,
  TIPO VARCHAR(10),
  NOMBRES TEXT,
  PROCESO BOOLEAN
)

ALTER TABLE historial
ADD CONSTRAINT fk_historial_base_historial
FOREIGN KEY (ID_BASE) REFERENCES base_historial(ID);

ALTER TABLE historial_img
ADD CONSTRAINT fk_historial_img_historial
FOREIGN KEY (ID) REFERENCES historial(ID_HISTORIAL);


/* ACCESORIOS *****************/
CREATE TABLE detalle_pago
(
  ID INT(11) PRIMARY KEY AUTO_INCREMENT,
  ID_USER INT(11),
  ID_PACIENTE VARCHAR(10),
  DESCRIPCION TEXT,
  CANTIDAD DECIMAL(10,2),
  PRECIO_U DECIMAL(10,2),
  SUB_TOTAL DECIMAL(10,2)
)

CREATE TABLE pagos
(
  ID INT(11) PRIMARY KEY AUTO_INCREMENT,
  FECHA DATE,
  ID_PACIENTE VARCHAR(10),
  TIP_PAGO VARCHAR(50),
  PAGO VARCHAR(50),
  TOTAL DECIMAL(10,2),
  OBSERVACION TEXT,
  PDF LONGBLOB
)

/******** CAJA ADMINISTRATIVA *********/
CREATE TABLE ingreso
(
  IN_ID INT(11) PRIMARY KEY AUTO_INCREMENT,
  IN_FECHA DATE DEFAULT CURDATE(),
  IN_TRANSACCION VARCHAR(50),
  IN_COMPROBANTE VARCHAR(50),
  IN_NCOMPRO VARCHAR(50),
  IN_RESPONSABLE VARCHAR(200),
  IN_TIP_PAGO VARCHAR(50),
  IN_DESCRIPCION TEXT,
  IN_AREA VARCHAR(70),
  IN_MONTO DECIMAL(10,2),
);

CREATE TABLE salida
(
  SAL_ID INT(11) PRIMARY KEY AUTO_INCREMENT,
  SAL_FECHA DATE DEFAULT CURDATE(),
  SAL_TRANSACCION VARCHAR(50),
  SAL_COMPROBANTE VARCHAR(50),
  SAL_NCOMPRO VARCHAR(50),
  SAL_RESPONSABLE VARCHAR(200),
  SAL_TIP_PAGO VARCHAR(50),
  SAL_DESCRIPCION TEXT,
  SAL_AREA VARCHAR(70),
  SAL_MONTO DECIMAL(10,2),
);