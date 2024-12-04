-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2024 a las 22:22:05
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
-- Base de datos: `secundaria4`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `constancias`
--

CREATE TABLE `constancias` (
  `num_constancia` int(11) NOT NULL,
  `formato` int(11) DEFAULT NULL,
  `empleado` varchar(13) DEFAULT NULL,
  `emitido_por` varchar(64) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `CURP` varchar(18) NOT NULL,
  `RFC` varchar(13) NOT NULL,
  `titulo` varchar(15) DEFAULT NULL COMMENT 'se coloca solo abreviaciones como LIC. , ING, etc.',
  `nombres` text NOT NULL,
  `apellido_p` varchar(128) DEFAULT NULL,
  `apellido_m` varchar(128) DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `telefono_movil` varchar(16) DEFAULT NULL,
  `telefono_fijo` varchar(16) DEFAULT NULL,
  `estado_civil` tinytext DEFAULT NULL,
  `CP` varchar(5) DEFAULT NULL,
  `col_fracc` varchar(50) DEFAULT NULL,
  `calle` varchar(128) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `fecha_contrato` date NOT NULL,
  `puesto` text DEFAULT NULL COMMENT 'puesto de trabajo (director, docente, secretaria, etcsa)',
  `turno` varchar(32) NOT NULL,
  `horario_entrada` time NOT NULL,
  `horario_salida` time NOT NULL,
  `estatus` binary(1) DEFAULT NULL,
  `dado_de_baja_por` varchar(100) DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `CURP`, `RFC`, `titulo`, `nombres`, `apellido_p`, `apellido_m`, `sexo`, `fecha_nacimiento`, `email`, `telefono_movil`, `telefono_fijo`, `estado_civil`, `CP`, `col_fracc`, `calle`, `numero`, `fecha_contrato`, `puesto`, `turno`, `horario_entrada`, `horario_salida`, `estatus`, `dado_de_baja_por`, `fecha_baja`) VALUES
