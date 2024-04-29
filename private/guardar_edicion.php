<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idUsuario'])) {
    // Si el usuario no ha iniciado sesión, puedes redirigirlo a la página de inicio de sesión o mostrar un mensaje de error.
    header("Location: ../public/login.php");
    exit();
}

// Verificar si se han enviado datos del formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $idPublicacion = $_POST['idPublicacion'];
    $tipoPublicacion = $_POST['tipoPublicacion'];
    $descripcion = $_POST['descripcion'];
    $habilidadRequerida = $_POST['habilidadRequerida'];
    $edadRecomendada = $_POST['edadRecomendada'];
    // Puedes obtener más campos según sea necesario

    // Validar y procesar los datos antes de actualizar la publicación en la base de datos
    // ...

    // Incluir el archivo de conexión a la base de datos
    include_once('../config/database.php');

    // Realizar una consulta SQL para actualizar la publicación
    $sql = "UPDATE publicaciones SET tipoPublicacion = ?, descripcion = ?, habilidadRequerida = ?, edadRecomendada = ? WHERE idPublicacion = ?";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $tipoPublicacion, $descripcion, $habilidadRequerida, $edadRecomendada, $idPublicacion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // La publicación se actualizó con éxito
        header("Location: historial.php"); // Redirige a la página de historial después de la edición
        exit();
    } else {
        // Hubo un error al actualizar la publicación
        echo "Error al actualizar la publicación: " . $stmt->error;
    }

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {
    // Si los datos del formulario no se enviaron correctamente, redirige o muestra un mensaje de error
    echo "Los datos del formulario no se enviaron correctamente.";
}
?>