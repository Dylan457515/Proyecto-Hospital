-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 28-06-2024 a las 02:52:42
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_sistema`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `PS_INTENTO_USUARIO` (IN `USUARIO` VARCHAR(50))   BEGIN
DECLARE CANTIDAD INT;

SET @INTENTO := (SELECT usu_intento FROM usuario WHERE usu_nombre = USUARIO);

IF @INTENTO = 2 THEN 
	SELECT @INTENTO;
ELSE
	UPDATE usuario SET
	usu_intento = @INTENTO + 1
	WHERE usu_nombre = USUARIO;
	SELECT @INTENTO;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PS_RESTABLECER_CONTRA` (IN `EMAIL` VARCHAR(255), IN `CONTRA` VARCHAR(255))   BEGIN 

DECLARE CANTIDAD INT;

SET @CANTIDAD := (SELECT COUNT(*) 
									FROM usuario
									WHERE usu_email = EMAIL);
if @CANTIDAD > 0 THEN
	UPDATE usuario SET 
		usu_contrasena = CONTRA,
		usu_intento = 0
		WHERE usu_email = EMAIL;
		SELECT 1;
ELSE
		SELECT 2;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_DATOS_CITAS_DE_DOCTORES` (IN `FECHA` DATE)   SELECT
	cita.medico_id, 
	
	COUNT(cita.cita_nroatencion)
FROM
	cita
WHERE cita.cita_feregistro = FECHA
	
GROUP BY medico_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_CITA` (IN `IDCITA` INT, IN `IDPACIENTE` INT, IN `IDESPECIALIDAD` INT, IN `IDDOCTOR` INT, IN `DESCRIPCION` TEXT, IN `ESTATUS` VARCHAR(10))   UPDATE cita SET
paciente_id = IDPACIENTE,
medico_id = IDDOCTOR,
especialidad_id = IDESPECIALIDAD,
cita_descripcion = DESCRIPCION,
cita_estatus = ESTATUS
WHERE cita_id = IDCITA$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GRAFICA_CITA` ()   SELECT
	COUNT(consulta.consulta_id) as cantidad, 
	consulta.consulta_feregistro
FROM
	consulta
WHERE consulta_estatus = 'ATENDIDA'
GROUP BY consulta_feregistro$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GRAFICA_INSUMO` ()   SELECT
	insumo.insumo_nombre, 
	insumo.insumo_stock
FROM
	insumo

WHERE insumo_estatus = 'ACTIVO'
GROUP BY insumo_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GRAFICA_MEDICAMENTO` ()   SELECT
	medicamento.medicamento_nombre, 
	medicamento.medicamento_stock
FROM
	medicamento
	
WHERE medicamento_estatus = 'ACTIVO'
GROUP BY medicamento_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CITA` ()   SELECT c.cita_id,
c.cita_nroatencion,
c.cita_feregistro,
c.cita_estatus,
p.paciente_id,
CONCAT_WS(' ',p.paciente_nombre,paciente_apepat,paciente_apemat) AS paciente,
c.medico_id,
CONCAT_WS(' ',m.medico_nombre,m.medico_apepat,m.medico_apemat) AS medico, 
e.especialidad_id, 
e.especialidad_nombre,
c.cita_descripcion
FROM cita as c 
INNER JOIN paciente AS p ON c.paciente_id = p.paciente_id
INNER JOIN medico AS m ON c.medico_id = m.medico_id
INNER JOIN especialidad as e ON e.especialidad_id = m.especialidad_id
ORDER BY cita_id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_ESPECIALIDAD` ()   SELECT * FROM especialidad WHERE especialidad_estatus = 'ACTIVO'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_INSUMO` ()   SELECT
	insumo.insumo_id, 
	insumo.insumo_nombre
FROM
	insumo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_MEDICAMENTO` ()   SELECT
	medicamento.medicamento_id, 
	medicamento.medicamento_nombre
FROM
	medicamento$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_PACIENTE` ()   SELECT paciente_id, concat_ws(' ', paciente_nombre,paciente_apepat,paciente_apemat) FROM paciente$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_PROCEDIMIENTO` ()   SELECT
	procedimiento.procedimiento_id, 
	procedimiento.procedimiento_nombre
FROM
	procedimiento$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CONSULTA` (IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE)   SELECT
	consulta.consulta_id, 
	consulta.consulta_descripcion, 
	consulta.consulta_diagnostico, 
	consulta.consulta_feregistro, 
	consulta.consulta_estatus, 
	cita.cita_id, 
	cita.cita_nroatencion, 
	cita.cita_feregistro, 
	cita.medico_id, 
	cita.especialidad_id, 
	cita.paciente_id, 
	cita.cita_estatus, 
	cita.cita_descripcion, 
	cita.usu_id, 
	CONCAT_WS(' ',paciente.paciente_nombre,paciente.paciente_apepat,paciente.paciente_apemat) AS paciente, 
	paciente.paciente_nrodocumento, 
	CONCAT_WS(' ',medico.medico_nombre,medico.medico_apepat,medico.medico_apemat) AS medico,
	especialidad.especialidad_nombre
FROM
	consulta
	INNER JOIN
	cita
	ON 
		consulta.cita_id = cita.cita_id
	INNER JOIN
	medico
	ON 
		cita.medico_id = medico.medico_id
	INNER JOIN
	paciente
	ON 
		cita.paciente_id = paciente.paciente_id
	INNER JOIN
	especialidad
	ON 
		cita.especialidad_id = especialidad.especialidad_id 
		
	WHERE consulta.consulta_feregistro BETWEEN FECHAINICIO and FECHAFIN$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CONSULTA_HISTORIAL` ()   SELECT
	consulta.consulta_id, 
	consulta.consulta_descripcion, 
	consulta.consulta_diagnostico,
	paciente.paciente_nrodocumento, 
	CONCAT_WS(' ',paciente.paciente_nombre,paciente.paciente_apepat,paciente.paciente_apemat) as paciente, 
	historia.historia_id, 
	consulta.consulta_feregistro
FROM
	consulta
	INNER JOIN
	cita
	ON 
		consulta.cita_id = cita.cita_id
	INNER JOIN
	paciente
	ON 
		cita.paciente_id = paciente.paciente_id
	INNER JOIN
	historia
	ON 
		paciente.paciente_id = historia.paciente_id
		
	WHERE consulta.consulta_feregistro = CURDATE()$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_DOCTOR_COMBO` (IN `ID` INT)   SELECT medico_id,CONCAT_WS(' ',medico_nombre,medico_apepat,medico_apemat)
