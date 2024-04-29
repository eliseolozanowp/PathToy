<?php
session_start();

// Incluir el archivo de conexión a la base de datos
include_once('../config/database.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idUsuario'])) {
    // Si el usuario no ha iniciado sesión, puedes redirigirlo a la página de inicio de sesión o mostrar un mensaje de error.
    header("Location: ../public/login.php");
    exit();
}

// Obtener el ID del usuario actual de la sesión
$idUsuario = $_SESSION['idUsuario'];

// Incluir lógica para cargar los datos del usuario actual
// Puedes obtener los datos del usuario actual desde la base de datos aquí
$sql = "SELECT nombre, apellido, correo FROM usuarios WHERE idUsuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    // Obtener los datos del usuario
    $datosUsuario = $resultado->fetch_assoc();
    $nombre = $datosUsuario['nombre'];
    $apellido = $datosUsuario['apellido'];
    $correo = $datosUsuario['correo'];
} else {
    // Manejar el caso en que no se encuentren datos del usuario
    // Esto puede incluir una redirección o mostrar un mensaje de error
}

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();
?>

<!-- Agrega un formulario para editar el perfil del usuario -->
<h2>Editar Perfil</h2>
<form action="guardar_edicion_perfil.php" method="POST">
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
    </div>
    <div class="form-group">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>">
    </div>
    <div class="form-group">
        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" value="<?php echo $correo; ?>">
    </div>
    <!-- Agrega más campos de acuerdo a tu formulario -->
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
</form>