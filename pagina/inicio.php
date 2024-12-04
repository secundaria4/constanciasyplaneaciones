<?php
session_start();
include("../sesiones/sesiones.php"); // Asegúrate de que la ruta sea correcta
// Obtener privilegio de la sesión
$privilegio = $_SESSION['privilegio']; // Ya está asegurado que existe por la verificación en sesiones.php
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<!-- Barra de navegación -->
<nav class="navbar">
    <div class="navbar-left">
        <!-- Logo añadido -->
        <a href="../pagina/inicio.php" class="navbar-logo">
            <img src="../img/logo_esc_sec_4.png" alt="Logo" class="logo" >
        </a>
        <button class="menu-toggle" id="menu-toggle">☰</button>
        <ul class="navbar-menu" id="navbar-menu">
            <!-- Navegación según privilegios (ya existente en tu código) -->
            <?php if ($privilegio == 'admin'): ?>
                <li><a href="../pagina/inicio.php" class="navbar-link">Inicio</a></li>
                <li><a href="../empleados/tabla2.php" class="navbar-link">Gestión de empleados</a></li>
                <li><a href="../usuarios/gestion_user.php" class="navbar-link">Gestión de usuarios</a></li>
                <li><a href="../empleados/bajas.php" class="navbar-link">Empleados dados de baja</a></li>
            <?php endif; ?>
            <!-- Otros privilegios... -->
               <!-- Barra de navegación para docentes -->
            <?php if ($privilegio == 'docente'): ?>
                <li><a href="../pagina/inicio.php" class="navbar-link">Inicio</a></li>
                <li><a href="../planeaciones/planeaciones.php" class="navbar-link">Planeaciones</a></li>
             
            <?php endif; ?>

            <!-- Barra de navegación para secretarias -->
            <?php if ($privilegio == 'secretaria'): ?>
                <li><a href="../empleados/tabla3.php" class="navbar-link">Inicio</a></li>
            <?php endif; ?>

            <!-- Barra de navegación para coordinadoras -->
            <?php if ($privilegio == 'coordinadora'): ?>
                <li><a href="../planeaciones/aprobar_planeacion.php" class="navbar-link">Planeaciones</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Perfil del usuario con menú desplegable -->
    <div class="user-profile">
        <span class="user-name" id="user-name"><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
        <div class="dropdown-menu" id="dropdown-menu">
            <a href="../sesiones/logout.php" class="logout-link">Cerrar sesión</a>
        </div>
    </div>
</nav>

<!-- Breadcrumb para indicar la ubicación actual -->
<nav aria-label="breadcrumb" class="breadcrumb">
    <ul>
        <li><a href="../pagina/inicio.php">Inicio</a></li>
        <?php if ($privilegio == 'admin'): ?>
            <?php if (strpos($_SERVER['PHP_SELF'], 'tabla2.php') !== false): ?>
                <li>Gestión de empleados</li>
            <?php elseif (strpos($_SERVER['PHP_SELF'], 'gestion_user.php') !== false): ?>
                <li>Gestión de usuarios</li>
            <?php elseif (strpos($_SERVER['PHP_SELF'], 'bajas.php') !== false): ?>
                <li>Empleados dados de baja</li>
            <?php else: ?>
                <li>Panel de administración</li>
            <?php endif; ?>
        <?php elseif ($privilegio == 'docente'): ?>
            <?php if (strpos($_SERVER['PHP_SELF'], 'planeaciones.php') !== false): ?>
                <li>Planeaciones</li>
            <?php elseif (strpos($_SERVER['PHP_SELF'], 'constancias2.php') !== false): ?>
                <li>Constancias</li>
            <?php else: ?>
                <li>Panel docente</li>
            <?php endif; ?>

        <?php elseif ($privilegio == 'coordinadora'): ?>
            <?php if (strpos($_SERVER['PHP_SELF'], 'aprobar_planeacion.php') !== false): ?>
                <li>Aprobar planeaciones</li>
            <?php else: ?>
                <li>Panel cordinadora</li>
            <?php endif; ?>

        <?php elseif ($privilegio == 'secretaria'): ?>
            <?php if (strpos($_SERVER['PHP_SELF'], 'tabla3.php') !== false): ?>
                <li>Inicio</li>
            <?php elseif (strpos($_SERVER['PHP_SELF'], 'constancias.php') !== false): ?>
                <li>Constancias</li>
            <?php else: ?>
                <li>Panel de secretaría</li>
            <?php endif; ?>
        <?php else: ?>
            <li>Sin privilegios</li>
        <?php endif; ?>
    </ul>
</nav>
>
</nav>


    <div id="access-container">
        <h1 class="main-title">Tienes acceso</h1>
        <p class="privilege-info">Privilegio: <span id="privilege"><?php echo htmlspecialchars($privilegio); ?></span></p>

        <table class="privileges-table">
            <tr>
                <th>Sección</th>
                <th>Descripción</th>
            </tr>
            <?php if ($privilegio == 'admin'): ?>
                <tr>
                    <td>Administradores</td>
                    <td>Acceso a contenido exclusivo para administradores.</td>
                </tr>
                <tr>
                    <td><a href="../empleados/tabla2.php" class="link">Gestionar empleados</a></td>
                    <td>Visualizar la informacion de los empleados.</td>
                </tr>
                <tr>
                    <td><a href="../usuarios/gestion_user.php" class="navbar-link">Gestionar usuarios</a></td>
                    <td>Visualizar los usuarios en el sistema.</td>
                </tr>
                <tr>
                    <td><a href="../empleados/bajas.php" class="link">Gestionar empleados anteriores</a></td>
                    <td>Visualizar los empleados anteriorees.</td>
                </tr>
            <?php elseif ($privilegio == 'docente'): ?>
                <tr>
                    <td>Docentes</td>
                    <td>Acceso a contenido exclusivo para docentes.</td>
                </tr>
                <tr>
                    <td><a href="../planeaciones/planeaciones.php" class="link">Planeaciones</a></td>
                    <td>Acceso a las planeaciones del docente.</td>
                </tr>
                
                <?php elseif ($privilegio == 'coordinadora'): ?>
                <tr>
                    <td>Cordinadora</td>
                    <td>Acceso a contenido exclusivo para cordinadora.</td>
                </tr>
                <tr>
                    <td><a href="../planeaciones/aprobar_planeacion.php" class="link">Planeaciones</a></td>
                    <td>Acceso a las planeaciones de los docentes.</td>
                </tr>
            <?php elseif ($privilegio == 'secretaria'): ?>
                <tr>
                    <td>Secretarias</td>
                    <td>Acceso a contenido exclusivo para secretarias.</td>
                </tr>
                <tr>
                    <td><a href="../constancias/constancias.php" class="link">Constancias</a></td>
                    <td>Emitir y visualizar las constancias disponibles.</td>
                </tr>
            <?php else: ?>
                <tr>
                    <td>Sin privilegios</td>
                    <td>No tienes privilegios especiales asignados.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <script>
        // Script para manejar el menú desplegable del perfil
        document.getElementById('user-name').addEventListener('click', function () {
            const dropdownMenu = document.getElementById('dropdown-menu');
            dropdownMenu.classList.toggle('active');
        });

        // Script para el menú hamburguesa en dispositivos pequeños
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const menu = document.getElementById('navbar-menu');
            menu.classList.toggle('active');
        });
    </script>
</body>
</html>
