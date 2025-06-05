-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2025 a las 08:39:31
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
(12, 1007, 1, 'requisito_683a6794e8a5e.pdf', 'VAL'),
(13, 1007, 2, 'requisito_683a67a5b1dee.pdf', 'VAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_nota`
--

CREATE TABLE `asistencia_nota` (
  `SECUENCIAL` int(11) NOT NULL,
  `SECUENCIALEVENTO` int(11) DEFAULT NULL,
  `SECUENCIALUSUARIO` int(11) DEFAULT NULL,
  `ASISTIO` tinyint(1) DEFAULT NULL,
  `NOTAFINAL` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `asistencia_nota`
--

INSERT INTO `asistencia_nota` (`SECUENCIAL`, `SECUENCIALEVENTO`, `SECUENCIALUSUARIO`, `ASISTIO`, `NOTAFINAL`) VALUES
(7, 152, 11, 1, 10.00);

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
(46, 'Trabajo Social', 10);

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
  `TIPO_CERTIFICADO` varchar(20) DEFAULT NULL,
  `URL_CERTIFICADO` varchar(255) DEFAULT NULL,
  `FECHA_EMISION` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `certificado`
--

INSERT INTO `certificado` (`SECUENCIAL`, `SECUENCIALUSUARIO`, `SECUENCIALEVENTO`, `TIPO_CERTIFICADO`, `URL_CERTIFICADO`, `FECHA_EMISION`) VALUES
(6, 11, 152, NULL, 'certificado_11_152_1748986054.pdf', '2025-06-03 16:27:34');

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
('COM', 'Completado'),
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
  `DESCRIPCION` text DEFAULT NULL,
  `CODIGOTIPOEVENTO` varchar(20) DEFAULT NULL,
  `FECHAINICIO` date NOT NULL,
  `FECHAFIN` date NOT NULL,
  `CODIGOMODALIDAD` varchar(20) DEFAULT NULL,
  `HORAS` int(11) NOT NULL,
  `NOTAAPROBACION` decimal(4,2) NOT NULL,
  `ES_PAGADO` tinyint(1) NOT NULL CHECK (`ES_PAGADO` in (0,1)),
  `COSTO` decimal(10,2) NOT NULL DEFAULT 0.00 CHECK (`COSTO` >= 0),
  `SECUENCIALCARRERA` int(11) DEFAULT NULL,
  `ES_SOLO_INTERNOS` tinyint(1) NOT NULL DEFAULT 0 CHECK (`ES_SOLO_INTERNOS` in (0,1)),
  `SECUENCIALCATEGORIA` int(11) DEFAULT NULL,
  `ESTADO` enum('DISPONIBLE','CERRADO','CANCELADO') NOT NULL DEFAULT 'DISPONIBLE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`SECUENCIAL`, `TITULO`, `DESCRIPCION`, `CODIGOTIPOEVENTO`, `FECHAINICIO`, `FECHAFIN`, `CODIGOMODALIDAD`, `HORAS`, `NOTAAPROBACION`, `ES_PAGADO`, `COSTO`, `SECUENCIALCARRERA`, `ES_SOLO_INTERNOS`, `SECUENCIALCATEGORIA`, `ESTADO`) VALUES
(152, ' semFYC', '🩺 ¡Actualízate con los mejores expertos en medicina desde donde estés! 🌐\r\n\r\nTe invitamos a participar en nuestra serie de webinarios médicos diseñados para profesionales de la salud, estudiantes y especialistas que buscan mantenerse al día con los últimos avances científicos, diagnósticos y tratamientos en diversas áreas de la medicina.\r\n\r\n📚 ¿Qué ofrecemos?\r\n✔️ Charlas en vivo con ponentes nacionales e internacionales\r\n✔️ Casos clínicos interactivos y análisis de evidencia actual\r\n✔️ Certificados de participación\r\n✔️ Espacio para preguntas y networking virtual\r\n\r\n🔍 Temáticas destacadas:\r\n\r\n    Medicina interna\r\n\r\n    Pediatría y ginecología\r\n\r\n    Cardiología y neurología\r\n\r\n    Salud pública y atención primaria\r\n\r\n    Innovaciones tecnológicas en el ámbito clínico.', 'SEM', '2025-06-01', '2025-06-01', 'PRES', 20, 0.00, 1, 15.00, 10, 0, 1, 'DISPONIBLE'),
(155, '31º Congreso de Pediatría (IPA) ', 'Organizado por la International Pediatric Association (IPA), en colaboración con la Asociación Mexicana de Pediatría (AMP) y la Confederación Nacional de Pediatría de México (CONAPEME), el congreso ofreció un espacio para compartir conocimientos, experiencias e innovaciones en el cuidado de la salud infantil.\r\n31° CONGRESO IPA\r\n🧠 Temáticas Destacadas\r\n\r\nEl programa académico abordó una amplia gama de temas, incluyendo:\r\n\r\n    Nutrición y desarrollo infantil\r\n\r\n    Salud mental en la infancia y adolescencia\r\n\r\n    Avances en enfermedades infecciosas pediátricas\r\n\r\n    Innovaciones en tratamientos y tecnologías médicas\r\n\r\n    Prevención y manejo de enfermedades crónicas en niños\r\n    Sociedad Argentina de Pediatría+3Cadena SER+3plandeactividades.com+3\r\n\r\nAdemás, se llevaron a cabo simposios, talleres prácticos y sesiones interactivas con expertos internacionales, fomentando el intercambio de conocimientos y experiencias entre los asistentes.\r\n🌍 Participación Internacional\r\n\r\nEl congreso contó con la participación de destacados ponentes y profesionales de la pediatría a nivel mundial, promoviendo la colaboración internacional y el fortalecimiento de redes profesionales en pro de la salud infantil.', 'CONF', '2025-06-05', '2025-06-05', 'PRES', 3, 0.00, 1, 5.00, 16, 0, 5, 'DISPONIBLE'),
(156, 'Java', '¿Quieres dominar uno de los lenguajes de programación más solicitados por las empresas? ¡Este curso de Java es para ti! 🌐💻\r\n\r\nEn nuestro curso aprenderás desde los fundamentos hasta conceptos intermedios y avanzados, con un enfoque 100% práctico. Aprenderás a desarrollar aplicaciones sólidas, seguras y multiplataforma, y te prepararás para el mundo laboral o proyectos propios.', 'CUR', '2025-06-01', '2025-06-06', 'VIRT', 32, 7.50, 1, 30.00, 43, 0, 1, 'DISPONIBLE'),
(157, 'JavaScript 1', 'Este curso de JavaScript está diseñado para introducir a los estudiantes en uno de los lenguajes de programación más utilizados en el desarrollo web. A lo largo del curso, los participantes aprenderán desde los fundamentos básicos de JavaScript hasta conceptos intermedios y avanzados que les permitirán crear sitios web interactivos y dinámicos.\r\n\r\nEl contenido incluye variables, estructuras de control, funciones, eventos, manipulación del DOM, manejo de errores, y el uso de APIs. Además, se abordarán principios modernos de desarrollo como ES6+, programación orientada a objetos y buenas prácticas de codificación.', 'CUR', '2025-06-01', '2025-06-15', 'VIRT', 90, 7.00, 1, 45.00, 43, 0, 1, 'DISPONIBLE');

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
('PYP', 'PayPal'),
('TARJ', 'Tarjeta de Crédito'),
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
(18, 157, 'public/img/portada_683ce572e3b06_js.jpg', 'PORTADA'),
(19, 157, 'public/img/galeria_683ce572e4340_galeria js.png', 'GALERIA'),
(20, 156, 'public/img/portada_683ce6a8cbb15_java.jpg', 'PORTADA'),
(21, 156, 'public/img/galeria_683ce6a8cc4fd_galeria java.jpg', 'GALERIA'),
(22, 155, 'public/img/portada_683ce7ab48674_congreso.png', 'PORTADA'),
(23, 155, 'public/img/galeria_683ce7ab49091_galeria congreso.png', 'GALERIA'),
(24, 152, 'public/img/portada_683ce8dfa6ac1_webnaris.jpg', 'PORTADA'),
(25, 152, 'public/img/galeria_683ce8dfa75a1_galeria Webnairs.jpg', 'GALERIA');

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
(1007, 152, 11, '2025-05-30 12:00:00', 'factura_683a640ce893b.pdf', 'ACE');

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
(52, 155, 12, 'RESPONSABLE'),
(53, 156, 12, 'RESPONSABLE'),
(54, 157, 12, 'RESPONSABLE'),
(70, 157, 12, 'ORGANIZADOR'),
(71, 152, 12, 'RESPONSABLE'),
(72, 152, 12, 'ORGANIZADOR');

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
  `FECHA_APROBACION` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`SECUENCIAL`, `SECUENCIALINSCRIPCION`, `CODIGOFORMADEPAGO`, `COMPROBANTE_URL`, `CODIGOESTADOPAGO`, `SECUENCIAL_USUARIO_APROBADOR`, `FECHA_PAGO`, `FECHA_APROBACION`) VALUES
(1, 1007, 'EFEC', '/comprobante', 'VAL', 12, '2025-06-01 19:43:20', '2025-06-25 00:42:58');

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
(3, NULL, 'Comprobante de pago', NULL),
(4, NULL, 'Certificado de vacunación COVID-19', NULL),
(5, NULL, 'Carta de autorización de la facultad', NULL),
(6, NULL, 'Ensayo o trabajo previo requerido', NULL),
(7, NULL, 'Presentación o diapositivas (para ponentes)', NULL),
(8, NULL, 'Formulario de inscripción firmado', NULL),
(9, NULL, 'Certificado de conocimiento previo', NULL),
(10, NULL, 'Carta de invitación oficial', NULL),
(11, NULL, 'Foto tipo carnet actualizada', NULL),
(12, NULL, 'Aval académico', NULL),
(13, NULL, 'Contrato o acuerdo de participación', NULL),
(14, NULL, 'Permiso de salida institucional', NULL),
(19, NULL, 'Constancia de asistencia a módulo anterior', NULL),
(20, NULL, 'Historial académico actualizado', NULL),
(39, 157, 'Comprobante de pago', NULL),
(40, 157, 'Foto tipo carnet actualizada', NULL),
(41, 156, 'Cédula o documento de identidad', NULL),
(42, 156, 'Comprobante de pago', NULL),
(43, 156, 'Formulario de inscripción firmado', NULL),
(44, 156, 'Resumen o abstract del tema propuesto', NULL);

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
('DOC', 'DOCENTE'),
('EST', 'ESTUDIANTE'),
('INV', 'INVITADO');

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
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  `TELEFONO` varchar(20) NOT NULL,
  `DIRECCION` varchar(255) DEFAULT NULL,
  `CORREO` varchar(100) NOT NULL,
  `CONTRASENA` varchar(255) NOT NULL,
  `CODIGOROL` varchar(20) NOT NULL,
  `CODIGOESTADO` varchar(10) NOT NULL CHECK (`CODIGOESTADO` in ('ACTIVO','INACTIVO','BLOQUEADO')),
  `ES_INTERNO` tinyint(1) NOT NULL CHECK (`ES_INTERNO` in (0,1)),
  `FOTO_PERFIL` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`SECUENCIAL`, `NOMBRES`, `APELLIDOS`, `FECHA_NACIMIENTO`, `TELEFONO`, `DIRECCION`, `CORREO`, `CONTRASENA`, `CODIGOROL`, `CODIGOESTADO`, `ES_INTERNO`, `FOTO_PERFIL`) VALUES