FROM medico 
WHERE especialidad_id = ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ESPECIALIDAD` ()   SELECT * FROM especialidad$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ESPECIALIDAD_COMBO` ()   SELECT especialidad_id,especialidad_nombre FROM especialidad$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_HISTORIAL` (IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE)   SELECT
	fua.fua_id, 
	fua.fua_fregistro, 
	fua.historia_id, 
	fua.consulta_id, 
	consulta.consulta_diagnostico, 
	CONCAT_WS(' ',paciente.paciente_nombre,paciente.paciente_apepat,paciente.paciente_apemat) AS paciente, 
	paciente.paciente_nrodocumento, 
	CONCAT_WS(' ',medico.medico_nombre,medico.medico_apepat,medico.medico_apemat) AS medico
FROM
	fua
	INNER JOIN
	consulta
	ON 
		fua.consulta_id = consulta.consulta_id
	INNER JOIN
	cita
	ON 
		consulta.cita_id = cita.cita_id
	INNER JOIN
	paciente
	ON 
		cita.paciente_id = paciente.paciente_id
	INNER JOIN
	medico
	ON 
		cita.medico_id = medico.medico_id
		
	WHERE fua.fua_fregistro BETWEEN FECHAINICIO AND FECHAFIN$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_INSUMO` ()   SELECT * FROM insumo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_INSUMO_DETALLE` (IN `IDFUA` INT)   SELECT
	insumo.insumo_nombre, 
	detalle_insumo.detain_cantidad
FROM
	detalle_insumo
	INNER JOIN
	insumo
	ON 
		detalle_insumo.insumo_id = insumo.insumo_id
		
		WHERE detalle_insumo.fua_id = IDFUA$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_MEDICAMENTO` ()   SELECT * FROM medicamento$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_MEDICAMENTO_DETALLE` (IN `IDFUA` INT)   SELECT
	medicamento.medicamento_nombre, 
	detalle_medicamento.detame_catidad
FROM
	detalle_medicamento
	INNER JOIN
	medicamento
	ON 
		detalle_medicamento.medicamento_id = medicamento.medicamento_id
		
		WHERE detalle_medicamento.fua_id = IDFUA$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_MEDICO` ()   SELECT
	medico.medico_id, 
	medico.medico_nombre, 
	medico.medico_apepat, 
	medico.medico_apemat, 
	CONCAT_WS(' ',medico_nombre,medico_apepat,medico_apemat) AS medico, 
	medico.medico_direccion, 
	medico.medico_movil, 
	medico.medico_sexo, 
	medico.medico_fenac, 
	medico.medico_nrodocumento, 
	medico.medico_colegiatura, 
	medico.especialidad_id, 
	medico.usu_id, 
	especialidad.especialidad_nombre, 
	usuario.usu_nombre, 
	usuario.rol_id, 
	usuario.usu_email
FROM
	medico
	INNER JOIN
	especialidad
	ON 
		medico.especialidad_id = especialidad.especialidad_id
	INNER JOIN
	usuario
	ON 
		medico.usu_id = usuario.usu_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_PACIENTE` ()   SELECT
	CONCAT_WS(' ',paciente_nombre,paciente_apepat,paciente_apemat) as paciente,
	paciente.paciente_id, 
	paciente.paciente_nombre, 
	paciente.paciente_apepat, 
	paciente.paciente_apemat, 
	paciente.paciente_direccion, 
	paciente.paciente_movil, 
	paciente.paciente_sexo, 
	paciente.paciente_nrodocumento, 
	paciente.paciente_estatus
FROM
	paciente$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_PACIENTE_CITA` ()   SELECT
	cita.cita_id, 
	cita.cita_nroatencion,
	CONCAT_WS(' ',paciente.paciente_nombre,paciente.paciente_apepat,paciente.paciente_apemat) AS paciente
FROM
	cita
	INNER JOIN
	paciente
	ON 
		cita.paciente_id = paciente.paciente_id
		
WHERE cita_feregistro = CURDATE() and cita_estatus = 'PENDIENTE'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_PROCEDIMIENTO` ()   SELECT * FROM procedimiento$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_PROCEDIMIENTO_DETALLE` (IN `IDFUA` INT)   SELECT
	procedimiento.procedimiento_nombre
FROM
	detalle_procedimiento
	INNER JOIN
	procedimiento
	ON 
		detalle_procedimiento.procedimiento_id = procedimiento.procedimiento_id
		
		WHERE detalle_procedimiento.fua_id = IDFUA$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTA_COMBO_ROL` ()   SELECT
	rol.rol_id, 
	rol.rol_nombre
FROM
	rol$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTA_USUARIO` ()   BEGIN
	DECLARE CANTIDAD int;
	SET @CANTIDAD := 0;
SELECT
	@CANTIDAD := @CANTIDAD+1 as posicion,
	usuario.usu_id, 
	usuario.usu_nombre, 
	usuario.usu_sexo, 
	usuario.rol_id, 
	usuario.usu_estatus, 
	rol.rol_nombre,
	usuario.usu_email
FROM
	usuario
	INNER JOIN
	rol
	ON 
		usuario.rol_id = rol.rol_id;
		
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_CONSULTA` (IN `IDCONSULTA` INT, IN `DESCRIPCION` VARCHAR(255), IN `DIAGNOSTICO` VARCHAR(255))   UPDATE consulta SET

consulta_descripcion = DESCRIPCION,
consulta_diagnostico = DIAGNOSTICO

WHERE consulta_id = IDCONSULTA$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_CONTRA_USUARIO` (IN `IDUSUARIO` INT, IN `CONTRA` VARCHAR(250))   UPDATE usuario SET
usu_contrasena = CONTRA

WHERE usu_id = IDUSUARIO$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_DATOS_USUARIO` (IN `IDUSUARIO` INT, IN `SEXO` CHAR(1), IN `IDROL` INT, IN `EMAIL` VARCHAR(250))   UPDATE usuario SET
usu_sexo = SEXO,
rol_id = IDROL,
usu_email = EMAIL
WHERE usu_id = IDUSUARIO$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ESPECIALIDAD` (IN `ID` INT, IN `ESPECIALIDADACTUAL` VARCHAR(50), IN `ESPECIALIDADNUEVA` VARCHAR(50), IN `ESTATUS` VARCHAR(10))   BEGIN 
DECLARE CANTIDAD INT;
	IF ESPECIALIDADACTUAL = ESPECIALIDADNUEVA THEN
		UPDATE especialidad SET
		especialidad_estatus = ESTATUS
		WHERE especialidad_id = ID;
		SELECT 1;
	ELSE
		SET @CANTIDAD := (SELECT COUNT(*) FROM especialidad WHERE especialidad_nombre = ESPECIALIDADNUEVA);
		IF @CANTIDAD = 0 THEN
			UPDATE especialidad SET
			especialidad_nombre = ESPECIALIDADNUEVA,
		especialidad_estatus = ESTATUS
		WHERE especialidad_id = ID;
			SELECT 1;
		ELSE
		
			SELECT 2;
		
		
		END IF;
	END IF;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ESTATUS_USUARIO` (IN `IDUSUARIO` INT, IN `ESTATUS` VARCHAR(20))   UPDATE usuario SET
usu_estatus = ESTATUS
WHERE usu_id = IDUSUARIO$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_INSUMO` (IN `ID` INT, IN `INSUMOACTUAL` VARCHAR(50), IN `INSUMONUEVO` VARCHAR(50), IN `STOCK` INT, IN `ESTATUS` VARCHAR(10))   BEGIN

DECLARE CANTIDAD INT;


IF INSUMOACTUAL = INSUMONUEVO THEN
	UPDATE insumo SET
	insumo_stock = STOCK,
	insumo_estatus = ESTATUS
	
	WHERE insumo_id = ID;
	
	SELECT 1;
	
