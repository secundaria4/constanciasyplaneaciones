<?php
// Incluir el archivo de conexión
require_once('../conexion/conexion.php');
include('../sesiones/sesiones.php');

// Verificar si se ha enviado un término de búsqueda
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC'; // Orden por defecto es ascendente

// Consulta para obtener los campos específicos de los empleados con orden
if (!empty($search)) {
    $sql = "SELECT CURP, nombres, apellido_p, puesto, turno 
            FROM empleados 
            WHERE estatus = 1 
            AND (nombres LIKE ? OR apellido_p LIKE ? OR CURP LIKE ? OR puesto LIKE ?)
            ORDER BY nombres $order";

    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search . "%";
    $stmt->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT CURP, nombres, apellido_p, puesto, turno  
            FROM empleados 
            WHERE estatus = 1
            ORDER BY nombres $order";
    $result = $conn->query($sql);
}

// Procesar eliminación si se recibe una solicitud POST
// Procesar eliminación si se recibe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_curp'])) {
    $curp = $_POST['delete_curp'];
    $usuario_logueado = $_SESSION['usuario']; // Usuario logueado
    $fecha_baja = date('Y-m-d'); // Fecha actual

    // Actualizamos el registro marcándolo como inactivo y registrando el usuario que lo dio de baja
    $delete_sql = "UPDATE empleados 
                   SET estatus = 0, 
                       dado_de_baja_por = ?, 
                       fecha_baja = ? 
                   WHERE CURP = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("sss", $usuario_logueado, $fecha_baja, $curp);  // Usar $usuario_logueado en lugar de $usuario

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
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

    <!-- Incluir la librería SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
<nav class="navbar" id="navbar">
    <div class="navbar-left" id="navbar-left">
        <a class="navbar-logo">
        <img src="../img/logo_esc_sec_4.png" alt="Logo" class="logo">
        </a>
        <button class="menu-toggle" id="menu-toggle">☰</button>
        <ul class="navbar-menu" id="navbar-menu">
            <li><a href="../pagina/inicio.php" class="navbar-link">Inicio</a></li>
            <li><a href="../empleados/tabla2.php" class="navbar-link">Gestión de empleados</a></li>
            <li><a href="../usuarios/gestion_user.php" class="navbar-link">Gestión de usuarios</a></li>
            <li><a href="../empleados/bajas.php" class="navbar-link">Empleados dados de baja</a></li>
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

<nav aria-label="breadcrumb" class="breadcrumb">
    <ul>
        <li><a href="../pagina/inicio.php">Inicio</a></li>
        <li><span class="breadcrumb-separator"></span>Gestión de empleados</li>
    </ul>
</nav>

<div class="tabla2-container">
    <h1 class="tabla2-title">Gestión de Empleados</h1>
    <div>
        <a href="registrar_empleado.php" class="tabla2-add-link">+ Añadir Empleado</a>
        <a href="tabla2.php" class="tabla2-add-link">Ver todos los empleados</a>
        <form method="GET" action="tabla2.php" class="busqueda-form">
            <input type="text" name="search" placeholder="Busqueda de empleado" class="busqueda-input" 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="busqueda-button">
                <i class="fa fa-search"></i>
            </button>
            <button type="submit" name="order" value="asc" class="busqueda-button">A-Z</button>
            <button type="submit" name="order" value="desc" class="busqueda-button">Z-A</button>
        </form>
    </div>
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
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["CURP"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["nombres"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["apellido_p"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["puesto"]) . "</td>";
                    echo "<td class='tabla2-actions'>";
                    echo "<a href='ver_empleado.php?curp=" . urlencode($row["CURP"]) . "'><i class='fa fa-eye'></i></a>";
                    echo "<a href='mod_empleado.php?curp=" . urlencode($row["CURP"]) . "'><i class='fa fa-edit'></i></a>";
                    echo "<form method='POST' class='inline' id='deleteForm-" . htmlspecialchars($row["CURP"]) . "'>";
                    echo "<input type='hidden' name='delete_curp' value='" . htmlspecialchars($row["CURP"]) . "'>";
                    echo "<button type='button' onclick=\"confirmDelete('" . htmlspecialchars($row['CURP']) . "')\"><i class='fa fa-trash'></i></button>";
                    echo "</form>";
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
    function confirmDelete(curp) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará al empleado de manera definitiva.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + curp).submit();
            }
        });
    }

    document.getElementById('user-name').addEventListener('click', function () {
        const dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.classList.toggle('active');
    });

    document.getElementById('menu-toggle').addEventListener('click', function () {
        const menu = document.getElementById('navbar-menu');
        menu.classList.toggle('active');
    });
</script>

</body>
</html>
