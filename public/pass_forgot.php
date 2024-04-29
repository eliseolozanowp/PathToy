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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];

    // Verificar si el campo de correo está vacío
    if (empty($correo)) {
        $mensajeError = "Debes ingresar un correo para continuar.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        // Verificar si el correo tiene un formato válido
        $mensajeError = "El correo ingresado no es válido.";
    } elseif (!endsWith($correo, '@gmail.com')) {
        // Verificar si el correo no tiene el dominio @gmail.com
        $mensajeError = "El correo debe ser de dominio @gmail.com.";
    } else {
        // Realiza la consulta para verificar si el correo existe en la base de datos
        $query = "SELECT * FROM usuarios WHERE correo = '$correo'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            // El correo existe en la base de datos, redirige a nueva_contrasena.php con el correo como parámetro
            header("Location: nueva_contrasena.php?correo=" . urlencode($correo));
            exit();
        } else {
            // El correo no existe, muestra un mensaje de error
            $mensajeError = "El correo no está registrado.";
        }
    }
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}
?>

<div class="fondo-login">
    <div class="icon">
        <a href="/webexample/public/login.php">
            <i class="fa-solid fa-arrow-left back-icon"> Volver</i>
        </a>
    </div>
    <div class="titulo">
        Validación de correo
    </div>

    <!--formulario de login-->
    <form action="" method="POST" class="col-8 col-md-3  login">
        <div class="md-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" id="correo" name="correo" class="form-control">
        </div><br>
        <?php if (!empty($mensajeError)): ?>
            <div class="alert alert-danger">
                <?php echo $mensajeError; ?>
            </div>
            <script>
                setTimeout(function () {
                    let mensajesError = document.querySelectorAll('.alert-danger');
                    mensajesError.forEach(function (mensaje) {
                        mensaje.style.display = 'none';
                    });
                }, 3000);
            </script>
        <?php endif; ?>
        <div class="row p-3">
            <div class="d-grid">
                <button type="submit" class="btn btn-dark">Validar correo</button>
            </div>
        </div>
    </form>
    <div class="col-8 col-md-3 mt-3 login">
        ¿No tienes una cuenta? <a href="register.php">Registrate</a>
    </div>
</div>

<?php include_once '../views/footer.php'; ?>