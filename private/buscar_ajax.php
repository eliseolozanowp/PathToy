<?php
// Incluir el archivo de conexión a la base de datos
include_once('../config/database.php');

// Obtener los valores del formulario AJAX
$q = isset($_GET['q']) ? $_GET['q'] : '';
$tipo_publicacion = isset($_GET['tipoPublicacion']) ? $_GET['tipoPublicacion'] : '';
$edad = isset($_GET['edadRecomendada']) ? $_GET['edadRecomendada'] : '';
$habilidad = isset($_GET['habilidadRequerida']) ? $_GET['habilidadRequerida'] : '';

// Construir la consulta SQL basada en los parámetros de búsqueda
$sql = "SELECT idPublicacion, tipoPublicacion, descripcion, habilidadRequerida, edadRecomendada, fechaRegistro, usuarioId FROM publicaciones WHERE descripcion LIKE '%$q%'";

if (!empty($tipo_publicacion)) {
    $sql .= " AND tipo_publicacion = '$tipo_publicacion'";
}

if (!empty($edad)) {
    $sql .= " AND edad = '$edad'";
}

if (!empty($habilidad)) {
    $sql .= " AND habilidad LIKE '%$habilidad%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Mostrar las tarjetas de productos
        echo '<div class="card">';
        echo '<div class="card-image">';
        // Muestra la imagen si tienes una imagen en formato base64
        // echo '<img src="data:image/jpeg;base64,' . $row['imagen_producto'] . '" alt="Imagen del producto">';
        echo '</div>';
        echo '<div class="card-content">';
        echo '<h2>' . $row['tipoPublicacion'] . '</h2>';
        echo '<p>Descripción: ' . $row['descripcion'] . '</p>';
        echo '<p>Edad recomendada: ' . $row['edadRecomendada'] . '</p>';
        $habilidad = explode(",", $row["habilidadRequerida"]);
        echo '';
        foreach ($habilidad as $habilidad) {
            echo $habilidad . " ";
        }
        echo '<div class="card-botones">';
        // Agregar enlace "Ver" con el ID de la publicación
        echo '<a class="btn-ver" href="publicacion.php?id=' . $row['idPublicacion'] . '">Ver más</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p class="text-center">No se encontraron publicaciones.</p>';
}

$conn->close();
?>