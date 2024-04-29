<?php
// Incluir el archivo de conexión a la base de datos
include_once('../config/database.php');

if (isset($_GET['id'])) {
    $publicacionID = $_GET['id'];

    // Realiza la consulta SQL para eliminar la publicación
    $sqlEliminarPublicacion = "DELETE FROM publicaciones WHERE idPublicacion = $publicacionID";
    if ($conn->query($sqlEliminarPublicacion) === TRUE) {
        // Redirige de vuelta a la página anterior
        header('Location: historial.php');
        exit;
    } else {
        // Error al eliminar la publicación
        echo 'Error al eliminar la publicación';
    }
}
?>