<?php
// Incluir el archivo de conexión
require_once('../conexion/conexion.php');
include('../sesiones/sesiones.php');

// Verificar si se ha enviado un término de búsqueda
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC'; // Determinar el orden

// Consulta para obtener los campos específicos de los empleados con orden
if (!empty($search)) {
    $sql = "SELECT CURP, nombres, apellido_p, puesto, turno 
            FROM empleados 
            WHERE estatus = 1 
            AND (nombres LIKE ? OR apellido_p LIKE ? OR CURP LIKE ? OR puesto LIKE ?)
            ORDER BY nombres $order"; // Cambiar el campo por el que ordenar si es necesario

    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search . "%"; // Creamos el término de búsqueda con comodines

    // Vinculamos los parámetros: buscamos en nombres, apellido_p, CURP y puesto
    $stmt->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT CURP, nombres, apellido_p, puesto, turno  
            FROM empleados 
            WHERE estatus = 1
            ORDER BY nombres $order"; // Orden por defecto
    $result = $conn->query($sql);
}


// Procesar eliminación si se recibe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_curp'])) {
    $curp = $_POST['delete_curp'];
    $delete_sql = "UPDATE empleados SET estatus = 0 WHERE CURP = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $curp);
    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../estilos.css">
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
        <li>Inicio</li>
        
    </ul>
</nav>  

    <!-- Contenedor principal -->
    <div class="tabla2-container">
        <!-- Título -->
        <h1 class="tabla2-title">Empleados</h1>

        <!-- Botones y barra de búsqueda -->
        <div>
            <a href="../constancias/constancias.php" class="tabla2-add-link">Emitir Constancia </a>
            <a href="tabla3.php" class="tabla2-add-link">Ver todos los empleados</a>
            <form method="GET" action="tabla3.php" class="busqueda-form">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Busqueda de empleado" 
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

        <!-- Tabla -->
        <table class="tabla2-table">
            <thead>
                <tr>
                    <th>CURP</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Puesto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["CURP"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nombres"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["apellido_p"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["puesto"]) . "</td>";
                        echo "<td class='tabla2-actions'>";
                        echo "<a href='ver_empleado_sec.php?curp=" . urlencode($row["CURP"]) . "'><i class='fa fa-eye'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay empleados registrados</td></tr>";
                }
                ?>
            </tbody>
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
