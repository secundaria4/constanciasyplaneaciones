<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>Eliminar Planeación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <?php 
    include_once("../conexion/conexion.php");

    // Convertir id_planeacion a un número entero
    $id_planeacion = intval($_GET['id_planeacion']);

    // 1. Consulta para obtener el nombre del archivo
    $consulta_archivo = "SELECT nom_arch FROM planeaciones WHERE id_planeacion = ?";
    $stmt = $conn->prepare($consulta_archivo);
    $stmt->bind_param("i", $id_planeacion);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_archivo = $row['nom_arch'];

        // Ruta completa del archivo
        $ruta_archivo = "files/" . $nombre_archivo;

        // Intentar borrar el archivo físico
        if (file_exists($ruta_archivo)) {
            if (unlink($ruta_archivo)) {
                // Archivo eliminado correctamente
                $mensaje = "Archivo eliminado correctamente.";
            } else {
                $mensaje = "Error al intentar eliminar el archivo físico.";
            }
        } else {
            $mensaje = "El archivo no existe en la carpeta.";
        }

        // 2. Eliminar el registro de la base de datos
        $consulta_delete = "DELETE FROM planeaciones WHERE id_planeacion = ?";
        $stmt_delete = $conn->prepare($consulta_delete);
        $stmt_delete->bind_param("i", $id_planeacion);

        if ($stmt_delete->execute()) {
            $mensaje = isset($mensaje) ? $mensaje : "Registro eliminado correctamente de la base de datos.";
            $tipo = 'success';
        } else {
            $mensaje = "Error al eliminar el registro de la base de datos.";
            $tipo = 'error';
        }
    } else {
        $mensaje = "No se encontró el registro solicitado en la base de datos.";
        $tipo = 'warning';
    }

    // Redirigir a la página principal con mensaje
    echo "<script>
        Swal.fire({
            icon: '$tipo',
            title: '$mensaje',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href='ver_planeacion.php';
            }
        });
    </script>";
    ?>
</body>
</html>