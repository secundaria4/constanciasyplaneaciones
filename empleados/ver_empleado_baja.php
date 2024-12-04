<?php
// Incluir el archivo de conexión
include("../conexion/conexion.php");
include("../sesiones/sesiones.php");

// Obtener la CURP del empleado de la URL
$curp = isset($_GET['curp']) ? $_GET['curp'] : '';

// Preparar y ejecutar la consulta
$query = "SELECT CURP, RFC, nombres, apellido_p, apellido_m, sexo, 
          fecha_nacimiento, email, telefono_movil, puesto, turno, 
          horario_entrada, horario_salida, col_fracc, 
          dado_de_baja_por, fecha_baja 
          FROM empleados 
          WHERE CURP = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $curp);  // "s" porque CURP es string
$stmt->execute();
$result = $stmt->get_result();
$empleado = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Empleado</title>
    <link rel="stylesheet" href="../estilos.css">
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
        <li><span class="breadcrumb-separator"></span><a href="bajas.php">Empleados dados de baja</a></li>
        <li><span class="breadcrumb-separator"></span>Empleados dados de baja</li>
    </ul>
</nav>

<div class="ver-container">
    <?php if ($empleado): ?>
        <div class="ver-content">
            <div class="ver-header">
                <h1 class="ver-title">
                    <?php echo htmlspecialchars($empleado['nombres'] . ' ' .
                        $empleado['apellido_p'] . ' ' .
                        $empleado['apellido_m']); ?>
                </h1>
                <span class="ver-job-title">
                    <?php echo htmlspecialchars($empleado['puesto']); ?>
                </span>
            </div>

            <div class="ver-sections">
                <div class="ver-section">
                    <h2 class="ver-section-title">Información Personal</h2>
                    <div class="ver-details">
                        <p>
                            <span class="ver-label">CURP:</span>
                            <?php echo htmlspecialchars($empleado['CURP']); ?>
                        </p>
                        <p>
                            <span class="ver-label">RFC:</span>
                            <?php echo htmlspecialchars($empleado['RFC']); ?>
                        </p>
                        <p>
                            <span class="ver-label">Fecha de Nacimiento:</span>
                            <?php echo date('d/m/Y', strtotime($empleado['fecha_nacimiento'])); ?>
                        </p>
                        <p>
                            <span class="ver-label">Sexo:</span>
                            <?php echo $empleado['sexo'] === 'M' ? 'Masculino' : 'Femenino'; ?>
                        </p>
                    </div>
                </div>

                <div class="ver-section">
                    <h2 class="ver-section-title">Información de Contacto</h2>
                    <div class="ver-details">
                        <p>
                            <span class="ver-label">Email:</span>
                            <a href="mailto:<?php echo htmlspecialchars($empleado['email']); ?>" class="ver-link">
                                <?php echo htmlspecialchars($empleado['email']); ?>
                            </a>
                        </p>
                        <p>
                            <span class="ver-label">Teléfono:</span>
                            <?php echo htmlspecialchars($empleado['telefono_movil']); ?>
                        </p>
                    </div>
                </div>

                <div class="ver-section">
                    <h2 class="ver-section-title">Información Laboral</h2>
                    <div class="ver-details">
                        <p>
                            <span class="ver-label">Turno:</span>
                            <?php echo htmlspecialchars($empleado['turno']); ?>
                        </p>
                        <p>
                            <span class="ver-label">Horario:</span>
                            <?php echo htmlspecialchars($empleado['horario_entrada'] . ' - ' .
                                $empleado['horario_salida']); ?>
                        </p>
                    </div>
                </div>

                <div class="ver-section">
                        <h2 class="ver-section-title">Información de Baja</h2>
                        <div class="ver-details">
                            <p>
                                <span class="ver-label">Dado de baja por:</span>
                                <?php echo htmlspecialchars($empleado['dado_de_baja_por']); ?>
                            </p>
                            <p>
                                <span class="ver-label">Dado de baja el:</span>
                                <?php echo date('d/m/Y', strtotime($empleado['fecha_baja'])); ?>
                            </p>
                        </div>
                    </div>

                <?php if (!empty($empleado['dado_de_baja_por']) && !empty($empleado['fecha_baja'])): ?>
                    <div class="ver-section">
                        <h2 class="ver-section-title">Información de Baja</h2>
                        <div class="ver-details">
                            <p>
                                <span class="ver-label">Dado de baja por:</span>
                                <?php echo htmlspecialchars($empleado['dado_de_baja_por']); ?>
                            </p>
                            <p>
                                <span class="ver-label">Dado de baja el:</span>
                                <?php echo date('d/m/Y', strtotime($empleado['fecha_baja'])); ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="ver-actions">
                <a href="bajas.php" class="ver-button ver-button-back">
                    Regresar a la Lista
                </a>
                <a href="mod_empleado.php?curp=<?php echo urlencode($empleado['CURP']); ?>" class="ver-button ver-button-edit">
                    Modificar Empleado
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="ver-error">
            <p>No se encontró información del empleado.</p>
            <p>
                <a href="tabla2.php" class="ver-button ver-button-back">
                    Volver a la lista de empleados
                </a>
            </p>
        </div>
    <?php endif; ?>
</div>

<?php
$stmt->close();
$conn->close();
?>

<script>
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