<?php
    $directorId = $_GET['id'];

    // Incluir archivo de conexión
    include 'conexion.php';

    // Obtener los datos del director
    $sql = "SELECT titulo, nombres, apellido_p, apellido_m FROM empleados WHERE id_empleado = $directorId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }

    $conn->close();
?>