ELSE 

	SET @CANTIDAD := (SELECT COUNT(*) FROM insumo WHERE insumo_nombre = INSUMONUEVO);
	
	IF @CANTIDAD = 0 THEN
			UPDATE insumo SET
			insumo_nombre = INSUMONUEVO,
			insumo_stock = STOCK,
			insumo_estatus = ESTATUS
			
			WHERE insumo_id = ID;
			
			SELECT 1;
	
	ELSE
		SELECT 2;
	
	END IF;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_MEDICAMENTO` (IN `ID` INT, IN `MEDICAMENTOACTUAL` VARCHAR(50), IN `MEDICAMENTONUEVO` VARCHAR(50), IN `ALIAS` VARCHAR(50), IN `STOCK` INT, IN `ESTATUS` VARCHAR(10))   BEGIN

DECLARE CANTIDAD INT;


IF MEDICAMENTOACTUAL = MEDICAMENTONUEVO THEN

	UPDATE medicamento SET
	
	medicamento_alias = ALIAS,
	medicamento_stock = STOCK,
	medicamento_estatus = ESTATUS
	
	WHERE medicamento_id = ID;
		SELECT 1;
ELSE
	SET @CANTIDAD := (SELECT COUNT(*) FROM medicamento WHERE medicamento_nombre = MEDICAMENTONUEVO);
	
		IF @CANTIDAD = 0 THEN 
			UPDATE medicamento SET
					medicamento_nombre = MEDICAMENTONUEVO,
					medicamento_alias = ALIAS,
					medicamento_stock = STOCK,
					medicamento_estatus = ESTATUS
					
					WHERE medicamento_id = ID;
					SELECT 1;
		ELSE
			SELECT 2;
		END IF;

END IF;



END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_MEDICO` (IN `IDMEDICO` INT, `NOMBRE` VARCHAR(50), IN `APEPAT` VARCHAR(50), IN `APEMAT` VARCHAR(50), IN `DIRECCION` VARCHAR(200), IN `MOVIL` CHAR(12), IN `SEXO` CHAR(2), IN `FECHANACIMIENTO` DATE, IN `NRODOCUMENTOACTUAL` CHAR(12), IN `NRODOCUMENTONUEVO` CHAR(12), IN `COLEGIATURAACTUA` CHAR(12), IN `COLEGIATURANUEVO` CHAR(12), IN `ESPECIALIDAD` INT, IN `IDUSUARIO` INT, IN `EMAIL` VARCHAR(255))   BEGIN 

DECLARE CANTIDAD INT;



IF  NRODOCUMENTOACTUAL = NRODOCUMENTONUEVO OR COLEGIATURAACTUA = COLEGIATURANUEVO THEN

	UPDATE usuario SET
	
	usu_email = EMAIL,
	usu_sexo = SEXO
	
	WHERE usu_id = IDUSUARIO;
	
	UPDATE medico SET
	medico_nombre = NOMBRE,
	medico_apemat = APEPAT,
	medico_apemat = APEMAT,
	medico_direccion = DIRECCION,
	medico_movil = MOVIL,
	medico_sexo = SEXO,
	medico_fenac = FECHANACIMIENTO,
	medico_nrodocumento = NRODOCUMENTONUEVO,
	medico_colegiatura = COLEGIATURANUEVO,
	especialidad_id = ESPECIALIDAD
	
	WHERE medico_id = IDMEDICO;
	

	SELECT 1;


ELSE 

	SET @CANTIDAD := (SELECT COUNT(*) FROM medico WHERE medico_nrodocumento = NRODOCUMENTONUEVO OR medico_colegiatura = COLEGIATURANUEVO);
	
	IF @CANTIDAD = 0 THEN
		UPDATE usuario SET
	
		usu_email = EMAIL,
		usu_sexo = SEXO
	
		
		WHERE usu_id = IDUSUARIO;
		
		UPDATE medico SET
		medico_nombre = NOMBRE,
		medico_apemat = APEPAT,
		medico_apemat = APEMAT,
		medico_direccion = DIRECCION,
		medico_movil = MOVIL,
		medico_sexo = SEXO,
		medico_fenac = FECHANACIMIENTO,
		medico_nrodocumento = NRODOCUMENTONUEVO,
		medico_colegiatura = COLEGIATURANUEVO,
		especialidad_id = ESPECIALIDAD
		
		WHERE medico_id = IDMEDICO;
		

		SELECT 1;
	
	ELSE
		SELECT 2;
		
	END IF;
	
	

END IF;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_PACIENTE` (IN `ID` INT, IN `NOMBRE` VARCHAR(50), IN `APEPAT` VARCHAR(50), IN `APEMAT` VARCHAR(50), IN `DIRECCION` VARCHAR(200), IN `MOVIL` CHAR(12), IN `SEXO` CHAR(1), IN `DOCUMENTOACTUAL` CHAR(12), IN `DOCUMENTONUEVO` CHAR(12), IN `ESTATUS` CHAR(10))   BEGIN
DECLARE CANTIDAD INT;


	IF DOCUMENTOACTUAL = DOCUMENTONUEVO THEN 
		UPDATE paciente SET
		paciente_nombre = NOMBRE,
		paciente_apepat = APEPAT,
		paciente_apemat = APEMAT,
		paciente_direccion = DIRECCION,
		paciente_movil = MOVIL,
		paciente_sexo = SEXO,
		paciente_estatus = ESTATUS
		WHERE paciente_id = ID;
		SELECT 1;
	ELSE 
		SET @CANTIDAD := (SELECT COUNT(*) FROM paciente WHERE paciente_nrodocumento = DOCUMENTONUEVO);
		IF @CANTIDAD = 0 THEN
			
			UPDATE paciente SET
			paciente_nombre = NOMBRE,
			paciente_apepat = APEPAT,
			paciente_apemat = APEMAT,
			paciente_direccion = DIRECCION,
			paciente_movil = MOVIL,
			paciente_sexo = SEXO,
			paciente_nrodocumento = DOCUMENTONUEVO,
			paciente_estatus = ESTATUS
			WHERE paciente_id = ID;
			SELECT 1;
			
		ELSE
			SELECT 2;
		
		END IF;
		

		
	END IF;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_PROCEDIMIENTO` (IN `ID` INT, IN `PROCEDIMIENTOACTUAL` VARCHAR(50), IN `PROCEDIMIENTONUEVO` VARCHAR(50), IN `ESTATUS` VARCHAR(10))   BEGIN
	DECLARE CANTIDAD INT;
IF PROCEDIMIENTOACTUAL = PROCEDIMIENTONUEVO THEN
	UPDATE procedimiento SET
		procedimiento_estatus = ESTATUS
		WHERE procedimiento_id = ID;
		
		SELECT 1;
	
ELSE

	SET @CANTIDAD := (SELECT COUNT(*) FROM procedimiento WHERE procedimiento_nombre = PROCEDIMIENTONUEVO);
	IF @CANTIDAD = 0 THEN
	
		UPDATE procedimiento SET
		procedimiento_estatus = ESTATUS,
		procedimiento_nombre = PROCEDIMIENTONUEVO
		WHERE procedimiento_id = ID;
		
		SELECT 1;
		
	ELSE
		
		SELECT 2;
	
	END IF;

END IF;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_CITA` (IN `IDPACIENTE` INT, IN `IDESPECIALIDAD` INT, IN `IDDOCTOR` INT, IN `DESCRIPCION` TEXT, IN `IDUSUARIO` INT)   BEGIN
DECLARE NUMCITA INT;
SET @NUMCITA := (SELECT COUNT(*) + 1 
									FROM cita 
									WHERE cita_feregistro = CURDATE() AND especialidad_id = IDESPECIALIDAD);
INSERT INTO cita(cita_nroatencion,
									cita_feregistro,
									medico_id,
									especialidad_id,
									paciente_id,
									cita_estatus,
									cita_descripcion,
									usu_id) 
VALUES (@NUMCITA,
				CURDATE(),
				IDDOCTOR,
				IDESPECIALIDAD,
				IDPACIENTE,
				'PENDIENTE',
				DESCRIPCION,
				IDUSUARIO);

SELECT LAST_INSERT_ID();

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_CONSULTA` (IN `ID` INT, IN `DESCRIPCION` VARCHAR(255), IN `DIAGNOSTICO` VARCHAR(255))   BEGIN

