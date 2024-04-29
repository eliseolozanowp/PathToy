<?php
session_start();

if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../public/login.php");
    exit();
}

include_once('../../config/database.php');

$idUsuario = $_SESSION['idUsuario'];

$tipoPublicacion = $_POST['tipo_publicacion'];
$descripcion = $_POST['descripcion'];
$habilidades = implode(', ', $_POST['habilidades']);
$edadRecomendada = $_POST['edad_recomendada'];

$imagenProducto = $_FILES['imagenProducto']['tmp_name'];
$tipoImagen = $_FILES['imagenProducto']['type'];

if (!empty($imagenProducto) && is_uploaded_file($imagenProducto) && strpos($tipoImagen, 'image/') === 0) {
    $imagenBase64 = base64_encode(file_get_contents($imagenProducto));
} else {
    // Manejo de errores en caso de que no se seleccione una imagen válida
    $imagenBase64 = ''; // Puedes asignar un valor por defecto vacío o mostrar un mensaje de error.
}

$sql = "INSERT INTO publicaciones (tipoPublicacion, imagenProducto, descripcion, habilidadRequerida, edadRecomendada, usuarioId) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("sssssi", $tipoPublicacion, $imagenBase64, $descripcion, $habilidades, $edadRecomendada, $idUsuario);
if ($stmt->execute()) {
    // Registro de publicación exitoso, redirigir a feed.php
    header("Location: ../feed.php");
    exit();
} else {
    // Manejo de errores en caso de que la inserción falle
    die("Error al insertar la publicación: " . $stmt->error);
}

$stmt->close();
?>