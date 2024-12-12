-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2024 a las 01:51:00
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vue_blog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `ID` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `resumen` varchar(500) NOT NULL,
  `descripcion` text NOT NULL,
  `categoria` enum('Entretenimiento','Cultura','Viajes','Tecnología') NOT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`ID`, `titulo`, `imagen`, `resumen`, `descripcion`, `categoria`, `fecha`) VALUES
(1, 'Cine Nostálgico: El Renacimiento de las Salas Vintage', 'uploads/1_20241211235919.jpeg', 'Las salas de cine retro están volviendo a ser populares gracias a su encanto único.', 'En un mundo dominado por plataformas de streaming, las salas de cine vintage ofrecen una experiencia única que transporta a los espectadores a décadas pasadas. Estas salas no solo proyectan clásicos del cine, sino que también recrean la atmósfera de la época con decoraciones art déco y bandas sonoras de antaño.\r\nAdemás, el interés por lo retro ha impulsado a los cinéfilos a buscar alternativas más inmersivas y diferentes a los complejos modernos. Ya sea por la nostalgia o la búsqueda de autenticidad, estos espacios están ganando protagonismo en las principales ciudades del mundo.', 'Entretenimiento', '2024-12-12 00:14:54'),
(2, 'Maratón Gamer: Cómo organizar la Noche Perfecta', 'uploads/2_20241212000149.jpg', 'Disfruta una noche inolvidable con tus amigos con estos consejos para una maratón de videojuegos.', 'Organizar una maratón de videojuegos no solo es divertido, sino también una excelente manera de socializar. Elige juegos que puedan disfrutar de varias personas, como títulos multijugador o competitivos.\r\nAdemás, no olvides planificar bocadillos y bebidas para mantener a todos energizados. Con la configuración correcta y un poco de creatividad, tu noche gamer será la envidia de todos tus amigos.', 'Entretenimiento', '2024-12-11 00:09:03'),
(3, 'Festivales de Música Local: Una Joya por Descubrir', 'uploads/3_20241212000506.jpg', 'Descubre el encanto de los festivales independientes en tu ciudad.', 'Los festivales de música local son la plataforma perfecta para conocer nuevas bandas y redescubrir géneros olvidados. Estos eventos suelen ofrecer una atmósfera más íntima y auténtica, alejados del caos de los macrofestivales.\r\nApoyar a los artistas locales no solo fomenta la cultura musical de tu región, sino que también crea conexiones únicas con la comunidad. ¡No te pierdas el próximo festival cerca de ti!', 'Entretenimiento', '2024-12-11 00:09:03'),
(4, '5 Playas Secretas que Debes Visitar Este Año', 'uploads/4_20241212000651.jpg', 'Descubre las playas menos conocidas que ofrecen paz y belleza inigualables.', 'Las playas secretas son un tesoro escondido que cada viajero debería experimentar al menos una vez. Desde calas escondidas en el Mediterráneo hasta costas remotas en el sudeste asiático, estas playas ofrecen tranquilidad y paisajes increíbles.\r\nSi buscas evitar las multitudes y conectarte con la naturaleza, considera visitar destinos como Railay Beach en Tailandia o Cala Macarella en Menorca.', 'Viajes', '2024-12-11 00:09:03'),
(5, 'La Magia del Viaje en Solitario: Consejos para Principiantes', 'uploads/5_20241212000830.jpg', 'Viajar solo puede ser transformador, pero es importante estar preparado.', 'Un viaje en solitario puede ayudarte a conocerte mejor y desarrollar una independencia única. Sin embargo, es crucial planificar bien para garantizar una experiencia segura y enriquecedora.\r\nInvestiga tu destino, prepara un itinerario flexible y mantente en contacto con tus seres queridos mientras viajas. ¡Atrévete a explorar el mundo por tu cuenta y descubre nuevas perspectivas!', 'Viajes', '2024-12-11 00:09:03'),
(7, 'Destinos para Vivir Aventura: Más Allá de lo Común', 'uploads/6_20241212001025.jpg', 'Experimenta aventuras inolvidables en lugares espectaculares alrededor del mundo.', 'Para los amantes de la adrenalina, destinos como Capadocia en Turquía o Queenstown en Nueva Zelanda son ideales. Estas regiones no solo ofrecen paisajes impresionantes, sino también actividades emocionantes como vuelos en globo y deportes extremos.\r\nPlanea tus próximas vacaciones con un toque de aventura y conviértelas en un recuerdo imborrable.', 'Viajes', '2024-12-12 00:14:45'),
(8, 'Los Mercados Artesanales: Un Refugio de Tradición y Creatividad', 'uploads/7_20241212001643.jpg', 'Explora los mercados donde convergen la tradición y el arte.', 'Los mercados artesanales son una ventana a la cultura local. En ellos se pueden encontrar desde textiles bordados hasta cerámicas únicas hechas a mano.\r\nAdemás, visitar estos mercados es una manera de apoyar a los artistas locales y aprender más sobre las tradiciones de cada región. La próxima vez que viajes, no olvides incluir un mercado artesanal en tu itinerario.', 'Cultura', '2024-12-12 00:16:43'),
(9, 'Clásicos Literarios que Todos Deberían Leer', 'uploads/8_20241212001803.jpg', 'Sumérgete en las obras maestras que han marcado la historia de la literatura.', 'Leer clásicos literarios no solo amplía tus horizontes, sino que también te conecta con las ideas y emociones universales de otras épocas. Obras como Don Quijote de Cervantes o Cien Años de Soledad de García Márquez siguen siendo relevantes hoy en día.\r\nDedicar tiempo a estas lecturas es un viaje intelectual y emocional que enriquecerá tu perspectiva del mundo.', 'Cultura', '2024-12-12 00:18:03'),
(10, 'Arte Moderno: Cómo interpretar lo incomprensible', 'uploads/9_20241212002042.jpg', 'Aprende a disfrutar del arte moderno incluso si parece desconcertante.', 'El arte moderno puede ser desconcertante a primera vista, pero entender su contexto y mensaje cambia la experiencia por completa. Muchas obras modernas buscan provocar emociones o cuestionar las normas sociales.\r\nLa clave está en abrir la mente, dejarse llevar por las sensaciones y disfrutar de la creatividad sin prejuicios.', 'Cultura', '2024-12-12 00:20:42'),
(11, 'El Futuro Está Aquí: Robots Asistentes para el Hogar', 'uploads/10_20241212003229.JPG', 'La tecnología está revolucionando la forma en que gestionamos nuestras tareas diarias.', 'Los robots asistentes como Alexa o Roomba están cambiando la forma en que interactuamos con la tecnología en casa. Desde limpiar hasta gestionar agendas, estos dispositivos hacen que la vida sea más sencilla.\r\nA medida que avanza la inteligencia artificial, podemos esperar asistentes más inteligentes y capaces que se adapten a nuestras necesidades.', 'Tecnología', '2024-12-12 00:32:29'),
(12, 'Realidad Virtual: Más Allá de los Videojuegos', 'uploads/11_20241212003853.JPG', 'Descubre cómo la realidad virtual está transformando la educación y la salud', 'Aunque los videojuegos han liderado el camino, la realidad virtual ahora se utiliza en educación, medicina y turismo virtual. Por ejemplo, los estudiantes pueden explorar el espacio o la anatomía humana en 3D, mientras que los médicos realizan simulaciones de cirugías. La realidad virtual ofrece una experiencia inmersiva que va más allá de lo visual, permitiendo a los usuarios sentir, oír y hasta tocar el entorno virtual, lo que la convierte en una herramienta poderosa para la formación y el entrenamiento.', 'Tecnología', '2024-12-12 00:38:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`ID`, `nombre`, `mail`, `password`, `avatar`) VALUES
(2, 'Admin', 'admin@gmail.com', '$2y$10$/OcbJqrLwIx4x6je355Gee/UAOWdjqLKEIxtbV3/MN1luDfryb0ve', 'uploads/rostro1.jpg'),
(3, 'Test2', 'test2@gmail.com', '$2y$10$ggUt5Vzi8JOKM2TjpDydP.jKqxoYqPZqu3VnDiKQWqUQif4YhdBwm', 'uploads/ros3_20241211192128.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
