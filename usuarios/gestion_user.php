<?php
// Incluir el archivo de conexión
require_once('../conexion/conexion.php');
include('../sesiones/sesiones.php');

// Verificar si se ha enviado un término de búsqueda
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC'; // Determinar el orden

// Consulta para obtener los campos específicos de los usuarios activos
if (!empty($search)) {
    $sql = "SELECT email, privilegio, estatus 
            FROM usuarios 
            WHERE estatus = 1 
            AND (email LIKE ? OR privilegio LIKE ?)
            ORDER BY email $order"; // Orden por email
    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search . "%";
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT email, privilegio, estatus FROM usuarios WHERE estatus = 1 ORDER BY email $order"; // Orden por email
    $result = $conn->query($sql);
}

// Procesar eliminación si se recibe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_email'])) {
    $email = $_POST['delete_email'];
    $delete_sql = "UPDATE usuarios SET estatus = 0 WHERE email = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $email);
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
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../estilos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<!-- Breadcrumb para indicar la ubicación actual -->
<nav aria-label="breadcrumb" class="breadcrumb">
    <ul>
        <li><a href="../pagina/inicio.php">Inicio</a></li>
        <li><span class="breadcrumb-separator"></span>Gestión de usuarios</li>
    </ul>
</nav>

<div class="gesuser">
    <h1>Gestión de Usuarios</h1>

    <!-- Barra de búsqueda y botones -->
    <div>
        <a href="registro_user.php">+ Añadir Usuario</a>
        <a href="gestion_user.php">Ver todos los usuarios</a>
        <form method="GET" action="gestion_user.php" class="busqueda-form">
            <input 
                type="text" 
                name="search" 
                placeholder="Buscar usuario" 
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

    <!-- Tabla de usuarios -->
    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Privilegio</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["privilegio"]) . "</td>";
                    echo "<td>" . ($row["estatus"] == 1 ? "Activo" : "Inactivo") . "</td>";
                    echo "<td class='tabla2-actions'>";
                    echo "<a href='mod_user.php?email=" . urlencode($row["email"]) . "'><i class='fa fa-edit'></i></a>";
                    echo "<button class='d-button' onclick='confirmarEliminacion(\"" . htmlspecialchars($row["email"]) . "\")'><i class='fa fa-trash'></i></button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay usuarios registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    // Función para manejar la confirmación de eliminación
    function confirmarEliminacion(email) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Este usuario será dado de baja.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = 'gestion_user.php';
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_email';
                input.value = email;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

</body>
</html>
