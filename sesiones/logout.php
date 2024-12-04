<?php
session_start();
session_destroy(); 
header("Location: ../sesiones/login.php"); 
exit();
?>