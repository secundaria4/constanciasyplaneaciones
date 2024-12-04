<?php
include('../sesiones/sesiones.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("../conexion/conexion.php");

    $email = $_POST['email'];
    $password = $_POST['contrasena'];
    $privi = $_POST['privilegio'];
    $status = 1;

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    mysqli_report(MYSQLI_REPORT_OFF);

    $sentencia = "INSERT INTO usuarios (email, contrasena, privilegio, estatus) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sentencia);
    $stmt->bind_param("sssi", $email, $hashed_password, $privi, $status);

    try {
        $ejecutar_sql = $stmt->execute();

        if ($ejecutar_sql) {
            $_SESSION['mensaje'] = 'Registro realizado exitosamente.';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            if ($conn->errno === 1062) {
                $_SESSION['mensaje'] = 'El correo electrónico ya está registrado. Intente con otro.';
                $_SESSION['tipo_mensaje'] = 'warning';
            } else {
                $_SESSION['mensaje'] = 'No se pudo realizar el registro. Intente nuevamente.';
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
    } catch (Exception $e) {
        $_SESSION['mensaje'] = 'Error en el registro: ' . $e->getMessage();
        $_SESSION['tipo_mensaje'] = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <li><span class="breadcrumb-separator"></span><a href="../usuarios/gestion_user.php">Gestión de usuarios</a></li>
        <li><span class="breadcrumb-separator"></span>Registro de usuario</li>
    </ul>
</nav>

<div class="user-form-container">
    <h2 class="user-form-title">Registro de Usuario</h2>
    <form action="registro_user.php" method="post" class="user-form">
        <label for="email" class="user-form-label">Correo Electrónico:</label>
        <input type="email" id="email" name="email" class="user-input-field" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <br><br>

        <label for="contrasena" class="user-form-label">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" class="user-input-field" required>
        <br><br>

        <label for="privilegio" class="user-form-label">Privilegio:</label>
        <select id="privilegio" name="privilegio" class="user-input-field" required>
            <option value="admin" <?php echo (isset($_POST['privilegio']) && $_POST['privilegio'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="docente" <?php echo (isset($_POST['privilegio']) && $_POST['privilegio'] === 'docente') ? 'selected' : ''; ?>>Docente</option>
            <option value="secretaria" <?php echo (isset($_POST['privilegio']) && $_POST['privilegio'] === 'secretaria') ? 'selected' : ''; ?>>Secretaria</option>
            <option value="coordinadora" <?php echo (isset($_POST['privilegio']) && $_POST['privilegio'] === 'coordinadora') ? 'selected' : ''; ?>>Coordinadora</option>
        </select>
        <br><br>

        <button type="submit" class="user-submit-button">Registrar Usuario</button>
        <button class="ro" type="button" onclick="window.location.href='gestion_user.php'">Cancelar</button>
    </form>
</div>

<script>
    <?php if (isset($_SESSION['mensaje'])): ?>
        Swal.fire({
            title: "<?php echo ($_SESSION['tipo_mensaje'] === 'success') ? '¡Éxito!' : '¡Atención!'; ?>",
            text: "<?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?>",
            icon: "<?php echo htmlspecialchars($_SESSION['tipo_mensaje'], ENT_QUOTES, 'UTF-8'); ?>",
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed && "<?php echo $_SESSION['tipo_mensaje']; ?>" === "success") {
                window.location.href = '../usuarios/gestion_user.php';
            }
        });
        <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
    <?php endif; ?>
</script>
</body>
</html>
