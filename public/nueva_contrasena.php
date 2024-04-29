<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['idUsuario'])) {
    // Si el usuario ha iniciado sesión, redirigirlo a la página de feed
    header("Location: /webexample/private/feed.php");
    exit();
}
require_once('../views/head.php');
require_once('../config/database.php');

// Variable para almacenar mensajes de error
$mensajeError = "";
$mensajeExito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevaContrasena = $_POST["nueva_contrasena"];
    $repetirContrasena = $_POST["repetir_contrasena"];

    // Verificar si los campos de contraseña están vacíos
    if (empty($nuevaContrasena) || empty($repetirContrasena)) {
        $mensajeError = "Rellena todos los campos para continuar.";
    } elseif (strlen($nuevaContrasena) < 8) {
        // Verificar si la contraseña tiene menos de 8 caracteres
        $mensajeError = "La contraseña debe tener al menos 8 caracteres.";
    } elseif ($nuevaContrasena !== $repetirContrasena) {
        // Verificar si las contraseñas no coinciden
        $mensajeError = "Las contraseñas no coinciden.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $nuevaContrasena)) {
        // Verificar si la contraseña no contiene una mezcla de mayúsculas, minúsculas y números
        $mensajeError = "La contraseña debe contener mezcla de mayúsculas, minúsculas y números.";
    } else {
        // Hash de la contraseña
        $hashContrasena = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos (reemplaza 'tu_query_actualizacion' por la consulta SQL real)
        $correo = $_GET["correo"]; // Obtiene el correo desde el parámetro en la URL

        // Ejemplo de consulta de actualización (debes personalizar esto según tu esquema de base de datos)
        $query = "UPDATE usuarios SET contrasena = '$hashContrasena' WHERE correo = '$correo'";

        if ($conn->query($query) === TRUE) {
            // Contraseña actualizada con éxito
            $mensajeExito = "La contraseña se ha actualizado.";
        } else {
            // Error al actualizar la contraseña
            $mensajeError = "Error al actualizar la contraseña: " . $conn->error;
        }
    }
}
?>

<div class="fondo-login">
    <div class="titulo">
        Nueva Contraseña
    </div>

    <form action="" method="POST" class="col-8 col-md-3  login">
        <div class="md-3">
            <label for="nueva_contrasena" class="form-label">Nueva Contraseña</label>
            <div class="box-eye">
                <button type="button" onclick="mostrarcontraseña('nueva_contrasena', 'eyepassword')">
                    <i id="eyepassword" class="fa-solid fa-eye changePassword"></i>
                </button>
            </div>
            <input type="password" id="nueva_contrasena" name="nueva_contrasena" class="form-control">
        </div>
        <div class="md-3">
            <label for="repetir_contrasena" class="form-label">Repetir contraseña</label>
            <div class="box-eye">
                <button type="button" onclick="mostrarcontraseña('repetir_contrasena', 'eyepassword')">
                    <i id="eyepassword" class="fa-solid fa-eye changePassword"></i>
                </button>
            </div>
            <input type="password" id="repetir_contrasena" name="repetir_contrasena" class="form-control">
        </div><br>
        <!-- Mostrar mensaje de éxito si es necesario -->
        <?php if (!empty($mensajeExito)): ?>
            <div class="alert alert-success">
                <?php echo $mensajeExito; ?>
            </div>
            <script>
                setTimeout(function () {
                    let mensajesExito = document.querySelectorAll('.alert-success');
                    mensajesExito.forEach(function (mensaje) {
                        mensaje.style.display = 'none';
                    });
                    // Después de ocultar el mensaje de éxito, redirigir al login
                    window.location.href = "/webexample/public/login.php";
                }, 3000);
            </script>
        <?php endif; ?>
        <div class="row p-3">
            <div class="d-grid">
                <button type="submit" class="btn btn-dark">Actualizar contraseña</button>
            </div>
        </div>
    </form>
</div>

<?php include_once '../views/footer.php'; ?>