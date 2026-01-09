-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-12-2025 a las 16:46:22
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
-- Base de datos: `active360`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `contenido` text NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `publicacion_id` int(10) UNSIGNED NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `votos` int(11) NOT NULL DEFAULT 0,
  `parent_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `contenido`, `usuario_id`, `publicacion_id`, `creado_en`, `votos`, `parent_id`) VALUES
(8, '¡Mucha suerte Sofia! Yo la corrí el año pasado. Carga hidratos la noche anterior y descansa bien.', 104, 201, '2025-12-09 14:38:43', 5, NULL),
(9, 'No hagas experimentos con geles nuevos el día de la carrera, usa los que ya conozcas.', 106, 201, '2025-12-09 14:38:43', 3, NULL),
(10, 'A mí el 5x5 me funcionó de lujo para salir de los 80kg. Paciencia.', 106, 202, '2025-12-09 14:38:43', 10, NULL),
(11, 'Revisa también tu ingesta de proteínas, a veces el estancamiento es falta de combustible.', 103, 202, '2025-12-09 14:38:43', 4, NULL),
(12, 'Yo la tomo siempre post-entreno con el batido. Funciona por acumulación, así que lo importante es no fallar ningún día.', 102, 203, '2025-12-09 14:38:43', 6, NULL),
(13, 'Exacto, la hora da igual. Yo la tomo en el desayuno para no olvidarme.', 105, 203, '2025-12-09 14:38:43', 2, NULL),
(14, '¡Qué buena pinta! Me encantaría ir pero este finde tengo tirada larga de running.', 101, 204, '2025-12-09 14:38:43', 1, NULL),
(15, '¿Es apta para novatos? Hace poco que tengo la bici de montaña.', 102, 204, '2025-12-09 14:38:43', 0, NULL),
(16, 'Tiene toda la pinta de ser cintilla. Prueba a usar el foam roller en el lateral del muslo, duele pero alivia mucho.', 105, 205, '2025-12-09 14:38:43', 7, NULL),
(17, 'A mí me pasaba por llevar el sillín de la bici muy bajo, vigila eso también.', 104, 205, '2025-12-09 14:38:43', 2, NULL),
(18, '¡Qué envidia! Yo sigo peleando con las dominadas estrictas. ¡Enhorabuena!', 102, 206, '2025-12-09 14:38:43', 12, NULL),
(19, '¡Bravo! La constancia es la clave en todo deporte.', 101, 206, '2025-12-09 14:38:43', 5, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `votos` int(11) NOT NULL DEFAULT 0,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id`, `titulo`, `contenido`, `votos`, `usuario_id`, `creado_en`) VALUES
(8, '¿Consejos para mi primera media maratón?', '¡Hola a todos! Por fin me he animado a apuntarme a la media maratón de Barcelona. Llevo corriendo unos meses, pero nunca he pasado de los 15km. ¿Alguna recomendación sobre nutrición para la semana previa? ¿Debería descansar totalmente los dos días antes o hacer una salida suave? ¡Gracias!', 0, 9, '2025-12-09 14:33:01'),
(201, '¿Consejos para mi primera media maratón?', '¡Hola a todos! Por fin me he animado a apuntarme a la media maratón de Barcelona. Llevo corriendo unos meses, pero nunca he pasado de los 15km. ¿Alguna recomendación sobre nutrición para la semana previa? ¿Debería descansar totalmente los dos días antes o hacer una salida suave? ¡Gracias!', 16, 101, '2025-12-09 14:38:43'),
(202, 'Estancado en el Press de Banca, ayuda.', 'Llevo tres semanas sin poder subir de peso en press banca (estoy en 80kg). He probado a bajar repeticiones y subir series, pero nada. ¿Alguien ha probado el método 5x5 o recomienda hacer descarga? Busco consejos para romper este estancamiento y llegar a los 100kg antes de verano.', 23, 102, '2025-12-09 14:38:43'),
(203, 'Debate: ¿Creatina antes o después de entrenar?', 'He leído estudios contradictorios sobre esto. Unos dicen que es mejor pre-entreno para tener fuerza explosiva y otros que post-entreno para la recuperación muscular. ¿Vosotros cuándo la tomáis? ¿Notáis diferencia real o es indiferente siempre que se tome a diario?', 45, 103, '2025-12-09 14:38:43'),
(204, 'Ruta increíble por Collserola este fin de semana', 'Os comparto la ruta que hicimos ayer con el grupo. Fueron 45km con 800m de desnivel positivo. Las vistas desde el Tibidabo estaban espectaculares. Si alguien se quiere unir para la salida del próximo sábado, saldremos desde Sant Cugat a las 8:00 AM. ¡Avisadme por privado!', 30, 104, '2025-12-09 14:38:43'),
(205, 'Dolor en la rodilla al hacer sentadillas profundas', 'Últimamente noto un pinchazo en la parte externa de la rodilla derecha cuando bajo de los 90 grados en la sentadilla. He revisado la técnica y creo que no meto las rodillas hacia dentro (valgo). ¿Puede ser la cintilla iliotibial? ¿Algún estiramiento que os haya funcionado?', 8, 105, '2025-12-09 14:38:43'),
(206, '¡Conseguí mi primer Muscle Up! 💪', 'Después de 4 meses de intentarlo y mucha frustración con la técnica del \"kipping\", hoy por fin ha salido. La clave ha sido trabajar más la explosividad en las dominadas al pecho. Os dejo este post para animaros a los que estéis luchando con un ejercicio difícil. ¡La constancia paga!', 45, 106, '2025-12-09 14:38:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contrasenya` varchar(255) NOT NULL,
  `genero` enum('masculino','femenino','NS') NOT NULL,
  `terminos` enum('Si','No') NOT NULL DEFAULT 'No',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `token_recuperacion` varchar(255) DEFAULT NULL,
  `token_expiracion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `correo`, `contrasenya`, `genero`, `terminos`, `creado_en`, `token_recuperacion`, `token_expiracion`) VALUES
(9, 'Daniel', 'Cahisa', 'daniel.cahisa@laginesta.com', '$2y$10$tAKyDsgLyqJyRVlbDOAW7eoE9QxH1atmNAX/OMiXe9ij77iam8N1S', 'masculino', 'Si', '2025-12-08 22:52:45', NULL, NULL),
(101, 'Sofia', 'Runner', 'sofia@active360.com', '$2y$10$jX.1.1.1.1.1.1.1.1.1.1', 'femenino', 'Si', '2025-12-09 14:38:43', NULL, NULL),
(102, 'Marc', 'Fuerza', 'marc@active360.com', '$2y$10$jX.1.1.1.1.1.1.1.1.1.1', 'masculino', 'Si', '2025-12-09 14:38:43', NULL, NULL),
(103, 'Laura', 'Nutri', 'laura@active360.com', '$2y$10$jX.1.1.1.1.1.1.1.1.1.1', 'femenino', 'Si', '2025-12-09 14:38:43', NULL, NULL),
(104, 'Alberto', 'Biker', 'Alberto@active360.com', '$2y$10$jX.1.1.1.1.1.1.1.1.1.1', 'masculino', 'Si', '2025-12-09 14:38:43', NULL, NULL),
(105, 'Elena', 'Fisio', 'elena@active360.com', '$2y$10$jX.1.1.1.1.1.1.1.1.1.1', 'femenino', 'Si', '2025-12-09 14:38:43', NULL, NULL),
(106, 'Alex', 'Street', 'alex@active360.com', '$2y$10$jX.1.1.1.1.1.1.1.1.1.1', 'masculino', 'Si', '2025-12-09 14:38:43', NULL, NULL),
(107, 'David', 'Alabarce', 'david@active360.com', '$2y$10$dHxeOLbqOSe6oZNWQJ.Qiuqd2maY3qm4npV8x3eOFsxi258oidpPa', 'femenino', 'Si', '2025-12-09 15:00:17', NULL, NULL),
(108, 'Oriol', 'Rodriguez', 'oriol.active360@gmail.com', '$2y$10$0YuY0Rx4gtXtkxBzOehrR.3eQU5kRMrqNAOG0DRmzaR5nAYVCdBha', 'masculino', 'Si', '2025-12-09 15:01:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos_comentarios`
--

CREATE TABLE `votos_comentarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `comentario_id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `voto` tinyint(4) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos_publicaciones`
--

CREATE TABLE `votos_publicaciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `publicacion_id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `voto` tinyint(4) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `votos_publicaciones`
--

INSERT INTO `votos_publicaciones` (`id`, `publicacion_id`, `usuario_id`, `voto`, `creado_en`) VALUES
(19, 201, 9, 1, '2025-12-09 14:38:50'),
(21, 206, 108, 1, '2025-12-09 15:04:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `publicacion_id` (`publicacion_id`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `votos_comentarios`
--
ALTER TABLE `votos_comentarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_usuario_comentario` (`comentario_id`,`usuario_id`),
  ADD KEY `idx_com` (`comentario_id`),
  ADD KEY `idx_user` (`usuario_id`);

--
-- Indices de la tabla `votos_publicaciones`
--
ALTER TABLE `votos_publicaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_usuario_publicacion` (`publicacion_id`,`usuario_id`),
  ADD KEY `idx_pub` (`publicacion_id`),
  ADD KEY `idx_user` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `votos_comentarios`
--
ALTER TABLE `votos_comentarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `votos_publicaciones`
--
ALTER TABLE `votos_publicaciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`publicacion_id`) REFERENCES `publicaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `votos_comentarios`
--
ALTER TABLE `votos_comentarios`
  ADD CONSTRAINT `fk_vc_comentario` FOREIGN KEY (`comentario_id`) REFERENCES `comentarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_vc_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `votos_publicaciones`
--
ALTER TABLE `votos_publicaciones`
  ADD CONSTRAINT `fk_vp_publicacion` FOREIGN KEY (`publicacion_id`) REFERENCES `publicaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_vp_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