INSERT INTO consulta(consulta_descripcion,consulta_diagnostico,consulta_feregistro,consulta_estatus,cita_id)VALUES(DESCRIPCION,DIAGNOSTICO,CURDATE(),'ATENDIDA',ID);




END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_DETALLE_INSUMO` (IN `IDFOA` INT, IN `IDINUSMO` INT, IN `CANTIDAD` INT)   INSERT INTO detalle_insumo(fua_id,insumo_id,detain_cantidad) VALUES (IDFOA,IDINUSMO,CANTIDAD)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_DETALLE_MEDICAMENTO` (IN `IDFUA` INT, IN `IDMEDICAMENTO` INT, IN `CANTIDAD` INT)   INSERT INTO detalle_medicamento(fua_id,medicamento_id,detame_catidad) VALUES (IDFUA,IDMEDICAMENTO,CANTIDAD)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_DETALLE_PROCEDIMIENTO` (IN `ID` INT, IN `IDPROCEDIMIENTO` INT)   INSERT INTO detalle_procedimiento(fua_id,procedimiento_id) VALUES(ID,IDPROCEDIMIENTO)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_ESPECIALIDAD` (IN `ESPECIALIDAD` VARCHAR(50), IN `ESTATUS` VARCHAR(10))   BEGIN

DECLARE CANTIDAD INT;
SET @CANTIDAD :=(SELECT COUNT(*) FROM especialidad WHERE especialidad_nombre = ESPECIALIDAD);
	IF @CANTIDAD = 0 THEN 
		INSERT INTO especialidad(especialidad_nombre,especialidad_fregistro,especialidad_estatus) VALUES (ESPECIALIDAD,CURDATE(),ESTATUS);
		SELECT 1;
	ELSE
		SELECT 2;
	END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_FUA` (IN `IDHISOTRIAL` INT, IN `IDCONSULTA` INT)   BEGIN

	INSERT INTO fua(fua_fregistro,historia_id,consulta_id) VALUES (CURDATE(),IDHISOTRIAL,IDCONSULTA);
	
	SELECT LAST_INSERT_ID();


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_INSUMO` (IN `INSUMO` VARCHAR(50), IN `STOCK` INT, `ESTATUS` VARCHAR(10))   BEGIN

DECLARE CANTIDAD INT;

SET @CANTIDAD := (SELECT COUNT(*) FROM insumo WHERE insumo_nombre = INSUMO );

IF @CANTIDAD = 0 THEN

	INSERT INTO insumo(insumo_nombre,insumo_stock,insumo_feregistro,insumo_estatus)
	VALUES(INSUMO,STOCK,CURDATE(),ESTATUS);
	
		SELECT 1;

ELSE

	SELECT 2;

END IF;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_MEDICAMENTO` (IN `MEDICAMENTO` VARCHAR(50), IN `ALIAS` VARCHAR(50), IN `STOCK` INT, IN `ESTATUS` VARCHAR(10))   BEGIN 

DECLARE CANTIDAD INT;

SET @CANTIDAD :=(SELECT COUNT(*) FROM medicamento WHERE medicamento_nombre = MEDICAMENTO );

	IF @CANTIDAD = 0 THEN
		INSERT INTO medicamento(medicamento_nombre,medicamento_alias,medicamento_stock,medicamento_fregistro,medicamento_estatus) VALUES(MEDICAMENTO,ALIAS,STOCK,CURDATE(),ESTATUS);
		SELECT 1;
		
	ELSE
	SELECT 2;
	
	
	END IF;




END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_MEDICO` (IN `NOMBRE` VARCHAR(50), IN `APEPAT` VARCHAR(50), IN `APEMAT` VARCHAR(50), IN `DIRECCION` VARCHAR(200), IN `MOVIL` CHAR(12), IN `SEXO` CHAR(2), IN `FECHANACIMIENTO` DATE, IN `NRODOCUMENTO` CHAR(12), IN `COLEGIATURA` CHAR(12), IN `ESPECIALIDAD` INT, IN `USUARIO` VARCHAR(20), IN `CONTRA` TEXT, IN `ROL` INT, IN `EMAIL` VARCHAR(255))   BEGIN
    DECLARE CANTIDADU INT;
    DECLARE CANTIDADME INT;

    SET CANTIDADU = (SELECT COUNT(*) FROM usuario WHERE usu_nombre = USUARIO);

    IF CANTIDADU = 0 THEN
        SET CANTIDADME = (SELECT COUNT(*) FROM medico WHERE medico_nrodocumento = NRODOCUMENTO OR medico_colegiatura = COLEGIATURA);

        IF CANTIDADME = 0 THEN
            INSERT INTO usuario(usu_nombre, usu_contrasena, usu_sexo, rol_id, usu_estatus, usu_email, usu_intento)
            VALUES(USUARIO, CONTRA, SEXO, ROL, 'ACTIVO', EMAIL, 0);

            INSERT INTO medico(medico_nombre, medico_apepat, medico_apemat, medico_direccion, medico_movil, medico_sexo, medico_fenac, medico_nrodocumento, medico_colegiatura, especialidad_id, usu_id)
            VALUES (NOMBRE, APEPAT, APEMAT, DIRECCION, MOVIL, SEXO, FECHANACIMIENTO, NRODOCUMENTO, COLEGIATURA, ESPECIALIDAD, (SELECT MAX(usu_id) FROM usuario));
						
						SELECT 1;
        ELSE 
            SELECT 2;
        END IF;
    ELSE 
        SELECT 2;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_PACIENTE` (IN `NOMBRE` VARCHAR(50), IN `APEPAT` VARCHAR(50), IN `APEMAT` VARCHAR(50), IN `DIRECCION` VARCHAR(200), IN `MOVIL` CHAR(12), IN `SEXO` CHAR(1), IN `NRODOCUMENTO` CHAR(12))   BEGIN
DECLARE CANTIDAD INT;

SET @CANTIDAD := (SELECT COUNT(*) FROM paciente WHERE paciente_nrodocumento = NRODOCUMENTO);

IF @CANTIDAD = 0 THEN 
	INSERT INTO paciente(paciente_nombre,paciente_apepat,paciente_apemat,paciente_direccion,paciente_movil,paciente_sexo,paciente_nrodocumento,paciente_estatus)VALUES(NOMBRE,APEPAT,APEMAT,DIRECCION,MOVIL,SEXO,NRODOCUMENTO,'ACTIVO');
	SELECT 1;
ELSE
	SELECT 2;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_PROCEDIMIENTO` (IN `PROCEDIMIENTO` VARCHAR(50), IN `ESTATUS` VARCHAR(10))   BEGIN

DECLARE CANTIDAD INT;

SET @CANTIDAD := (SELECT COUNT(*) FROM procedimiento WHERE procedimiento_nombre = PROCEDIMIENTO);

IF @CANTIDAD = 0 THEN

	INSERT INTO procedimiento(procedimiento_nombre,procedimiento_fecregistro,procedimiento_estatus)
	VALUES(PROCEDIMIENTO,CURDATE(),ESTATUS);
	SELECT 1;
	
