-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-07-2025 a las 19:43:53
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
(131, 1077, 79, 'cedula_6869fa7aa059f.pdf', 'VAL'),
(132, 1077, 80, 'matricula_6869fe7bef0ae.pdf', 'VAL'),
(133, 1077, 81, 'req_686a1defc5c0f_Informe_Tercer_Sprint final (1).pdf', 'VAL');

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
(30, 168, 87, 1, 100.00, NULL, NULL),
(31, 172, 87, 1, 100.00, 10.00, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoridades`
--

CREATE TABLE `autoridades` (
  `SECUENCIAL` int(11) NOT NULL,
  `FACULTAD_SECUENCIAL` int(11) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `CARGO` varchar(100) NOT NULL,
  `FOTO_URL` varchar(255) DEFAULT NULL,
  `CORREO` varchar(100) DEFAULT NULL,
  `TELEFONO` varchar(20) DEFAULT NULL,
  `ESTADO` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autoridades`
--

INSERT INTO `autoridades` (`SECUENCIAL`, `FACULTAD_SECUENCIAL`, `NOMBRE`, `CARGO`, `FOTO_URL`, `CORREO`, `TELEFONO`, `ESTADO`) VALUES
(1, 9, 'Ing. Mg. Franklin Mayorga ', 'DECANO', 'perfil_68532e628f45d_franklin_mayorga.png', 'fmayorga@uta.edu.ec', '032851894', 1),
(2, 9, 'Ing. Mg. Luis Morales', 'SUBDECANO', 'perfil_684537231ab49_luis_morales.png', 'luisamorales@uta.edu.ec', '032851894', 1),
(8, 9, 'Ing. Mg. Marco Guachimboza', 'COORDINADOR DE CARRERA', 'perfil_68698d46257cc_perfil_6845373c24875_marcoG.png', 'marcovguachimboza@uta.edu.ec', '032851894', 1),
(9, 9, 'Ing. Daniel Jerez, Mg', 'RESPONSABLE CTT', 'perfil_68698ee09f918_perfil_684536f4b3c0f_daniel_jerez.jpeg', 'jerezD@uta.edu.ec', '032851894', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `SECUENCIAL` int(11) NOT NULL,
  `NOMBRE_CARRERA` varchar(100) DEFAULT NULL,
  `IMAGEN` varchar(255) DEFAULT NULL,
  `SECUENCIALFACULTAD` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`SECUENCIAL`, `NOMBRE_CARRERA`, `IMAGEN`, `SECUENCIALFACULTAD`) VALUES
(1, 'Ingeniería en Alimentos', NULL, 1),
(2, 'Biotecnología', NULL, 1),
(3, 'Bioquímica', NULL, 1),
(4, 'Administración de Empresas EC', 'public/img/carreras/boda8.jpg', 2),
(5, 'Mercadotecnia', NULL, 2),
(6, 'Agronomía', NULL, 3),
(7, 'Ingeniería Agronómica', NULL, 3),
(8, 'Medicina Veterinaria', NULL, 3),
(9, 'Medicina Veterinaria y Zootecnia', NULL, 3),
(10, 'Enfermería', NULL, 4),
(11, 'Estimulación Temprana', NULL, 4),
(12, 'Fisioterapia', NULL, 4),
(13, 'Laboratorio Clínico', NULL, 4),
(14, 'Medicina', NULL, 4),
(15, 'Nutrición y Dietética', NULL, 4),
(16, 'Psicología Clínica', NULL, 4),
(17, 'Terapia Física', NULL, 4),
(18, 'Educación Básica', NULL, 5),
(19, 'Educación Parvularia', NULL, 5),
(20, 'Cultura Física', NULL, 5),
(21, 'Turismo y Hotelería', NULL, 5),
(22, 'Idiomas', NULL, 5),
(23, 'Docencia en Informática', NULL, 5),
(24, 'Psicología Industrial', NULL, 5),
(25, 'Pedagogía de la Actividad Física y Deportes', NULL, 5),
(26, 'Psicopedagogía', NULL, 5),
(27, 'Educación Inicial', NULL, 5),
(28, 'Contabilidad y Auditoría', NULL, 6),
(29, 'Economía', NULL, 6),
(30, 'Ingeniería Financiera', NULL, 6),
(31, 'Arquitectura', NULL, 7),
(32, 'Diseño Gráfico', NULL, 7),
(33, 'Diseño Textil e Indumentaria', NULL, 7),
(34, 'Diseño Industrial', NULL, 7),
(35, 'Ingeniería Civil', NULL, 8),
(36, 'Ingeniería Mecánica', NULL, 8),
(37, 'Sistemas Computacionales e Informáticos', 'public/img/carreras/Sistemas Computacionales e Informáticos.jpg', 9),
(38, 'Electrónica y Telecomunicaciones', 'public/img/carreras/Electrónica y Telecomunicaciones.jpg', 9),
(39, 'Industrial en Procesos de Automatización', 'public/img/carreras/Industrial en Procesos de Automatización.jpg', 9),
(40, 'Tecnologías de la Información', 'public/img/carreras/Tecnologías de la Información.jpg', 9),
(41, 'Telecomunicaciones', 'public/img/carreras/Telecomunicaciones.jpg', 9),
(42, 'Ingeniería Industrial', 'public/img/carreras/Ingeniería Industrial.png', 9),
(43, 'Software', 'public/img/carreras/SOFTWARE.png', 9),
(44, 'Derecho', NULL, 10),
(45, 'Comunicación Social', NULL, 10),
(46, 'Trabajo Social', NULL, 10),
(47, 'Agricultura', NULL, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrusel`
--

CREATE TABLE `carrusel` (
  `SECUENCIAL` int(11) NOT NULL,
  `TITULO` varchar(255) DEFAULT NULL,
  `SUBTITULO` text DEFAULT NULL,
  `URL_IMAGEN` varchar(255) NOT NULL,
  `ENLACE` varchar(255) DEFAULT NULL,
  `ORDEN` int(11) DEFAULT 0,
  `ACTIVO` tinyint(1) DEFAULT 1,
  `FECHACREACION` timestamp NULL DEFAULT current_timestamp(),
  `DESCRIPCION` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrusel`
--

INSERT INTO `carrusel` (`SECUENCIAL`, `TITULO`, `SUBTITULO`, `URL_IMAGEN`, `ENLACE`, `ORDEN`, `ACTIVO`, `FECHACREACION`, `DESCRIPCION`) VALUES
(11, 'Desarrollo de software en entornos reales', NULL, 'public/img/carrusel/68685bc67ea14_ChatGPT Image 4 jul 2025, 17_51_41.png', NULL, 0, 1, '2025-07-04 22:55:02', 'Python y Java Soluciones del mundo real'),
(12, 'Programación web interactiva', NULL, 'public/img/carrusel/6868601652ab6_ChatGPT Image 4 jul 2025, 18_12_39.png', NULL, 0, 1, '2025-07-04 23:13:26', 'HTML, CSS y lógica en acción'),
(13, 'Lenguajes esenciales para desarrollo web', NULL, 'public/img/carrusel/686864af2ca50_ChatGPT Image 4 jul 2025, 18_32_53.png', NULL, 0, 0, '2025-07-04 23:33:03', 'HTML, CSS y JavaScript en acción'),
(14, 'softaer', NULL, 'public/img/carrusel/6868b0667036e_webnair galeria.jpg', NULL, 0, 0, '2025-07-05 04:56:06', 'mkmcksmd');

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
(5, 'Social', 'Integración social');

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
(30, 87, 168, 'Participación', 'certificado_87_168_1751171449.pdf', '2025-06-28 23:30:49'),
(31, 87, 172, 'Aprobación', 'certificado_87_172_1751815462.pdf', '2025-07-06 10:24:22');

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
  `NOTAAPROBACION` decimal(4,2) NOT NULL,
  `ES_PAGADO` tinyint(1) NOT NULL,
  `COSTO` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ES_SOLO_INTERNOS` tinyint(1) NOT NULL DEFAULT 0,
  `SECUENCIALCATEGORIA` int(11) DEFAULT NULL,
  `ESTADO` enum('DISPONIBLE','CERRADO','CANCELADO','EN CURSO','FINALIZADO') NOT NULL DEFAULT 'DISPONIBLE',
  `CAPACIDAD` int(11) DEFAULT NULL,
  `ES_DESTACADO` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si el evento es destacado (1) o no (0)',
  `ASISTENCIAMINIMA` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`SECUENCIAL`, `TITULO`, `CONTENIDO`, `DESCRIPCION`, `CODIGOTIPOEVENTO`, `FECHAINICIO`, `FECHAFIN`, `CODIGOMODALIDAD`, `HORAS`, `NOTAAPROBACION`, `ES_PAGADO`, `COSTO`, `ES_SOLO_INTERNOS`, `SECUENCIALCATEGORIA`, `ESTADO`, `CAPACIDAD`, `ES_DESTACADO`, `ASISTENCIAMINIMA`) VALUES
(167, 'FUNDAMENTOS DE PYTHON 1', '• Módulo 1: Introducción a Python y programación informática\no Introducción a la programación\no Introducción a Python\no Evaluación\n• Módulo 2: Tipos de datos, variables, operaciones básicas de entradasalida y operadores básicos\no El programa “Hola, Mundo”\no Literales de Python\no Operadores – herramientas de manipulación de datos\no Variables\no Comentarios\no Interacción con el usuario\no Evaluación\n• Módulo 3: Valores booleanos, ejecución condicional, bucles, listas y procesamiento de listas, operaciones lógicas y bit a bit\no Toma de decisiones en Python\no Bucles en Python\no Operadores lógicos y operacionales bit a bit en Python.\no Listas\no Operaciones con listas\no Aplicaciones avanzadas de listas\no Evaluación\n• Módulo 4: Funciones, tuplas, diccionarios, excepciones y procesamiento de datos.\no Funciones\no Comunicación de las funciones con su entorno\no Resultados de funciones\no Alcances en Python', 'El curso Fundamentos de Python 1 de Cisco NetAcad es una introducción esencial al mundo de la programación, diseñado para enseñar los conceptos básicos de Python de forma práctica y accesible. A través de actividades interactivas y ejercicios basados en problemas reales, los estudiantes desarrollarán habilidades fundamentales en lógica de programación, estructuras de control, manejo de datos y uso de funciones básicas. Este curso está dirigido tanto a principiantes como a personas interesadas en dar sus primeros pasos en el campo de la programación, proporcionando una base sólida para avanzar hacia niveles más complejos y para explorar su aplicación en áreas como redes, ciberseguridad e inteligencia artificial.', 'CUR', '2025-06-24', '2025-06-26', 'VIRT', 32, 7.00, 1, 25.00, 0, 4, 'FINALIZADO', 30, 1, NULL),
(168, 'Congreso de FISEI', NULL, 'El Congreso de la FISEI es un evento académico organizado por la Universidad Técnica de Ambato que promueve la investigación, innovación y el intercambio de conocimientos en las áreas de sistemas, electrónica e ingeniería industrial, reuniendo a expertos, estudiantes y profesionales del sector.', 'CONF', '2025-06-29', '2025-06-30', 'VIRT', 3, 7.00, 0, 0.00, 0, 1, 'FINALIZADO', 30, 1, NULL),
(169, 'CONCURSO PYTHON', NULL, 'REALIZAR PRUEBAS CON LA BASE DE DATOS', 'CONF', '2025-07-01', '2025-10-10', 'PRES', 120, 7.00, 1, 120.00, 1, 1, 'FINALIZADO', 120, 1, NULL),
(170, 'V CONGRESO DE SOFTWARE', NULL, 'PROYECTOS DE TEGNOLOGIA', 'CONF', '2025-07-01', '2025-07-05', 'VIRT', 20, 7.00, 0, 0.00, 1, 1, 'FINALIZADO', 120, 1, NULL),
(171, 'Taller de Desarrollo Web Frontend', NULL, 'En este taller práctico, los participantes aprenderán a crear interfaces web modernas usando tecnologías esenciales del desarrollo frontend.', 'TALL', '2025-07-05', '2025-08-22', 'PRES', 30, 8.00, 1, 120.00, 0, 1, 'DISPONIBLE', 30, 1, NULL),
(172, 'Curso Intensivo de Python para Ciencia de Datos', NULL, 'Aprende Python desde cero con un enfoque práctico orientado a la ciencia de datos.\r\n\r\n', 'CUR', '2025-07-06', '2025-10-18', 'VIRT', 50, 8.00, 1, 50.00, 0, 1, 'FINALIZADO', 50, 1, NULL),
(173, 'Conferencia sobre Ciberseguridad en la Nube', NULL, 'Expertos compartirán experiencias y técnicas sobre cómo proteger sistemas y datos en infraestructuras cloud.', 'CONF', '2025-07-05', '2025-07-31', 'PRES', 120, 0.00, 0, 0.00, 1, 5, 'DISPONIBLE', 200, 1, NULL);

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
  `UBICACION` varchar(255) DEFAULT NULL,
  `ABOUT` text DEFAULT NULL,
  `URL_LOGO` varchar(255) DEFAULT NULL,
  `URL_PORTADA` varchar(255) DEFAULT NULL,
  `SIGLA` varchar(20) DEFAULT NULL,
  `ACTIVO` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `facultad`
--

INSERT INTO `facultad` (`SECUENCIAL`, `NOMBRE`, `MISION`, `VISION`, `UBICACION`, `ABOUT`, `URL_LOGO`, `URL_PORTADA`, `SIGLA`, `ACTIVO`) VALUES
(1, 'Facultad de Ciencia e Ingeniería en Alimentos', 'Formar profesionales líderes competentes, con visión humanista y pensamiento crítico a través de la docencia, la investigación y la vinculación, que apliquen, promuevan y difundan el conocimiento respondiendo a las necesidades del país.', 'La Facultad de Ciencia e Ingeniería en Alimentos será reconocida por su excelencia académica y su compromiso con el desarrollo sostenible del sector alimentario a nivel nacional e internacional.', 'Campus Huachi, AV. Los Chasquis y Río Guayllabamba, Ambato, Ecuador', 'conocemos quienes eres', NULL, NULL, 'FCIA', 1),
(2, 'Facultad de Ciencias Administrativas', 'Formar profesionales en el área administrativa con sólidos conocimientos teóricos y prácticos, capaces de liderar procesos organizacionales y contribuir al desarrollo empresarial del país.', 'Ser una facultad líder en la formación de profesionales en ciencias administrativas, reconocida por su calidad académica y su vinculación con el entorno empresarial.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador', NULL, NULL, NULL, NULL, 1),
(3, 'Facultad de Ciencias Agropecuarias', 'Formar profesionales en el ámbito agropecuario con competencias técnicas y científicas que contribuyan al desarrollo sostenible del sector rural.', 'Ser una facultad de referencia en la formación agropecuaria, promoviendo la innovación y el desarrollo rural sostenible.', 'Campus Querochaca, Cevallos, Tungurahua, Ecuador', NULL, NULL, NULL, NULL, 1),
(4, 'Facultad de Ciencias de la Salud', 'Formar profesionales en ciencias de la salud con alto sentido ético y compromiso social, capaces de responder a las necesidades de salud de la población.', 'Ser una facultad reconocida por la excelencia en la formación de profesionales de la salud y su contribución al bienestar social.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador', NULL, NULL, NULL, NULL, 1),
(5, 'Facultad de Ciencias Humanas y de la Educación', 'Formar profesionales en el ámbito de las ciencias humanas y la educación, comprometidos con el desarrollo integral de la sociedad.', 'Ser una facultad líder en la formación de educadores y profesionales de las ciencias humanas, con reconocimiento nacional e internacional.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador', NULL, NULL, NULL, NULL, 1),
(6, 'Facultad de Contabilidad y Auditoría', 'Formar profesionales en contabilidad y auditoría con competencias técnicas y éticas, capaces de contribuir al desarrollo económico del país.', 'Ser una facultad de excelencia en la formación de contadores y auditores, reconocida por su calidad académica y su vinculación con el sector productivo.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador', NULL, NULL, NULL, NULL, 1),
(7, 'Facultad de Diseño, Arquitectura y Artes', 'Formar profesionales creativos e innovadores en diseño, arquitectura y artes, comprometidos con el desarrollo cultural y urbano.', 'Ser una facultad referente en la formación artística y arquitectónica, promoviendo la creatividad y la innovación.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador', NULL, NULL, NULL, NULL, 1),
(8, 'Facultad de Ingeniería Civil y Mecánica', 'Formar ingenieros civiles y mecánicos con competencias técnicas y éticas, capaces de liderar proyectos de infraestructura y desarrollo industrial.', 'Ser una facultad reconocida por la excelencia en la formación de ingenieros y su contribución al desarrollo sostenible.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador', NULL, NULL, NULL, NULL, 1),
(9, 'Facultad de Ingeniería en Sistemas, Electrónica e Industrial', 'Formar profesionales en ingeniería de sistemas, electrónica e industrial con capacidades para innovar y liderar procesos tecnológicos.', 'Ser una facultad líder en la formación de ingenieros en tecnologías de la información y la industria, con reconocimiento nacional e internacional.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador', 'El 20 de octubre de 2002 se crea el Centro de Transferencia y Desarrollo de Tecnologías mediante resoluión 1452-2002-CU-P en las áreas de Ingenierías en Sistemas, Electrónica e Industrial de la Universidad Técnica de Ambato, para proveer servicios a la comunidad mediante la realización de trabajos y proyectos especificos, asesorias, estudios, investigaciones, cursos de entrenamiento, seminarios y otras actividades de servicios a los sectores sociales y productivos en las áreas de ingeniería en Sistemas computacionales e informáticos, ingeniería Electrónica y Comunícaciones e Ingeniería Industrial en Procesos de automatización.', NULL, NULL, 'FISEI', 1),
(10, 'Facultad de Jurisprudencia y Ciencias Sociales', 'Formar profesionales en derecho y ciencias sociales con sentido de justicia y responsabilidad social, comprometidos con el estado de derecho.', 'Ser una facultad de referencia en la formación jurídica y social, promoviendo la equidad y la justicia en la sociedad.', 'Campus Huachi, Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador', NULL, NULL, NULL, NULL, 1);

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
(46, 167, '', 'PORTADA'),
(47, 167, '', 'GALERIA'),
(48, 168, '', 'PORTADA'),
(49, 168, '', 'GALERIA'),
(52, 170, '', 'PORTADA'),
(53, 170, '', 'GALERIA'),
(64, 173, 'portada_6869468fc5e50.jpg', 'PORTADA'),
(65, 173, 'galeria_6869468fc61d4.jpg', 'GALERIA'),
(66, 172, 'portada_686947237534f.jpg', 'PORTADA'),
(67, 172, 'galeria_686947237576b.png', 'GALERIA'),
(68, 171, 'portada_68694751ad3d7.jpg', 'PORTADA'),
(69, 171, 'galeria_68694751ad622.jpg', 'GALERIA');

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
  `CODIGOESTADOINSCRIPCION` varchar(20) DEFAULT NULL,
  `motivacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`SECUENCIAL`, `SECUENCIALEVENTO`, `SECUENCIALUSUARIO`, `FECHAINSCRIPCION`, `FACTURA_URL`, `CODIGOESTADOINSCRIPCION`, `motivacion`) VALUES
(1048, 167, 87, '2025-06-24 01:27:14', NULL, 'ACE', NULL),
(1049, 168, 87, '2025-06-28 19:14:19', NULL, 'ACE', NULL),
(1077, 172, 87, '2025-07-06 01:55:03', NULL, 'ACE', NULL);

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
('ADC', 'a Distancia'),
('HIBR', 'Híbrida'),
('PRES', 'Presencial'),
('SEMIP', 'Semi-presencial'),
('VIRT', 'Virtual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `SECUENCIAL` int(11) NOT NULL,
  `TITULO` varchar(255) NOT NULL,
  `RESUMEN` text DEFAULT NULL,
  `CONTENIDO` text DEFAULT NULL,
  `URL_IMAGEN` varchar(255) DEFAULT NULL,
  `AUTOR` varchar(100) DEFAULT NULL,
  `FECHAPUBLICACION` date NOT NULL,
  `ACTIVO` tinyint(1) DEFAULT 1,
  `FECHACREACION` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizador_evento`
--

CREATE TABLE `organizador_evento` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIALEVENTO` int(11) NOT NULL,
  `SECUENCIALUSUARIO` int(11) NOT NULL,
  `ROL_ORGANIZADOR` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `organizador_evento`
--

INSERT INTO `organizador_evento` (`SECUENCIAL`, `SECUENCIALEVENTO`, `SECUENCIALUSUARIO`, `ROL_ORGANIZADOR`) VALUES
(97, 167, 88, 'RESPONSABLE'),
(98, 167, 88, 'ORGANIZADOR'),
(99, 168, 88, 'RESPONSABLE'),
(106, 169, 89, 'RESPONSABLE'),
(107, 169, 90, 'ORGANIZADOR'),
(108, 170, 89, 'RESPONSABLE'),
(109, 170, 89, 'ORGANIZADOR'),
(120, 173, 88, 'RESPONSABLE'),
(121, 173, 88, 'ORGANIZADOR'),
(122, 172, 88, 'RESPONSABLE'),
(123, 172, 88, 'ORGANIZADOR'),
(124, 171, 88, 'RESPONSABLE'),
(125, 171, 88, 'ORGANIZADOR');

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
(40, 1077, 'TRANS', 'comprobante_686a1defc5f46_prueba_backend.pdf', 'VAL', 88, '2025-07-06 01:55:43', '2025-07-06 01:56:41', 50.00);

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
(9, NULL, 'Certificado de conocimiento previo', NULL),
(10, NULL, 'Carta de invitación oficial', NULL),
(12, 167, 'Aval académico', NULL),
(72, 167, 'Cédula o documento de identidad', NULL),
(73, 167, 'Comprobante de matrícula vigente', NULL),
(74, 168, 'Carta de invitación oficial', NULL),
(75, 168, 'Aval académico', NULL),
(76, NULL, 'Certificado de estar matriculado', NULL),
(78, NULL, 'ACTA DE MATRIMONIO', NULL),
(79, 172, 'Cédula o documento de identidad', NULL),
(80, 172, 'Comprobante de matrícula vigente', NULL),
(81, 172, 'Certificado de vacunación COVID-19', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

CREATE TABLE `rol_usuario` (
  `CODIGO` varchar(20) NOT NULL,
  `NOMBRE` enum('ADMIN','DOCENTE','ESTUDIANTE','INVITADO','AUTORIDAD','COORDINADOR','DECANO','SECRETARIA','ASISTENTE','DIRECTOR','USUARIO','SUPERVISOR','JEFE','RESPONSABLE','COLABORADOR') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `rol_usuario`
--

INSERT INTO `rol_usuario` (`CODIGO`, `NOMBRE`) VALUES
('ADM', 'ADMIN'),
('DOC', 'DOCENTE'),
('EST', 'ESTUDIANTE'),
('INV', 'INVITADO'),
('OTRO', 'USUARIO');

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
  `DESCRIPCION` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_evento`
--

INSERT INTO `tipo_evento` (`CODIGO`, `NOMBRE`, `DESCRIPCION`) VALUES
('CONF', 'Conferencia', 'Evento académico con expositores'),
('CUR', 'Curso', 'Capacitación estructurada'),
('EXP', 'Exposición', 'Presentación de proyectos'),
('SEM', 'Seminario', 'Espacio de exposición académica'),
('TALL', 'Taller', 'Sesión práctica sobre un tema específico');

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
  `CODIGOESTADO` varchar(10) NOT NULL,
  `ES_INTERNO` tinyint(1) NOT NULL,
  `FOTO_PERFIL` varchar(300) DEFAULT NULL,
  `token_recupera` varchar(100) DEFAULT NULL,
  `token_expiracion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`SECUENCIAL`, `NOMBRES`, `APELLIDOS`, `CEDULA`, `URL_CEDULA`, `URL_MATRICULA`, `FECHA_NACIMIENTO`, `TELEFONO`, `DIRECCION`, `CORREO`, `CONTRASENA`, `CODIGOROL`, `CODIGOESTADO`, `ES_INTERNO`, `FOTO_PERFIL`, `token_recupera`, `token_expiracion`) VALUES
(73, 'Cristian', 'Jurado', NULL, NULL, NULL, '2004-06-29', '0982184126', 'Tena', 'ernestojurado2005@gmail.com', '$2y$10$5DqomY0n029e2viMtabJZOF3zm2EGervyNM9sLTOLR6xefxbpWbv2', 'ADM', 'ACTIVO', 0, NULL, NULL, NULL),
(87, 'Amalia Analia', 'Romero', '1500453806', 'cedula_6869fa7aa059f.pdf', 'matricula_6869fe7bef0ae.pdf', '2002-07-21', '0996871239', 'Ambato', 'ernestojurado2004@gmail.com', '$2y$10$CwJLT0w0.DLyI/V.95OvVONE/UsZc6TsIJkNhlKWO6EzvHyhtd8u2', 'EST', 'ACTIVO', 1, 'perfil_6868de163522a.jpg', NULL, NULL),
(88, 'Patricio', 'Jaramillo', '1800034257', NULL, '', '2000-06-27', '0995643234', 'Ambato, Huachi', 'cjurado5795@uta.edu.ec', '$2y$10$JxEajy/LAlIy1P4qlCPxJeBm917Lw4TGKu6DzBul4KU57uAT6vUu2', 'DOC', 'ACTIVO', 1, 'perfil_68542abd32162_perfil_patricio_jaramillo.png', NULL, NULL),
(89, 'Josue', 'Llumitasig', '1500453808', NULL, 'matricula_68630880e9291.pdf', '2002-09-29', '0999335938', 'El Panecillo', 'jllumitasig2280@uta.edu.ec', '$2y$10$5l7HO2wZamUE/R3Wm9RteOR6kq2TBvIdqGjHs5WrfV4wAHZb1QSuy', 'EST', 'ACTIVO', 1, 'perfil_6868e1c18da58.png', NULL, NULL),
(90, 'Daniel', 'Bastidas ', '1223498498', NULL, NULL, '2000-09-19', '0999950930', 'Quisapincha', 'dbastidas@uta.edu.ec', '$2y$10$ok8u/VBfL27tQuFjcdfOCOOlu.f01acfsgnwl.pYyrtyDkkPCgTwO', 'DOC', 'ACTIVO', 1, 'perfil_6868e1dfa5e59.png', NULL, NULL);

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
(9, 87, 16),
(10, 89, 43),
(11, 90, 44);

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
-- Indices de la tabla `autoridades`
--
ALTER TABLE `autoridades`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `FACULTAD_ID` (`FACULTAD_SECUENCIAL`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`SECUENCIAL`),
  ADD KEY `SECUENCIALFACULTAD` (`SECUENCIALFACULTAD`);

--
-- Indices de la tabla `carrusel`
--
ALTER TABLE `carrusel`
  ADD PRIMARY KEY (`SECUENCIAL`);

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
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`SECUENCIAL`);

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
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT de la tabla `asistencia_nota`
--
ALTER TABLE `asistencia_nota`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `autoridades`
--
ALTER TABLE `autoridades`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `carrusel`
--
ALTER TABLE `carrusel`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `categoria_evento`
--
ALTER TABLE `categoria_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `certificado`
--
ALTER TABLE `certificado`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT de la tabla `evento_carrera`
--
ALTER TABLE `evento_carrera`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facultad`
--
ALTER TABLE `facultad`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `imagen_evento`
--
ALTER TABLE `imagen_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1078;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `organizador_evento`
--
ALTER TABLE `organizador_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `recepcion_cambio`
--
ALTER TABLE `recepcion_cambio`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `requisito_evento`
--
ALTER TABLE `requisito_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `solicitud_cambio`
--
ALTER TABLE `solicitud_cambio`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `usuario_carrera`
--
ALTER TABLE `usuario_carrera`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- Filtros para la tabla `autoridades`
--
ALTER TABLE `autoridades`
  ADD CONSTRAINT `autoridades_ibfk_1` FOREIGN KEY (`FACULTAD_SECUENCIAL`) REFERENCES `facultad` (`SECUENCIAL`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `evento_ibfk_4` FOREIGN KEY (`SECUENCIALCATEGORIA`) REFERENCES `categoria_evento` (`SECUENCIAL`);

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
