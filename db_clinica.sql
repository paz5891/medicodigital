-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2021 a las 10:24:02
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_clinica`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizar_citas` (IN `idcitac` INT, IN `idseguroc` INT, IN `idmedicoc` INT, IN `tipocitac` VARCHAR(50), IN `pacienteovisitadorc` VARCHAR(250), IN `visitadorc` VARCHAR(100), IN `asuntoc` VARCHAR(500), IN `telefonoc` VARCHAR(10), IN `fechac` DATE, IN `horac` VARCHAR(50), IN `estadocitac` VARCHAR(50))  BEGIN

set @lastrow1 := (concat(idmedicoc,' ', fechac,' ', horac));


UPDATE cita SET idseguro=idseguroc, idmedico=idmedicoc, tipocita=tipocitac, pacienteovisitador=pacienteovisitadorc, visitador=visitadorc, asunto = asuntoc, telefono=telefonoc, fecha=fechac, hora=horac, estadocita=estadocitac, horariocitaunica= @lastrow1  WHERE idcita=idcitac;


end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_referencias` ()  SELECT ref.idreferencia, ref.idpaciente, concat(p.nombre,' ', p.apellido) as paciente, ref.idmedico, concat(med.nombre, ' ',med.apellido) as medico, ref.institucion, ref.motivo, DATE_FORMAT(ref.fecha, '%d/%m/%Y') as fecha, ref.condicion FROM referencia ref INNER JOIN paciente p on ref.idpaciente = p.idpaciente
INNER JOIN medico med on med.idmedico = ref.idmedico$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modificar_contra_usuario` (IN `idusu` INT, IN `contra` VARCHAR(250))  UPDATE usuario SET
clave = contra
WHERE idusuario = idusu$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registrar_citas` (IN `idseguroc` INT, IN `idmedicoc` INT, IN `tipocitac` VARCHAR(50), IN `pacienteovisitadorc` VARCHAR(250), IN `visitadorc` VARCHAR(100), IN `asuntoc` VARCHAR(500), IN `telefonoc` VARCHAR(10), IN `fechac` DATE, IN `horac` VARCHAR(50), IN `estadocitac` VARCHAR(50))  BEGIN

set @lastrow1 := (concat(idmedicoc,' ', fechac,' ', horac));
INSERT INTO `cita`(`idseguro`, `idmedico`, `tipocita`, `pacienteovisitador`, `visitador`, `asunto`, `telefono`, `fecha`, `hora`, `estadocita`, `horariocitaunica`) VALUES (idseguroc,idmedicoc,tipocitac,pacienteovisitadorc,visitadorc,asuntoc,telefonoc,fechac,horac,estadocitac, @lastrow1);

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_restablecer_contra` (IN `correo` VARCHAR(255), IN `contra` VARCHAR(255))  BEGIN 
DECLARE cantidad INT;
SET @cantidad:=(SELECT COUNT(*) FROM usuario WHERE email = correo);
IF @cantidad>0 THEN 
	UPDATE usuario SET clave = contra  WHERE email = correo;
	SELECT 1;

ELSE 
	SELECT 2;

END IF;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `idarticulo` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `idubicacion` int(11) NOT NULL,
  `medida` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `descripcion` varchar(256) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `precio_compra` decimal(11,2) NOT NULL DEFAULT 0.00,
  `precio_venta` decimal(11,2) NOT NULL DEFAULT 0.00,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`idarticulo`, `idcategoria`, `idubicacion`, `medida`, `nombre`, `stock`, `descripcion`, `imagen`, `precio_compra`, `precio_venta`, `condicion`) VALUES
(122, 1, 1, 'Listener', 'Ibuprofenos', 13, 'Para dolor de espalda', '', '12.00', '14.00', 1),
(123, 2, 2, 'Pastilla', 'Acetaminofén', 27, '', '', '6.50', '8.50', 1),
(132, 1, 1, 'Caja', 'Sucrol', 13, 'SAsA', '1637723432.jpg', '3.00', '6.00', 1),
(133, 2, 1, 'Unidad', 'Panadol', 107, '', '', '1.25', '2.00', 1);