ELSE

	SELECT 2;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_USUAIO` (IN `USU` VARCHAR(20), IN `CONTRA` VARCHAR(250), IN `SEXO` CHAR(1), IN `ROL` INT, IN `EMAIL` VARCHAR(250))   BEGIN
DECLARE CANTIDAD int;

SET @CANTIDAD := (SELECT COUNT(*) FROM usuario WHERE usu_nombre = BINARY USU);
if @CANTIDAD = 0 THEN
	INSERT INTO usuario(usu_nombre,usu_contrasena,usu_sexo,rol_id,usu_estatus,usu_email,usu_intento) VALUES(USU,CONTRA,SEXO,ROL,'ACTIVO',EMAIL,0);
	SELECT 1;
ELSE
	SELECT 2;
END if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TRAER_STOCK_INSUMO_H` (IN `ID` INT)   SELECT
	insumo.insumo_id,
	insumo.insumo_stock
FROM
	insumo
	
	WHERE insumo.insumo_id = ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TRAER_STOCK_MEDICAMENTO_H` (IN `ID` INT)   SELECT
	medicamento.medicamento_nombre, 
	medicamento.medicamento_stock

FROM
	medicamento
	
	WHERE medicamento.medicamento_id = ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_VERIFICAR_USUARIO` (IN `USUARIO` VARCHAR(20))   SELECT
	usuario.usu_id,
	usuario.usu_nombre, 
	usuario.usu_contrasena,  
	usuario.usu_sexo, 
	usuario.rol_id,
	usuario.usu_estatus,
	rol.rol_nombre,
	usuario.usu_intento
		


FROM
	usuario
	INNER JOIN
	rol
	ON 
		usuario.rol_id = rol.rol_id
		
WHERE usu_nombre = BINARY USUARIO$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `cita_id` int(11) NOT NULL,
  `cita_nroatencion` int(11) DEFAULT NULL,
  `cita_feregistro` date DEFAULT NULL,
  `medico_id` int(11) DEFAULT NULL,
  `especialidad_id` int(11) DEFAULT NULL,
  `paciente_id` int(11) DEFAULT NULL,
  `cita_estatus` enum('PENDIENTE','CANCELADA','ATENDIDA') NOT NULL,
  `cita_descripcion` text DEFAULT NULL,
  `usu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`cita_id`, `cita_nroatencion`, `cita_feregistro`, `medico_id`, `especialidad_id`, `paciente_id`, `cita_estatus`, `cita_descripcion`, `usu_id`) VALUES
(1, 1, '2024-06-10', 1, 4, 2, 'PENDIENTE', NULL, NULL),
(2, 1, '2024-06-11', 4, 1, 1, 'CANCELADA', 'vino por dolor en el vientre de su hijo', 1),
(3, 2, '2024-06-11', 4, 1, 1, 'PENDIENTE', 'adwadwad', 1),
(4, 3, '2024-06-11', 1, 4, 1, 'PENDIENTE', 'Cita a prye', 1),
(5, 4, '2024-06-14', 2, 6, 1, 'ATENDIDA', 'prueba de imprimir', 1),
(6, 1, '2024-06-12', 1, 4, 1, 'PENDIENTE', 'sadwa', 1),
(7, 1, '2024-06-12', 2, 6, 1, 'ATENDIDA', 'd', 1),
(8, 1, '2024-06-12', 3, 5, 1, 'PENDIENTE', 'dia', 1),
(9, 1, '2024-06-12', 4, 1, 1, 'ATENDIDA', 'noche', 1),
(10, 2, '2024-06-12', 4, 1, 1, 'PENDIENTE', 'jue', 1),
(11, 3, '2024-06-12', 6, 1, 1, 'PENDIENTE', 'us', 1),
(12, 2, '2024-06-12', 1, 3, 2, 'ATENDIDA', 'asdawdwa', 1),
(13, 1, '2024-06-12', 1, 3, 2, 'PENDIENTE', 'sedfesf', 1),
(14, 4, '2024-06-12', 4, 1, 1, 'PENDIENTE', 'asdwadgfdsfdsfafrdfsfeasdfesad', 1),
(15, 5, '2024-06-12', 4, 1, 1, 'ATENDIDA', 'asdwadgfdsfdsfafrdfsfeasdfesadffdsdfsdfdfsfsddfsadsf', 1),
(16, 1, '2024-06-14', 1, 3, 1, 'ATENDIDA', 'po 2', 1),
(17, 1, '2024-06-14', 2, 6, 1, 'ATENDIDA', 'dolor de estomago y del pie', 11),
(18, 1, '2024-06-17', 3, 5, 2, 'ATENDIDA', 'pihg', 1),
(19, 1, '2024-06-19', 3, 5, 1, 'ATENDIDA', 'alergia', 1),
(20, 1, '2024-06-20', 1, 3, 3, 'ATENDIDA', 'Problemas del corazón ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `consulta_id` int(11) NOT NULL,
  `consulta_descripcion` text DEFAULT NULL,
  `consulta_diagnostico` text DEFAULT NULL,
  `consulta_feregistro` date DEFAULT NULL,
  `consulta_estatus` enum('ATENDIDA','PENDIENTE') DEFAULT NULL,
  `cita_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`consulta_id`, `consulta_descripcion`, `consulta_diagnostico`, `consulta_feregistro`, `consulta_estatus`, `cita_id`) VALUES
(1, 'prueba si', 'sLa importancia radica en su capacidad para agrupar la información vital que guía al profesional o al equipo médico durante el proceso diagnóstico y terapéutico. Este documento es esencial no solo para el cuidado directo del enfermo, sino también para la investigación médica y la post educación, asegurando una comprensión integral de la condición del paciente. Además permite dejar toda la información por escrito para futuras revisiones incluso por otros profesionales.', '2024-06-12', 'ATENDIDA', 1),
(3, 'FGHTTGTRGVSST', 'ERVFFVDFVGG', '2024-06-14', 'ATENDIDA', 12),
(4, 'medio muesrt', 'eutanacia', '2024-06-14', 'ATENDIDA', 16),
(5, 'n', 'k', '2024-06-14', 'ATENDIDA', 17),
(6, 'kbv', 'ñljñ', '2024-06-17', 'PENDIENTE', 18),
(7, 'casi muerto', 'diabetes', '2024-06-19', 'ATENDIDA', 19),
(8, 'Avanzado', 'Sufre sin dolor ', '2024-06-24', 'ATENDIDA', 20),
(9, 'gh', 'k', '2024-06-19', 'ATENDIDA', 4),
(10, 'bv', 'g', '2024-06-25', 'PENDIENTE', 7);

--
-- Disparadores `consulta`
--
DELIMITER $$
CREATE TRIGGER `TR_STATUS_CITA_CONSULTA` BEFORE INSERT ON `consulta` FOR EACH ROW UPDATE cita SET
cita_estatus = 'ATENDIDA' 
WHERE cita_id = new.cita_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_insumo`
--

CREATE TABLE `detalle_insumo` (
  `detain_id` int(11) NOT NULL,
  `detain_cantidad` int(11) DEFAULT NULL,
  `insumo_id` int(11) DEFAULT NULL,
  `fua_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `detalle_insumo`
--

INSERT INTO `detalle_insumo` (`detain_id`, `detain_cantidad`, `insumo_id`, `fua_id`) VALUES
(1, 1, 1, 1),
(2, 4, 1, 6),
(3, 3, 1, 7),
(4, 1, 1, 8),
(5, 1, 1, 11),
(6, 3, 4, 11),
(7, 3, 4, 12),
(8, 3, 4, 13),
(9, 1, 3, 14),
(10, 1, 4, 15),
(11, 3, 6, 15);

--
-- Disparadores `detalle_insumo`
--
DELIMITER $$
CREATE TRIGGER `TR_STOCK_INSUMO` BEFORE INSERT ON `detalle_insumo` FOR EACH ROW BEGIN

