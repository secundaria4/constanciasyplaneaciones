<?php
session_start();
include_once("../conexion/conexion.php"); // Asegúrate de que la conexión a la base de datos funcione

if (isset($_GET['id_planeacion'])) {
    $id_planeacion = intval($_GET['id_planeacion']); // Asegura que sea un número entero válido
    $aprobado_por = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Desconocido'; // Captura al usuario de la sesión

    // Consulta para actualizar las columnas "aprobacion" y "aprobado_por"
    $query = "UPDATE planeaciones SET aprobacion = 'Si', aprobado_por = ? WHERE id_planeacion = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("si", $aprobado_por, $id_planeacion);

        if ($stmt->execute()) {
            // Mensaje de éxito
            $mensaje = "Planeación aprobada con éxito.";
            $tipo = "success";
        } else {
            // Mensaje de error durante la ejecución
            $mensaje = "Error al aprobar la planeación: " . addslashes($stmt->error);
            $tipo = "error";
        }

        $stmt->close();
    } else {
        // Mensaje de error en la preparación de la consulta
        $mensaje = "Error en la preparación de la consulta: " . addslashes($conn->error);
        $tipo = "error";
    }
} else {
    // Mensaje si no se proporcionó un ID válido
    $mensaje = "No se proporcionó un ID de planeación válido.";
    $tipo = "warning";
}

// Cerrar la conexión a la base de datos
$conn->close();

// Mostrar el mensaje utilizando SweetAlert para confirmación de aprobación
echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Aprobar Planeación</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
</head>
<body>
    <script>
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas aprobar esta planeación?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, aprobar planeación',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: '$tipo',
                    title: '$mensaje',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = 'aprobar_planeacion.php'; // Redirige después de aprobar
                });
            } else {
                window.location.href = 'aprobar_planeacion.php'; // Redirige si cancela
            }
        });
    </script>
</body>
</html>";
?>
