<?php
// Configuración de la conexión
$servername = "localhost";  
$username = "root";         
$password = "123";
$dbname = "secundaria4";       

// Crear la conexión con MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
// if ($conn->connect_error) {
//     echo "Conexión fallida: " . $conn->connect_error;
// } else {
//     echo "Conexión exitosa a la base de datos '$dbname'";
// }

?>