DECLARE STOCKACTUAL DECIMAL(10,2);
SET @STOCKACTUAL := (SELECT insumo_stock FROM insumo WHERE insumo_id = new.insumo_id);

UPDATE insumo SET
insumo_stock = @STOCKACTUAL - new.detain_cantidad
WHERE insumo_id = new.insumo_id;


END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_medicamento`
--

CREATE TABLE `detalle_medicamento` (
  `detami_id` int(11) NOT NULL,
  `fua_id` int(11) DEFAULT NULL,
  `medicamento_id` int(11) DEFAULT NULL,
  `detame_catidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `detalle_medicamento`
--

INSERT INTO `detalle_medicamento` (`detami_id`, `fua_id`, `medicamento_id`, `detame_catidad`) VALUES
(1, 4, 1, 12),
(2, 5, 1, 32),
(3, 6, 1, 7),
(4, 7, 1, 1),
(5, 9, 4, 2),
(6, 10, 4, 3),
(7, 10, 5, 6),
(8, 12, 5, 5),
(9, 12, 2, 7),
(10, 13, 1, 1),
(11, 13, 5, 3),
(12, 14, 4, 5),
(13, 15, 2, 7),
(14, 16, 1, 3);

--
-- Disparadores `detalle_medicamento`
--
DELIMITER $$
CREATE TRIGGER `TR_STOCK_MEDICAMENTO` BEFORE INSERT ON `detalle_medicamento` FOR EACH ROW BEGIN

DECLARE STOCKACTUAL DECIMAL(10,2);
SET @STOCKACTUAL := (SELECT medicamento_stock FROM medicamento WHERE medicamento_id = new.medicamento_id);

UPDATE medicamento SET
medicamento_stock = @STOCKACTUAL - new.detame_catidad
WHERE medicamento_id = new.medicamento_id;


END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_procedimiento`
--

CREATE TABLE `detalle_procedimiento` (
  `detaproce_id` int(11) NOT NULL,
  `procedimiento_id` int(11) DEFAULT NULL,
  `fua_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `detalle_procedimiento`
--

INSERT INTO `detalle_procedimiento` (`detaproce_id`, `procedimiento_id`, `fua_id`) VALUES
(1, 1, 6),
(2, 4, 6),
(3, 5, 7),
(4, 3, 11),
(5, 9, 12),
(6, 6, 13),
(7, 4, 14),
(8, 3, 14),
(9, 4, 15),
(10, 2, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `especialidad_id` int(11) NOT NULL,
  `especialidad_nombre` varchar(50) DEFAULT NULL,
  `especialidad_fregistro` date DEFAULT NULL,
  `especialidad_estatus` enum('ACTIVO','INACTIVO') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`especialidad_id`, `especialidad_nombre`, `especialidad_fregistro`, `especialidad_estatus`) VALUES
