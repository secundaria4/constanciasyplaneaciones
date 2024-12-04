<?php
    $empleadoId = $_GET['id'];

    // Incluir archivo de conexión
    include 'conexion.php';

    // Obtener los datos del empleado
    $sql = "SELECT titulo, nombres, apellido_p, apellido_m, turno, horario_entrada, horario_salida, puesto, id_empleado, RFC, fecha_contrato, calle, numero, col_fracc, telefono_movil, email FROM empleados WHERE id_empleado = $empleadoId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }

    $conn->close();
?>



