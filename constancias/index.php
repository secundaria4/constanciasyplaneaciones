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
    <title>Generar Constancia</title>
    <link rel="stylesheet" href="../estilos.css">
    <script>
        function cargarDatosEmpleado(empleadoId) {
            if (empleadoId == "") {
                document.getElementById("empleado_datos").value = "";
                return;
            }
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "obtener_datos_empleado.php?id=" + empleadoId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const datos = JSON.parse(xhr.responseText);
                    document.getElementById("empleado_datos").value = JSON.stringify(datos);
                }
            };
            xhr.send();
        }

        function cargarDatosDirector(directorId) {
            if (directorId == "") {
                document.getElementById("director_datos").value = "";
                return;
            }
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "obtener_datos_director.php?id=" + directorId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const datos = JSON.parse(xhr.responseText);
                    document.getElementById("director_datos").value = JSON.stringify(datos);
                }
            };
            xhr.send();
        }
    </script>
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
        <li><a href="constancias.php">Constancias</a></li>
        <li><span class="breadcrumb-separator"></span>Generar constancias</li>
    </ul>
</nav>  
    <div class="constancias">
        <div class="constancias-header">
            <h1 class="constancias-title">Generar Constancias</h1>
        </div>
        <form class="constancias-form" action="crear_constancia.php" method="POST">
            <label for="tipo_constancia" class="constancias-label">Tipo de Constancia:</label>
            <select id="tipo_constancia" name="tipo_constancia" class="constancias-select" required>
                <option value="">Selecciona un tipo de constancia</option>
                <option value="1">Tipo 1</option>
                <option value="2">Tipo 2</option>
                <option value="3">Tipo 3</option>
                <option value="4">Tipo 4</option>
                <option value="5">Tipo 5</option>
            </select>
            
            <label for="director" class="constancias-label">Director:</label>
            <select id="director" name="director" class="constancias-select" required onchange="cargarDatosDirector(this.value)">
                <option value="">Selecciona un director</option>
                <?php
                include 'conexion.php';

                $sql = "SELECT id_empleado, CONCAT(titulo, ' ', nombres, ' ', apellido_p, ' ', apellido_m) AS nombre_completo FROM empleados WHERE puesto = 'director'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="'.$row["id_empleado"].'">'.$row["nombre_completo"].'</option>';
                    }
                }

                $conn->close();
                ?>
            </select>

            <label for="empleado" class="constancias-label">Empleado:</label>
            <select id="empleado" name="empleado" class="constancias-select" required onchange="cargarDatosEmpleado(this.value)">
                <option value="">Selecciona un empleado</option>
                <?php
                include 'conexion.php';

                $sql = "SELECT id_empleado, CONCAT(titulo, ' ', nombres, ' ', apellido_p, ' ', apellido_m) AS nombre_completo FROM empleados WHERE puesto != 'director'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="'.$row["id_empleado"].'">'.$row["nombre_completo"].'</option>';
                    }
                }

                $conn->close();
                ?>
            </select>

            <input type="hidden" id="empleado_datos" name="empleado_datos">
            <input type="hidden" id="director_datos" name="director_datos">

            <input type="submit" value="Generar Constancia" class="constancias-submit">
            <a href="../empleados/tabla3.php" class="ver-button ver-button-back">
                        Regresar a la Lista
                    </a>
        </form>
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