(11, 'Juan', 'Jurado', '2000-05-10', '0992222222', 'Dirección estudiante', 'juan@uta.edu.ec', 'juan123', 'EST', 'ACTIVO', 1, 'foto_est.jpg'),
(12, 'Lucía', 'Rivas', '1990-03-15', '0993333333', 'Dirección docente', 'lucia@uta.edu.ec', '$2y$10$HMdTkyEy1uXQ04Q3piAZkOnqS5hRF7UWqkqyk2hFdcQWf.t8psBBy', 'DOC', 'ACTIVO', 1, 'Cris.jpg'),
(13, 'Marco', 'López', '1988-07-22', '0994444444', 'Dirección invitado', 'marco@gmail.com', '$2y$10$kqR7ELnnF8TPwLvT.Vuua.sY42HPhSx5kZnP4PDHppEcRH4ENYlhS', 'INV', 'ACTIVO', 1, 'foto_inv.jpg'),
(14, 'Cristian', 'Jurado', NULL, '0982184126', 'Archidona, Barrio PIEDRA GRANDE', 'ernestojurado2004@gmail.com', '$2y$10$/sAAKQhvFhSIWVx6KwKUJeclYV1ya0csfsZCPasamfygRw6QmCrYW', 'ADM', 'ACTIVO', 1, NULL);

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
(6, 11, 37),
(7, 12, 43);

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
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `asistencia_nota`
--
ALTER TABLE `asistencia_nota`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `categoria_evento`
--
ALTER TABLE `categoria_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `certificado`
--
ALTER TABLE `certificado`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT de la tabla `facultad`
--
ALTER TABLE `facultad`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `imagen_evento`
--
ALTER TABLE `imagen_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1012;

--
-- AUTO_INCREMENT de la tabla `organizador_evento`
--
ALTER TABLE `organizador_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `requisito_evento`
--
ALTER TABLE `requisito_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuario_carrera`
--
ALTER TABLE `usuario_carrera`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Filtros para la tabla `requisito_evento`
--
ALTER TABLE `requisito_evento`
  ADD CONSTRAINT `requisito_evento_ibfk_1` FOREIGN KEY (`SECUENCIALEVENTO`) REFERENCES `evento` (`SECUENCIAL`);

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
