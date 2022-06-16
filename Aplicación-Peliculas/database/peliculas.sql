-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-06-2022 a las 04:03:05
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `peliculas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `codigo_pelicula` int(11) NOT NULL,
  `nombre` varchar(170) NOT NULL,
  `director` varchar(50) NOT NULL,
  `genero` varchar(15) NOT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `urlvideo` varchar(50) NOT NULL,
  `enlacepeli` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`codigo_pelicula`, `nombre`, `director`, `genero`, `imagen`, `urlvideo`, `enlacepeli`) VALUES
(1, 'EL GOLPE', 'GEORGE ROY HILL', 'COMEDIA', 'El_golpe.jpg', 'https://www.youtube.com/embed/UZ4CuWPnfeM', 'https://www.primevideo.com/detail/0KIYOEZ48P46MIVBJJYIQZFFH9/ref=atv_d'),
(2, 'LOS PAJAROS', 'ALFRED HITCHOCK', 'TERROR', 'Los pajaros.jpg', 'https://www.youtube.com/embed/R7J6WFVYU8Y', 'https://www.primevideo.com/detail/The-Birds/0HG4MYILEHFLDP0WMXQP60JI79'),
(3, 'SOSPECHOSOS HABITUALES', 'BRYAN SINGER', 'SUSPENSE', 'sospechosos_habituales.jpg', 'https://www.youtube.com/embed/fdValbjQXTI', 'https://www.primevideo.com/detail/Sospechosos-Comunes/0FSF6FBYQ6KLKL85RC1EYVCKOU/ref=atv_nb_lcl_es_ES?language=es_ES&ie=UTF8'),
(4, 'PIRATAS DEL CARIBE. EN EL FIN DEL MUNDO', 'GORE VERBINSKI', 'AVENTURAS', 'piratas3.jpg', 'https://www.youtube.com/embed/Jkc2TwhOGYs', 'https://www.primevideo.com/detail/Piratas-del-Caribe-En-el-fin-del-mundo/0SP289HN659P8SA634MWWDV96X?_encoding=UTF8&language=es_ES'),
(5, 'EL SEÑOR LOS DE LOS ANILLOS. LA COMUNIDAD DEL ANIL', 'PETER JACKSON', 'AVENTURAS', 'señor-anillos-1.jpg', 'https://www.youtube.com/embed/3GJp6p_mgPo', 'https://www.hbomax.com/es/es/feature/urn:hbo:feature:GXdu2ZAglVJuAuwEAADbA'),
(6, 'WILLOW', 'RON HOWARD ', 'AVENTURAS', 'willow.jpg', 'https://www.youtube.com/embed/00ouJZsjXkg', 'https://www.disneyplus.com/es-es/movies/willow/6HPlwZfF5agA'),
(7, 'BRAVEHEART', 'MEL GIBSON', 'AVENTURAS', 'Braveheart.jpg', 'https://www.youtube.com/embed/OwJGElRruv8', 'https://www.disneyplus.com/es-es/movies/braveheart/6erx76ycCSTj'),
(8, 'ALIEN, EL OCTAVO PASAJERO', 'RIDLEY SCOTT ', 'TERROR', '', 'https://www.youtube.com/embed/Eu9ZFTXXEiw', 'https://www.disneyplus.com/es-es/movies/alien-el-8%C2%BA-pasajero/3gmwPpcKMkwS'),
(9, 'HOTEL RWANDA', 'TERRY GEORGE', 'DRAMA', '', 'https://www.youtube.com/embed/-6MtH6bUuP0', 'https://www.primevideo.com/detail/Hotel-Rwanda-La-Matanza/0SP2HZRMLWRCNBCSF7IABR53FO'),
(10, 'CRASH (COLISIÓN)', 'PAUL HAGGIS', 'DRAMA', '', 'https://www.youtube.com/embed/LFVZ0_xTk6U', 'https://www.primevideo.com/detail/Crash/0GZ3LFFI5G2QHAF0F5AK7GNQUO'),
(11, 'EL TEMIBLE BURLON', 'ROBERT SIODMAK', 'AVENTURAS', '', '', ''),
(12, 'EL NUMERO 23', 'JOEL SCHUMACHER', 'SUSPENSE', '', '', ''),
(13, 'BEN-HUR', 'WILLIAM WYLER ', 'DRAMA', '', '', ''),
(14, 'SHREK 3', 'CHRIS MILLER', 'COMEDIA', '', '', ''),
(15, 'LA LISTA DE SHILDER ', 'STEVEN SPIELBERG', 'DRAMA', '', '', ''),
(16, 'LA GRAN EVASION', 'JOHN STURGES', 'BELICA', '', '', ''),
(17, 'DOCE DEL PATIBULO', 'ROBERT ALDRICH', 'BELICA', '', '', ''),
(18, 'DOCE MONOS', 'TERRY GILLIAM', 'SUSPENSE', '', '', ''),
(19, 'AL ESTE DEL EDEN', 'ELIA KAZAN ', 'DRAMA', '', '', ''),
(20, 'TIBURON', 'STEVEN SPIELBERG', 'TERROR', '', '', ''),
(21, 'MATRIX', ' LARRY Y ANDY WACHOWSKI', 'CIENCIA FICCION', '', '', ''),
(22, 'AMERICAN HISTORY X', 'TONY KAYE', 'DRAMA', '', '', ''),
(24, 'MOSNTER', 'SS', 'AVENTURAS', 'monstruos_sa_2001.jpg', '', ''),
(25, '<B> HOLA </B> ADIOS', 'ASDAS', 'AVENTURAS', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `contraseña` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `rol` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contraseña`, `email`, `rol`) VALUES
(2, 'raul', 'raul', 'raul@raul.es', 'user'),
(1, 'admin', 'admin', 'admin@admin.es', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`codigo_pelicula`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `codigo_pelicula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
