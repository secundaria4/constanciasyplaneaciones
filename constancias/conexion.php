<?php
//Configuración de la conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "secundaria4";

//Crear la conexión MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión 
if ($conn->connect_error) { 
    die("Conexión fallida: " . $conn->connect_error);
}
?>