(1, 'Alergología', '2024-04-09', 'ACTIVO'),
(2, 'Anestesiología ', '2024-05-14', 'INACTIVO'),
(3, 'Cardiología', '2024-06-05', 'ACTIVO'),
(4, 'Dermatología', '2024-06-05', 'INACTIVO'),
(5, 'Endocrinología', '2024-06-05', 'ACTIVO'),
(6, 'Gastroenterología', '2024-06-05', 'ACTIVO'),
(7, 'Partologia', '2024-06-14', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fua`
--

CREATE TABLE `fua` (
  `fua_id` int(11) NOT NULL,
  `fua_fregistro` date DEFAULT NULL,
  `historia_id` int(11) DEFAULT NULL,
  `consulta_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `fua`
--

INSERT INTO `fua` (`fua_id`, `fua_fregistro`, `historia_id`, `consulta_id`) VALUES
(1, '2024-06-14', 1, 4),
(2, '2024-06-14', 2, 3),
(3, '2024-06-14', 1, 4),
(4, '2024-06-14', 1, 4),
(5, '2024-06-14', 1, 4),
(6, '2024-06-14', 1, 5),
(7, '2024-06-14', 1, 5),
(8, '2024-06-14', 1, 5),
(9, '2024-06-14', 2, 3),
(10, '2024-06-15', 1, 5),
(11, '2024-06-17', 2, 6),
(12, '2024-06-19', 1, 7),
(13, '2024-06-20', 3, 8),
(14, '2024-06-20', 3, 8),
(15, '2024-06-20', 3, 8),
(16, '2024-06-24', 3, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia`
--

CREATE TABLE `historia` (
  `historia_id` int(11) NOT NULL,
  `paciente_id` int(11) DEFAULT NULL,
  `historia_feregistro` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `historia`
--

INSERT INTO `historia` (`historia_id`, `paciente_id`, `historia_feregistro`) VALUES
(1, 1, '2024-06-10 00:00:00.000000'),
(2, 2, '2024-06-10 00:00:00.000000'),
(3, 3, '2024-06-20 00:00:00.000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

CREATE TABLE `insumo` (
  `insumo_id` int(11) NOT NULL,
  `insumo_nombre` varchar(50) DEFAULT NULL,
  `insumo_stock` int(11) DEFAULT NULL,
  `insumo_feregistro` date DEFAULT NULL,
  `insumo_estatus` enum('ACTIVO','INACTIVO','AGOTADO') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` (`insumo_id`, `insumo_nombre`, `insumo_stock`, `insumo_feregistro`, `insumo_estatus`) VALUES
(1, 'Guantes', 0, '2024-05-08', 'ACTIVO'),
(2, 'Jeringas', 0, '2024-05-29', 'AGOTADO'),
(3, 'Agujas', 1, '2024-03-20', 'INACTIVO'),
(4, 'Pinza', 2, '2024-06-03', 'ACTIVO'),
(5, 'Mascarillas', 54, '2024-06-03', 'ACTIVO'),
(6, 'Gasas', 29, '2024-06-03', 'ACTIVO'),
(7, 'Suturas de acero', 34, '2024-06-03', 'ACTIVO'),
(8, 'sadw', 3, '2024-06-05', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento`
--

CREATE TABLE `medicamento` (
  `medicamento_id` int(11) NOT NULL,
  `medicamento_nombre` varchar(50) DEFAULT NULL,
  `medicamento_alias` varchar(50) DEFAULT NULL,
  `medicamento_stock` int(11) DEFAULT NULL,
  `medicamento_fregistro` date DEFAULT NULL,
  `medicamento_estatus` enum('ACTIVO','INACTIVO','AGOTADO') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `medicamento`
--

INSERT INTO `medicamento` (`medicamento_id`, `medicamento_nombre`, `medicamento_alias`, `medicamento_stock`, `medicamento_fregistro`, `medicamento_estatus`) VALUES
(1, 'Paracetamol', 'Efferalgan', 46, '2024-05-21', 'ACTIVO'),
(2, 'Ibuprofeno', 'Advil', 18, '2024-06-05', 'INACTIVO'),
(3, 'Amoxicilina', 'Amoxil', 0, '2024-05-20', 'AGOTADO'),
(4, 'Simvastatina', 'Zocor', 10, '2024-06-05', 'ACTIVO'),
(5, 'Metformina', 'Glucophage', 18, '2024-06-05', 'INACTIVO'),
(6, 'asdfs', 'd', 1, '2024-06-05', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE `medico` (
  `medico_id` int(11) NOT NULL,
  `medico_nombre` varchar(50) DEFAULT NULL,
  `medico_apepat` varchar(50) DEFAULT NULL,
  `medico_apemat` varchar(50) DEFAULT NULL,
  `medico_direccion` varchar(200) DEFAULT NULL,
  `medico_movil` char(12) DEFAULT NULL,
  `medico_sexo` char(1) DEFAULT NULL,
  `medico_fenac` date DEFAULT NULL,
  `medico_nrodocumento` char(12) DEFAULT NULL,
  `medico_colegiatura` char(12) DEFAULT NULL,
  `especialidad_id` int(11) DEFAULT NULL,
  `usu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`medico_id`, `medico_nombre`, `medico_apepat`, `medico_apemat`, `medico_direccion`, `medico_movil`, `medico_sexo`, `medico_fenac`, `medico_nrodocumento`, `medico_colegiatura`, `especialidad_id`, `usu_id`) VALUES
(1, 'Dylan', 'Quispe', 'Huallpa', 'zenkata', '12345645', 'M', '2004-05-13', '315616646', '13546', 3, 1),
(2, 'DylanQ', 'Quispe', 'Huallpa', 'Dasjkh', '654163231', 'M', '2024-06-15', '22363', '32', 6, 6),
(3, 'asd', 'avs', 'dwad', 'dasd', '13221', 'F', '2024-05-28', '165163', '324', 5, 7),
(4, 'abc', 'asdw', 'addw', 'cxedsa', '123156', 'M', '2024-05-29', '4444', '444222', 1, 8),
(5, 'wsadasd', 'dwadsa', 'wsadwasd', 'dwadxaasd', '213', 'M', '2024-05-28', '34534534', '32454365', 3, 9),
(6, 'Dylanqwewq', 'Quispe', 'asdaw', 'asdef rsd', '21324', 'M', '2024-06-12', '3243254', '3244', 1, 10),
(7, 'Marcos', 'Ramos', 'Quisbert', 'AVSubteniente Burgos', '65160863', 'M', '2004-04-14', '20', '5', 1, 11),
(8, 'Lorna ', 'Huasco', 'Aruquipa', 'jbsdnmlqkmx', '256545644521', 'M', '2024-06-10', '154655843432', '155', 1, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `paciente_id` int(11) NOT NULL,
  `paciente_nombre` varchar(50) DEFAULT NULL,
  `paciente_apepat` varchar(50) DEFAULT NULL,
  `paciente_apemat` varchar(50) DEFAULT NULL,
  `paciente_direccion` varchar(200) DEFAULT NULL,
  `paciente_movil` char(12) DEFAULT NULL,
  `paciente_sexo` char(1) DEFAULT NULL,
  `paciente_nrodocumento` char(12) DEFAULT NULL,
  `paciente_estatus` enum('ACTIVO','INACTIVO') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`paciente_id`, `paciente_nombre`, `paciente_apepat`, `paciente_apemat`, `paciente_direccion`, `paciente_movil`, `paciente_sexo`, `paciente_nrodocumento`, `paciente_estatus`) VALUES
(1, 'Dylan', 'Quispe', 'Huallpa', 'tablada', '123456789', 'M', '9244732', 'ACTIVO'),
(2, 'cod', 'Monter', 'dsfsdgcat', 'buenos', '123456789', 'F', '123456485', 'INACTIVO'),
(3, 'Marcos ', 'Ramos ', 'Huayhua ', 'Av.sub teniente ', '78301932', 'M', '12', 'INACTIVO');

--
-- Disparadores `paciente`
--
DELIMITER $$
CREATE TRIGGER `TR_CREAR_HISTORIA` AFTER INSERT ON `paciente` FOR EACH ROW INSERT INTO 
historia(paciente_id,historia_feregistro)
VALUES (new.paciente_id,curdate())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimiento`
--

CREATE TABLE `procedimiento` (
  `procedimiento_id` int(11) NOT NULL,
  `procedimiento_nombre` varchar(50) DEFAULT NULL,
  `procedimiento_fecregistro` date DEFAULT NULL,
  `procedimiento_estatus` enum('ACTIVO','INACTIVO') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `procedimiento`
--

INSERT INTO `procedimiento` (`procedimiento_id`, `procedimiento_nombre`, `procedimiento_fecregistro`, `procedimiento_estatus`) VALUES
(1, 'Biopsia', '2024-05-17', 'ACTIVO'),
(2, 'Gammagrafía', '2024-06-10', 'ACTIVO'),
(3, 'Análisis de sangre', '2024-06-14', 'ACTIVO'),
(4, 'Radiografía', '2024-05-15', 'ACTIVO'),
(5, 'TAC', '2024-03-19', 'ACTIVO'),
(6, 'Radiografía', '2024-06-02', 'INACTIVO'),
(7, 'Electrocauterización', '2024-06-02', 'ACTIVO'),
(8, 'Escisión de lipomas', '2024-06-02', 'ACTIVO'),
(9, 'Lavado de oído', '2024-06-02', 'ACTIVO'),
(10, 'Extracción de lunares', '2024-06-02', 'ACTIVO'),
(11, 'Extracción de verrugas', '2024-06-02', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `rol_id` int(11) NOT NULL,
  `rol_nombre` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`rol_id`, `rol_nombre`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'RECEPCIONISTA'),
(3, 'MEDICO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usu_id` int(11) NOT NULL,
  `usu_nombre` varchar(20) DEFAULT NULL,
  `usu_contrasena` varchar(255) DEFAULT NULL,
  `usu_sexo` char(1) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `usu_estatus` enum('ACTIVO','INACTIVO') DEFAULT NULL,
  `usu_email` varchar(255) DEFAULT NULL,
  `usu_intento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usu_id`, `usu_nombre`, `usu_contrasena`, `usu_sexo`, `rol_id`, `usu_estatus`, `usu_email`, `usu_intento`) VALUES
(1, 'Dylan', '$2y$10$lCsJS4PO8DH7T93HbhSmreGmab0/rnYg8LunxFru67DeX1zQuB3pK', 'M', 1, 'ACTIVO', 'dylan45751@gmail.com', 0),
(2, 'prueba', '$2y$10$VQ9QR7WiOAfPqvCj5VIxcO6.BVwf0nLPoP7limJd.iBz9hNIGpaR2', 'F', 2, 'ACTIVO', 'Charly3452@gmail.com', 0),
(3, 'DylanQ', '$2y$10$XYYHBuKU8yjYGV7aLVf2POnNR59rTxyL5wC4uNozaMyO9/iXdmO8a', 'F', 3, 'ACTIVO', 'dylan.estudia.13@gmail.com', 0),
(4, 'Dylan13', '$2y$10$0u.Ivfzefszq4mpvJoF89uRHsK7Y/VAb3KawiXUMV2SMJXfNKkrDK', 'M', 1, 'INACTIVO', 'Dylan313@gmail.com', 0),
(5, 'Marcos', '$2y$10$lCsJS4PO8DH7T93HbhSmreGmab0/rnYg8LunxFru67DeX1zQuB3pK', 'M', 1, 'ACTIVO', 'ramosquibert@gmail.com', 1),
(6, 'Dylan45751', '$2y$10$vceGxkDDmCGwRMkrAtX87.gZ23XJLVVJXjTdnczFQMrvHL04R3tTi', 'M', 1, 'INACTIVO', 's@gmail.com', 0),
(7, 'Das', '$2y$10$I4wtvygFdMLFXSuA7UxC2.bXH0z92Zre17W6ieYEjzFeI1dvM0BA6', 'F', 2, 'ACTIVO', 'seaf@gmail.com', 0),
(8, 'Dylan5', '$2y$10$jFIxMa4qwCzBYRx1vQpxP.O7ysYGn6zDtbEZgP0xa0wrAz/FC2zUu', 'M', 1, 'ACTIVO', 'Dylan13@gmail.com', 0),
(9, 'adwsad', '$2y$10$9yk8GMyjBZUXX.g5/p7Fm.6awy6cK8irA.LccMhPLjL/XtiieG63i', 'M', 3, 'ACTIVO', 'fasd@gmail.com', 0),
(10, 'Dylan1343', '$2y$10$Qp0a.A24sOwG8Xs8bll.qezeF74dr8V4cVj4peGUvwWF3Lix282k.', 'M', 3, 'ACTIVO', 'dylan45751asdaw@gmail.com', 0),
(11, 'marquitos', '$2y$10$IMDaAj3ca047xXEPR1en9Oaoj/2qyS7Zz5B7uieGQccBBcIjukF2q', 'M', 3, 'ACTIVO', 'ramosquibert@gmail.com', 0),
(12, '21435', '$2y$10$uo4xnTn.vJ22Wo5neeWUI.7SVn.mV/HuEbzwKXMkm6iqqiyXhw8PC', 'F', 1, 'ACTIVO', 'sdfre234@gmail.com', 0),
(13, 'lhuasco', '$2y$10$oR0CDuSRC/wFuTg1jOip6OUJclAlfqyJV3gvUUG/C3ES.gwmufQrS', 'M', 3, 'ACTIVO', 'lhuasco@gmail.com', 0),
(14, 'laruquipa', '$2y$10$XSTIkpV2PyIZdRXq.OjkW.60pxb3WZkoJ43dyilvz0q62J6egKcQC', 'F', 1, 'ACTIVO', 'lhuascoaruquipa@gmail.com', 0),
(15, 'Gabito', '$2y$10$8bkV4A3vn7ZPmizGDeYrAuDICtrTmTEIg6ooBzneStNN1kCJY8Ek.', 'M', 3, 'ACTIVO', 'gabrielgarciahuayhua2003@gmail.com', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`cita_id`) USING BTREE,
  ADD KEY `paciente_id` (`paciente_id`) USING BTREE,
  ADD KEY `medico_id` (`medico_id`) USING BTREE,
  ADD KEY `espcialidad_id` (`especialidad_id`),
  ADD KEY `usu_id` (`usu_id`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`consulta_id`) USING BTREE,
  ADD KEY `cita_id` (`cita_id`) USING BTREE;

--
-- Indices de la tabla `detalle_insumo`
--
ALTER TABLE `detalle_insumo`
  ADD PRIMARY KEY (`detain_id`) USING BTREE,
  ADD KEY `fua_id` (`fua_id`) USING BTREE,
  ADD KEY `insumo_id` (`insumo_id`) USING BTREE;

--
-- Indices de la tabla `detalle_medicamento`
--
ALTER TABLE `detalle_medicamento`
  ADD PRIMARY KEY (`detami_id`) USING BTREE,
  ADD KEY `fua_id` (`fua_id`) USING BTREE,
  ADD KEY `medicamento_id` (`medicamento_id`) USING BTREE;

--
-- Indices de la tabla `detalle_procedimiento`
--
ALTER TABLE `detalle_procedimiento`
  ADD PRIMARY KEY (`detaproce_id`) USING BTREE,
  ADD KEY `procedimiento_id` (`procedimiento_id`) USING BTREE,
  ADD KEY `fua_id` (`fua_id`) USING BTREE;

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`especialidad_id`) USING BTREE;

