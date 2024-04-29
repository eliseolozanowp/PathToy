<?php
// Incluir el archivo de conexión a la base de datos
include_once('../config/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados por el formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];

    // ID del usuario que se está editando (puedes obtenerlo de la sesión o de otra manera)
    $idUsuario = $_SESSION["idUsuario"];

    // Preparar una consulta SQL para actualizar los datos del usuario
    $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, correo = ? WHERE idUsuario = ?";

    // Preparar la declaración SQL
    $stmt = $conn->prepare($sql);

    // Vincular los parámetros
    $stmt->bind_param("sssi", $nombre, $apellido, $correo, $idUsuario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // La actualización se realizó con éxito
        // Redirigir de regreso a la página de perfil después de la actualización
        header("Location: perfil.php");
        exit();
    } else {
        // Ocurrió un error al actualizar los datos
        echo "Error al actualizar los datos del usuario: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión a la base de datos
    $stmt->close();
    $conn->close();
}
?>