<?php
    // Incluir archivo de conexión
    include 'conexion.php';

    // Detectar el sistema operativo
    $is_windows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

    // Establecer la ruta del ejecutable de Python
    if ($is_windows) {
        $python_path = "python"; // En Windows, generalmente se usa 'python'
    } else {
        $python_path = __DIR__ . "/run_python.sh";
        if (!file_exists($python_path)) {
            die("Error: No se encontró el entorno virtual en " . $python_path);
        }
    }

    // Obtener los datos del formulario
    $tipo_constancia = $_POST['tipo_constancia'];
    $empleado_datos = json_decode($_POST['empleado_datos'], true);
    $director_datos = json_decode($_POST['director_datos'], true);

    // Preparar los datos para el script de Python
    $datos_json = json_encode(array(
        'tipo_constancia' => $tipo_constancia,
        'empleado' => $empleado_datos,
        'director' => $director_datos
    ), JSON_UNESCAPED_UNICODE);

    // Si es Windows, manejar el escapado de comillas
    if ($is_windows) {
        $datos = '"' . addcslashes($datos_json, '\\"') . '"';
    } else {
        $datos = escapeshellarg($datos_json);
    }

    // Ruta del script de Python
    $script_path = __DIR__ . DIRECTORY_SEPARATOR . 'script-python.py';

    // Ejecutar el script de Python y capturar la salida
    $command = "$python_path $script_path $datos";
    $output = shell_exec("$command 2>&1"); // Captura tanto stdout como stderr

    // Depuración (comentar para producción)
    echo "<pre>";
    echo "Comando ejecutado: $command\n";
    echo "Datos JSON: $datos_json\n";
    echo "Datos Escapados: $datos\n";
    echo "Salida:\n$output";
    echo "</pre>";

    // Determinar la ruta de guardado según el sistema operativo
    if ($is_windows) {
        $filename = __DIR__ . DIRECTORY_SEPARATOR . 'constancia_generada.docx';
    } else {
        $filename = '/tmp/constancia_generada.docx';
    }

    // Verificar si el archivo se creó y darlo para la descarga
    if (file_exists($filename)) {
        header('Content-Description: File Transfer');
	header('Content-Type: text/html; charset=utf-8');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="'.basename($filename).'"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        ob_clean();
        flush();
        readfile($filename);

        // Eliminar el archivo después de la descarga
        unlink($filename);
        exit;
    } else {
        echo "Error: el archivo no se ha podido generar. Detalles:\n$output";
    }
?>