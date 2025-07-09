-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-07-2025 a las 13:15:16
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
(160, 1092, 146, 'requisito_686e49478951d.pdf', 'VAL');

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
(34, 181, 95, 1, 80.00, 8.00, NULL);

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
(12, 'Programación web Alto Nivel', NULL, 'public/img/carrusel/6868601652ab6_ChatGPT Image 4 jul 2025, 18_12_39.png', NULL, 0, 1, '2025-07-04 23:13:26', 'HTML, CSS y lógica en acción'),
(13, 'Lenguajes esenciales para desarrollo web', NULL, 'public/img/carrusel/686864af2ca50_ChatGPT Image 4 jul 2025, 18_32_53.png', NULL, 0, 0, '2025-07-04 23:33:03', 'HTML, CSS y JavaScript en acción'),
(14, 'softaer', NULL, 'public/img/carrusel/6868b0667036e_webnair galeria.jpg', NULL, 0, 0, '2025-07-05 04:56:06', 'mkmcksmd'),
(15, 'prueba', NULL, 'public/img/carrusel/686b23352363a_portada_686947237534f.jpg', NULL, 0, 0, '2025-07-07 01:30:29', 'smkdmskmskd'),
(16, 'mkmdkmd', NULL, 'public/img/carrusel/686b243362d8b_portada_686b1d8470feb.jpg', NULL, 0, 0, '2025-07-07 01:34:43', 'sdmksmdksdm'),
(17, 'Taller de Desarrollo Web Frontend', NULL, 'public/img/carrusel/686b257c62eba_portada_68542c2a2f47a_python1.jpg', NULL, 0, 0, '2025-07-07 01:40:12', 'sdsdsd'),
(18, 'mkmkm', NULL, 'public/img/carrusel/686b26938818c_portada_686b1d8470feb.jpg', NULL, 0, 0, '2025-07-07 01:44:51', 'mkmkmkm'),
(19, 'mmkmk', NULL, 'public/img/carrusel/686b26ae813cd_portada_686aeca728445.png', NULL, 0, 0, '2025-07-07 01:45:18', 'mkmkmkm'),
(20, 'mkmkmkm', NULL, 'public/img/carrusel/686b270f9e775_portada_686aeca728445.png', NULL, 0, 0, '2025-07-07 01:46:55', 'mkmkmkmk');

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
  `ES_PAGADO` tinyint(1) NOT NULL,
  `COSTO` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ES_SOLO_INTERNOS` tinyint(1) NOT NULL DEFAULT 0,
  `SECUENCIALCATEGORIA` int(11) DEFAULT NULL,
  `ESTADO` enum('DISPONIBLE','CERRADO','CANCELADO','EN CURSO','FINALIZADO','CREADO') NOT NULL,
  `CAPACIDAD` int(11) DEFAULT NULL,
  `ES_DESTACADO` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si el evento es destacado (1) o no (0)',
  `ASISTENCIAMINIMA` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`SECUENCIAL`, `TITULO`, `CONTENIDO`, `DESCRIPCION`, `CODIGOTIPOEVENTO`, `FECHAINICIO`, `FECHAFIN`, `CODIGOMODALIDAD`, `HORAS`, `NOTAAPROBACION`, `ES_PAGADO`, `COSTO`, `ES_SOLO_INTERNOS`, `SECUENCIALCATEGORIA`, `ESTADO`, `CAPACIDAD`, `ES_DESTACADO`, `ASISTENCIAMINIMA`) VALUES
(179, 'Administración de Amenazas Cibernéticas', '<ul><li><strong>Módulo 1: Defensa de la Red</strong><ul><li>Capítulo 1:Comprendiendo la Defensa</li><li>Capítulo 2: Defensa de Sistemas y Redes</li><li>Capítulo 3:Control de Acceso</li><li>Capítulo 4: Listas de Control de Acceso</li><li>Capítulo 5: Tecnologías de Firewall</li><li>Capítulo 6: Firewalls de Política Basados en Zonas</li><li>Capítulo 7: Seguridad en la Nube</li><li>Capítulo 8: Criptografía</li><li>Capítulo 9: Tecnologías y Protocolos</li><li>Capítulo 10: Datos de Seguridad de la Red</li><li>Capítulo 11: Evaluación de Alertas</li></ul></li><li><strong>Módulo 2: Administración de Amenazas Cibernéticas</strong><ul><li>Capítulo 1: Gobernanza y Cumplimiento</li><li>Capítulo 2: Pruebas de seguridad de red</li><li>Capítulo 3: Inteligencia de amenazas</li><li>Capítulo 4: Evaluación de la vulnerabilidad de los endpoints</li><li>Capítulo 5: Gestión de Riesgos y Controles de Seguridad</li><li>Capítulo 6: Forense digital y Análisis y respuesta a incidentes</li></ul></li></ul>', '<p>Este curso cubre diferentes métodos para monitorear la red y cómo evaluar las alertas de seguridad. Se profundiza en las herramientas y técnicas utilizadas para proteger la red, incluido el control de acceso, firewalls, seguridad en la nube y criptografía. Permite explorar la gobernanza en la ciberseguridad y la gestión de amenazas, mediante el desarrollo de políticas para que la organización cumpla con los estándares de ética y los marcos legales y regulatorios.</p><h2>OBJETIVOS</h2><ul><li>Explicar los enfoques para la defensa de la seguridad de la red.</li><li>Implementar listas de control de acceso (ACL), firewall para filtrar el tráfico y mitigar los ataques a la red.</li><li>Determinar las técnicas criptográficas que se requieren para garantizar la confidencialidad, la integridad y la autenticidad.</li><li>Impulsar el desarrollo de proyectos de mejora continua dentro del campo empresarial.</li></ul><h2><strong>LUGAR DE CELEBRACIÓN</strong></h2><p>Facultad de Ingeniería en Sistemas, Electrónica e Industrial.</p><ul><li>Avda. Los Chasquis entre Río Payamino y Río Guayllabamba</li><li>Campus Huachi, Ambato-Ecuador.</li><li><a href=\"https://ctt-talleresfisei.uta.edu.ec/edu/login/index.php\">Aula virtual de los Talleres Tecnológicos – FISEI</a></li></ul><p>&nbsp;</p>', 'CUR', '2025-09-09', '2025-09-12', 'VIRT', 48, NULL, 1, 40.00, 0, 4, 'DISPONIBLE', 20, 1, 70.00),
(180, 'JavaScript Essentials 2', '<ul><li><strong>Módulo 1: Objetos sin clases</strong>&nbsp;Manipulación de objetos, comparación, clonación, métodos, getters/setters, prototipos y herencia.</li><li><strong>Módulo 2: Clases y programación basada en clases</strong>&nbsp;Declaración de clases, propiedades, herencia, miembros estáticos, getters y setters.</li><li><strong>Módulo 3: Objetos integrados</strong>&nbsp;Uso de objetos como String, Date, Array, Map, Set; manejo de JSON; operaciones matemáticas y expresiones regulares</li><li><strong>Módulo 4: Uso avanzado de funciones&nbsp;</strong>Parámetros extendidos, closures, funciones de orden superior, generadores, programación asincrónica con callbacks y promesas.</li></ul>', '<p>JavaScript Essentials 2 es un curso avanzado diseñado para profundizar en las capacidades de programación con JavaScript, abordando conceptos avanzados como la programación orientada a objetos (OOP), técnicas funcionales y asincrónicas. A través de un enfoque práctico, los estudiantes aprenderán a analizar y resolver problemas del mundo real, trabajar con estructuras de datos complejas y desarrollar aplicaciones más eficientes y escalables. Este curso prepara a los participantes construir un portafolio profesional que demuestre habilidades avanzadas en el desarrollo de aplicaciones con JavaScript.</p><h2>OBJETIVOS</h2><ul><li>Comprender e implementar clases y programación basada en clases para estructurar aplicaciones siguiendo principios modernos de diseño orientado a objetos.</li><li>Explorar y utilizar objetos integrados y estructuras avanzadas como Map, Set y JSON para optimizar el manejo de datos y mejorar el rendimiento de las aplicaciones</li><li>Aplicar técnicas avanzadas de programación funcional y asincrónica usando closures, funciones de orden superior, generadores y promesas para gestionar tareas complejas y asincrónicas.</li><li>Desarrollar habilidades analíticas y prácticas en resolución de problemas aplicando conceptos de JavaScript en proyectos prácticos para construir un portafolio competitivo.&nbsp;</li></ul><h2>LUGAR DE CELEBRACIÓN</h2><p>Facultad de Ingeniería en Sistemas, Electrónica e Industrial, CTT-FISEI. Campus Huachi, Ambato-Ecuador.</p>', 'CUR', '2025-09-09', '2025-09-10', 'PRES', 5, NULL, 1, 10.00, 0, 4, 'DISPONIBLE', 40, 1, 70.00),
(181, ' ETHICAL HACKER', '<ul><li><strong>Módulo 1: Introducción al hacking ético y a las pruebas de penetración</strong><br>1.1 Entendiendo el Hacking Ético y la Penetración Pruebas<br>1.2 Exploración de metodologías de pruebas de penetración<br>1.3 Construir su propio laboratorio</li><li><strong>Módulo 2: Planificación y alcance de una prueba de penetración Evaluación</strong><br>2.1 Comparación y contraste de los conceptos de gobernanza, riesgo y cumplimiento normativo<br>2.2 Explicar la importancia del alcance y los requisitos de la organización o del cliente<br>2.3 Demostrar una mentalidad de hacking ético manteniendo el profesionalismo y la integridad</li><li><strong>Módulo 3: Recopilación de información y exploración de vulnerabilidades</strong><br>3.1 Realización de un reconocimiento pasivo<br>3.2 Realización de un reconocimiento activo<br>3.3 Entender el arte de realizar escaneos de vulnerabilidades<br>3.4 Cómo analizar los resultados de la exploración de vulnerabilidades</li><li><strong>Módulo 4: Ataques de Ingeniería Social</strong><br>4.1 Pretexto para un acercamiento y suplantación de identidad<br>4.2 Ataques de ingeniería social<br>4.3 Ataques físicos<br>4.4 Herramientas de ingeniería social<br>4.5 Métodos de influencia</li><li><strong>Módulo 5: Ataques de Ingeniería Social</strong><br>5.1 Explotación de vulnerabilidades basadas en la red<br>5.2 Explotación de vulnerabilidades inalámbricas.</li><li><strong>Módulo 6: Explotación de vulnerabilidades basadas en aplicaciones</strong><br>6.1 Visión general de los ataques basados en aplicaciones web para profesionales de seguridad y los 10 principales de OWASP<br>6.2 Cómo construir su propio laboratorio de aplicaciones web<br>6.3 Entendiendo las fallas en la lógica del negocio<br>6.4 Entender las vulnerabilidades basadas en inyección<br>6.5 Explotación de vulnerabilidades basadas en autenticación<br>6.6 Explotación de vulnerabilidades basadas en autorización<br>6.7 Descripción de vulnerabilidades de secuencias de comandos en sitios cruzados (XSS)<br>6.8 Entender la Falsificación de Peticiones en Sitios Cruzados (CSRF/XSRF)(CSRF/XSRF) y Ataques de Falsificación de Peticiones del Lado del Servidor<br>6.9 Entendiendo Clickjacking<br>6.10 Explotación de vulnerabilidades de inclusión de archivos<br>6.11 Explotación de prácticas de código inseguro</li><li><strong>Módulo 7: Seguridad en la nube, móvil e IoT</strong><br>7.1 Investigación de vectores de ataque y realización de ataques en tecnologías de nube<br>7.2 Explicación de ataques y vulnerabilidades comunes contra sistemas especializados</li><li><strong>Módulo 8: Realización de técnicas de post-explotación</strong><br>8.1 Creación de un punto de apoyo y mantener la persistencia después de comprometer un sistema<br>8.2 Realización de movimientos laterales, evasión de detección y enumeración</li><li><strong>Módulo 9:Informes y comunicación</strong><br>9.1 Comparación y contraste de los componentes importantes de los informes escritos<br>9.2 Análisis de los hallazgos y recomendar la remediación apropiada dentro de un informe<br>9.3 Explicación de la importancia de la comunicación durante el proceso de pruebas de penetración<br>9.4 Explicación de las actividades posteriores a la entrega del informe</li><li><strong>Módulo 10: Ataques de Ingeniería Social</strong><br>10.1 Conceptos Básicos de Scripting y Desarrollo de Software.<br>10.2 Comprensión de los Diferentes Casos de Uso de las Herramientas de Pruebas de Penetración y Análisis de Código Exploit.</li></ul>', '<p>El panorama digital está evolucionando a un ritmo sin precedentes y las amenazas cibernéticas acechan en cada esquina. La resiliencia de la ciberseguridad en el mundo moderno no puede ser sólo un complemento: es una necesidad. Los profesionales de seguridad ofensivos, como los piratas informáticos éticos y los evaluadores de penetración, pueden ayudar a descubrir de forma proactiva amenazas desconocidas y abordarlas antes de que lo hagan los ciberdelincuentes.<br>El curso Ethical Hacker prepara a los alumnos para descubrir vulnerabilidades de forma proactiva antes de que lo hagan los ciberdelincuentes. Los alumnos dominarán el arte de determinar el alcance, ejecutar e informar sobre las evaluaciones de vulnerabilidades, al tiempo que recomiendan estrategias de mitigación.</p><h2>OBJETIVOS</h2><ul><li>Analizar la mentalidad y las tácticas de los cibercriminales para fortalecer sus habilidades defensivas.</li><li>Implementar controles de seguridad de manera más efectiva y monitorear, analizar y responder a las amenazas de seguridad actuales.</li><li>Adquirir las habilidades necesarias para implementar seguridad y monitorear, analizar y y responder a las amenazas de seguridad actuales.&nbsp;</li></ul><h2>LUGAR DE CELEBRACIÓN</h2><p>Facultad de Ingeniería en Sistemas, Electrónica e Industria, Avda. Los Chasquis entre Río Payamino y Río Guayllabamba, Campus Huachi, Ambato-Ecuador.</p>', 'CUR', '2025-08-17', '2025-08-19', 'PRES', 23, NULL, 1, 10.00, 1, 4, 'FINALIZADO', 30, 1, 70.00),
(182, 'LA LEY DE PROTECCIÓN DE DATOS ', '<ul><li><strong>Clase 1:</strong>&nbsp;Fundamentos de la Protección de Datos Personales: Contexto Nacional e Internacional</li><li><strong>Clase 2:</strong>&nbsp;Derechos del Titular y Obligaciones de los Responsables del Tratamiento</li><li><strong>Clase 3:</strong>&nbsp;Gestión y Seguridad de los Datos en Organizaciones</li><li><strong>Clase 4:</strong>&nbsp;Aplicación Práctica y Casos Reales</li></ul>', '<p>Este curso tiene como objetivo ofrecer a estudiantes, docentes y al público en general una comprensión sólida sobre la Ley Orgánica de Protección de Datos Personales (LOPDP) de Ecuador y su reglamento. A través de un análisis de los fundamentos legales, principios clave y casos prácticos, los participantes aprenderán a identificar los derechos que tienen como titulares de datos, así como las responsabilidades que deben cumplir las instituciones, tanto públicas como privadas, al manejar información personal.<br><br>La propuesta académica se basa en ejemplos reales de políticas internas, normativas internacionales y estándares como el GDPR europeo. El curso promueve una perspectiva humanista sobre la protección de datos, fomentando el uso responsable de la información como un derecho fundamental y un aspecto esencial en nuestra sociedad digital.</p><h2>OBJETIVOS</h2><h3>Objetivo Principal</h3><p>Capacitar a estudiantes, docentes y ciudadanía en general en los principios, derechos y obligaciones establecidos por la Ley Orgánica de Protección de Datos Personales del Ecuador, promoviendo una cultura de respeto a la privacidad, responsabilidad en el tratamiento de datos y cumplimiento normativo en contextos educativos, laborales y sociales.</p><h2>LUGAR DE CELEBRACIÓN</h2><p>Facultad de Ingeniería en Sistemas, Electrónica e Industrial.</p><ul><li>Centro de Transferencia y Desarrollo de Tecnologías CTT-FISEI.</li><li>Avda. Los Chasquis entre Río Payamino y Río Guayllabamba</li><li>Campus Huachi, Ambato-Ecuador.</li></ul>', 'CUR', '2025-09-17', '2025-09-18', 'PRES', 7, NULL, 1, 60.00, 1, 3, 'DISPONIBLE', 20, 1, 100.00),
(183, 'CONCEPTOS BÁSICOS DE REDES', '<p>&nbsp;</p><ul><li><strong>Módulo 1: Comunicación en un mundo conectado</strong><br>Tipos de red<br>Transmisión de datos<br>Ancho de banda y rendimiento</li><li><strong>Módulo 2:Componentes, tipos y conexiones de red</strong><br>Clientes y Servidores<br>Componentes de la red<br>Opciones de conectividad al ISP</li><li><strong>Módulo 3: Redes inalámbricas y móviles</strong><br>Redes inalámbricas<br>Conectividad de dispositivos móviles</li><li><strong>Módulo 4:Crear una red domestica</strong><br>Conceptos básicos de redes domesticas<br>Tecnologías de red en el hogar<br>Estándares inalámbricos<br>Configurar un enrutador domestico</li><li><strong>Módulo 5: Principios de comunicación</strong><br>Protocolo de comunicación<br>Estándares de comunicación<br>Modelos de comunicación de red</li><li><strong>Módulo 6: Medios de red</strong><br>Tipos de medios de red</li><li><strong>Módulo 7: La capa de acceso</strong><br>Encapsulación y la trama de Ethernet<br>La capa de acceso</li><li><strong>Módulo 8: El protocolo de internet</strong><br>Propósito de una dirección IPv4<br>La estructura de la dirección IPv4</li><li><strong>Módulo 9: IPv4 y segmentación de redes</strong><br>Unidifusión, difusión y multidifusión de IPv4<br>Tipos de direcciones IPv4<br>Segmentación de la red</li><li><strong>Módulo 10: Formatos y reglas de direccionamiento IPv6</strong><br>Problemas con IPv4<br>Direccionamiento IPv6</li><li><strong>Módulo 11: Direccionamiento dinámico con DHCP</strong><br>Direccionamiento estático y dinámico<br>Configuración de DHCPv4</li><li><strong>Módulo 12: Puertas de enlace a otras redes</strong><br>Límites de la Red<br>Traducción de direcciones de red</li><li><strong>Módulo 13: El proceso ARP</strong><br>MAC e IP<br>Contención de difusiones</li><li><strong>Módulo 14: Enrutamiento entre redes</strong><br>La necesidad del enrutamiento<br>La tabla de enrutamiento<br>Crear una LAN</li></ul>', '<p>Este curso cubre la base de redes y dispositivos de red, medios y protocolos. Observará datos que fluyen a través de una red y configurará dispositivos para conectarse a redes. Por último, aprenderá a usar diferentes aplicaciones y protocolos de red para realizar tareas de red. El conocimiento y las habilidades que obtenga le pueden dar un punto de partida para encontrar una carrera gratificante en tecnología.</p><h2>OBJETIVOS DEL CURSO</h2><ul><li>Comprender cómo las redes conectan el mundo, identificando los diferentes tipos de redes, cómo se transmiten los datos, y el impacto del ancho de banda y el rendimiento en la comunicación.</li><li>Adquirir conocimientos prácticos para diseñar y gestionar redes, tanto inalámbricas como móviles, incluyendo la creación de redes domésticas, con un enfoque en los componentes de la red, opciones de conectividad y configuraciones de enrutadores.</li><li>Dominar los fundamentos de la comunicación en red, incluyendo los principios de la comunicación, los medios de red, la capa de acceso, el protocolo de Internet (IPv4 e IPv6), y comprender la importancia del direccionamiento dinámico con DHCP, el enrutamiento entre redes, y los servicios de la capa de aplicación.</li></ul><h2>LUGAR DE CELEBRACIÓN</h2><p>Facultad de Ingeniería en Sistemas, Electrónica e Industrial., Avda. Los Chasquis entre Río Payamino y Río Guayllabamba, Campus Huachi, Ambato-Ecuador.</p>', 'CUR', '2025-09-10', '2025-10-11', 'VIRT', 60, NULL, 0, 0.00, 0, 4, 'DISPONIBLE', 50, 0, 70.00),
(188, 'Descubre tu Poder Personal', '<h2>&nbsp;</h2><p><strong>1. Introducción al poder personal</strong></p><ul><li>¿Qué es y por qué lo hemos perdido?</li><li>Causas comunes de desconexión interna</li></ul><p><strong>2. Autoconocimiento y fortalezas internas</strong></p><ul><li>Dinámica de identificación de talentos</li><li>Mapa personal de recursos</li></ul><p><strong>3. Inteligencia emocional práctica</strong></p><ul><li>Reconocimiento y regulación emocional</li><li>Comunicación asertiva y manejo de conflictos</li></ul><p><strong>4. Autoestima y límites sanos</strong></p><ul><li>Cómo decir “no” sin culpa</li><li>Construcción de límites personales</li></ul><p><strong>5. Cierre y plan de acción personal</strong></p><ul><li>Compromisos personales</li><li>Rueda de cierre grupal</li></ul>', '<h4>Este taller vivencial tiene como objetivo ayudarte a reconectar contigo mismo/a, identificar tus fortalezas internas y desarrollar habilidades clave para mejorar tu bienestar personal y profesional. A través de dinámicas grupales, reflexión y herramientas prácticas, los participantes aprenderán a gestionar emociones, establecer límites sanos y potenciar su autoestima.</h4><h2>OBJETIVO:</h2><h4><br>Brindar a los participantes herramientas prácticas para desarrollar su inteligencia emocional, fortalecer su autoestima y mejorar sus relaciones personales y profesionales.</h4><h2>LUGAR:&nbsp;</h2><h4><br>Centro Cultural Comunitario “Raíces Vivas” – Sala 2<br>(Calle Libertad 123, Ciudad Central)</h4>', 'TALL', '2025-09-19', '2025-09-22', 'VIRT', 20, NULL, 1, 5.00, 1, 5, 'DISPONIBLE', 20, 0, 70.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento_carrera`
--