(1, 'GOMA900726HDFRRL07', 'GOMA900726HD4', 'LIC.', 'Juan Carlos', 'Gómez', 'Martínez', 'M', '1990-07-26', 'jc.gomez@example.com', '5512345678', '5532123456', 'Casado', '6500', 'Centro', 'Insurgentes', '123', '2023-01-15', 'Docente', 'Matutino', '08:00:00', '15:00:00', 0x30, NULL, NULL),
(2, 'MULA850519MDFRRD06', 'MULA850519MD5', 'PROF.', 'María Luisa', 'Martínez', 'Álvares', 'F', '1985-05-19', 'm.luisa@example.com', '5534567890', '', 'soltero', '6100', 'Condesa', 'Reforma', '234', '2022-06-10', 'docente', 'Vespertino', '14:00:00', '20:00:00', 0x30, NULL, '2024-12-03'),
(3, 'RUCA800314HDFLLN09', 'RUCA800314HD6', NULL, 'Rosa', 'Uribe', 'Contreras', 'F', '1980-03-14', 'r.uribe@example.com', '5523456789', NULL, 'Divorciada', '6030', 'Norte', 'Juárez', '56', '2021-09-20', 'Secretaria', 'Matutino', '08:00:00', '15:00:00', 0x30, NULL, NULL),
(4, 'PEAR910515HDFRNS01', 'PEAR9105158J0', 'LIC.', 'Alonso Sai', 'Macias', 'Sandoval', 'M', '1975-05-15', 'alonso.macias@example.com', '1234567890', '9876543210', 'soltero', '34000', 'Centro', '20 de noviembre', '123', '2024-01-01', 'docente', 'Matutino', '07:00:00', '15:00:00', 0x30, 'PRUEBA', '2024-12-03'),
(5, 'ROSA890128MDFRNZ08', 'ROSA8901284J0', 'MTRA.', 'Rosa', 'Hernandez', 'López', 'F', '1989-01-28', 'rosa.hernandez@example.com', '2345678901', '8765432109', 'Soltero', '34000', '20 de Noviembre', '20 de Noviembre', '456', '2024-01-01', 'Docente', 'Matutino', '08:00:00', '16:00:00', 0x30, NULL, '2024-12-03'),
(6, 'MARJ960512MDFNSR02', 'MARJ9605129K0', 'LIC.', 'María', 'Jiménez', 'Ramírez', 'F', '1996-05-12', 'maria.jimenez@example.com', '3456789012', '7654321098', 'Casado', '34000', 'Las Palmas', 'benito', '789', '2024-01-01', 'Secretaria', 'Vespertino', '13:00:00', '21:00:00', 0x30, NULL, NULL),
(7, 'ABC123456789012345', 'ABCJ900101XYZ', 'LIC.', 'Juan Carlos', 'Perez', 'González', 'M', '2000-05-03', 'juan.perez@example.com', '5551234567', '', 'soltero', '12345', 'colonia centro', '15 de mayo', '103', '2024-11-15', 'docente', 'Matutino', '08:00:00', '14:00:00', 0x31, NULL, NULL),
(8, 'ABCD123456HGRRRL01', 'ABCD123456XYZ', '', 'LIC.', 'Pérez', 'Nevarez', 'M', '2000-06-21', 'kamisamadatenshi@gmail.com', '61845654645', '', 'viudo', '34160', 'huizache1', 'tres culturas', '105', '2024-11-17', 'secretaria', 'matutino', '20:00:00', '14:00:00', 0x30, NULL, NULL),
(11, 'LOPE890612HDFNNS05', 'LOPE890612HDF', 'ti', 'Juan Carlos', 'Pérez', 'Nevarez', 'M', '2024-11-17', 'kamisamadatenshi@gmail.com', '61845654645', '6345663', 'soltero', '34160', 'huizache1', 'tres culturas', '105', '2024-11-17', 'docente', 'matutino', '07:34:00', '19:34:00', 0x30, NULL, NULL),
(12, 'LOPE890612HDFNNS06', 'ABCD123456XYF', 'ti', 'Juan Carlos', 'sanchez', 'González', 'M', '2024-11-17', 'kamisamadatenshi@gmail.com', '61845654645', '6345663', 'soltero', '34160', 'huizache1', 'tres culturas', '105', '2024-11-17', 'docente', 'matutino', '08:47:00', '20:47:00', 0x31, NULL, NULL),
(13, 'Wanc050508hdglvrag', 'ABCD123456XYa', 'ti', 'LIC.', 'sanchez', 'Nevarez', 'M', '2024-11-17', 'cristopher_3041230319@utd.edu.mx', '61845654645', '6345663', 'casado', '34160', 'huizache1', 'tres culturas', '105', '2024-11-07', 'docente', 'matutino', '08:49:00', '20:49:00', 0x30, NULL, NULL),
(14, 'ABCD123456HGRRRL0f', 'WANC0505', 'ti', 'LIC.', 'sanchez', 'González', 'M', '2024-11-07', 'kamisamadatenshi@gmail.com', '61845654645', '6345663', 'casado', '34160', 'huizache1', 'tres culturas', '105', '2024-11-08', 'secretaria', 'matutino', '11:53:00', '22:55:00', 0x30, NULL, NULL),
(15, 'LOPA890912HDFNNl06', 'MERD123456XYG', 'Sr.', 'Laura', 'sanchez', 'Nevarez', 'F', '2024-11-19', 'kamisamadatenshi@gmail.com', '61845654645', '6345663', 'soltero', '34160', 'huizache1', 'tres culturas', '105', '2024-11-19', 'docente', 'matutino', '07:49:00', '19:49:00', 0x31, NULL, NULL),
(16, 'GOMA900726HDHTYJ0', 'OPQE890612FRG', 'lic. Ti', 'Sara Vinsmoke', 'Paez', 'Cruz', 'F', '1996-03-07', 'laura@gmail.com', '61845654645', '6345663', 'soltero', '34160', 'huizache1', 'tres culturas', '105', '2013-02-15', 'docente', 'matutino', '08:00:00', '14:00:00', 0x30, 'PRUEBA', NULL),
(17, 'DERE890612HDFNNS90', 'RETE890612KOL', 'lic. Ti', 'Chris Fernando', 'Unzueta', 'Cruz', 'M', '1992-02-05', 'Cruz123@gmail.com', '61845654645', '634566334', 'casado', '34345', 'huizache2', 'cluiclahuac', '145', '2018-07-20', 'docente', 'vespertino', '08:00:00', '14:16:00', 0x31, NULL, NULL),
(18, 'RIGG050902HDGVRRA3', 'RIGG050902', 'ING', 'Gregorio Antonio', 'Rivas', 'Garcia', 'M', '2005-09-02', 'goyor419@gmail.com', '6183350471', '6183350471', 'soltero', '34046', 'Cerro de las Rosas', 'Rosa Blanca', '23', '2019-08-02', 'docente', 'Matutino', '08:00:00', '20:00:00', 0x31, NULL, NULL),
(19, 'HJDK050508HDGLVRA6', 'ADJKSDUEFOE', 'Tecnico ', 'Pedro Sais', 'Vinsmoke', 'Kiemon', 'M', '2024-12-02', 'pedro@gmail.com', '6183456743', '7894356', 'Casado/a', '34678', 'colonia clicla', 'Tres culturas', '154', '2024-12-02', 'Docente', 'Vespertino', '10:34:00', '22:34:00', 0x30, NULL, '2024-12-03'),
(20, 'HDJJ050508HDGLVRA6', 'ADJKSDKJDKFJS', '', 'Alonso', 'Rosales', 'Martinez', 'M', '2024-12-02', 'alonso@utd', '6183456743', '7894356', 'soltero', '34678', 'colonia clicla', 'Tres culturas', '154', '2024-12-02', 'docente', 'Vespertino', '10:57:00', '22:57:00', 0x30, NULL, NULL),
(21, 'HJKD050508HDGLVRA6', 'ADJKSDIEIRIEI', 'Pedagogía ', 'Alonso', 'Rosales', 'Martinez', 'M', '2024-12-02', 'alonso@utd', '6183456743', '7894356', 'soltero', '34678', 'calle clicla', 'Tres culturas', '154', '2024-12-02', 'docente', 'Vespertino', '10:59:00', '22:59:00', 0x30, NULL, NULL),
(22, 'FRHL50508HDGLVRA6', 'ADJKSDJFSJDFK', 'M. en Ped.', 'Alonso', 'Rosales', 'Martinez', 'M', '2024-12-02', 'alonso@utd', '6183456743', '7894356', 'Soltero/a', '34678', 'colonia clicla', 'Tres culturas', '154', '2024-12-02', 'director', 'Vespertino', '11:05:00', '23:05:00', 0x31, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planeaciones`
--

CREATE TABLE `planeaciones` (
  `id_planeacion` int(11) NOT NULL,
  `subido_por` varchar(64) DEFAULT NULL,
  `docente_encargado` varchar(13) DEFAULT NULL,
  `nombre_materia` varchar(255) DEFAULT NULL,
  `grado` varchar(8) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `hora_creacion` time DEFAULT NULL,
  `aprobacion` varchar(11) DEFAULT NULL,
  `aprobado_por` varchar(110) DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT NULL,
  `nom_arch` varchar(60) DEFAULT NULL COMMENT 'Nombre del archivo subido',
  `size_arch` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Tamaño del archivo en bytes',
  `ruta` varchar(80) DEFAULT NULL COMMENT 'Ruta del archivo almacenado',
  `extencion` varchar(10) DEFAULT NULL COMMENT 'Extensión del archivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `planeaciones`
--

INSERT INTO `planeaciones` (`id_planeacion`, `subido_por`, `docente_encargado`, `nombre_materia`, `grado`, `fecha_creacion`, `hora_creacion`, `aprobacion`, `aprobado_por`, `estatus`, `nom_arch`, `size_arch`, `ruta`, `extencion`) VALUES
(56, 'docente@utd', 'ABCD123456XYZ', 'Español', '2-A', '2024-12-02', '11:33:02', 'Desaprobada', 'cordinadora@utd', 1, 'constancia_generada (15).docx', '1045546', '/prototipo2.0/planeaciones/files/constancia_generada (15).docx', 'docx'),
(57, 'docente@utd', 'MERD123456XYG', 'Español', '2-A', '2024-12-02', '17:55:39', 'Si', 'cordinadora@utd', 1, 'constancia_generada (15).docx', '1045546', '/prototipo2.0/planeaciones/files/constancia_generada (15).docx', 'docx'),
(58, 'docente@utd', 'RIGG050902', 'Matematicas', '3B', '2024-12-03', '07:00:06', 'No', 'No aprobado', 1, 'documentacion.docx', '3261394', '/prototipo2.0/planeaciones/files/documentacion.docx', 'docx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_constancias`
--

CREATE TABLE `tipo_constancias` (
  `id_constancia` int(11) NOT NULL,
  `nombre_constancia` varchar(50) DEFAULT NULL,
  `ruta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `email` varchar(64) NOT NULL,
  `contrasena` varchar(255) NOT NULL DEFAULT '',
  `privilegio` text DEFAULT NULL,
  `estatus` binary(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`email`, `contrasena`, `privilegio`, `estatus`) VALUES
('a', '$2y$10$RLduJ/jVUlCFsoFvjZkd.uZ0zXW4t617h/s8jbPi52ekoXdMEila6', 'cordinadora', 0x30),
('admin', '$2y$10$KJi6XnNd0roMsl.CNbcVfuWeEIR9xy9a2v8N4w4CID.RocLvqdypW', 'admin', 0x30),
('admin@utd', '$2y$10$qPChodPIiBYuGLt2peHboOucyxUBWoQiA8rYDurcDXZTANQ/zbd66', 'admin', 0x31),
('B', '$2y$10$GVRxnALIxwVUtOaKmIZG6uHB8TcQ2iFNVkM71yTLLSHIIEVk10e2i', 'docente', 0x30),
('C', '$2y$10$tqzMP6K/x79e9leNxUUsdOnOrRXnVFdX1hDIc.d/81W8R5T9NxBKu', 'cordinadora', 0x30),
('Carlo', '$2y$10$heDui6dfcGXabSYE.TOjx.VVsXZQaluaHhrwdHk4gItDHchk.oG3q', 'docente', 0x30),
('cordinadora@utd', '$2y$10$mBbhEc6.vFlNTvgDLWQY5e/WWU6icUadDqNLO2Mf6Ws91WSOMK4wS', 'coordinadora', 0x31),
('Cruz@gmail.com', '$2y$10$YKr3lmRMYM5SE04dpa35l.x6rW7a5lgESO5nNLXSe96vKlRPp/Vnq', 'docente', 0x31),
('docente', 'pass', 'docente', 0x30),
('docente@utd', '$2y$10$Dg7usuudqXf3ZFejaGmzLu9rcp/FTJfVOiIVHx5Sb2j8QvoDQ5CRS', 'docente', 0x31),
('falla', 'pass', 'consulta', 0x30),
('goyo@gmail', '$2y$10$o58MasEEQZlLcgl7GvTVzOV18H9tyCHoy60XFJq8Y/QbR9Dc0w4DS', 'docente', 0x31),
('goyor@gmail', '$2y$10$W2lgLg/OUUvcRko8yOS5tu26EZeyomRcVVDRVldYt3.9AmFxgOTDC', 'docente', 0x31),
('intento@utd.edu', 'pass', 'docente', 0x31),
('laura@gmail.com', '$2y$10$u7WtZrZWeXqlhJDR5M5oM.03.CM1M9aCZkdk1XeT5XwRFXPQ7s8yO', 'admin', 0x31),
('matias', '123', 'profe', 0x30),
('Matias.Rosales.473@gmail.com', '$2y$10$njPc.Pt1jcZDDyQlvf9qxu/Wxon9oRExrP7sNXW8JFHgdeataMarG', 'admin', 0x31),
('pepi', '1234', 'secretaria', 0x30),
('PRUEBA', '$2y$10$Cs.YX3PrUdXFD0b1gVFar.Wz5vBYgZC7doCQTD6XF9lcWbMGMiuLq', 'admin', 0x31),
('root', '$2y$10$uFYtcIUEMDqOInL9ZyZCjuKZDcXd0kr1lriLH101d8.bsD6KnF2Ae', 'docente', 0x30),
('root2', 'pass', 'docente', 0x30),
('secretaria@utd', '$2y$10$IYUE9g9muwtF0PHwuc86VOk2Hbn2hs52IRkcJ/aZXxF1O21VAOtHa', 'secretaria', 0x31),
('utd@utd.edu.mx', '$2y$10$F4wrbjtPE3MorLe1qj/2dOvMfNwqzz0z2gMTSTCHYsQIcjiurmrbC', 'admin', 0x31);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `constancias`
--
ALTER TABLE `constancias`
  ADD PRIMARY KEY (`num_constancia`),
  ADD KEY `formato` (`formato`),
  ADD KEY `empleado_id` (`empleado`),
  ADD KEY `emitido_por` (`emitido_por`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `CURP` (`CURP`) USING BTREE,
  ADD UNIQUE KEY `RFC` (`RFC`) USING BTREE;

--
-- Indices de la tabla `planeaciones`
--
ALTER TABLE `planeaciones`
  ADD PRIMARY KEY (`id_planeacion`),
  ADD KEY `subido_por` (`subido_por`),
  ADD KEY `docente_encargado` (`docente_encargado`),
  ADD KEY `aprobado_por` (`aprobado_por`);

--
-- Indices de la tabla `tipo_constancias`
--
ALTER TABLE `tipo_constancias`
  ADD PRIMARY KEY (`id_constancia`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `constancias`
--
ALTER TABLE `constancias`
  MODIFY `num_constancia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `planeaciones`
--
ALTER TABLE `planeaciones`
  MODIFY `id_planeacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `tipo_constancias`
--
ALTER TABLE `tipo_constancias`
  MODIFY `id_constancia` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `constancias`
--
ALTER TABLE `constancias`
  ADD CONSTRAINT `constancias_ibfk_1` FOREIGN KEY (`formato`) REFERENCES `tipo_constancias` (`id_constancia`),
  ADD CONSTRAINT `constancias_ibfk_2` FOREIGN KEY (`empleado`) REFERENCES `empleados` (`RFC`) ON UPDATE CASCADE,
  ADD CONSTRAINT `constancias_ibfk_3` FOREIGN KEY (`emitido_por`) REFERENCES `usuarios` (`email`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `planeaciones`
--
ALTER TABLE `planeaciones`
  ADD CONSTRAINT `planeaciones_ibfk_2` FOREIGN KEY (`docente_encargado`) REFERENCES `empleados` (`RFC`),
  ADD CONSTRAINT `planeaciones_ibfk_3` FOREIGN KEY (`subido_por`) REFERENCES `usuarios` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
