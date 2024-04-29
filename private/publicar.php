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

<body class="body-publish">

    <!-- Contenido del formulario de publicación -->
    <form action="validaciones/validar_publicacion.php" method="POST" enctype="multipart/form-data">
        <div id="TituloPublicacion">
            <h1>Tipo de Publicación</h1>
        </div>
        <select id="tipo_publicacion" name="tipo_publicacion" required>
            <option value="Intercambio">Intercambio</option>
            <option value="Donación">Donación</option>
            <option value="Petición">Petición</option>
        </select>
        <div id="ImagenP">
            <h1>Imagen del juguete</h1>
            <div id="cuadroImagen">
                <input type="file" id="imagenProducto" name="imagenProducto" accept="image/*">
                <label for="imagenProducto" id="labelImagen">
                    <i class="fas fa-image" id="iconoImagen"></i>
                </label>
            </div>
        </div>
        <div id="descripcionProducto">
            <h2>Agregar descripción del juguete</h2>
            <textarea id="descripcion" name="descripcion" placeholder="Ingrese una descripción" rows="6"
                required></textarea>
        </div>
        <div class="container-publish">
            <div id="TituloPublicacion">
                <h1>Habilidad(es) requerida(s)</h1>
            </div>
            <div class="option">
                <input type="checkbox" id="motoras" name="habilidades[]" value="Motoras">
                <label for="motoras">Motoras</label>
            </div>

            <div class="option">
                <input type="checkbox" id="cognitivas" name="habilidades[]" value="Cognitivas">
                <label for="cognitivas">Cognitivas</label><br>
            </div>
            <div class="option">
                <input type="checkbox" id="linguisticas" name="habilidades[]" value="Linguisticas">
                <label for="linguisticas">Linguísticas</label><br>
            </div>
        </div><br>
        <div id="PublicoDes">
            <h1>Edad para el público destinatario</h1>
            <div id="labelEdad">
                <h1>
                    <input type="number" id="edad_recomendada" name="edad_recomendada" min="0" max="100" required>
                </h1>
            </div>
        </div>
        <button type="submit" id="realizarButton" class="btn btn-primary">Publicar</button>
    </form>
</body>

<?php include_once '../views/footer.php'; ?>