CREATE TABLE `evento_carrera` (
  `ID` int(11) NOT NULL,
  `SECUENCIALEVENTO` int(11) NOT NULL,
  `SECUENCIALCARRERA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evento_carrera`
--

INSERT INTO `evento_carrera` (`ID`, `SECUENCIALEVENTO`, `SECUENCIALCARRERA`) VALUES
(87, 168, 2),
(88, 168, 2),
(89, 176, 40),
(90, 176, 42),
(91, 176, 43),
(92, 176, 40),
(93, 176, 42),
(94, 176, 43),
(95, 171, 3),
(96, 171, 3),
(97, 173, 5),
(98, 173, 5),
(99, 167, 3),
(100, 167, 3),
(101, 172, 3),
(174, 177, 4),
(175, 177, 5),
(176, 178, 2),
(177, 178, 3),
(178, 178, 5),
(190, 184, 16),
(191, 184, 45),
(192, 185, 16),
(193, 185, 45),
(194, 186, 16),
(195, 186, 45),
(196, 187, 16),
(197, 187, 45),
(270, 182, 38),
(271, 182, 43),
(272, 183, 4),
(273, 183, 37),
(274, 179, 37),
(275, 179, 40),
(276, 179, 43),
(277, 180, 40),
(278, 180, 43),
(279, 181, 37),
(280, 181, 43),
(311, 188, 16),
(312, 188, 45),
(313, 189, 3),
(314, 189, 5),
(318, 190, 3),
(319, 190, 4),
(320, 190, 5);

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
('DEP', 'Deposito'),
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
(92, 179, 'portada_686de2e9959f4.jpg', 'PORTADA'),
(93, 179, 'galeria_686de2e996527.jpg', 'GALERIA'),
(94, 180, 'portada_686de83b995b3.png', 'PORTADA'),
(95, 180, 'galeria_686de83b9a4e4.png', 'GALERIA'),
(96, 181, 'portada_686de9f6c3ee2.jpg', 'PORTADA'),
(97, 181, 'galeria_686de9f6c4a90.jpg', 'GALERIA'),
(98, 182, 'portada_686dec5911ae6.jpg', 'PORTADA'),
(99, 182, 'galeria_686dec5912522.jpg', 'GALERIA'),
(100, 183, 'portada_686dedf86e040.jpg', 'PORTADA'),
(101, 183, 'galeria_686dedf86ec05.jpg', 'GALERIA'),
(110, 188, 'portada_686df5bdf3e2f.jpg', 'PORTADA'),
(111, 188, 'galeria_686df5bdf4173.jpg', 'GALERIA');

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
  `MOTIVACION` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`SECUENCIAL`, `SECUENCIALEVENTO`, `SECUENCIALUSUARIO`, `FECHAINSCRIPCION`, `FACTURA_URL`, `CODIGOESTADOINSCRIPCION`, `MOTIVACION`) VALUES
