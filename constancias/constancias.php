<?php
session_start();
include("../sesiones/sesiones.php"); // Asegúrate de que la ruta sea correcta
// Obtener privilegio de la sesión
$privilegio = $_SESSION['privilegio']; // Ya está asegurado que existe por la verificación en sesiones.php
if ($privilegio != 'docente' && $privilegio != 'directivo' && $privilegio != 'secretaria') {
    // Si el privilegio no es 'docente' o 'directivo', redirigir a una página de error o login
    header("Location: ../sesiones/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constancias</title>
    <link rel="stylesheet" href="../estilos.css">
   
</head>
<body>
<nav class="navbar" id="navbar">
    <div class="navbar-left" id="navbar-left">
        <!-- Logo a la izquierda -->
        <a href="#" class="navbar-logo">
        <img src="../img/logo_esc_sec_4.png" alt="Logo" class="logo" >
        </a>
        <button class="menu-toggle" id="menu-toggle">☰</button>
        <ul class="navbar-menu" id="navbar-menu">
        <li><a href="../empleados/tabla3.php" class="navbar-link">Inicio</a></li>
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
        <li><a href="../empleados/tabla3.php">Inicio</a></li>
        <li><span class="breadcrumb-separator"></span>Constancias</li>
    </ul>
</nav>  

    <!-- Contenedor del panel -->
    <div id="access-container">
        <h1 class="main-title">Bienvenido, <?php echo ucfirst($privilegio); ?></h1>
        <p class="privilege-info">Privilegio: <span id="privilege"><?php echo htmlspecialchars($privilegio); ?></span></p>

        <div class="form">
            <div class="form-group">
               <!-- <a href="../constancias/ver_constancias.php" class="form-button">Ver Constancias</a><br>-->
                <?php if ($privilegio == 'secretaria'): ?>
                    <a href="index.php" class="form-button">Generar Constancias</a>
                    <?php endif; ?>
                      <!-- Botones de Acción -->
                <div class="ver-actions">
                    <a href="../empleados/tabla3.php" class="ver-button ver-button-back">
                        Regresar a la Lista
                    </a>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript para manejar el menú adaptable
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const menu = document.getElementById('navbar-menu');
            menu.classList.toggle('active');
        });
        
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