--
-- Indices de la tabla `fua`
--
ALTER TABLE `fua`
  ADD PRIMARY KEY (`fua_id`) USING BTREE,
  ADD KEY `historia_id` (`historia_id`) USING BTREE,
  ADD KEY `consulta_id` (`consulta_id`) USING BTREE;

--
-- Indices de la tabla `historia`
--
ALTER TABLE `historia`
  ADD PRIMARY KEY (`historia_id`) USING BTREE,
  ADD KEY `paciente_id` (`paciente_id`) USING BTREE;

--
-- Indices de la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`insumo_id`) USING BTREE;

--
-- Indices de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD PRIMARY KEY (`medicamento_id`) USING BTREE;

--
-- Indices de la tabla `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`medico_id`) USING BTREE,
  ADD KEY `usu_id` (`usu_id`) USING BTREE,
  ADD KEY `especialidad_id` (`especialidad_id`) USING BTREE;

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`paciente_id`) USING BTREE;

--
-- Indices de la tabla `procedimiento`
--
ALTER TABLE `procedimiento`
  ADD PRIMARY KEY (`procedimiento_id`) USING BTREE;

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`rol_id`) USING BTREE;

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_id`) USING BTREE,
  ADD KEY `rol_id` (`rol_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `cita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `consulta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalle_insumo`
--
ALTER TABLE `detalle_insumo`
  MODIFY `detain_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `detalle_medicamento`
--
ALTER TABLE `detalle_medicamento`
  MODIFY `detami_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `detalle_procedimiento`
--
ALTER TABLE `detalle_procedimiento`
  MODIFY `detaproce_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `especialidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `fua`
--
ALTER TABLE `fua`
  MODIFY `fua_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `historia`
--
ALTER TABLE `historia`
  MODIFY `historia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `insumo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `medicamento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `medico_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `paciente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `procedimiento`
--
ALTER TABLE `procedimiento`
  MODIFY `procedimiento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`),
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`),
  ADD CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`),
  ADD CONSTRAINT `cita_ibfk_4` FOREIGN KEY (`usu_id`) REFERENCES `usuario` (`usu_id`);

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`);

--
-- Filtros para la tabla `detalle_insumo`
--
ALTER TABLE `detalle_insumo`
  ADD CONSTRAINT `detalle_insumo_ibfk_1` FOREIGN KEY (`fua_id`) REFERENCES `fua` (`fua_id`),
  ADD CONSTRAINT `detalle_insumo_ibfk_2` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`insumo_id`);

--
-- Filtros para la tabla `detalle_medicamento`
--
ALTER TABLE `detalle_medicamento`
  ADD CONSTRAINT `detalle_medicamento_ibfk_1` FOREIGN KEY (`fua_id`) REFERENCES `fua` (`fua_id`),
  ADD CONSTRAINT `detalle_medicamento_ibfk_2` FOREIGN KEY (`medicamento_id`) REFERENCES `medicamento` (`medicamento_id`);

--
-- Filtros para la tabla `detalle_procedimiento`
--
ALTER TABLE `detalle_procedimiento`
  ADD CONSTRAINT `detalle_procedimiento_ibfk_1` FOREIGN KEY (`procedimiento_id`) REFERENCES `procedimiento` (`procedimiento_id`),
  ADD CONSTRAINT `detalle_procedimiento_ibfk_2` FOREIGN KEY (`fua_id`) REFERENCES `fua` (`fua_id`);

--
-- Filtros para la tabla `fua`
--
ALTER TABLE `fua`
  ADD CONSTRAINT `fua_ibfk_1` FOREIGN KEY (`historia_id`) REFERENCES `historia` (`historia_id`),
  ADD CONSTRAINT `fua_ibfk_2` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`);

--
-- Filtros para la tabla `historia`
--
ALTER TABLE `historia`
  ADD CONSTRAINT `historia_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`);

--
-- Filtros para la tabla `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `medico_ibfk_1` FOREIGN KEY (`usu_id`) REFERENCES `usuario` (`usu_id`),
  ADD CONSTRAINT `medico_ibfk_2` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`rol_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