(1092, 182, 95, '2025-07-09 05:20:23', NULL, 'ACE', 'EJEMPLO DE COMO UTULIZARRRRRR');

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
(216, 179, 92, 'RESPONSABLE'),
(217, 179, 92, 'ORGANIZADOR'),
(218, 180, 92, 'RESPONSABLE'),
(219, 180, 92, 'ORGANIZADOR'),
(220, 181, 92, 'RESPONSABLE'),
(221, 181, 92, 'ORGANIZADOR'),
(222, 182, 92, 'RESPONSABLE'),
(223, 182, 92, 'ORGANIZADOR'),
(224, 183, 92, 'RESPONSABLE'),
(225, 183, 92, 'ORGANIZADOR'),
(236, 188, 92, 'RESPONSABLE'),
(237, 188, 92, 'ORGANIZADOR');

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
(48, 1092, 'TRANS', 'comprobante_686e4817908be_prueba_backend.pdf', 'VAL', 92, '2025-07-09 05:44:39', '2025-07-09 05:45:12', 60.00);

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

--
-- Volcado de datos para la tabla `recepcion_cambio`
--

INSERT INTO `recepcion_cambio` (`SECUENCIAL`, `SECUENCIAL_CAMBIO`, `TIPO_ITIL`, `PRIORIDAD`, `CATEGORIA_TECNICA`, `EVALUACION`, `BENEFICIOS`, `IMPACTO_NEGATIVO`, `ACCIONES`, `DECISION`, `OBSERVACIONES`, `RESPONSABLE_TECNICO`, `FECHA_DECISION`) VALUES
(2, 4, 'Normal', 'Media', 'Frontend / Interfaz', 'Es de impacto alto por lo tanto requiere análisis', 'Mejor visualizacion de solciitud de cambio', 'reclamos por usuarios finales.', '-Cambiar Front, css, y js.', 'Rechazado', 'No se puede implementar en este momento por el proyecto.', 'Josue Llumitasig', '2025-07-07 00:00:00');

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
(4, NULL, 'Aval Institucional', NULL),
(5, NULL, 'Carta de autorización de la facultad', NULL),
(6, NULL, 'Ensayo o trabajo previo requerido', NULL),
(7, NULL, 'Certificado de Aprobación Inglés B1', NULL),
(9, NULL, 'Ticket de descuento', NULL),
(10, NULL, 'Carta de invitación oficial', NULL),
(142, NULL, 'Acta de Matrimonio', NULL),
(146, 182, 'Cédula o documento de identidad', NULL),
(147, 182, 'Comprobante de matrícula vigente', NULL),
(148, 182, 'Aval Institucional', NULL),
(149, 183, 'Cédula o documento de identidad', NULL),
(150, 183, 'Comprobante de matrícula vigente', NULL),
(151, 183, 'Carta de autorización de la facultad', NULL),
(152, 179, 'Cédula o documento de identidad', NULL),
(153, 179, 'Comprobante de matrícula vigente', NULL),
(154, 179, 'Certificado de Aprobación Inglés B1', NULL),
(155, 180, 'Cédula o documento de identidad', NULL),
(156, 180, 'Comprobante de matrícula vigente', NULL),
(157, 180, 'Ensayo o trabajo previo requerido', NULL),
(158, 181, 'Cédula o documento de identidad', NULL),
(159, 181, 'Comprobante de matrícula vigente', NULL),
(160, 181, 'Ensayo o trabajo previo requerido', NULL);

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
  `SECUENCIAL_USUARIO` int(11) DEFAULT NULL,
  `MODULO_AFECTADO` varchar(100) NOT NULL,
  `TIPO_SOLICITUD` enum('Problema','Mejora','Idea') NOT NULL,
  `DESCRIPCION` text NOT NULL,
  `JUSTIFICACION` text NOT NULL,
  `URGENCIA` enum('Alta','Media','Baja') NOT NULL,
  `ARCHIVO_EVIDENCIA` varchar(255) DEFAULT NULL,
  `ESTADO` enum('Pendiente','Evaluado','Rechazado') DEFAULT 'Pendiente',
  `FECHA_ENVIO` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_cambio`
--

INSERT INTO `solicitud_cambio` (`SECUENCIAL`, `SECUENCIAL_USUARIO`, `MODULO_AFECTADO`, `TIPO_SOLICITUD`, `DESCRIPCION`, `JUSTIFICACION`, `URGENCIA`, `ARCHIVO_EVIDENCIA`, `ESTADO`, `FECHA_ENVIO`) VALUES
(3, NULL, 'Cambiar los eventos Académicos', 'Mejora', 'No se puede saber si un evento es gratis o  no,  solo nos indica el precio que es 0.0 pero al inscribise pide el comprobante de pago.', 'Porque es algo importante para las personas que desea inscribirse', 'Media', 'evidencia_686b19259185f.pdf', 'Pendiente', '2025-07-06 19:47:33'),
(4, NULL, 'Corregir error de formulario', 'Problema', 'No se puede abrir el formulariod de soliticitud de cambio en el home', 'Es importante para reportar los cambios que deberian ir en esa parte.', 'Alta', 'evidencia_686b19e091907.pdf', 'Rechazado', '2025-07-06 19:50:40');

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
('SEM', 'Seminario', 'Evento para todo publico'),
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
(91, 'Cristian', 'Jurado', '1501185795', 'cedula_686dd1b9b17b6.pdf', NULL, '2005-06-17', '0982184126', 'Tena', 'ernestojurado2004@gmail.com', '$2y$10$qNgMoMsGM9OL6Nkfczp.p.YDeRSyRpxVSuCL4Q465cO1VBktNrcn2', 'ADM', 'ACTIVO', 0, 'perfil_686dd1b9b0ccd.jpg', NULL, NULL),
(92, 'Andres', 'Pérez', '1500028987', NULL, NULL, '1991-09-17', '0982184126', 'Ambato-Huachi', 'cjurado5795@uta.edu.ec', '$2y$10$jI31D2optgFl2TNubsnwKOXk0b/xqMlFNZBWRqzKsxXhkoJykIx1C', 'DOC', 'ACTIVO', 1, 'perfil_686dd5a85f483.png', NULL, NULL),
(95, 'Juan', 'Jurado', '1500453806', 'cedula_686e2c6d014d2.pdf', NULL, '2005-07-17', '0982184189', 'Tena', 'juradojuan344@gmail.com', '$2y$10$MgszLjdZIgAyHAXCx7CN0OM5kME1DkoxJq7A0XS9b.C10cOhDNmRq', 'INV', 'ACTIVO', 0, 'perfil_686e2c6d01180.jpg', NULL, NULL);

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
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de la tabla `asistencia_nota`
--
ALTER TABLE `asistencia_nota`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `categoria_evento`
--
ALTER TABLE `categoria_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `certificado`
--
ALTER TABLE `certificado`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT de la tabla `evento_carrera`
--
ALTER TABLE `evento_carrera`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT de la tabla `facultad`
--
ALTER TABLE `facultad`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `imagen_evento`
--
ALTER TABLE `imagen_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1093;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `organizador_evento`
--
ALTER TABLE `organizador_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `recepcion_cambio`
--
ALTER TABLE `recepcion_cambio`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `requisito_evento`
--
ALTER TABLE `requisito_evento`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT de la tabla `solicitud_cambio`
--
ALTER TABLE `solicitud_cambio`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `SECUENCIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

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
