<?php
if (isset($_GET['id'])) {
    $publicacionID = $_GET['id'];
    echo '<script>
            var confirmar = confirm("¿Estás seguro de eliminar esta publicación?");
            if (confirmar) {
                // Redirige a un archivo PHP para eliminar la publicación de la base de datos
                window.location.href = "eliminar_publicacion_confirmar.php?id=' . $publicacionID . '";
            } else {
                // Redirige de vuelta a la página anterior
                window.history.back();
            }
          </script>';
}
?>