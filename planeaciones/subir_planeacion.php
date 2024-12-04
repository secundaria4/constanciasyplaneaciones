<?php
session_start();
include("../sesiones/sesiones.php"); // Asegúrate de que la ruta sea correcta

$mensaje = ''; // Definimos la variable mensaje

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_FILES['archivo']['name']) && $_FILES['archivo']['size'] > 0) {
        // Usuario que sube el archivo
        $subido_por = $_SESSION['usuario'];

        // Datos del archivo
        $nom_file = $_FILES['archivo']['name'];
        $size_arch = $_FILES['archivo']['size'];
        $extencion_arch = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
        $directorio = pathinfo($_SERVER['PHP_SELF'], PATHINFO_DIRNAME);
        $ruta_file = $directorio . "/files/" . $nom_file;

        // Datos del formulario
        $docente_encargado = $_POST['docente_encargado'];
        $nombre_materia = $_POST['nombre_materia'];
        $grado = $_POST['grado'];

        // Validar extensión del archivo
        $extensiones_permitidas = ["doc", "docx", "pdf", "xls", "xlsx"];
        if (in_array($extencion_arch, $extensiones_permitidas)) {
            // Subir archivo al servidor
            if (move_uploaded_file($_FILES['archivo']['tmp_name'], "files/" . $nom_file)) {
                require_once("../conexion/conexion.php");

                // Consulta para insertar los datos
                $consulta = "INSERT INTO planeaciones 
                            (subido_por, docente_encargado, nombre_materia, grado, fecha_creacion, hora_creacion, aprobacion, aprobado_por, estatus, nom_arch, size_arch, ruta, extencion) 
                            VALUES ('$subido_por', '$docente_encargado', '$nombre_materia', '$grado', CURDATE(), CURTIME(), 'No', 'No aprobado', 1, '$nom_file', '$size_arch', '$ruta_file', '$extencion_arch')";

                $resultado = $conn->query($consulta);

                if ($resultado) {
                    $mensaje = "¡Planeación agregada! La planeación se ha subido correctamente.";
                } else {
                    $mensaje = "Error en la base de datos. No se pudo registrar la planeación. Por favor, verifica la información.";
                }
            } else {
                $mensaje = "Error al subir el archivo. No se pudo copiar el archivo al servidor.";
            }
        } else {
            $mensaje = "Extensión no permitida. Solo se permiten archivos con extensiones: doc, docx, pdf, xls, xlsx.";
        }
    } else {
        $mensaje = "Archivo no seleccionado. Por favor, selecciona un archivo antes de enviar.";
    }
}
?>

<!DOCTYPE html>
<html>  
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Planeación</title>
    <link rel="stylesheet" href="../estilos.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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
            <li><a href="../planeaciones/planeaciones.php" class="navbar-link">Planeaciones</a></li>
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
        <li><span class="breadcrumb-separator"></span><a href="planeaciones.php">Planeaciones</a></li>
        <li><span class="breadcrumb-separator"></span>Subir planeación</li>
    </ul>
</nav>  

<div class="plan-container">
    <div class="plan-header">
        <h3 class="plan-title">Subir Planeación</h3>
    </div>
    <hr>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <table class="plan-table">
            <tr>
                <td>Seleccionar Archivo</td>
                <td>
                    <input name="archivo" type="file" class="file-input">  
                </td>
            </tr>
            <tr>
                <td>Docente Encargado</td>
                <td>
                    <select name="docente_encargado" class="input-field" required>
                        <option value="" disabled selected>Seleccionar Docente</option>
                        <?php
                        require_once("../conexion/conexion.php");
                        $consulta_docentes = "SELECT RFC, CONCAT(nombres, ' ', apellido_p, ' ', apellido_m) AS nombre_completo FROM empleados";
                        $result_docentes = $conn->query($consulta_docentes);
                        while ($docente = $result_docentes->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($docente['RFC']) . "'>" . htmlspecialchars($docente['nombre_completo']) . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nombre de la Materia</td>
                <td>
                    <input type="text" name="nombre_materia" class="input-field" required>
                </td>
            </tr>
            <tr>
                <td>Grado</td>
                <td>
                    <input type="text" name="grado" class="input-field" required>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" name="enviar" class="plan-button">Subir</button>
                    <button type="reset" name="borrar" class="plan-button plan-reset">Cancelar</button>
                </td>
            </tr>
        </table>
    </form>
    <hr>
    <a href="ver_planeacion.php" class="plan-link">Ver Planeaciones</a>
</div>

<script>
    // Si hay mensaje, mostrar la alerta
    <?php if ($mensaje): ?>
        Swal.fire({
            icon: '<?php echo strpos($mensaje, "¡Planeación agregada!") !== false ? "success" : (strpos($mensaje, "Error") !== false ? "error" : "info"); ?>',
            title: '<?php echo htmlspecialchars($mensaje); ?>',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed && '<?php echo strpos($mensaje, "¡Planeación agregada!") !== false ? "true" : "false"; ?>' === 'true') {
                window.location.href = 'ver_planeacion.php';
            }
        });
    <?php endif; ?>

    // Menú adaptable
    document.getElementById('menu-toggle').addEventListener('click', function () {
        const menu = document.getElementById('navbar-menu');
        menu.classList.toggle('active');
    });
    // Menú desplegable del perfil
    document.getElementById('user-name').addEventListener('click', function () {
        const dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.classList.toggle('active');
    });
</script>
</body>
</html>
