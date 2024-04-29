<?php
session_start();

// Acceder a los datos de la sesión
$idUsuario = $_SESSION['idUsuario'];
$correo = $_SESSION['correo'];

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idUsuario'])) {
    // Si el usuario no ha iniciado sesión, puedes redirigirlo a la página de inicio de sesión o mostrar un mensaje de error.
    header("Location: ../public/login.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include_once('../config/database.php');

// Obtener los datos enviados desde el formulario de edición
$idPublicacion = $_POST['idPublicacion'];
$tipoPublicacion = $_POST['tipo_publicacion'];
$descripcion = $_POST['descripcion'];
$habilidades = implode(', ', $_POST['habilidades']); // Convertir las habilidades seleccionadas en una cadena
$edadRecomendada = $_POST['edad_recomendada'];

$nuevaImagen = $_FILES['imagenProducto']['tmp_name'];
$tipoNuevaImagen = $_FILES['imagenProducto']['type'];

if (!empty($nuevaImagen) && is_uploaded_file($nuevaImagen) && strpos($tipoNuevaImagen, 'image/') === 0) {
    // Leer la nueva imagen en formato Base64
    $imagenBase64 = base64_encode(file_get_contents($nuevaImagen));
} else {
    // Si no se ha seleccionado una nueva imagen, mantener la imagen existente sin cambios
    $imagenBase64 = $imagen; // $imagen contiene la imagen actual de la publicación
}


// Consulta SQL para actualizar la publicación
$sql = "UPDATE publicaciones SET tipoPublicacion = ?, imagenProducto = ?, descripcion = ?, habilidadRequerida = ?, edadRecomendada = ? WHERE idPublicacion = ? AND usuarioId = ?";

// Preparar la consulta
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

// Vincular parámetros y ejecutar la consulta
$stmt->bind_param("ssssiii", $tipoPublicacion, $imagenBase64, $descripcion, $habilidades, $edadRecomendada, $idPublicacion, $idUsuario);
if ($stmt->execute()) {
    // Actualización exitosa, redirigir a historial.php
    header("Location: historial.php");
    exit();
} else {
    // Error al actualizar la publicación
    die("Error al actualizar la publicación: " . $stmt->error);
}

// Cerrar la declaración
$stmt->close();
$conn->close();
?>