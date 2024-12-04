<?php
session_start();
include_once("../conexion/conexion.php");
include("../sesiones/sesiones.php"); // Asegura que la sesión está activa
// Procesar búsqueda y orden
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

// Consulta base
$consulta = "SELECT id_planeacion, subido_por, docente_encargado, nombre_materia, grado, 
             fecha_creacion, hora_creacion, aprobacion, aprobado_por, estatus, nom_arch, 
             size_arch, ruta, extencion 
             FROM planeaciones";

// Si hay búsqueda, agregar condición
if (!empty($search)) {
    $consulta .= " WHERE docente_encargado LIKE ? OR nombre_materia LIKE ? OR grado LIKE ?";
}

// Agregar orden por defecto
$consulta .= " ORDER BY docente_encargado $order";

$stmt = $conn->prepare($consulta);
if (!empty($search)) {
    $search_param = "%" . $search . "%";
    $stmt->bind_param("sss", $search_param, $search_param, $search_param);
}
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeaciones</title>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="stylesheet" href="../verplan-estilos.css"> <!-- Archivo CSS adicional -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<nav class="navbar" id="navbar">
    <div class="navbar-left" id="navbar-left">
        <!-- Logo a la izquierda -->
        <a class="navbar-logo">
        <img src="../img/logo_esc_sec_4.png" alt="Logo" class="logo" >
        </a>
        <button class="menu-toggle" id="menu-toggle">☰</button>
        <ul class="navbar-menu" id="navbar-menu">
                <li><a href="../pagina/inicio.php" class="navbar-link">Inicio</a></li>
                <li><a href="../planeaciones/planeaciones.php" class="navbar-link">Planeaciones</a></li>
                
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
        <li><span class="breadcrumb-separator"></span><a href="planeaciones.php">Planeaciones</a></li>
        <li><span class="breadcrumb-separator"></span>Ver planeaciónes</li>
    </ul>
</nav>  

    <!-- Contenido principal -->
    <div class="verplan-container">
        <h3 class="verplan-title">Planeaciones</h3>

            <!-- Barra de búsqueda -->
            <div class="busqueda-container">
            <form method="GET" action="aprobar_planeacion.php" class="busqueda-form">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar planeación..." 
                    class="busqueda-input" 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="busqueda-button">
                    <i class="fa fa-search"></i>
                </button>
                <!-- Botones de orden ascendente y descendente -->
                <button type="submit" name="order" value="asc" class="busqueda-button">A-Z</button>
                <button type="submit" name="order" value="desc" class="busqueda-button">Z-A</button>
            </form>
        </div>
        

        <div class="verplan-table-container">
            <?php
            $consulta = "SELECT id_planeacion, subido_por, docente_encargado, nombre_materia, grado, 
                         fecha_creacion, hora_creacion, aprobacion, aprobado_por, estatus, nom_arch, 
                         size_arch, ruta, extencion FROM planeaciones";
            $resultado = $conn->query($consulta);

            echo "<table class='verplan-table'>";
            echo "<tr class='verplan-header-row'>


                    <th>Docente</th>
                    <th>Materia</th>
                    <th>Grado</th>

                    <th>Aprobación</th>



                    <th>Ruta</th>

                    <th>Acciones</th>
                  </tr>";

            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr class='verplan-row'>";
                // echo "<td>" . $fila['id_planeacion'] . "</td>";
                // echo "<td>" . htmlspecialchars($fila['subido_por']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['docente_encargado']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['nombre_materia']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['grado']) . "</td>";
                // echo "<td>" . htmlspecialchars($fila['fecha_creacion']) . "</td>";
                // echo "<td>" . htmlspecialchars($fila['hora_creacion']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['aprobacion']) . "</td>";
                // echo "<td>" . htmlspecialchars($fila['aprobado_por']) . "</td>";
                // echo "<td>" . htmlspecialchars($fila['estatus']) . "</td>";
                // echo "<td>" . htmlspecialchars($fila['nom_arch']) . "</td>";
                // echo "<td>" . htmlspecialchars($fila['size_arch']) . " KB</td>";
                echo "<td><a href='" . htmlspecialchars($fila['ruta']) . "' target='_blank' class='verplan-link'>Ver Archivo</a></td>";
                // echo "<td>" . htmlspecialchars($fila['extencion']) . "</td>";
                echo "<td>
                        <div class='acciones-container'>
                            <a href='ver2.php?id_planeacion=" . $fila['id_planeacion'] . "' class='verplan-action-link'>
                                <i class='fa fa-eye'></i>
                            </a>
                            <a href='eliminar_planeacion.php?id_planeacion=" . $fila['id_planeacion'] . "' class='verplan-action-link'>
                                <i class='fa fa-trash'></i>
                            </a>
                        </div>
                    </td>";

                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>
        <hr>
        <div class="verplan-actions">
            <a href="subir_planeacion.php" class="plan-link">Subir Planeación</a>
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
