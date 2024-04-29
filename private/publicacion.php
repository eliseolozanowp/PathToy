<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idUsuario'])) {
    // Si el usuario no ha iniciado sesión, puedes redirigirlo a la página de inicio de sesión o mostrar un mensaje de error.
    header("Location: ../public/login.php");
    exit();
}

// Obtener el ID de la publicación desde la URL
if (isset($_GET['id'])) {
    $idPublicacion = $_GET['id'];
} else {
    // Si no se proporcionó un ID de publicación válido, redirige a alguna página de error
    header("Location: error.php");
    exit();
}
// Obtener el ID del usuario actual
$idUsuarioActual = $_SESSION['idUsuario'];

// Incluir el archivo de conexión a la base de datos
include_once('../config/database.php');

// Realizar una consulta SQL para obtener los detalles de la publicación por su ID
$sql = "SELECT p.*, u.nombre, u.apellido FROM publicaciones p
        INNER JOIN usuarios u ON p.usuarioId = u.idUsuario
        WHERE p.idPublicacion = ?";

// Preparar la consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idPublicacion);
$stmt->execute();

// Obtener los resultados de la consulta
$resultado = $stmt->get_result();

// Verificar si se obtuvieron resultados
if ($resultado->num_rows > 0) {
    // Mostrar los detalles de la publicación y el nombre y apellido de quien la publicó
    $fila = $resultado->fetch_assoc();
    $tipoPublicacion = $fila['tipoPublicacion'];
    $imagen = $fila['imagenProducto'];
    $descripcion = $fila['descripcion'];
    $habilidad = $fila['habilidadRequerida'];
    $edad = $fila['edadRecomendada'];
    $nombreUsuario = $fila['nombre'];
    $apellidoUsuario = $fila['apellido'];
    $usuarioId = $fila['usuarioId']; // Obtener el ID del usuario que publicó la entrada

    // Muestra los detalles de la publicación
    echo '<div class="container">';
    echo '<div class="card-details">';
    echo '<div class="card-image">';
    echo '<img src="data:image/jpeg;base64,' . $fila['imagenProducto'] . '" alt="Imagen del producto">';
    echo '</div>';
    echo '<div class="card-data">';
    echo '<h1><center>' . $fila['tipoPublicacion'] . '</center></h1>';
    echo '<p><center><b>Descripción:</b></center>' . $fila['descripcion'] . '</p>';
    $habilidad = explode(",", $fila["habilidadRequerida"]);
    echo '<p><center><b>Habilidad(es) requerida(s):</b></center><br> ' . implode(", ", $habilidad) . '</p>';
    echo '<p><center><b>Edad recomendada:</b></center>' . $fila['edadRecomendada'] . '</p>';
    echo '<br>';
    echo '<br>';
    echo '<p>Publicado por: <b>' . $nombreUsuario . $apellidoUsuario . '</b> </p>';
    // Verifica si la publicación es del usuario actual
    if ($idUsuarioActual !== $usuarioId) {
        // Si no es la publicación del usuario actual, muestra el botón "Chatear" con los parámetros requeridos
        echo '<a href="chat.php?user_id=' . $fila['usuarioId'] . '" class="btn-chatear">Chatear</a>';
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
} else {
    // Si no se encontró la publicación, muestra un mensaje de error o redirige a alguna página de error
    echo '<p class="error-message">La publicación no se encuentra disponible.</p>';
    exit();
}

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();
?>

<?php include_once '../views/head.php'; ?>

<head>
    <link rel="stylesheet" href="/webexample/assets/css/publicacion.css">
</head>

<!-- Contenedor para la opción "Volver atrás" -->
<div class="back-container">
    <a href="feed.php" class="btn-back">Volver atrás</a>
</div><br>

<?php include_once '../views/footer.php'; ?>