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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores enviados desde el formulario
    $idPublicacion = isset($_POST['idPublicacion']) ? $_POST['idPublicacion'] : '';
    $tipoPublicacion = isset($_POST['tipo_publicacion']) ? $_POST['tipo_publicacion'] : '';
    $descripcion = $_POST['descripcion'];
    $habilidades = isset($_POST['habilidades']) && is_array($_POST['habilidades']) ? implode(",", $_POST['habilidades']) : '';
    $edadRecomendada = $_POST['edad_recomendada'];

    // Manejar la actualización de la imagen (si se proporcionó una nueva imagen)
    if ($_FILES['imagenProducto']['tmp_name']) {
        $nuevaImagen = $_FILES['imagenProducto']['tmp_name'];
        $tipoNuevaImagen = $_FILES['imagenProducto']['type'];

        if (!empty($nuevaImagen) && is_uploaded_file($nuevaImagen) && strpos($tipoNuevaImagen, 'image/') === 0) {
            // Leer la nueva imagen en formato Base64
            $imagenBase64 = base64_encode(file_get_contents($nuevaImagen));

            // Actualizar la imagen en la base de datos
            $sqlImagen = "UPDATE publicaciones SET imagenProducto = ? WHERE idPublicacion = ?";
            $stmtImagen = $conn->prepare($sqlImagen);
            $stmtImagen->bind_param("si", $imagenBase64, $idPublicacion);
            $stmtImagen->execute();
        }
    }

    // Actualizar otros campos de la publicación en la base de datos
    $sql = "UPDATE publicaciones SET tipoPublicacion = ?, descripcion = ?, habilidadRequerida = ?, edadRecomendada = ? WHERE idPublicacion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $tipoPublicacion, $descripcion, $habilidades, $edadRecomendada, $idPublicacion);

    if ($stmt->execute()) {
        // Redirige al usuario al historial u otra página con un mensaje de éxito
        header('Location: historial.php?mensaje=Publicación%20actualizada%20con%20éxito');
        exit();
    } else {
        // Maneja el error en caso de fallo en la actualización
        die("Error al actualizar la publicación en la base de datos");
    }
}

// Consulta SQL para obtener los datos de la publicación a editar
if (isset($_GET['id'])) {
    $idPublicacion = $_GET['id'];

    $sqlPublicacion = "SELECT * FROM publicaciones WHERE idPublicacion = ?";
    $stmtPublicacion = $conn->prepare($sqlPublicacion);
    $stmtPublicacion->bind_param("i", $idPublicacion);
    $stmtPublicacion->execute();
    $resultPublicacion = $stmtPublicacion->get_result();

    if ($resultPublicacion->num_rows > 0) {
        $row = $resultPublicacion->fetch_assoc();
        $tipoPublicacion = $row["tipoPublicacion"];
        $descripcion = $row["descripcion"];
        $habilidades = $row["habilidadRequerida"]; // Convertir habilidades en un arreglo
        $edadRecomendada = $row["edadRecomendada"];
        $imagen = $row["imagenProducto"];
    } else {
        echo "La publicación seleccionada no existe.";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
<?php include_once '../views/head.php'; ?>

<!-- Aquí puedes crear el formulario de edición similar al de publicación -->
<!-- Llena los campos del formulario con los datos de la publicación -->

<body class="body-publish">

    <form action="" method="POST" enctype="multipart/form-data">
        <div id="TituloPublicacion">
            <h1>Editar Publicación</h1>
        </div>
        <input type="hidden" name="idPublicacion" value="<?php echo $idPublicacion; ?>">
        <!-- Agregar un campo oculto para enviar el ID de la publicación a actualizar -->

        <div id="TituloPublicacion">
            <h1>Tipo de Publicación</h1>
        </div>
        <select id="tipo_publicacion" name="tipo_publicacion" required>
            <option value="Intercambio" <?php if ($tipoPublicacion === 'Intercambio')
                echo 'selected'; ?>>Intercambio
            </option>
            <option value="Donación" <?php if ($tipoPublicacion === 'Donación')
                echo 'selected'; ?>>Donación</option>
            <option value="Petición" <?php if ($tipoPublicacion === 'Petición')
                echo 'selected'; ?>>Petición</option>
        </select>

        <!-- Vista previa de la imagen actual -->
        <div id="ImagenP">
            <h1>Imagen del juguete</h1>
            <div id="cuadroImagen">
                <input type="file" id="imagenProducto" name="imagenProducto" accept="image/*">
                <label for="imagenProducto" id="labelImagen">
                    <img id="vistaPrevia" src="data:image/jpeg;base64,<?php echo $imagen; ?>"
                        alt="Imagen actual del juguete">
                </label>
            </div>
        </div>

        <div id="descripcionProducto">
            <h2>Agregar descripción del juguete</h2>
            <textarea id="descripcion" name="descripcion" placeholder="Ingrese una descripción" rows="6"
                required><?php echo $descripcion; ?></textarea>
        </div>
        <div class="container-publish">
            <div id="TituloPublicacion">
                <h1>Habilidad(es) requerida(s)</h1>
            </div>
            <div class="option">
                <input type="checkbox" id="motoras" name="habilidades[]" value="Motoras" <?php if (strpos($habilidades, 'Motoras') !== false)
                    echo 'checked'; ?>>
                <label for="motoras">Motoras</label>
            </div>

            <div class="option">
                <input type="checkbox" id="cognitivas" name="habilidades[]" value="Cognitivas" <?php if (strpos($habilidades, 'Cognitivas') !== false)
                    echo 'checked'; ?>>
                <label for="cognitivas">Cognitivas</label><br>
            </div>
            <div class="option">
                <input type="checkbox" id="linguisticas" name="habilidades[]" value="Linguisticas" <?php if (strpos($habilidades, 'Linguisticas') !== false)
                    echo 'checked'; ?>>
                <label for="linguisticas">Linguísticas</label><br>
            </div>
        </div><br>
        <div id="PublicoDes">
            <h1>Edad para el público destinatario</h1>
            <div id="labelEdad">
                <h1>
                    <input type="number" id="edad_recomendada" name="edad_recomendada" min="0" max="100" required
                        value="<?php echo $edadRecomendada; ?>">
                </h1>
            </div>
        </div>
        <button type="submit" id="realizarButton" class="btn btn-primary">Actualizar</button>
    </form>

    <script>
        // Función para mostrar la vista previa de la imagen cuando se selecciona una nueva imagen
        function mostrarVistaPrevia() {
            var archivoInput = document.getElementById('imagenProducto');
            var vistaPrevia = document.getElementById('vistaPrevia');

            // Verificar si se seleccionó un archivo
            if (archivoInput.files && archivoInput.files[0]) {
                var lector = new FileReader();

                lector.onload = function (e) {
                    vistaPrevia.src = e.target.result;
                };

                lector.readAsDataURL(archivoInput.files[0]);
            }
        }

        // Asociar la función a un evento de cambio del campo de carga de archivos
        var archivoInput = document.getElementById('imagenProducto');
        archivoInput.addEventListener('change', mostrarVistaPrevia);
    </script>
</body>
<!-- Puedes agregar estilos personalizados para el formulario de edición -->
<?php include_once '../views/footer.php'; ?>