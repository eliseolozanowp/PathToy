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
?>

<?php include_once '../views/head.php'; ?>

<head>
    <style>
        .card-image img {
            width: 200px;
            /* Ancho deseado */
            height: 250px;
            /* Altura automática para mantener la proporción */
        }
    </style>
    <link rel="stylesheet" href="/webexample/assets/css/panel.css">
</head>

<h1 class="text-center mt-4">Publicaciones</h1>

<?php
// Incluir el archivo de conexión a la base de datos
include_once('../config/database.php');

$current_time = date("Y-m-d H:i:s");
$twenty_four_hours_ago = date("Y-m-d H:i:s", strtotime('-24 hours', strtotime($current_time)));

// Realizar una consulta SQL para obtener todas las publicaciones (reemplaza 'tabla_publicaciones' por el nombre de tu tabla)
$sql = "SELECT * FROM publicaciones WHERE fechaRegistro >= '$twenty_four_hours_ago' ORDER BY fechaRegistro DESC"; // Puedes ajustar el orden según tus necesidades

// Ejecutar la consulta
$resultado = $conn->query($sql);

// Verificar si se obtuvieron resultados
if ($resultado->num_rows > 0) {
    echo '<div class="card-container">';
    // Mostrar las publicaciones
    while ($fila = $resultado->fetch_assoc()) {
        $fechaRegistro = $fila['fechaRegistro'];
        $fecha = date_create($fechaRegistro);
        $meses = array(
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        );
        $mes = $meses[(date_format($fecha, 'n') - 1)];
        $hora = date_format($fecha, 'H');
        $minuto = date_format($fecha, 'i');
        $fechaFormateada = date_format($fecha, 'd') . " de " . $mes . " - " . date_format($fecha, 'Y');
        $horaFormateada = $hora . ":" . $minuto;
        // Agrega las clases a las tarjetas de publicaciones
        echo '<div class="card">';
        echo '<p style="text-align: right;">' . $fechaFormateada . /*' <br> ' . $horaFormateada .*/'</p>';
        echo '<div class="card-image">';
        echo '<img src="data:image/jpeg;base64,' . $fila['imagenProducto'] . '" alt="Imagen del producto">';
        echo '</div>';
        echo '<div class="card-content">';
        echo '<h3 class="campo-editable">' . $fila['tipoPublicacion'] . '</h3>';
        echo '<p> <span class="campo-editable">' . $fila['descripcion'] . '</span></p>';
        echo '</div>';

        echo '<div class="card-botones">';
        // Agregar enlace "Ver" con el ID de la publicación
        echo '<a class="btn-ver" href="publicacion.php?id=' . $fila['idPublicacion'] . '">Ver más</a>';
        echo '</div>';
        echo '</div>';
        echo "<br>";
    }
} else {
    // Si no hay publicaciones, muestra el mensaje
    echo '<p class="no-publications-message">No hay publicaciones disponibles.</p>';
}
echo '</div>';


// Cerrar la conexión a la base de datos
$conn->close();
?>

<?php include_once '../views/footer.php'; ?>