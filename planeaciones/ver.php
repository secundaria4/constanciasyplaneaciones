<?php
session_start();
include_once("../conexion/conexion.php");
include("../sesiones/sesiones.php"); // Asegura que la sesión está activa

// Obtener el ID de la planeación desde la URL
$id_planeacion = isset($_GET['id_planeacion']) ? $_GET['id_planeacion'] : 0;

// Si no se proporciona un ID válido, redirige o muestra un mensaje
if ($id_planeacion == 0) {
    echo "<p>No se encontró la planeación.</p>";
    exit;
}

// Consultar la base de datos para obtener la información de la planeación seleccionada
$consulta = "SELECT id_planeacion, subido_por, docente_encargado, nombre_materia, grado, 
             fecha_creacion, hora_creacion, aprobacion, aprobado_por, estatus, nom_arch, 
             size_arch, ruta, extencion FROM planeaciones WHERE id_planeacion = ?";
$stmt = $conn->prepare($consulta);
$stmt->bind_param("i", $id_planeacion);
$stmt->execute();
$resultado = $stmt->get_result();

// Si no se encuentra la planeación, muestra un mensaje
if ($resultado->num_rows == 0) {
    echo "<p>Planeación no encontrada.</p>";
    exit;
}

// Recuperar la fila de resultados
$fila = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Planeación</title>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="stylesheet" href="../verplan-estilos.css"> <!-- Archivo CSS adicional -->
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
        </ul>
    </div>

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
        <li><a href="aprobar_planeacion.php"><span class="breadcrumb-separator"></span>Aprobar planeación</a></li>
        <li><span class="breadcrumb-separator"></span>Ver planeación</li>
    </ul>
</nav> 


<!-- Contenido principal -->
<div class="verplan-container">
    <h3 class="verplan-title">Planeación #<?php echo $fila['id_planeacion']; ?></h3>
    <hr>
    <div class="planeacion-card">
        <p><strong>Subido por:</strong> <?php echo htmlspecialchars($fila['subido_por']); ?></p>
        <p><strong>Docente encargado:</strong> <?php echo htmlspecialchars($fila['docente_encargado']); ?></p>
        <p><strong>Materia:</strong> <?php echo htmlspecialchars($fila['nombre_materia']); ?></p>
        <p><strong>Grado:</strong> <?php echo htmlspecialchars($fila['grado']); ?></p>
        <p><strong>Fecha de creación:</strong> <?php echo htmlspecialchars($fila['fecha_creacion']); ?> a las <?php echo htmlspecialchars($fila['hora_creacion']); ?></p>
        <p><strong>Aprobación:</strong> <?php echo htmlspecialchars($fila['aprobacion']); ?> por <?php echo htmlspecialchars($fila['aprobado_por']); ?></p>
        <p><strong>Estatus:</strong> <?php echo htmlspecialchars($fila['estatus']); ?></p>
        <p><strong>Nombre del archivo:</strong> <?php echo htmlspecialchars($fila['nom_arch']); ?> (<?php echo htmlspecialchars($fila['size_arch']); ?> KB)</p>
        <p><strong>Extensión:</strong> <?php echo htmlspecialchars($fila['extencion']); ?></p>
        <p><a href="<?php echo htmlspecialchars($fila['ruta']); ?>" target="_blank" class="ver-button ver-button-back">Ver Archivo</a></p>
        <div class="planeacion-actions">
            <a href="aprobar.php?id_planeacion=<?php echo $fila['id_planeacion']; ?>" class="ver-button ver-button-edit">Aprobar</a> |
            <a href="desaprobar.php?id_planeacion=<?php echo $fila['id_planeacion']; ?>" class="ver-button ver-button-edit">Desaprobar</a>
        </div>
    </div>
    
    <!-- Botón para regresar a la lista -->
    <div class="back-to-list">
    <p>
                    <a href="aprobar_planeacion.php" class="ver-button ver-button-back">
                        Volver a la lista de planeaciones
                    </a>
                </p>
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
</script>
</body>
</html>
