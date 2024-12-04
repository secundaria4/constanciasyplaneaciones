<?php
include('../sesiones/sesiones.php');

$entrar = "";
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1.- Conectarse a la BD
    include("../conexion/conexion.php");

    // Obtener los datos del formulario
    $curp_em = strtoupper($_POST['CURP']);  
    $rfc_em = strtoupper($_POST['RFC']);
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
    $estatus_em = 1; // Asumiendo que el valor de estatus es siempre 1

    // Verificar si la CURP o el RFC ya existen
    if (empty($curp_em) || empty($rfc_em) || empty($nombres_em) || empty($apellido_p_em)) {
        $mensaje = "Envío inválido: Algunos campos obligatorios están vacíos.";
        $entrar = "envioinvalido";  // Esta es la nueva variable que indica un error en el envío
    } else {
        $verificar_sql = "SELECT COUNT(*) as total FROM empleados WHERE CURP = '$curp_em' OR RFC = '$rfc_em'";
        $resultado = mysqli_query($conn, $verificar_sql);
        $fila = mysqli_fetch_assoc($resultado);

        if ($fila['total'] > 0) {
            $mensaje = "La CURP y/o RFC ya se encuentran en el sistema.";
        } else {
            // Insertar el empleado
            $sentencia = "INSERT INTO empleados 
            (CURP, RFC, titulo, nombres, apellido_p, apellido_m, sexo, fecha_nacimiento, email, telefono_movil, telefono_fijo, estado_civil, CP, col_fracc, calle, numero, fecha_contrato, puesto, turno, horario_entrada, horario_salida, estatus) 
            VALUES ('$curp_em', '$rfc_em', '$titulo_em', '$nombres_em', '$apellido_p_em', '$apellido_m_em', '$sexo_em', '$fecha_nacimiento_em', '$email_em', '$telefono_movil_em', '$telefono_fijo_em', '$estado_civil_em', '$cp_em', '$col_fracc_em', '$calle_em', '$numero_em', '$fecha_contrato_em', '$puesto_em', '$turno_em', '$horario_entrada_em', '$horario_salida_em', $estatus_em)";
            
            if (mysqli_query($conn, $sentencia)) {
                $entrar = "insertar";
                $mensaje = "Empleado registrado con éxito";
            } else {
                $entrar = "noinsertar";
                $mensaje = "Error al registrar el empleado: " . mysqli_error($conn);
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Empleado</title>
    <link rel="stylesheet" href="../estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.onload = function() {
            <?php if (!empty($mensaje)) { ?>
                Swal.fire({
                    title: "<?php echo ($entrar === 'insertar') ? '¡Éxito!' : ($entrar === 'envioinvalido' ? 'Envío Inválido' : 'Error'); ?>",
                    text: "<?php echo $mensaje; ?>",
                    icon: "<?php echo ($entrar === 'insertar') ? 'success' : ($entrar === 'envioinvalido' ? 'warning' : 'error'); ?>",
                    showConfirmButton: <?php echo ($entrar === 'insertar' || $entrar === 'envioinvalido') ? 'true' : 'false'; ?>,
                    timer: <?php echo ($entrar === 'insertar') ? '2000' : 'null'; ?>
                }).then(() => {
                    <?php if ($entrar === "insertar") { ?>
                        window.location.href = "tabla2.php";
                    <?php } ?>
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
        <li><span class="breadcrumb-separator"></span><a href="../empleados/tabla2.php">Gestión de empleados</a></li>
        <li><span class="breadcrumb-separator"></span>Registro de empleados</li>
    </ul>
</nav>

    <table id="registro-form-container">
        <tr>
            <td colspan="2">
                <h1 id="registro-form-title">Formulario de Registro de Empleados</h1>
                <button class="ver-button ver-button-back"type="button" onclick="window.location.href='tabla2.php'">Regresar a la Lista</button>
            </td>
        </tr>
        <tr id="registro-form-content">
            <td colspan="2">
                <form action="registrar_empleado.php" method="POST">
                 <!-- CURP -->
                    <label class="registro-form-label" for="curp">CURP:</label>
                    <input class="registro-form-input texto-mayusculas" type="text" id="curp" name="CURP" maxlength="18" required><br><br>

                    <!-- RFC -->
                    <label class="registro-form-label" for="rfc">RFC:</label>
                    <input class="registro-form-input texto-mayusculas" type="text" id="rfc" name="RFC" maxlength="13" required><br><br>

                    <!-- Título -->
                    <label class="registro-form-label" for="titulo">Título:</label>
                    <input class="registro-form-input" type="text" id="titulo" name="titulo" maxlength="15"><br><br>

                    <!-- Nombres -->
                    <label class="registro-form-label" for="nombres">Nombres:</label>
                    <input class="registro-form-input" type="text" id="nombres" name="nombres" required><br><br>

                    <!-- Apellidos -->
                    <label class="registro-form-label" for="apellido_p">Apellido Paterno:</label>
                    <input class="registro-form-input" type="text" id="apellido_p" name="apellido_p" required><br><br>

                    <label class="registro-form-label" for="apellido_m">Apellido Materno:</label>
                    <input class="registro-form-input" type="text" id="apellido_m" name="apellido_m"><br><br>

                    <!-- Sexo -->
                    <label class="registro-form-label" for="sexo">Sexo:</label>
                    <input class="registro-form-radio" type="radio" id="sexo_m" name="sexo" value="M"> Masculino
                    <input class="registro-form-radio" type="radio" id="sexo_f" name="sexo" value="F"> Femenino<br><br>

                    <!-- Fecha de Nacimiento -->
                    <label class="registro-form-label" for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input class="registro-form-input" type="date" id="fecha_nacimiento" name="fecha_nacimiento"><br><br>

                    <!-- Email -->
                    <label class="registro-form-label" for="email">Email:</label>
                    <input class="registro-form-input" type="email" id="email" name="email" required><br><br>

                    <!-- Teléfonos -->
                    <label class="registro-form-label" for="telefono_movil">Teléfono Móvil:</label>
                    <input class="registro-form-input" type="text" id="telefono_movil" name="telefono_movil" required><br><br>

                    <label class="registro-form-label" for="telefono_fijo">Teléfono Fijo:</label>
                    <input class="registro-form-input" type="text" id="telefono_fijo" name="telefono_fijo"><br><br>

                    <!-- Dirección -->
                    <label class="registro-form-label" for="cp">Código Postal:</label>
                    <input class="registro-form-input" type="text" id="cp" name="CP" maxlength="5" required><br><br>

                    <label class="registro-form-label" for="col_fracc">Colonia/Fraccionamiento:</label>
                    <input class="registro-form-input" type="text" id="col_fracc" name="col_fracc" required><br><br>

                    <label class="registro-form-label" for="calle">Calle:</label>
                    <input class="registro-form-input" type="text" id="calle" name="calle"><br><br>

                    <label class="registro-form-label" for="numero">Número:</label>
                    <input class="registro-form-input" type="text" id="numero" name="numero"><br><br>

                    <!-- Estado Civil -->
                    <label class="registro-form-label" for="estado_civil">Estado Civil:</label>
                    <select class="registro-form-input" name="estado_civil" id="estado_civil">
                        <option value="Soltero/a">Soltero/a</option>
                        <option value="Casado/a">Casado/a</option>
                        <option value="Divorciado/a">Divorciado/a</option>
                        <option value="Viudo/a">Viudo/a</option>
                    </select><br><br>

                    <!-- Contrato -->
                    <label class="registro-form-label" for="fecha_contrato">Fecha de Contrato:</label>
                    <input class="registro-form-input" type="date" id="fecha_contrato" name="fecha_contrato"><br><br>

                    <!-- Puesto -->
                    <label class="registro-form-label" for="puesto">Puesto:</label>
                    <input class="registro-form-input" type="text" id="puesto" name="puesto" required><br><br>

                    <!-- Turno -->
                    <label class="registro-form-label" for="turno">Turno:</label>
                    <input class="registro-form-input" type="text" id="turno" name="turno" required><br><br>

                    <!-- Horario -->
                    <label class="registro-form-label" for="horario_entrada">Horario de Entrada:</label>
                    <input class="registro-form-input" type="time" id="horario_entrada" name="horario_entrada" required><br><br>

                    <label class="registro-form-label" for="horario_salida">Horario de Salida:</label>
                    <input class="registro-form-input" type="time" id="horario_salida" name="horario_salida" required><br><br>

                    <!-- Botones -->
                    <button class="registro-form-button" type="submit">Enviar</button>
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

    // Script para el menú hamburguesa en dispositivos pequeños
    document.getElementById('menu-toggle').addEventListener('click', function () {
        const menu = document.getElementById('navbar-menu');
        menu.classList.toggle('active');
    });
</script>
</body>

</html>
