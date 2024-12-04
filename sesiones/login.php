<?php
session_start(); // Mantener la sesión activa

$acceso = "";
$mensaje = "";

// Manejo de peticiones web
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $user = $_POST['usuario'];
    $contra = $_POST['contraseña'];

    include_once("../conexion/conexion.php");

    // Consulta para obtener la contraseña encriptada del usuario
    $sentencia = "SELECT email, contrasena, privilegio, estatus FROM usuarios WHERE email='$user' AND estatus=1";
    $ejecutar = mysqli_query($conn, $sentencia);

    if (mysqli_num_rows($ejecutar)) {
        if ($fila = mysqli_fetch_assoc($ejecutar)) {
            // Verificar la contraseña ingresada contra la encriptada
            if (password_verify($contra, $fila['contrasena'])) {
                $privilegio = $fila['privilegio'];
    
                $_SESSION['usuario'] = $user;
                $_SESSION['privilegio'] = $privilegio;
    
                if ($privilegio === "secretaria") {
                    // Redirigir a la ruta específica para "secretaria"
                    header("Location: ../empleados/tabla3.php");
                } else {
                    // Redirigir a la ruta de inicio por defecto
                    header("Location: ../pagina/inicio.php");
                }
                exit();

                //privilegio de cordinadora
                if ($privilegio === "cordinadora") {
                    // Redirigir a la ruta específica para "cordinadora"
                    header("Location: ../planeaciones/ver_planeacion.php");
                } else {
                    // Redirigir a la ruta de inicio por defecto
                    header("Location: ../pagina/inicio.php");
                }
                exit();
            } else {
                $mensaje = "Contraseña incorrecta.";
            }
        }
    } else {
        $mensaje = "Usuario y/o contraseña incorrectos, Verifique sus credenciales.";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="general-body">
    <div class="container" id="login-container">
        <div class="logo-container" style="text-align: center; margin-bottom: 1rem;">
        <img src="../img/logo_esc_sec_4.png" alt="Logo Escuela" class="logo" style="max-width: 150px; height: auto;">
        </div>
        <h1 class="title" id="main-title">Escuela Secundaria General #4 "José Vasconcelos"</h1>
        <h2 class="title" id="main-title">Sistema Gestor de Constancias y Planeaciones</h2>
        <form method="post" class="form" id="login-form">
            <p class="form-group">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="form-input" required>
            </p>
            <p class="form-group">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <div class="input-wrapper">
                    <input type="password" id="contraseña" name="contraseña" class="form-input" required>
                    <button type="button" id="toggle-password" class="toggle-password">
                        <span id="password-icon">👁️</span> <!-- Ícono de ojo abierto -->
                    </button>
                </div>
            </p>
            <input type="submit" value="Iniciar" class="form-button" id="submit-button">
        </form>
        <h2 class="error-message" id="error-message">
            <?php
                echo $mensaje ?? '';
            ?>
        </h2>
    </div>

    <!-- Script para mostrar/ocultar contraseña -->
    <script>
        const passwordInput = document.getElementById('contraseña');
        const togglePasswordButton = document.getElementById('toggle-password');
        const passwordIcon = document.getElementById('password-icon');

        togglePasswordButton.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.textContent = '👁️'; // Cambia al ícono de ojo cerrado
            } else {
                passwordInput.type = 'password';
                passwordIcon.textContent = '🔒'; // Cambia al ícono de ojo abierto
            }
        });
    </script>
</body>
</html>








