<?php
include('../sesiones/sesiones.php');

$mensaje = "";

// 1.- Conectarse a la BD
include("../conexion/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['curp'])) {
    $curp_em = $_GET['curp'];

    // Consultar datos del empleado
    $consulta_sql = "SELECT * FROM empleados WHERE CURP = '$curp_em'";
    $resultado = mysqli_query($conn, $consulta_sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        $empleado = $fila;
    } else {
        $mensaje = "Empleado no encontrado.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $curp_em = $_POST['CURP'];
    $rfc_em = $_POST['RFC'];
    $titulo_em = $_POST['titulo'];
    $nombres_em = $_POST['nombres'];
    $apellido_p_em = $_POST['apellido_p'];
    $apellido_m_em = $_POST['apellido_m'];
    $sexo_em = $_POST['sexo'];
    $fecha_nacimiento_em = $_POST['fecha_nacimiento'];
    $email_em = $_POST['email'];
    $telefono_movil_em = $_POST['telefono_movil'];
    $telefono_fijo_em = $_POST['telefono_fijo'];
    $estado_civil_em = $_POST['estado_civil'];
    $cp_em = $_POST['CP'];
    $col_fracc_em = $_POST['col_fracc'];
    $calle_em = $_POST['calle'];
    $numero_em = $_POST['numero'];
    $fecha_contrato_em = $_POST['fecha_contrato'];
    $puesto_em = $_POST['puesto'];
    $turno_em = $_POST['turno'];
    $horario_entrada_em = $_POST['horario_entrada'];
    $horario_salida_em = $_POST['horario_salida'];

    // Actualizar los datos del empleado
    $sentencia = "UPDATE empleados SET 
        RFC = '$rfc_em', 
        titulo = '$titulo_em', 
        nombres = '$nombres_em', 
        apellido_p = '$apellido_p_em', 
        apellido_m = '$apellido_m_em', 
        sexo = '$sexo_em', 
        fecha_nacimiento = '$fecha_nacimiento_em', 
        email = '$email_em', 
        telefono_movil = '$telefono_movil_em', 
        telefono_fijo = '$telefono_fijo_em', 
        estado_civil = '$estado_civil_em', 
        CP = '$cp_em', 
        col_fracc = '$col_fracc_em', 
        calle = '$calle_em', 
        numero = '$numero_em', 
        fecha_contrato = '$fecha_contrato_em', 
        puesto = '$puesto_em', 
        turno = '$turno_em', 
        horario_entrada = '$horario_entrada_em', 
        horario_salida = '$horario_salida_em' 
        WHERE CURP = '$curp_em'";

    if (mysqli_query($conn, $sentencia)) {
        $mensaje = "Datos del empleado actualizados con éxito.";
    } else {
        $mensaje = "Error al actualizar los datos: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Empleado</title>
    <link rel="stylesheet" href="../estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.onload = function () {
            <?php if (!empty($mensaje)) { ?>
                Swal.fire({
                    title: 'Cambio Exitoso',
                    text: "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>",
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    window.location.href = "tabla2.php";
                });
            <?php } ?>
        };
    </script>
</head>


<body>
    <nav class="navbar" id="navbar">
        <div class="navbar-left" id="navbar-left">
            <!-- Logo a la izquierda -->
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
            <span class="user-name" id="user-name">
                <?php echo htmlspecialchars($_SESSION['usuario']); ?>
            </span>
            <div class="dropdown-menu" id="dropdown-menu">

                <a href="../sesiones/logout.php" class="logout-link">Cerrar sesión</a>
            </div>
        </div>
    </nav>
    <!-- Breadcrumb para indicar la ubicación actual -->
    <nav aria-label="breadcrumb" class="breadcrumb">
        <ul>
            <li><a href="../pagina/inicio.php">Inicio</a></li>
            <li><span class="breadcrumb-separator"></span><a href="../empleados/tabla2.php">Gestión de empleados</a>
            </li>
            <li><span class="breadcrumb-separator"></span>Modificar empleado</li>
        </ul>
    </nav>


    <table id="registro-form-container">
        <tr>
            <td colspan="2">
                <h1 id="registro-form-title">Modificar Empleado</h1>
                <button class="ver-button ver-button-back" type="button"
                    onclick="window.location.href='tabla2.php'">Regresar a la Lista</button>
            </td>
        </tr>

        <tr id="registro-form-content">

            <td colspan="2">
                <form action="mod_empleado.php" method="POST">
                    <!-- CURP -->
                    <label class="registro-form-label" for="CURP">CURP:</label>
                    <input class="registro-form-input" type="text" name="CURP"
                        value="<?php echo $empleado['CURP'] ?? ''; ?>" readonly><br><br>

                    <!-- RFC -->
                    <label class="registro-form-label" for="RFC">RFC:</label>
                    <input class="registro-form-input" type="text" name="RFC"
                        value="<?php echo $empleado['RFC'] ?? ''; ?>" readonly><br><br>

                    <!-- Título -->
                    <label class="registro-form-label" for="titulo">Título:</label>
                    <input class="registro-form-input" type="text" name="titulo"
                        value="<?php echo $empleado['titulo'] ?? ''; ?>"><br><br>

                    <!-- Nombres -->
                    <label class="registro-form-label" for="nombres">Nombres:</label>
                    <input class="registro-form-input" type="text" name="nombres"
                        value="<?php echo $empleado['nombres'] ?? ''; ?>" required><br><br>

                    <!-- Apellidos -->
                    <label class="registro-form-label" for="apellido_p">Apellido Paterno:</label>
                    <input class="registro-form-input" type="text" name="apellido_p"
                        value="<?php echo $empleado['apellido_p'] ?? ''; ?>" required><br><br>

                    <label class="registro-form-label" for="apellido_m">Apellido Materno:</label>
                    <input class="registro-form-input" type="text" name="apellido_m"
                        value="<?php echo $empleado['apellido_m'] ?? ''; ?>"><br><br>

                    <!-- Sexo -->
                    <label class="registro-form-label" for="sexo">Sexo:</label>
                    <input class="registro-form-radio" type="radio" name="sexo" value="M" <?php echo
                        ($empleado['sexo']=='M' ) ? 'checked' : '' ; ?>> Masculino
                    <input class="registro-form-radio" type="radio" name="sexo" value="F" <?php echo
                        ($empleado['sexo']=='F' ) ? 'checked' : '' ; ?>> Femenino<br><br>

                    <!-- Fecha de Nacimiento -->
                    <label class="registro-form-label" for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input class="registro-form-input" type="date" name="fecha_nacimiento"
                        value="<?php echo $empleado['fecha_nacimiento'] ?? ''; ?>"><br><br>

                    <!-- Email -->
                    <label class="registro-form-label" for="email">Email:</label>
                    <input class="registro-form-input" type="email" name="email"
                        value="<?php echo $empleado['email'] ?? ''; ?>" required><br><br>

                    <!-- Teléfonos -->
                    <label class="registro-form-label" for="telefono_movil">Teléfono Móvil:</label>
                    <input class="registro-form-input" type="text" name="telefono_movil"
                        value="<?php echo $empleado['telefono_movil'] ?? ''; ?>" required><br><br>

                    <label class="registro-form-label" for="telefono_fijo">Teléfono Fijo:</label>
                    <input class="registro-form-input" type="text" name="telefono_fijo"
                        value="<?php echo $empleado['telefono_fijo'] ?? ''; ?>"><br><br>

                    <!-- Dirección -->
                    <label class="registro-form-label" for="cp">Código Postal:</label>
                    <input class="registro-form-input" type="text" name="CP"
                        value="<?php echo $empleado['CP'] ?? ''; ?>" required><br><br>

                    <label class="registro-form-label" for="col_fracc">Colonia/Fraccionamiento:</label>
                    <input class="registro-form-input" type="text" name="col_fracc"
                        value="<?php echo $empleado['col_fracc'] ?? ''; ?>" required><br><br>

                    <label class="registro-form-label" for="calle">Calle:</label>
                    <input class="registro-form-input" type="text" name="calle"
                        value="<?php echo $empleado['calle'] ?? ''; ?>"><br><br>

                    <label class="registro-form-label" for="numero">Número:</label>
                    <input class="registro-form-input" type="text" name="numero"
                        value="<?php echo $empleado['numero'] ?? ''; ?>"><br><br>

                    <!-- Estado Civil -->
                    <label class="registro-form-label" for="estado_civil">Estado Civil:</label>
                    <select class="registro-form-select" name="estado_civil" required>
                        <option value="soltero" <?php echo ($empleado['estado_civil']=='soltero' ) ? 'selected' : '' ;
                            ?>>Soltero</option>
                        <option value="casado" <?php echo ($empleado['estado_civil']=='casado' ) ? 'selected' : '' ; ?>
                            >Casado</option>
                        <option value="viudo" <?php echo ($empleado['estado_civil']=='viudo' ) ? 'selected' : '' ; ?>
                            >Viudo</option>
                    </select><br><br>

                    <!-- Fecha de Contrato -->
                    <label class="registro-form-label" for="fecha_contrato">Fecha de Contrato:</label>
                    <input class="registro-form-input" type="date" name="fecha_contrato"
                        value="<?php echo $empleado['fecha_contrato'] ?? ''; ?>" required><br><br>

                    <!-- Puesto -->
                    <label class="registro-form-label" for="puesto">Puesto:</label>
                    <select class="registro-form-select" name="puesto">
                        <option value="docente" <?php echo ($empleado['puesto']=='docente' ) ? 'selected' : '' ; ?>
                            >Docente</option>
                        <option value="administrativo" <?php echo ($empleado['puesto']=='administrativo' ) ? 'selected'
                            : '' ; ?>>Administrativo</option>
                        <option value="secretaria" <?php echo ($empleado['puesto']=='secretaria' ) ? 'selected' : '' ;
                            ?>>Secretaria</option>
                    </select><br><br>

                    <!-- Turno -->
                    <label class="registro-form-label" for="turno">Turno:</label>
                    <input class="registro-form-input" type="text" name="turno"
                        value="<?php echo $empleado['turno'] ?? ''; ?>" required><br><br>

                    <!-- Horario de Entrada -->
                    <label class="registro-form-label" for="horario_entrada">Horario de Entrada:</label>
                    <input class="registro-form-input" type="time" name="horario_entrada"
                        value="<?php echo $empleado['horario_entrada'] ?? ''; ?>" required><br><br>

                    <!-- Horario de Salida -->
                    <label class="registro-form-label" for="horario_salida">Horario de Salida:</label>
                    <input class="registro-form-input" type="time" name="horario_salida"
                        value="<?php echo $empleado['horario_salida'] ?? ''; ?>" required><br><br>

                    <!-- Botón de Enviar -->
                    <button class="registro-form-button" type="submit">Guardar cambios</button>
                    <button class="r" type="button" onclick="window.location.href='tabla2.php'">Cancelar</button>

                </form>
            </td>
        </tr>
    </table>
    <script>
        // Script para manejar el menú desplegable del perfil
        document.getElementById('user-name').addEventListener('click', function () {
            const dropdownMenu = document.getElementById('dropdown-menu');
            dropdownMenu.classList.toggle('active');
        });

        // Script para el menú en dispositivos pequeños
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const menu = document.getElementById('navbar-menu');
            menu.classList.toggle('active');
        });
    </script>
</body>

</html>