-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-07-2025 a las 00:59:55
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
-- Base de datos: `uta_fisei_eventosconfig`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo_requisito`
--

CREATE TABLE `archivo_requisito` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIALINSCRIPCION` int(11) DEFAULT NULL,
  `SECUENCIALREQUISITO` int(11) DEFAULT NULL,
  `URLARCHIVO` varchar(255) DEFAULT NULL,
  `CODIGOESTADOVALIDACION` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `archivo_requisito`
--

INSERT INTO `archivo_requisito` (`SECUENCIAL`, `SECUENCIALINSCRIPCION`, `SECUENCIALREQUISITO`, `URLARCHIVO`, `CODIGOESTADOVALIDACION`) VALUES
(70, 1048, 72, 'cedula_685a43a297fb0.pdf', 'VAL'),
(71, 1048, 73, 'matricula_685a43a298776.pdf', 'VAL'),
(73, 1048, 12, 'req_685a4561c9b73_REGLAMENTO.pdf', 'VAL'),
(74, 1049, 74, 'req_686086389d4e2_reporte_certificados_FUNDAMENTOS_DE_PYTHON_1.pdf', 'VAL'),
(75, 1049, 75, 'req_686086389d833_reporte_certificados_FUNDAMENTOS_DE_PYTHON_1.pdf', 'VAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_nota`
--

CREATE TABLE `asistencia_nota` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIALEVENTO` int(11) DEFAULT NULL,
  `SECUENCIALUSUARIO` int(11) DEFAULT NULL,
  `ASISTIO` tinyint(1) DEFAULT NULL,
  `PORCENTAJE_ASISTENCIA` decimal(5,2) DEFAULT NULL,
  `NOTAFINAL` decimal(5,2) DEFAULT NULL,
  `OBSERVACION` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `asistencia_nota`
--

INSERT INTO `asistencia_nota` (`SECUENCIAL`, `SECUENCIALEVENTO`, `SECUENCIALUSUARIO`, `ASISTIO`, `PORCENTAJE_ASISTENCIA`, `NOTAFINAL`, `OBSERVACION`) VALUES
(29, 167, 87, 1, 95.00, 9.00, NULL),
(30, 168, 87, 1, 100.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `SECUENCIAL` int(11) NOT NULL,
  `NOMBRE_CARRERA` varchar(100) DEFAULT NULL,
  `SECUENCIALFACULTAD` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`SECUENCIAL`, `NOMBRE_CARRERA`, `SECUENCIALFACULTAD`) VALUES
(1, 'Ingeniería en Alimentos', 1),
(2, 'Biotecnología', 1),
(3, 'Bioquímica', 1),
(4, 'Administración de Empresas', 2),
(5, 'Mercadotecnia', 2),
(6, 'Agronomía', 3),
(7, 'Ingeniería Agronómica', 3),
(8, 'Medicina Veterinaria', 3),
(9, 'Medicina Veterinaria y Zootecnia', 3),
(10, 'Enfermería', 4),
(11, 'Estimulación Temprana', 4),
(12, 'Fisioterapia', 4),
(13, 'Laboratorio Clínico', 4),
(14, 'Medicina', 4),
(15, 'Nutrición y Dietética', 4),
(16, 'Psicología Clínica', 4),
(17, 'Terapia Física', 4),
(18, 'Educación Básica', 5),
(19, 'Educación Parvularia', 5),
(20, 'Cultura Física', 5),
(21, 'Turismo y Hotelería', 5),
(22, 'Idiomas', 5),
(23, 'Docencia en Informática', 5),
(24, 'Psicología Industrial', 5),
(25, 'Pedagogía de la Actividad Física y Deportes', 5),
(26, 'Psicopedagogía', 5),
(27, 'Educación Inicial', 5),
(28, 'Contabilidad y Auditoría', 6),
(29, 'Economía', 6),
(30, 'Ingeniería Financiera', 6),
(31, 'Arquitectura', 7),
(32, 'Diseño Gráfico', 7),
(33, 'Diseño Textil e Indumentaria', 7),
(34, 'Diseño Industrial', 7),
(35, 'Ingeniería Civil', 8),
(36, 'Ingeniería Mecánica', 8),
(37, 'Sistemas Computacionales e Informáticos', 9),
(38, 'Electrónica y Telecomunicaciones', 9),
(39, 'Industrial en Procesos de Automatización', 9),
(40, 'Tecnologías de la Información', 9),
(41, 'Telecomunicaciones', 9),
(42, 'Ingeniería Industrial', 9),
(43, 'Software', 9),
(44, 'Derecho', 10),
(45, 'Comunicación Social', 10),
(46, 'Trabajo Social', 10),
(47, 'Agricultura', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_evento`
--

CREATE TABLE `categoria_evento` (
  `SECUENCIAL` int(11) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `DESCRIPCION` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `categoria_evento`
--

INSERT INTO `categoria_evento` (`SECUENCIAL`, `NOMBRE`, `DESCRIPCION`) VALUES
(1, 'Científica', 'Eventos Científicos y tecnológicos'),
(2, 'Cultural', 'Eventos culturales y artísticos'),
(3, 'Deportiva', 'Actividades deportivas'),
(4, 'Académica', 'Conferencias y seminarios académicos'),
(5, 'Social', 'Eventos de integración social');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificado`
--

CREATE TABLE `certificado` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIALUSUARIO` int(11) NOT NULL,
  `SECUENCIALEVENTO` int(11) NOT NULL,
  `TIPO_CERTIFICADO` enum('Participación','Aprobación') DEFAULT 'Participación',
  `URL_CERTIFICADO` varchar(255) DEFAULT NULL,
  `FECHA_EMISION` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `certificado`
--

INSERT INTO `certificado` (`SECUENCIAL`, `SECUENCIALUSUARIO`, `SECUENCIALEVENTO`, `TIPO_CERTIFICADO`, `URL_CERTIFICADO`, `FECHA_EMISION`) VALUES
(13, 87, 167, 'Aprobación', 'certificado_87_167_1751211264.pdf', '2025-06-29 10:34:24'),
(30, 87, 168, 'Participación', 'certificado_87_168_1751171449.pdf', '2025-06-28 23:30:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_inscripcion`
--

CREATE TABLE `estado_inscripcion` (
  `CODIGO` varchar(20) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `estado_inscripcion`
--

INSERT INTO `estado_inscripcion` (`CODIGO`, `NOMBRE`) VALUES
('ACE', 'Aceptado'),
('ANU', 'Anulado'),
('PEN', 'Pendiente'),
('REC', 'Rechazado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pago`
--

CREATE TABLE `estado_pago` (
  `CODIGO` varchar(20) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `estado_pago`
--

INSERT INTO `estado_pago` (`CODIGO`, `NOMBRE`) VALUES
('INV', 'Inválido'),
('PEN', 'Pendiente'),
('RECH', 'Rechazado'),
('VAL', 'Validado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_validacion_requisito`
--

CREATE TABLE `estado_validacion_requisito` (
  `CODIGO` varchar(20) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `estado_validacion_requisito`
--

INSERT INTO `estado_validacion_requisito` (`CODIGO`, `NOMBRE`) VALUES
('PEN', 'Pendiente'),
('REC', 'Rechazado'),
('REV', 'En Revisión'),
('VAL', 'Validado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `SECUENCIAL` int(11) NOT NULL,
  `TITULO` varchar(150) NOT NULL,
  `CONTENIDO` text DEFAULT NULL,
  `DESCRIPCION` text DEFAULT NULL,
  `CODIGOTIPOEVENTO` varchar(20) DEFAULT NULL,
  `FECHAINICIO` date NOT NULL,
  `FECHAFIN` date NOT NULL,
  `CODIGOMODALIDAD` varchar(20) DEFAULT NULL,
  `HORAS` int(11) NOT NULL,
  `NOTAAPROBACION` decimal(4,2) DEFAULT NULL,
  `ES_PAGADO` tinyint(1) NOT NULL CHECK (`ES_PAGADO` in (0,1)),
  `COSTO` decimal(10,2) NOT NULL DEFAULT 0.00 CHECK (`COSTO` >= 0),
  `SECUENCIALCARRERA` int(11) DEFAULT NULL,
  `ES_SOLO_INTERNOS` tinyint(1) NOT NULL DEFAULT 0 CHECK (`ES_SOLO_INTERNOS` in (0,1)),
  `SECUENCIALCATEGORIA` int(11) DEFAULT NULL,
  `ESTADO` enum('DISPONIBLE','CERRADO','CANCELADO','EN CURSO','FINALIZADO') NOT NULL DEFAULT 'DISPONIBLE',
  `CAPACIDAD` int(11) DEFAULT NULL,
  `ES_DESTACADO` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si el evento es destacado (1) o no (0)',
  `ASISTENCIAMINIMA` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`SECUENCIAL`, `TITULO`, `CONTENIDO`, `DESCRIPCION`, `CODIGOTIPOEVENTO`, `FECHAINICIO`, `FECHAFIN`, `CODIGOMODALIDAD`, `HORAS`, `NOTAAPROBACION`, `ES_PAGADO`, `COSTO`, `SECUENCIALCARRERA`, `ES_SOLO_INTERNOS`, `SECUENCIALCATEGORIA`, `ESTADO`, `CAPACIDAD`, `ES_DESTACADO`, `ASISTENCIAMINIMA`) VALUES
(167, 'FUNDAMENTOS DE PYTHON 1', '• Módulo 1: Introducción a Python y programación informática\no Introducción a la programación\no Introducción a Python\no Evaluación\n• Módulo 2: Tipos de datos, variables, operaciones básicas de entradasalida y operadores básicos\no El programa “Hola, Mundo”\no Literales de Python\no Operadores – herramientas de manipulación de datos\no Variables\no Comentarios\no Interacción con el usuario\no Evaluación\n• Módulo 3: Valores booleanos, ejecución condicional, bucles, listas y procesamiento de listas, operaciones lógicas y bit a bit\no Toma de decisiones en Python\no Bucles en Python\no Operadores lógicos y operacionales bit a bit en Python.\no Listas\no Operaciones con listas\no Aplicaciones avanzadas de listas\no Evaluación\n• Módulo 4: Funciones, tuplas, diccionarios, excepciones y procesamiento de datos.\no Funciones\no Comunicación de las funciones con su entorno\no Resultados de funciones\no Alcances en Python', 'El curso Fundamentos de Python 1 de Cisco NetAcad es una introducción esencial al mundo de la programación, diseñado para enseñar los conceptos básicos de Python de forma práctica y accesible. A través de actividades interactivas y ejercicios basados en problemas reales, los estudiantes desarrollarán habilidades fundamentales en lógica de programación, estructuras de control, manejo de datos y uso de funciones básicas. Este curso está dirigido tanto a principiantes como a personas interesadas en dar sus primeros pasos en el campo de la programación, proporcionando una base sólida para avanzar hacia niveles más complejos y para explorar su aplicación en áreas como redes, ciberseguridad e inteligencia artificial.', 'CUR', '2025-06-24', '2025-06-26', 'VIRT', 32, 7.00, 1, 25.00, 37, 0, 4, 'FINALIZADO', 30, 0, NULL),
(168, 'Congreso de FISEI', NULL, 'El Congreso de la FISEI es un evento académico organizado por la Universidad Técnica de Ambato que promueve la investigación, innovación y el intercambio de conocimientos en las áreas de sistemas, electrónica e ingeniería industrial, reuniendo a expertos, estudiantes y profesionales del sector.', 'CONF', '2025-06-29', '2025-06-30', 'VIRT', 3, 7.00, 0, 0.00, 43, 0, 1, 'FINALIZADO', 30, 0, NULL),
(169, 'Congreso', NULL, 'juojiikiiluloo', 'EXP', '2025-07-13', '2025-07-20', 'HIBR', 10, 0.00, 0, 0.00, NULL, 0, 1, 'DISPONIBLE', 40, 1, NULL),
(171, 'Curso nuevo ', NULL, 'nuevo curso de vacaciones', 'CUR', '2025-07-13', '2025-07-20', 'HIBR', 10, 0.00, 0, 0.00, NULL, 0, 2, 'DISPONIBLE', 40, 0, NULL),
(172, 'Congreso', NULL, 'dcxxcvcxcxcx', 'CUR', '2025-07-13', '2025-07-20', 'HIBR', 10, 0.00, 0, 0.00, NULL, 0, 1, 'DISPONIBLE', 40, 1, NULL),
(173, 'Curso ', NULL, 'curso nuevo ', 'CUR', '2025-07-13', '2025-07-20', 'PRES', 10, 0.00, 0, 0.00, NULL, 0, 1, 'DISPONIBLE', 40, 1, NULL),
(177, 'Calculo Integral', NULL, 'calculo integral ', 'TALL', '2025-07-05', '2025-07-06', 'PRES', 20, 0.00, 0, 0.00, NULL, 0, 3, 'FINALIZADO', 20, 0, NULL),
(181, 'fisica', NULL, 'nuevo curso fisica', 'CUR', '2025-07-05', '2025-07-17', 'HIBR', 20, 0.00, 0, 0.00, NULL, 0, 1, 'CANCELADO', 5, 0, NULL),
(182, 'fisica', NULL, 'nuevo curso ', 'CUR', '2025-07-05', '2025-07-12', 'HIBR', 40, 0.00, 0, 0.00, NULL, 0, 1, 'CANCELADO', 50, 0, NULL),
(183, 'fisica', NULL, 'nuevo curso fisica', 'CUR', '2025-07-05', '2025-07-06', 'HIBR', 5, 0.00, 0, 0.00, NULL, 0, 1, 'CANCELADO', 5, 0, NULL),
(187, 'Estructura de datos', NULL, 'nuevo curso de estructura de datos', 'CONF', '2025-07-07', '2025-07-09', 'HIBR', 40, 8.00, 0, 0.00, NULL, 0, 1, 'DISPONIBLE', 40, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento_carrera`
--

CREATE TABLE `evento_carrera` (
  `ID` int(11) NOT NULL,
  `SECUENCIALEVENTO` int(11) NOT NULL,
  `SECUENCIALCARRERA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultad`
--

CREATE TABLE `facultad` (
  `SECUENCIAL` int(11) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `MISION` text DEFAULT NULL,
  `VISION` text DEFAULT NULL,
  `UBICACION` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `facultad`
--

INSERT INTO `facultad` (`SECUENCIAL`, `NOMBRE`, `MISION`, `VISION`, `UBICACION`) VALUES
(1, 'Facultad de Ciencia e Ingeniería en Alimentos', 'Formar profesionales líderes competentes, con visión humanista y pensamiento crítico a través de la docencia, la investigación y la vinculación, que apliquen, promuevan y difundan el conocimiento respondiendo a las necesidades del país.', 'La Facultad de Ciencia e Ingeniería en Alimentos será reconocida por su excelencia académica y su compromiso con el desarrollo sostenible del sector alimentario a nivel nacional e internacional.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador'),
(2, 'Facultad de Ciencias Administrativas', 'Formar profesionales en el área administrativa con sólidos conocimientos teóricos y prácticos, capaces de liderar procesos organizacionales y contribuir al desarrollo empresarial del país.', 'Ser una facultad líder en la formación de profesionales en ciencias administrativas, reconocida por su calidad académica y su vinculación con el entorno empresarial.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador'),
(3, 'Facultad de Ciencias Agropecuarias', 'Formar profesionales en el ámbito agropecuario con competencias técnicas y científicas que contribuyan al desarrollo sostenible del sector rural.', 'Ser una facultad de referencia en la formación agropecuaria, promoviendo la innovación y el desarrollo rural sostenible.', 'Campus Querochaca, Cevallos, Tungurahua, Ecuador'),
(4, 'Facultad de Ciencias de la Salud', 'Formar profesionales en ciencias de la salud con alto sentido ético y compromiso social, capaces de responder a las necesidades de salud de la población.', 'Ser una facultad reconocida por la excelencia en la formación de profesionales de la salud y su contribución al bienestar social.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador'),
(5, 'Facultad de Ciencias Humanas y de la Educación', 'Formar profesionales en el ámbito de las ciencias humanas y la educación, comprometidos con el desarrollo integral de la sociedad.', 'Ser una facultad líder en la formación de educadores y profesionales de las ciencias humanas, con reconocimiento nacional e internacional.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador'),
(6, 'Facultad de Contabilidad y Auditoría', 'Formar profesionales en contabilidad y auditoría con competencias técnicas y éticas, capaces de contribuir al desarrollo económico del país.', 'Ser una facultad de excelencia en la formación de contadores y auditores, reconocida por su calidad académica y su vinculación con el sector productivo.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador'),
(7, 'Facultad de Diseño, Arquitectura y Artes', 'Formar profesionales creativos e innovadores en diseño, arquitectura y artes, comprometidos con el desarrollo cultural y urbano.', 'Ser una facultad referente en la formación artística y arquitectónica, promoviendo la creatividad y la innovación.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador'),
(8, 'Facultad de Ingeniería Civil y Mecánica', 'Formar ingenieros civiles y mecánicos con competencias técnicas y éticas, capaces de liderar proyectos de infraestructura y desarrollo industrial.', 'Ser una facultad reconocida por la excelencia en la formación de ingenieros y su contribución al desarrollo sostenible.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador'),
(9, 'Facultad de Ingeniería en Sistemas, Electrónica e Industrial', 'Formar profesionales en ingeniería de sistemas, electrónica e industrial con capacidades para innovar y liderar procesos tecnológicos.', 'Ser una facultad líder en la formación de ingenieros en tecnologías de la información y la industria, con reconocimiento nacional e internacional.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador'),
(10, 'Facultad de Jurisprudencia y Ciencias Sociales', 'Formar profesionales en derecho y ciencias sociales con sentido de justicia y responsabilidad social, comprometidos con el estado de derecho.', 'Ser una facultad de referencia en la formación jurídica y social, promoviendo la equidad y la justicia en la sociedad.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_pago`
--

CREATE TABLE `forma_pago` (
  `CODIGO` varchar(20) NOT NULL,
  `NOMBRE` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `forma_pago`
--

INSERT INTO `forma_pago` (`CODIGO`, `NOMBRE`) VALUES
('EFEC', 'Efectivo'),
('TRANS', 'Transferencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_evento`
--

CREATE TABLE `imagen_evento` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIALEVENTO` int(11) NOT NULL,
  `URL_IMAGEN` varchar(300) NOT NULL,
  `TIPO_IMAGEN` enum('PORTADA','GALERIA') DEFAULT 'PORTADA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `imagen_evento`
--

INSERT INTO `imagen_evento` (`SECUENCIAL`, `SECUENCIALEVENTO`, `URL_IMAGEN`, `TIPO_IMAGEN`) VALUES
(46, 167, 'public/img/portada_68542c2a2f47a_python1.jpg', 'PORTADA'),
(47, 167, 'public/img/galeria_68542c2a2fa01_galeriaPython.png', 'GALERIA'),
(48, 168, 'public/img/portada_68608505c9c01_portada.png', 'PORTADA'),
(49, 168, 'public/img/galeria_68608505ca16e_galerai.jpg', 'GALERIA'),
(50, 187, 'public/img/portada_6869ade52cff3_diarmaFlujo.png', 'PORTADA'),
(51, 187, 'public/img/galeria_6869ade52d790_diagramEntidadRelacion.png', 'GALERIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIALEVENTO` int(11) DEFAULT NULL,
  `SECUENCIALUSUARIO` int(11) DEFAULT NULL,
  `FECHAINSCRIPCION` datetime DEFAULT NULL,
  `FACTURA_URL` varchar(255) DEFAULT NULL,
  `CODIGOESTADOINSCRIPCION` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`SECUENCIAL`, `SECUENCIALEVENTO`, `SECUENCIALUSUARIO`, `FECHAINSCRIPCION`, `FACTURA_URL`, `CODIGOESTADOINSCRIPCION`) VALUES
(1048, 167, 87, '2025-06-24 01:27:14', NULL, 'ACE'),
(1049, 168, 87, '2025-06-28 19:14:19', NULL, 'ACE'),
(1050, 169, 89, '2025-07-04 00:21:19', NULL, 'PEN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidad_evento`
--

CREATE TABLE `modalidad_evento` (
  `CODIGO` varchar(20) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `modalidad_evento`
--

INSERT INTO `modalidad_evento` (`CODIGO`, `NOMBRE`) VALUES
('HIBR', 'Híbrida'),
('PRES', 'Presencial'),
('SEMIP', 'Semi-presencial'),
('VIRT', 'Virtual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizador_evento`
--

CREATE TABLE `organizador_evento` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIALEVENTO` int(11) NOT NULL,
  `SECUENCIALUSUARIO` int(11) NOT NULL,
  `ROL_ORGANIZADOR` varchar(50) NOT NULL CHECK (`ROL_ORGANIZADOR` in ('ORGANIZADOR','RESPONSABLE'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `organizador_evento`
--

INSERT INTO `organizador_evento` (`SECUENCIAL`, `SECUENCIALEVENTO`, `SECUENCIALUSUARIO`, `ROL_ORGANIZADOR`) VALUES
(97, 167, 88, 'RESPONSABLE'),
(98, 167, 88, 'ORGANIZADOR'),
(99, 168, 88, 'RESPONSABLE'),
(135, 169, 91, 'ORGANIZADOR'),
(137, 172, 91, 'ORGANIZADOR'),
(139, 173, 91, 'ORGANIZADOR'),
(141, 171, 91, 'ORGANIZADOR'),
(149, 181, 91, 'RESPONSABLE'),
(150, 182, 91, 'RESPONSABLE'),
(151, 183, 91, 'RESPONSABLE'),
(155, 187, 91, 'RESPONSABLE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIALINSCRIPCION` int(11) DEFAULT NULL,
  `CODIGOFORMADEPAGO` varchar(20) DEFAULT NULL,
  `COMPROBANTE_URL` varchar(255) DEFAULT NULL,
  `CODIGOESTADOPAGO` varchar(20) DEFAULT NULL,
  `SECUENCIAL_USUARIO_APROBADOR` int(11) DEFAULT NULL,
  `FECHA_PAGO` datetime DEFAULT NULL,
  `FECHA_APROBACION` datetime DEFAULT NULL,
  `MONTO` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`SECUENCIAL`, `SECUENCIALINSCRIPCION`, `CODIGOFORMADEPAGO`, `COMPROBANTE_URL`, `CODIGOESTADOPAGO`, `SECUENCIAL_USUARIO_APROBADOR`, `FECHA_PAGO`, `FECHA_APROBACION`, `MONTO`) VALUES
(32, 1048, 'TRANS', 'comprobante_685a4698198e1_REGLAMENTO.pdf', 'VAL', 88, '2025-06-24 01:32:56', '2025-06-29 13:40:32', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcion_cambio`
--

CREATE TABLE `recepcion_cambio` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIAL_CAMBIO` int(11) NOT NULL,
  `TIPO_ITIL` enum('Estándar','Normal','Emergencia') DEFAULT NULL,
  `PRIORIDAD` enum('Alta','Media','Baja') DEFAULT NULL,
  `CATEGORIA_TECNICA` varchar(100) DEFAULT NULL,
  `EVALUACION` text DEFAULT NULL,
  `BENEFICIOS` text DEFAULT NULL,
  `IMPACTO_NEGATIVO` text DEFAULT NULL,
  `ACCIONES` text DEFAULT NULL,
  `DECISION` enum('Aprobado','Rechazado','Más información') DEFAULT NULL,
  `OBSERVACIONES` text DEFAULT NULL,
  `RESPONSABLE_TECNICO` varchar(100) DEFAULT NULL,
  `FECHA_DECISION` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requisito_evento`
--

CREATE TABLE `requisito_evento` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIALEVENTO` int(11) DEFAULT NULL,
  `DESCRIPCION` varchar(255) DEFAULT NULL,
  `ES_OBLIGATORIO` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `requisito_evento`
--

INSERT INTO `requisito_evento` (`SECUENCIAL`, `SECUENCIALEVENTO`, `DESCRIPCION`, `ES_OBLIGATORIO`) VALUES
(1, NULL, 'Cédula o documento de identidad', NULL),
(2, NULL, 'Comprobante de matrícula vigente', NULL),
(4, NULL, 'Certificado de vacunación COVID-19', NULL),
(5, NULL, 'Carta de autorización de la facultad', NULL),
(6, NULL, 'Ensayo o trabajo previo requerido', NULL),
(7, NULL, 'Presentación o diapositivas (para ponentes)', NULL),
(8, NULL, 'Formulario de inscripción firmado', NULL),
(9, NULL, 'Certificado de conocimiento previo', NULL),
(10, NULL, 'Carta de invitación oficial', NULL),
(12, 167, 'Aval académico', NULL),
(72, 167, 'Cédula o documento de identidad', NULL),
(73, 167, 'Comprobante de matrícula vigente', NULL),
(74, 168, 'Carta de invitación oficial', NULL),
(75, 168, 'Aval académico', NULL),
(76, NULL, 'Carta de motivación', NULL),
(81, 177, 'Cédula o documento de identidad', NULL),
(82, 177, 'Carta de motivación', NULL),
(86, 181, 'Cédula o documento de identidad', NULL),
(87, 181, 'Carta de motivación', NULL),
(88, 182, 'Cédula o documento de identidad', NULL),
(89, 182, 'Carta de motivación', NULL),
(90, 183, 'Cédula o documento de identidad', NULL),
(91, 183, 'Carta de motivación', NULL),
(96, 187, 'Cédula o documento de identidad', NULL),
(97, 187, 'Certificado de vacunación COVID-19', NULL),
(98, 187, 'Carta de motivación', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

CREATE TABLE `rol_usuario` (
  `CODIGO` varchar(20) NOT NULL,
  `NOMBRE` enum('ADMIN','DOCENTE','ESTUDIANTE','INVITADO','AUTORIDAD') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `rol_usuario`
--

INSERT INTO `rol_usuario` (`CODIGO`, `NOMBRE`) VALUES
('ADM', 'ADMIN'),
('AUT', 'AUTORIDAD'),
('COORDINADOR', 'AUTORIDAD'),
('DECANO', 'AUTORIDAD'),
('DOC', 'DOCENTE'),
('EST', 'ESTUDIANTE'),
('INV', 'INVITADO'),
('RECTOR', 'AUTORIDAD'),
('SUBDECANO', 'AUTORIDAD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_cambio`
--

CREATE TABLE `solicitud_cambio` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIAL_USUARIO` int(11) NOT NULL,
  `MODULO_AFECTADO` varchar(100) NOT NULL,
  `TIPO_SOLICITUD` enum('Problema','Mejora','Idea') NOT NULL,
  `DESCRIPCION` text NOT NULL,
  `JUSTIFICACION` text NOT NULL,
  `URGENCIA` enum('Alta','Media','Baja') NOT NULL,
  `ARCHIVO_EVIDENCIA` varchar(255) DEFAULT NULL,
  `ESTADO` enum('Pendiente','Evaluado','Rechazado') DEFAULT 'Pendiente',
  `FECHA_ENVIO` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_evento`
--

CREATE TABLE `tipo_evento` (
  `CODIGO` varchar(20) NOT NULL,
  `NOMBRE` varchar(100) DEFAULT NULL,
  `DESCRIPCION` varchar(500) DEFAULT NULL,
  `REQUIERENOTA` tinyint(1) NOT NULL DEFAULT 0,
  `REQUIEREASISTENCIA` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_evento`
--

INSERT INTO `tipo_evento` (`CODIGO`, `NOMBRE`, `DESCRIPCION`, `REQUIERENOTA`, `REQUIEREASISTENCIA`) VALUES
('CONF', 'Conferencia', 'Evento académico con expositores', 1, 1),
('CUR', 'Curso', 'Capacitación estructurada', 0, 0),
('EXP', 'Exposición', 'Presentación de proyectos', 0, 0),
('SEM', 'Seminario', 'Espacio de exposición académica', 0, 0),
('TALL', 'Taller', 'Sesión práctica sobre un tema específico', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `SECUENCIAL` int(11) NOT NULL,
  `NOMBRES` varchar(100) NOT NULL,
  `APELLIDOS` varchar(100) NOT NULL,
  `CEDULA` varchar(20) DEFAULT NULL,
  `URL_CEDULA` varchar(255) DEFAULT NULL,
  `URL_MATRICULA` varchar(255) DEFAULT NULL,
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  `TELEFONO` varchar(20) NOT NULL,
  `DIRECCION` varchar(255) DEFAULT NULL,
  `CORREO` varchar(100) NOT NULL,
  `CONTRASENA` varchar(255) NOT NULL,
  `CODIGOROL` varchar(20) NOT NULL,
  `CODIGOESTADO` varchar(10) NOT NULL CHECK (`CODIGOESTADO` in ('ACTIVO','INACTIVO','BLOQUEADO')),
  `ES_INTERNO` tinyint(1) NOT NULL CHECK (`ES_INTERNO` in (0,1)),
  `FOTO_PERFIL` varchar(300) DEFAULT NULL,
  `token_recupera` varchar(100) DEFAULT NULL,
  `token_expiracion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`SECUENCIAL`, `NOMBRES`, `APELLIDOS`, `CEDULA`, `URL_CEDULA`, `URL_MATRICULA`, `FECHA_NACIMIENTO`, `TELEFONO`, `DIRECCION`, `CORREO`, `CONTRASENA`, `CODIGOROL`, `CODIGOESTADO`, `ES_INTERNO`, `FOTO_PERFIL`, `token_recupera`, `token_expiracion`) VALUES
(17, 'Ing. Luis', 'Morales', NULL, NULL, NULL, NULL, '0982184126', 'Ambato', 'luisamorales@uta.edu.ec', '$2y$10$zhHNQdBczuYUGPyug01NYunxM9NA9E6jn/vSa15ZdXXdrvBUUbppq', 'SUBDECANO', 'INACTIVO', 1, 'perfil_684537231ab49_luis_morales.png', NULL, NULL),
(18, 'Ing. Daniel', 'Jerez', NULL, NULL, NULL, NULL, '09784334934', 'Ambato', 'jerezD@uta.edu.ec', '$2y$10$ENH1c55NGiQYlIoN.YXcHee50cDBv.wfgNYLzn3KNi44y1YZr6adW', 'COORDINADOR', 'INACTIVO', 1, 'perfil_684536f4b3c0f_daniel_jerez.jpeg', NULL, NULL),
(19, 'Ing. Marco', 'Guachimboza', NULL, NULL, NULL, NULL, '0984384394', 'Ambato', 'marcovguachimboza@uta.edu.ec', '$2y$10$sAskvAiElJ8xegl8RJa/qeMSeRz8siV7D5lrQLjbGaoTou4rHs8CC', 'RECTOR', 'INACTIVO', 1, 'perfil_6845373c24875_marcoG.png', NULL, NULL),
(73, 'Cristian', 'Jurado', NULL, NULL, NULL, '2004-06-29', '0982184126', 'Tena', 'ernestojurado2004@gmail.com', '$2y$10$5DqomY0n029e2viMtabJZOF3zm2EGervyNM9sLTOLR6xefxbpWbv2', 'ADM', 'ACTIVO', 0, NULL, NULL, NULL),
(86, 'Ing. Franklin ', 'Mayorga', NULL, NULL, NULL, NULL, '0385798467', 'FISEI', 'fmayorga@uta.edu.ec', '$2y$10$VkHbS.77pNdqEYp7dgkNxe/h/rPGQw8Ux1V8V2Y9dgKHf7/RfClU.', 'DECANO', 'INACTIVO', 1, 'perfil_68532e628f45d_franklin_mayorga.png', NULL, NULL),
(87, 'Amalia Analia', 'Romero', '1601185795', 'cedula_685a43a297fb0.pdf', 'matricula_685a43a298776.pdf', '2003-06-10', '0996871239', 'Ambato', 'amaliaR@uta.edu.ec', '$2y$10$CwJLT0w0.DLyI/V.95OvVONE/UsZc6TsIJkNhlKWO6EzvHyhtd8u2', 'EST', 'ACTIVO', 1, 'perfil_685a43a2979e7.jpg', NULL, NULL),
(88, 'Patricio', 'Jaramillo', '1800034257', '', '', '2000-06-27', '0995643234', 'Ambato, Huachi', 'patricio.jar@uta.edu.ec', '$2y$10$JxEajy/LAlIy1P4qlCPxJeBm917Lw4TGKu6DzBul4KU57uAT6vUu2', 'DOC', 'ACTIVO', 1, 'perfil_68542abd32162_perfil_patricio_jaramillo.png', NULL, NULL),
(89, 'Javier', 'Quisaguano', NULL, NULL, NULL, '2005-01-13', '0993459583', 'squisili', 'dquisaguano6335@uta.edu.ec', '$2y$10$cyj3klJO9GEueKQFGc6s4OtKs5UQHy2Qd6btc9139IqPEncA936TO', 'EST', 'ACTIVO', 1, NULL, NULL, NULL),
(91, 'Dennis', 'Quisaguano', '0550236335', NULL, NULL, '2005-01-13', '0993459583', 'saquisili', 'dennis@uta.edu.ec', '$2y$10$VaQZEWUvHdCaUrJ8ccpocu8nECsPCW10mhE98onk26Sm2YMPu.SfC', 'DOC', 'ACTIVO', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_carrera`
--

CREATE TABLE `usuario_carrera` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIALUSUARIO` int(11) NOT NULL,
  `SECUENCIALCARRERA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario_carrera`
--

INSERT INTO `usuario_carrera` (`SECUENCIAL`, `SECUENCIALUSUARIO`, `SECUENCIALCARRERA`) VALUES
(9, 87, 16);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivo_requisito`
--
ALTER TABLE `archivo_requisito`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `SECUENCIALINSCRIPCION` (`SECUENCIALINSCRIPCION`),
  ADD KEY `SECUENCIALREQUISITO` (`SECUENCIALREQUISITO`),
  ADD KEY `CODIGOESTADOVALIDACION` (`CODIGOESTADOVALIDACION`);

--
-- Indices de la tabla `asistencia_nota`
--
ALTER TABLE `asistencia_nota`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `SECUENCIALEVENTO` (`SECUENCIALEVENTO`),
  ADD KEY `SECUENCIALUSUARIO` (`SECUENCIALUSUARIO`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `SECUENCIALFACULTAD` (`SECUENCIALFACULTAD`);

--
-- Indices de la tabla `categoria_evento`
--
ALTER TABLE `categoria_evento`
  ADD PRIMARY KEY (`SECUENCIAL`);

--
-- Indices de la tabla `certificado`
--
ALTER TABLE `certificado`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `SECUENCIALUSUARIO` (`SECUENCIALUSUARIO`),
  ADD KEY `SECUENCIALEVENTO` (`SECUENCIALEVENTO`);

--
-- Indices de la tabla `estado_inscripcion`
--
ALTER TABLE `estado_inscripcion`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Indices de la tabla `estado_pago`
--
ALTER TABLE `estado_pago`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Indices de la tabla `estado_validacion_requisito`
--
ALTER TABLE `estado_validacion_requisito`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `CODIGOTIPOEVENTO` (`CODIGOTIPOEVENTO`),
  ADD KEY `CODIGOMODALIDAD` (`CODIGOMODALIDAD`),
  ADD KEY `SECUENCIALCARRERA` (`SECUENCIALCARRERA`),
  ADD KEY `SECUENCIALCATEGORIA` (`SECUENCIALCATEGORIA`);

--
-- Indices de la tabla `evento_carrera`
--
ALTER TABLE `evento_carrera`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SECUENCIALEVENTO` (`SECUENCIALEVENTO`),
  ADD KEY `SECUENCIALCARRERA` (`SECUENCIALCARRERA`);

--
-- Indices de la tabla `facultad`
--
ALTER TABLE `facultad`
  ADD PRIMARY KEY (`SECUENCIAL`);

--
-- Indices de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Indices de la tabla `imagen_evento`
--
ALTER TABLE `imagen_evento`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `SECUENCIALEVENTO` (`SECUENCIALEVENTO`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `SECUENCIALEVENTO` (`SECUENCIALEVENTO`),
  ADD KEY `SECUENCIALUSUARIO` (`SECUENCIALUSUARIO`),
  ADD KEY `CODIGOESTADOINSCRIPCION` (`CODIGOESTADOINSCRIPCION`);

--
-- Indices de la tabla `modalidad_evento`
--
ALTER TABLE `modalidad_evento`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Indices de la tabla `organizador_evento`
--
ALTER TABLE `organizador_evento`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `SECUENCIALEVENTO` (`SECUENCIALEVENTO`),
  ADD KEY `SECUENCIALUSUARIO` (`SECUENCIALUSUARIO`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `SECUENCIALINSCRIPCION` (`SECUENCIALINSCRIPCION`),
  ADD KEY `CODIGOFORMADEPAGO` (`CODIGOFORMADEPAGO`),
  ADD KEY `CODIGOESTADOPAGO` (`CODIGOESTADOPAGO`),
  ADD KEY `SECUENCIAL_USUARIO_APROBADOR` (`SECUENCIAL_USUARIO_APROBADOR`);

--
-- Indices de la tabla `recepcion_cambio`
--
ALTER TABLE `recepcion_cambio`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `SECUENCIAL_CAMBIO` (`SECUENCIAL_CAMBIO`);

--
-- Indices de la tabla `requisito_evento`
--
ALTER TABLE `requisito_evento`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `SECUENCIALEVENTO` (`SECUENCIALEVENTO`);

--
-- Indices de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Indices de la tabla `solicitud_cambio`
--
ALTER TABLE `solicitud_cambio`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `fk_usuario` (`SECUENCIAL_USUARIO`);

--
-- Indices de la tabla `tipo_evento`
--
ALTER TABLE `tipo_evento`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD UNIQUE KEY `CORREO` (`CORREO`),
  ADD KEY `CODIGOROL` (`CODIGOROL`);

--
-- Indices de la tabla `usuario_carrera`
--
ALTER TABLE `usuario_carrera`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `SECUENCIALUSUARIO` (`SECUENCIALUSUARIO`),
  ADD KEY `SECUENCIALCARRERA` (`SECUENCIALCARRERA`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivo_requisito`
--
ALTER TABLE `archivo_requisito`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `asistencia_nota`
--
ALTER TABLE `asistencia_nota`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `categoria_evento`
--
ALTER TABLE `categoria_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `certificado`
--
ALTER TABLE `certificado`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de la tabla `evento_carrera`
--
ALTER TABLE `evento_carrera`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=637;

--
-- AUTO_INCREMENT de la tabla `facultad`
--
ALTER TABLE `facultad`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `imagen_evento`
--
ALTER TABLE `imagen_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1051;

--
-- AUTO_INCREMENT de la tabla `organizador_evento`
--
ALTER TABLE `organizador_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `recepcion_cambio`
--
ALTER TABLE `recepcion_cambio`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `requisito_evento`
--
ALTER TABLE `requisito_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT de la tabla `solicitud_cambio`
--
ALTER TABLE `solicitud_cambio`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `usuario_carrera`
--
ALTER TABLE `usuario_carrera`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivo_requisito`
--
ALTER TABLE `archivo_requisito`
  ADD CONSTRAINT `archivo_requisito_ibfk_1` FOREIGN KEY (`SECUENCIALINSCRIPCION`) REFERENCES `inscripcion` (`SECUENCIAL`),
  ADD CONSTRAINT `archivo_requisito_ibfk_2` FOREIGN KEY (`SECUENCIALREQUISITO`) REFERENCES `requisito_evento` (`SECUENCIAL`),
  ADD CONSTRAINT `archivo_requisito_ibfk_3` FOREIGN KEY (`CODIGOESTADOVALIDACION`) REFERENCES `estado_validacion_requisito` (`CODIGO`);

--
-- Filtros para la tabla `asistencia_nota`
--
ALTER TABLE `asistencia_nota`
  ADD CONSTRAINT `asistencia_nota_ibfk_1` FOREIGN KEY (`SECUENCIALEVENTO`) REFERENCES `evento` (`SECUENCIAL`),
  ADD CONSTRAINT `asistencia_nota_ibfk_2` FOREIGN KEY (`SECUENCIALUSUARIO`) REFERENCES `usuario` (`SECUENCIAL`);

--
-- Filtros para la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD CONSTRAINT `carrera_ibfk_1` FOREIGN KEY (`SECUENCIALFACULTAD`) REFERENCES `facultad` (`SECUENCIAL`);

--
-- Filtros para la tabla `certificado`
--
ALTER TABLE `certificado`
  ADD CONSTRAINT `certificado_ibfk_1` FOREIGN KEY (`SECUENCIALUSUARIO`) REFERENCES `usuario` (`SECUENCIAL`),
  ADD CONSTRAINT `certificado_ibfk_2` FOREIGN KEY (`SECUENCIALEVENTO`) REFERENCES `evento` (`SECUENCIAL`);

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`CODIGOTIPOEVENTO`) REFERENCES `tipo_evento` (`CODIGO`),
  ADD CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`CODIGOMODALIDAD`) REFERENCES `modalidad_evento` (`CODIGO`),
  ADD CONSTRAINT `evento_ibfk_3` FOREIGN KEY (`SECUENCIALCARRERA`) REFERENCES `carrera` (`SECUENCIAL`),
  ADD CONSTRAINT `evento_ibfk_4` FOREIGN KEY (`SECUENCIALCATEGORIA`) REFERENCES `categoria_evento` (`SECUENCIAL`);

--
-- Filtros para la tabla `evento_carrera`
--
ALTER TABLE `evento_carrera`
  ADD CONSTRAINT `evento_carrera_ibfk_1` FOREIGN KEY (`SECUENCIALEVENTO`) REFERENCES `evento` (`SECUENCIAL`) ON DELETE CASCADE,
  ADD CONSTRAINT `evento_carrera_ibfk_2` FOREIGN KEY (`SECUENCIALCARRERA`) REFERENCES `carrera` (`SECUENCIAL`) ON DELETE CASCADE;

--
-- Filtros para la tabla `imagen_evento`
--
ALTER TABLE `imagen_evento`
  ADD CONSTRAINT `imagen_evento_ibfk_1` FOREIGN KEY (`SECUENCIALEVENTO`) REFERENCES `evento` (`SECUENCIAL`);

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `inscripcion_ibfk_1` FOREIGN KEY (`SECUENCIALEVENTO`) REFERENCES `evento` (`SECUENCIAL`),
  ADD CONSTRAINT `inscripcion_ibfk_2` FOREIGN KEY (`SECUENCIALUSUARIO`) REFERENCES `usuario` (`SECUENCIAL`),
  ADD CONSTRAINT `inscripcion_ibfk_5` FOREIGN KEY (`CODIGOESTADOINSCRIPCION`) REFERENCES `estado_inscripcion` (`CODIGO`);

--
-- Filtros para la tabla `organizador_evento`
--
ALTER TABLE `organizador_evento`
  ADD CONSTRAINT `organizador_evento_ibfk_1` FOREIGN KEY (`SECUENCIALEVENTO`) REFERENCES `evento` (`SECUENCIAL`),
  ADD CONSTRAINT `organizador_evento_ibfk_2` FOREIGN KEY (`SECUENCIALUSUARIO`) REFERENCES `usuario` (`SECUENCIAL`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`SECUENCIALINSCRIPCION`) REFERENCES `inscripcion` (`SECUENCIAL`),
  ADD CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`CODIGOFORMADEPAGO`) REFERENCES `forma_pago` (`CODIGO`),
  ADD CONSTRAINT `pago_ibfk_3` FOREIGN KEY (`CODIGOESTADOPAGO`) REFERENCES `estado_pago` (`CODIGO`),
  ADD CONSTRAINT `pago_ibfk_4` FOREIGN KEY (`SECUENCIAL_USUARIO_APROBADOR`) REFERENCES `usuario` (`SECUENCIAL`);

--
-- Filtros para la tabla `recepcion_cambio`
--
ALTER TABLE `recepcion_cambio`
  ADD CONSTRAINT `recepcion_cambio_ibfk_1` FOREIGN KEY (`SECUENCIAL_CAMBIO`) REFERENCES `solicitud_cambio` (`SECUENCIAL`) ON DELETE CASCADE;

--
-- Filtros para la tabla `requisito_evento`
--
ALTER TABLE `requisito_evento`
  ADD CONSTRAINT `requisito_evento_ibfk_1` FOREIGN KEY (`SECUENCIALEVENTO`) REFERENCES `evento` (`SECUENCIAL`);

--
-- Filtros para la tabla `solicitud_cambio`
--
ALTER TABLE `solicitud_cambio`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`SECUENCIAL_USUARIO`) REFERENCES `usuario` (`SECUENCIAL`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`CODIGOROL`) REFERENCES `rol_usuario` (`CODIGO`);

--
-- Filtros para la tabla `usuario_carrera`
--
ALTER TABLE `usuario_carrera`
  ADD CONSTRAINT `usuario_carrera_ibfk_1` FOREIGN KEY (`SECUENCIALUSUARIO`) REFERENCES `usuario` (`SECUENCIAL`),
  ADD CONSTRAINT `usuario_carrera_ibfk_2` FOREIGN KEY (`SECUENCIALCARRERA`) REFERENCES `carrera` (`SECUENCIAL`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
