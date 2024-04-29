<?php
// Datos de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_webexample";

// Intentar establecer la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Configurar la codificación de caracteres a UTF-8 (opcional, pero recomendado)
$conn->set_charset("utf8");
?>