--
-- Disparadores `articulo`
--
DELIMITER $$
CREATE TRIGGER `stockss` BEFORE UPDATE ON `articulo` FOR EACH ROW BEGIN
IF new.stock < 0 THEN
CALL `raise`(1356, 'Algo sucedio');
END if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'Jarabes', '', 1),
(2, 'Pastilla', '', 1),
(3, 'Estimulantes', '', 1),
(4, 'Atibioticos', '', 1),
(5, 'Sueros', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cginecologica`
--

CREATE TABLE `cginecologica` (
  `idcginecologica` int(11) NOT NULL,
  `idpaciente` int(11) DEFAULT NULL,
  `idseguro` int(11) DEFAULT NULL,
  `fecha_reg` datetime DEFAULT current_timestamp(),
  `mc` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `historia` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `peso` tinyint(2) DEFAULT NULL,
  `estatura` tinyint(2) DEFAULT NULL,
  `temperatura` tinyint(2) DEFAULT NULL,
  `pa` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fc` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fr` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `examenmamas` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `examenginec` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `examendental` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `resexadiag` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `descripcionresexadiag` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `usgpelv` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ic` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `tx` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ordenexadiag` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proximacita` date DEFAULT NULL,
  `montoacobrar` float(10,2) DEFAULT NULL,
  `observaciones` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `condicion` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cginecologica`
--

INSERT INTO `cginecologica` (`idcginecologica`, `idpaciente`, `idseguro`, `fecha_reg`, `mc`, `historia`, `peso`, `estatura`, `temperatura`, `pa`, `fc`, `fr`, `examenmamas`, `examenginec`, `examendental`, `resexadiag`, `descripcionresexadiag`, `usgpelv`, `ic`, `tx`, `ordenexadiag`, `proximacita`, `montoacobrar`, `observaciones`, `condicion`) VALUES
(2, 13, 2, '2021-09-05 19:35:46', '12', '', 12, 12, 12, '12', '12', '12', '12', '21', '12', '1637855652.pdf', '12', '12', '12', '12', '12', '2021-09-06', 123.00, '213', 1),
(3, 14, 3, '2021-11-17 23:03:48', 'Dolor de algo', '', 127, 123, 36, '234/3', '234/23', '234', '423', '423', '423', '1637855669.pdf', '423423', '32423', '23423', '423432', '4234', '2021-11-29', 200.00, 'n/a', 1),
(4, 13, 2, '2021-11-24 19:54:58', 'Venta', 'das', 127, 123, 123, '312', '312', '312', 'sadsad', 'dasda', 'dasd', '1630892147.png', 'dasd', 'das', 'das', 'das', 'das', '2021-11-25', 123.00, '123', 1),
(5, 14, 2, '2021-11-25 09:55:23', '&lt;zcxz', 'x&lt;zx', 127, 12, 31, '312', '321', '312', '312', '312', 'xczc', '1637855724.pdf', 'dsad', 'das', 'das', 'dsa', 'dsa', '2021-12-25', 123.00, 'dasdad', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `idcita` int(11) NOT NULL,
  `idseguro` int(11) DEFAULT NULL,
  `idmedico` int(11) DEFAULT NULL,
  `tipocita` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `pacienteovisitador` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `visitador` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `asunto` varchar(500) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefono` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estadocita` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `horariocitaunica` varchar(500) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`idcita`, `idseguro`, `idmedico`, `tipocita`, `pacienteovisitador`, `visitador`, `asunto`, `telefono`, `fecha`, `hora`, `estadocita`, `horariocitaunica`, `condicion`) VALUES
(28, 1, 1, 'Ginecologica', '14', '', 'Dolor', '4234234', '2021-11-21', '12:30 AM', 'Pendiente', '1 2021-11-21 12:30 AM', 1),
(30, 2, 1, 'Ginecologica', '', 'Visitador Bayer', '', '3423423', '2021-11-22', '12:30 AM', 'Confirmada', '1 2021-11-22 12:30 AM', 1),
(31, 3, 1, 'Ginecologica', '', 'EDASD', 'DSADSA', '324234', '2021-11-23', '03:00 PM', 'Pendiente', '1 2021-11-23 03:00 PM', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cpediatrica`
--

CREATE TABLE `cpediatrica` (
  `idcpediatrica` int(11) NOT NULL,
  `idpaciente` int(11) DEFAULT NULL,
  `idseguro` int(11) DEFAULT NULL,
  `fecha_reg` datetime DEFAULT current_timestamp(),
  `mc` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `historia` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `peso` tinyint(2) DEFAULT NULL,
  `estatura` tinyint(2) DEFAULT NULL,
  `temperatura` tinyint(2) DEFAULT NULL,
  `adecuacion` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `pa` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fc` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fr` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `examendental` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `resexadiag` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `descripcionresexadiag` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ic` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `tx` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ordenexadiag` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proximacita` date DEFAULT NULL,
  `montoacobrar` float(10,2) DEFAULT NULL,
  `observaciones` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `condicion` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cpediatrica`
--

INSERT INTO `cpediatrica` (`idcpediatrica`, `idpaciente`, `idseguro`, `fecha_reg`, `mc`, `historia`, `peso`, `estatura`, `temperatura`, `adecuacion`, `pa`, `fc`, `fr`, `examendental`, `resexadiag`, `descripcionresexadiag`, `ic`, `tx`, `ordenexadiag`, `proximacita`, `montoacobrar`, `observaciones`, `condicion`) VALUES
(3, 13, 4, '2021-09-05 19:40:54', '123', '', 12, 12, 12, '12', '12', '12', '12', '12', '1630892455.png', '21', '12', '21', 'dasdasd kkasoljdsakd kklasjdsak nsdlsajklda lkjdaslkdjsa ljdñasljdalsdj dlndaslkdns djaslkdjsakl asjdlkasjdsa  ldasjlñkdjasd lkjdlkasjdsa lkjdlsakjdkas lndaslkdnsa lkjdalskjdklsadnas ldkasjldkjaskld', '2021-09-07', 123.00, '121', 1),
(4, 16, 3, '2021-11-12 23:09:27', 'Dolor de estomago', '', 34, 46, 37, '12', '12', '12', '12', 'Si', '1636780258.jpg', 'Esta en buebs condiciones', 'Bien', 'Paracetamol', 'En buena condicion', '2021-11-26', 120.00, 'La edad le ha afectado', 1),
(5, 16, 3, '2021-11-17 23:20:04', 'saAS', 'SasA', 122, 122, 32, '123ASDAS', '213', '12', '123', '12SDSA', '', '321 SAD', 'WEQD D', 'DASDASDSADAS', 'DASDAS', '2021-11-29', 200.00, 'DSADAS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cprenatal`
--

CREATE TABLE `cprenatal` (
  `idcprenatal` int(11) NOT NULL,
  `idpaciente` int(11) NOT NULL,
  `idembarazo` int(11) NOT NULL,
  `idseguro` int(11) NOT NULL,
  `historia` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_reg` datetime DEFAULT current_timestamp(),
  `edadgestaact` tinyint(2) DEFAULT NULL,
  `peso` tinyint(2) DEFAULT NULL,
  `estatura` tinyint(2) DEFAULT NULL,
  `temperatura` tinyint(2) DEFAULT NULL,
  `pa` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fc` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fr` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `examenmamas` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `examenginec` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `examendental` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `resexadiag` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `descripcionresexadiag` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `usgobs` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `ic` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `tx` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ordenexadiag` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proximacita` date DEFAULT NULL,
  `montoacobrar` float(10,2) DEFAULT NULL,
  `observaciones` varchar(500) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `condicion` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cprenatal`
--

INSERT INTO `cprenatal` (`idcprenatal`, `idpaciente`, `idembarazo`, `idseguro`, `historia`, `fecha_reg`, `edadgestaact`, `peso`, `estatura`, `temperatura`, `pa`, `fc`, `fr`, `examenmamas`, `examenginec`, `examendental`, `resexadiag`, `descripcionresexadiag`, `usgobs`, `ic`, `tx`, `ordenexadiag`, `proximacita`, `montoacobrar`, `observaciones`, `condicion`) VALUES
(10, 13, 3, 2, '', '2021-08-23 19:11:44', 4, 127, 127, 37, '40', '20', '40', 'Si', 'si', 'si', '1629767505.png', 'Todo bien', 'Sin problemas', 'Sin problemas', 'Prenatales', '', '2021-09-09', 200.00, '', 0),
(11, 13, 3, 3, '', '2021-10-03 20:10:45', 6, 123, 124, 32, '12', '12', '12', 'si', 'si', 'si', '1633313445.jpg', 'si', 'si', 'si', 'Acetaminofen', 'si', '2021-11-03', 200.00, 'Se encuentra en buen estado', 1),
(12, 13, 3, 5, '', '2021-10-03 20:59:50', 8, 127, 127, 36, '123', '123', '123', 'si', 'si', 'si', '1633316391.jpg', 'si', 'si', 'si', 'Prenatales tipo 1', 'si', '2021-12-03', 200.00, '', 1),
(13, 14, 4, 2, '', '2021-11-03 23:03:58', 4, 127, 127, 36, '12', '12', '12', 'No cuenta con indicios de daños en los senos', 'Su evolución después del embarazo es estable', 'La dentadura se encuentra en buen estado', '1636002239.jpg', 'No se encontró algún riesgo', 'El ultrasonido obstétrico es un examen clínico que resulta útil para: establecer la presencia de un embrión/feto con vida. estimar el tiempo de gestación del embarazo.', 'diagnóstica: Identificación sustancial de los diversos elementos que integran la organización de la personalidad de la evaluada, presentados como: n Síntesis sobre las áreas evaluadas.', 'Prenatales', 'No se encontró ningún riesgo', '2021-11-10', 200.00, 'Tratar de comer saludable, 0 grasa.', 1),
(14, 13, 3, 2, 'fsdcxz', '2021-11-18 00:04:56', 6, 123, 127, 123, '123', '312', '312', '312', '123', '312', '', '312', '312', '312', '312cvcxvxc', '312', '2021-12-07', 123.00, '3123123', 1),
(15, 13, 3, 1, 'Todo bien', '2021-11-24 20:36:53', 19, 127, 127, 37, '123', '312', '213', 'si', '321', '213', '', '321', '312', '312', '312', '123', '2021-11-30', 124.00, 'todo bien', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingreso`
--

CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL,
  `idingreso` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_ingreso`
--

INSERT INTO `detalle_ingreso` (`iddetalle_ingreso`, `idingreso`, `idarticulo`, `cantidad`, `precio_compra`, `precio_venta`) VALUES
(52, 31, 122, 10, '12.00', '14.00'),
(53, 31, 132, 10, '3.00', '6.00'),
(54, 31, 123, 10, '6.00', '8.00'),
(55, 32, 133, 100, '1.25', '2.00'),
(56, 32, 123, 10, '6.50', '8.50'),
(57, 33, 133, 100, '1.25', '2.00'),
(58, 33, 123, 10, '6.50', '8.50'),
(59, 34, 132, 10, '3.00', '6.00'),
(60, 34, 133, 10, '1.25', '2.00'),
(61, 34, 123, 10, '6.50', '8.50'),
(62, 34, 122, 10, '12.00', '14.00'),
(63, 35, 122, 1, '12.00', '14.00'),
(64, 35, 132, 1, '3.00', '6.00'),
(65, 36, 122, 1, '12.00', '14.00'),
(66, 36, 132, 1, '3.00', '6.00');

--
-- Disparadores `detalle_ingreso`
--
DELIMITER $$
CREATE TRIGGER `prueba_loka` BEFORE INSERT ON `detalle_ingreso` FOR EACH ROW BEGIN
 UPDATE articulo SET precio_compra =  NEW.precio_compra, precio_venta =  NEW.precio_venta 
 WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingreso` FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock + NEW.cantidad, precio_compra =  NEW.precio_compra, precio_venta =  NEW.precio_venta 
 WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1,
  `descripcion` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'Aceptado',
  `condicional` varchar(50) NOT NULL DEFAULT 'si'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`iddetalle_venta`, `idventa`, `idarticulo`, `cantidad`, `precio_venta`, `descuento`, `condicion`, `descripcion`, `estado`, `condicional`) VALUES
(76, 51, 122, 3, '14.00', '0.00', 1, '', 'Aceptado', 'si'),
(77, 51, 133, 3, '2.00', '0.00', 1, '', 'Aceptado', 'si'),
(78, 51, 123, 3, '8.50', '0.00', 1, '', 'Aceptado', 'si'),
(79, 51, 132, 3, '6.00', '0.00', 1, '', 'Aceptado', 'si');

--
-- Disparadores `detalle_venta`
--
DELIMITER $$
CREATE TRIGGER `sale_update_after` AFTER UPDATE ON `detalle_venta` FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock - new.cantidad
 WHERE articulo.idarticulo = new.idarticulo;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sales_delete` BEFORE DELETE ON `detalle_venta` FOR EACH ROW BEGIN
 UPDATE 
 articulo SET stock = stock + OLD.cantidad 
 WHERE articulo.idarticulo = OLD.idarticulo;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updStockVenta` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
 UPDATE 
 articulo SET stock = stock - NEW.cantidad 
 WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updateVentasas` BEFORE UPDATE ON `detalle_venta` FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock + old.cantidad 
 WHERE articulo.idarticulo = old.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `embarazo`
--

CREATE TABLE `embarazo` (
  `idembarazo` int(11) NOT NULL,
  `idpaciente` int(11) NOT NULL,
  `fech_reg` datetime DEFAULT current_timestamp(),
  `edadgestaini` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `edadgestapor` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fpp` date DEFAULT NULL,
  `estadogesta` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `detallesestado` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nivelriesgo` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `observaciones` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `condicion` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `embarazo`
--

INSERT INTO `embarazo` (`idembarazo`, `idpaciente`, `fech_reg`, `edadgestaini`, `edadgestapor`, `fpp`, `estadogesta`, `detallesestado`, `nivelriesgo`, `observaciones`, `condicion`) VALUES
(3, 13, '2021-08-23 19:10:03', '1', 'USG OBS. GENESIS', '2022-05-10', 'FINALIZADO', 'Normal', 'BAJO', 'Madres jóvenes de relativamente más recursos de acuerdo con las respuestas en las  secciones de vivienda y hogar abandonan los estudios como consecuencia del embarazo.  Para muchas, no alcanza lo que ganan en trabajo, sea en fábrica o en el comercio', 1),
(4, 14, '2021-11-03 23:02:34', '1', 'USG OBS. GENESIS', '2022-08-03', 'EN CURSO', 'Todo bien', 'BAJO', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `idespecialidad` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `condicion` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`idespecialidad`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'Cardiologo', 'Cardiologo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiaclinica`
--

CREATE TABLE `historiaclinica` (
  `idhistoriaclinica` int(11) NOT NULL,
  `idpaciente` int(11) NOT NULL,
  `enfermedadingreso` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `antecedentesmedicos` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `antecedentesgin` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `antecedentesquir` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `antecedentespren` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `antecedentesfam` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `alergias` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `medicamentos` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `habitos` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `observaciones` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `gestas` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `hv` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `hm` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fup` date DEFAULT NULL,
  `fupap` date DEFAULT NULL,
  `estatura` date DEFAULT NULL,
  `ciclos` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `planfam` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `infecciones` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `observacionesg` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `espediente` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `condicion` tinyint(1) DEFAULT 1,
  `fecha_creacion` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `historiaclinica`
--

INSERT INTO `historiaclinica` (`idhistoriaclinica`, `idpaciente`, `enfermedadingreso`, `antecedentesmedicos`, `antecedentesgin`, `antecedentesquir`, `antecedentespren`, `antecedentesfam`, `alergias`, `medicamentos`, `habitos`, `observaciones`, `gestas`, `hv`, `hm`, `fup`, `fupap`, `estatura`, `ciclos`, `planfam`, `infecciones`, `observacionesg`, `espediente`, `condicion`, `fecha_creacion`) VALUES
(18, 13, 'das', 'dsa', 'dsa', 'dsa', 'dsa', 'sad', 'dsa', 'dsa', 'dsa', 'dsa', 'dsa', '2', '1', '2021-11-03', '0000-00-00', '0000-00-00', '', '', '', '', '1636434578.pdf', 1, '2021-11-17'),
(20, 14, 'bvn', 'bvn', '', 'nvb', 'nbv', 'bvn', 'nvb', 'nvb', 'nvb', 'nvb', '', '3', '3', '2021-11-03', '0000-00-00', '0000-00-00', '', '', '', '', '1636435175.pdf', 1, '2021-11-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiaclinica_vacuna`
--

CREATE TABLE `historiaclinica_vacuna` (
  `idhistoriaclinica_vacuna` int(11) NOT NULL,
  `idhistoriaclinica` int(11) NOT NULL,
  `idvacuna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `historiaclinica_vacuna`
--

INSERT INTO `historiaclinica_vacuna` (`idhistoriaclinica_vacuna`, `idhistoriaclinica`, `idvacuna`) VALUES
(5, 18, 3),
(6, 18, 4),
(7, 18, 10),
(8, 0, 2),
(9, 0, 3),
(10, 20, 2),
(11, 20, 3),
(12, 20, 4),
(13, 20, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ingreso`
--

INSERT INTO `ingreso` (`idingreso`, `idproveedor`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `total_compra`, `estado`) VALUES
(31, 9, 1, 'Ticket', '', '', '2021-11-24 00:00:00', '210.00', 'Aceptado'),
(32, 9, 1, 'Ticket', '', '', '2021-11-24 00:00:00', '190.00', 'Anulado'),
(33, 9, 1, 'Ticket', '', '', '2021-11-24 00:00:00', '190.00', 'Aceptado'),
(34, 9, 1, 'Ticket', '', '', '2021-11-25 00:00:00', '227.50', 'Anulado'),
(35, 9, 1, 'Ticket', '', '', '2021-11-25 00:00:00', '15.00', 'Anulado'),
(36, 9, 1, 'Ticket', '', '', '2021-11-25 00:00:00', '15.00', 'Aceptado');

--
-- Disparadores `ingreso`
--
DELIMITER $$
CREATE TRIGGER `tr_ingreso` AFTER UPDATE ON `ingreso` FOR EACH ROW update articulo a join detalle_ingreso di on di.idarticulo = a.idarticulo and di.idingreso = new.idingreso set a.stock = a.stock - di.cantidad
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

CREATE TABLE `insumo` (
  `idinsumo` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `condicion` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` (`idinsumo`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'KIT 1: Guantes + Algodón', '', 1),
(2, 'KIT 2: Guantes', '', 1),
(3, 'KIT 3: Guantes + Algodón + Jeringa', '', 1),
(4, 'dasdasdasfa', '', 1),
(5, 'DASDASGSD', 'DASDMASÑDAM', 1),
(6, 'DSADASD', 'ASLÑDAS{ÑDA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE `medico` (
  `idmedico` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idespecialidad` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `movil` char(12) NOT NULL,
  `sexo` char(1) NOT NULL,
  `fechanac` date NOT NULL,
  `numero_documento` char(15) NOT NULL,
  `numcolegiatura` char(15) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`idmedico`, `idusuario`, `idespecialidad`, `nombre`, `apellido`, `direccion`, `movil`, `sexo`, `fechanac`, `numero_documento`, `numcolegiatura`, `condicion`) VALUES
(1, 1, 1, 'Luis Alfonso', 'Hernandez Fernandez', 'Jalapa', '45454778', '', '2000-05-21', '4554645646', '456846', 1),
(2, 2, 1, 'Leticia Judith', 'Gutierrez Menendez', 'Jalapa', '45474558', '', '2000-04-12', '12312312312', '6565465', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `idpaciente` int(11) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `seguros` varchar(400) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `apellidocasada` varchar(50) NOT NULL,
  `estadocivil` varchar(50) DEFAULT NULL,
  `municipio` varchar(200) DEFAULT NULL,
  `direccion` varchar(250) NOT NULL,
  `movil` char(12) DEFAULT NULL,
  `sexo` char(1) NOT NULL,
  `gsanguineo` varchar(100) DEFAULT NULL,
  `fechanac` date DEFAULT NULL,
  `nacionalidad` varchar(100) DEFAULT NULL,
  `numero_documento` char(15) DEFAULT NULL,
  `religion` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  `nencargado` varchar(100) DEFAULT NULL,
  `parentesco` varchar(100) DEFAULT NULL,
  `tel_referencia` varchar(15) DEFAULT NULL,
  `condicion` tinyint(1) DEFAULT 1,
  `fecha_reg` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`idpaciente`, `imagen`, `seguros`, `nombre`, `apellido`, `apellidocasada`, `estadocivil`, `municipio`, `direccion`, `movil`, `sexo`, `gsanguineo`, `fechanac`, `nacionalidad`, `numero_documento`, `religion`, `email`, `observaciones`, `nencargado`, `parentesco`, `tel_referencia`, `condicion`, `fecha_reg`) VALUES
(13, '1633321939.jpg', NULL, 'Lisbeth Nohemi', 'Menéndez Gómez', 'Pinto', 'Casado(a)', 'Jalapa', 'Jalapa', '40516809', 'F', 'A positivo (A +)', '2000-05-12', 'Guatemala', '213123123123123', 'Católico', 'lisbeth@gmail.com', '', 'Juan Perez', 'Cónyuge', '34343434', 1, '2021-10-03 22:24:09'),
(14, '1633321948.jpg', '', 'Ana', 'Cardona Palma', 'Guzman', 'Casado(a)', 'Jalapa', '4ta. Av. Zona 1', '324234234234', 'F', 'A negativo (A-)', '2001-10-17', 'Guatemala', '423423423423', 'Católico', 'guzman@gmail.com', 'padece de la presión', 'Javier Guzman', 'Cónyuge', '4324234234234', 1, '2021-10-03 22:24:09'),
(15, '1635996731.jpg', NULL, 'Juan Jose', 'Méndez Méndez', '', 'Soltero(a)', 'Jalapa', '4ta. Av. Zona 1', '34343434', 'M', 'B positivo (B +)', '2021-11-09', 'Guatemala', '21312312313', 'Cristiano', 'juanjose@gmail.com', '', 'Javier', 'Tio', '32423432', 1, '2021-11-03 21:32:11'),
(16, '1636001062.jpg', NULL, 'Joel', 'Gomez', '', 'Divorciado(a)', 'Monjas', '4ta. Av. Zona 1', '32432423', 'M', 'B negativo (B-)', '2021-11-01', 'Guatemalteco', '3123123123', 'Católico', 'joel@gmail.com', '', 'Josue', 'Tio', '4324234', 1, '2021-11-03 22:44:22'),
(17, '', 'Segured, Columna', 'Kevin José', 'Aguirre Menendez', '', 'Soltero(a)', 'Jalapa', '4ta. Ave. Zona 1', '40454558', 'M', 'A positivo (A +)', '2015-12-12', 'Guatemala', '411252252', 'Católico', '', '', 'Juan Jose Menendez', 'Tio', '40122523', 1, '2021-11-17 11:03:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Escritorio'),
(2, 'Pacientes'),
(3, 'Embarazos'),
(4, 'Medicos'),
(5, 'Citas'),
(6, 'Seguros y Vacunas'),
(7, 'Consultas'),
(8, 'Acceso'),
(9, 'Reportes'),
(10, 'Home'),
(11, 'Almacen'),
(12, 'Compras'),
(13, 'Ventas'),
(14, 'Consulta Compras'),
(15, 'Consulta Ventas'),
(16, 'Ayuda'),
(17, 'Consultas No Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `tipo_persona` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `num_documento` varchar(20) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `tipo_persona`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`) VALUES
(8, 'Cliente', 'Consumidor final', 'DNI', '000000', 'Sin Identificación', '', ''),
(9, 'Proveedor', 'Juan Jose Bayer', 'DNI', '423423', 'Jalapa', '432423', 'dasd@gmail.com'),
(10, 'Proveedor', 'Jenifer', 'DNI', 'dasdsa', 'dasd', '42342342', 'dsad@gmail.com'),
(13, 'Cliente', 'Gerson González Pérez', 'DNI', '4051234234', 'Jalapa', '40515256', 'gersonbreakgonzalez@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencia`
--

CREATE TABLE `referencia` (
  `idreferencia` int(11) NOT NULL,
  `idmedico` int(11) NOT NULL,
  `idpaciente` int(11) NOT NULL,
  `referir` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `institucion` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `motivo` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `historial` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `observaciones` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `condicion` tinyint(1) DEFAULT 1,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguro`
--

CREATE TABLE `seguro` (
  `idseguro` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `condicion` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `seguro`
--

INSERT INTO `seguro` (`idseguro`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'EPSS', '', 1),
(2, 'COLUMNA', '', 1),
(3, 'ROBLERED', '', 1),
(4, 'RPN', '', 1),
(5, 'REDTOTAL', '', 1),
(6, 'MEDIRED', '', 1),
(7, 'SEGURED', '', 1),
(8, 'ESCOLAR', '', 1),
(9, 'UNIVERSALES', '', 1),
(10, 'NO APLICA', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `idubicacion` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `condicion` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`idubicacion`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'Estante X', '', 1),
(2, 'Estante Y', '', 1),
(3, 'Estante Z', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cargo` varchar(20) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `clave` varchar(64) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `telefono`, `email`, `cargo`, `login`, `clave`, `imagen`, `condicion`) VALUES
(1, 'Dr. Luis Alfonso Hernandez Fernandez', '931742904', 'luisalfonso@gmail.com', 'Doctor', 'doctor', '72f4be89d6ebab1496e21e38bcd7c8ca0a68928af3081ad7dff87e772eb350c2', '1636339321.jpg', 1),
(2, 'Dra. Leticia Judith Gutierrez Menendez', '54588556', 'leticia@gmail.com', 'Doctora', 'doctora', '2b2f4b3d52dcbb47dfa088c5b1b2df6a74d5e82f8355443787296b8957bc5f31', '', 1),
(3, 'Maricel Paz', '45316269', 'maricel@gmail.com', 'Secretaria', 'secretaria', '3e7100903faebe330d30fd23a5563830568bca178d5210986163528da8fac196', '', 1),
(4, 'vendedor', '324234', 'asd@gmail.com', 'vendedor', 'vendedor', 'e8827f3c0bcc90509b7d6841d446b163a671cac807a5f1bf41218667546ce80b', '', 1),
(5, 'Prueba', '4234234', 'preuba@gmail.com', 'prueba', 'prueba', '655e786674d9d3e77bc05ed1de37b4b6bc89f788829f9f3c679e7687b410c89b', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(77, 2, 1),
(78, 2, 2),
(79, 2, 3),
(80, 2, 4),
(81, 2, 5),
(82, 2, 6),
(83, 2, 7),
(84, 2, 8),
(85, 2, 9),
(86, 3, 1),
(87, 3, 2),
(88, 3, 3),
(89, 3, 4),
(90, 3, 5),
(91, 3, 6),
(92, 3, 7),
(93, 3, 8),
(94, 3, 9),
(155, 1, 1),
(156, 1, 2),
(157, 1, 3),
(158, 1, 4),
(159, 1, 5),
(160, 1, 6),
(161, 1, 7),
(162, 1, 8),
(163, 1, 9),
(164, 1, 10),
(165, 1, 11),
(166, 1, 12),
(167, 1, 13),
(168, 1, 14),
(169, 1, 15),
(170, 1, 17),
(173, 4, 10),
(174, 4, 11),
(175, 4, 12),
(176, 4, 13),
(177, 4, 14),
(178, 4, 15),
(179, 4, 16),
(180, 4, 17),
(181, 5, 1),
(182, 5, 2),
(183, 5, 3),
(184, 5, 4),
(185, 5, 5),
(186, 5, 6),
(187, 5, 7),
(188, 5, 8),
(189, 5, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacuna`
--

CREATE TABLE `vacuna` (
  `idvacuna` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vacuna`
--

INSERT INTO `vacuna` (`idvacuna`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'BCG', '', 1),
(2, 'PENTA', '', 1),
(3, 'SPR', '', 1),
(4, 'NEUMOCOCO', '', 1),
(5, 'ROTAVIRUS', '', 1),
(6, 'INFLUENZA', '', 1),
(7, 'COVID-19', '', 1),
(8, 'VARICELA', '', 1),
(9, 'HEP A', '', 1),
(10, 'POLIO', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) DEFAULT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_venta` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1,
  `con` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `idcliente`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `total_venta`, `estado`, `condicion`, `con`) VALUES
(51, 8, 1, 'Ticket', '', '', '2021-11-24 06:00:00', '91.50', 'Aceptado', 1, '2021-11-24 22:19:29');

--
-- Disparadores `venta`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockAnularVenta` AFTER UPDATE ON `venta` FOR EACH ROW update articulo a
    join detalle_venta di
      on di.idarticulo = a.idarticulo
      INNER JOIN venta v on v.idventa = di.idventa
     and di.idventa = new.idventa
     set a.stock = a.stock +  di.cantidad
     WHERE v.estado='Anulado'
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`idarticulo`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD KEY `fk_articulo_categoria_idx` (`idcategoria`),
  ADD KEY `fk_articulo_medida` (`medida`),
  ADD KEY `fk_articulo_ubicacion` (`idubicacion`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `cginecologica`
--
ALTER TABLE `cginecologica`
  ADD PRIMARY KEY (`idcginecologica`),
  ADD KEY `fk_cginecologica_paciente` (`idpaciente`),
  ADD KEY `fk_cginecologica_seguro` (`idseguro`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`idcita`),
  ADD UNIQUE KEY `horariocitaunica` (`horariocitaunica`),
  ADD KEY `fk_cita_seguro` (`idseguro`),
  ADD KEY `fk_cita_medico` (`idmedico`);

--
-- Indices de la tabla `cpediatrica`
--
ALTER TABLE `cpediatrica`
  ADD PRIMARY KEY (`idcpediatrica`),
  ADD KEY `fk_cpediatrica_paciente` (`idpaciente`),
  ADD KEY `fk_cpediatrica_seguro` (`idseguro`);

--
-- Indices de la tabla `cprenatal`
--
ALTER TABLE `cprenatal`
  ADD PRIMARY KEY (`idcprenatal`),
  ADD KEY `fk_cprenatal_seguro` (`idseguro`),
  ADD KEY `fk_cprenatal_paciente` (`idpaciente`),
  ADD KEY `fk_cprenatal_embarazo` (`idembarazo`);

--
-- Indices de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD PRIMARY KEY (`iddetalle_ingreso`),
  ADD KEY `fk_detalle_ingreso_ingreso_idx` (`idingreso`),
  ADD KEY `fk_detalle_ingreso_articulo_idx` (`idarticulo`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`iddetalle_venta`),
  ADD KEY `fk_detalle_venta_venta_idx` (`idventa`),
  ADD KEY `fk_detalle_venta_articulo_idx` (`idarticulo`);

--
-- Indices de la tabla `embarazo`
--
ALTER TABLE `embarazo`
  ADD PRIMARY KEY (`idembarazo`),
  ADD KEY `fk_embarazo_paciente` (`idpaciente`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`idespecialidad`);

--
-- Indices de la tabla `historiaclinica`
--
ALTER TABLE `historiaclinica`
  ADD PRIMARY KEY (`idhistoriaclinica`),
  ADD UNIQUE KEY `historial` (`idpaciente`) USING BTREE;

--
-- Indices de la tabla `historiaclinica_vacuna`
--
ALTER TABLE `historiaclinica_vacuna`
  ADD PRIMARY KEY (`idhistoriaclinica_vacuna`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`idingreso`),
  ADD KEY `fk_ingreso_persona_idx` (`idproveedor`),
  ADD KEY `fk_ingreso_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`idinsumo`);

--
-- Indices de la tabla `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`idmedico`),
  ADD UNIQUE KEY `fk_medico_usuario` (`idusuario`) USING BTREE,
  ADD KEY `fk_medico_especialidad` (`idespecialidad`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`idpaciente`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `referencia`
--
ALTER TABLE `referencia`
  ADD PRIMARY KEY (`idreferencia`),
  ADD KEY `fk_referencia_paciente` (`idpaciente`),
  ADD KEY `fk_referencia_medico` (`idmedico`);

--
-- Indices de la tabla `seguro`
--
ALTER TABLE `seguro`
  ADD PRIMARY KEY (`idseguro`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`idubicacion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_usuario_permiso_permiso` (`idpermiso`),
  ADD KEY `fk_usuario_permiso_usuario` (`idusuario`);

--
-- Indices de la tabla `vacuna`
--
ALTER TABLE `vacuna`
  ADD PRIMARY KEY (`idvacuna`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `fk_venta_mesa_idx` (`idcliente`),
  ADD KEY `fk_venta_usuario_idx` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `idarticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cginecologica`
--
ALTER TABLE `cginecologica`
  MODIFY `idcginecologica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `idcita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `cpediatrica`
--
ALTER TABLE `cpediatrica`
  MODIFY `idcpediatrica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cprenatal`
--
ALTER TABLE `cprenatal`
  MODIFY `idcprenatal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  MODIFY `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `embarazo`
--
ALTER TABLE `embarazo`
  MODIFY `idembarazo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `idespecialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `historiaclinica`
--
ALTER TABLE `historiaclinica`
  MODIFY `idhistoriaclinica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `historiaclinica_vacuna`
--
ALTER TABLE `historiaclinica_vacuna`
  MODIFY `idhistoriaclinica_vacuna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `idingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `idinsumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `idmedico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `idpaciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `referencia`
--
ALTER TABLE `referencia`
  MODIFY `idreferencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `seguro`
--
ALTER TABLE `seguro`
  MODIFY `idseguro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `idubicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT de la tabla `vacuna`
--
ALTER TABLE `vacuna`
  MODIFY `idvacuna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `fk_articulo_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_articulo_ubicacion` FOREIGN KEY (`idubicacion`) REFERENCES `ubicacion` (`idubicacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cginecologica`
--
ALTER TABLE `cginecologica`
  ADD CONSTRAINT `fk_cginecologica_paciente` FOREIGN KEY (`idpaciente`) REFERENCES `paciente` (`idpaciente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cginecologica_seguro` FOREIGN KEY (`idseguro`) REFERENCES `seguro` (`idseguro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_medico` FOREIGN KEY (`idmedico`) REFERENCES `medico` (`idmedico`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_seguro` FOREIGN KEY (`idseguro`) REFERENCES `seguro` (`idseguro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cpediatrica`
--
ALTER TABLE `cpediatrica`
  ADD CONSTRAINT `fk_cpediatrica_paciente` FOREIGN KEY (`idpaciente`) REFERENCES `paciente` (`idpaciente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cpediatrica_seguro` FOREIGN KEY (`idseguro`) REFERENCES `seguro` (`idseguro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cprenatal`
--
ALTER TABLE `cprenatal`
  ADD CONSTRAINT `fk_cprenatal_embarazo` FOREIGN KEY (`idembarazo`) REFERENCES `embarazo` (`idembarazo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cprenatal_paciente` FOREIGN KEY (`idpaciente`) REFERENCES `paciente` (`idpaciente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cprenatal_seguro` FOREIGN KEY (`idseguro`) REFERENCES `seguro` (`idseguro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD CONSTRAINT `fk_detalle_ingreso_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_ingreso_ingreso` FOREIGN KEY (`idingreso`) REFERENCES `ingreso` (`idingreso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_detalle_venta_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_venta_venta` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `embarazo`
--
ALTER TABLE `embarazo`
  ADD CONSTRAINT `fk_embarazo_paciente` FOREIGN KEY (`idpaciente`) REFERENCES `paciente` (`idpaciente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historiaclinica`
--
ALTER TABLE `historiaclinica`
  ADD CONSTRAINT `historiaclinica_ibfk_1` FOREIGN KEY (`idpaciente`) REFERENCES `paciente` (`idpaciente`);

--
-- Filtros para la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `fk_ingreso_persona` FOREIGN KEY (`idproveedor`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingreso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `fk_medico_especialidad` FOREIGN KEY (`idespecialidad`) REFERENCES `especialidad` (`idespecialidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_medico_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `referencia`
--
ALTER TABLE `referencia`
  ADD CONSTRAINT `fk_referencia_medico` FOREIGN KEY (`idmedico`) REFERENCES `medico` (`idmedico`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_referencia_paciente` FOREIGN KEY (`idpaciente`) REFERENCES `paciente` (`idpaciente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `fk_usuario_permiso_permiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_permiso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_venta_mesa` FOREIGN KEY (`idcliente`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
