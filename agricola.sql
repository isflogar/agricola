-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-12-2015 a las 15:35:13
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `agricola`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

CREATE TABLE IF NOT EXISTS `acceso` (
  `id_acceso` int(11) NOT NULL AUTO_INCREMENT,
  `id_modulo` int(11) NOT NULL,
  `id_tipo_usuario` int(11) NOT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`id_acceso`),
  KEY `modulo_acceso_fk` (`id_modulo`),
  KEY `tipos_acceso_fk` (`id_tipo_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `acceso`
--

INSERT INTO `acceso` (`id_acceso`, `id_modulo`, `id_tipo_usuario`, `estado`) VALUES
(1, 1, 1, 'A'),
(2, 4, 1, 'A'),
(3, 5, 1, 'A'),
(4, 6, 1, 'A'),
(5, 7, 1, 'A'),
(6, 8, 1, 'A'),
(7, 9, 1, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conocimiento`
--

CREATE TABLE IF NOT EXISTS `conocimiento` (
  `id_conocimiento` int(11) NOT NULL AUTO_INCREMENT,
  `conocimiento` varchar(80) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `color` varchar(10) NOT NULL,
  `toneladas_hectarea` decimal(10,2) NOT NULL,
  `costo_hectarea` decimal(10,2) NOT NULL,
  `porcentaje_ganancia` decimal(10,2) NOT NULL,
  `estado` char(1) NOT NULL,
  `insecticidas` varchar(300) DEFAULT NULL,
  `kilos_hectarea` varchar(100) NOT NULL,
  `periodo_crecimiento` varchar(100) NOT NULL,
  `ganancia` decimal(4,2) NOT NULL,
  PRIMARY KEY (`id_conocimiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `conocimiento`
--

INSERT INTO `conocimiento` (`id_conocimiento`, `conocimiento`, `descripcion`, `imagen`, `color`, `toneladas_hectarea`, `costo_hectarea`, `porcentaje_ganancia`, `estado`, `insecticidas`, `kilos_hectarea`, `periodo_crecimiento`, `ganancia`) VALUES
(1, 'Naranja', 'es una prueba de que la naranja es medio rara', 'img_1334.jpg', '#FF8000', 0.00, 0.00, 0.00, 'I', NULL, '', '', 0.00),
(2, 'Prueba', 'ess la prueba p', 'img_7607.jpg', '', 0.00, 0.00, 0.00, 'I', NULL, '', '', 0.00),
(3, 'Asasa', 'asas', 'img_5638.png', '', 0.00, 0.00, 0.00, 'I', NULL, '', '', 0.00),
(4, 'Sacha Inchi', 'La semilla Sacha Inchi, autóctona de la amazonía peruana fue conocida por los nativos hace miles de años. Tras la conquista de la civilización de los chancas, los inkas comenzaron a representarla en sus cerámicas fruto del conocimiento heredado de la tribu precedente. Esta semilla oleaginosa se conoce también como maní del inka.\r\n\r\nLos estudios científicos actuales señalan el Sacha Inchi como la mejor oleaginosa por su composición y alta calidad nutricional:\r\n\r\nEl aceite tiene alto contenido en ácidos grasos omega 3 (más de 48%), omega 6 (36%) y omega 9 (8%).\r\nSu digestibilidad es muy alta (más de 96%).\r\nContiene antioxidantes  vitamina A y alfa-tocoferol vitamina E.\r\nMás del 60% de la almendra desgrasada es proteína completa de alta calidad (99% digestible).\r\nMuy rica en aminoácidos esenciales y no esenciales, en cantidades suficientes para la salud.', 'img_926.jpg', '#E67300', 0.00, 0.00, 0.00, 'A', '', '1111', '1000 año', 0.25),
(5, 'Cafe', 'El cafeto es un arbusto o árbol pequeño, perennifolio, de fuste recto que puede alcanzar los 10 metros en estado silvestre; en los cultivos se los mantiene normalmente en tamaño más reducido, alrededor de 3 metros. Las hojas son elípticas, oscuras y coriáceas. Florece a partir del tercer o cuarto año de crecimiento, produciendo inflorescencias axilares, fragantes, de color blanco o rosáceo; algunas especies, en especial C. arabica, son capaces de autofertilización, mientras que otras, como C. robusta, son polinizadas por insectos. El fruto es una baya, que se desarrolla en unas 15 semanas a partir de la floración; el endospermo comienza a desarrollarse a partir de la duodécima semana, y acumulará materia sólida en el curso de varios meses, atrayendo casi la totalidad de la energía producida por la fotosíntesis. El mesocarpio forma una pulpa dulce y aromática, de color rojizo, que madura en unas 35 semanas desde la floración.\n', 'img_7722.jpg', '#804000', 0.00, 0.00, 0.00, 'A', NULL, '', '', 0.00),
(6, 'Cacao', 'El cacao fue utilizado en el -en sentido amplio- México prehispánico como moneda de cambio (en los intercambios comerciales entre los nativos). Es por ello que la palabra Cacahuatl tiene su origen en el verbo comprar, que se dice en el náhuatl o mexicano Cohua, nitla- (se admite también la forma Coa, nitla- ). Este verbo, como muchos otros en náhuatl, tiene una forma modificada que se denomina por los estudiosos del idioma frecuentativo, en Cohcohua, nitla-. Sólo nos resta explicar que el sufijo TL es un sufijo nominal.\r\n\r\nEn el México actual al cacao se le denomina también cocoa. La sílaba inicial coh se convierte en co pues ha sido costumbre impuesta por los misioneros que fueron a evangelizar allá el omitir la H (o saltillo) por entender que su pronunciación es una oclusión brusca de la glotis (y no una consonante). Sin embargo, algunos frailes, como Bernardino de Sahagún, sí marcaban la sílaba inicial reduplicada con saltillo mediante un acento circunflejo (Cô) y su sonido puede pronunciarse como una H alemana, esto es, una letra que se pronuncia de forma semejante a la J española, pero no en la garganta como la J española (que es fuerte) sino como un suave soplido formado en la parte delantera del paladar.', 'img_8077.jpg', '#FF0000', 0.00, 0.00, 0.00, 'A', '', '', '1 semana', 0.35),
(7, 'Platano', '\nEsta fruta tropical posee una excelente combinación de energía, minerales y vitaminas que la convierten en un alimento indispensable en cualquier dieta, incluidas las de diabetes y adelgazamiento. \n\nEs, además, el complemento perfecto para personas con gran actividad física, como niños y deportistas. \n\n"Un árbol frutal extraordinario". Los árabes y los griegos definían con esta halagadora frase al plátano, cuyas propiedades beneficiosas para la salud se conocen desde hace miles de años. En la India recibía el nombre de “la fruta de los sabios”, ya que, según una antigua leyenda, los más insignes pensadores hindúes meditaban bajo su sombra mientras comían de su fruto, símbolo de fecundidad y prosperidad. El plátano no es sólo de una de las frutas más consumidas en el mundo entero, sino también una de las más sanas. Su sabor es dulce y delicioso, es una fruta rica en vitaminas C y B6 y minerales esenciales, y se caracteriza por dotar de sabor a infinidad de platos.', 'img_3350.jpg', '#99FF00', 0.00, 0.00, 0.00, 'A', NULL, '12000', '', 0.00),
(8, 'Arroz', 'El arroz es la semilla de la planta Oryza sativa. Se trata de un cereal considerado alimento básico en muchas culturas culinarias (en especial la cocina asiática), así como en algunas partes de América Latina.1 El arroz es el segundo cereal más producido en el mundo, tras el maíz.2 Debido a que el maíz es producido con otros muchos propósitos aparte del consumo humano, se puede decir que el arroz es el cereal más importante en la alimentación humana y que contribuye de forma muy efectiva al aporte calórico de la dieta humana actual; es fuente de una quinta parte de las calorías consumidas en el mundo.3 Desde 2008, se ha realizado un racionamiento en algunos países debido a la carestía de arroz.4 En países como Bangladés y Camboya puede llegar a representar casi las tres cuartas partes de la alimentación de la población.5 Se dedican muchas hectáreas al cultivo del arroz en el mundo. Se sabe que el 95% de este cultivo se extiende entre los paralelos 53º, latitud norte, y 35º, latitud Sur. Su origen es objeto de controversia entre los investigadores; se discute si fue en China o en India.', 'img_2077.jpg', '#333399', 24.00, 30.00, 0.00, 'A', 'hjhjhjh', '130', '1 mes', 0.50),
(9, 'Papaya', 'La papaya es el fruto de un árbol que se lo conoce como papayo. Su nombre científico de Carica papaya y pertenece  a la familia de las caricáceas. Esta planta es originaria de Centroamérica pero también es muy popular en países de África y Asia.  La papaya es una planta tropical que tiene un solo tronco sin ramas y forma una copa o follaje redondeado. Puede alcanzar una altura de 1,8 metros a 2,5 metros.\nLas hojas son pocas, largas y con una forma similar a un péndulo, en color verde muy claro y con nervaduras. Las flores son pequeñas, tiene 5 pétalos en color blanco y la parte del medio o sea el estigma es de color amarillo.  Los frutos o se la papaya tiene forma ovalada y con una textura suave, carnoso y tienen un tamaño importante ya que alcanzan un peso de 500 gramos en promedio pero en algunos casos pueden llegar a pesar varios kilos un sola papaya.\nEl color de esta fruta es amarilla mezclado con verde claro.  Dentro del fruto hay muchas semillas negras de poco tamaño, la pulpa es de color anaranjada o rojiza. El fruto es muy dulce y apreciado como una fruta tropical.  Los frutos y las flores forman racimos por lo que le dan un aspecto robusto cuando es época de recolección de la fruta.  Es importante saber que hay papayos machos, hembras que necesitan que ambos se fecunden para que luego esa semilla genere otra planta.', 'img_8551.jpg', '#00A65A', 0.00, 0.00, 0.00, 'A', NULL, '170', '', 0.00),
(10, 'Maiz', 'El cultivo del maíz tuvo su origen, con toda probabilidad, en América Central, especialmente en México, de donde se difundió hacia el norte hasta el Canadá y hacia el sur hasta la Argentina. La evidencia más antigua de la existencia del maíz, de unos 7 000 años de antigüedad, ha sido encontrada por arqueólogos en el valle de Tehuacán (México) pero es posible que hubiese otros centros secundarios de origen en América. Este cereal era un articulo esencial en las civilizaciones maya y azteca y tuvo un importante papel en sus creencias religiosas, festividades y nutrición; ambos pueblos incluso afirmaban que la carne y la sangre estaban formadas por maíz. La supervivencia del maíz más antiguo y su difusión se debió a los seres humanos, quienes recogieron las semillas para posteriormente plantarlas. A finales del siglo XV, tras el descubrimiento del continente americano por Cristóbal Colón, el grano fue introducido en Europa a través de España. Se difundió entonces por los lugares de clima más cálido del Mediterráneo y posteriormente a Europa septentrional. Mangelsdorf y Reeves (1939) han hecho notar que el maíz se cultiva en todas las regiones del mundo aptas para actividades agrícolas y que se recoge en algún lugar del planeta todos los meses del año. Crece desde los 58° de latitud norte en el Canadá y Rusia hasta los 40° de latitud sur en el hemisferio meridional. Se cultiva en regiones por debajo del nivel del mar en la llanura del Caspio y a más de 4 000 metros de altura en los Andes peruanos.\n\nPese a la gran diversidad de sus formas, al parecer todos los tipos principales de maíz conocidos hoy en día, clasificados como Zea mays, eran cultivados ya por las poblaciones autóctonas cuando se descubrió el continente americano. Por otro lado, los indicios recogidos mediante estudios de botánica, genética y citología apuntan a un antecesor común de todos los tipos existentes de maíz. La mayoría de los investigadores creen que este cereal se desarrolló a partir del teosinte, Euchlaena mexicana Schrod, cultivo anual que posiblemente sea el más cercano al maíz. Otros creen, en cambio, que se originó a partir de un maíz silvestre, hoy en día desaparecido. La tesis de la proximidad entre el teosinte y el maíz se basa en que ambos tienen 10 cromosomas y son homólogos o parcialmente homólogos.', 'img_7037.jpg', '#F2F200', 0.00, 0.00, 0.00, 'A', NULL, '200', '', 0.00),
(11, 'Zzz', 'aaa', 'img_9383.gif', '#fc38c8', 1.00, 1.00, 0.00, 'I', 'aaa', '', '1 mes', 0.00),
(12, 'Jijiji', 'prueba', 'img_5727.jpg', '#335778', 12.00, 12.00, 0.00, 'A', 'prueba', '', '12', 11.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fundo`
--

CREATE TABLE IF NOT EXISTS `fundo` (
  `id_fundo` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `nro` int(11) NOT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`id_fundo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Volcado de datos para la tabla `fundo`
--

INSERT INTO `fundo` (`id_fundo`, `id_usuario`, `nro`, `estado`) VALUES
(64, 1, 1, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hechos`
--

CREATE TABLE IF NOT EXISTS `hechos` (
  `id_hechos` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_hecho` int(11) NOT NULL,
  `id_tipo_investigacion` int(11) NOT NULL,
  `descripcion` varchar(80) NOT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`id_hechos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Volcado de datos para la tabla `hechos`
--

INSERT INTO `hechos` (`id_hechos`, `id_tipo_hecho`, `id_tipo_investigacion`, `descripcion`, `estado`) VALUES
(1, 1, 2, 'Humedo Y Semicalido', 'A'),
(2, 0, 2, 'Prueba', 'I'),
(3, 1, 2, 'Tropical Húmedo', 'A'),
(4, 10, 2, 'Existencia Presencia', 'A'),
(5, 10, 2, 'No Existe Presencia', 'A'),
(6, 3, 2, 'Drena Rápido', 'A'),
(7, 3, 2, 'No Drena Rápido', 'A'),
(8, 4, 2, 'Arcilloso', 'A'),
(9, 4, 2, 'Arenoso', 'A'),
(10, 5, 2, 'Granular', 'A'),
(11, 5, 2, 'No Granular', 'A'),
(12, 6, 2, 'Húmedo', 'A'),
(13, 6, 2, 'Sin Humedad', 'A'),
(14, 7, 2, 'Amarillo', 'A'),
(15, 7, 2, 'Rojizo', 'A'),
(16, 7, 2, 'Oscuro', 'A'),
(17, 8, 2, 'Expuesta Al Sol', 'A'),
(18, 8, 2, 'Bajo Sombra', 'A'),
(19, 9, 2, 'Reaccióna Con El Jugo De Limón', 'A'),
(20, 9, 2, 'No Reaccióna Con El Jugo De Limón', 'A'),
(21, 0, 2, 'Existencia Presencia', 'I'),
(22, 0, 2, 'No Existe Presencia', 'I'),
(23, 2, 2, 'Existencia Presencia', 'A'),
(24, 2, 2, 'No Existe Presencia', 'A'),
(25, 1, 1, 'Húmedo Y Semicalido', 'A'),
(26, 1, 1, 'Tropical Húmedo', 'A'),
(27, 13, 1, '200 - 300 Cal/cm2/dia', 'A'),
(28, 13, 1, '300 - 400 Cal/cm2/dia', 'A'),
(29, 13, 1, '400 - 500 Cal/cm2/dia', 'A'),
(30, 13, 1, '500 - 600 Cal/cm2/dia', 'A'),
(31, 3, 1, 'Drena Rapido', 'A'),
(32, 3, 1, 'No Drena Rapido', 'A'),
(33, 4, 1, 'Arcilloso', 'A'),
(34, 4, 1, 'Limoso', 'A'),
(35, 4, 1, 'Arenoso', 'A'),
(36, 14, 1, '500 - 1000 Mm/año', 'A'),
(37, 14, 1, '1000 - 1500 Mm/año', 'A'),
(38, 14, 1, '1500 - 2000 Mm/año', 'A'),
(39, 14, 1, '2000 - 2500 Mm/año', 'A'),
(40, 14, 1, '2500 - 3000 Mm/año', 'A'),
(41, 6, 1, '0 - 40%', 'A'),
(42, 6, 1, '40 - 70%', 'A'),
(43, 6, 1, '70% - 90%', 'A'),
(44, 8, 1, '10°C - 20°C', 'A'),
(45, 8, 1, '20°C - 30°C', 'A'),
(46, 8, 1, '30°C - 40°C', 'A'),
(47, 9, 1, '5 - 6', 'A'),
(48, 9, 1, '6 - 7', 'A'),
(49, 9, 1, '7 - 8', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hecho_conocimiento`
--

CREATE TABLE IF NOT EXISTS `hecho_conocimiento` (
  `id_hecho_conocimiento` int(11) NOT NULL AUTO_INCREMENT,
  `id_conocimiento` int(11) NOT NULL,
  `id_hechos` int(11) NOT NULL,
  `peso` int(11) NOT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`id_hecho_conocimiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=266 ;

--
-- Volcado de datos para la tabla `hecho_conocimiento`
--

INSERT INTO `hecho_conocimiento` (`id_hecho_conocimiento`, `id_conocimiento`, `id_hechos`, `peso`, `estado`) VALUES
(6, 5, 1, 20, 'A'),
(7, 5, 3, 1, 'A'),
(8, 5, 23, 20, 'A'),
(9, 5, 6, 20, 'A'),
(10, 5, 8, 20, 'A'),
(11, 5, 9, 4, 'A'),
(12, 5, 10, 20, 'A'),
(13, 5, 11, 1, 'A'),
(14, 5, 12, 20, 'A'),
(15, 5, 14, 2, 'A'),
(16, 5, 15, 3, 'A'),
(17, 5, 16, 20, 'A'),
(18, 5, 17, 2, 'A'),
(19, 5, 18, 20, 'A'),
(20, 5, 19, 20, 'A'),
(21, 5, 4, 20, 'A'),
(22, 4, 1, 20, 'A'),
(23, 4, 3, 1, 'A'),
(24, 4, 23, 20, 'A'),
(25, 4, 6, 20, 'A'),
(26, 4, 7, 1, 'A'),
(27, 4, 8, 20, 'A'),
(28, 4, 9, 2, 'A'),
(29, 4, 10, 20, 'A'),
(30, 4, 11, 1, 'A'),
(31, 4, 12, 20, 'A'),
(32, 4, 14, 1, 'A'),
(33, 4, 15, 2, 'A'),
(34, 4, 16, 20, 'A'),
(35, 4, 17, 2, 'A'),
(36, 4, 18, 20, 'A'),
(37, 4, 19, 20, 'A'),
(38, 4, 4, 20, 'A'),
(39, 6, 1, 20, 'A'),
(40, 6, 3, 2, 'A'),
(41, 6, 23, 20, 'A'),
(42, 6, 24, 2, 'A'),
(43, 6, 6, 20, 'A'),
(44, 6, 7, 1, 'A'),
(45, 6, 8, 20, 'A'),
(46, 6, 10, 20, 'A'),
(47, 6, 11, 2, 'A'),
(48, 6, 12, 10, 'A'),
(49, 6, 14, 2, 'A'),
(50, 6, 15, 3, 'A'),
(51, 6, 16, 20, 'A'),
(52, 6, 17, 2, 'A'),
(53, 6, 18, 20, 'A'),
(54, 6, 19, 20, 'A'),
(55, 6, 4, 20, 'A'),
(56, 7, 1, 3, 'A'),
(57, 7, 3, 2, 'A'),
(58, 7, 23, 20, 'A'),
(59, 7, 24, 1, 'A'),
(60, 7, 6, 20, 'A'),
(61, 7, 8, 20, 'A'),
(62, 7, 10, 4, 'A'),
(63, 7, 11, 3, 'A'),
(64, 7, 12, 20, 'A'),
(65, 7, 13, 1, 'A'),
(66, 7, 14, 3, 'A'),
(67, 7, 15, 2, 'A'),
(68, 7, 16, 4, 'A'),
(69, 7, 18, 3, 'A'),
(70, 7, 17, 5, 'A'),
(71, 7, 19, 20, 'A'),
(72, 7, 20, 1, 'A'),
(73, 7, 4, 20, 'A'),
(74, 8, 1, 20, 'A'),
(75, 8, 3, 20, 'A'),
(76, 8, 23, 3, 'A'),
(77, 8, 24, 2, 'A'),
(78, 8, 7, 20, 'A'),
(79, 8, 8, 20, 'A'),
(80, 8, 9, 3, 'A'),
(81, 8, 10, 20, 'A'),
(82, 8, 11, 20, 'A'),
(83, 8, 12, 20, 'A'),
(84, 8, 13, 20, 'A'),
(85, 8, 14, 4, 'A'),
(86, 8, 15, 2, 'A'),
(87, 8, 16, 20, 'A'),
(88, 8, 17, 20, 'A'),
(89, 8, 19, 20, 'A'),
(90, 8, 20, 1, 'A'),
(91, 8, 5, 20, 'A'),
(92, 9, 1, 2, 'A'),
(93, 9, 3, 20, 'A'),
(94, 9, 23, 3, 'A'),
(95, 9, 24, 2, 'A'),
(96, 9, 6, 20, 'A'),
(97, 9, 8, 3, 'A'),
(98, 9, 10, 20, 'A'),
(99, 9, 11, 2, 'A'),
(100, 9, 12, 4, 'A'),
(101, 9, 14, 3, 'A'),
(102, 9, 15, 4, 'A'),
(103, 9, 16, 20, 'A'),
(104, 9, 17, 20, 'A'),
(105, 9, 18, 1, 'A'),
(106, 9, 19, 20, 'A'),
(107, 9, 4, 20, 'A'),
(108, 9, 7, 1, 'A'),
(109, 9, 9, 3, 'A'),
(110, 10, 1, 1, 'A'),
(111, 10, 3, 20, 'A'),
(112, 10, 23, 20, 'A'),
(113, 10, 24, 2, 'A'),
(114, 10, 6, 20, 'A'),
(115, 10, 8, 20, 'A'),
(116, 10, 10, 20, 'A'),
(117, 10, 11, 2, 'A'),
(118, 10, 12, 2, 'A'),
(119, 10, 13, 20, 'A'),
(120, 10, 14, 2, 'A'),
(121, 10, 16, 20, 'A'),
(122, 10, 17, 20, 'A'),
(123, 10, 19, 20, 'A'),
(124, 10, 4, 20, 'A'),
(125, 5, 25, 20, 'A'),
(126, 5, 26, 1, 'A'),
(127, 5, 27, 20, 'A'),
(128, 5, 28, 3, 'A'),
(129, 5, 31, 20, 'A'),
(130, 5, 33, 20, 'A'),
(131, 5, 35, 4, 'A'),
(132, 5, 37, 1, 'A'),
(133, 5, 38, 2, 'A'),
(134, 5, 39, 4, 'A'),
(135, 5, 42, 2, 'A'),
(136, 5, 43, 20, 'A'),
(137, 5, 44, 20, 'A'),
(138, 5, 45, 3, 'A'),
(139, 5, 48, 3, 'A'),
(140, 5, 49, 20, 'A'),
(141, 5, 40, 20, 'A'),
(142, 4, 25, 20, 'A'),
(143, 4, 26, 1, 'A'),
(144, 4, 27, 20, 'A'),
(145, 4, 28, 2, 'A'),
(146, 4, 31, 20, 'A'),
(147, 4, 32, 1, 'A'),
(148, 4, 33, 20, 'A'),
(149, 4, 35, 2, 'A'),
(150, 4, 38, 3, 'A'),
(151, 4, 39, 3, 'A'),
(152, 4, 40, 20, 'A'),
(153, 4, 42, 2, 'A'),
(154, 4, 43, 20, 'A'),
(155, 4, 44, 20, 'A'),
(156, 4, 45, 3, 'A'),
(157, 4, 48, 3, 'A'),
(158, 4, 49, 20, 'A'),
(159, 6, 25, 20, 'A'),
(160, 6, 26, 2, 'A'),
(161, 6, 27, 20, 'A'),
(162, 6, 28, 4, 'A'),
(163, 6, 31, 20, 'A'),
(164, 6, 32, 1, 'A'),
(165, 6, 33, 20, 'A'),
(166, 6, 37, 1, 'A'),
(167, 6, 38, 2, 'A'),
(168, 6, 39, 4, 'A'),
(169, 6, 40, 20, 'A'),
(170, 6, 42, 2, 'A'),
(171, 6, 43, 20, 'A'),
(172, 6, 44, 20, 'A'),
(173, 6, 45, 3, 'A'),
(174, 6, 48, 4, 'A'),
(175, 6, 49, 20, 'A'),
(176, 7, 25, 3, 'A'),
(177, 7, 26, 2, 'A'),
(178, 7, 27, 20, 'A'),
(179, 7, 28, 4, 'A'),
(180, 7, 29, 3, 'A'),
(181, 7, 30, 2, 'A'),
(182, 7, 31, 20, 'A'),
(183, 7, 33, 20, 'A'),
(184, 7, 34, 2, 'A'),
(185, 7, 36, 3, 'A'),
(186, 7, 37, 3, 'A'),
(187, 7, 38, 20, 'A'),
(188, 7, 39, 20, 'A'),
(189, 7, 40, 2, 'A'),
(190, 7, 41, 2, 'A'),
(191, 7, 42, 20, 'A'),
(192, 7, 43, 1, 'A'),
(193, 7, 44, 2, 'A'),
(194, 7, 45, 20, 'A'),
(195, 7, 46, 3, 'A'),
(196, 7, 47, 1, 'A'),
(197, 7, 48, 4, 'A'),
(198, 7, 49, 20, 'A'),
(199, 8, 25, 20, 'A'),
(200, 8, 26, 20, 'A'),
(201, 8, 27, 20, 'A'),
(202, 8, 28, 20, 'A'),
(203, 8, 29, 2, 'A'),
(204, 8, 30, 1, 'A'),
(205, 8, 32, 20, 'A'),
(206, 8, 33, 20, 'A'),
(207, 8, 34, 3, 'A'),
(208, 8, 35, 3, 'A'),
(209, 8, 36, 3, 'A'),
(210, 8, 37, 4, 'A'),
(211, 8, 38, 20, 'A'),
(212, 8, 39, 3, 'A'),
(213, 8, 40, 2, 'A'),
(214, 8, 41, 20, 'A'),
(215, 8, 42, 2, 'A'),
(216, 8, 44, 1, 'A'),
(217, 8, 45, 20, 'A'),
(218, 8, 46, 20, 'A'),
(219, 8, 47, 1, 'A'),
(220, 8, 48, 4, 'A'),
(221, 8, 49, 20, 'A'),
(222, 9, 25, 2, 'A'),
(223, 9, 26, 20, 'A'),
(224, 9, 27, 2, 'A'),
(225, 9, 28, 4, 'A'),
(226, 9, 29, 20, 'A'),
(227, 9, 30, 20, 'A'),
(228, 9, 31, 20, 'A'),
(229, 9, 32, 1, 'A'),
(230, 9, 33, 3, 'A'),
(231, 9, 34, 2, 'A'),
(232, 9, 35, 3, 'A'),
(233, 9, 36, 2, 'A'),
(234, 9, 37, 20, 'A'),
(235, 9, 38, 20, 'A'),
(236, 9, 39, 2, 'A'),
(237, 9, 40, 1, 'A'),
(238, 9, 41, 2, 'A'),
(239, 9, 42, 20, 'A'),
(240, 9, 43, 2, 'A'),
(241, 9, 44, 1, 'A'),
(242, 9, 45, 20, 'A'),
(243, 9, 46, 3, 'A'),
(244, 9, 48, 2, 'A'),
(245, 9, 49, 20, 'A'),
(246, 10, 25, 1, 'A'),
(247, 10, 26, 20, 'A'),
(248, 10, 27, 1, 'A'),
(249, 10, 28, 2, 'A'),
(250, 10, 29, 4, 'A'),
(251, 10, 30, 20, 'A'),
(252, 10, 31, 20, 'A'),
(253, 10, 33, 20, 'A'),
(254, 10, 34, 20, 'A'),
(255, 10, 35, 20, 'A'),
(256, 10, 36, 20, 'A'),
(257, 10, 37, 20, 'A'),
(258, 10, 38, 2, 'A'),
(259, 10, 39, 1, 'A'),
(260, 10, 41, 20, 'A'),
(261, 10, 42, 2, 'A'),
(262, 10, 45, 2, 'A'),
(263, 10, 46, 20, 'A'),
(264, 10, 48, 3, 'A'),
(265, 10, 49, 20, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE IF NOT EXISTS `modulo` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) NOT NULL,
  `id_modulo_padre` int(11) NOT NULL,
  `img` varchar(40) NOT NULL,
  `url` varchar(100) NOT NULL,
  `orden` int(11) NOT NULL,
  `estado` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id_modulo`, `descripcion`, `id_modulo_padre`, `img`, `url`, `orden`, `estado`) VALUES
(1, 'Modulo', 0, 'fa fa-sitemap', 'modulo', 10, 'A'),
(2, '', 0, '', '', 0, 'I'),
(3, '', 0, '', '', 0, 'I'),
(4, 'Accesos', 0, 'fa fa-key', 'acceso', 11, 'A'),
(5, 'Hechos', 0, 'fa fa-history', 'hechos', 9, 'A'),
(6, 'Conocimientos', 0, 'fa fa-book', 'conocimientos', 8, 'A'),
(7, 'Usuarios', 0, 'fa fa-user', 'usuario', 12, 'A'),
(8, 'Tipo Hecho', 0, 'fa fa-list', 'tipohecho', 10, 'A'),
(9, 'Estadistica Usuario', 0, 'fa fa-pie-chart', 'estadistica_usuario', 7, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parcela`
--

CREATE TABLE IF NOT EXISTS `parcela` (
  `id_parcela` int(11) NOT NULL AUTO_INCREMENT,
  `id_fundo` int(11) NOT NULL,
  `id_tipo_investigacion` int(11) NOT NULL,
  `nro` int(11) NOT NULL,
  `dimension` decimal(10,2) NOT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`id_parcela`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Volcado de datos para la tabla `parcela`
--

INSERT INTO `parcela` (`id_parcela`, `id_fundo`, `id_tipo_investigacion`, `nro`, `dimension`, `estado`) VALUES
(1, 48, 0, 1, 123.00, 'A'),
(2, 48, 0, 2, 123.00, 'A'),
(3, 48, 0, 3, 123.00, 'I'),
(4, 52, 0, 1, 789.00, 'A'),
(5, 54, 0, 1, 34.00, 'A'),
(6, 54, 0, 2, 348.00, 'A'),
(7, 55, 0, 1, 7.00, 'A'),
(8, 53, 0, 1, 5.00, 'A'),
(9, 56, 0, 1, 67.00, 'A'),
(10, 57, 0, 1, 67.00, 'A'),
(11, 57, 0, 2, 12.00, 'I'),
(12, 58, 2, 1, 7.00, 'A'),
(13, 58, 2, 2, 56.00, 'A'),
(14, 62, 0, 1, 123.00, 'A'),
(15, 62, 0, 2, 345.00, 'A'),
(16, 63, 0, 1, 89.00, 'A'),
(17, 58, 2, 3, 789.00, 'A'),
(18, 58, 2, 4, 345.00, 'A'),
(19, 64, 2, 1, 123.00, 'A'),
(20, 64, 2, 2, 89.00, 'A'),
(21, 64, 2, 3, 1332.00, 'I'),
(22, 64, 1, 4, 1234.00, 'I'),
(23, 64, 1, 5, 123.00, 'I'),
(24, 64, 1, 6, 1233.00, 'A'),
(25, 64, 1, 7, 564.00, 'A'),
(26, 64, 2, 8, 1234.00, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parcela_conocimiento`
--

CREATE TABLE IF NOT EXISTS `parcela_conocimiento` (
  `id_parcela_conocimiento` int(11) NOT NULL AUTO_INCREMENT,
  `id_conocimiento` int(11) NOT NULL,
  `id_parcela` int(11) NOT NULL,
  `periodo_siembra` int(11) NOT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`id_parcela_conocimiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `parcela_conocimiento`
--

INSERT INTO `parcela_conocimiento` (`id_parcela_conocimiento`, `id_conocimiento`, `id_parcela`, `periodo_siembra`, `estado`) VALUES
(1, 8, 1, 0, 'A'),
(2, 6, 1, 0, 'A'),
(3, 5, 1, 0, 'A'),
(4, 10, 1, 0, 'A'),
(5, 10, 9, 0, 'A'),
(6, 8, 10, 0, 'A'),
(7, 6, 10, 0, 'A'),
(8, 4, 4, 0, 'A'),
(9, 10, 4, 0, 'A'),
(10, 7, 12, 0, 'A'),
(11, 6, 12, 0, 'A'),
(12, 8, 26, 0, 'A'),
(13, 6, 26, 0, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parcela_hechos`
--

CREATE TABLE IF NOT EXISTS `parcela_hechos` (
  `id_parcela_hechos` int(11) NOT NULL AUTO_INCREMENT,
  `id_hechos` int(11) NOT NULL,
  `id_parcela` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`id_parcela_hechos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=131 ;

--
-- Volcado de datos para la tabla `parcela_hechos`
--

INSERT INTO `parcela_hechos` (`id_parcela_hechos`, `id_hechos`, `id_parcela`, `cantidad`, `estado`) VALUES
(59, 1, 19, 0, 'A'),
(60, 23, 19, 0, 'A'),
(61, 6, 19, 0, 'A'),
(62, 8, 19, 0, 'A'),
(63, 10, 19, 0, 'A'),
(64, 12, 19, 0, 'A'),
(65, 15, 19, 0, 'A'),
(66, 17, 19, 0, 'A'),
(67, 19, 19, 0, 'A'),
(68, 4, 19, 0, 'A'),
(69, 1, 20, 0, 'A'),
(70, 23, 20, 0, 'A'),
(71, 6, 20, 0, 'A'),
(72, 8, 20, 0, 'A'),
(73, 10, 20, 0, 'A'),
(74, 12, 20, 0, 'A'),
(75, 14, 20, 0, 'A'),
(76, 17, 20, 0, 'A'),
(77, 19, 20, 0, 'A'),
(78, 4, 20, 0, 'A'),
(79, 1, 21, 0, 'A'),
(80, 24, 21, 0, 'A'),
(81, 6, 21, 0, 'A'),
(82, 8, 21, 0, 'A'),
(83, 11, 21, 0, 'A'),
(84, 12, 21, 0, 'A'),
(85, 15, 21, 0, 'A'),
(86, 17, 21, 0, 'A'),
(87, 19, 21, 0, 'A'),
(88, 5, 21, 0, 'A'),
(89, 26, 22, 0, 'A'),
(90, 31, 22, 0, 'A'),
(91, 34, 22, 0, 'A'),
(92, 42, 22, 0, 'A'),
(93, 44, 22, 0, 'A'),
(94, 48, 22, 0, 'A'),
(95, 29, 22, 0, 'A'),
(96, 37, 22, 0, 'A'),
(97, 25, 23, 0, 'A'),
(98, 31, 23, 0, 'A'),
(99, 34, 23, 0, 'A'),
(100, 42, 23, 0, 'A'),
(101, 45, 23, 0, 'A'),
(102, 47, 23, 0, 'A'),
(103, 28, 23, 0, 'A'),
(104, 40, 23, 0, 'A'),
(105, 25, 24, 0, 'A'),
(106, 32, 24, 0, 'A'),
(107, 34, 24, 0, 'A'),
(108, 42, 24, 0, 'A'),
(109, 44, 24, 0, 'A'),
(110, 47, 24, 0, 'A'),
(111, 27, 24, 0, 'A'),
(112, 37, 24, 0, 'A'),
(113, 26, 25, 0, 'A'),
(114, 32, 25, 0, 'A'),
(115, 35, 25, 0, 'A'),
(116, 41, 25, 0, 'A'),
(117, 46, 25, 0, 'A'),
(118, 47, 25, 0, 'A'),
(119, 30, 25, 0, 'A'),
(120, 36, 25, 0, 'A'),
(121, 3, 26, 0, 'A'),
(122, 24, 26, 0, 'A'),
(123, 7, 26, 0, 'A'),
(124, 9, 26, 0, 'A'),
(125, 11, 26, 0, 'A'),
(126, 13, 26, 0, 'A'),
(127, 14, 26, 0, 'A'),
(128, 17, 26, 0, 'A'),
(129, 20, 26, 0, 'A'),
(130, 5, 26, 0, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_hecho`
--

CREATE TABLE IF NOT EXISTS `tipo_hecho` (
  `id_tipo_hecho` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) NOT NULL,
  `pregunta_empirica` varchar(200) NOT NULL,
  `pregunta_cientifica` varchar(200) NOT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`id_tipo_hecho`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `tipo_hecho`
--

INSERT INTO `tipo_hecho` (`id_tipo_hecho`, `descripcion`, `pregunta_empirica`, `pregunta_cientifica`, `estado`) VALUES
(1, 'Clima', '¿Qué tipo de clima observa en su parcela?', '¿Cuál es el clima de la zona?', 'A'),
(2, 'Materia Organica', '¿Existe presencia de materia órganica?', '', 'A'),
(3, 'Suelo', '¿El agua del suelo de su parcela se drena rápido?', '¿El agua del suelo se drena rápido?', 'A'),
(4, 'Textura', '¿Qué tipo de textura observa en el suelo de su parcela?', '¿Cuál es la textura del suelo?', 'A'),
(5, 'Estructura', '¿Cúal es la estructura del suelo que observa en su parcela?', '', 'A'),
(6, 'Humedad', 'El suelo de su parcela, ¿Posee humedad o no posee humedad?', '¿Cuál es el porcentaje de humedad de la zona?', 'A'),
(7, 'Color', '¿Qué color de suelo posee su parcela?', '', 'A'),
(8, 'Temperatura', 'El cultivo de esta parcela, ¿se encuentra expuesta al sol?', '¿Cuál es la temperatura ambiental de la zona?', 'A'),
(9, 'Acidez (pH)', 'Agarre un poco de tierra y échele jugo de limon, ¿Qué es lo que observa?', '¿Cuánto es el nivel de acidez (pH) del suelo?', 'A'),
(10, 'Especies Arboreas', '¿Existe presencia de especies arboreas en el suelo?', '', 'A'),
(11, 'Prueba', '', '', 'I'),
(12, 'Una Prueba', '', '', 'I'),
(13, 'Radiación', '', '¿Cuál es el nivel de radiación de la zona?', 'A'),
(14, 'Precipitaciones', '', '¿Cuántas precipitaciones por año existe en la zona?', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_investigacion`
--

CREATE TABLE IF NOT EXISTS `tipo_investigacion` (
  `id_tipo_investigacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_tipo_investigacion` varchar(100) NOT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`id_tipo_investigacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipo_investigacion`
--

INSERT INTO `tipo_investigacion` (`id_tipo_investigacion`, `descripcion_tipo_investigacion`, `estado`) VALUES
(1, 'CIENTIFICA', 'A'),
(2, 'EMPIRICA', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) NOT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `descripcion`, `estado`) VALUES
(1, 'ADMIN', 'A'),
(2, 'BASICO', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `user` varchar(20) NOT NULL,
  `clave` varchar(60) NOT NULL,
  `estado` char(1) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `id_tipo_usuario`, `nombre`, `user`, `clave`, `estado`) VALUES
(1, 1, 'ISRAEL', 'admin', '202cb962ac59075b964b07152d234b70', 'A'),
(3, 2, 'PRUEBA', 'prueba1', '202cb962ac59075b964b07152d234b70', 'I'),
(4, 2, 'NASH', 'nash', '202cb962ac59075b964b07152d234b70', 'A');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
